<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_pools', function (Blueprint $table) {
            $table->integer('awardId');
            // $table->foreign('awardId')->references('id')->on('awards')->onDelete('cascade');
            $table->integer('poolId');
            $table->integer('count');
            $table->integer('remaining');

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
        Schema::dropIfExists('award_pools');
    }
}
