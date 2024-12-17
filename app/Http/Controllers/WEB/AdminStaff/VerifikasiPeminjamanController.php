<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
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
            'ruangLaboratorium.peminjaman',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin-staff.staff.verifikasi-peminjaman.index', [
            'peminjaman' => $peminjaman,
        ]);
    }


    public function updateStatusBarang(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'status' => 'required|array',
            'status.*' => 'in:Diproses,Diterima,Ditolak',
            'alasan_penolakan' => 'nullable|array'
        ]);

        DB::beginTransaction();
        try {
            $statuses = $request->input('status', []);
            $alasanPenolakan = $request->input('alasan_penolakan', []);

            foreach ($peminjaman->peminjamanDetail as $detail) {
                if (isset($statuses[$detail->id])) {
                    $detail->status = $statuses[$detail->id];

                    if ($detail->status == 'Ditolak') {
                        $detail->jumlah = 0;
                        $detail->alasan_penolakan = $alasanPenolakan[$detail->id] ?? 'Tidak ada alasan spesifik';
                    } else {
                        $detail->alasan_penolakan = null;
                    }

                    $detail->save();
                }
            }

            DB::commit();

            return back()->with('success', 'Status barang berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
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
                        ['peminjaman_id' => $peminjaman->id],
                        [
                            'user_id' => $peminjaman->user_id,
                            'user_type' => $peminjaman->user_type,
                            'persetujuan' => 'Menunggu Verifikasi',
                            'tindakan_spo_pengguna' => $peminjaman->tindakan_spo_pengguna
                        ]
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

}
