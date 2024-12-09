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
        Schema::dropIfExists('tb_pemasukan');
        Schema::dropIfExists('tb_pengeluaran');
        Schema::dropIfExists('tb_kewajiban');

        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
