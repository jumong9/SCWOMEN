<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassLectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_lector', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conatract_class_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name')->nullable();
            $table->tinyInteger('main_yn')->default(0);


            $table->timestamps();

            $table->foreign('conatract_class_id')->references('id')->on('contract_classes');
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
        Schema::dropIfExists('class_lector');
    }
}
