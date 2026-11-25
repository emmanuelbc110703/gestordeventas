<x-layouts.panel
    titulo="Nueva promoción"
    :regresar="route('admin.promociones')"
    :migas="[
        ['texto' => 'Promociones', 'url' => route('admin.promociones')],
        ['texto' => 'Nueva'],
    ]"
>

@push('estilos')
    @include('admin.promociones._estilos')
@endpush

<div class="pagina-promo">
    <div class="promo-encabezado">
        <div>
            <h1>Nueva promoción</h1>
            <p>Registra un descuento para productos o servicios.</p>
        </div>
    </div>

    <form action="{{ route('admin.promociones.guardar') }}" method="POST">
        @csrf
        @include('admin.promociones._form', ['textoBoton' => 'Guardar promoción'])
    </form>
</div>

</x-layouts.panel>