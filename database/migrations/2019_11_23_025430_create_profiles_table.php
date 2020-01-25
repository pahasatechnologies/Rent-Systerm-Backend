<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('addressLineOne');
            $table->string('addressLineTwo')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode');
            $table->text('bio')->nullable();
            $table->unsignedBigInteger('user_id')->unique();
            $table->timestamps();

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
        Schema::dropIfExists('profiles');
    }
}
