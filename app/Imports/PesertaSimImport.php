<?php

namespace App\Imports;

use App\PesertaSim;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class PesertaSimImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new PesertaSim([
            'nama' => $row['nama'],
            'username' => $row['username'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);
    }
}
