<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Imports\DosenImport;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query awal
        $query = Dosen::query();

        // Cek apakah ada parameter 'search'
        if ($request->filled('search')) {
            $search = $request->search;

            // Gabungkan semua kondisi pencarian dengan 'or'
            $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('nidn', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%");
        }

        // Paginate hasil pencarian
        $dataDosen = $query->paginate(5)->appends($request->all());

        // Kirim data ke view
        return view('pages.admin-staff.admin.dosen.index', [
            'dataDosen' => $dataDosen,
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
            'nidn' => 'required',
            'nama' => 'required',
            'username' => 'required',
        ], [
            'nidn.required' => 'NIDN/NIP harus diisi',
            'nama.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
        ]);

        $validateData['password'] = Hash::make('polindra');

        $dosen = new Dosen();
        $dosen->nidn = $request->nidn;
        $dosen->nama = $request->nama;
        $dosen->username = $request->username;
        $dosen->password = $validateData['password'];
        $dosen->save();

        return redirect()->back()->with('success', 'Data Dosen berhasil ditambahkan');
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
            'nidn' => 'required',
            'nama' => 'required',
            'username' => 'required',
            'password' => 'nullable|min:5',
        ]);

        $dosen = Dosen::findOrFail($id);

        $dosen->nidn = $request->nidn;
        $dosen->nama = $request->nama;
        $dosen->username = $request->username;

        if ($request->filled('password')) {
            $dosen->password = Hash::make($request->password);
        }

        $dosen->save();

        return redirect()->back()->with('success', 'Data Dosen berhasil diubah.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosen = Dosen::find($id);
        $dosen->delete();
        return redirect()->back()->with('success', 'Data Dosen berhasil dihapus');
    }

    public function importDosen(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ], [
            'file.required' => 'File harus diisi',
            'file.mimes' => 'Format file harus .xls atau .xlsx',
        ]);

        Excel::import(new DosenImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Dosen berhasil di import!');
    }
}
