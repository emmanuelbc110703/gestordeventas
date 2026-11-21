<x-layouts.panel
    titulo="Registrar categoría"
    :migas="[
        ['texto' => 'Categorías', 'url' => route('admin.categorias.index')],
        ['texto' => 'Registrar', 'url' => null],
    ]"
>

<x-formulario-estilos />

<x-sidebar activo="categorias" />

@include('admin.categorias._formulario', [
    'action'      => route('admin.categorias.store'),
    'titulo'      => 'Registrar categoría',
    'subtitulo'   => 'Agrega una categoría para clasificar bienes, servicios o gastos.',
    'textoBoton'  => 'Guardar categoría',
    'tipoInicial' => $tipoInicial ?? '',
])

</x-layouts.panel>