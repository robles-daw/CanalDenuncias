<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Estadísticas - {{ $empresa->nombre }}</title>
    <style>
        :root {
            --accent: {{ $empresa->color_principal_hex }};
            --accent-deep: {{ $empresa->color_secundario_hex }};
            --accent-contrast: {{ $empresa->color_principal_contrast }};
            --accent-deep-contrast: {{ $empresa->color_secundario_contrast }};
            --brand-contrast: {{ $empresa->brand_contrast }};
            --ink: #15202b;
            --muted: #61707b;
            --line: rgba(21, 32, 43, 0.10);
            --surface: rgba(255, 252, 247, 0.84);
            --shadow: 0 34px 88px rgba(21, 32, 43, 0.12);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% 12%, color-mix(in srgb, var(--accent) 16%, transparent), transparent 0 28%),
                radial-gradient(circle at 86% 14%, color-mix(in srgb, var(--accent-deep) 14%, transparent), transparent 0 24%),
                linear-gradient(135deg, #eef4fb 0%, #f7fafe 42%, #e9f0f7 100%);
            background-attachment: fixed;
        }

        .page {
            max-width: 1220px;
            margin: 0 auto;
            padding: 24px 18px 48px;
        }

        .shell {
            border-radius: 34px;
            border: 1px solid rgba(255,255,255,0.54);
            background: var(--surface);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow);
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            margin-bottom: 26px;
        }

        h1 {
            margin: 0;
            font-family: "Fraunces", "Iowan Old Style", "Palatino Linotype", serif;
            font-size: clamp(2.8rem, 6vw, 4.5rem);
            line-height: 0.92;
            letter-spacing: -0.04em;
        }

        .intro {
            margin-top: 10px;
            color: var(--muted);
            max-width: 65ch;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 18px;
            border-radius: 999px;
            text-decoration: none;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
        }

        .button-primary {
            color: var(--brand-contrast);
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%);
            box-shadow: 0 20px 40px color-mix(in srgb, var(--accent) 18%, transparent);
        }

        .button-secondary {
            color: var(--ink);
            background: rgba(255,255,255,0.88);
            border: 1px solid var(--line);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .stat-card,
        .panel {
            border-radius: 26px;
            border: 1px solid rgba(21, 32, 43, 0.08);
            background: linear-gradient(180deg, rgba(255,255,255,0.78), rgba(241,246,252,0.96));
            padding: 22px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .stat-value {
            margin-top: 10px;
            font-size: clamp(1.9rem, 4vw, 2.9rem);
            font-weight: 900;
            line-height: 0.95;
        }

        .stat-note {
            margin-top: 10px;
            color: var(--muted);
            line-height: 1.5;
        }

        .panels {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
            gap: 18px;
        }

        h2 {
            margin: 0 0 18px;
            font-size: 1.3rem;
        }

        .type-list {
            display: grid;
            gap: 12px;
        }

        .type-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 0.95rem;
        }

        .type-name {
            font-weight: 800;
        }

        .type-track {
            width: 100%;
            height: 10px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(21, 32, 43, 0.08);
            margin-top: 8px;
        }

        .type-fill {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--accent), var(--accent-deep));
        }

        .chart {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            align-items: end;
            min-height: 250px;
        }

        .chart-col {
            display: grid;
            gap: 10px;
            justify-items: center;
        }

        .chart-bar-wrap {
            width: 100%;
            min-height: 190px;
            display: flex;
            align-items: end;
        }

        .chart-bar {
            width: 100%;
            min-height: 16px;
            border-radius: 20px 20px 8px 8px;
            background: linear-gradient(180deg, var(--accent) 0%, var(--accent-deep) 100%);
            box-shadow: 0 16px 28px color-mix(in srgb, var(--accent) 18%, transparent);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-top: 10px;
            color: var(--brand-contrast);
            font-weight: 900;
        }

        .chart-label {
            text-align: center;
            font-size: 0.92rem;
            font-weight: 800;
        }

        .chart-note {
            color: var(--muted);
            text-align: center;
            font-size: 0.88rem;
        }

        .empty {
            color: var(--muted);
        }

        @media (max-width: 900px) {
            .stats-grid,
            .panels,
            .chart,
            .topbar {
                grid-template-columns: 1fr;
                display: grid;
            }
        }

        @media (max-width: 760px) {
            .page {
                padding: 16px 14px 40px;
            }

            .shell,
            .stat-card,
            .panel {
                padding: 22px;
                border-radius: 24px;
            }

            .chart-bar-wrap {
                min-height: 120px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell">
            <div class="topbar">
                <div>
                    <h1>{{ $empresa->nombre }}</h1>
                    <p class="intro">Estadísticas del canal de denuncias de esta empresa: volumen total, datos de contacto disponibles, reparto por tipo y estado actual de los expedientes.</p>
                </div>

                <div class="actions">
                    <a class="button button-secondary" href="{{ route('admin.empresas.index') }}">Volver a empresas</a>
                    <a class="button button-primary" href="{{ route('admin.empresas.edit', $empresa) }}">Editar empresa</a>
                </div>
            </div>

            <div class="stats-grid">
                <article class="stat-card">
                    <div class="stat-label">Denuncias totales</div>
                    <div class="stat-value">{{ number_format($stats['total_denuncias'], 0, ',', '.') }}</div>
                    <div class="stat-note">Total de comunicaciones registradas en este canal.</div>
                </article>

                <article class="stat-card">
                    <div class="stat-label">Con teléfono</div>
                    <div class="stat-value">{{ number_format($stats['con_telefono'], 0, ',', '.') }}</div>
                    <div class="stat-note">Sin teléfono: {{ number_format($stats['sin_telefono'], 0, ',', '.') }}</div>
                </article>

                <article class="stat-card">
                    <div class="stat-label">Con email</div>
                    <div class="stat-value">{{ number_format($stats['con_email'], 0, ',', '.') }}</div>
                    <div class="stat-note">Casos con correo de contacto informado.</div>
                </article>

                <article class="stat-card">
                    <div class="stat-label">Anónimas</div>
                    <div class="stat-value">{{ number_format($stats['anonimas'], 0, ',', '.') }}</div>
                    <div class="stat-note">Denuncias enviadas sin identificación del comunicante.</div>
                </article>
            </div>

            <div class="panels">
                <section class="panel">
                    <h2>Denuncias por tipo</h2>

                    @if ($denunciasPorTipo->isEmpty())
                        <p class="empty">Esta empresa todavía no tiene denuncias registradas por tipo.</p>
                    @else
                        <div class="type-list">
                            @foreach ($denunciasPorTipo as $tipo)
                                <div>
                                    <div class="type-meta">
                                        <span class="type-name">{{ $tipo['nombre'] }}</span>
                                        <span>{{ number_format($tipo['total'], 0, ',', '.') }} · {{ str_replace('.', ',', (string) $tipo['porcentaje']) }}%</span>
                                    </div>
                                    <div class="type-track">
                                        <div class="type-fill" style="width: {{ min($tipo['porcentaje'], 100) }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="panel">
                    <h2>Denuncias por estado</h2>

                    <div class="chart">
                        @foreach ($denunciasPorEstado as $estado)
                            @php
                                $height = $maxDenunciasEstado > 0 ? max(16, (int) round(($estado['total'] / $maxDenunciasEstado) * 190)) : 16;
                            @endphp
                            <div class="chart-col">
                                <div class="chart-bar-wrap">
                                    <div class="chart-bar" style="height: {{ $height }}px;">
                                        {{ number_format($estado['total'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="chart-label">{{ $estado['label'] }}</div>
                                <div class="chart-note">
                                    {{ $stats['total_denuncias'] > 0 ? str_replace('.', ',', (string) round(($estado['total'] / $stats['total_denuncias']) * 100, 1)) : '0' }}%
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>
    </main>
</body>
</html>
