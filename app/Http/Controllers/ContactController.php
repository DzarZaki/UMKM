<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Menangani pengiriman data dari form kontak.
     */
    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:15',
            'message' => 'required|string',
        ]);

        // 2. PROSES DATA (Contoh: Mengirim Email)
        // Di sini Anda akan menambahkan logika untuk mengirim email atau menyimpan ke DB.
        // Untuk saat ini, kita hanya akan mencatatnya.
        // Log::info('Pesan Kontak Baru Diterima', $request->all());

        // 3. REDIREKSI DENGAN PESAN SUKSES
        return redirect('/')->with('success', 'Terima kasih, pesan Anda telah terkirim!');
    }
}