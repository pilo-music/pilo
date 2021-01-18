<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewAnalyzesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('view_analyzes', function (Blueprint $table) {
			$table->charset = 'utf8';
            $table->collation = 'utf8_persian_ci';
			$table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->tinyInteger('post_type');
			$table->integer('post_id');
			$table->string('ip')->nullable();
			$table->string('browser')->nullable();
			$table->string('browser_version')->nullable();
			$table->string('platform')->nullable();
			$table->string('platform_version')->nullable();
			$table->boolean('is_robot')->default(0);
			$table->boolean('robot_name')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('view_analyzes');
	}
}
