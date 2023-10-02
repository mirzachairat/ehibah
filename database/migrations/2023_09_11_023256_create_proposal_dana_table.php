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
        Schema::create('proposal_dana', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposal_id');
            $table->integer('sequence');
            $table->string('description');
            $table->decimal('amount');
            $table->decimal('correction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_dana');
    }
};
