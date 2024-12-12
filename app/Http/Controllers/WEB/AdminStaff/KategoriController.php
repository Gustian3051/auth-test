<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kategori::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('kategori', 'LIKE', "%{$search}%");
        }

        $dataKategori = $query->paginate(5)->appends($request->all());

        return view('pages.admin-staff.staff.kategori.index', [
            'dataKategori' => $dataKategori,
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
            'kategori' => 'required',
        ], [
            'kategori.required' => 'Kategori harus diisi',
        ]);

        $kategori = new Kategori();
        $kategori->kategori = $request->kategori;
        $kategori->save();

        return redirect()->back()->with('success', 'Data Kategori berhasil ditambahkan');
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
            'kategori' => 'required',
        ]);

        $kategori = Kategori::find($id);
        $kategori->kategori = $request->kategori;
        $kategori->save();

        return redirect()->back()->with('success', 'Data Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Data Kategori berhasil dihapus');
    }
}
