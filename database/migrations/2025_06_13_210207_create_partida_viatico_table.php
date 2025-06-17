<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidaViaticoTable extends Migration
{
    public function up()
    {
        Schema::create('partida_viatico', function (Blueprint $table) {
            $table->id();

            $table->foreignId('viatico_id')->constrained()->onDelete('cascade');
            $table->foreignId('partida_id')->constrained()->onDelete('restrict');
            $table->decimal('monto', 12, 2);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partida_viatico');
    }
}
