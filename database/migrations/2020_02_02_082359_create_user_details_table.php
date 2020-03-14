<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
           // $table->integer('google_id');
            $table->string('title');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('address');
            $table->string('username');
            $table->string('phone')->unique();
            $table->string('profile');
            $table->string('nationality');
            $table->string('email');
            $table->string('picture_url');
            $table->string('web');
            $table->string('interest');
            $table->string('date_of_birth');
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
        Schema::dropIfExists('user_details');
    }
}
