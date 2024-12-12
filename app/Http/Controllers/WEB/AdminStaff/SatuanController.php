<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Satuan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('satuan', 'LIKE', "%{$search}%");
        }

        $dataSatuan = $query->paginate(5)->appends($request->all());

        return view('pages.admin-staff.staff.satuan.index', [
            'dataSatuan' => $dataSatuan,
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
            'satuan' => 'required',
        ], [
            'satuan.required' => 'Satuan harus diisi',
        ]);

        $satuan = new Satuan();
        $satuan->satuan = $request->satuan;
        $satuan->save();

        return redirect()->back()->with('success', 'Data Satuan berhasil ditambahkan');
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
            'satuan' => 'required',
        ]);

        $satuan = Satuan::find($id);
        $satuan->satuan = $request->satuan;
        $satuan->save();

        return redirect()->back()->with('success', 'Data Satuan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();
        return redirect()->back()->with('success', 'Data Satuan berhasil dihapus');
    }
}
