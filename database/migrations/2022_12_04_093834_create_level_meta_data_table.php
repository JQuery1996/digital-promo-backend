<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelMetaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_meta_data', function (Blueprint $table) {
            $table->id();
            $table->integer('levelId');
            // $table->foreign('levelId')->references('id')->on('levels')->onDelete('cascade');
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
        Schema::dropIfExists('level_meta_data');
    }
}
