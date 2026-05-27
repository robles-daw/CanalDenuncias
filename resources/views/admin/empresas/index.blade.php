<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Administración de empresas</title>
    <style>
        :root {
            --accent: #1d4f8c;
            --accent-deep: #0f2744;
            --ink: #15202b;
            --muted: #61707b;
            --line: rgba(21, 32, 43, 0.10);
            --surface: rgba(248, 251, 255, 0.82);
            --shadow: 0 34px 88px rgba(21, 32, 43, 0.12);
            --ok: #166534;
            --danger: #b42318;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 12% 14%, rgba(29, 79, 140, 0.16), transparent 0 28%),
                radial-gradient(circle at 86% 14%, rgba(15, 39, 68, 0.12), transparent 0 22%),
                linear-gradient(135deg, #eef4fb 0%, #f7fafe 40%, #e9f0f7 100%);
            background-attachment: fixed;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255,255,255,0.26), transparent 36%),
                repeating-linear-gradient(135deg, rgba(255,255,255,0.05) 0 1px, transparent 1px 22px);
        }

        .page {
            position: relative;
            max-width: 1180px;
            margin: 0 auto;
            padding: 24px 18px 48px;
        }

        .shell {
            border-radius: 34px;
            border: 1px solid rgba(255,255,255,0.52);
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
            margin-bottom: 24px;
        }

        h1 {
            margin: 0;
            font-family: "Fraunces", "Iowan Old Style", "Palatino Linotype", serif;
            font-size: clamp(2.8rem, 6vw, 4.4rem);
            line-height: 0.92;
            letter-spacing: -0.04em;
        }

        .intro {
            margin-top: 10px;
            color: var(--muted);
        }

        .actions,
        .row-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .button,
        button {
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
            color: #fff;
            border: 0;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%);
            box-shadow: 0 20px 40px rgba(29, 79, 140, 0.18);
        }

        .button-secondary {
            color: var(--ink);
            background: rgba(255,255,255,0.86);
            border: 1px solid var(--line);
        }

        .delete-toggle {
            color: var(--danger);
            background: rgba(180, 35, 24, 0.08);
            border: 1px solid rgba(180, 35, 24, 0.16);
        }

        .notice {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(22, 101, 52, 0.10);
            border: 1px solid rgba(22, 101, 52, 0.18);
            color: var(--ok);
        }

        .list {
            display: grid;
            gap: 12px;
        }

        .row-shell {
            border-radius: 26px;
            background: linear-gradient(180deg, rgba(255,255,255,0.78), rgba(241,246,252,0.96));
            border: 1px solid rgba(21, 32, 43, 0.08);
            padding: 18px;
        }

        .empresa-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 16px;
            align-items: center;
        }

        .empresa-main {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .swatch {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.20);
            flex-shrink: 0;
        }

        .empresa-name {
            font-weight: 900;
            font-size: 1.08rem;
        }

        .empresa-meta {
            margin-top: 5px;
            color: var(--muted);
            line-height: 1.55;
        }

        .empty {
            color: var(--muted);
        }

        .logout-form {
            margin: 0;
        }

        .delete-panel {
            display: none;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--line);
        }

        .delete-panel.is-open {
            display: block;
        }

        .delete-form {
            display: grid;
            grid-template-columns: minmax(210px, 280px) auto;
            gap: 10px;
            align-items: center;
        }

        .delete-form input {
            width: 100%;
            min-height: 46px;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 0 14px;
            font: inherit;
            background: rgba(255,255,255,0.96);
        }

        .delete-button {
            border: 0;
            background: var(--danger);
            color: #fff;
        }

        .delete-hint,
        .delete-error {
            margin-top: 8px;
            font-size: 0.92rem;
        }

        .delete-hint {
            color: var(--muted);
        }

        .delete-error {
            color: var(--danger);
        }

        @media (max-width: 900px) {
            .empresa-row,
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
            .row-shell {
                padding: 22px;
                border-radius: 24px;
            }

            .delete-form {
                grid-template-columns: 1fr;
            }

            .empresa-main {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell">
            <div class="topbar">
                <div>
                    <h1>Empresas</h1>
                    <p class="intro">Gestiona accesos, imagen de marca y entra a las estadísticas particulares de cada canal.</p>
                </div>

                <div class="actions">
                    <a class="button button-primary" href="{{ route('admin.empresas.create') }}">Nueva empresa</a>
                    <form class="logout-form" method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="button button-secondary" type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </div>

            @if (session('status'))
                <div class="notice">{{ session('status') }}</div>
            @endif

            @if ($empresas->isEmpty())
                <p class="empty">No hay empresas registradas.</p>
            @else
                <div class="list">
                    @foreach ($empresas as $empresa)
                        <div class="row-shell">
                            <div class="empresa-row">
                                <div class="empresa-main">
                                    <div class="swatch" style="background:linear-gradient(135deg, {{ $empresa->color_principal_hex }} 0%, {{ $empresa->color_secundario_hex }} 100%);"></div>
                                    <div>
                                        <div class="empresa-name">{{ $empresa->nombre }}</div>
                                        <div class="empresa-meta">/canaldedenuncias/{{ $empresa->dominio }} · {{ $empresa->email }}</div>
                                        <div class="empresa-meta">/empresa/{{ $empresa->dominio }}</div>
                                    </div>
                                </div>

                                <div class="row-actions">
                                    <a class="button button-secondary" href="{{ route('canal-denuncias.show', $empresa->dominio) }}">Ver canal</a>
                                    <a class="button button-secondary" href="{{ route('admin.empresas.stats', $empresa) }}">Estadísticas</a>
                                    <a class="button button-secondary" href="{{ route('admin.empresas.edit', $empresa) }}">Editar</a>
                                    <a href="#" class="button delete-toggle" data-delete-toggle="delete-form-{{ $empresa->id }}">Eliminar</a>
                                </div>
                            </div>

                            <div class="delete-panel @if($errors->has('confirmacion_eliminacion') && old('_delete_empresa_id') == $empresa->id) is-open @endif" id="delete-form-{{ $empresa->id }}">
                                <form method="POST" action="{{ route('admin.empresas.destroy', $empresa) }}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_delete_empresa_id" value="{{ $empresa->id }}">
                                    <input type="text" name="confirmacion_eliminacion" placeholder="Escribe {{ $empresa->nombre }}" value="{{ old('_delete_empresa_id') == $empresa->id ? old('confirmacion_eliminacion') : '' }}">
                                    <button class="button delete-button" type="submit">Confirmar borrado</button>
                                </form>
                                <div class="delete-hint">Escribe el nombre exacto para confirmar la eliminación.</div>
                                @if($errors->has('confirmacion_eliminacion') && old('_delete_empresa_id') == $empresa->id)
                                    <div class="delete-error">{{ $errors->first('confirmacion_eliminacion') }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
    <script>
        document.querySelectorAll('[data-delete-toggle]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const panel = document.getElementById(button.getAttribute('data-delete-toggle'));

                if (panel) {
                    panel.classList.toggle('is-open');
                }
            });
        });
    </script>
</body>
</html>
