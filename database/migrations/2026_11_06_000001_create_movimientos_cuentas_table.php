<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_cuentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_financiera_id')
                ->constrained('cuentas_financieras')
                ->restrictOnDelete();
            $table->string('tipo', 10);
            $table->decimal('monto', 14, 2);
            $table->date('fecha');
            $table->string('concepto');
            $table->foreignId('recibo_pago_servicio_id')->nullable()
                ->constrained('recibos_pagos_servicios')->nullOnDelete();
            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['cuenta_financiera_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_cuentas');
    }
};