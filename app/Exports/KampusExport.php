<?php

namespace App\Exports;

use App\Prodi;
use App\Rekrut;
use App\Univ;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KampusExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            "Kampus", 
            "Akreditasi", 
            "Score Ulasan Magang", 
            "Jumlah Prodi", 
            "Website",
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $univs = Univ::join('users', 'univs.univ_user_email', '=', 'users.user_email')
                    ->join('cities', 'cities.city_id', '=', 'univs.univ_city_id')
                    ->whereNotNull('user_email_verified_at')
                    ->whereNotNull('univ_verified')->get();
                    
        $output = [];

        foreach ($univs as $univ)
        {
            $rating = Rekrut::getRatingKampus($univ->univ_id);
            $rating = empty($rating) ? 0 : $rating->rating*10;

            $output[] = [
                $univ->univ_nama,
                $univ->univ_akreditasi,
                round($rating),
                Prodi::getCountByUniv($univ->univ_id),
                $univ->univ_website,
            ];
        }
        return collect($output);
    }
}
