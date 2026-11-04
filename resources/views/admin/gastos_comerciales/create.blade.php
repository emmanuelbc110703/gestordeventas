<x-layouts.panel
    titulo="Registrar gasto"
    :migas="[
        ['texto' => 'Gastos comerciales', 'url' => route('admin.gastos_comerciales')],
        ['texto' => 'Registrar gasto', 'url' => null],
    ]"
>
    <x-formulario-estilos />

    @include('admin.gastos_comerciales._formulario', [
        'gasto'      => null,
        'action'     => route('admin.gastos_comerciales.store'),
        'titulo'     => 'Registrar gasto',
        'subtitulo'  => 'Captura un nuevo gasto comercial del negocio.',
        'textoBoton' => 'Guardar gasto',
    ])
</x-layouts.panel>