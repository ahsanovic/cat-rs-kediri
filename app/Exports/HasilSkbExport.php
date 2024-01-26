<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\HasilSkb;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HasilSkbExport extends DefaultValueBinder implements WithCustomValueBinder, FromQuery, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'NIPTT-PK',
            'Sesi',
            'Nilai',
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
        return HasilSkb::select(
                        'nama',
                        'nik',
                        'nip',
                        'sesi',
                        'nilai',
                        'hasil_skb.created_at'
                    )
                    ->join('peserta_skb', 'peserta_skb.id', '=', 'hasil_skb.peserta_skb_id');
    }
}
