<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conatract_class_id')->nullable();;
            $table->unsignedBigInteger('user_id')->nullable();;
            $table->unsignedBigInteger('class_category_id')->nullable();

            $table->string('class_day')->nullable();
            $table->string('time_from')->nullable();
            $table->string('time_to')->nullable();

            $table->string('class_place')->nullable();
            $table->text('class_contents');
            $table->text('class_rating');

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
        Schema::dropIfExists('class_reports');
    }
}
