<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarTicketCheckingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_ticket_checking', function (Blueprint $table) {
            $table->id();
            $table->string('car_license');
            $table->string('car_ownership_certificate');
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
        Schema::dropIfExists('car_ticket_checking');
    }
}
