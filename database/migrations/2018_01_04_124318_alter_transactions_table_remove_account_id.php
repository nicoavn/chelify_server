<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactionsTableRemoveAccountId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_account_id_foreign');
            $table->dropColumn('account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('account_id')->unsigned()->after('amount');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }
}
