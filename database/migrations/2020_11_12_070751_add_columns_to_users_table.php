<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->tinyInteger('grade')->default('0');
           $table->string('mobile')->nullable();
           $table->tinyInteger('group')->default('0');
           $table->string('birthday')->nullable();
           $table->string('zipcode')->nullable();
           $table->string('address')->nullable();
           $table->tinyInteger('status')->default('0');
           $table->tinyInteger('gubun')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['grade','mobile','group','birthday','zipcode','address','status','gubun']);
        });
    }
}
