<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_pago_servicio_id')
                ->constrained('agenda_pagos_servicios')
                ->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('monto_agenda', 12, 2);
            $table->decimal('monto_pagado', 12, 2);
            $table->date('fecha_pago');
            $table->date('fecha_recibo');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->string('folio_recibo', 100)->nullable();
            $table->text('informacion_recibo')->nullable();
            $table->string('estado', 20)->default('pagado');
            $table->date('fecha_siguiente_pago');
            $table->timestamps();
            $table->index('fecha_pago');
            $table->unique(['agenda_pago_servicio_id', 'periodo_inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos_servicios');
    }
};