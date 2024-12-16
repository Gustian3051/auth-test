<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiPengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalian = Pengembalian::with([
            'pengembalianDetail.alatBahan.kategori',
            'pengembalianDetail.alatBahan.satuan',
            'pengembalianDetail.pengembalian',
            'peminjaman.peminjamanDetail',
            'peminjaman.user',
            'peminjaman.matkul',
            'peminjaman.ruangLaboratorium',
            'peminjaman.dosen',
        ])->get();

        return view('pages.admin-staff.staff.verifikasi-pengembalian.index', [
            'pengembalian' => $pengembalian,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verifikasi(Request $request, Pengembalian $pengembalian_id)
    {
        DB::beginTransaction();
        try {
            $pengembalian = Pengembalian::with('pengembalianDetail')->findOrFail($pengembalian_id);
            $pengembalian->update([
                'persetujuan' => 'Diserahkan',
            ]);

            foreach ($pengembalian->pengembalianDetail as $detail) {
                $stok = Stok::where('alat_bahan_id', $detail->alat_bahan_id)->first();

                if ($detail->kondisi === 'Dikembalikan') {
                    $stok->increment('stok', $detail->jumlah);
                } elseif ($detail->kondisi === 'Hilang') {
                    $stok->decrement('stok', $detail->jumlah);
                } elseif ($detail->kondisi === 'Rusak' || $detail->kondisi === 'Habis') {
                    $stok->decrement('stok', $detail->jumlah);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Pengembalian diterima');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        //
    }
}
