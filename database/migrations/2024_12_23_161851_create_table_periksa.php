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
        Schema::create('table_periksa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_daftar_poli');
            $table->date('tgl_periksa');
            $table->text('catatatn');
            $table->unsignedInteger('biaya_periksa')->default(0);
            $table->timestamps();

            $table->foreign('id_daftar_poli')->references('id')->on('daftar_poli')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_periksa');
    }
};
