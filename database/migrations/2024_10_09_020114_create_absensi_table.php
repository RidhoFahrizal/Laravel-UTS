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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->date('tanggal');
            $table->time('waktu_masuk')->default(DB::raw('CURRENT_TIME'))->nullable();
            $table->time('waktu_keluar')->default(DB::raw('CURRENT_TIME'))->nullable();
            $table->enum('status_absensi', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->timestamps();

            // Foreign key
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
