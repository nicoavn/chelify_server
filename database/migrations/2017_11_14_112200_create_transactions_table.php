<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->double('amount');


            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->integer('financial_instrument_id')->unsigned();
            $table->foreign('financial_instrument_id')->references('id')->on('financial_instruments');
            $table->integer('transaction_category_id')->unsigned()->nullable();
            $table->foreign('transaction_category_id')->references('id')->on('transaction_categories');

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
        Schema::dropIfExists('transactions');
    }
}
