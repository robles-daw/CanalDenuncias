<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $denuncia->codigo_seguimiento }} - {{ $empresa->nombre }}</title>
    @include('partials.theme-head')
    <style>
        .page { max-width: 1120px; }

        .topbar {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 16px;
            align-items: end;
            margin-bottom: 22px;
        }

        h1 {
            margin: 0;
            font-size: clamp(2.8rem, 6vw, 4.4rem);
            line-height: 0.96;
        }

        .grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 22px;
        }

        .stack {
            display: grid;
            gap: 16px;
        }

        .panel {
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255,255,255,0.78), rgba(241,246,252,0.96));
            border: 1px solid rgba(21, 32, 43, 0.08);
        }

        .meta-item {
            padding-top: 14px;
            border-top: 1px solid var(--line);
        }

        .meta-item:first-child {
            padding-top: 0;
            border-top: 0;
        }

        .meta-item strong {
            display: block;
            margin-bottom: 4px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        li + li {
            margin-top: 8px;
        }

        .attachment-link {
            color: color-mix(in srgb, var(--accent-deep) 78%, black);
            font-weight: 700;
            text-decoration: none;
        }

        .attachment-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 920px) {
            .topbar,
            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .page { padding: 16px 14px 40px; }
            .shell, .panel { padding: 22px; border-radius: 24px; }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell glass">
            <div class="topbar">
                <div>
                    <h1>{{ $denuncia->codigo_seguimiento }}</h1>
                    <div class="subtitle">{{ $empresa->nombre }}</div>
                </div>
                <a class="back" href="{{ route('empresa.panel.denuncias.index', $empresa->dominio) }}">Volver</a>
            </div>

            @if (session('status'))
                <div class="notice">{{ session('status') }}</div>
            @endif

            <div class="grid">
                <div class="stack">
                    <section class="panel">
                        <div class="meta-item">
                            <strong>Descripción</strong>
                            <div style="white-space:pre-line;">{{ $denuncia->descripcion_hechos }}</div>
                        </div>
                    </section>

                    @if ($denuncia->implicados->isNotEmpty())
                        <section class="panel">
                            <div class="meta-item">
                                <strong>Personas implicadas</strong>
                                <ul>
                                    @foreach ($denuncia->implicados as $implicado)
                                        <li>{{ $implicado->nombre }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @endif

                    @if ($denuncia->adjuntos->isNotEmpty())
                        <section class="panel">
                            <div class="meta-item">
                                <strong>Adjuntos</strong>
                                <ul>
                                    @foreach ($denuncia->adjuntos as $adjunto)
                                        <li>
                                            <a
                                                class="attachment-link"
                                                href="{{ route('empresa.panel.denuncias.adjuntos.download', ['empresa' => $empresa->dominio, 'denuncia' => $denuncia->id, 'adjunto' => $adjunto->id]) }}"
                                            >
                                                {{ $adjunto->nombre_original }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @endif
                </div>

                <div class="stack">
                    <section class="panel">
                        <div class="meta-item">
                            <strong>Tipo</strong>
                            <span>{{ $denuncia->causa?->nombre }}</span>
                        </div>
                        <div class="meta-item">
                            <strong>Fecha de recepción</strong>
                            <span>{{ $denuncia->fecha_recepcion?->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="meta-item">
                            <strong>Anónima</strong>
                            <span>{{ $denuncia->anonima ? 'Sí' : 'No' }}</span>
                        </div>
                        <div class="meta-item">
                            <strong>Riesgo inmediato</strong>
                            <span>{{ $denuncia->riesgo_inmediato ? 'Sí' : 'No' }}</span>
                        </div>
                    </section>

                    <section class="panel">
                        <form method="POST" action="{{ route('empresa.panel.denuncias.update', ['empresa' => $empresa->dominio, 'denuncia' => $denuncia->id]) }}" class="stack">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="estado">Estado</label>
                                <select id="estado" name="estado">
                                    <option value="pendiente" @selected($denuncia->estado === 'pendiente')>Pendiente</option>
                                    <option value="en_revision" @selected($denuncia->estado === 'en_revision')>En revisión</option>
                                    <option value="resuelta" @selected($denuncia->estado === 'resuelta')>Resuelta</option>
                                    <option value="archivada" @selected($denuncia->estado === 'archivada')>Archivada</option>
                                </select>
                            </div>
                            <button type="submit">Guardar estado</button>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
