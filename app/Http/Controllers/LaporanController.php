<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengukuran;
use App\Models\Balita;

class LaporanController extends Controller
{
    // Tampilkan form + hasil laporan
    public function index(Request $request)
    {
        $tanggalMulai  = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $pengukuran = collect(); // default kosong

        if ($tanggalMulai && $tanggalSelesai) {
            $pengukuran = Pengukuran::with('balita')
                ->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai])
                ->orderBy('created_at')
                ->get();
        }

        return view('laporan.index', compact('pengukuran', 'tanggalMulai', 'tanggalSelesai'));
    }

    // Cetak PDF
    public function cetak(Request $request)
    {
        $tanggalMulai  = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $pengukuran = Pengukuran::with('balita')
            ->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai])
            ->orderBy('created_at')
            ->get();

        // Contoh jika pakai dompdf
        // $pdf = PDF::loadView('laporan.pdf', compact('pengukuran', 'tanggalMulai', 'tanggalSelesai'));
        // return $pdf->download("laporan-{$tanggalMulai}-sd-{$tanggalSelesai}.pdf");

        // Kalau belum pakai pdf, untuk sementara bisa return view biasa
        return view('laporan.cetak', compact('pengukuran', 'tanggalMulai', 'tanggalSelesai'));
    }
}
