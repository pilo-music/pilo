<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 191);
            $table->string('name_en', 191);
            $table->string('slug')->unique();
            $table->text('image');
            $table->boolean("isbest")->default(false);
            $table->timestamps();
        });

        Schema::create('artistables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('artist_id');
            $table->bigInteger('artistable_id');
            $table->string('artistable_type');
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
        Schema::dropIfExists('artists');
        Schema::dropIfExists('artistables');
    }
}
