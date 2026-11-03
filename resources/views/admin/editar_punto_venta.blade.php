<x-layouts.panel
    titulo="Editar punto de venta"
    :regresar="route('admin.puntos_venta')"
    :migas="[
        ['texto' => 'Puntos de venta', 'url' => route('admin.puntos_venta')],
        ['texto' => $puntoVenta->nombre_caja],
    ]"
>

    @include('admin.puntos_venta._formulario')

</x-layouts.panel>