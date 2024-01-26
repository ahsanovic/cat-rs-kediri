<?php

namespace App\Imports;

use App\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use Hash;

class PesertaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Peserta([
            'nama' => $row['nama'],
            'nik' => $row['nik'],
            'nip' => $row['nip'],
            'password' => Hash::make($row['password']),
            'blokir' => $row['blokir'],
            'sesi' => $row['sesi'],
            'last_login' => $row['last_login'],
            'ip_address' => $row['ip_address'],
        ]);
    }
}
