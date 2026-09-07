<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aperturas_caja', function (Blueprint $table) {

            $table->id();

            $table->foreignId('punto_venta_id')
                ->constrained('puntos_venta')
                ->cascadeOnDelete();

            $table->foreignId('empleado_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('fecha');

            $table->time('hora_apertura');

            $table->decimal('dinero_inicial', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aperturas_caja');
    }
};