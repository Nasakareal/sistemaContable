<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentaBancariasTable extends Migration
{
    public function up()
    {
        Schema::create('cuenta_bancarias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fondo_id');
            $table->string('nombre');
            $table->string('numero');
            $table->decimal('saldo', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('fondo_id')->references('id')->on('fondos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuenta_bancarias');
    }
}
