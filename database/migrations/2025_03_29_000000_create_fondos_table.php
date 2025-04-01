<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondosTable extends Migration
{
    public function up()
    {
        Schema::create('fondos', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fondos');
    }
}
