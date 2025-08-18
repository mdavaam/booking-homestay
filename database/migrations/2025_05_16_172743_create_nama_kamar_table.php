<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('nama_kamar', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kamar');
            $table->string('nama_kamar')->unique();
            $table->text('deskripsi');
            $table->string('status')->default('tersedia');
            $table->integer('harga_permalam');
            $table->string('photo_utama');
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
