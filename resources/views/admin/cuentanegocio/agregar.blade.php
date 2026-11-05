<x-layouts.panel
    titulo="Nueva cuenta"
    :regresar="route('admin.cuentas.index')"
    :migas="[
        ['texto' => 'Cuenta del negocio', 'url' => route('admin.cuentas.index')],
        ['texto' => 'Nueva cuenta'],
    ]"
>

    @include('admin.cuentanegocio._formulario')

</x-layouts.panel>