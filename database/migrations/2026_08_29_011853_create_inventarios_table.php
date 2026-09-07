<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {

            $table->id();

            // Nombre del bien o servicio
            $table->string('nombre');

            // Fotografía
            $table->string('foto')->nullable();

            // Descripción
            $table->text('descripcion')->nullable();

            // Precio
            $table->decimal('precio', 10, 2);

            // Tipo: bien o servicio
            $table->enum('tipo', ['bien', 'servicio']);

            // Cantidad disponible
            $table->integer('cantidad')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};