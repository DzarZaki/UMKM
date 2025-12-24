<?php

namespace App\Exports;

use App\Models\Reservasi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReservasiExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Reservasi::query()->latest();

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('tipe_paket')) {
            $query->where('tipe_paket', $this->request->tipe_paket);
        }

        if ($this->request->filled('q')) {
            $q = $this->request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('no_hp', 'like', "%{$q}%");
            });
        }

        return view('reservasi.export-excel', [
            'reservasi' => $query->get(),
        ]);
    }
}
