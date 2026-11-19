<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Inventario;
use App\Models\PuntoVenta;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    private const COLUMNA_ROL = 'rol';
    private const ROL_EMPLEADO = 'vendedor';

    public function dashboard()
    {
        $inicio = Carbon::now()->startOfMonth()->subMonths(5);

        $pedidosAgrupados = Cotizacion::where('created_at', '>=', $inicio)
            ->get(['created_at'])
            ->groupBy(fn ($pedido) => $pedido->created_at->format('Y-m'));

        $labels = [];
        $datos = [];

        for ($i = 0; $i < 6; $i++) {
            $mes = $inicio->copy()->addMonths($i);
            $labels[] = ucfirst($mes->translatedFormat('M'));
            $datos[] = $pedidosAgrupados->get($mes->format('Y-m'), collect())->count();
        }

        return view('admin.dashboard', [
            'totalInventario'  => Inventario::count(),
            'totalBienes'      => Inventario::where('tipo', 'bien')->count(),
            'totalServicios'   => Inventario::where('tipo', 'servicio')->count(),
            'totalPuntosVenta' => PuntoVenta::count(),
            'totalEmpleados'   => User::where(self::COLUMNA_ROL, self::ROL_EMPLEADO)->count(),
            'totalPedidos'     => Cotizacion::count(),
            'pedidosPorMes'    => ['labels' => $labels, 'datos' => $datos],
        ]);
    }
}