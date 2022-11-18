<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassifyNameUpperToClassifies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classifies', function (Blueprint $table) {
            $table->string('classify_name_upper')->after('classify_name')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classifies', function (Blueprint $table) {
            $table->dropColumn('classify_name_upper');
        });
    }
}
