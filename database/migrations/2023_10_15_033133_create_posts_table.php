<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('author');
            $table->string('title');
            $table->text('meta_desc');
            $table->string('slug')->unique();
            $table->string('tag');
            $table->foreignId('category');
            $table->string('cover');
            $table->text('body');
            $table->foreignUuid('id_tutorial')->nullable();
            $table->integer('tutorial_order')->default(false);
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
};
