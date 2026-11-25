<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->text('descripcion')->nullable();
            $table->enum('tipo_descuento', ['porcentaje', 'monto_fijo']);
            $table->decimal('valor', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activa')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inventario_promocion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promocion_id')->constrained('promociones')->cascadeOnDelete();
            $table->foreignId('inventario_id')->constrained('inventarios')->cascadeOnDelete();
            $table->unique(['promocion_id', 'inventario_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario_promocion');
        Schema::dropIfExists('promociones');
    }
};