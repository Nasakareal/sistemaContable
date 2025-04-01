<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadResponsablesTable extends Migration
{
    public function up()
    {
        Schema::create('unidad_responsables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fondo_id')->constrained('fondos')->onDelete('cascade');
            $table->string('clave')->unique();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidad_responsables');
    }
}
