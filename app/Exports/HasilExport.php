<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Hasil;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HasilExport extends DefaultValueBinder implements WithCustomValueBinder, FromQuery, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'NIPTT-PK',
            'Sesi',
            'TWK',
            'TIU',
            'TKP',
            'Total',
            'Selesai Tes',
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'B') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function query()
    {
        return Hasil::select(
                        'nama',
                        'nik',
                        'nip',
                        'sesi',
                        'nilaitwk',
                        'nilaitiu',
                        'nilaitkp',
                        'nilai_total',
                        'hasil.created_at'
                    )
                    ->join('peserta', 'peserta.id', '=', 'hasil.peserta_id');
    }
}
