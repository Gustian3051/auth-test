<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InformasiController extends Controller
{
    public function peminjamanIndex()
    {
        // Ambil user yang sedang login
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

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

        // Ambil data peminjaman terkait user yang login
        $peminjaman = Peminjaman::where('persetujuan', 'Belum Diserahkan')->with([
            'matkul',
            'ruangLaboratorium',
            'dosen',
            'peminjamanDetail.alatBahan',
            'user',
            'dokumenSpo'
        ])
            ->where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirim data ke view
        return view('pages.pengguna.informasi.peminjaman', [
            'peminjaman' => $peminjaman,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'userType' => $userType,
            'userID' => $userID
        ]);
    }

    public function pengembalianIndex()
    {
        // Ambil user yang sedang login
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

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

        // Ambil data peminjaman terkait user yang login
        $pengembalian = Peminjaman::where('persetujuan', 'Diserahkan')
            ->where('user_id', $userID)
            ->with('peminjamanDetail.alatBahan.stok')
            ->get();

        foreach ($pengembalian as $data) {
            $data->barangDiterima = $data->peminjamanDetail->filter(function ($detail) {
                return $detail->status == 'Diterima';
            });
        }

        // Kirim data ke view
        return view('pages.pengguna.informasi.pengembalian', [
            'pengembalian' => $pengembalian,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'userType' => $userType,
            'userID' => $userID
        ]);
    }

    public function prosesPengembalian(Request $request, Peminjaman $peminjaman_id)
    {
        $request->validate([
            'kondisi' => 'required|array', // Kondisi harus berupa array
            'kondisi.*' => 'required|in:Hilang,Rusak,Habis,Dikembalikan', // Validasi setiap kondisi
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:0', // Validasi jumlah minimal 1
            'catatan' => 'nullable|string',
            'jumlah_hilang' => 'nullable|array',
            'jumlah_hilang.*' => 'nullable|numeric|min:0',
            'jumlah_rusak' => 'nullable|array',
            'jumlah_rusak.*' => 'nullable|numeric|min:0',
            'jumlah_habis' => 'nullable|array',
            'jumlah_habis.*' => 'nullable|numeric|min:0',
            'catatan_hilang' => 'nullable|array',
            'catatan_hilang.*' => 'nullable|string',


        ]);

        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::with('peminjamanDetail')->findOrFail($peminjaman_id);

            $pengembalian = Pengembalian::CreateOrUpdate(
                [
                    'peminjaman_id' => $peminjaman_id,
                    'catatan' => $request->catatan,
                    'persetujuan' => 'Menunggu Verifikasi',
                ]
            );

            foreach ($peminjaman->peminjamanDetail as $detail) {
                $kondisi = $request->kondisi[$detail->id] ?? null;
                $jumlah = $request->jumlah[$detail->id] ?? 0;
            }
            DB::commit();

            return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diajukan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengajukan pengembalian: ' . $e->getMessage());
        }
    }
}
