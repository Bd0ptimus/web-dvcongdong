<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestRequireResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entry_ban_checking', function (Blueprint $table) {
            $table->integer('response_require')->nullable();
        });
        Schema::table('car_ticket_checking', function (Blueprint $table) {
            $table->integer('response_require')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entry_ban_checking', function (Blueprint $table) {
            $table->dropColumn('response_require');
        });
        Schema::table('car_ticket_checking', function (Blueprint $table) {
            $table->dropColumn('response_require');
        });
    }
}
