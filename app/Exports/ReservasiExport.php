<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReservasiExport implements FromView
{
    protected $reservasi;

    public function __construct($reservasi)
    {
        $this->reservasi = $reservasi;
    }

    public function view(): View
    {
        return view('reservasi.export-excel', [
            'reservasi' => $this->reservasi
        ]);
    }
}
