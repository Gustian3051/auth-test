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
            Schema::create('peminjaman', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id'); // ID pengguna
                $table->string('user_type'); // Polymorphic relationship
                $table->unsignedBigInteger('matkul_id');
                $table->unsignedBigInteger('dosen_id');
                $table->unsignedBigInteger('ruang_laboratorium_id');
                $table->dateTime('tanggal_waktu_peminjaman');
                $table->time('waktu_pengembalian')->nullable();
                $table->enum('persetujuan', ['Belum Diserahkan', 'Diserahkan'])->default('Belum Diserahkan');
                $table->unsignedBigInteger('dokumen_spo_id')->nullable();
                $table->string('anggota_kelompok')->nullable();
                $table->timestamps();

                $table->foreign('matkul_id')->references('id')->on('matkuls')->onDelete('cascade');
                $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
                $table->foreign('ruang_laboratorium_id')->references('id')->on('ruang_laboratorium')->onDelete('cascade');
                $table->foreign('dokumen_spo_id')->references('id')->on('dokumen_s_p_o_s')->onDelete('cascade');
                $table->index(['user_id', 'user_type']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
