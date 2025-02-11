<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use Exception;
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

            // Ambil data peminjaman terkait user yang login
            $pengembalian = Peminjaman::with([
                'peminjamanDetail.alatBahan',
                'ruangLaboratorium',
                'matkul',
                'dosen',
                'user',
            ])->where('persetujuan', 'Diserahkan')->where('user_id', $userID)->orderBy('created_at', 'desc')->get();

            // Kirim data ke view
            return view('pages.pengguna.informasi.pengembalian', [
                'pengembalian' => $pengembalian,
                'dataKeranjang' => $dataKeranjang,
                'notifikasiKeranjang' => $notifikasiKeranjang,
                'userType' => $userType,
                'userID' => $userID
            ]);
        }
    }



    public function prosesPengembalian(Request $request, $peminjamanId)
    {
        $request->validate([
            'jumlah_kembali' => 'required|array',
            'jumlah_kembali.*' => 'required|integer|min:0',
            'kondisi' => 'required|array',
            'kondisi.*' => 'required|in:Dikembalikan,Hilang,Rusak,Habis',
            'tindakan_spo_pengguna' => 'required|string',
        ]);

        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();
        $peminjaman = Peminjaman::with('peminjamanDetail.alatBahan')->findOrFail($peminjamanId);

        if ($peminjaman->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengembalikan peminjaman ini.');
        }

        DB::beginTransaction();
        try {
            $pengembalian = Pengembalian::updateOrcreate(
                [
                    'peminjaman_id' => $peminjamanId,
                    'user_id' => $userID,
                    'user_type' => $userType,
                ],
                [
                    'persetujuan' => 'Menunggu Verifikasi',
                    'tindakan_spo_pengguna' => $request->tindakan_spo_pengguna,
                ]
            );

            foreach ($peminjaman->peminjamanDetail as $detail) {
                $jumlahKembali = $request->input('jumlah_kembali.' . $detail->id, 0);
                $kondisi = $request->input('kondisi.' . $detail->id);

                if ($jumlahKembali > $detail->jumlah) {
                    return redirect()->back()->with('error', 'Jumlah kembali melebihi batas peminjaman.');
                }

                PengembalianDetail::updateOrCreate(
                    [
                        'pengembalian_id' => $pengembalian->id,
                        'alat_bahan_id' => $detail->alat_bahan_id,
                    ],
                    [
                        'jumlah_pinjam' => $detail->jumlah,
                        'jumlah_kembali' => $jumlahKembali,
                        'kondisi' => $kondisi,
                    ]
                );
            }

            $pengembalian->update([
                'persetujuan' => 'Menunggu Verifikasi',
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pengembalian berhasil diserahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
