<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permitir clientes sin correo electrónico.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')
                ->nullable()
                ->change();
        });
    }

    /**
     * Volver a hacer obligatorio el correo.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')
                ->nullable(false)
                ->change();
        });
    }
};