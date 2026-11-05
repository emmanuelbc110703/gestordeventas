<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recibos_pagos_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_servicio_id')->nullable()
                ->constrained('pagos_servicios')->nullOnDelete();
            $table->foreignId('user_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->string('servicio');

            $table->decimal('monto_agenda', 10, 2);
            $table->decimal('monto_pagado', 10, 2);

            $table->date('fecha_pago');
            $table->date('fecha_recibo');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');

            $table->string('folio_recibo', 100)->nullable();
            $table->text('informacion_recibo')->nullable();
            $table->string('estado', 20)->default('Pagado');
            $table->date('fecha_siguiente_pago')->nullable();

            $table->timestamps();

            $table->index('fecha_pago');
            $table->unique('pago_servicio_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recibos_pagos_servicios');
    }
};