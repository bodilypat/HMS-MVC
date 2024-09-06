<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersnalAccessTokenTable extends Migration
{
    public function up()
    {
        Schema::create('personalAccessToken', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_use_date')->nullable();
            $table->timestamp();
        });
    }

    public function down() 
    {
        Schema::dropIfExists('personalAccessToken');
    }
}
