@php
    $usuario = auth()->user();
    $modulos = [];
    foreach (config('modulos', []) as $seccion => $items) {
        foreach ($items as $item) {
            if (empty($item['ruta'])) continue;
            $modulos[] = [
                'texto'   => $item['texto'],
                'icono'   => $item['icono'],
                'url'     => route($item['ruta']),
                'seccion' => $seccion,
            ];
        }
    }

    if ($usuario && $usuario->puntoVenta) {
        $modulos[] = [
            'texto'   => 'Punto de venta',
            'icono'   => 'fa-cash-register',
            'url'     => route('empleado.punto_venta'),
            'seccion' => 'Mi cuenta',
        ];
    }
@endphp

<style>
    .buscador-modulos {
        position: relative;
        width: 280px;
    }
    .bm-lupa {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        color: #9ca3af;
        pointer-events: none;
    }
    .buscador-modulos input {
        width: 100%;
        height: 40px;
        padding: 0 60px 0 36px;
        background: #f9fafb;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .buscador-modulos input::placeholder { color: #9ca3af; }
    .buscador-modulos input:focus {
        background: #fff;
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .bm-atajo {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        padding: 1px 6px;
        background: #eef0f4;
        border: 1px solid var(--borde);
        font-size: 11px;
        font-weight: 500;
        color: var(--texto-suave);
        pointer-events: none;
    }

    /* ===== LISTA DESPLEGABLE ===== */
    .bm-lista {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        width: 300px;
        max-width: calc(100vw - 32px);
        max-height: 340px;
        margin: 0;
        padding: 6px;
        overflow-y: auto;
        list-style: none;
        background: #fff;
        border: 1px solid var(--borde);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        z-index: 700;
    }
    .bm-lista.abierta { display: block; }
    .bm-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        font-size: 14px;
        color: var(--texto);
        text-decoration: none;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .bm-item i {
        width: 16px;
        text-align: center;
        font-size: 14px;
        color: #8b93a1;
    }
    .bm-item small {
        margin-left: auto;
        font-size: 11px;
        color: #9ca3af;
    }
    .bm-item:hover,
    .bm-item.activo {
        background: var(--primario-suave);
        color: var(--primario);
    }
    .bm-item:hover i,
    .bm-item.activo i { color: var(--primario); }
    .bm-vacio {
        padding: 14px 12px;
        font-size: 13px;
        text-align: center;
        color: var(--texto-suave);
    }

    @media (max-width: 900px) { .buscador-modulos { width: 200px; } }
    @media (max-width: 700px) { .buscador-modulos { width: 150px; } .bm-atajo { display: none; } .buscador-modulos input { padding-right: 12px; } }
    @media (max-width: 520px) { .buscador-modulos { width: 120px; } }
</style>

<div class="buscador-modulos" id="bmContenedor">
    <i class="fa-solid fa-magnifying-glass bm-lupa"></i>

    <input
        type="text"
        id="bmEntrada"
        placeholder="Buscar módulo..."
        autocomplete="off"
        aria-label="Buscar módulo"
        aria-expanded="false"
        aria-controls="bmLista"
    >

    <span class="bm-atajo" id="bmAtajo">⌘K</span>
    <ul class="bm-lista" id="bmLista">
        @foreach($modulos as $modulo)
            <li>
                <a href="{{ $modulo['url'] }}" class="bm-item" data-texto="{{ $modulo['texto'] }}">
                    <i class="fa-solid {{ $modulo['icono'] }}"></i>
                    <span>{{ $modulo['texto'] }}</span>
                    <small>{{ $modulo['seccion'] }}</small>
                </a>
            </li>
        @endforeach

        <li class="bm-vacio" id="bmVacio" style="display: none;">Sin resultados</li>
    </ul>
</div>

<script>
    (function () {
        var contenedor = document.getElementById('bmContenedor');
        var entrada = document.getElementById('bmEntrada');
        var lista = document.getElementById('bmLista');
        var vacio = document.getElementById('bmVacio');
        var atajo = document.getElementById('bmAtajo');
        var items = Array.prototype.slice.call(lista.querySelectorAll('.bm-item'));
        var indice = -1;

        if (!/Mac|iPhone|iPad/.test(navigator.platform)) atajo.textContent = 'Ctrl K';

        function normalizar(texto) {
            return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
        }

        function visibles() {
            return items.filter(function (a) { return a.parentElement.style.display !== 'none'; });
        }

        function marcar() {
            visibles().forEach(function (a, i) {
                a.classList.toggle('activo', i === indice);
                if (i === indice) a.scrollIntoView({ block: 'nearest' });
            });
        }

        function filtrar() {
            var consulta = normalizar(entrada.value);
            var cantidad = 0;

            items.forEach(function (a) {
                var coincide = normalizar(a.dataset.texto).includes(consulta);
                a.parentElement.style.display = coincide ? '' : 'none';
                if (coincide) cantidad++;
            });

            vacio.style.display = cantidad ? 'none' : 'block';
            indice = -1;
            marcar();
        }

        function abrir() {
            lista.classList.add('abierta');
            entrada.setAttribute('aria-expanded', 'true');
        }

        function cerrar() {
            lista.classList.remove('abierta');
            entrada.setAttribute('aria-expanded', 'false');
            indice = -1;
            marcar();
        }

        entrada.addEventListener('focus', function () { filtrar(); abrir(); });
        entrada.addEventListener('input', function () { filtrar(); abrir(); });
        entrada.addEventListener('keydown', function (evento) {
            var lista_visible = visibles();

            if (evento.key === 'ArrowDown') {
                evento.preventDefault();
                if (lista_visible.length) { indice = (indice + 1) % lista_visible.length; marcar(); }
            } else if (evento.key === 'ArrowUp') {
                evento.preventDefault();
                if (lista_visible.length) { indice = (indice - 1 + lista_visible.length) % lista_visible.length; marcar(); }
            } else if (evento.key === 'Enter') {
                evento.preventDefault();
                var destino = lista_visible[indice >= 0 ? indice : 0];
                if (destino) window.location.href = destino.href;
            } else if (evento.key === 'Escape') {
                cerrar();
                entrada.blur();
            }
        });

        document.addEventListener('click', function (evento) {
            if (!contenedor.contains(evento.target)) cerrar();
        });

        document.addEventListener('keydown', function (evento) {
            if ((evento.ctrlKey || evento.metaKey) && evento.key.toLowerCase() === 'k') {
                evento.preventDefault();
                entrada.focus();
                entrada.select();
            }
        });
    })();
</script>