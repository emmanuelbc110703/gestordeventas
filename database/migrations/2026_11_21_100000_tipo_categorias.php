<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE categorias MODIFY tipo VARCHAR(30) NOT NULL DEFAULT 'bien'");
    }

    public function down(): void
    {
        $otros = DB::table('categorias')->whereNotIn('tipo', ['bien', 'servicio'])->count();

        if ($otros > 0) {
            throw new RuntimeException(
                'No se puede revertir: hay categorías de otros tipos. Elimínalas o reasígnalas primero.'
            );
        }

        DB::statement("ALTER TABLE categorias MODIFY tipo ENUM('bien','servicio') NOT NULL DEFAULT 'bien'");
    }
};