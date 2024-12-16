<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
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
        $peminjaman = Peminjaman::whereIn('persetujuan', ['Belum Diserahkan', 'Diserahkan'])->with([
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
            'status' => 'required|array', // Validasi status harus berupa array
            'status.*' => 'required|in:Diproses,Diterima,Ditolak', // Setiap item di array status harus valid
            'alasan_penolakan' => 'nullable|array', // Alasan penolakan berupa array (opsional)
            'alasan_penolakan.*' => 'required_if:status.*,Ditolak', // Alasan wajib jika status Ditolak
        ]);

        // Cari peminjaman berdasarkan ID
        $peminjaman = Peminjaman::findOrFail($id);

        // Loop untuk update setiap detail
        foreach ($peminjaman->peminjamanDetail as $detail) {
            $status = $request->status[$detail->id] ?? 'Diproses';
            $alasan = $request->alasan_penolakan[$detail->id] ?? null;

            $detail->update([
                'status' => $status,
                'alasan_penolakan' => $status == 'Ditolak' ? $alasan : null,
            ]);
        }

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }


    public function updatePersetujuan(Request $request, $id)
    {

        $request->validate([
            'persetujuan' => 'required|in:Belum Diserahkan,Diserahkan',
        ]);



        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with([
                'peminjamanDetail.alatBahan.stok',
                'matkul',
                'dosen',
                'ruangLaboratorium',
                'peminjamanDetail',
                'dokumenSpo',
                'user'
            ])->findOrFail($id);

            $peminjaman->update([
                'persetujuan' => $request->persetujuan,
            ]);

            if ($request->persetujuan == 'Diserahkan') {
                $pengembalian = Pengembalian::where('peminjaman_id', $peminjaman->id)->first(); // Ambil pengembalian berdasarkan peminjaman_id
                if (!$pengembalian) {
                    $pengembalian = Pengembalian::updateOrCreate(
                        ['peminjaman_id' => $peminjaman->id], // Kondisi pencarian
                        ['persetujuan' => 'Belum Dikembalikan'] // Data yang akan dibuat jika tidak ada
                    );
                }
            }


            if ($request->persetujuan == 'Diserahkan') {
                foreach ($peminjaman->peminjamanDetail as $detail) {
                    if ($detail->status == 'Diterima') {
                        $alatBahan = $detail->alatBahan;
                        $stok = $alatBahan->stok;

                        if ($stok && $stok->stok >= $detail->jumlah) {
                            $stok->stok -= $detail->jumlah;
                            $stok->save();
                        } else {
                            if ($stok->stok < $detail->jumlah) {
                                DB::rollBack();
                                return redirect()->back()->with('error', 'Stok alat bahan tidak cukup.');
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Persetujuan peminjaman berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan : ' . $e->getMessage());
        }
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
