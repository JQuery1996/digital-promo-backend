<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_languages', function (Blueprint $table) {
            $table->id();
            $table->integer('awardId');
            // $table->foreign('awardId')->references('id')->on('awards')->onDelete('cascade');
            $table->integer('languageId');
            $table->string('appMessage');
            $table->timestamp('CreationTimestamp');
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
        Schema::dropIfExists('award_languages');
    }
}
