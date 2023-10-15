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
        Schema::create('log_qrcode', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('pegawai_id', 50);
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->json('json_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_qrcode');
    }
};
