<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('client_id');
            $table->string('class_day')->nullable();
            $table->string('time_from')->nullable();
            $table->string('time_to')->nullable();
            $table->unsignedBigInteger('class_category_id')->nullable();
            $table->string('class_target')->nullable();
            $table->tinyInteger('class_number')->default('0');
            $table->tinyInteger('class_count')->default('1');
            $table->tinyInteger('class_order')->default('1');
            $table->tinyInteger('main_count')->default('1');
            $table->tinyInteger('sub_count')->default('0');
            $table->tinyInteger('class_type')->default('0');
            $table->timestamps();


            $table->foreign('contract_id')->references('id')->on('contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_classes');
    }
}
