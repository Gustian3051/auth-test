<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function peminjamanIndex()
    {
        // Ambil user yang sedang login
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        // Data keranjang untuk pengguna yang sedang login
        $notifikasiKeranjang = [];
        $dataKeranjang = [];

        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('alatBahan')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('alat_bahan_id');
        }

        // Ambil data peminjaman terkait user yang login
        $peminjaman = Peminjaman::where('persetujuan', 'Belum Diserahkan')->with([
            'matkul',
            'ruangLaboratorium',
            'dosen',
            'peminjamanDetail.alatBahan',
            'user',
            'dokumenSpo'
        ])
        ->where('user_id', $userID)
        ->orderBy('created_at', 'desc')
        ->get();

        // Kirim data ke view
        return view('pages.pengguna.informasi.peminjaman', [
            'peminjaman' => $peminjaman,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'userType' => $userType,
            'userID' => $userID
        ]);
    }

    public function pengembalianIndex()
    {
        // Ambil user yang sedang login
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        // Data keranjang untuk pengguna yang sedang login
        $notifikasiKeranjang = [];
        $dataKeranjang = [];

        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('alatBahan')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('alat_bahan_id');
        }

        // Ambil data peminjaman terkait user yang login
        $pengembalian = Peminjaman::where('persetujuan', 'Diserahkan')->with([
            'matkul',
            'ruangLaboratorium',
            'dosen',
            'peminjamanDetail.alatBahan',
            'user',
            'dokumenSpo'
        ])
        ->where('user_id', $userID)
        ->orderBy('created_at', 'desc')
        ->get();

        // Kirim data ke view
        return view('pages.pengguna.informasi.pengembalian', [
            'pengembalian' => $pengembalian,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'userType' => $userType,
            'userID' => $userID
        ]);
    }
}
