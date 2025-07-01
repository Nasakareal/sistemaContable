<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRevisadoToViaticosTable extends Migration
{
    public function up()
    {
        Schema::table('viaticos', function (Blueprint $table) {
            $table->boolean('revisado')->default(false)->after('estatus');
        });
    }

    public function down()
    {
        Schema::table('viaticos', function (Blueprint $table) {
            $table->dropColumn('revisado');
        });
    }
}
