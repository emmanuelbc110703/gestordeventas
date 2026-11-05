<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos_servicios', function (Blueprint $table) {
            $table->string('periodicidad', 20)->nullable()->after('estado');
        });
    }

    public function down(): void
    {
        Schema::table('pagos_servicios', function (Blueprint $table) {
            $table->dropColumn('periodicidad');
        });
    }
};