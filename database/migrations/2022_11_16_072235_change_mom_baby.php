<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMomBaby extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mom_babies', function (Blueprint $table) {
            $table->dropColumn('mombaby_classify_id');
            $table->string('information')->nullable(true)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mom_babies', function (Blueprint $table) {
            $table->dropColumn('information');
        });
    }
}
