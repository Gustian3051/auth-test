<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Dosen;
use App\Models\Keranjang;
use App\Models\Matkul;
use App\Models\RuangLaboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        $dosen = Dosen::all();
        $matkul = Matkul::all();
        $ruangLaboratorium = RuangLaboratorium::all();

        $dataKeranjang = Keranjang::with('alatBahan')->where('user_id', $userID)->get();

        $barangKosong = $dataKeranjang->isEmpty();



        return view('pages.pengguna.keranjang.index', [
            'dataKeranjang' => $dataKeranjang,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $dataKeranjang->sum('alat_bahan_id'),
            'dosen' => $dosen,
            'matkul' => $matkul,
            'ruangLaboratorium' => $ruangLaboratorium,
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
            ]);
        } else {
            Keranjang::create([
                'user_id' => $userID,
                'user_type' => $userType,
                'alat_bahan_id' => $request->alat_bahan_id,
                'jumlah' => $request->jumlah,
            ]);
        }
        return redirect()->route('beranda.index')->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
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
        $dataKeranjang = Keranjang::findOrFail($id);

        if ($dataKeranjang->user_id !== auth()->id()) {
            return back()->with('error', 'Keranjang tidak ditemukan');
        }

        $dataKeranjang->delete();
        return back()->with('success', 'Keranjang berhasil dihapus');
    }
}
