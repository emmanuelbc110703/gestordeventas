<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    private const ETIQUETAS = [
        'publicidad'    => 'Publicidad',
        'transporte'    => 'Transporte',
        'papeleria'     => 'Papelería',
        'servicios'     => 'Servicios',
        'mantenimiento' => 'Mantenimiento',
        'compras'       => 'Compras',
        'otros'         => 'Otros',
    ];

    public function up(): void
    {
        if (! Schema::hasColumn('gastos_comerciales', 'categoria_id')) {
            Schema::table('gastos_comerciales', function (Blueprint $table) {
                $table->unsignedBigInteger('categoria_id')->nullable()->after('descripcion');
            });
        }

        $ahora = now();

        foreach (self::ETIQUETAS as $nombre) {
            DB::table('categorias')->insertOrIgnore([
                'nombre'     => $nombre,
                'tipo'       => 'gasto',
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ]);
        }

        if (Schema::hasColumn('gastos_comerciales', 'categoria')) {
            $valores = DB::table('gastos_comerciales')
                ->whereNotNull('categoria')
                ->where('categoria', '!=', '')
                ->distinct()
                ->pluck('categoria');

            foreach ($valores as $valor) {
                $nombre = self::ETIQUETAS[Str::lower($valor)] ?? Str::ucfirst(trim($valor));

                DB::table('categorias')->insertOrIgnore([
                    'nombre'     => $nombre,
                    'tipo'       => 'gasto',
                    'created_at' => $ahora,
                    'updated_at' => $ahora,
                ]);

                $id = DB::table('categorias')
                    ->where('tipo', 'gasto')
                    ->where('nombre', $nombre)
                    ->value('id');

                DB::table('gastos_comerciales')
                    ->where('categoria', $valor)
                    ->update(['categoria_id' => $id]);
            }

            Schema::table('gastos_comerciales', function (Blueprint $table) {
                $table->dropColumn('categoria');
            });
        }

        Schema::table('gastos_comerciales', function (Blueprint $table) {
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gastos_comerciales', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->string('categoria')->default('otros')->after('descripcion');
        });

        DB::table('gastos_comerciales')
            ->whereNotNull('categoria_id')
            ->orderBy('id')
            ->each(function ($gasto) {
                $nombre = DB::table('categorias')->where('id', $gasto->categoria_id)->value('nombre');

                DB::table('gastos_comerciales')
                    ->where('id', $gasto->id)
                    ->update(['categoria' => Str::slug($nombre ?? 'otros')]);
            });

        Schema::table('gastos_comerciales', function (Blueprint $table) {
            $table->dropColumn('categoria_id');
        });
    }
};