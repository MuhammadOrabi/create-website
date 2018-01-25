<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(1);
            $table->integer('page_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
