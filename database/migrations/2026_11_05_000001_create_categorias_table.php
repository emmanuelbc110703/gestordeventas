<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['bien', 'servicio'])->default('bien');
            $table->timestamps();
            $table->unique(['nombre', 'tipo']);
        });

        $ahora = now();

        DB::table('categorias')->insert([
            ['nombre' => 'Accesorios de Baño', 'descripcion' => null, 'tipo' => 'bien', 'created_at' => $ahora, 'updated_at' => $ahora],
            ['nombre' => 'Muebles',            'descripcion' => null, 'tipo' => 'bien', 'created_at' => $ahora, 'updated_at' => $ahora],
            ['nombre' => 'Decoración',         'descripcion' => null, 'tipo' => 'bien', 'created_at' => $ahora, 'updated_at' => $ahora],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};