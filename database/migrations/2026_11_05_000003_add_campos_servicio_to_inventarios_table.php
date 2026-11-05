<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventarios', function (Blueprint $table) {
            $table->decimal('costo', 10, 2)->nullable()->after('precio');
            $table->string('referencia', 100)->nullable()->after('costo');
            $table->boolean('disponible_punto_venta')->default(true)->after('cantidad');
        });
    }

    public function down(): void
    {
        Schema::table('inventarios', function (Blueprint $table) {
            $table->dropColumn(['costo', 'referencia', 'disponible_punto_venta']);
        });
    }
};