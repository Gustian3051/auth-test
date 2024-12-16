<?php

use App\Http\Controllers\WEB\AdminStaff\AdminStaffController;
use App\Http\Controllers\WEB\AdminStaff\AlatDanBahanController;
use App\Http\Controllers\WEB\AdminStaff\DashboardController;
use App\Http\Controllers\WEB\AdminStaff\DokumenSPOController;
use App\Http\Controllers\WEB\AdminStaff\DosenController;
use App\Http\Controllers\WEB\AdminStaff\KategoriController;
use App\Http\Controllers\WEB\AdminStaff\LaporanController;
use App\Http\Controllers\WEB\AdminStaff\MahasiswaController;
use App\Http\Controllers\WEB\AdminStaff\MatkulController;
use App\Http\Controllers\WEB\AdminStaff\RuangLaboratoriumController;
use App\Http\Controllers\WEB\AdminStaff\SatuanController;
use App\Http\Controllers\WEB\AdminStaff\VerifikasiPeminjamanController;
use App\Http\Controllers\WEB\AdminStaff\VerifikasiPengembalianController;
use App\Http\Controllers\WEB\Auth\ForgotController;
use App\Http\Controllers\WEB\Auth\LoginController;
use App\Http\Controllers\WEB\Auth\LogoutController;
use App\Http\Controllers\WEB\Pengguna\BerandaController;
use App\Http\Controllers\WEB\Pengguna\DetailController;
use App\Http\Controllers\WEB\Pengguna\InformasiController;
use App\Http\Controllers\WEB\Pengguna\KatalogController;
use App\Http\Controllers\WEB\Pengguna\KeranjangController;
use App\Http\Controllers\WEB\Pengguna\PeminjamanController;
use App\Models\Matkul;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('pages.admin-staff.dashboard.index');
// });

Route::resource('login', LoginController::class);
Route::resource('forgot-password', ForgotController::class);

Route::middleware('auth:admin-staff')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('laporan', LaporanController::class);

    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

    Route::middleware('role:Admin')->group(function () {
        Route::prefix('pengguna')->group(function () {
            Route::resource('admin-staff', AdminStaffController::class);

            Route::resource('dosen', DosenController::class);
            Route::post('import-dosen', [DosenController::class, 'importDosen'])->name('import-dosen');

            Route::resource('mahasiswa', MahasiswaController::class);
            Route::post('import-mahasiswa', [MahasiswaController::class, 'importMahasiswa'])->name('import-mahasiswa');
        });

        Route::resource('dokumen-spo', DokumenSPOController::class);
        Route::get('download-dokumen-spo/{data_spo}', [DokumenSPOController::class, 'downloadSPO'])->name('download-dokumen-spo');

        Route::resource('mata-kuliah', MatkulController::class);
        Route::post('import-matkul', [MatkulController::class, 'importMatkul'])->name('import-matkul');
    });

    Route::middleware('role:Staff')->group(function () {
        Route::prefix('alat-bahan')->group(function () {
            Route::resource('barang', AlatDanBahanController::class);
            Route::post('import-barang', [AlatDanBahanController::class, 'importAlatBahan'])->name('import-alat-bahan');

            Route::resource('kategori', KategoriController::class);
            Route::resource('satuan', SatuanController::class);
        });

        Route::resource('ruang-laboratorium', RuangLaboratoriumController::class);
        Route::post('import-ruang-laboratorium', [RuangLaboratoriumController::class, 'importRuangLaboratorium'])->name('import-ruang-laboratorium');

        Route::prefix('verifikasi')->group(function () {
            Route::get('peminjaman', [VerifikasiPeminjamanController::class, 'index'])->name('verifikasi-peminjaman.index');

            Route::put('/verifikasi/status/{id}', [VerifikasiPeminjamanController::class, 'updateStatus'])->name('staff.updateStatus');
            Route::put('/verifikasi/persetujuan/{id}', [VerifikasiPeminjamanController::class, 'updatePersetujuan'])->name('staff.updatePersetujuan');


            Route::get('pengembalian', [VerifikasiPengembalianController::class, 'index'])->name('verifikasi-pengembalian.index');
            Route::post('/verifikass-pengembalian/{pengembalian}', [VerifikasiPengembalianController::class, 'verifiaksi'])->name('pengembalian.verifikasi');
        });
    });


});

Route::middleware('MultiAuth:mahasiswa,dosen')->group(function () {
    Route::resource('beranda', BerandaController::class);
    Route::resource('katalog', KatalogController::class);
    Route::resource('detail', DetailController::class);
    Route::resource('keranjang', KeranjangController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::prefix('informasi')->group(function () {
        Route::get('peminjaman', [InformasiController::class, 'peminjamanIndex'])->name('peminjaman.index');

        Route::get('pengembalian', [InformasiController::class, 'pengembalianIndex'])->name('pengembalian.index');
        Route::post('proses-pengembalian/{pengembalian_id}', [InformasiController::class, 'prosesPengembalian'])->name('pengembalian.proses');

    });
});
