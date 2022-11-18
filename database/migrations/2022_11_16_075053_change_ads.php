<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classify_ads', function (Blueprint $table) {
            $table->dropColumn('ads_classify_id');
            $table->string('adContent')->nullable(true)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classify_ads', function (Blueprint $table) {
            $table->dropColumn('adContent');
        });
    }
}
