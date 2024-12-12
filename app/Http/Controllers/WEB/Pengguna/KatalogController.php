<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataKategori = Kategori::all(); // Mengambil semua kategori

        $kategoriId = $request->kategori;

        // Query barang sesuai filter
        $query = AlatBahan::with('kategori');

        if ($kategoriId && $kategoriId !== 'semua') {
            $query->where('kategori_id', $kategoriId);
        }

        // Lakukan pagination di query
        $dataBarang = $query->paginate(5)->appends($request->all());

        // Tentukan jika barang kosong
        $barangKosong = $dataBarang->isEmpty();

        return view('pages.pengguna.katalog.index', [
            'dataBarang' => $dataBarang,
            'dataKategori' => $dataKategori,
            'barangKosong' => $barangKosong,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data barang berdasarkan ID
        $data = AlatBahan::with(['kategori', 'stok', 'satuan'])->findOrFail($id);

        // Pastikan data ditemukan, jika tidak akan otomatis return 404 oleh `findOrFail`
        return view('pages.pengguna.detail.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
