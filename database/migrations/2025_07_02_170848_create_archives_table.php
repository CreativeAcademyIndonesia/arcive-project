<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('archives', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_akta');
        $table->string('nama_klien');
        $table->string('jenis_dokumen');
        $table->unsignedBigInteger('kategori_id');
        $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('cascade');
        $table->date('tanggal_akta');
        $table->timestamps();

    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archives');
    }
};