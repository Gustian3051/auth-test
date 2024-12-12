<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\DokumenSPO;
use Illuminate\Http\Request;

class DokumenSpoController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenSpo::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama_dokumen', 'LIKE', "%{$search}%");
        }

        $dataDokumenSPO = $query->paginate(5)->appends($request->all());

        return view('pages.admin-staff.admin.dokumen-spo.index', ['dataDokumenSPO' => $dataDokumenSPO]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $file_path = $request->file('file_dokumen')->storeAs(
            'dokumen-spo',
            time() . '_' . $request->file('file_dokumen')->getClientOriginalName()
        );

        // Pastikan path file berhasil disimpan
        if (!$file_path) {
            return redirect()->back()->with('error', 'Gagal menyimpan file!');
        }

        DokumenSpo::create([
            'nama_dokumen' => $request->nama_dokumen,
            'file_dokumen' => $file_path,
        ]);

        return redirect()->route('dokumen-spo.index')->with('success', 'Dokumen SPO berhasil ditambahkan');
    }

    public function destroy(DokumenSpo $data_spo)
    {
        // Hapus file terkait
        if ($data_spo->file_dokumen && file_exists(storage_path('app/' . $data_spo->file_dokumen))) {
            unlink(storage_path('app/' . $data_spo->file_dokumen));
        }

        // Hapus data
        $data_spo->delete();

        return redirect()->back()->with('success', 'Dokumen SPO berhasil dihapus!');
    }


    public function downloadSPO(DokumenSpo $data_spo)
    {
        $filePath = $data_spo->file_dokumen;

        if (file_exists(storage_path('app/' . $filePath))) {
            return response()->download(storage_path('app/' . $filePath));
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }
}
