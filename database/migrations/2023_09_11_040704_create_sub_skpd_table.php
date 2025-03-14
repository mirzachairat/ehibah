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
        Schema::create('sub_skpd', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kd_skpd');
            $table->integer('kd_sub_skpd');
            $table->string('nm_sub_skpd');
            $table->string('skpd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_skpd');
    }
};
