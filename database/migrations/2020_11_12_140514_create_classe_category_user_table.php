<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_category_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_category_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();


            $table->foreign('class_category_id')->references('id')->on('class_category_user');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_category_user');
    }
}
