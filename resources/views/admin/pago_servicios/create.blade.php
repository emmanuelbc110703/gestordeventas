<x-layouts.panel
    titulo="Agregar servicio"
    :migas="[
        ['texto' => 'Pago de servicios', 'url' => route('admin.pago_servicios.index')],
        ['texto' => 'Agregar servicio', 'url' => null],
    ]"
>
    <x-formulario-estilos />

    @include('admin.pago_servicios._formulario', [
        'pago'       => null,
        'action'     => route('admin.pago_servicios.store'),
        'titulo'     => 'Agregar servicio',
        'subtitulo'  => 'Registra un servicio o pago del negocio.',
        'textoBoton' => 'Guardar servicio',
    ])
</x-layouts.panel>