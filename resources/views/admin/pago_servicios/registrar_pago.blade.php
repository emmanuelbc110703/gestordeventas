@php
    $input = 'w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900';
@endphp

<x-layouts.panel
    titulo="Registrar pago de servicio"
    :migas="[
        ['texto' => 'Pago de servicios', 'url' => url('/admin/pago-servicios')],
        ['texto' => 'Registrar pago', 'url' => null],
    ]"
>
    <div class="mx-auto max-w-3xl space-y-6">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-zinc-500">
                Selecciona el servicio del recibo que recibiste y captura lo que realmente pagaste.
            </p>
            <a href="{{ route('admin.pago_servicios.historial') }}"
               class="rounded-lg border border-zinc-300 px-3 py-2 text-sm font-medium hover:bg-zinc-50">
                Ver pagos realizados
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-300 bg-green-50 p-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any() && ! $seleccionado)
            <div class="rounded-lg border border-red-300 bg-red-50 p-3 text-sm text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        @if ($pendientes->isEmpty())
            <div class="rounded-lg border border-zinc-200 p-6 text-center text-sm text-zinc-500">
                No hay servicios con pago pendiente.
            </div>
        @else
            {{-- Selector de servicio pendiente --}}
            <form method="GET" action="{{ route('admin.pago_servicios.registrar') }}" class="space-y-2">
                <label for="servicio" class="block text-sm font-medium">Servicio con pago pendiente</label>
                <select id="servicio" name="servicio" onchange="this.form.submit()" class="{{ $input }}">
                    <option value="">Selecciona el servicio del recibo…</option>
                    @foreach ($pendientes as $p)
                        <option value="{{ $p->id }}" @selected($seleccionado && $seleccionado->id === $p->id)>
                            {{ $p->servicio }} · {{ $p->fecha_pago->format('d/m/Y') }} ·
                            {{ $p->monto !== null ? '$'.number_format((float) $p->monto, 2) : 'sin monto' }}
                        </option>
                    @endforeach
                </select>
                <noscript>
                    <button type="submit" class="rounded-lg border border-zinc-300 px-3 py-2 text-sm">Ver servicio</button>
                </noscript>
            </form>

            @if (request()->filled('servicio') && ! $seleccionado)
                <p class="text-sm text-amber-700">Ese servicio ya no tiene un pago pendiente.</p>
            @endif

            @if ($seleccionado)
                {{-- Información registrada en la agenda --}}
                <div class="grid grid-cols-2 gap-4 rounded-lg border border-zinc-200 p-4 text-sm sm:grid-cols-3">
                    <div>
                        <div class="text-zinc-500">Servicio</div>
                        <div class="font-medium">{{ $seleccionado->servicio }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-500">Monto registrado</div>
                        <div class="font-medium">
                            {{ $seleccionado->monto !== null ? '$'.number_format((float) $seleccionado->monto, 2) : 'Sin monto' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-zinc-500">Fecha de pago programada</div>
                        <div class="font-medium">{{ $seleccionado->fecha_pago->format('d/m/Y') }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-500">Fecha de vencimiento</div>
                        <div class="font-medium">{{ $seleccionado->fecha_vencimiento?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-500">Periodicidad</div>
                        <div class="font-medium">{{ $periodicidades[$seleccionado->periodicidad] ?? 'No definida' }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-500">Descripción</div>
                        <div class="font-medium">{{ $seleccionado->descripcion ?: '—' }}</div>
                    </div>
                </div>

                {{-- Registro del recibo --}}
                <form method="POST" action="{{ route('admin.pago_servicios.registrar.store') }}"
                      onsubmit="return confirm('¿Confirmas que este servicio ya fue pagado?')"
                      class="space-y-4">
                    @csrf
                    <input type="hidden" name="pago_servicio_id" value="{{ $seleccionado->id }}">

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="monto_pagado" class="mb-1 block text-sm font-medium">Monto pagado (según recibo)</label>
                            <input id="monto_pagado" name="monto_pagado" type="number" step="0.01" min="0.01"
                                   value="{{ old('monto_pagado', $seleccionado->monto) }}" class="{{ $input }}" required>
                            @error('monto_pagado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="folio_recibo" class="mb-1 block text-sm font-medium">Folio / número de recibo (opcional)</label>
                            <input id="folio_recibo" name="folio_recibo" type="text" maxlength="100"
                                   value="{{ old('folio_recibo') }}" class="{{ $input }}">
                            @error('folio_recibo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="fecha_recibo" class="mb-1 block text-sm font-medium">Fecha del recibo</label>
                            <input id="fecha_recibo" name="fecha_recibo" type="date" max="{{ now()->toDateString() }}"
                                   value="{{ old('fecha_recibo', now()->toDateString()) }}" class="{{ $input }}" required>
                            @error('fecha_recibo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="fecha_pago" class="mb-1 block text-sm font-medium">Fecha en que se pagó</label>
                            <input id="fecha_pago" name="fecha_pago" type="date" max="{{ now()->toDateString() }}"
                                   value="{{ old('fecha_pago', now()->toDateString()) }}" class="{{ $input }}" required>
                            @error('fecha_pago') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <p id="aviso-monto" class="text-sm"></p>

                    @if (blank($seleccionado->periodicidad))
                        <div>
                            <label for="periodicidad" class="mb-1 block text-sm font-medium">
                                Periodicidad del servicio (para calcular el siguiente pago)
                            </label>
                            <select id="periodicidad" name="periodicidad" class="{{ $input }}" required>
                                <option value="">Selecciona…</option>
                                @foreach ($periodicidades as $valor => $texto)
                                    <option value="{{ $valor }}" @selected(old('periodicidad') === $valor)>{{ $texto }}</option>
                                @endforeach
                            </select>
                            @error('periodicidad') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <div>
                        <label for="informacion_recibo" class="mb-1 block text-sm font-medium">Información del recibo (opcional)</label>
                        <textarea id="informacion_recibo" name="informacion_recibo" rows="3" maxlength="1000"
                                  placeholder="Número de contrato, referencia, observaciones…"
                                  class="{{ $input }}">{{ old('informacion_recibo') }}</textarea>
                        @error('informacion_recibo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    @error('pago_servicio_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                    <div class="flex justify-end">
                        <button type="submit"
                                class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700">
                            Confirmar pago
                        </button>
                    </div>
                </form>

                <script>
                    (function () {
                        const campo = document.getElementById('monto_pagado');
                        const aviso = document.getElementById('aviso-monto');
                        const base = {{ (float) $seleccionado->monto }};

                        function revisar() {
                            const valor = parseFloat(campo.value);
                            if (isNaN(valor)) { aviso.textContent = ''; return; }
                            const dif = Math.round((valor - base) * 100) / 100;
                            if (dif === 0) {
                                aviso.textContent = 'El monto coincide con la agenda; se conservará.';
                                aviso.className = 'text-sm text-green-700';
                            } else {
                                aviso.textContent = 'El monto es ' + (dif > 0 ? 'mayor' : 'menor') +
                                    ' por $' + Math.abs(dif).toFixed(2) +
                                    ' que el de la agenda; se actualizará con la cantidad pagada.';
                                aviso.className = 'text-sm text-amber-700';
                            }
                        }

                        campo.addEventListener('input', revisar);
                        revisar();
                    })();
                </script>
            @endif
        @endif
    </div>
</x-layouts.panel>