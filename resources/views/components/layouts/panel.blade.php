@props([
    'titulo' => 'Panel',
    'regresar' => null,
    'migas' => [],
    'notificaciones' => 0,
])

@php
    $usuario = auth()->user();

    if ($usuario) {
        $nombreCompleto = trim($usuario->name . ' ' . $usuario->apellido);
        $iniciales = mb_strtoupper(
            mb_substr($usuario->name, 0, 1) . mb_substr($usuario->apellido ?? '', 0, 1)
        );
        $etiquetaRol = [
            'admin' => 'Administrador',
            'vendedor' => 'Vendedor',
            'cliente' => 'Cliente',
        ][$usuario->rol] ?? '';
        $rutaPerfil = match ($usuario->rol) {
            'admin' => route('admin.informacion'),
            'vendedor' => route('vendedor.informacion'),
            default => route('cliente.informacion'),
        };
        $colorPerfil = $usuario->color_perfil ?: '#6d28d9';
    }
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $titulo }} · Orquídeas y más Los Amates</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primario: #6d28d9;
            --primario-oscuro: #5b21b6;
            --primario-suave: #f3eefe;
            --texto: #111827;
            --texto-suave: #6b7280;
            --borde: #e5e7eb;
            --fondo: #f8f9fb;
            --ancho-max: 1280px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, Arial, sans-serif;
            background: var(--fondo);
            color: var(--texto);
        }

        .contenedor-pagina {
            width: 100%;
            max-width: var(--ancho-max);
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== HEADER ===== */
        .encabezado-app {
            position: sticky;
            top: 0;
            z-index: 500;
            background: #fff;
            border-bottom: 1px solid var(--borde);
        }

        .encabezado-app .contenedor-pagina {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .encabezado-izq,
        .encabezado-der {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .enlace-regresar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--texto-suave);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .enlace-regresar:hover { color: var(--primario); }

        .separador-vertical {
            width: 1px;
            height: 24px;
            background: var(--borde);
        }

        .migas {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            min-width: 0;
        }

        .migas a {
            color: var(--texto-suave);
            text-decoration: none;
        }

        .migas a:hover { color: var(--primario); }

        .migas-sep {
            font-size: 10px;
            color: #9ca3af;
        }

        .miga-actual {
            color: var(--texto);
            font-weight: 600;
        }

        .btn-notificaciones {
            position: relative;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 50%;
            background: transparent;
            color: var(--texto-suave);
            font-size: 17px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .btn-notificaciones:hover {
            background: var(--primario-suave);
            color: var(--primario);
        }

        .punto-notificacion {
            position: absolute;
            top: 7px;
            right: 8px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--primario);
            border: 2px solid #fff;
        }

        .usuario-app {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
        }

        .avatar-app {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-app img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .usuario-datos {
            display: flex;
            flex-direction: column;
            line-height: 1.25;
        }

        .usuario-nombre {
            font-size: 14px;
            font-weight: 600;
            color: var(--texto);
        }

        .usuario-rol {
            font-size: 13px;
            color: var(--texto-suave);
        }

        @media (max-width: 700px) {
            .usuario-datos { display: none; }
            .contenedor-pagina { padding: 0 16px; }
        }

        @media (max-width: 520px) {
            .migas { display: none; }
        }
    </style>

    @stack('estilos')
</head>

<body>

    <header class="encabezado-app">
        <div class="contenedor-pagina">

            <div class="encabezado-izq">

                @if($regresar)
                    <a href="{{ $regresar }}" class="enlace-regresar">
                        <i class="fa-solid fa-arrow-left"></i>
                        Regresar
                    </a>
                @endif

                @if($regresar && count($migas))
                    <span class="separador-vertical"></span>
                @endif

                @if(count($migas))
                    <nav class="migas" aria-label="Ruta de navegación">
                        @foreach($migas as $miga)
                            @if(!$loop->first)
                                <i class="fa-solid fa-chevron-right migas-sep"></i>
                            @endif

                            @if(!empty($miga['url']) && !$loop->last)
                                <a href="{{ $miga['url'] }}">{{ $miga['texto'] }}</a>
                            @else
                                <span class="miga-actual">{{ $miga['texto'] }}</span>
                            @endif
                        @endforeach
                    </nav>
                @endif

            </div>

            @if($usuario)
                <div class="encabezado-der">

                    <button type="button" class="btn-notificaciones" title="Notificaciones">
                        <i class="fa-regular fa-bell"></i>
                        @if($notificaciones > 0)
                            <span class="punto-notificacion"></span>
                        @endif
                    </button>

                    <span class="separador-vertical"></span>

                    <a href="{{ $rutaPerfil }}" class="usuario-app">
                        <span class="avatar-app" style="background: {{ $colorPerfil }};">
                            @if($usuario->foto_perfil)
                                <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="{{ $nombreCompleto }}">
                            @else
                                {{ $iniciales }}
                            @endif
                        </span>

                        <span class="usuario-datos">
                            <span class="usuario-nombre">{{ $nombreCompleto }}</span>
                            <span class="usuario-rol">{{ $etiquetaRol }}</span>
                        </span>
                    </a>

                </div>
            @endif

        </div>
    </header>

    <main class="contenedor-pagina">
        {{ $slot }}
    </main>

    @stack('scripts')

</body>

</html>