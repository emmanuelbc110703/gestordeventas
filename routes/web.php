<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\EmpleadoController;
use App\Http\Controllers\PuntoVentaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CotizacionController;

// ========================================
// COTIZACIONES - CLIENTE
// ========================================

Route::get(
    '/cliente/cotizaciones',
    [CotizacionController::class, 'indexCliente']
)->name('cliente.cotizaciones');

Route::get(
    '/cliente/cotizaciones/crear',
    [CotizacionController::class, 'crear']
)->name('cliente.cotizaciones.crear');

Route::post(
    '/cliente/cotizaciones',
    [CotizacionController::class, 'store']
)->name('cliente.cotizaciones.store');

Route::get(
    '/cliente/cotizaciones/{id}',
    [CotizacionController::class, 'mostrar']
)->name('cliente.cotizaciones.mostrar');


// ========================================
// COTIZACIONES - ADMIN
// ========================================

Route::get(
    '/admin/cotizaciones',
    [CotizacionController::class, 'indexAdmin']
)->name('admin.cotizaciones');

Route::get(
    '/admin/cotizaciones/{id}',
    [CotizacionController::class, 'mostrarAdmin']
)->name('admin.cotizaciones.mostrar');

Route::post(
    '/admin/cotizaciones/{id}/procesar',
    [CotizacionController::class, 'procesar']
)->name('admin.cotizaciones.procesar');

Route::get(
    '/admin/cotizaciones/{id}/editar',
    [CotizacionController::class, 'editar']
)->name('admin.cotizaciones.editar');

Route::put(
    '/admin/cotizaciones/{id}',
    [CotizacionController::class, 'actualizar']
)->name('admin.cotizaciones.actualizar');

Route::post(
    '/admin/cotizaciones/{id}/finalizar',
    [CotizacionController::class, 'finalizar']
)->name('admin.cotizaciones.finalizar');

Route::post(
    '/admin/cotizaciones/{id}/terminar',
    [CotizacionController::class, 'terminar']
)->name('admin.cotizaciones.terminar');


Route::post('/ventas/registrar', [VentaController::class, 'registrar'])
    ->name('ventas.registrar');

// ========================================
// VENTAS Y TICKETS
// ========================================

Route::post('/ventas', [VentaController::class, 'store'])
    ->name('venta.store');

Route::get('/ventas/{venta}/ticket', [VentaController::class, 'ticket'])
    ->name('venta.ticket');

// ========================================
// PUNTO DE VENTA
// ========================================

Route::post(
    '/punto-venta/cliente/registrar',
    [PuntoVentaController::class, 'registrarCliente']
)->name('cliente.registrar.caja');

Route::post(
    '/punto-venta/cerrar',
    [PuntoVentaController::class, 'cerrar']
)->name('punto_venta.cerrar');

Route::post(
    '/punto-venta/cliente/registrar',
    [PuntoVentaController::class, 'registrarClienteCaja']
)->name('cliente.registrar.caja');

// Mostrar punto de venta
Route::get(
    '/empleado/punto-venta',
    function () {

        $puntoVenta = auth()->user()->puntoVenta;

        abort_unless($puntoVenta, 403);

        return view(
            'punto_venta',
            compact('puntoVenta')
        );
    }
)->name('empleado.punto_venta');


// ========================================
// ABRIR CAJA
// ========================================

Route::post(
    '/empleado/punto-venta/abrir/{id}',
    [PuntoVentaController::class, 'abrir']
)->name('punto_venta.abrir');


// ========================================
// MOSTRAR CAJA
// ========================================

Route::get(
    '/empleado/punto-venta/caja/{id}',
    [PuntoVentaController::class, 'caja']
)->name('punto_venta.caja');


// ========================================
// ADMIN - PUNTOS DE VENTA
// ========================================

Route::get(
    '/admin/puntos-venta',
    [PuntoVentaController::class, 'index']
)->name('admin.puntos_venta');

Route::get(
    '/admin/puntos-venta/crear',
    [PuntoVentaController::class, 'create']
)->name('admin.puntos_venta.create');

Route::post(
    '/admin/puntos-venta',
    [PuntoVentaController::class, 'store']
)->name('admin.puntos_venta.store');

Route::get(
    '/admin/puntos-venta/{id}/editar',
    [PuntoVentaController::class, 'edit']
)->name('admin.puntos_venta.edit');

Route::put(
    '/admin/puntos-venta/{id}',
    [PuntoVentaController::class, 'update']
)->name('admin.puntos_venta.update');

Route::delete(
    '/admin/puntos-venta/{id}',
    [PuntoVentaController::class, 'destroy']
)->name('admin.puntos_venta.destroy');

// ================================
// EDITAR INVENTARIO
// ================================

Route::get(
    '/admin/inventario/{id}/editar',
    [InventarioController::class, 'edit']
)->name('admin.inventario.editar');


// ================================
// ACTUALIZAR INVENTARIO
// ================================

Route::put(
    '/admin/inventario/{id}',
    [InventarioController::class, 'update']
)->name('admin.inventario.actualizar');


// ================================
// ELIMINAR INVENTARIO
// ================================

Route::delete(
    '/admin/inventario/{id}',
    [InventarioController::class, 'destroy']
)->name('admin.inventario.eliminar');

// ========================================
// ADMIN - PUNTOS DE VENTA
// ========================================

// Panel de puntos de venta
Route::get(
    '/admin/puntos-venta',
    [PuntoVentaController::class, 'index']
)->name('admin.puntos_venta');

// Mostrar formulario para crear
Route::get(
    '/admin/puntos-venta/crear',
    [PuntoVentaController::class, 'create']
)->name('admin.puntos_venta.create');

// Guardar punto de venta
Route::post(
    '/admin/puntos-venta',
    [PuntoVentaController::class, 'store']
)->name('admin.puntos_venta.store');

// Mostrar formulario para editar
Route::get(
    '/admin/puntos-venta/{id}/editar',
    [PuntoVentaController::class, 'edit']
)->name('admin.puntos_venta.edit');

// Actualizar punto de venta
Route::put(
    '/admin/puntos-venta/{id}',
    [PuntoVentaController::class, 'update']
)->name('admin.puntos_venta.update');

// Eliminar punto de venta
Route::delete(
    '/admin/puntos-venta/{id}',
    [PuntoVentaController::class, 'destroy']
)->name('admin.puntos_venta.destroy');


// ========================================
// AUTENTICACIÓN
// ========================================

// Mostrar login
Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

// Procesar login
Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.store');

// Google
Route::post(
    '/auth/google',
    [AuthController::class, 'googleLogin']
)->name('google.login');

// Cerrar sesión
Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');


// ========================================
// ACTIVAR CUENTA DEL CLIENTE
// ========================================

// Mostrar formulario para crear contraseña
Route::get(
    '/activar-cuenta',
    [AuthController::class, 'mostrarActivarCuenta']
)->name('cuenta.activar');

// Guardar nueva contraseña
Route::post(
    '/activar-cuenta',
    [AuthController::class, 'activarCuenta']
)->name('cuenta.activar.guardar');


// ========================================
// CLIENTE - CREAR CONTRASEÑA
// ========================================

Route::get(
    '/cliente/crear-password/{id}',
    [AuthController::class, 'showCrearPassword']
)->name('cliente.crear.password');

Route::post(
    '/cliente/crear-password/{id}',
    [AuthController::class, 'crearPassword']
)->name('cliente.crear.password.guardar');


// ========================================
// ADMIN - EMPLEADOS
// ========================================

// Editar empleado
Route::get(
    '/admin/empleados/{id}/editar',
    [EmpleadoController::class, 'edit']
)->name('admin.empleados.editar');

// Actualizar empleado
Route::put(
    '/admin/empleados/{id}',
    [EmpleadoController::class, 'update']
)->name('admin.empleados.actualizar');

// Eliminar empleado
Route::delete(
    '/admin/empleados/{id}',
    [EmpleadoController::class, 'destroy']
)->name('admin.empleados.eliminar');

// Agregar empleado
Route::post(
    '/admin/empleados',
    [EmpleadoController::class, 'store']
)->name('admin.empleados.guardar');

// Mostrar formulario para agregar empleado
Route::get(
    '/admin/empleados/agregar',
    [EmpleadoController::class, 'create']
)->name('admin.empleados.agregar');

// Mostrar lista de empleados
Route::get(
    '/admin/empleados',
    [EmpleadoController::class, 'index']
)->name('admin.empleados');


// ========================================
// ADMINISTRADOR - INFORMACIÓN
// ========================================

// Mostrar información del administrador
Route::get(
    '/admin/informacion',
    [AuthController::class, 'adminInformacion']
)->name('admin.informacion');

// Mostrar formulario para editar información
Route::get(
    '/admin/informacion/editar',
    [AuthController::class, 'adminEditarInformacion']
)->name('admin.informacion.editar');

// Guardar cambios de información
Route::put(
    '/admin/informacion',
    [AuthController::class, 'adminActualizarInformacion']
)->name('admin.informacion.actualizar');


// ========================================
// ADMIN - FOTO Y COLOR DE PERFIL
// ========================================

// Actualizar foto del administrador
Route::post(
    '/admin/foto-perfil',
    [AuthController::class, 'actualizarFotoAdmin']
)->name('admin.foto.actualizar');

// Eliminar foto del administrador
Route::post(
    '/admin/foto/eliminar',
    [AuthController::class, 'eliminarFotoAdmin']
)->name('admin.foto.eliminar');

// Actualizar color del administrador
Route::post(
    '/admin/color-perfil',
    [AuthController::class, 'actualizarColorAdmin']
)->name('admin.color.actualizar');


// ========================================
// VENDEDOR - MI INFORMACIÓN
// ========================================

// Mostrar información del vendedor
Route::get(
    '/vendedor/informacion',
    [AuthController::class, 'vendedorInformacion']
)->name('vendedor.informacion');

// Mostrar formulario para editar información
Route::get(
    '/vendedor/informacion/editar',
    [AuthController::class, 'vendedorEditarInformacion']
)->name('vendedor.informacion.editar');

// Guardar cambios de información
Route::put(
    '/vendedor/informacion',
    [AuthController::class, 'vendedorActualizarInformacion']
)->name('vendedor.informacion.actualizar');


// ========================================
// VENDEDOR - FOTO Y COLOR DE PERFIL
// ========================================

// Actualizar foto del vendedor
Route::post(
    '/vendedor/foto-perfil',
    [AuthController::class, 'actualizarFotoVendedor']
)->name('vendedor.foto.actualizar');

// Eliminar foto del vendedor
Route::post(
    '/vendedor/foto/eliminar',
    [AuthController::class, 'eliminarFotoVendedor']
)->name('vendedor.foto.eliminar');

// Actualizar color del vendedor
Route::post(
    '/vendedor/color-perfil',
    [AuthController::class, 'actualizarColorVendedor']
)->name('vendedor.color.actualizar');


// ========================================
// ADMIN - CLIENTES
// ========================================

// Editar cliente
Route::get(
    '/admin/clientes/{id}/editar',
    [AuthController::class, 'editarCliente']
)->name('admin.clientes.editar');

// Actualizar cliente
Route::put(
    '/admin/clientes/{id}',
    [AuthController::class, 'actualizarCliente']
)->name('admin.clientes.actualizar');

// Eliminar cliente
Route::delete(
    '/admin/clientes/{id}',
    [AuthController::class, 'destroyCliente']
)->name('admin.clientes.eliminar');

// Mostrar formulario para agregar cliente
Route::get(
    '/admin/clientes/agregar',
    [AuthController::class, 'showRegisterAdmin']
)->name('admin.clientes.agregar');

// Guardar cliente
Route::post(
    '/admin/clientes/guardar',
    [AuthController::class, 'registerAdmin']
)->name('admin.clientes.guardar');

// Lista de clientes
Route::get(
    '/admin/clientes',
    [AuthController::class, 'clientes']
)->name('admin.clientes');


// ========================================
// CLIENTE - PERFIL
// ========================================

// Eliminar foto
Route::post(
    '/cliente/foto/eliminar',
    [AuthController::class, 'eliminarFotoPerfil']
)->name('cliente.foto.eliminar');

// Actualizar color
Route::post(
    '/cliente/color-perfil',
    [AuthController::class, 'actualizarColorPerfil']
)->name('cliente.color.actualizar');

// Actualizar foto
Route::post(
    '/cliente/foto-perfil',
    [AuthController::class, 'actualizarFotoPerfil']
)->name('cliente.foto.actualizar');


// ========================================
// CLIENTE - MI INFORMACIÓN
// ========================================

// Mostrar formulario de edición
Route::get(
    '/cliente/informacion/editar',
    [AuthController::class, 'editProfile']
)->name('cliente.informacion.editar');

// Guardar cambios
Route::put(
    '/cliente/informacion',
    [AuthController::class, 'updateProfile']
)->name('cliente.informacion.actualizar');

// Mostrar información
Route::get(
    '/cliente/informacion',
    function () {
        return view('cliente.informacion');
    }
)->name('cliente.informacion');


// ========================================
// REGISTRO
// ========================================

// Mostrar registro
Route::get(
    '/registro',
    [AuthController::class, 'showRegister']
)->name('registro');

// Guardar registro
Route::post(
    '/registro',
    [AuthController::class, 'register']
)->name('register.store');


// ========================================
// ADMIN - SERVICIOS
// ========================================

// Lista de servicios
Route::get(
    '/admin/servicios',
    [InventarioController::class, 'servicios']
)->name('admin.servicios');

// Mostrar formulario para agregar servicio
Route::get(
    '/admin/servicios/agregar',
    function () {
        return view('admin.agregar_servicio');
    }
)->name('admin.agregar_servicio');

// Guardar servicio
Route::post(
    '/admin/servicios',
    [InventarioController::class, 'storeServicio']
)->name('admin.servicios.guardar');

// Editar servicio
Route::get(
    '/admin/servicios/{id}/editar',
    [InventarioController::class, 'editServicio']
)->name('admin.servicios.editar');

// Actualizar servicio
Route::put(
    '/admin/servicios/{id}',
    [InventarioController::class, 'updateServicio']
)->name('admin.servicios.actualizar');

// Eliminar servicio
Route::delete(
    '/admin/servicios/{id}',
    [InventarioController::class, 'destroyServicio']
)->name('admin.servicios.eliminar');


// ========================================
// ADMIN - BIENES
// ========================================

// Mostrar formulario para agregar bien
Route::get(
    '/admin/bienes/agregar',
    [InventarioController::class, 'createBien']
)->name('admin.agregar_bien');

// Guardar bien
Route::post(
    '/admin/bienes',
    [InventarioController::class, 'storeBien']
)->name('admin.bienes.guardar');

// Lista de bienes
Route::get(
    '/admin/bienes',
    [InventarioController::class, 'bienes']
)->name('admin.bienes');


// ========================================
// ADMIN - INVENTARIO
// ========================================

// Inventario
Route::get(
    '/admin/inventario',
    [InventarioController::class, 'index']
)->name('admin.inventario');


// ========================================
// INICIO
// ========================================

Route::get(
    '/',
    function () {
        return view('inicio');
    }
)->name('inicio');


// ========================================
// DASHBOARDS
// ========================================

// Dashboard administrador
Route::get(
    '/admin/dashboard',
    [AdminController::class, 'dashboard']
)->name('admin.dashboard');

// Dashboard vendedor
Route::get(
    '/vendedor/dashboard',
    [VendedorController::class, 'dashboard']
)->name('vendedor.dashboard');

// Dashboard cliente
Route::get(
    '/cliente/dashboard',
    [ClienteController::class, 'dashboard']
)->name('cliente.dashboard');