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
        Schema::create('transaksi', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('nama_pemesan')->nullable();
            $table->string('kebangsaan');
            $table->string('kode_negara')->nullable();
            $table->string('nohp')->nullable();
            $table->unsignedBigInteger('id_kamar');
            $table->string('kode_transaksi', 20)->unique();
            $table->integer('total_harga');
            $table->date('check_in');
            $table->date('check_out');
            $table->string('metode_pembayaran');
            $table->string('status')->default('pending');
            $table->dateTime('tanggal_transaksi')->nullable();
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->string('acceptedby')->nullable();
            $table->string('snap_token')->nullable();
            $table->timestamp('kadaluarsa')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kamar')->references('id')->on('nama_kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
