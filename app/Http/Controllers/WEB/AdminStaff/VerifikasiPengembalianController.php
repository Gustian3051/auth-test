<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use App\Models\Stok;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiPengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalian = Pengembalian::with(['pengembalianDetail.alatBahan', 'peminjaman.user'])->where('persetujuan', 'Menunggu Verifikasi')->get();

        return view('pages.admin-staff.staff.verifikasi-pengembalian.index', [
            'pengembalian' => $pengembalian,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verifikasi(Request $request, $pengembalianId)
    {
        $pengembalian = Pengembalian::with('pengembalianDetail')->find($pengembalianId);

        DB::beginTransaction();
        try {
            // Verifikasi persetujuan pengembalian
            $pengembalian->update([
                'persetujuan' => 'Dikembalikan',
            ]);

            foreach ($pengembalian->pengembalianDetail as $detail) {
                // Ambil data yang dikirimkan dari form
                $jumlahKembali = $request->input('details.' . $detail->id . '.jumlah_kembali');
                $kondisi = $request->input('details.' . $detail->id . '.kondisi');

                // Cek stok berdasarkan alat bahan
                $stok = Stok::where('alat_bahan_id', $detail->alat_bahan_id)->first();
                if (!$stok) {
                    throw new Exception('Stok alat bahan tidak ditemukan.');
                }

                // Update stok alat bahan sesuai kondisi
                if ($kondisi == 'Dikembalikan') {
                    $stok->jumlah += $jumlahKembali;  // Menambah stok
                } elseif ($kondisi == 'Habis' || $kondisi == 'Rusak' || $kondisi == 'Hilang') {
                    $stok->jumlah -= $jumlahKembali;  // Mengurangi stok
                }
                $stok->save();

                // Update detail pengembalian
                $catatan = $request->input('details.' . $detail->id . '.catatan', 'Verifikasi Pengembalian Berhasil');
                $detail->update([
                    'catatan' => $catatan,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Verifikasi pengembalian berhasil.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat verifikasi pengembalian: ' . $e->getMessage());
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
