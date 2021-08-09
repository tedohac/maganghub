<?php

namespace App\Exports;

use App\Lowongan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LowonganExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            "Perusahaan", 
            "Lowongan", 
            "Fungsi", 
            "Penempatan", 
            "Mulai Magang", 
            "Durasi Magang", 
            "Jumlah Dibutuhkan"
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $lowongans = Lowongan::join('perusahaans', 'perusahaans.perusahaan_id', '=', 'lowongans.lowongan_perusahaan_id')
                            ->join('cities', 'cities.city_id', '=', 'lowongans.lowongan_city_id')
                            ->join('fungsis', 'fungsis.fungsi_id', '=', 'lowongans.lowongan_fungsi_id')
                            ->where('lowongan_status', 'post')
                            ->where('lowongan_jlh_dibutuhkan', '>', 0)->get();

        $output = [];

        foreach ($lowongans as $lowongan)
        {            
            $output[] = [
                $lowongan->perusahaan_nama,
                $lowongan->lowongan_judul,
                $lowongan->fungsi_nama,
                $lowongan->city_nama,
                $lowongan->lowongan_tgl_mulai,
                $lowongan->lowongan_durasi,
                $lowongan->lowongan_jlh_dibutuhkan,
            ];
        }
        return collect($output);
    }
}
