<?php
return [
    'admin' =>[
        'Administración' => [
            ['clave' => 'dashboard',     'texto' => 'Menú Principal',     'icono' => 'fa-table-cells-large', 'ruta' => 'admin.dashboard'],
            ['clave' => 'inventario',    'texto' => 'Inventario',         'icono' => 'fa-boxes-stacked',     'ruta' => 'admin.inventario'],
            ['clave' => 'puntos_venta',  'texto' => 'Puntos de venta',    'icono' => 'fa-store',             'ruta' => 'admin.puntos_venta'],
            ['clave' => 'empleados',     'texto' => 'Empleados',          'icono' => 'fa-id-badge',          'ruta' => 'admin.empleados'],
            ['clave' => 'clientes',      'texto' => 'Clientes',           'icono' => 'fa-user-group',        'ruta' => 'admin.clientes'],
            ['clave' => 'pedidos',       'texto' => 'Pedidos',            'icono' => 'fa-file-lines',        'ruta' => 'admin.cotizaciones'],
            ['clave' => 'gastos',        'texto' => 'Gastos comerciales', 'icono' => 'fa-wallet',            'ruta' => 'admin.gastos_comerciales'],
            ['clave' => 'cuenta',        'texto' => 'Cuenta del negocio', 'icono' => 'fa-building-columns',  'ruta' => 'admin.cuentas.index'],
            ['clave' => 'pagos',         'texto' => 'Pago de servicios',  'icono' => 'fa-file-invoice',      'ruta' => 'admin.pago_servicios.index'],
            ['clave' => 'respaldos',     'texto' => 'Respaldos',          'icono' => 'fa-database',          'ruta' => 'admin.respaldos'],
        ],
        'Mi cuenta' => [
            ['clave' => 'informacion',   'texto' => 'Mi información',     'icono' => 'fa-circle-user',       'ruta' => 'admin.informacion'],
            ['clave' => 'configuracion', 'texto' => 'Configuración',      'icono' => 'fa-gear',              'ruta' => null],
        ],
    ],
    'cliente' =>[
        'Navegacion' => [
            ['clave' => 'compras',       'texto' => 'Compras',            'icono' => 'fa-cart-shopping',     'ruta' => null],
            ['clave' => 'pedidos',       'texto' => 'Pedidos',            'icono' => 'fa-file-lines',        'ruta' => 'cliente.cotizaciones'],
        ],
        'Mi cuenta' => [
            ['clave' => 'informacion',   'texto' => 'Mi información',     'icono' => 'fa-circle-user',       'ruta' => 'cliente.informacion'],
        ],
    ]

];