<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de denuncia - {{ $empresa->nombre }}</title>
    @include('partials.theme-head')
    <style>
        .page { max-width: 960px; }
        .stack { display: grid; gap: 20px; }
        .panel { border-radius: var(--radius-xl); }
        h1 { font-size: clamp(2.8rem, 6vw, 4.4rem); line-height: 0.96; }
        h2 { font-family: "Fraunces", serif; font-size: 1.5rem; font-weight: 500; }
        .panel-copy { margin-top: 14px; max-width: 58ch; }
        form { display: grid; gap: 16px; margin-top: 22px; }
        .empty { color: var(--accent-deep); font-weight: 600; }
        .meta { display: grid; gap: 16px; margin-top: 16px; }
        .meta-item { padding-top: 16px; border-top: 1px solid var(--line); }
        .meta-item:first-child { padding-top: 0; border-top: 0; }
        .meta-item strong {
            display: block;
            margin-bottom: 4px;
            font-size: 0.78rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
        }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; }
    </style>
</head>
<body>
    <main class="page stack">
        <section class="panel glass">
            <h1>Seguimiento</h1>
            <p>Introduce el código asignado a tu comunicación para consultar su estado.</p>

            <form method="GET" action="{{ route('canal-denuncias.tracking', $empresa->dominio) }}">
                <input type="text" name="codigo" value="{{ $codigo }}" placeholder="Ejemplo: {{ strtoupper($empresa->dominio) }}-ABC123XYZ9">
                <button type="submit">Consultar</button>
            </form>
        </section>

        @if ($busquedaRealizada && ! $denuncia)
            <section class="panel glass">
                <p class="empty">No se ha encontrado ninguna comunicación con el código indicado.</p>
            </section>
        @endif

        @if ($denuncia)
            <section class="panel glass">
                <h2>Estado actual</h2>

                <div class="meta">
                    <div class="meta-item">
                        <strong>Código</strong>
                        <span>{{ $denuncia->codigo_seguimiento }}</span>
                    </div>

                    <div class="meta-item">
                        <strong>Estado</strong>
                        <span>{{ $denuncia->estado_label }}</span>
                    </div>

                    <div class="meta-item">
                        <strong>Tipo</strong>
                        <span>{{ $denuncia->causa?->nombre }}</span>
                    </div>

                    <div class="meta-item">
                        <strong>Fecha de recepción</strong>
                        <span>{{ $denuncia->fecha_recepcion?->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="meta-item">
                        <strong>Riesgo inmediato</strong>
                        <span>{{ $denuncia->riesgo_inmediato ? 'Sí' : 'No' }}</span>
                    </div>

                    <div class="meta-item">
                        <strong>Continuidad del hecho</strong>
                        <span>{{ is_null($denuncia->sigue_ocurriendo) ? 'No informado' : ($denuncia->sigue_ocurriendo ? 'Sí' : 'No') }}</span>
                    </div>
                </div>
            </section>
        @endif

        <div class="actions">
            <a class="button button-secondary" href="{{ route('canal-denuncias.show', $empresa->dominio) }}">Volver al canal</a>
        </div>
    </main>
</body>
</html>
