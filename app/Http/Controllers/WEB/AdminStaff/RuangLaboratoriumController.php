<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Imports\RuangLaboratoriumImport;
use App\Models\RuangLaboratorium;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RuangLaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RuangLaboratorium::query();

        if($request->filled('search')) {
            $search = $request->search;

            $query->where('nama', 'LIKE', "%{$search}%");
        }

        $dataRuangLaboratorium = $query->paginate(5)->appends($request->all());

        return view('pages.admin-staff.staff.ruang-laboratorium.index', [
            'dataRuangLaboratorium' => $dataRuangLaboratorium,
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
        ], [
            'nama.required' => 'Ruang laboratorium harus diisi',
        ]);

        $ruangLaboratorium = new RuangLaboratorium();
        $ruangLaboratorium->nama = $request->nama;
        $ruangLaboratorium->save();

        return redirect()->back()->with('success', 'Data ruang laboratorium berhasil disimpan');
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
        ]);

        $ruangLaboratorium = RuangLaboratorium::findOrFail($id);
        $ruangLaboratorium->nama = $request->nama;
        $ruangLaboratorium->save();

        return redirect()->back()->with('success', 'Data ruang laboratorium berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ruangLaboratorium = RuangLaboratorium::findOrFail($id);
        $ruangLaboratorium->delete();
        return redirect()->back()->with('success', 'Data ruang laboratorium berhasil dihapus');
    }

    public function importRuangLaboratorium(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ], [
            'file.required' => 'File harus diisi',
            'file.mimes' => 'Format file harus .xls atau .xlsx',
        ]);

        Excel::import(new RuangLaboratoriumImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Ruang laboratorium berhasil di import!');
    }
}
