<?php

namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths
};

class ReservasiExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths
{
    protected $reservasi;

    public function __construct($reservasi)
    {
        $this->reservasi = $reservasi;
    }

    /**
     * DATA
     */
    public function collection()
    {
        return $this->reservasi;
    }

    /**
     * HEADER EXCEL
     */
    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'No HP',
            'Fotografer',
            'Paket',
            'Tanggal',
            'Waktu',
            'Status',
        ];
    }

    /**
     * ISI PER BARIS
     */
    public function map($r): array
    {
        return [
            $r->nama,
            $r->email,
            $r->no_hp,
            $r->fotografer?->nama_fotografer ?? '-',
            $r->tipe_paket ?? '-',
            $r->tanggal,
            substr($r->waktu_mulai,0,5).' - '.substr($r->waktu_selesai,0,5),
            ucfirst(str_replace('_',' ', $r->status)),
        ];
    }

    /**
     * LEBAR KOLOM
     */
    public function columnWidths(): array
    {
        return [
            'A' => 22,
            'B' => 28,
            'C' => 18,
            'D' => 22,
            'E' => 18,
            'F' => 16,
            'G' => 18,
            'H' => 16,
        ];
    }
}
