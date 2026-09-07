<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregar columna rol.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('rol')
                ->default('cliente');

        });
    }

    /**
     * Eliminar columna rol.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('rol');

        });
    }
};