<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\BluePrint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobTable extend Migration 
{
    public function up()
    {
        Schema::create('failedJob', function (Blueprint $table){
            $table->string('userID')->unique();
            $table->String('connection');
            $table->string('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestemp('failed')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('failedJob');
    }
}