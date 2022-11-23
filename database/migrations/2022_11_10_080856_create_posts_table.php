<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('classify_id');
            $table->integer('user_id')->nullable(true);
            $table->string('title')->nullable(false);
            $table->string('content')->nullable(true);
            $table->Date('exist_from')->format('d-m-Y')->nullable(true);
            $table->Date('exist_to')->format('d-m-Y')->nullable(true);
            $table->string('contact_person');
            $table->string('contact_address');
            $table->integer('contact_phone');
            $table->string('contact_email');
            $table->morphs('posts_classify');
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
        Schema::dropIfExists('posts');
    }
}
