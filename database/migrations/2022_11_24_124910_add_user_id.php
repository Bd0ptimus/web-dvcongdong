<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entry_ban_checking', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('car_ticket_checking', function (Blueprint $table) {
            $table->integer('user_id');
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
            $table->dropColumn('user_id');
        });
        Schema::table('car_ticket_checking', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
