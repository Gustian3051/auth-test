<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\VerifikasiPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = Peminjaman::where('persetujuan', 'Belum Diserahkan')->with([
            'user',
            'peminjamanDetail.alatBahan',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin-staff.staff.verifikasi-peminjaman.index', [
            'peminjaman' => $peminjaman,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Diterima,Ditolak',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = $request->status;
        $peminjaman->save();

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function updatePersetujuan(Request $request, $id)
    {
        $request->validate([
            'persetujuan' => 'required|in:Belum Diserahkan,Diserahkan',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with(['peminjamanDetail.alatBahan.stok', 'matkul', 'dosen', 'ruangLaboratorium', 'dokumenSpo', 'user'])->findOrFail($id);

            $peminjaman->update([
                'persetujuan' => $request->persetujuan,
            ]);

            if ($request->persetujuan == 'Diserahkan') {
                foreach ($peminjaman->peminjamanDetail as $detail) {
                    $alatBahan = $detail->alatBahan;

                    // Mengambi data stok alat bahan
                    $stok = $alatBahan->stok;


                    // Kurangi stok alat bahan
                    if ($stok && $stok->stok >= $detail->jumlah) {
                        $stok->stok -= $detail->jumlah;
                        $stok->save();
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('error', "Stok {{ $alatBahan->nama }} tidak mencukupi.");
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Persetujuan peminjaman berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan : ' . $e->getMessage());
        }


        return redirect()->back()->with('success', 'Persetujuan peminjaman berhasil diperbarui.');
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
