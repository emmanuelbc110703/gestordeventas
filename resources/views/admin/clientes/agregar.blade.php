<x-layouts.panel
    titulo="Nuevo cliente"
    :regresar="route('admin.clientes')"
    :migas="[
        ['texto' => 'Clientes', 'url' => route('admin.clientes')],
        ['texto' => 'Nuevo'],
    ]"
>

    @include('admin.clientes._formulario')

</x-layouts.panel>