<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear detalles de las cotizaciones.
     */
    public function up(): void
    {
        Schema::create('cotizacion_detalles', function (Blueprint $table) {

            $table->id();

            // Cotización a la que pertenece
            $table->foreignId('cotizacion_id')
                ->constrained('cotizaciones')
                ->cascadeOnDelete();

            // Servicio original del inventario
            $table->foreignId('inventario_id')
                ->constrained('inventarios')
                ->restrictOnDelete();

            // Copia del servicio al momento de realizar la cotización
            $table->string('nombre');

            // Cantidad solicitada
            $table->integer('cantidad')->default(1);

            // Precio del servicio en ese momento
            $table->decimal('precio', 10, 2);

            // Importe
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Eliminar tabla.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_detalles');
    }
};