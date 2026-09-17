<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::create('pagos_servicios', function (Blueprint $table) {
            $table->id();

            $table->string('servicio');
            $table->string('descripcion')->nullable();

            $table->date('fecha_pago');
            $table->decimal('monto', 10, 2)->nullable();

            $table->enum('estado', ['Pendiente', 'Pagado'])
                  ->default('Pendiente');

            $table->date('fecha_vencimiento')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_servicios');
    }
};