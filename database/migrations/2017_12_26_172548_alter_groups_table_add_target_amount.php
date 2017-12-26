<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGroupsTableAddTargetAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->double('current_amount')
                ->default(0.0)
                ->after('account_id');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->double('target_amount')
                ->after('account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('current_amount');
            $table->dropColumn('target_amount');
        });
    }
}
