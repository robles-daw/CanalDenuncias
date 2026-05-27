<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denuncia registrada - {{ $empresa->nombre }}</title>
    @include('partials.theme-head')
    <style>
        body { display: grid; place-items: center; padding: 18px; }
        .card { width: min(760px, 100%); }
        h1 { margin: 18px 0 0; font-size: clamp(2.7rem, 6vw, 4.3rem); line-height: 0.96; }
        .intro { margin-top: 16px; max-width: 58ch; }
        .code {
            margin: 28px 0;
            padding: 24px 22px;
            border-radius: var(--radius-lg);
            background: linear-gradient(150deg, color-mix(in srgb, var(--accent-deep) 92%, white) 0%, var(--accent-deep) 100%);
            color: var(--accent-deep-contrast);
            font-size: clamp(1.38rem, 5vw, 2.1rem);
            font-weight: 900;
            letter-spacing: 0.08em;
            text-align: center;
            box-shadow: var(--shadow-brand);
        }
        .meta { display: grid; gap: 14px; }
        .meta-item { padding-top: 14px; border-top: 1px solid var(--line); }
        .meta-item:first-child { padding-top: 0; border-top: 0; }
        .meta-item strong {
            display: block;
            margin-bottom: 4px;
            font-size: 0.78rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
        }
        .mail-panel {
            margin-top: 26px;
            padding: 22px;
            border-radius: var(--radius-lg);
            background: rgba(255,255,255,0.6);
            border: 1px solid var(--line);
        }
        .mail-panel h2 { margin: 0 0 8px; font-family: "Fraunces", serif; font-size: 1.35rem; font-weight: 500; }
        .mail-form { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px; }
        .mail-form input { flex: 1 1 280px; min-height: 50px; }
        .mail-form button { min-width: 180px; }
        .field-error { margin-top: 10px; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 30px; }
    </style>
</head>
<body>
    <section class="card glass">
        <span class="eyebrow">Registro completado</span>
        <h1>Comunicación registrada</h1>
        <p class="intro">Conserva este código para consultar el estado de la denuncia cuando lo necesites.</p>

        <div class="code">{{ $denuncia->codigo_seguimiento }}</div>

        <div class="meta">
            <div class="meta-item">
                <strong>Tipo</strong>
                <span>{{ $denuncia->causa?->nombre }}</span>
            </div>

            <div class="meta-item">
                <strong>Estado</strong>
                <span>{{ $denuncia->estado_label }}</span>
            </div>

            <div class="meta-item">
                <strong>Fecha de recepción</strong>
                <span>{{ $denuncia->fecha_recepcion?->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <section class="mail-panel">
            <h2>Recibir el código por correo</h2>
            <p>Si quieres, puedes enviarte ahora este código de seguimiento a una dirección de correo electrónico.</p>

            @if (session('tracking_code_sent'))
                <div class="status">{{ session('tracking_code_sent') }}</div>
            @endif

            <form class="mail-form" method="POST" action="{{ route('canal-denuncias.confirmacion.correo', ['empresa' => $empresa->dominio, 'codigo' => $denuncia->codigo_seguimiento]) }}">
                @csrf
                <input type="email" name="email_destino" value="{{ old('email_destino') }}" placeholder="tucorreo@ejemplo.com" required>
                <button class="button button-primary" type="submit">Enviar por correo</button>
            </form>

            @error('email_destino')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </section>

        <div class="actions">
            <a class="button button-primary" href="{{ route('canal-denuncias.tracking', ['empresa' => $empresa->dominio, 'codigo' => $denuncia->codigo_seguimiento]) }}">Consultar seguimiento</a>
            <a class="button button-secondary" href="{{ route('canal-denuncias.show', $empresa->dominio) }}">Volver al canal</a>
        </div>
    </section>
</body>
</html>
