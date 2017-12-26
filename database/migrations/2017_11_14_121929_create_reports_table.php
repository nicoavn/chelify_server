<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('report_type');
            $table->timestamp('from_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('to_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->integer('financial_instrument_id')->unsigned();
            $table->foreign('financial_instrument_id')->references('id')->on('financial_instruments');
            $table->integer('transaction_category_type_id')->unsigned();
            $table->foreign('transaction_category_type_id')->references('id')->on('transaction_category_types');

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
        Schema::dropIfExists('reports');
    }
}
