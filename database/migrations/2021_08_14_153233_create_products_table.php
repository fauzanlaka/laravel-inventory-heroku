<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug'); // url --> exp: my-iphone-232
            $table->string('description')->nullable();
            $table->decimal('price', 9, 2); // เลข 9 หลัก ทศนิยม 2 ตำแหน่ง
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_id')->comment('created by user');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
}
