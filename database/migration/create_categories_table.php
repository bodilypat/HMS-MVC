<?php

use Illuminate\Database\Migrations\Migratiion;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migrations
{
    /* Run the migrations */
    public function up() 
    {
        Schema::create('categories', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps(); //created at and update at timestamps
        });
    }

    /* Reverse the migrations. */
    public function down()
    {
        Schema::dropIfExist('categories');
    }
}