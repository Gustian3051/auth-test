<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\DokumenSPO;
use App\Models\Dosen;
use App\Models\Keranjang;
use App\Models\Matkul;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\RuangLaboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {


        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        $dosen = Dosen::all();
        $matkul = Matkul::all();
        $ruangLaboratorium = RuangLaboratorium::all();
        $dokumenSpo = DokumenSPO::all();

        $dataKeranjang = Keranjang::with('alatBahan')->where('user_id', $userID)->get();
        if ($dataKeranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }
        $barangKosong = $dataKeranjang->isEmpty();



        return view('pages.pengguna.keranjang.index', [
            'dataKeranjang' => $dataKeranjang,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $dataKeranjang->sum('alat_bahan_id'),
            'dosen' => $dosen,
            'matkul' => $matkul,
            'ruangLaboratorium' => $ruangLaboratorium,
            'dokumenSpo' => $dokumenSpo
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'tanggal_waktu_peminjaman' => 'required|date|after_or_equal:today',
                'waktu_pengembalian' => 'required|date_format:H:i',
                'dokumen_spo_id' => 'required|exists:dokumen_s_p_o_s,id',
                'matkul_id' => 'required|exists:matkuls,id',
                'dosen_id' => 'required|exists:dosens,id',
                'ruang_laboratorium_id' => 'required|exists:ruang_laboratorium,id',
                'anggota_kelompok' => 'nullable|string',
            ],
            [
                'tanggal_waktu_peminjaman.required' => 'Tanggal waktu peminjaman harus diisi',
                'tanggal_waktu_peminjaman.date' => 'Tanggal waktu peminjaman harus berupa tanggal',
                'tanggal_waktu_peminjaman.after_or_equal' => 'Tanggal waktu peminjaman harus setelah hari ini',
                'waktu_peminjaman.required' => 'Waktu peminjaman harus diisi',
                'waktu_peminjaman.date_format' => 'Format waktu peminjaman harus HH:MM',
                'dokumen_spo_id.required' => 'Dokumen SPO harus diisi',
                'matkul_id.required' => 'Matkul harus diisi',
                'matkul_id.exists' => 'Matkul tidak ditemukan',
                'dosen_id.required' => 'Dosen harus diisi',
                'dosen_id.exists' => 'Dosen tidak ditemukan',
                'ruang_laboratorium_id.required' => 'Ruangan harus diisi',
                'ruang_laboratorium_id.exists' => 'Ruangan tidak ditemukan',
                'anggota_kelompok.required' => 'Anggota kelompok harus diisi',
            ]
        );

        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();
        $dataKeranjang = Keranjang::with('alatBahan')->where('user_id', $userID)->get();

        if ($dataKeranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'user_id' => $userID,
                'user_type' => $userType,
                'tanggal_waktu_peminjaman' => now(),
                'waktu_pengembalian' => $request->waktu_pengembalian,
                'matkul_id' => $request->matkul_id,
                'dosen_id' => $request->dosen_id,
                'ruang_laboratorium_id' => $request->ruang_laboratorium_id,
                'anggota_kelompok' => $request->anggota_kelompok,
                'status' => 'Diproses',
                'persetujuan' => 'Belum Diserahkan',
                'dokumen_spo_id' => $request->dokumen_spo_id,
            ]);

            foreach ($dataKeranjang as $keranjang) {
                PeminjamanDetail::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_bahan_id' => $keranjang->alat_bahan_id,
                    'jumlah' => $keranjang->jumlah,
                    'tindakan_SPO' => $keranjang->tindakan_SPO,
                ]);
            }

            Keranjang::where('user_id', $userID)->delete();
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Peminjaman gagal dibuat: ' . $e->getMessage());
        }
    }
}
