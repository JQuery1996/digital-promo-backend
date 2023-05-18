<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMetaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_meta_data', function (Blueprint $table) {
            $table->id();
            $table->integer('gameId');
            // $table->foreign('gameId')->references('id')->on('games')->onDelete('cascade');
            $table->string('key');
            $table->string('value');

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
        Schema::dropIfExists('game_meta_data');
    }
}
