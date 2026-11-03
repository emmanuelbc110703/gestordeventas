<x-layouts.panel
    titulo="Editar cliente"
    :regresar="route('admin.clientes')"
    :migas="[
        ['texto' => 'Clientes', 'url' => route('admin.clientes')],
        ['texto' => trim($cliente->name . ' ' . $cliente->apellido)],
    ]"
>

    @include('admin.clientes._formulario')

</x-layouts.panel>