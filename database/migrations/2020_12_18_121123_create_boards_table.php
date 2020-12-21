<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();

            $table->string('board_id');
            $table->string('board_title');
            $table->text('board_contents');
            $table->unsignedBigInteger('file_id');

            $table->unsignedBigInteger('created_id');
            $table->string('created_name');
            $table->unsignedBigInteger('updated_id');
            $table->string('updated_name');

            $table->integer('read_count');

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
        Schema::dropIfExists('boards');
    }
}
