<?php

namespace App\Console\Commands;

use App\Models\AgendaPagoServicio;
use Illuminate\Console\Command;

class ActivarPagosPendientes extends Command
{
    protected $signature = 'pagos-servicios:activar-pendientes';

    protected $description = 'Vuelve a pendiente los servicios pagados cuyo siguiente periodo ya llegó';

    public function handle(): int
    {
        $total = AgendaPagoServicio::query()
            ->where('estado', 'pagado')
            ->whereDate('fecha_pago', '<=', today())
            ->update(['estado' => 'pendiente']);

        $this->info("Servicios marcados como pendientes: {$total}");

        return self::SUCCESS;
    }
}