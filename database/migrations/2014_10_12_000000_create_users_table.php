<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('level', 20)->default('user');
            $table->string('email')->nullable();
            $table->string('phone', 20)->unique();
            $table->string('birth', 30)->nullable();
            $table->boolean('gender')->nullable();
            $table->string('pic')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(\App\Models\User::USER_STATUS_NOT_VERIFY);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->boolean('global_notification')->default(true);
            $table->boolean('music_notification')->default(true);
            $table->boolean('album_notification')->default(true);
            $table->boolean('video_notification')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
