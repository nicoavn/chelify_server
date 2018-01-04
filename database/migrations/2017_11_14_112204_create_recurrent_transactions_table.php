<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecurrentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurrent_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('day_of_month');
            $table->double('amount');
            $table->string('title');
            $table->boolean('active');

            $table->integer('charge_to')->unsigned();
            $table->foreign('charge_to')->references('id')->on('financial_instruments');

            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recurrent_transactions');
    }
}
