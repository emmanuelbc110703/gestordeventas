<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('inventarios')
            ->whereNotNull('categoria_id')
            ->whereNotIn('categoria_id', DB::table('categorias')->select('id'))
            ->update(['categoria_id' => null]);

        Schema::table('inventarios', function (Blueprint $table) {
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inventarios', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
        });
    }
};