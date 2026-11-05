<x-layouts.panel
    titulo="Respaldos"
    :migas="[['texto' => 'Respaldos', 'url' => null]]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .rs-aviso {
        padding: 12px 16px; margin-bottom: 16px; font-size: 14px;
        background: #fff7ed; border: 1px solid #fed7aa; color: #9a3412;
    }
    .rs-carga {
        display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between;
        background: #fff; border: 1px solid var(--borde); padding: 14px 20px; margin-bottom: 20px;
    }
    .rs-carga strong { display: block; font-size: 14px; color: var(--texto); }
    .rs-carga span { font-size: 13px; color: var(--texto-suave); }
    .rs-carga form { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .rs-carga input[type=file] { font-size: 13px; max-width: 260px; }
    .rs-tipo { font-size: 12px; color: var(--texto-suave); }
    .rs-nombre { font-weight: 600; color: var(--texto); word-break: break-all; }
    .rs-acciones { display: flex; gap: 6px; justify-content: flex-end; }
    .rs-btn {
        display: inline-flex; align-items: center; gap: 6px; height: 32px; padding: 0 12px;
        font-size: 13px; font-weight: 600; border: 1px solid var(--borde); background: #fff;
        color: var(--texto); cursor: pointer; text-decoration: none; font-family: inherit;
    }
    .rs-btn:hover { background: #f3f4f6; }
    .rs-btn.advertencia { color: #9a3412; border-color: #fed7aa; }
    .rs-btn.advertencia:hover { background: #fff7ed; }
    @media (max-width: 700px) { .rs-carga input[type=file] { max-width: 100%; } }
</style>
@endpush

<x-sidebar activo="respaldos" />
<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Respaldos</h1>
            </div>
            <p>Crea copias de seguridad de la base de datos y restáuralas cuando lo necesites.</p>
        </div>
        @if($disponible)
            <form method="POST" action="{{ route('admin.respaldos.crear') }}">
                @csrf
                <button type="submit" class="lst-btn-principal">Crear respaldo ahora</button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="lst-mensaje exito">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="lst-mensaje error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="lst-mensaje error">{{ $errors->first() }}</div>
    @endif

    @unless($disponible)
        <div class="rs-aviso">
            El respaldo desde el sistema solo está disponible cuando la base de datos es SQLite.
        </div>
    @else
        <div class="rs-carga">
            <div>
                <strong>Restaurar desde un archivo</strong>
                <span>Sube un respaldo (.sqlite) descargado anteriormente. Se guardará una copia del estado actual antes de restaurar.</span>
            </div>
            <form method="POST" action="{{ route('admin.respaldos.restaurar_archivo') }}" enctype="multipart/form-data" id="formArchivo">
                @csrf
                <input type="file" name="archivo" id="archivoRespaldo" accept=".sqlite,.db,.sqlite3" required>
                <button type="button" class="rs-btn advertencia" id="btnSubir">
                    <i class="fa-solid fa-rotate-left"></i> Restaurar archivo
                </button>
            </form>
        </div>

        @if(count($respaldos))
            <div class="lst-tabla-wrap">
                <table class="lst-tabla">
                    <thead>
                        <tr>
                            <th>Respaldo</th>
                            <th>Fecha</th>
                            <th>Tamaño</th>
                            <th style="text-align:right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($respaldos as $r)
                            <tr>
                                <td data-label="Respaldo">
                                    <div class="rs-nombre">{{ $r['nombre'] }}</div>
                                    <div class="rs-tipo">{{ $r['tipo'] }}</div>
                                </td>
                                <td data-label="Fecha">{{ $r['fecha']->format('d/m/Y H:i') }}</td>
                                <td data-label="Tamaño">{{ number_format($r['tamano'] / 1024, 1) }} KB</td>
                                <td data-label="Acciones">
                                    <div class="rs-acciones">
                                        <a href="{{ route('admin.respaldos.descargar', $r['nombre']) }}"
                                           class="rs-btn" title="Descargar" aria-label="Descargar {{ $r['nombre'] }}">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <button type="button" class="rs-btn advertencia btn-restaurar"
                                                data-nombre="{{ $r['nombre'] }}"
                                                data-url="{{ route('admin.respaldos.restaurar', $r['nombre']) }}">
                                            <i class="fa-solid fa-rotate-left"></i> Restaurar
                                        </button>
                                        <button type="button" class="lst-btn-eliminar btn-eliminar" title="Eliminar"
                                                aria-label="Eliminar {{ $r['nombre'] }}"
                                                data-nombre="{{ $r['nombre'] }}"
                                                data-url="{{ route('admin.respaldos.eliminar', $r['nombre']) }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="lst-vacio" style="display:block;">Aún no hay respaldos. Crea el primero con el botón "Crear respaldo ahora".</div>
        @endif
    @endunless
</div>

<div class="lst-modal" id="modalRespaldo" role="dialog" aria-modal="true" aria-labelledby="tituloModalRespaldo">
    <div class="lst-modal-caja">
        <h2 id="tituloModalRespaldo"></h2>
        <p id="mensajeModalRespaldo"></p>

        <form id="formModalRespaldo" method="POST">
            @csrf
            <input type="hidden" name="_method" id="metodoModalRespaldo" value="POST">
            <div class="lst-modal-botones">
                <button type="button" class="lst-btn-cancelar" id="btnCancelarModal">Cancelar</button>
                <button type="submit" class="lst-btn-confirmar" id="btnConfirmarModal"></button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const modal = document.getElementById('modalRespaldo');
    const form = document.getElementById('formModalRespaldo');
    const metodo = document.getElementById('metodoModalRespaldo');
    const titulo = document.getElementById('tituloModalRespaldo');
    const mensaje = document.getElementById('mensajeModalRespaldo');
    const confirmar = document.getElementById('btnConfirmarModal');
    let alConfirmar = null;

    function abrir(cfg) {
        titulo.textContent = cfg.titulo;
        mensaje.textContent = cfg.mensaje;
        confirmar.textContent = cfg.boton;
        form.action = cfg.url || '';
        metodo.value = cfg.metodo || 'POST';
        alConfirmar = cfg.enviarArchivo || null;
        modal.classList.add('activo');
    }
    const cerrar = () => modal.classList.remove('activo');

    document.getElementById('btnCancelarModal').addEventListener('click', cerrar);
    modal.addEventListener('click', e => { if (e.target === modal) cerrar(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrar(); });

    form.addEventListener('submit', e => {
        if (alConfirmar) { e.preventDefault(); alConfirmar(); }
    });

    document.querySelectorAll('.btn-restaurar').forEach(b => b.addEventListener('click', () => abrir({
        titulo: 'Restaurar respaldo',
        mensaje: 'Se reemplazará TODA la información actual por la de "' + b.dataset.nombre
            + '". Antes se guardará automáticamente una copia del estado actual. ¿Deseas continuar?',
        boton: 'Sí, restaurar',
        url: b.dataset.url,
    })));

    document.querySelectorAll('.btn-eliminar').forEach(b => b.addEventListener('click', () => abrir({
        titulo: 'Eliminar respaldo',
        mensaje: '¿Eliminar definitivamente "' + b.dataset.nombre + '"? Esta acción no se puede deshacer.',
        boton: 'Sí, eliminar',
        url: b.dataset.url,
        metodo: 'DELETE',
    })));

    const btnSubir = document.getElementById('btnSubir');
    if (btnSubir) {
        btnSubir.addEventListener('click', () => {
            const archivo = document.getElementById('archivoRespaldo');
            if (!archivo.files.length) { archivo.click(); return; }
            abrir({
                titulo: 'Restaurar desde archivo',
                mensaje: 'Se reemplazará TODA la información actual por la del archivo "' + archivo.files[0].name
                    + '". Antes se guardará automáticamente una copia del estado actual. ¿Deseas continuar?',
                boton: 'Sí, restaurar',
                enviarArchivo: () => document.getElementById('formArchivo').submit(),
            });
        });
    }
})();
</script>
@endpush

</x-layouts.panel>