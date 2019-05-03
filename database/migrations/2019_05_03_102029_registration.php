<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Registration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data', function($table){
            $table->increments('id');
            $table->string('first_name',25);
            $table->string('middle_initial',3);
            $table->string('last_name',25);
            $table->string('school',40);
            $table->dateTime('date_created');
            $table->string('email',255);
            $table->string('role',30);
            $table->tinyInteger('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
