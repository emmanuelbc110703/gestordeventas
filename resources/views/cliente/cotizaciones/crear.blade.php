<x-layouts.panel
    titulo="Crear cotización"
    :regresar="route('cliente.cotizaciones')"
    :migas="[
        ['texto' => 'Mis pedidos', 'url' => route('cliente.cotizaciones')],
        ['texto' => 'Crear cotización'],
    ]"
>

<x-formulario-estilos />
<x-lista-estilos />

@push('estilos')
<style>
    .cat-layout { grid-template-columns: 2fr 1fr; gap: 24px; }
    .cat-herramientas { margin-bottom: 16px; }

    .cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }
    .cat-servicio {
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid var(--borde);
        transition: border-color 0.2s ease;
    }
    .cat-servicio:hover { border-color: #c4b5fd; }
    .cat-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background: #f3f4f6;
        display: block;
    }
    .cat-sin-img {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        color: #c0c5ce;
        font-size: 34px;
    }
    .cat-cuerpo {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 16px;
    }
    .cat-nombre {
        margin: 0 0 6px;
        font-size: 15px;
        font-weight: 600;
        color: var(--texto);
    }
    .cat-desc {
        margin: 0 0 12px;
        font-size: 13px;
        line-height: 1.45;
        color: var(--texto-suave);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-precio {
        margin-top: auto;
        margin-bottom: 12px;
        font-size: 18px;
        font-weight: 700;
        color: var(--primario);
    }
    .cat-accion { display: flex; gap: 8px; }
    .cat-cantidad {
        width: 64px;
        height: 38px;
        padding: 0 6px;
        border: 1px solid var(--borde);
        border-radius: 0;
        font: inherit;
        font-size: 14px;
        text-align: center;
    }
    .cat-cantidad:focus { outline: none; border-color: var(--primario); }
    .cat-agregar {
        flex: 1;
        height: 38px;
        background: var(--primario-suave);
        border: 1px solid #ddd6fe;
        border-radius: 0;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        color: var(--primario);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }
    .cat-agregar:hover {
        background: var(--primario);
        border-color: var(--primario);
        color: #fff;
    }

    /* Carrito */
    .cat-carrito { position: sticky; top: 88px; }
    .cat-vacio-carrito {
        padding: 18px 0;
        text-align: center;
        font-size: 14px;
        color: #9ca3af;
    }
    .cat-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--borde);
    }
    .cat-item-nombre { font-size: 14px; font-weight: 600; color: var(--texto); }
    .cat-item-detalle { margin-top: 3px; font-size: 13px; color: var(--texto-suave); }
    .cat-item-der { text-align: right; white-space: nowrap; }
    .cat-item-importe { font-weight: 700; font-size: 14px; }
    .cat-quitar {
        margin-top: 4px;
        padding: 0;
        background: none;
        border: none;
        font: inherit;
        font-size: 12px;
        color: #b91c1c;
        cursor: pointer;
    }
    .cat-quitar:hover { text-decoration: underline; }

    .cat-subtotal {
        display: flex;
        justify-content: space-between;
        margin-top: 16px;
        font-size: 17px;
        font-weight: 700;
    }
    .cat-pago-titulo {
        margin: 22px 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--texto-suave);
    }
    .cat-pago {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        margin-bottom: 8px;
        border: 1px solid var(--borde);
        font-size: 14px;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .cat-pago:hover { background: #fcfbff; }
    .cat-pago:has(input:checked) {
        border-color: var(--primario);
        background: var(--primario-suave);
        color: var(--primario);
    }
    .cat-pago input { accent-color: var(--primario); }
    .cat-enviar { width: 100%; margin-top: 18px; }

    .cat-sin-resultados {
        display: none;
        padding: 40px 20px;
        text-align: center;
        color: var(--texto-suave);
        border: 1px solid var(--borde);
        background: #fff;
    }
    .cat-sin-resultados.visible { display: block; }

    @media (max-width: 950px) {
        .cat-layout { grid-template-columns: 1fr; }
        .cat-carrito { position: static; }
    }
</style>
@endpush

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div>
            <h1>Crear cotización</h1>
            <p>Selecciona los servicios que necesitas y envía tu solicitud.</p>
        </div>
        <div class="frm-acciones">
            <a href="{{ route('cliente.cotizaciones') }}" class="frm-btn-cancelar">Volver</a>
        </div>
    </div>

    @if($errors->any())
        <div class="frm-alerta">
            <strong>No se pudo enviar la cotización:</strong>
            <ul style="margin: 6px 0 0; padding-left: 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="frm-alerta" id="errorCliente" style="display: none;"></div>

    <form method="POST" action="{{ route('cliente.cotizaciones.store') }}" id="formCotizacion">
        @csrf

        <div class="frm-grid cat-layout">
            <div>
                @if($servicios->isNotEmpty())
                    <div class="cat-herramientas">
                        <div class="lst-buscador">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="buscadorServicios" placeholder="Buscar servicio..." autocomplete="off">
                            <button type="button" class="lst-btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="cat-grid" id="catalogo">
                    @forelse($servicios as $servicio)
                        <div class="cat-servicio" data-nombre="{{ $servicio->nombre }}">
                            @if($servicio->foto)
                                <img src="{{ asset('storage/' . $servicio->foto) }}"
                                     alt="{{ $servicio->nombre }}" class="cat-img">
                            @else
                                <div class="cat-sin-img"><i class="fa-solid fa-image"></i></div>
                            @endif

                            <div class="cat-cuerpo">
                                <h3 class="cat-nombre">{{ $servicio->nombre }}</h3>
                                <p class="cat-desc">{{ $servicio->descripcion ?: 'Sin descripción disponible.' }}</p>
                                <div class="cat-precio">${{ number_format($servicio->precio, 2) }}</div>

                                <div class="cat-accion">
                                    <input type="number" min="1" value="1"
                                           class="cat-cantidad"
                                           id="cantidad-{{ $servicio->id }}"
                                           aria-label="Cantidad">
                                    <button type="button" class="cat-agregar"
                                            data-id="{{ $servicio->id }}"
                                            data-nombre="{{ $servicio->nombre }}"
                                            data-precio="{{ $servicio->precio }}">
                                        <i class="fa-solid fa-cart-plus"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="cat-sin-resultados visible" style="grid-column: 1 / -1;">
                            Actualmente no hay servicios disponibles.
                        </div>
                    @endforelse
                </div>

                <div class="cat-sin-resultados" id="sinResultados">
                    No se encontraron servicios con esa búsqueda.
                </div>
            </div>

            <aside class="frm-card cat-carrito">
                <h2 class="frm-card-titulo">Mi pedido</h2>

                <div id="listaCarrito">
                    <div class="cat-vacio-carrito">No has agregado servicios.</div>
                </div>

                <div class="cat-subtotal">
                    <span>Subtotal</span>
                    <span id="subtotalTexto">$0.00</span>
                </div>

                <p class="cat-pago-titulo">Forma de pago</p>

                <label class="cat-pago">
                    <input type="radio" name="forma_pago" value="efectivo">
                    <i class="fa-solid fa-money-bill-wave"></i> Efectivo
                </label>
                <label class="cat-pago">
                    <input type="radio" name="forma_pago" value="transferencia">
                    <i class="fa-solid fa-building-columns"></i> Transferencia
                </label>

                <button type="submit" class="frm-btn-guardar cat-enviar" id="botonSolicitar" disabled>
                    <i class="fa-solid fa-paper-plane" style="margin-right: 8px;"></i> Solicitar cotización
                </button>
            </aside>

        </div>
    </form>
</div>

@push('scripts')
<script>
    (function () {
        let carrito = [];

        const formulario = document.getElementById('formCotizacion');
        const catalogo = document.getElementById('catalogo');
        const lista = document.getElementById('listaCarrito');
        const subtotalTexto = document.getElementById('subtotalTexto');
        const boton = document.getElementById('botonSolicitar');
        const errorCliente = document.getElementById('errorCliente');

        function escapeHtml(texto) {
            const div = document.createElement('div');
            div.textContent = texto;
            return div.innerHTML;
        }

        function mostrarError(mensaje) {
            errorCliente.textContent = mensaje;
            errorCliente.style.display = 'block';
        }

        function ocultarError() {
            errorCliente.style.display = 'none';
        }

        function actualizarBoton() {
            const pago = document.querySelector('input[name="forma_pago"]:checked');
            boton.disabled = carrito.length === 0 || !pago;
        }

        function actualizarInputs() {
            document.querySelectorAll('.input-carrito').forEach(function (i) { i.remove(); });

            carrito.forEach(function (item, indice) {
                [['id', item.id], ['cantidad', item.cantidad]].forEach(function (par) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'productos[' + indice + '][' + par[0] + ']';
                    input.value = par[1];
                    input.className = 'input-carrito';
                    formulario.appendChild(input);
                });
            });
        }

        function renderizar() {
            if (carrito.length === 0) {
                lista.innerHTML = '<div class="cat-vacio-carrito">No has agregado servicios.</div>';
                subtotalTexto.textContent = '$0.00';
            } else {
                let subtotal = 0;
                let html = '';

                carrito.forEach(function (item) {
                    const importe = item.precio * item.cantidad;
                    subtotal += importe;

                    html +=
                        '<div class="cat-item">' +
                            '<div>' +
                                '<div class="cat-item-nombre">' + escapeHtml(item.nombre) + '</div>' +
                                '<div class="cat-item-detalle">' + item.cantidad + ' × $' + item.precio.toFixed(2) + '</div>' +
                            '</div>' +
                            '<div class="cat-item-der">' +
                                '<div class="cat-item-importe">$' + importe.toFixed(2) + '</div>' +
                                '<button type="button" class="cat-quitar" data-quitar="' + item.id + '">Quitar</button>' +
                            '</div>' +
                        '</div>';
                });

                lista.innerHTML = html;
                subtotalTexto.textContent = '$' + subtotal.toFixed(2);
            }

            actualizarInputs();
            actualizarBoton();
        }

        catalogo.addEventListener('click', function (evento) {
            const btn = evento.target.closest('.cat-agregar');
            if (!btn) return;

            const id = parseInt(btn.dataset.id, 10);
            const input = document.getElementById('cantidad-' + id);
            let cantidad = parseInt(input.value, 10);

            if (!cantidad || cantidad < 1) {
                cantidad = 1;
                input.value = 1;
            }

            const existente = carrito.find(function (i) { return i.id === id; });

            if (existente) {
                existente.cantidad += cantidad;
            } else {
                carrito.push({
                    id: id,
                    nombre: btn.dataset.nombre,
                    precio: parseFloat(btn.dataset.precio),
                    cantidad: cantidad
                });
            }

            input.value = 1;
            ocultarError();
            renderizar();
        });

        lista.addEventListener('click', function (evento) {
            const btn = evento.target.closest('[data-quitar]');
            if (!btn) return;

            const id = parseInt(btn.dataset.quitar, 10);
            carrito = carrito.filter(function (i) { return i.id !== id; });
            renderizar();
        });

        document.querySelectorAll('input[name="forma_pago"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                ocultarError();
                actualizarBoton();
            });
        });

        formulario.addEventListener('submit', function (evento) {
            if (carrito.length === 0) {
                evento.preventDefault();
                mostrarError('Agrega al menos un servicio.');
                return;
            }
            if (!document.querySelector('input[name="forma_pago"]:checked')) {
                evento.preventDefault();
                mostrarError('Selecciona una forma de pago.');
                return;
            }
            actualizarInputs();
            boton.disabled = true;
        });

        const buscador = document.getElementById('buscadorServicios');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const sinResultados = document.getElementById('sinResultados');

        if (buscador) {
            function normalizar(t) {
                return (t || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
            }

            function filtrar() {
                const texto = normalizar(buscador.value);
                btnLimpiar.style.display = buscador.value ? 'flex' : 'none';
                let visibles = 0;

                catalogo.querySelectorAll('.cat-servicio').forEach(function (tarjeta) {
                    const coincide = normalizar(tarjeta.dataset.nombre).includes(texto);
                    tarjeta.style.display = coincide ? '' : 'none';
                    if (coincide) visibles++;
                });

                sinResultados.classList.toggle('visible', visibles === 0);
            }

            buscador.addEventListener('input', filtrar);
            btnLimpiar.addEventListener('click', function () {
                buscador.value = '';
                filtrar();
                buscador.focus();
            });
        }

        actualizarBoton();
    })();
</script>
@endpush

</x-layouts.panel>