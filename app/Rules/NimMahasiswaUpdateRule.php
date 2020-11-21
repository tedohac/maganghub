<?php

namespace App\Rules;
use App\Mahasiswa;

use Illuminate\Contracts\Validation\Rule;

class NimMahasiswaUpdateRule implements Rule
{
    public $univ_id, $mahasiswa_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($univ_id, $mahasiswa_id)
    {
        $this->univ_id = $univ_id;
        $this->mahasiswa_id = $mahasiswa_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $mahasiswa = Mahasiswa::join('dospems', 'dospems.dospem_id', '=', 'mahasiswas.mahasiswa_dospem_id')
                        ->join('prodis', 'prodis.prodi_id', '=', 'dospems.dospem_prodi_id')
                        ->where('prodis.prodi_univ_id', $this->univ_id)
                        ->where('mahasiswas.mahasiswa_nim', $value)
                        ->where('mahasiswas.mahasiswa_id', '!=', $this->mahasiswa_id)
                        ->get();
        
        return $mahasiswa->count()===0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'NIM sudah terdaftar pada kampus anda.';
    }
}
