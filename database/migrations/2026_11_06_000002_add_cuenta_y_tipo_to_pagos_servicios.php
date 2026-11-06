<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos_servicios', function (Blueprint $table) {
            $table->string('tipo_movimiento', 10)->default('egreso');
            $table->foreignId('cuenta_financiera_id')->nullable()
                ->constrained('cuentas_financieras')->nullOnDelete();
        });

        Schema::table('recibos_pagos_servicios', function (Blueprint $table) {
            $table->string('tipo_movimiento', 10)->default('egreso');
            $table->foreignId('cuenta_financiera_id')->nullable()
                ->constrained('cuentas_financieras')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('recibos_pagos_servicios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cuenta_financiera_id');
            $table->dropColumn('tipo_movimiento');
        });

        Schema::table('pagos_servicios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cuenta_financiera_id');
            $table->dropColumn('tipo_movimiento');
        });
    }
};