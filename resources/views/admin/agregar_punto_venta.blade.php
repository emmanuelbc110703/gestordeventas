<x-layouts.panel
    titulo="Nuevo punto de venta"
    :regresar="route('admin.puntos_venta')"
    :migas="[
        ['texto' => 'Puntos de venta', 'url' => route('admin.puntos_venta')],
        ['texto' => 'Nuevo'],
    ]"
>

    @include('admin.puntos_venta._formulario')

</x-layouts.panel>