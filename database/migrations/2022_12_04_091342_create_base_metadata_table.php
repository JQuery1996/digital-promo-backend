<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_metadata', function (Blueprint $table) {
            $table->string('Key');
            $table->string('entity');
            $table->string('tag');
            $table->string('name');
            $table->string('type');
            $table->string('defaultValue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_metadata');
    }
}
