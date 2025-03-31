<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudDevsTable extends Migration
{
    public function up()
    {
        Schema::create('solicitud_devs', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('documento_origen')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_devs');
    }
}
