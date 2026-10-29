<?php
return [

    'Administración' => [
        ['clave' => 'dashboard',     'texto' => 'Menú Principal',     'icono' => 'fa-table-cells-large', 'ruta' => 'admin.dashboard'],
        ['clave' => 'inventario',    'texto' => 'Inventario',         'icono' => 'fa-boxes-stacked',     'ruta' => 'admin.inventario'],
        ['clave' => 'puntos_venta',  'texto' => 'Puntos de venta',    'icono' => 'fa-store',             'ruta' => 'admin.puntos_venta'],
        ['clave' => 'empleados',     'texto' => 'Empleados',          'icono' => 'fa-id-badge',          'ruta' => 'admin.empleados'],
        ['clave' => 'clientes',      'texto' => 'Clientes',           'icono' => 'fa-user-group',        'ruta' => 'admin.clientes'],
        ['clave' => 'pedidos',       'texto' => 'Pedidos',            'icono' => 'fa-file-lines',        'ruta' => 'admin.cotizaciones'],
        ['clave' => 'gastos',        'texto' => 'Gastos comerciales', 'icono' => 'fa-wallet',            'ruta' => 'admin.gastos_comerciales'],
        ['clave' => 'cuenta',        'texto' => 'Cuenta del negocio', 'icono' => 'fa-building-columns',  'ruta' => null],
        ['clave' => 'pagos',         'texto' => 'Pago de servicios',  'icono' => 'fa-file-invoice',      'ruta' => 'admin.pago_servicios.index'],
    ],

    'Mi cuenta' => [
        ['clave' => 'informacion',   'texto' => 'Mi información',     'icono' => 'fa-circle-user',       'ruta' => 'admin.informacion'],
        ['clave' => 'configuracion', 'texto' => 'Configuración',      'icono' => 'fa-gear',              'ruta' => null],
    ],

];