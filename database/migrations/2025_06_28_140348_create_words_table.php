<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordsTable extends Migration
{
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word')->unique();
            $table->string('translate');
            $table->text('example')->nullable();
            $table->string('language');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('words');
    }
}
