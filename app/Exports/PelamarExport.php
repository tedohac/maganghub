<?php

namespace App\Exports;

use App\Perusahaan;
use App\Rekrut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PelamarExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct($request)
    {
        $this->request = $request;
    } 

    public function headings(): array
    {
        return [
            "Tgl Melamar", 
            "Lowongan", 
            "Kampus", 
            "Prodi", 
            "Mahasiswa", 
            "Status"
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filter = new \stdClass();
        
        if(!empty($this->request->filter_lowongan)) $filter->lowongan = $this->request->filter_lowongan;
        else $filter->lowongan = "";
        
        if(!empty($this->request->filter_status)) $filter->status = $this->request->filter_status;
        else $filter->status = "";
        
        $perusahaan = Perusahaan::where('perusahaan_user_email', $this->request->auth_user_email )->first();

        $rekruts = Rekrut::join('mahasiswas', 'mahasiswas.mahasiswa_id', '=', 'rekruts.rekrut_mahasiswa_id')
                        ->join('lowongans', 'lowongans.lowongan_id', '=', 'rekruts.rekrut_lowongan_id')
                        ->join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->join('univs', 'univs.univ_id', '=', 'prodis.prodi_univ_id')
                        ->where('lowongan_perusahaan_id', "=", $perusahaan->perusahaan_id);
                        
        if(!empty($this->request->filter_lowongan)) {
            $rekruts = $rekruts->where('rekrut_lowongan_id', "=", $this->request->filter_lowongan);
            $lowongan = Lowongan::where('lowongan_id', $this->request->filter_lowongan)->first();
            $filter->lowongan_judul = $lowongan->lowongan_judul;
        }     

        if(!empty($this->request->filter_status)) {
            $rekruts = $rekruts->where('rekrut_status', "=", $this->request->filter_status);
        }
        
        $rekruts = $rekruts->get();

        $output = [];
        
        foreach ($rekruts as $rekrut)
        {
            
            if($rekrut->rekrut_status=='magang') $rekrut->rekrut_status='Sudah Magang';
            elseif($rekrut->rekrut_status=="melamartlk") $rekrut->rekrut_status='Ditolak';
            elseif($rekrut->rekrut_status=="tlkundang") $rekrut->rekrut_status='Undangan ditolak';
            elseif($rekrut->rekrut_status=="cnfrmtest") $rekrut->rekrut_status='Undangan dikonfirmasi';
            elseif($rekrut->rekrut_status=="tdklulus") $rekrut->rekrut_status='Tidak Lulus';
            elseif($rekrut->rekrut_status=="finishmhs") $rekrut->rekrut_status='Menunggu Rating';
            elseif($rekrut->rekrut_status=="finishprs") $rekrut->rekrut_status='Selesai';
            
            $output[] = [
                date('Y-m-d', strtotime($rekrut->rekrut_waktu_melamar)),
                $rekrut->lowongan_judul,
                $rekrut->univ_nama,
                $rekrut->prodi_nama,
                $rekrut->mahasiswa_nama,
                $rekrut->rekrut_status,
            ];
        }
        return collect($output);
    }
}
