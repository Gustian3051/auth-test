<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Imports\MatkulImport;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Cast\String_;

class MatkulController extends Controller
{
    public function index(Request $request)
    {
        $query = Matkul::query();

        if($request->filled('search')) {
            $search = $request->search;

            $query->where('kode_matkul', 'LIKE', "%{$search}%")
            ->orWhere('nama_matkul', 'LIKE', "%{$search}%");
        }

        $dataMatkul = $query->paginate(5)->appends($request->all());

        return view('pages.admin-staff.admin.matkul.index', [
            'dataMatkul' => $dataMatkul,
        ]);
    }

    public function create()
    {

    }

    public function edit()
    {

    }

    public function show()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
        ], [
            'kode_matkul.required' => 'Kode matkul harus diisi',
            'nama_matkul.required' => 'Nama matkul harus diisi',
        ]);

        $matkul = new Matkul();
        $matkul->kode_matkul = $request->kode_matkul;
        $matkul->nama_matkul = $request->nama_matkul;
        $matkul->save();

        return redirect()->back()->with('success', 'Data matkul berhasil disimpan');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
        ]);

        $matkul = Matkul::findOrFail($id);
        $matkul->kode_matkul = $request->kode_matkul;
        $matkul->nama_matkul = $request->nama_matkul;
        $matkul->save();

        return redirect()->back()->with('success', 'Data matkul berhasil diubah');
    }

    public function destroy(String $id)
    {
        $matkul = Matkul::findOrFail($id);
        $matkul->delete();
        return redirect()->back()->with('success', 'Data matkul berhasil dihapus');
    }

    public function importMatkul(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ], [
            'file.required' => 'File harus diisi',
            'file.mimes' => 'Format file harus .xls atau .xlsx',
        ]);

        Excel::import(new MatkulImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Matkul berhasil di import!');
    }
}
