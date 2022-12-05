<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeServiceContentToNullnable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_documents', function (Blueprint $table) {
            $table->string('content')->nullable()->change();
        });
        Schema::table('service_edus', function (Blueprint $table) {
            $table->string('content')->nullable()->change();
        });
        Schema::table('service_electronics', function (Blueprint $table) {
            $table->string('content')->nullable()->change();
        });
        Schema::table('service_medicals', function (Blueprint $table) {
            $table->string('content')->nullable()->change();
        });
        Schema::table('service_travels', function (Blueprint $table) {
            $table->string('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
