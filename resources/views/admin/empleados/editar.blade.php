<x-layouts.panel
    titulo="Editar empleado"
    :regresar="route('admin.empleados')"
    :migas="[
        ['texto' => 'Empleados', 'url' => route('admin.empleados')],
        ['texto' => trim($empleado->name . ' ' . $empleado->apellido)],
    ]"
>

    @include('admin.empleados._formulario')

</x-layouts.panel>