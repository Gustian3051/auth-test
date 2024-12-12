<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login.index');
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
        $credentials = $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        // Login Admin/Staff
        if (Auth::guard('admin-staff')->attempt(['username' => $credentials['identifier'], 'password' => $request->password])) {
            $user = Auth::guard('admin-staff')->user();

            if ($user->hasRole('Admin')) {
                return redirect()->route('dashboard.index')->with('success', 'Login berhasil sebagai Admin');
            }

            if ($user->hasRole('Staff')) {
                return redirect()->route('dashboard.index')->with('success', 'Login berhasil sebagai Staff');
            }
        }

        // Login Dosen
        if (Auth::guard('dosen')->attempt(['username' => $credentials['identifier'], 'password' => $request->password])) {
            return redirect()->route('beranda.index')->with('success', 'Login berhasil sebagai Dosen');
        }

        // Login Mahasiswa
        if (Auth::guard('mahasiswa')->attempt(['nim' => $credentials['identifier'], 'password' => $request->password])) {
            return redirect()->route('beranda.index');
        }

        // Jika semua gagal
        return back()->withErrors(['error' => 'Username atau password salah'])->withInput();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
