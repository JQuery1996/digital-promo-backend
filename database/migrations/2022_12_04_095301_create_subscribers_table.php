<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('Msisdn');
            $table->integer('operatorId');
            $table->timestamp('lastCheckTimestamp')->nullable();
            $table->string('status');
            $table->integer('daliyBalanceValue')->nullable();
            $table->dateTime('daliyBalanceDate')->nullable();
            $table->integer('monthlyBalanceValue')->nullable();
            $table->dateTime('monthlyBalanceDate')->nullable();
            $table->timestamp('lastPlayDate')->nullable();
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
        Schema::dropIfExists('subscribers');
    }
}
