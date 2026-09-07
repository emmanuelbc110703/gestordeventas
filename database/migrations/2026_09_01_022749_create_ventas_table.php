<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | La tabla ventas ya puede existir
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasTable('ventas')) {

            Schema::create('ventas', function (Blueprint $table) {

                $table->id();

                $table->string('folio');

                $table->foreignId('punto_venta_id')
                    ->constrained('puntos_venta')
                    ->cascadeOnDelete();

                $table->foreignId('empleado_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->foreignId('cliente_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->decimal('subtotal', 10, 2)
                    ->default(0);

                $table->decimal('descuento_porcentaje', 5, 2)
                    ->default(0);

                $table->decimal('descuento', 10, 2)
                    ->default(0);

                $table->decimal('impuesto_porcentaje', 5, 2)
                    ->default(0);

                $table->decimal('impuesto', 10, 2)
                    ->default(0);

                $table->decimal('total', 10, 2)
                    ->default(0);

                $table->enum('forma_pago', [
                    'efectivo',
                    'tarjeta',
                    'transferencia'
                ]);

                $table->decimal('efectivo_recibido', 10, 2)
                    ->nullable();

                $table->decimal('cambio', 10, 2)
                    ->nullable();

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};