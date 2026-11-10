@php
    $usuario = auth()->user();
    $colorPerfil = $usuario->color_perfil ?? '#6a1b9a';
    $inicial = strtoupper(substr($usuario->name, 0, 1));

    $nacimiento = $usuario->fecha_nacimiento;
    $nacimientoTexto = $nacimiento
        ? (method_exists($nacimiento, 'format') ? $nacimiento->format('d/m/Y') : $nacimiento)
        : null;

    $colores = [
        '#6a1b9a' => 'Morado',
        '#2196F3' => 'Azul',
        '#F44336' => 'Rojo',
        '#4CAF50' => 'Verde',
        '#FF9800' => 'Naranja',
        '#263238' => 'Oscuro',
    ];

    $datos = [
        ['icono' => 'fa-user',          'etiqueta' => 'Nombre',               'valor' => $usuario->name],
        ['icono' => 'fa-user',          'etiqueta' => 'Apellidos',            'valor' => $usuario->apellido],
        ['icono' => 'fa-envelope',      'etiqueta' => 'Correo electrónico',   'valor' => $usuario->email],
        ['icono' => 'fa-phone',         'etiqueta' => 'Teléfono',             'valor' => $usuario->telefono],
        ['icono' => 'fa-location-dot',  'etiqueta' => 'Dirección',            'valor' => $usuario->direccion],
        ['icono' => 'fa-calendar',      'etiqueta' => 'Fecha de nacimiento',  'valor' => $nacimientoTexto],
    ];
@endphp

<x-layouts.panel
    titulo="Mi información"
    :migas="[['texto' => 'Mi información', 'url' => null]]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .mi-grid {
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .mi-card {
        background: #fff;
        border: 1px solid var(--borde, #e5e7eb);
        border-radius: 8px;
    }
    .mi-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--borde, #e5e7eb);
    }
    .mi-card-head h2 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: var(--texto, #1f2937);
    }

    /* ---------- Perfil ---------- */
    .mi-perfil {
        padding: 28px 20px 24px;
        text-align: center;
    }
    .mi-avatar-wrap {
        position: relative;
        width: 104px;
        margin: 0 auto 16px;
    }
    .mi-avatar {
        width: 104px;
        height: 104px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        color: #fff;
        font-size: 40px;
        font-weight: 600;
        border: 1px solid var(--borde, #e5e7eb);
    }
    .mi-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .mi-btn-foto {
        position: absolute;
        right: -2px;
        bottom: -2px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #fff;
        background: var(--texto, #1f2937);
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mi-btn-foto:hover { background: #000; }

    .mi-cerrar-sesion { padding: 0 20px 20px; }
    .mi-btn-salir {
        width: 100%;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 10px 14px;
        background: #fff; color: #b91c1c;
        border: 1px solid #fecaca; border-radius: 8px;
        font: inherit; font-weight: 600; cursor: pointer;
        transition: background 0.2s ease;
    }
    .mi-btn-salir:hover { background: #fef2f2; }

    .mi-pop {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        left: 50%;
        transform: translateX(-50%);
        width: 220px;
        background: #fff;
        border: 1px solid var(--borde, #e5e7eb);
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .12);
        text-align: left;
        z-index: 30;
    }
    .mi-pop.mostrar { display: block; }
    .mi-pop-item {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 10px 14px;
        border: none;
        background: none;
        font: inherit;
        font-size: 13px;
        color: var(--texto, #1f2937);
        cursor: pointer;
    }
    .mi-pop-item + .mi-pop-item { border-top: 1px solid var(--borde, #e5e7eb); }
    .mi-pop-item:hover { background: #f9fafb; }
    .mi-pop-item i { width: 16px; color: var(--texto-suave, #6b7280); }

    .mi-pop-colores { padding: 14px; }
    .mi-pop-colores p {
        margin: 0 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--texto, #1f2937);
    }
    .mi-colores { display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; }
    .mi-color {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px var(--borde, #d1d5db);
        cursor: pointer;
        padding: 0;
    }
    .mi-color:hover { box-shadow: 0 0 0 2px var(--texto-suave, #6b7280); }
    .mi-color.actual { box-shadow: 0 0 0 2px var(--texto, #1f2937); }

    .mi-nombre {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--texto, #1f2937);
    }
    .mi-empresa {
        margin: 4px 0 12px;
        font-size: 13px;
        color: var(--texto-suave, #6b7280);
    }
    .mi-rol {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 999px;
        background: var(--primario-suave, #f3e8f8);
        color: var(--primario-oscuro, #4a126d);
    }

    .mi-contacto {
        border-top: 1px solid var(--borde, #e5e7eb);
        padding: 14px 20px;
        font-size: 13px;
    }
    .mi-contacto div {
        display: flex;
        gap: 10px;
        align-items: baseline;
        color: var(--texto, #1f2937);
        word-break: break-word;
    }
    .mi-contacto div + div { margin-top: 8px; }
    .mi-contacto i { width: 14px; color: var(--texto-suave, #6b7280); }

    /* ---------- Datos ---------- */
    .mi-campos {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 24px;
        padding: 20px;
    }
    .mi-campo small {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        color: var(--texto-suave, #6b7280);
    }
    .mi-valor {
        min-height: 36px;
        padding: 8px 12px;
        font-size: 14px;
        color: var(--texto, #1f2937);
        background: #f9fafb;
        border: 1px solid var(--borde, #e5e7eb);
        border-radius: 6px;
        word-break: break-word;
    }
    .mi-valor.vacio { color: var(--texto-suave, #9ca3af); }

    .gx-alerta {
        padding: 12px 16px;
        margin-bottom: 16px;
        font-size: 14px;
        background: #ecfdf3;
        border: 1px solid #abefc6;
        border-radius: 6px;
        color: #067647;
    }

    .mi-oculto { display: none; }

    @media (max-width: 900px) {
        .mi-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 560px) {
        .mi-campos { grid-template-columns: 1fr; }
    }
</style>
@endpush

<x-sidebar activo="informacion" />

<div class="lst-pagina">

    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Mi información</h1>
            </div>
            <p>Consulta los datos de tu cuenta y personaliza tu perfil.</p>
        </div>
        <a href="{{ route('admin.informacion.editar') }}" class="lst-btn-principal">Editar información</a>
    </div>

    @if(session('success'))
        <div class="gx-alerta">{{ session('success') }}</div>
    @endif

    <div class="mi-grid">
        <aside class="mi-card">
            <div class="mi-perfil">

                <div class="mi-avatar-wrap">
                    <div class="mi-avatar" style="background-color: {{ $colorPerfil }};">
                        @if($usuario->foto_perfil)
                            <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Foto de perfil">
                        @else
                            {{ $inicial }}
                        @endif
                    </div>

                    <button type="button" class="mi-btn-foto" id="botonEditarFoto"
                            title="Editar foto de perfil" aria-label="Editar foto de perfil"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <div class="mi-pop" id="menuFoto">
                        <button type="button" class="mi-pop-item" id="subirFoto">
                            <i class="fa-solid fa-camera"></i> Subir foto
                        </button>
                        <button type="button" class="mi-pop-item" id="cambiarColor">
                            <i class="fa-solid fa-palette"></i> Cambiar color
                        </button>
                    </div>

                    {{-- Selector de color --}}
                    <div class="mi-pop mi-pop-colores" id="panelColores">
                        <form id="formularioColor" action="{{ route('admin.color.actualizar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="color_perfil" id="colorPerfilSeleccionado">
                            <p>Color del perfil</p>
                            <div class="mi-colores">
                                @foreach($colores as $hex => $nombre)
                                    <button type="button"
                                            class="mi-color {{ strtolower($hex) === strtolower($colorPerfil) ? 'actual' : '' }}"
                                            data-color="{{ $hex }}"
                                            style="background-color: {{ $hex }};"
                                            title="{{ $nombre }}" aria-label="{{ $nombre }}"></button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                    <form id="formularioFoto" class="mi-oculto" action="{{ route('admin.foto.actualizar') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="inputFotoPerfil" name="foto_perfil" accept="image/*">
                    </form>
                </div>

                <h2 class="mi-nombre">{{ $usuario->name }} {{ $usuario->apellido }}</h2>
                <p class="mi-empresa">Orquídeas y más "Los Amates"</p>
                <span class="mi-rol"><i class="fa-solid fa-shield-halved"></i> Administrador</span>
            </div>

            <div class="mi-contacto">
                <div><i class="fa-solid fa-envelope"></i> {{ $usuario->email }}</div>
                <div><i class="fa-solid fa-phone"></i> {{ $usuario->telefono ?: 'Teléfono no registrado' }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mi-cerrar-sesion">
                @csrf
                <button type="submit" class="mi-btn-salir">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                </button>
            </form>
        </aside>
        <section class="mi-card">
            <div class="mi-card-head">
                <h2>Datos personales</h2>
            </div>

            <div class="mi-campos">
                @foreach($datos as $dato)
                    <div class="mi-campo">
                        <small>{{ $dato['etiqueta'] }}</small>
                        <div class="mi-valor {{ $dato['valor'] ? '' : 'vacio' }}">
                            {{ $dato['valor'] ?: 'Sin registrar' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</div>

@push('scripts')
<script>
(function () {
    const botonEditar = document.getElementById('botonEditarFoto');
    const menuFoto = document.getElementById('menuFoto');
    const panelColores = document.getElementById('panelColores');
    const inputFoto = document.getElementById('inputFotoPerfil');
    const formFoto = document.getElementById('formularioFoto');
    const formColor = document.getElementById('formularioColor');
    const colorInput = document.getElementById('colorPerfilSeleccionado');

    function cerrar() {
        menuFoto.classList.remove('mostrar');
        panelColores.classList.remove('mostrar');
        botonEditar.setAttribute('aria-expanded', 'false');
    }

    botonEditar.addEventListener('click', e => {
        e.stopPropagation();
        const abierto = menuFoto.classList.toggle('mostrar');
        panelColores.classList.remove('mostrar');
        botonEditar.setAttribute('aria-expanded', abierto ? 'true' : 'false');
    });

    document.getElementById('subirFoto').addEventListener('click', e => {
        e.stopPropagation();
        inputFoto.click();
    });

    inputFoto.addEventListener('change', () => {
        if (inputFoto.files.length > 0) formFoto.submit();
    });

    document.getElementById('cambiarColor').addEventListener('click', e => {
        e.stopPropagation();
        menuFoto.classList.remove('mostrar');
        panelColores.classList.add('mostrar');
    });

    document.querySelectorAll('.mi-color').forEach(op => {
        op.addEventListener('click', e => {
            e.stopPropagation();
            colorInput.value = op.dataset.color;
            formColor.submit();
        });
    });

    document.addEventListener('click', e => {
        if (!menuFoto.contains(e.target) && !panelColores.contains(e.target) && !botonEditar.contains(e.target)) {
            cerrar();
        }
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrar(); });
})();
</script>
@endpush

</x-layouts.panel>