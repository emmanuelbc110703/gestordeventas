<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::table('users', function (Blueprint $table) {
        $table->string('apellido');
        $table->string('telefono')->nullable();
        $table->string('direccion')->nullable();
        $table->date('fecha_nacimiento')->nullable();
        $table->string('foto_perfil')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'apellido',
            'telefono',
            'direccion',
            'fecha_nacimiento',
            'foto_perfil',
        ]);
    });
}
};
