<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthersTable extends Migration
{
    /* Run the migrations. */
    public function up()
    {
        Schema::create('authers', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('biography')->nullable();
            $table->timestamps();
        });
    }

    /* Reverse the migrations. */
    public function down()
    {
        Schema::dropIfExists('authers');
    }
}