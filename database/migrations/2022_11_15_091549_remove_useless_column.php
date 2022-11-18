<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUselessColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('car_trades', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('garments', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('mom_babies', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('classify_ads', function (Blueprint $table) {
            $table->dropColumn('city');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('content')->nullable(true);
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('address')->nullable(true);
        });
        Schema::table('car_trades', function (Blueprint $table) {
            $table->string('address')->nullable(true);
        });
        Schema::table('garments', function (Blueprint $table) {
            $table->string('info')->nullable(true);
        });
        Schema::table('mom_babies', function (Blueprint $table) {
            $table->string('info')->nullable(true);
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('address')->nullable(true);
        });
        Schema::table('classify_ads', function (Blueprint $table) {
            $table->string('info')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });
        Schema::table('services', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });
        Schema::table('car_trades', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });
        Schema::table('garments', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });
        Schema::table('mom_babies', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });
        Schema::table('classify_ads', function (Blueprint $table) {
            $table->string('city')->nullable(true);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('content');
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('car_trades', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('garments', function (Blueprint $table) {
            $table->dropColumn('info');
        });
        Schema::table('mom_babies', function (Blueprint $table) {
            $table->dropColumn('info');
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('classify_ads', function (Blueprint $table) {
            $table->dropColumn('info');
        });
    }
}
