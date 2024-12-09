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
        Schema::create('tb_pemasukan', function (Blueprint $table) {
            $table->id('id_pemasukan');
            $table->unsignedBigInteger('id_laporan');
            $table->string('jumlah_pemasukan', 50);
            $table->timestamps();
        
            $table->foreign('id_laporan')->references('id_laporan')->on('tb_laporan')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
