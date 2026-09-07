<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla de cotizaciones.
     */
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {

            $table->id();

            // Cliente que realizó la cotización
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Folio de la cotización
            $table->string('folio')->unique();

            // Estado del proceso
            $table->enum('estado', [
                'enviado',
                'procesando',
                'finalizado',
                'terminado'
            ])->default('enviado');

            // Forma de pago elegida por el cliente
            $table->enum('forma_pago', [
                'efectivo',
                'transferencia'
            ]);

            // Totales
            $table->decimal('subtotal', 10, 2)->default(0);

            $table->decimal('descuento', 10, 2)->default(0);

            $table->decimal('descuento_porcentaje', 5, 2)->default(0);

            $table->decimal('impuesto', 10, 2)->default(0);

            $table->decimal('impuesto_porcentaje', 5, 2)->default(0);

            $table->decimal('total', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Eliminar tabla.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};