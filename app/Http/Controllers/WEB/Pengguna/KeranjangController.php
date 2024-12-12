<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $alatBahanId)
    {
        $dataUser = Auth::user();

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tindakan_SPO' => 'required'
        ]);

        $dataAlatBahan = AlatBahan::findOrFail($alatBahanId);

        Keranjang::create([
            'user_id' => $dataUser->id,
            'user_type' => get_class($dataUser),
            'alat_bahan_id' => $alatBahanId,
            'jumlah' => $request->jumlah,
            'tindakan_SPO' => $request->tindakan_SPO
        ]);

        return redirect()->back()->with('success', 'Data Keranjang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $dataUser = Auth::user();
        $dataKeranjang = Keranjang::where('user_id', $dataUser->id)
                                    ->where('user_yype', get_class($dataUser))
                                    ->with('alat_bahan_id')
                                    ->get();

        return view('pengguna.keranjang.index', compact('dataKeranjang'));
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
