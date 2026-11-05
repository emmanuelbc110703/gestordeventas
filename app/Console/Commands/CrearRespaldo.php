<?php

namespace App\Console\Commands;

use App\Services\RespaldoService;
use Illuminate\Console\Command;

class CrearRespaldo extends Command
{
    protected $signature = 'respaldo:crear {--conservar=10 : Cantidad de respaldos programados a conservar}';

    protected $description = 'Crea un respaldo de la base de datos';

    public function handle(RespaldoService $servicio): int
    {
        try {
            $nombre = $servicio->crear('programado');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->info('Respaldo creado: ' . $nombre);

        $programados = array_values(array_filter(
            $servicio->listar(),
            fn ($r) => $r['tipo'] === 'Programado'
        ));

        foreach (array_slice($programados, (int) $this->option('conservar')) as $viejo) {
            $servicio->eliminar($viejo['nombre']);
        }

        return self::SUCCESS;
    }
}