<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Kategori;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        // Data kategori
        $dataKategori = Kategori::all();

        // Filter berdasarkan kategori
        $kategoriId = $request->kategori;

        if ($kategoriId && $kategoriId !== 'semua') {
            $dataBarang = AlatBahan::where('kategori_id', $kategoriId)->with('kategori')->get();
        } else {
            $dataBarang = AlatBahan::with('kategori')->get();
        }

        // Check jika data barang kosong
        $barangKosong = $dataBarang->isEmpty();

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

        return view('pages.pengguna.beranda.index', [
            'dataBarang' => $dataBarang,
            'dataKategori' => $dataKategori,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'dataKeranjang' => $dataKeranjang
        ]);
    }
}
