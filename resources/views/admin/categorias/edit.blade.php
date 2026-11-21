<x-layouts.panel
    titulo="Editar categoría"
    :migas="[
        ['texto' => 'Categorías', 'url' => route('admin.categorias.index')],
        ['texto' => 'Editar', 'url' => null],
    ]"
>

<x-formulario-estilos />

<x-sidebar activo="categorias" />

@include('admin.categorias._formulario', [
    'categoria'  => $categoria,
    'action'     => route('admin.categorias.update', $categoria->id),
    'titulo'     => 'Editar categoría',
    'subtitulo'  => 'Modifica los datos de la categoría.',
    'textoBoton' => 'Guardar cambios',
])

</x-layouts.panel>