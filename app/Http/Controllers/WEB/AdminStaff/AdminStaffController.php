<?php

namespace App\Http\Controllers\WEB\AdminStaff;

use App\Http\Controllers\Controller;
use App\Models\AdminStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = Role::all();

        $query = AdminStaff::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('nidn', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%");
        }

        $dataAdminStaff = $query->paginate(5)->appends($request->all());

        return view('pages.admin-staff.admin.admin-dan-staff.index', [
            'dataAdminStaff' => $dataAdminStaff,
            'role' => $role,
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
        // Validasi input
        $validateData = $request->validate(
            [
                'nama' => 'required',
                'nidn' => 'required',
                'username' => 'required|unique:admin_staff,username',
                'role' => 'required|exists:roles,id',
            ],
            [
                'nama.required' => 'Nama harus diisi',
                'nidn.required' => 'NIDN/NIP harus diisi',
                'username.required' => 'Username harus diisi',
                'username.unique' => 'Username sudah digunakan, silakan pilih username lain', 
                'role.required' => 'Role harus dipilih',
                'role.exists' => 'Role tidak valid',
            ]
        );

        // Hash password default
        $validateData['password'] = Hash::make('password');

        // Simpan data AdminStaff
        $adminStaff = new AdminStaff();
        $adminStaff->nama = $validateData['nama'];
        $adminStaff->nidn = $validateData['nidn'];
        $adminStaff->username = $validateData['username'];
        $adminStaff->password = $validateData['password'];
        $adminStaff->save();

        // Assign role menggunakan Spatie
        $role = Role::findById($validateData['role']);
        $adminStaff->assignRole($role);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data Admin / Staff berhasil ditambahkan.');
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
            'nidn' => 'required',
            'username' => 'required',
            'password' => 'nullable|min:5',
            'role' => 'required|exists:roles,name',
        ]);

        $adminStaff = AdminStaff::findOrFail($id);

        $adminStaff->nama = $request->nama;
        $adminStaff->nidn = $request->nidn;
        $adminStaff->username = $request->username;

        if ($request->filled('password')) {
            $adminStaff->password = Hash::make($request->password);
        }


        // Update role
        if ($adminStaff->hasAnyRole(Role::all())) {
            $adminStaff->syncRoles([$request->role]);
        } else {
            $adminStaff->assignRole($request->role);
        }

        $adminStaff->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adminDanStaff = AdminStaff::findOrFail($id);
        $adminDanStaff->delete();
        return redirect()->back()->with('success', 'Data Admin / Staff berhasil di hapus!');
    }
}
