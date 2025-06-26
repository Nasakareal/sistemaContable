<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDescripcionFromViaticosComprobacions extends Migration
{
    public function up()
    {
        Schema::table('viaticos_comprobacions', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });
    }

    public function down()
    {
        Schema::table('viaticos_comprobacions', function (Blueprint $table) {
            $table->text('descripcion')->nullable();
        });
    }
}
