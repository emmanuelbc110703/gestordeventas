<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cajas', function (Blueprint $table) {

            $table->id();

            // Punto de venta al que pertenece la caja
            $table->foreignId('punto_venta_id')
                ->constrained('puntos_venta')
                ->cascadeOnDelete();

            // Empleado que realiza la apertura
            $table->foreignId('empleado_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Fecha correspondiente a la jornada
            $table->date('fecha');

            // Momento exacto en que se abrió
            $table->dateTime('hora_apertura');

            // Dinero entregado para cambio inicial
            $table->decimal('monto_inicial', 10, 2);

            // Estado de la caja
            $table->enum('estado', [
                'abierta',
                'cerrada'
            ])->default('abierta');

            // Momento en que se cierre posteriormente
            $table->dateTime('hora_cierre')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};