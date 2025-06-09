<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyeccionsTable extends Migration
{
    public function up()
    {
        Schema::create('proyecciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuenta_bancaria_id');
            $table->unsignedTinyInteger('month');
            $table->year('year');
            $table->decimal('monto', 15, 2);
            $table->timestamps();

            $table->foreign('cuenta_bancaria_id')->references('id')->on('cuenta_bancarias')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proyeccions');
    }
}
