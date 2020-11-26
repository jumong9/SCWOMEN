<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->unsignedBigInteger('class_cost')->nullable();
            $table->unsignedBigInteger('class_total_cost')->nullable();
            $table->unsignedBigInteger('material_cost')->nullable();
            $table->unsignedBigInteger('material_total_cost')->nullable();
            $table->unsignedBigInteger('total_cost')->nullable();
            $table->tinyInteger('paid_yn', 1)->default('0');
            $table->tinyInteger('status')->default('1');
            $table->string('comments')->nullable();
            $table->timestamps();


            $table->foreign('client_id')->references('id')->on('clients');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
