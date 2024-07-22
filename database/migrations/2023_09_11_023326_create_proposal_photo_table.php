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
        Schema::create('proposal_photo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposal_id');
            $table->integer('sequence');
            $table->string('path');
            $table->integer('is_nphd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_photo');
    }
};
