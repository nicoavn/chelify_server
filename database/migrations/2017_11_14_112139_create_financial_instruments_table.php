<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_instruments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('identifier');
            $table->string('alias');
            $table->double('balance');

            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->integer('financial_entity_id')->unsigned()->nullable();
            $table->foreign('financial_entity_id')->references('id')->on('financial_entities');
            $table->integer('financial_instrument_type_id')->unsigned();
            $table->foreign('financial_instrument_type_id')->references('id')->on('financial_instrument_types');

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
        Schema::dropIfExists('financial_instruments');
    }
}
