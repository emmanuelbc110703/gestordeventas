<x-layouts.panel
    :titulo="'Editar ' . $gasto->concepto"
    :migas="[
        ['texto' => 'Gastos comerciales', 'url' => route('admin.gastos_comerciales')],
        ['texto' => 'Editar gasto', 'url' => null],
    ]"
>
    <x-formulario-estilos />

    @include('admin.gastos_comerciales._formulario', [
        'gasto'      => $gasto,
        'action'     => route('admin.gastos_comerciales.update', $gasto->id),
        'titulo'     => 'Editar gasto',
        'subtitulo'  => 'Modifica los datos del gasto "' . $gasto->concepto . '".',
        'textoBoton' => 'Guardar cambios',
    ])
</x-layouts.panel>