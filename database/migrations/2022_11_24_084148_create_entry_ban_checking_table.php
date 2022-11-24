<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryBanCheckingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_ban_checking', function (Blueprint $table) {
            $table->id();
            $table->string('name_russian');
            $table->string('name_latin');
            $table->Date('dob')->format('d-m-Y');
            $table->string('passport_series');
            $table->Date('passport_expired')->format('d-m-Y');
            $table->integer('status');
            $table->integer('result')->nullable();
            $table->string('result_comment')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_ban_checking');
    }
}
