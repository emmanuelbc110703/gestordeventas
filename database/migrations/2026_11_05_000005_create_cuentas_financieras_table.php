<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuentas_financieras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo', 10);
            $table->string('moneda', 3)->default('MXN');
            $table->string('numero_cuenta', 50)->nullable();
            $table->decimal('saldo_inicial', 14, 2)->default(0);
            $table->date('fecha_saldo_inicial');
            $table->boolean('activa')->default(true);
            $table->text('notas')->nullable();
            $table->string('tipo_pasivo', 20)->nullable();
            $table->string('direccion_pasivo', 10)->nullable();
            $table->decimal('tasa_interes', 6, 2)->nullable();
            $table->string('periodo_interes', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuentas_financieras');
    }
};