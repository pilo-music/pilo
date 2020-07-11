<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMusicsChangeTablesNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musics', function (Blueprint $table) {
            $table->string('title_en')->nullable(false)->change();
            $table->string('title')->nullable()->change();
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->string('name_en')->nullable(false)->change();
            $table->string('name')->nullable()->change();
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->string('title_en')->nullable(false)->change();
            $table->string('title')->nullable()->change();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->string('title_en')->nullable(false)->change();
            $table->string('title')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musics', function (Blueprint $table) {
            $table->string('title_en')->nullable()->change();
            $table->string('title')->change();
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->string('name_en')->nullable()->change();
            $table->string('name')->change();
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->string('title_en')->nullable()->change();
            $table->string('title')->change();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->string('title_en')->nullable()->change();
            $table->string('title')->change();
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->string('title_en')->nullable()->change();
            $table->string('title')->change();
        });
    }
}
