<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('addressLineOne');
            $table->string('addressLineTwo')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('thumbnail')->nullable();
            $table->double('price', 8, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('listings');
    }
}
