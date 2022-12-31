<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminisCheckingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminis_checking', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->Date('dob');
            $table->string('passport_series');
            $table->Date('passport_expired');
            $table->integer('status')->nullable();
            $table->integer('user_id');
            $table->integer('response_require')->nullable();
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
        Schema::dropIfExists('adminis_checking');

    }
}
