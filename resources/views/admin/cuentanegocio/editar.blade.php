<x-layouts.panel
    titulo="Editar cuenta"
    :regresar="route('admin.cuentas.index')"
    :migas="[
        ['texto' => 'Cuenta del negocio', 'url' => route('admin.cuentas.index')],
        ['texto' => $cuenta->nombre],
    ]"
>

    @include('admin.cuentanegocio._formulario')

</x-layouts.panel>