<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Kategori;
use App\Models\Keranjang;
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

        return view('pages.pengguna.katalog.index', [
            'dataBarang' => $dataBarang,
            'dataKategori' => $dataKategori,
            'barangKosong' => $barangKosong,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
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
        $request->validate(
            [
                'alat_bahan_id' => 'required|exists:alat_bahans,id',
                'jumlah' => 'required|int|min:1',
                'tindakan_SPO' => 'nullable|string',
            ]
        );

        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        $dataKeranjang = Keranjang::where('user_id', $userID)
            ->where('alat_bahan_id', $request->alat_bahan_id)
            ->first();

        if ($dataKeranjang) {
            $dataKeranjang->update([
                'jumlah' => $dataKeranjang->jumlah + $request->jumlah,
                'tindakan_SPO' => $request->tindakan_SPO,
            ]);
        } else {
            Keranjang::create([
                'user_id' => $userID,
                'user_type' => $userType,
                'alat_bahan_id' => $request->alat_bahan_id,
                'jumlah' => $request->jumlah,
                'tindakan_SPO' => $request->tindakan_SPO,
            ]);
        }
        return redirect()->route('katalog.index')->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data barang berdasarkan ID
        $userID = auth()->id();

        $data = AlatBahan::with(['kategori', 'stok', 'satuan'])->findOrFail($id);

        $dataKeranjang = Keranjang::with('alatBahan')->where('user_id', $userID)->get();


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

        return view('pages.pengguna.detail.index', [
            'data' => $data,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
        ]);
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
