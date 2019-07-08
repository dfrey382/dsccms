<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->unsignedInteger('author_id');
            $table->enum('post_type',['Pages','Posts'])->nullable();
            $table->string('post_title');
            $table->string('slug')->unique()->nullable();
            $table->longText('post_content')->nullable();
            $table->text('excerpt');
            $table->string('featured_image');
            $table->timestamp('published_at');
            $table->timestamps();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
