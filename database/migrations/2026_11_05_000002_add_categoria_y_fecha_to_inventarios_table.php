<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventarios', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->after('tipo')->index();
            $table->date('fecha_adquisicion')->nullable()->after('categoria_id');
        });
    }

    public function down(): void
    {
        Schema::table('inventarios', function (Blueprint $table) {
            $table->dropIndex(['categoria_id']);
            $table->dropColumn(['categoria_id', 'fecha_adquisicion']);
        });
    }
};