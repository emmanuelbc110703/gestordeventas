<x-layouts.panel
    titulo="Promociones"
    :regresar="route('admin.dashboard')"
    :migas="[['texto' => 'Promociones', 'url' => route('admin.promociones')]]"
>
@push('estilos')
    @include('admin.promociones._estilos')
@endpush
<x-sidebar activo="promociones" :total-inventario="\App\Models\Inventario::count()" />
<div class="pagina-promo">
    <div class="promo-encabezado">
        <div>
            <h1>Promociones y descuentos</h1>
            <p>Administra los descuentos aplicables a productos y servicios durante la venta.</p>
        </div>
        <a href="{{ route('admin.promociones.crear') }}" class="btn-p">
            <i class="fa-solid fa-plus"></i> Nueva promoción
        </a>
    </div>
    @if(session('success'))
        <div class="mensaje-exito"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif

    <div class="tabla-wrap">
        @if($promociones->count() > 0)
            <table class="tabla-promo">
                <thead>
                    <tr>
                        <th>Promoción</th>
                        <th>Descuento</th>
                        <th>Vigencia</th>
                        <th>Aplica a</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promociones as $promocion)
                        <tr>
                            <td>
                                <span class="nombre-promo">{{ $promocion->nombre }}</span>
                                @if($promocion->descripcion)
                                    <span class="desc-promo">{{ \Illuminate\Support\Str::limit($promocion->descripcion, 70) }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $promocion->tipo_descuento === 'porcentaje'
                                    ? rtrim(rtrim(number_format($promocion->valor, 2), '0'), '.') . '%'
                                    : '$ ' . number_format($promocion->valor, 2) }}
                            </td>
                            <td>{{ $promocion->fecha_inicio->format('d/m/Y') }} – {{ $promocion->fecha_fin->format('d/m/Y') }}</td>
                            <td>{{ $promocion->inventarios_count }} {{ $promocion->inventarios_count === 1 ? 'elemento' : 'elementos' }}</td>
                            <td><span class="estado {{ strtolower($promocion->estado) }}">{{ $promocion->estado }}</span></td>
                            <td>
                                <div class="acciones-fila">
                                    <a href="{{ route('admin.promociones.editar', $promocion->id) }}" class="btn-p-sec btn-p-chico">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.promociones.eliminar', $promocion->id) }}"
                                          onsubmit="return confirm('¿Eliminar la promoción «{{ addslashes($promocion->nombre) }}»?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-p-peligro btn-p-chico">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="vacio">
                <i class="fa-solid fa-tags"></i>
                <h3>No hay promociones registradas</h3>
                <p>Crea una para aplicar descuentos en tus ventas.</p>
            </div>
        @endif
    </div>
</div>

</x-layouts.panel>