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
    public function up()
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('user');
            $table->integer('name');
            $table->integer('judul');
            $table->integer('latar_belakang');
            $table->integer('maksud_tujuan');
            $table->integer('address');
            $table->string('file');
            $table->string('nphd');
            $table->string('foto');
            $table->integer('type_id');
            $table->integer('skpd_id');
            $table->timestamp('time_entry');
            $table->date('tanggal_lpj');
            $table->integer('current_stat');
            $table->string('tahun');
            $table->string('rekomendasi');
            $table->string('rekomendasi_ins');
            $table->string('rekomendasi_ta');
            $table->string('dokumen_tapd');
            $table->string('lampiran');
            $table->string('penetapan');
            $table->string('sppd');
            $table->string('kota');
            $table->string('kec');
            $table->string('kel');
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
        Schema::dropIfExists('proposal');
    }
};
