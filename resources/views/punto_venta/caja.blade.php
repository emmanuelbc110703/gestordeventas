<x-layouts.panel
    titulo="Caja registradora"
    :regresar="route('empleado.punto_venta')"
    :migas="[
        ['texto' => 'Caja registradora', 'url' => '#'],
    ]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .cj-perfil { position: relative; }
    .cj-perfil-boton {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        height: 40px;
        padding: 0 12px 0 6px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 13px;
        font-weight: 500;
        color: var(--texto);
        cursor: pointer;
        transition: border-color 0.2s ease;
    }
    .cj-perfil-boton:hover { border-color: var(--primario); }
    .cj-perfil-foto,
    .cj-perfil-icono {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primario);
        color: #fff;
        font-size: 12px;
        object-fit: cover;
    }
    .cj-menu-perfil {
        display: none;
        position: absolute;
        right: 0;
        top: 46px;
        width: 220px;
        background: #fff;
        border: 1px solid var(--borde);
        z-index: 50;
    }
    .cj-menu-perfil.mostrar { display: block; }
    .cj-menu-perfil-info {
        padding: 14px 16px;
        border-bottom: 1px solid var(--borde);
    }
    .cj-menu-perfil-info strong { display: block; font-size: 14px; color: var(--texto); }
    .cj-menu-perfil-info span { font-size: 12px; color: var(--texto-suave); }
    .cj-menu-perfil button {
        width: 100%;
        padding: 12px 16px;
        background: #fff;
        border: none;
        text-align: left;
        font-family: inherit;
        font-size: 13px;
        color: #b91c1c;
        cursor: pointer;
    }
    .cj-menu-perfil button:hover { background: #fef2f2; }
    .cj-menu-perfil button i { width: 20px; }
    .cj-toast {
        display: none;
        position: fixed;
        top: 90px;
        right: 24px;
        z-index: 15000;
        min-width: 300px;
        max-width: 420px;
        padding: 14px 16px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-left: 4px solid #047857;
        align-items: center;
        gap: 12px;
        color: #047857;
    }
    .cj-toast.mostrar { display: flex; }
    .cj-toast i { font-size: 22px; flex-shrink: 0; }
    .cj-toast strong { display: block; margin-bottom: 3px; font-size: 14px; }
    .cj-toast span { font-size: 13px; color: var(--texto-suave); }
    .cj-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(340px, 0.9fr);
        gap: 20px;
        align-items: start;
    }
    .cj-panel {
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        padding: 22px;
    }
    .cj-panel-titulo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }
    .cj-panel-titulo i { color: var(--primario); font-size: 18px; }
    .cj-panel-titulo h2 { margin: 0; font-size: 17px; font-weight: 600; color: var(--texto); }

    .cj-buscador { position: relative; margin-bottom: 18px; }
    .cj-buscador i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--texto-suave);
        font-size: 14px;
    }
    .cj-buscador input,
    .cj-input {
        width: 100%;
        height: 42px;
        padding: 0 14px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease;
    }
    .cj-buscador input { padding-left: 40px; }
    .cj-buscador input:focus,
    .cj-input:focus { border-color: var(--primario); }

    .cj-servicios {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 14px;
        max-height: 640px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .cj-servicio {
        padding: 14px;
        background: #fff;
        border: 1px solid var(--borde);
        transition: border-color 0.2s ease;
    }
    .cj-servicio:hover { border-color: var(--primario); }
    .cj-servicio-imagen {
        width: 100%;
        height: 140px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f9fafb;
        border: 1px solid var(--borde);
    }
    .cj-servicio-imagen img { width: 100%; height: 100%; object-fit: cover; }
    .cj-servicio-vacio { color: var(--primario); font-size: 38px; }
    .cj-servicio h3 { margin: 0 0 6px; font-size: 15px; font-weight: 600; color: var(--texto); }
    .cj-servicio-precio {
        margin-bottom: 6px;
        font-size: 19px;
        font-weight: 700;
        color: var(--primario);
    }
    .cj-servicio-stock { margin-bottom: 12px; font-size: 12px; color: var(--texto-suave); }

    .cj-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 40px;
        padding: 0 16px;
        background: var(--primario);
        border: 1px solid var(--primario);
        border-radius: 0;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        transition: opacity 0.2s ease;
    }
    .cj-btn:hover { opacity: 0.88; }
    .cj-btn:disabled { background: #d1d5db; border-color: #d1d5db; cursor: not-allowed; opacity: 1; }
    .cj-btn-verde { background: #047857; border-color: #047857; }
    .cj-btn-rojo { background: #b91c1c; border-color: #b91c1c; }
    .cj-btn-claro {
        background: #fff;
        border-color: var(--borde);
        color: var(--texto);
    }
    .cj-btn-claro:hover { background: #f9fafb; opacity: 1; }

    .cj-sin-servicios {
        grid-column: 1 / -1;
        padding: 50px 20px;
        text-align: center;
        color: var(--texto-suave);
    }
    .cj-sin-servicios i { display: block; margin-bottom: 14px; font-size: 40px; color: #c4b5fd; }

    .cj-cliente { margin-bottom: 22px; }
    .cj-cliente-buscador { display: flex; gap: 8px; }
    .cj-cliente-buscador .cj-input { flex: 1; min-width: 0; }
    .cj-cliente-buscador .cj-btn { width: auto; white-space: nowrap; }
    .cj-clientes-lista {
        margin-top: 6px;
        max-height: 160px;
        overflow-y: auto;
    }
    .cj-cliente-opcion {
        padding: 10px 12px;
        border: 1px solid var(--borde);
        border-top: none;
        background: #fff;
        cursor: pointer;
    }
    .cj-cliente-opcion:first-child { border-top: 1px solid var(--borde); }
    .cj-cliente-opcion:hover { background: #f5f3ff; }
    .cj-cliente-opcion strong { display: block; font-size: 14px; }
    .cj-cliente-opcion span { font-size: 12px; color: var(--texto-suave); }
    .cj-cliente-seleccionado {
        display: none;
        margin-top: 10px;
        padding: 11px 12px;
        background: #f5f3ff;
        border: 1px solid #ddd6fe;
        font-size: 14px;
        font-weight: 600;
        color: var(--primario);
    }

    .cj-carrito {
        min-height: 140px;
        max-height: 340px;
        overflow-y: auto;
        margin-bottom: 18px;
    }
    .cj-carrito-vacio {
        padding: 40px 10px;
        text-align: center;
        font-size: 14px;
        color: var(--texto-suave);
    }
    .cj-carrito-vacio i { display: block; margin-bottom: 10px; font-size: 34px; color: #c4b5fd; }
    .cj-producto {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--borde);
    }
    .cj-producto-info { display: flex; align-items: center; gap: 10px; min-width: 0; }
    .cj-producto-imagen {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f9fafb;
        border: 1px solid var(--borde);
        color: var(--primario);
    }
    .cj-producto-imagen img { width: 100%; height: 100%; object-fit: cover; }
    .cj-producto-nombre { font-size: 14px; font-weight: 600; }
    .cj-producto-precio { margin-top: 3px; font-size: 14px; font-weight: 700; color: var(--primario); }
    .cj-controles { display: flex; align-items: center; gap: 6px; }
    .cj-cantidad-btn {
        width: 30px;
        height: 30px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .cj-cantidad-btn:hover { background: var(--primario); border-color: var(--primario); color: #fff; }
    .cj-cantidad { min-width: 24px; text-align: center; font-weight: 700; font-size: 14px; }
    .cj-eliminar {
        margin-left: 4px;
        background: transparent;
        border: none;
        color: #b91c1c;
        cursor: pointer;
    }

    .cj-totales { padding-top: 16px; border-top: 1px solid var(--borde); }
    .cj-fila {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 14px;
    }
    .cj-porcentaje { display: flex; align-items: center; gap: 6px; }
    .cj-porcentaje input {
        width: 90px;
        height: 36px;
        padding: 0 10px;
        text-align: right;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        outline: none;
    }
    .cj-porcentaje input:focus { border-color: var(--primario); }
    .cj-porcentaje span { font-weight: 700; color: var(--primario); }
    .cj-fila-final {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--borde);
    }
    .cj-fila-final > span:first-child { font-size: 17px; font-weight: 600; }
    #total { font-size: 28px; font-weight: 700; color: var(--primario); }
    .cj-cobrar { height: 50px; margin-top: 18px; font-size: 16px; }

    .lst-modal .lst-modal-caja.cj-ancho { max-width: 520px; }
    .cj-centro { text-align: center; }
    .cj-modal-icono {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 28px;
    }
    .cj-icono-info  { background: #f5f3ff; color: var(--primario); }
    .cj-icono-exito { background: #ecfdf5; color: #047857; }
    .cj-botones { display: flex; gap: 10px; margin-top: 20px; }
    .cj-botones .cj-btn { flex: 1; }
    .cj-campo { margin-bottom: 16px; text-align: left; }
    .cj-campo label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 600; }

    .cj-total-cobro {
        margin-bottom: 20px;
        padding: 16px;
        text-align: center;
        background: #f5f3ff;
        border: 1px solid #ddd6fe;
    }
    .cj-total-cobro small { display: block; margin-bottom: 4px; color: var(--texto-suave); }
    .cj-total-cobro strong { font-size: 32px; color: var(--primario); }
    .cj-titulo-metodo { margin-bottom: 10px; font-size: 13px; font-weight: 600; text-align: left; }
    .cj-metodos {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 18px;
    }
    .cj-metodo {
        padding: 16px 8px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 13px;
        color: var(--texto);
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .cj-metodo i { display: block; margin-bottom: 8px; font-size: 24px; }
    .cj-metodo:hover { border-color: var(--primario); }
    .cj-metodo.seleccionado {
        border-color: var(--primario);
        background: #f5f3ff;
        color: var(--primario);
    }
    .cj-efectivo {
        display: none;
        margin-bottom: 18px;
        padding: 16px;
        text-align: left;
        border: 1px solid var(--borde);
    }
    .cj-efectivo.mostrar { display: block; }
    .cj-efectivo label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; }
    .cj-efectivo input { font-size: 17px; height: 46px; }
    .cj-cambio {
        display: flex;
        justify-content: space-between;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--borde);
        font-size: 14px;
    }
    #cambioValor { font-size: 18px; font-weight: 700; color: #047857; }
    .cj-mensaje-pago {
        display: none;
        margin-bottom: 14px;
        padding: 10px 12px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        font-size: 13px;
        color: #b91c1c;
        text-align: left;
    }
    .cj-mensaje-pago.mostrar { display: block; }

    .cj-folio {
        margin: 16px 0 4px;
        padding: 16px;
        background: #f5f3ff;
        border: 1px solid #ddd6fe;
    }
    .cj-folio span { display: block; margin-bottom: 6px; font-size: 13px; color: var(--texto-suave); }
    .cj-folio strong { font-size: 28px; color: var(--primario); }

    @media (max-width: 1000px) {
        .cj-grid { grid-template-columns: 1fr; }
        .cj-servicios { max-height: none; }
    }
    @media (max-width: 600px) {
        .cj-perfil-nombre { display: none; }
        .cj-servicios { grid-template-columns: 1fr 1fr; }
        .cj-cliente-buscador { flex-wrap: wrap; }
        .cj-cliente-buscador .cj-btn { width: 100%; }
        .cj-metodos { grid-template-columns: 1fr; }
        .cj-botones { flex-direction: column; }
        .cj-toast { top: 80px; left: 14px; right: 14px; min-width: 0; max-width: none; }
    }
    @media (max-width: 420px) {
        .cj-servicios { grid-template-columns: 1fr; }
        .cj-producto { grid-template-columns: 1fr; }
    }
</style>
@endpush
<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <h1>Caja registradora</h1>
            </div>
            <p>Registra ventas, selecciona clientes y cobra los servicios.</p>
        </div>
        <div class="cj-perfil">
            <button type="button" class="cj-perfil-boton" onclick="toggleMenuPerfil()">
                @if(auth()->user()->foto_perfil)
                    <img
                        src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                        class="cj-perfil-foto"
                        alt="Perfil"
                    >
                @else
                    <span class="cj-perfil-icono">
                        <i class="fa-solid fa-user"></i>
                    </span>
                @endif
                <span class="cj-perfil-nombre">{{ auth()->user()->name }}</span>
                <i class="fa-solid fa-chevron-down" style="font-size:11px;"></i>
            </button>
            <div class="cj-menu-perfil" id="menuPerfil">
                <div class="cj-menu-perfil-info">
                    <strong>
                        {{ auth()->user()->name }}
                        {{ auth()->user()->apellido ?? '' }}
                    </strong>
                    <span>{{ ucfirst(auth()->user()->rol ?? '') }}</span>
                </div>
                <button type="button" onclick="abrirModalCerrarCaja()">
                    <i class="fa-solid fa-door-open"></i>
                    Cerrar caja
                </button>
            </div>
        </div>
    </div>
    <div class="cj-toast" id="mensajeClienteRegistrado">
        <i class="fa-solid fa-circle-check"></i>
        <div>
            <strong>¡Cliente registrado correctamente!</strong>
            <span id="textoClienteRegistrado"></span>
        </div>
    </div>
    <div class="cj-grid">
        <section class="cj-panel">
            <div class="cj-panel-titulo">
                <i class="fa-solid fa-list"></i>
                <h2>Servicios</h2>
            </div>
            <div class="cj-buscador">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscarServicio" placeholder="Buscar servicio..." autocomplete="off">
            </div>
            <div class="cj-servicios" id="listaServicios">
                @forelse($servicios as $servicio)
                    <div class="cj-servicio" data-nombre="{{ strtolower($servicio->nombre) }}">
                        <div class="cj-servicio-imagen">
                            @if($servicio->foto)
                                <img
                                    src="{{ asset('storage/' . $servicio->foto) }}"
                                    alt="{{ $servicio->nombre }}"
                                >
                            @else
                                <div class="cj-servicio-vacio">
                                    <i class="fa-solid fa-concierge-bell"></i>
                                </div>
                            @endif
                        </div>
                        <h3>{{ $servicio->nombre }}</h3>
                        <div class="cj-servicio-precio">
                            ${{ number_format($servicio->precio, 2) }}
                        </div>
                        <div class="cj-servicio-stock">
                            Disponible: {{ $servicio->cantidad }}
                        </div>
                        <button
                            type="button"
                            class="cj-btn"
                            onclick="agregarProducto(
                                {{ $servicio->id }},
                                @js($servicio->nombre),
                                {{ $servicio->precio }},
                                @js($servicio->foto),
                                {{ $servicio->cantidad }}
                            )"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Agregar
                        </button>
                    </div>
                @empty
                    <div class="cj-sin-servicios">
                        <i class="fa-solid fa-box-open"></i>
                        <div>No hay servicios registrados.</div>
                    </div>
                @endforelse
            </div>
        </section>
        <section class="cj-panel">
            <div class="cj-cliente">
                <div class="cj-panel-titulo">
                    <i class="fa-solid fa-user"></i>
                    <h2>Cliente</h2>
                </div>
                <div class="cj-cliente-buscador">
                    <input
                        type="text"
                        id="buscarCliente"
                        class="cj-input"
                        placeholder="Buscar cliente..."
                        autocomplete="off"
                    >
                    <button type="button" class="cj-btn" onclick="abrirModalCliente()">
                        <i class="fa-solid fa-user-plus"></i>
                        Nuevo cliente
                    </button>
                </div>
                <div class="cj-clientes-lista" id="clientesLista"></div>
                <div class="cj-cliente-seleccionado" id="clienteSeleccionado">
                    <i class="fa-solid fa-user-check"></i>
                    <span id="clienteNombre"></span>
                </div>
            </div>
            <div class="cj-panel-titulo">
                <i class="fa-solid fa-cart-shopping"></i>
                <h2>Venta actual</h2>
            </div>
            <div class="cj-carrito" id="carrito">
                <div class="cj-carrito-vacio">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Agrega servicios a la venta.
                </div>
            </div>
            <div class="cj-totales">
                <div class="cj-fila">
                    <span>Subtotal</span>
                    <strong id="subtotal">$0.00</strong>
                </div>
                <div class="cj-fila">
                    <span>Descuento</span>
                    <div class="cj-porcentaje">
                        <input type="number" id="descuento" value="0" min="0" max="100" step="0.01">
                        <span>%</span>
                    </div>
                </div>
                <div class="cj-fila">
                    <span>Impuesto</span>
                    <div class="cj-porcentaje">
                        <input type="number" id="impuesto" value="0" min="0" max="100" step="0.01">
                        <span>%</span>
                    </div>
                </div>
                <div class="cj-fila-final">
                    <span>Total</span>
                    <span id="total">$0.00</span>
                </div>
                <button
                    type="button"
                    class="cj-btn cj-cobrar"
                    id="botonCobrar"
                    disabled
                    onclick="abrirModalCobro()"
                >
                    <i class="fa-solid fa-money-bill-wave"></i>
                    Cobrar
                </button>
            </div>
        </section>
    </div>
</div>
<div class="lst-modal" id="modalCliente" role="dialog" aria-modal="true" aria-labelledby="tituloModalCliente">
    <div class="lst-modal-caja">
        <h2 id="tituloModalCliente">Registrar cliente</h2>
        <form method="POST" action="{{ route('cliente.registrar.caja') }}" id="formRegistrarCliente">
            @csrf
            <div class="cj-campo">
                <label>Nombre</label>
                <input type="text" name="name" class="cj-input" required maxlength="255" placeholder="Nombre del cliente">
            </div>
            <div class="cj-campo">
                <label>Apellido</label>
                <input type="text" name="apellido" class="cj-input" required maxlength="255" placeholder="Apellido del cliente">
            </div>
            <div class="cj-campo">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="cj-input" maxlength="20" placeholder="Número de teléfono">
            </div>
            <div class="lst-modal-botones">
                <button type="button" class="lst-btn-cancelar" onclick="cerrarModalCliente()">
                    Cancelar
                </button>
                <button type="submit" class="lst-btn-confirmar boton-guardar">
                    <i class="fa-solid fa-user-plus"></i>
                    Registrar cliente
                </button>
            </div>
        </form>
    </div>
</div>
<div class="lst-modal" id="modalCerrarCaja" role="dialog" aria-modal="true" aria-labelledby="tituloCerrarCaja">
    <div class="lst-modal-caja cj-centro">
        <div class="cj-modal-icono cj-icono-info">
            <i class="fa-solid fa-cash-register"></i>
        </div>
        <h2 id="tituloCerrarCaja">¿Cerrar la caja?</h2>
        <p>
            Vas a cerrar la caja.
            <br><br>
            Recuerda que
            <strong>no puedes volver a poner el dinero inicial</strong>.
        </p>
        <div class="lst-modal-botones">
            <button type="button" class="lst-btn-cancelar" onclick="cerrarModalCerrarCaja()">
                Cancelar
            </button>
            <button type="button" class="lst-btn-confirmar" onclick="cerrarCaja()">
                Sí, cerrar caja
            </button>
        </div>
    </div>
</div>
<div class="lst-modal" id="modalCobro" role="dialog" aria-modal="true" aria-labelledby="tituloCobro">
    <div class="lst-modal-caja cj-ancho">
        <h2 id="tituloCobro">Cobrar venta</h2>
        <div class="cj-total-cobro">
            <small>Total a pagar</small>
            <strong id="totalModalCobro">$0.00</strong>
        </div>
        <div class="cj-titulo-metodo">Selecciona la forma de pago:</div>
        <div class="cj-metodos">
            <button type="button" class="cj-metodo" id="metodoEfectivo" onclick="seleccionarMetodoPago('efectivo')">
                <i class="fa-solid fa-money-bill-wave"></i>
                <span>Efectivo</span>
            </button>
            <button type="button" class="cj-metodo" id="metodoTarjeta" onclick="seleccionarMetodoPago('tarjeta')">
                <i class="fa-solid fa-credit-card"></i>
                <span>Tarjeta</span>
            </button>
            <button type="button" class="cj-metodo" id="metodoTransferencia" onclick="seleccionarMetodoPago('transferencia')">
                <i class="fa-solid fa-building-columns"></i>
                <span>Transferencia</span>
            </button>
        </div>
        <div class="cj-efectivo" id="datosEfectivo">
            <label for="efectivoRecibido">Efectivo recibido</label>
            <input type="number" id="efectivoRecibido" class="cj-input" min="0" step="0.01" placeholder="0.00">
            <div class="cj-cambio">
                <span>Cambio:</span>
                <span id="cambioValor">$0.00</span>
            </div>
        </div>
        <div class="cj-mensaje-pago" id="mensajePago"></div>
        <div class="lst-modal-botones">
            <button type="button" class="lst-btn-cancelar" onclick="cerrarModalCobro()">
                Cancelar
            </button>
            <button type="button" class="lst-btn-confirmar" id="botonConfirmarPago" onclick="confirmarPago()">
                <i class="fa-solid fa-check"></i>
                Confirmar pago
            </button>
        </div>
    </div>
</div>
<div class="lst-modal" id="modalVentaExitosa" role="dialog" aria-modal="true" aria-labelledby="tituloVenta">
    <div class="lst-modal-caja cj-centro">
        <div class="cj-modal-icono cj-icono-exito">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h2 id="tituloVenta">¡Venta registrada!</h2>
        <p>La venta se registró correctamente.</p>

        <div class="cj-folio">
            <span>Número de folio</span>
            <strong id="folioVenta">—</strong>
        </div>

        <div class="cj-botones">
            <button type="button" class="cj-btn" onclick="cerrarModalVentaExitosa()">
                <i class="fa-solid fa-check"></i>
                Aceptar
            </button>

            <button
                type="button"
                class="cj-btn cj-btn-verde"
                id="botonAbrirTicket"
                onclick="abrirTicket()"
                style="display:none;"
            >
                <i class="fa-solid fa-print"></i>
                Ver ticket
            </button>
        </div>
    </div>
</div>
<form id="formCerrarCaja" method="POST" action="{{ route('punto_venta.cerrar') }}" style="display:none;">
    @csrf
</form>

@push('scripts')
<script>
    let carrito = [];
    let clienteSeleccionado = null;
    let metodoPagoSeleccionado = null;
    let ticketUrlVenta = null;

    const clientes = @json($clientes ?? []);
    const puntoVentaId = @json(session('punto_venta_id'));
    const urlRegistrarVenta = @json(route('venta.store'));
    const csrfToken = @json(csrf_token());

    function agregarProducto(id, nombre, precio, foto, stock) {
        const producto = carrito.find(item => item.id === id);

        if (producto) {
            if (producto.cantidad >= stock) {
                alert(
                    'No puedes agregar más unidades de "' + nombre +
                    '". Existencia disponible: ' + stock
                );
                return;
            }
            producto.cantidad++;
        } else {
            if (stock <= 0) {
                alert('El servicio "' + nombre + '" no tiene existencia disponible.');
                return;
            }

            carrito.push({
                id: id,
                nombre: nombre,
                precio: parseFloat(precio),
                foto: foto,
                cantidad: 1,
                stock: stock
            });
        }

        mostrarCarrito();
        calcularTotal();
    }

    function mostrarCarrito() {
        const contenedor = document.getElementById('carrito');

        if (carrito.length === 0) {
            contenedor.innerHTML = `
                <div class="cj-carrito-vacio">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Agrega servicios a la venta.
                </div>
            `;
            return;
        }

        contenedor.innerHTML = '';

        carrito.forEach((producto, indice) => {

            const subtotalProducto = producto.precio * producto.cantidad;

            let imagen;

            if (producto.foto) {
                imagen = `<img src="/storage/${producto.foto}" alt="${escapeHtml(producto.nombre)}">`;
            } else {
                imagen = `<i class="fa-solid fa-concierge-bell"></i>`;
            }

            contenedor.innerHTML += `
                <div class="cj-producto">
                    <div class="cj-producto-info">
                        <div class="cj-producto-imagen">${imagen}</div>
                        <div>
                            <div class="cj-producto-nombre">${escapeHtml(producto.nombre)}</div>
                            <div class="cj-producto-precio">$${subtotalProducto.toFixed(2)}</div>
                        </div>
                    </div>

                    <div class="cj-controles">
                        <button type="button" class="cj-cantidad-btn" onclick="cambiarCantidad(${indice}, -1)">-</button>
                        <span class="cj-cantidad">${producto.cantidad}</span>
                        <button type="button" class="cj-cantidad-btn" onclick="cambiarCantidad(${indice}, 1)">+</button>
                        <button type="button" class="cj-eliminar" onclick="eliminarProducto(${indice})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function cambiarCantidad(indice, cambio) {

        const producto = carrito[indice];

        if (!producto) {
            return;
        }

        const nuevaCantidad = producto.cantidad + cambio;

        if (nuevaCantidad > producto.stock) {
            alert('No hay suficiente existencia. Disponible: ' + producto.stock);
            return;
        }

        producto.cantidad = nuevaCantidad;

        if (producto.cantidad <= 0) {
            carrito.splice(indice, 1);
        }

        mostrarCarrito();
        calcularTotal();
    }

    function eliminarProducto(indice) {
        carrito.splice(indice, 1);
        mostrarCarrito();
        calcularTotal();
    }

    function obtenerTotales() {

        let subtotal = 0;

        carrito.forEach(producto => {
            subtotal += producto.precio * producto.cantidad;
        });

        let descuentoPorcentaje = parseFloat(document.getElementById('descuento').value) || 0;
        let impuestoPorcentaje = parseFloat(document.getElementById('impuesto').value) || 0;

        descuentoPorcentaje = Math.min(Math.max(descuentoPorcentaje, 0), 100);
        impuestoPorcentaje = Math.min(Math.max(impuestoPorcentaje, 0), 100);

        const descuento = subtotal * (descuentoPorcentaje / 100);
        const subtotalConDescuento = subtotal - descuento;
        const impuesto = subtotalConDescuento * (impuestoPorcentaje / 100);
        const total = Math.max(0, subtotalConDescuento + impuesto);

        return {
            subtotal,
            descuentoPorcentaje,
            descuento,
            impuestoPorcentaje,
            impuesto,
            total
        };
    }

    function calcularTotal() {
        const totales = obtenerTotales();
        document.getElementById('subtotal').textContent = '$' + totales.subtotal.toFixed(2);
        document.getElementById('total').textContent = '$' + totales.total.toFixed(2);
        document.getElementById('botonCobrar').disabled = carrito.length === 0;
    }


    document.getElementById('descuento').addEventListener('input', calcularTotal);
    document.getElementById('impuesto').addEventListener('input', calcularTotal);

    document.getElementById('buscarServicio').addEventListener('input', function () {

        const texto = this.value.toLowerCase().trim();

        document.querySelectorAll('.cj-servicio').forEach(servicio => {
            servicio.style.display =
                servicio.dataset.nombre.includes(texto) ? '' : 'none';
        });
    });

    document.getElementById('buscarCliente').addEventListener('input', function () {

        const texto = this.value.toLowerCase().trim();
        const lista = document.getElementById('clientesLista');

        lista.innerHTML = '';

        if (!texto) {
            return;
        }

        const resultados = clientes.filter(cliente => {
            const nombre =
                ((cliente.name || '') + ' ' + (cliente.apellido || '')).toLowerCase();
            return nombre.includes(texto);
        });

        resultados.forEach(cliente => {

            const nombreCompleto =
                ((cliente.name || '') + ' ' + (cliente.apellido || '')).trim();

            const elemento = document.createElement('div');
            elemento.className = 'cj-cliente-opcion';

            elemento.innerHTML = `
                <strong>${escapeHtml(nombreCompleto)}</strong>
                <span>Cliente registrado</span>
            `;

            elemento.onclick = function () {
                seleccionarCliente(cliente.id, nombreCompleto);
            };

            lista.appendChild(elemento);
        });
    });

    function seleccionarCliente(id, nombre) {

        clienteSeleccionado = { id: id, nombre: nombre };

        document.getElementById('clienteNombre').textContent = nombre;
        document.getElementById('clienteSeleccionado').style.display = 'block';
        document.getElementById('clientesLista').innerHTML = '';
        document.getElementById('buscarCliente').value = nombre;
    }

    function abrirModalCliente() {
        document.getElementById('modalCliente').classList.add('activo');
    }

    function cerrarModalCliente() {
        document.getElementById('modalCliente').classList.remove('activo');
    }

    document.getElementById('formRegistrarCliente').addEventListener('submit', async function (event) {

        event.preventDefault();

        const formulario = this;
        const boton = formulario.querySelector('.boton-guardar');
        const textoOriginal = boton.innerHTML;

        boton.disabled = true;

        boton.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            Registrando...
        `;

        try {

            const respuesta = await fetch(formulario.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(formulario)
            });

            const resultado = await respuesta.json();

            if (!respuesta.ok || !resultado.success) {
                throw new Error(
                    resultado.message || 'No se pudo registrar el cliente.'
                );
            }

            const cliente = resultado.cliente;

            if (!cliente || !cliente.id) {
                throw new Error(
                    'El servidor registró el cliente, pero no devolvió sus datos.'
                );
            }

            clientes.push(cliente);

            const nombreCompleto =
                ((cliente.name || '') + ' ' + (cliente.apellido || '')).trim();

            seleccionarCliente(cliente.id, nombreCompleto);

            cerrarModalCliente();

            formulario.reset();

            const mensaje = document.getElementById('mensajeClienteRegistrado');

            document.getElementById('textoClienteRegistrado').textContent =
                nombreCompleto + ' fue agregado correctamente.';

            mensaje.classList.add('mostrar');

            setTimeout(function () {
                mensaje.classList.remove('mostrar');
            }, 4000);

        } catch (error) {

            console.error('Error al registrar cliente:', error);

            alert(error.message || 'Ocurrió un error al registrar el cliente.');

        } finally {

            boton.disabled = false;
            boton.innerHTML = textoOriginal;
        }
    });

    function toggleMenuPerfil() {
        document.getElementById('menuPerfil').classList.toggle('mostrar');
    }

    document.addEventListener('click', function (event) {

        const perfil = document.querySelector('.cj-perfil');
        const menu = document.getElementById('menuPerfil');

        if (perfil && !perfil.contains(event.target)) {
            menu.classList.remove('mostrar');
        }
    });

    function abrirModalCerrarCaja() {
        document.getElementById('menuPerfil').classList.remove('mostrar');
        document.getElementById('modalCerrarCaja').classList.add('activo');
    }

    function cerrarModalCerrarCaja() {
        document.getElementById('modalCerrarCaja').classList.remove('activo');
    }

    function cerrarCaja() {
        document.getElementById('formCerrarCaja').submit();
    }

    function confirmarSalidaCaja(event) {
        event.preventDefault();
        abrirModalCerrarCaja();
        return false;
    }

    function abrirModalCobro() {

        if (carrito.length === 0) {
            return;
        }

        const totales = obtenerTotales();

        document.getElementById('totalModalCobro').textContent =
            '$' + totales.total.toFixed(2);

        metodoPagoSeleccionado = null;

        document.querySelectorAll('.cj-metodo').forEach(boton => {
            boton.classList.remove('seleccionado');
        });

        document.getElementById('datosEfectivo').classList.remove('mostrar');
        document.getElementById('efectivoRecibido').value = '';
        document.getElementById('cambioValor').textContent = '$0.00';

        ocultarMensajePago();

        document.getElementById('modalCobro').classList.add('activo');
    }

    function cerrarModalCobro() {
        document.getElementById('modalCobro').classList.remove('activo');
    }

    function seleccionarMetodoPago(metodo) {

        metodoPagoSeleccionado = metodo;

        document.querySelectorAll('.cj-metodo').forEach(boton => {
            boton.classList.remove('seleccionado');
        });

        const boton = document.getElementById(
            'metodo' + metodo.charAt(0).toUpperCase() + metodo.slice(1)
        );

        if (boton) {
            boton.classList.add('seleccionado');
        }

        if (metodo === 'efectivo') {

            document.getElementById('datosEfectivo').classList.add('mostrar');
            document.getElementById('efectivoRecibido').focus();
            calcularCambio();

        } else {

            document.getElementById('datosEfectivo').classList.remove('mostrar');
            ocultarMensajePago();
        }
    }

    function calcularCambio() {

        const totales = obtenerTotales();

        const recibido =
            parseFloat(document.getElementById('efectivoRecibido').value) || 0;

        const cambio = recibido - totales.total;

        document.getElementById('cambioValor').textContent =
            '$' + Math.max(0, cambio).toFixed(2);

        if (recibido > 0 && recibido < totales.total) {
            mostrarMensajePago('El efectivo recibido es menor al total.');
        } else {
            ocultarMensajePago();
        }
    }

    document.getElementById('efectivoRecibido').addEventListener('input', calcularCambio);

    function mostrarMensajePago(mensaje) {

        const elemento = document.getElementById('mensajePago');

        elemento.textContent = mensaje;
        elemento.classList.add('mostrar');
    }

    function ocultarMensajePago() {
        document.getElementById('mensajePago').classList.remove('mostrar');
    }

    function mostrarModalVentaExitosa(folio, ticketUrl = null) {

        ticketUrlVenta = ticketUrl;

        document.getElementById('folioVenta').textContent = folio || '—';

        document.getElementById('botonAbrirTicket').style.display =
            ticketUrlVenta ? 'inline-flex' : 'none';

        document.getElementById('modalVentaExitosa').classList.add('activo');
    }

    function cerrarModalVentaExitosa() {
        document.getElementById('modalVentaExitosa').classList.remove('activo');
        ticketUrlVenta = null;
    }

    function abrirTicket() {

        if (!ticketUrlVenta) {
            return;
        }

        window.open(ticketUrlVenta, '_blank');
    }

    async function confirmarPago() {

        if (!metodoPagoSeleccionado) {
            mostrarMensajePago('Selecciona una forma de pago para continuar.');
            return;
        }

        if (!puntoVentaId) {
            mostrarMensajePago('No se encontró el punto de venta actual en la sesión.');
            return;
        }

        if (carrito.length === 0) {
            mostrarMensajePago('El carrito está vacío.');
            return;
        }

        const totales = obtenerTotales();

        let efectivoRecibido = null;
        let cambio = null;

        if (metodoPagoSeleccionado === 'efectivo') {

            efectivoRecibido =
                parseFloat(document.getElementById('efectivoRecibido').value) || 0;

            if (efectivoRecibido < totales.total) {
                mostrarMensajePago('El efectivo recibido no alcanza para cubrir el total.');
                return;
            }

            cambio = efectivoRecibido - totales.total;
        }

        const datosVenta = {
            punto_venta_id: parseInt(puntoVentaId),
            cliente_id: clienteSeleccionado ? clienteSeleccionado.id : null,
            subtotal: Number(totales.subtotal.toFixed(2)),
            descuento_porcentaje: Number(totales.descuentoPorcentaje.toFixed(2)),
            descuento: Number(totales.descuento.toFixed(2)),
            impuesto_porcentaje: Number(totales.impuestoPorcentaje.toFixed(2)),
            impuesto: Number(totales.impuesto.toFixed(2)),
            total: Number(totales.total.toFixed(2)),
            forma_pago: metodoPagoSeleccionado,
            metodo_pago: metodoPagoSeleccionado,

            efectivo_recibido:
                efectivoRecibido !== null
                    ? Number(efectivoRecibido.toFixed(2))
                    : null,

            cambio:
                cambio !== null
                    ? Number(cambio.toFixed(2))
                    : null,

            productos: carrito.map(producto => ({
                id: producto.id,
                cantidad: producto.cantidad,
                precio: Number(producto.precio.toFixed(2))
            }))
        };

        const boton = document.getElementById('botonConfirmarPago');

        boton.disabled = true;

        boton.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            Registrando...
        `;

        ocultarMensajePago();

        try {

            const respuesta = await fetch(urlRegistrarVenta, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(datosVenta)
            });

            const resultado = await respuesta.json();

            if (!respuesta.ok || !resultado.success) {
                throw new Error(
                    resultado.message || 'No se pudo registrar la venta.'
                );
            }

            carrito = [];
            clienteSeleccionado = null;

            document.getElementById('clienteSeleccionado').style.display = 'none';
            document.getElementById('buscarCliente').value = '';
            document.getElementById('descuento').value = '0';
            document.getElementById('impuesto').value = '0';

            mostrarCarrito();
            calcularTotal();
            cerrarModalCobro();

            mostrarModalVentaExitosa(
                resultado.folio,
                resultado.ticket_url || null
            );

        } catch (error) {

            console.error('Error al registrar venta:', error);

            mostrarMensajePago(
                error.message || 'Ocurrió un error al registrar la venta.'
            );

        } finally {

            boton.disabled = false;

            boton.innerHTML = `
                <i class="fa-solid fa-check"></i>
                Confirmar pago
            `;
        }
    }

    document.getElementById('modalCliente').addEventListener('click', function (event) {
        if (event.target === this) cerrarModalCliente();
    });

    document.getElementById('modalCerrarCaja').addEventListener('click', function (event) {
        if (event.target === this) cerrarModalCerrarCaja();
    });

    document.getElementById('modalCobro').addEventListener('click', function (event) {
        if (event.target === this) cerrarModalCobro();
    });

    document.getElementById('modalVentaExitosa').addEventListener('click', function (event) {
        if (event.target === this) cerrarModalVentaExitosa();
    });

    mostrarCarrito();
    calcularTotal();

</script>
@endpush

</x-layouts.panel>
