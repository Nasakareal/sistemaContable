<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvidenciasTable extends Migration
{
    public function up()
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_dev_id')->nullable();
            $table->string('ruta');
            $table->timestamps();

            $table->foreign('solicitud_dev_id')->references('id')->on('solicitud_devs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evidencias');
    }
}
