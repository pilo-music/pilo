<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->timestamp('stored_at')->nullable();
        });

        Schema::table('musics', function (Blueprint $table) {
            $table->timestamp('stored_at')->nullable();
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->timestamp('stored_at')->nullable();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->timestamp('stored_at')->nullable();
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->timestamp('stored_at')->nullable();
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
            $table->dropColumn('stored_at');
        });

        Schema::table('musics', function (Blueprint $table) {
            $table->dropColumn('stored_at');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('stored_at');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('stored_at');
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('stored_at');
        });
    }
}
