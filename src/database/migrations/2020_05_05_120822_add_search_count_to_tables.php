<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchCountToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->unsignedBigInteger('search_count')->default(0);
        });
        Schema::table('musics', function (Blueprint $table) {
            $table->unsignedBigInteger('search_count')->default(0);
        });
        Schema::table('albums', function (Blueprint $table) {
            $table->unsignedBigInteger('search_count')->default(0);
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->unsignedBigInteger('search_count')->default(0);
        });
        Schema::table('playlists', function (Blueprint $table) {
            $table->unsignedBigInteger('search_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('search_count')->default(0);
        });
        Schema::table('musics', function (Blueprint $table) {
            $table->dropColumn('search_count')->default(0);
        });
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('search_count')->default(0);
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('search_count')->default(0);
        });
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('search_count')->default(0);
        });
    }
}
