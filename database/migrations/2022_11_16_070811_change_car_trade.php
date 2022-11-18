<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCarTrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_trades', function (Blueprint $table) {
            $table->dropColumn('car_trade_classify_id');
            $table->string('address_trading')->nullable(true)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_trades', function (Blueprint $table) {
            $table->dropColumn('address_trading');
        });
    }
}
