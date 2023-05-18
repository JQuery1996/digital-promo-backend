<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('awardId');
            // $table->foreign('awardId')->references('id')->on('awards')->onDelete('cascade');
            $table->integer('levelId');
            $table->integer('gameId');
            $table->string('Msisdn');
            $table->timestamp('CreationTimestamp');
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('awards_logs');
    }
}
