<x-layouts.panel
    titulo="Nuevo empleado"
    :regresar="route('admin.empleados')"
    :migas="[
        ['texto' => 'Empleados', 'url' => route('admin.empleados')],
        ['texto' => 'Nuevo'],
    ]"
>

    @include('admin.empleados._formulario')

</x-layouts.panel>