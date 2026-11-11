<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;

class ClienteController extends Controller
{
    public function dashboard()
    {
        return view('cliente.dashboard');
    }

    public function compras(Request $request)
    {
        $base = Cotizacion::where('user_id', auth()->id())->whereIn('estado', ['procesando', 'finalizado', 'terminado']);

        $resumen = [
            'total'       => (clone $base)->count(),
            'procesando'  => (clone $base)->where('estado', 'procesando')->count(),
            'finalizadas' => (clone $base)->whereIn('estado', ['finalizado', 'terminado'])->count(),
            'invertido'   => (clone $base)->sum('total'),
        ];

        $filtro = (string) $request->query('estado', '');

        $compras = (clone $base)
            ->when($filtro === 'procesando', fn ($q) => $q->where('estado', 'procesando'))
            ->when($filtro === 'finalizadas', fn ($q) => $q->whereIn('estado', ['finalizado', 'terminado']))
            ->withCount('detalles')
            ->latest()
            ->get();

        return view('cliente.compras', compact('compras', 'resumen', 'filtro'));
    }
}