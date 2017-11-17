<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contents', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type');
			$table->string('title')->nullable();
			$table->longText('content')->nullable();
			$table->integer('section_id')->nullable();
			$table->integer('constant_id')->nullable();
			$table->integer('order')->default(0);
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
		Schema::dropIfExists('contents');
	}
}
