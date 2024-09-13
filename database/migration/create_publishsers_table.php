<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersTable extends Migration 
{
    /* Run the mingrations. */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /* Reverse the migratons. */
    public function down()
    {
        Schema::dropIfExists('publishers');
    }
}