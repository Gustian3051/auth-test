<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Imports\AlatBahanImport;
use App\Models\AlatBahan;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Stok;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AlatDanBahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataKategori = Kategori::all();
        $dataSatuan = Satuan::all();

        $query = AlatBahan::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('kategori', 'LIKE', "%{$search}%")
                ->orWhere('stok', 'LIKE', "%{$search}%")
                ->orWhere('satuan', 'LIKE', "%{$search}%");
        }

        $dataAlatBahan = $query->paginate(5)->appends($request->all());

        return view('pages.admin-staff.staff.alat-bahan.index', [
            'dataAlatBahan' => $dataAlatBahan,
            'dataKategori' => $dataKategori,
            'dataSatuan' => $dataSatuan
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
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required|exists:kategoris,id',
            'stok' => 'required|min:0',
            'satuan' => 'required|exists:satuans,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama harus diisi',
            'kategori.required' => 'Kategori harus diisi',
            'stok.required' => 'Stok harus diisi',
            'satuan.required' => 'Satuan harus diisi',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads/alat_bahans', 'public');
        }

        // Simpan data alat bahan
        $alatBahan = new AlatBahan();
        $alatBahan->nama = $request->nama;
        $alatBahan->kategori_id = $request->kategori;
        $alatBahan->satuans_id = $request->satuan;
        $alatBahan->foto = $fotoPath;
        $alatBahan->save();

        // Simpan data stok
        $stok = new Stok();
        $stok->alat_bahan_id = $alatBahan->id;
        $stok->stok = $request->stok;
        $stok->save();

        return redirect()->back()->with('success', 'Data Alat dan Bahan berhasil ditambahkan.');
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
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'stok' => 'required',
            'satuan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $foto->storeAs('public/foto', $foto->hashName());
        }

        $alatBahan = AlatBahan::find($id);
        $alatBahan->nama = $request->nama;
        $alatBahan->kategori = $request->kategori;
        $alatBahan->stok = $request->stok;
        $alatBahan->satuan = $request->satuan;
        $alatBahan->foto = $request->hasFile('foto') ? $foto->hashName() : $alatBahan->foto;
        $alatBahan->save();

        return redirect()->back()->with('success', 'Data Alat dan Bahan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alatBahan = AlatBahan::find($id);
        $alatBahan->delete();
        return redirect()->back()->with('success', 'Data Alat dan Bahan berhasil dihapus.');
    }

    public function importAlatBahan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ], [
            'file.required' => 'File harus diisi',
            'file.mimes' => 'Format file harus .xls atau .xlsx',
        ]);

        Excel::import(new AlatBahanImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Alat dan Bahan berhasil di import!');
    }
}
