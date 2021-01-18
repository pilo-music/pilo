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
            $table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('level',20)->default('user');
            $table->string('email')->unique();
            $table->string('phone',20)->nullable()->unique();
            $table->string('birth',30)->nullable();
            $table->string('gender',7)->nullable();
            $table->string('pic')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(\App\Models\User::USER_STATUS_NOT_VERIFY);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
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
