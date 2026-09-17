<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos_comerciales', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');

            $table->string('concepto');

            $table->text('descripcion')->nullable();

            $table->string('categoria');

            $table->decimal('monto', 10, 2);

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos_comerciales');
    }
};