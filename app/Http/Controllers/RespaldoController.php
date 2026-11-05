<?php

namespace App\Http\Controllers;

use App\Services\RespaldoService;
use Illuminate\Http\Request;

class RespaldoController extends Controller
{
    public function __construct(private RespaldoService $servicio)
    {
    }

    public function index()
    {
        try {
            $motivo     = $this->servicio->motivoNoDisponible();
            $disponible = $motivo === null;
            $respaldos  = $disponible ? $this->servicio->listar() : [];
            $extension  = $this->servicio->extension();
        } catch (\Throwable $e) {
            $respaldos  = [];
            $disponible = false;
            $motivo     = $e->getMessage();
            $extension  = 'sql';
        }

        return view('admin.respaldos.index', compact('respaldos', 'disponible', 'motivo', 'extension'));
    }

    public function crear()
    {
        try {
            $nombre = $this->servicio->crear('manual');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.respaldos')
            ->with('success', 'Respaldo creado correctamente: ' . $nombre);
    }

    public function descargar(string $archivo)
    {
        try {
            $ruta = $this->servicio->rutaDe($archivo);
        } catch (\Throwable $e) {
            abort(404);
        }

        return response()->download($ruta, $archivo);
    }

    public function restaurar(string $archivo)
    {
        try {
            $previo = $this->servicio->restaurar($this->servicio->rutaDe($archivo));
        } catch (\Throwable $e) {
            return redirect()->route('admin.respaldos')->with('error', $e->getMessage());
        }

        return redirect()->route('admin.respaldos')
            ->with('success', 'Base de datos restaurada desde ' . $archivo . '. Se guardó una copia del estado anterior (' . $previo . ').');
    }

    public function restaurarArchivo(Request $request)
    {
        $request->validate([
            'archivo' => ['required', 'file', 'max:102400'],
        ], [
            'archivo.required' => 'Selecciona un archivo de respaldo.',
            'archivo.file'     => 'El archivo no es válido.',
            'archivo.max'      => 'El archivo no puede superar los 100 MB.',
        ]);

        $temporal = $request->file('archivo')->getRealPath();

        try {
            $previo = $this->servicio->restaurar($temporal);
        } catch (\Throwable $e) {
            return redirect()->route('admin.respaldos')->with('error', $e->getMessage());
        }

        return redirect()->route('admin.respaldos')
            ->with('success', 'Base de datos restaurada desde el archivo cargado. Se guardó una copia del estado anterior (' . $previo . ').');
    }

    public function eliminar(string $archivo)
    {
        try {
            $this->servicio->eliminar($archivo);
        } catch (\Throwable $e) {
            return redirect()->route('admin.respaldos')->with('error', $e->getMessage());
        }

        return redirect()->route('admin.respaldos')->with('success', 'Respaldo eliminado.');
    }
}