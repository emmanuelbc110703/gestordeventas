<x-layouts.panel
    titulo="Editar promoción"
    :regresar="route('admin.promociones')"
    :migas="[
        ['texto' => 'Promociones', 'url' => route('admin.promociones')],
        ['texto' => 'Editar'],
    ]"
>

@push('estilos')
    @include('admin.promociones._estilos')
@endpush

<div class="pagina-promo">
    <div class="promo-encabezado">
        <div>
            <h1>Editar promoción</h1>
            <p>Modifica la información de la promoción seleccionada.</p>
        </div>
    </div>

    <form action="{{ route('admin.promociones.actualizar', $promocion->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.promociones._form', ['textoBoton' => 'Actualizar promoción'])
    </form>
</div>

</x-layouts.panel>