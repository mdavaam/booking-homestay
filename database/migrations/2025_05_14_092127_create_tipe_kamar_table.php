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
        Schema::create('tipe_kamar', function (Blueprint $table) {
    $table->id();
    $table->string('jenis_kamar');
    $table->integer('harga_permalam');
    $table->text('deskripsi');
    $table->string('photo_kamar');
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nama_kamar');
    }
};
