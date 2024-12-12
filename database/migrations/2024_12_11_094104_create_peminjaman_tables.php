<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('alat_bahan')) {
            Schema::create('peminjaman', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('peminjam_id'); // ID pengguna
                $table->string('peminjam_type'); // Tipe pengguna
                $table->foreignId('alat_bahan_id')->constrained()->onDelete('cascade');
                $table->integer('jumlah'); // Jumlah item yang dipinjam
                $table->dateTime('tanggal_waktu_peminjaman');
                $table->time('waktu_pengembalian')->nullable();
                $table->enum('status', ['Diproses', 'Ditolak', 'Diterima'])->default('Diproses');
                $table->string('tindakan_SPO')->nullable();
                $table->timestamps();
            });

        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
