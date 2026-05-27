<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denuncias - {{ $empresa->nombre }}</title>
    @include('partials.theme-head')
    <style>
        .page { max-width: 1160px; }

        .topbar,
        .toolbar,
        .row {
            display: grid;
            gap: 16px;
        }

        .topbar {
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: end;
            margin-bottom: 22px;
        }

        h1 {
            margin: 0;
            font-size: clamp(2.8rem, 6vw, 4.4rem);
            line-height: 0.96;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .toolbar {
            grid-template-columns: auto 1fr;
            align-items: center;
            margin-bottom: 18px;
        }

        .list {
            display: grid;
            gap: 12px;
        }

        .row-shell {
            padding: 18px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255,255,255,0.78), rgba(241,246,252,0.96));
            border: 1px solid rgba(21, 32, 43, 0.08);
        }

        .row {
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
        }

        .code {
            font-weight: 900;
            letter-spacing: 0.03em;
        }

        .meta {
            margin-top: 6px;
            color: var(--muted);
            line-height: 1.55;
        }

        .empty {
            color: var(--muted);
        }

        @media (max-width: 860px) {
            .topbar,
            .toolbar,
            .row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .page { padding: 16px 14px 40px; }
            .shell, .row-shell { padding: 22px; border-radius: 24px; }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell glass">
            <div class="topbar">
                <div>
                    <h1>Denuncias</h1>
                    <div class="subtitle">{{ $empresa->nombre }}</div>
                </div>

                <form method="POST" action="{{ route('empresa.panel.logout', $empresa->dominio) }}">
                    @csrf
                    <button class="button button-secondary" type="submit">Cerrar sesión</button>
                </form>
            </div>

            <div class="toolbar">
                <form class="filter-form" method="GET" action="{{ route('empresa.panel.denuncias.index', $empresa->dominio) }}">
                    <select name="estado" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" @selected($estadoActual === 'pendiente')>Pendiente</option>
                        <option value="en_revision" @selected($estadoActual === 'en_revision')>En revisión</option>
                        <option value="resuelta" @selected($estadoActual === 'resuelta')>Resuelta</option>
                        <option value="archivada" @selected($estadoActual === 'archivada')>Archivada</option>
                    </select>
                </form>
            </div>

            @if ($denuncias->isEmpty())
                <div class="empty">No hay denuncias registradas.</div>
            @else
                <div class="list">
                    @foreach ($denuncias as $denuncia)
                        <div class="row-shell">
                            <div class="row">
                                <div>
                                    <div class="code">{{ $denuncia->codigo_seguimiento }}</div>
                                    <div class="meta">{{ $denuncia->causa?->nombre }} · {{ $denuncia->estado_label }} · {{ $denuncia->fecha_recepcion?->format('d/m/Y H:i') }}</div>
                                </div>
                                <a class="button button-primary" href="{{ route('empresa.panel.denuncias.show', ['empresa' => $empresa->dominio, 'denuncia' => $denuncia->id]) }}">Gestionar</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</body>
</html>
