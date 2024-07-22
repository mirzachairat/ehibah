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
        Schema::create('laporan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('laporan_id');
            $table->integer('tahun');
            $table->decimal('anggaran');
            $table->decimal('realisasi_rp');
            $table->float('realisasi_persen');
            $table->integer('penerima_cair');
            $table->integer('penerima_lapor');
            $table->integer('nilai_lapor');
            $table->string('file');
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
        Schema::dropIfExists('laporan');
    }
};
