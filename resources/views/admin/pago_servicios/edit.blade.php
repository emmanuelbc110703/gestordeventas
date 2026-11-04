<x-layouts.panel
    :titulo="'Editar ' . $pagoServicio->servicio"
    :migas="[
        ['texto' => 'Pago de servicios', 'url' => route('admin.pago_servicios.index')],
        ['texto' => 'Editar servicio', 'url' => null],
    ]"
>
    @push('estilos')
        <x-formulario-estilos />
    @endpush

    @include('admin.pago_servicios._formulario', [
        'pago'       => $pagoServicio,
        'action'     => route('admin.pago_servicios.update', $pagoServicio->id),
        'titulo'     => 'Editar servicio',
        'subtitulo'  => 'Modifica los datos de ' . $pagoServicio->servicio . '.',
        'textoBoton' => 'Guardar cambios',
    ])
</x-layouts.panel>