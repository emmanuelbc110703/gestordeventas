@props([
    'categorias',
    'seleccionada' => null,
])

@php
    $nuevaAnterior = old('categoria_nueva');
    $idInicial = $nuevaAnterior ? null : old('categoria_id', $seleccionada);
    $textoInicial = $nuevaAnterior ?: optional($categorias->firstWhere('id', (int) $idInicial))->nombre;
@endphp

<style>
    .selcat { position: relative; }

    .selcat-lista {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        z-index: 50;
        max-height: 240px;
        overflow-y: auto;
        margin: 0;
        padding: 4px 0;
        list-style: none;
        background: #fff;
        border: 1px solid var(--borde);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .selcat-lista[hidden] { display: none; }

    .selcat-opcion {
        display: block;
        width: 100%;
        padding: 10px 14px;
        background: none;
        border: none;
        border-radius: 0;
        font: inherit;
        font-size: 14px;
        color: var(--texto);
        text-align: left;
        cursor: pointer;
    }

    .selcat-opcion:hover,
    .selcat-opcion.activa { background: var(--primario-suave); color: var(--primario-oscuro); }

    .selcat-opcion.crear { font-weight: 600; color: var(--primario); border-top: 1px solid var(--borde); }
    .selcat-lista li:first-child .selcat-opcion.crear { border-top: none; }

    .selcat-vacio { padding: 10px 14px; font-size: 13px; color: var(--texto-suave); }

    .selcat-aviso {
        margin-top: 6px;
        font-size: 12px;
        color: var(--texto-suave);
    }

    .selcat-aviso.nueva { color: var(--primario); font-weight: 600; }
    .selcat-aviso.error { color: #b91c1c; }
</style>

<div class="selcat" data-selcat>
    <div class="campo-control">
        <input
            type="text"
            id="categoria_texto"
            value="{{ $textoInicial }}"
            placeholder="Busca o escribe una categoría"
            autocomplete="off"
            role="combobox"
            aria-expanded="false"
            aria-controls="selcatLista"
        >
        <i class="fa-solid fa-chevron-down icono-select"></i>
    </div>

    <input type="hidden" name="categoria_id" value="{{ $idInicial }}" data-selcat-id>
    <input type="hidden" name="categoria_nueva" value="{{ $nuevaAnterior }}" data-selcat-nueva>

    <ul class="selcat-lista" id="selcatLista" role="listbox" hidden></ul>

    <div class="selcat-aviso {{ $nuevaAnterior ? 'nueva' : '' }}" data-selcat-aviso>
        @if($nuevaAnterior) Se creará la categoría "{{ $nuevaAnterior }}" al guardar. @endif
    </div>
</div>

<script>
(function () {
    const raiz = document.querySelector('[data-selcat]');
    if (!raiz || raiz.dataset.listo) return;
    raiz.dataset.listo = '1';

    const opciones = @json($categorias->map(fn ($c) => ['id' => $c->id, 'nombre' => $c->nombre])->values());

    const texto = raiz.querySelector('#categoria_texto');
    const campoId = raiz.querySelector('[data-selcat-id]');
    const campoNueva = raiz.querySelector('[data-selcat-nueva]');
    const lista = raiz.querySelector('.selcat-lista');
    const aviso = raiz.querySelector('[data-selcat-aviso]');
    const formulario = raiz.closest('form');

    const norm = t => (t || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    let activa = -1;

    function avisar(mensaje, clase) {
        aviso.textContent = mensaje || '';
        aviso.className = 'selcat-aviso' + (clase ? ' ' + clase : '');
    }

    function coincidenciaExacta(valor) {
        const n = norm(valor);
        return n ? opciones.find(o => norm(o.nombre) === n) : null;
    }

    function elegirExistente(o) {
        texto.value = o.nombre;
        campoId.value = o.id;
        campoNueva.value = '';
        avisar('');
        cerrar();
    }

    function elegirNueva(nombre) {
        const limpio = nombre.replace(/\s+/g, ' ').trim();
        texto.value = limpio;
        campoId.value = '';
        campoNueva.value = limpio;
        avisar('Se creará la categoría "' + limpio + '" al guardar.', 'nueva');
        cerrar();
    }

    function cerrar() {
        lista.hidden = true;
        texto.setAttribute('aria-expanded', 'false');
        activa = -1;
    }

    function pintar() {
        const q = norm(texto.value);
        const visibles = opciones.filter(o => !q || norm(o.nombre).includes(q));
        const exacta = coincidenciaExacta(texto.value);

        lista.innerHTML = '';

        visibles.forEach(o => {
            const li = document.createElement('li');
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'selcat-opcion';
            b.textContent = o.nombre;
            b.addEventListener('mousedown', e => { e.preventDefault(); elegirExistente(o); });
            li.appendChild(b);
            lista.appendChild(li);
        });

        if (texto.value.trim() && !exacta) {
            const li = document.createElement('li');
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'selcat-opcion crear';
            b.textContent = 'Crear "' + texto.value.replace(/\s+/g, ' ').trim() + '"';
            b.addEventListener('mousedown', e => { e.preventDefault(); elegirNueva(texto.value); });
            li.appendChild(b);
            lista.appendChild(li);
        }

        if (!lista.children.length) {
            const li = document.createElement('li');
            li.className = 'selcat-vacio';
            li.textContent = 'Aún no hay categorías. Escribe el nombre para crear una.';
            lista.appendChild(li);
        }

        activa = -1;
        lista.hidden = false;
        texto.setAttribute('aria-expanded', 'true');
    }

    texto.addEventListener('focus', pintar);

    texto.addEventListener('input', () => {
        const exacta = coincidenciaExacta(texto.value);
        campoNueva.value = '';
        campoId.value = exacta ? exacta.id : '';
        avisar('');
        pintar();
    });

    texto.addEventListener('keydown', e => {
        const items = Array.from(lista.querySelectorAll('.selcat-opcion'));

        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
            e.preventDefault();
            if (lista.hidden) pintar();
            if (!items.length) return;
            activa = e.key === 'ArrowDown' ? (activa + 1) % items.length : (activa - 1 + items.length) % items.length;
            items.forEach((it, i) => it.classList.toggle('activa', i === activa));
            items[activa].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter') {
            if (!lista.hidden && activa >= 0 && items[activa]) {
                e.preventDefault();
                items[activa].dispatchEvent(new MouseEvent('mousedown', { bubbles: true, cancelable: true }));
            }
        } else if (e.key === 'Escape') {
            cerrar();
        }
    });

    texto.addEventListener('blur', cerrar);
    raiz.querySelector('.icono-select').addEventListener('mousedown', e => { e.preventDefault(); texto.focus(); });

    if (formulario) {
        formulario.addEventListener('submit', e => {
            if (campoId.value || campoNueva.value) return;

            const exacta = coincidenciaExacta(texto.value);
            if (exacta) { campoId.value = exacta.id; return; }

            if (texto.value.trim()) {
                e.preventDefault();
                avisar('Elige una categoría de la lista o confirma "Crear" para registrarla.', 'error');
                texto.focus();
                pintar();
            }
        });
    }
})();
</script>