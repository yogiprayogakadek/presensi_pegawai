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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id', 50);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->char('nip', 18);
            $table->string('nama', 50);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('status_perkawinan', ['Belum kawin', 'Kawin', 'Cerai hidup', 'Cerai mati']);
            $table->enum('pendidikan_terakhir', ['SD', 'SMP', 'SMA atau sederajat', 'Diploma 1', 'Diploma 2', 'Diploma 3', 'Diploma 4', 'Sarjana (S1)', 'Magister (S2)', 'Doktor (S3)']);
            $table->string('alamat', 100);
            $table->char('telp', 16);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
