<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function dropMorphs($name, $indexName = null){
        $this->dropIndex($indexName?:$this->createIndexName('index', ["{$name}_type", "{$name}_id"]));
        $this->dropColumn("{$name}_type", "{$name}_id");
    }
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->dropMorphs('real_estate_type');
        });

        Schema::table('car_trades', function (Blueprint $table) {
            $table->dropMorphs('car_trades_type');
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->dropMorphs('jobs_type');
        });

        Schema::table('garments', function (Blueprint $table) {
            $table->dropMorphs('garments_type');
        });

        Schema::table('mom_babies', function (Blueprint $table) {
            $table->dropMorphs('mombaby_type');
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropMorphs('restaurants_type');
        });

        Schema::table('classify_ads', function (Blueprint $table) {
            $table->dropMorphs('ads_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
