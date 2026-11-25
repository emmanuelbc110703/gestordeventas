<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->foreignId('promocion_id')->nullable()->after('inventario_id')
                ->constrained('promociones')->nullOnDelete();
            $table->decimal('descuento', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('detalle_ventas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promocion_id');
            $table->dropColumn('descuento');
        });
    }
};
