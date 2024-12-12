<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query awal
        $query = Mahasiswa::query();

        // Cek apakah ada parameter 'search'
        if ($request->filled('search')) {
            $search = $request->search;

            // Gabungkan semua kondisi pencarian dengan 'or'
            $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('nim', 'LIKE', "%{$search}%")
                ->orWhere('kelas', 'LIKE', "%{$search}%");
        }

        // Paginate hasil pencarian
        $dataMahasiswa = $query->paginate(5)->appends($request->all());

        // Kirim data ke view
        return view('pages.admin-staff.admin.mahasiswa.index', [
            'dataMahasiswa' => $dataMahasiswa,
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
        $validateData = $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
        ], [
            'nim.required' => 'NIM harus diisi',
            'nama.required' => 'Nama harus diisi',
            'kelas.required' => 'Kelas harus diisi',
        ]);

        $validateData['password'] = Hash::make('@Poli' . $validateData['nim']);

        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->kelas = $request->kelas;
        $mahasiswa->password = $validateData['password'];
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Data Mahasiswa berhasil ditambahkan');
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
        // Validasi input
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'password' => 'nullable|min:5',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->kelas = $request->kelas;

        if ($request->filled('password')) {
            $mahasiswa->password = Hash::make($request->password);
        }

        $mahasiswa->save();

        return redirect()->back()->with('success', 'Data Mahasiswa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $mahasiswa->delete();
        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus');
    }

    public function importMahasiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ], [
            'file.required' => 'File harus diisi',
            'file.mimes' => 'Format file harus .xls atau .xlsx',
        ]);

        Excel::import(new MahasiswaImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Mahasiswa berhasil di import!');
    }
}
