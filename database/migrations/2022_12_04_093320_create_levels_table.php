<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->integer('gameId');
            // $table->foreign('gameId')->references('id')->on('games')->onDelete('cascade');
            $table->integer('number');
            $table->integer('poolId');
            // $table->foreign('poolId')->references('id')->on('pools')->onDelete('cascade');
            $table->integer('tries');
            $table->integer('rounds');
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
        Schema::dropIfExists('levels');
    }
}
