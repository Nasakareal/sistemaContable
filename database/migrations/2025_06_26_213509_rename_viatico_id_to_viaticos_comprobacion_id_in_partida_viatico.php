<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameViaticoIdToViaticosComprobacionIdInPartidaViatico extends Migration
{
    public function up()
    {
        Schema::table('partida_viatico', function (Blueprint $table) {
            $table->renameColumn('viatico_id', 'viaticos_comprobacion_id');
        });
    }

    public function down()
    {
        Schema::table('partida_viatico', function (Blueprint $table) {
            $table->renameColumn('viaticos_comprobacion_id', 'viatico_id');
        });
    }
}
