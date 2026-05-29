@php($isEdit = $empresa->exists)
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>{{ $isEdit ? 'Editar empresa' : 'Nueva empresa' }}</title>
    <style>
        :root {
            --accent: #1d4f8c;
            --accent-deep: #0f2744;
            --ink: #15202b;
            --muted: #61707b;
            --line: rgba(21, 32, 43, 0.10);
            --surface: rgba(248, 251, 255, 0.80);
            --surface-soft: rgba(240, 246, 252, 0.90);
            --shadow: 0 34px 88px rgba(21, 32, 43, 0.12);
            --radius-xl: 34px;
            --radius-lg: 24px;
            --radius-md: 18px;
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
            max-width: 1240px;
            margin: 0 auto;
            padding: 24px 18px 48px;
        }

        .shell {
            border-radius: var(--radius-xl);
            border: 1px solid rgba(255,255,255,0.52);
            background: var(--surface);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow);
            padding: 32px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 28px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            padding: 9px 13px;
            border-radius: 999px;
            background: rgba(29, 79, 140, 0.10);
            color: var(--accent-deep);
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        h1 {
            margin: 0;
            font-family: "Fraunces", "Iowan Old Style", "Palatino Linotype", serif;
            font-size: clamp(2.9rem, 6vw, 4.5rem);
            line-height: 0.92;
            letter-spacing: -0.04em;
        }

        p {
            margin: 0;
            line-height: 1.68;
        }

        .intro {
            margin-top: 14px;
            max-width: 60ch;
            color: var(--muted);
        }

        .back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.86);
            color: var(--ink);
            text-decoration: none;
            font-weight: 800;
            border: 1px solid var(--line);
            white-space: nowrap;
        }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(330px, 0.8fr);
            gap: 22px;
        }

        .stack {
            display: grid;
            gap: 18px;
        }

        .panel {
            padding: 24px;
            border-radius: 28px;
            background: linear-gradient(180deg, rgba(255,255,255,0.72), var(--surface-soft));
            border: 1px solid rgba(21, 32, 43, 0.08);
        }

        .panel-title {
            margin: 0 0 18px;
            font-size: 1.08rem;
            font-weight: 900;
            letter-spacing: -0.02em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 18px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 800;
        }

        input {
            width: 100%;
            border: none;
            border-bottom: 2px solid rgba(29, 79, 140, 0.32);
            border-radius: 0;
            padding: 14px 0 12px;
            font: inherit;
            color: var(--ink);
            background: transparent;
            transition: border-bottom-color 0.18s ease, box-shadow 0.18s ease;
        }

        input[type="text"] {
            background: #EEF3F8;
        }

        textarea {
            background: #EEF3F8;
        }

        input:not([type="file"]):focus {
            outline: none;
            border-bottom-color: var(--accent);
            box-shadow: inset 0 -1px 0 var(--accent);
        }

        input[type="file"] {
            min-height: 56px;
            padding: 12px 0 14px;
            border: none;
            border-bottom: 2px solid rgba(29, 79, 140, 0.32);
            border-radius: 0;
            color: var(--muted);
            background: transparent;
        }

        input[type="file"]::file-selector-button {
            border: 0;
            margin-right: 14px;
            padding: 8px 0 6px;
            border-radius: 0;
            border-bottom: 2px solid var(--accent);
            background: transparent;
            color: var(--accent);
            font: inherit;
            font-weight: 800;
            cursor: pointer;
        }

        .error {
            margin-top: 8px;
            color: var(--danger);
            font-size: 0.92rem;
        }

        .hint {
            display: block;
            margin-top: 8px;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.55;
        }

        .color-block {
            display: grid;
            gap: 14px;
        }

        .color-input-row {
            display: grid;
            grid-template-columns: minmax(180px, 240px) minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
        }

        .color-picker {
            width: 100%;
            min-height: 58px;
            padding: 4px;
            border-radius: 999px;
            border: 1px solid rgba(21, 32, 43, 0.12);
            background: #fff;
            cursor: pointer;
        }

        .hex-input {
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .secondary-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .picker-button,
        .ghost-button,
        .primary-button {
            min-height: 50px;
            padding: 0 20px;
            border-radius: 999px;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
        }

        .picker-button {
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.9);
            color: var(--ink);
            white-space: nowrap;
        }

        .ghost-button {
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.84);
            color: var(--ink);
        }

        .primary-button {
            border: 0;
            color: #fff;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%);
            box-shadow: 0 20px 40px rgba(29, 79, 140, 0.18);
        }

        .submit-row {
            display: flex;
            justify-content: flex-start;
        }

        .preview-box {
            min-height: 210px;
            border-radius: 26px;
            overflow: hidden;
            border: 1px solid rgba(21, 32, 43, 0.08);
            background: linear-gradient(180deg, rgba(255,255,255,0.84), rgba(241,246,252,0.94));
            position: relative;
            padding: 18px;
        }

        .preview-box::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(120deg, rgba(255,255,255,0.24), transparent 42%),
                radial-gradient(circle at 85% 15%, rgba(255,255,255,0.18), transparent 0 24%);
        }

        .preview-colors {
            position: relative;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            height: 100%;
            align-items: stretch;
        }

        .preview-color {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 170px;
            border-radius: 22px;
            border: 1px solid rgba(255,255,255,0.44);
            padding: 16px;
            color: #fff;
            background: var(--preview-fill, #1d4f8c);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.20);
        }

        .preview-color.is-empty {
            color: var(--muted);
            background:
                repeating-linear-gradient(
                    135deg,
                    rgba(21,32,43,0.04) 0 10px,
                    rgba(255,255,255,0.44) 10px 20px
                ),
                rgba(255,255,255,0.72);
            border-style: dashed;
            border-color: rgba(21, 32, 43, 0.14);
        }

        .preview-color strong {
            display: block;
            margin-bottom: 4px;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .preview-token {
            position: relative;
            margin-top: 8px;
            font-weight: 700;
            line-height: 1.45;
        }

        .meta-item strong {
            display: block;
            margin-bottom: 4px;
        }

        .meta {
            display: grid;
            gap: 14px;
        }

        .meta-item {
            padding-top: 14px;
            border-top: 1px solid rgba(21, 32, 43, 0.08);
        }

        .meta-item:first-child {
            padding-top: 0;
            border-top: 0;
        }

        .meta-item span,
        .meta-item a {
            color: var(--muted);
            text-decoration: none;
            word-break: break-word;
        }

        @media (max-width: 980px) {
            .layout,
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .page {
                padding: 16px 14px 40px;
            }

            .shell,
            .panel {
                padding: 22px;
                border-radius: 24px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .color-input-row,
            .preview-colors {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell">
            <div class="topbar">
                <div>
                    <span class="eyebrow">Administración</span>
                    <h1>{{ $isEdit ? 'Editar empresa' : 'Nueva empresa' }}</h1>
                    <p class="intro">Configura el acceso público, la identidad visual y el acceso privado de la empresa a su panel de denuncias.</p>
                </div>

                <a class="back" href="{{ route('admin.empresas.index') }}">Volver</a>
            </div>

            <div class="layout">
                <div class="stack">
                    <form method="POST" action="{{ $isEdit ? route('admin.empresas.update', $empresa) : route('admin.empresas.store') }}" enctype="multipart/form-data" class="stack">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <section class="panel">
                            <h2 class="panel-title">Datos de empresa</h2>

                            <div class="form-grid">
                                <div>
                                    <label for="nombre">Nombre</label>
                                    <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $empresa->nombre) }}" required>
                                    @error('nombre') <div class="error">{{ $message }}</div> @enderror
                                </div>

                                <div>
                                    <label for="dominio">Dominio URL</label>
                                    <input id="dominio" type="text" name="dominio" value="{{ old('dominio', $empresa->dominio) }}" required>
                                    @error('dominio') <div class="error">{{ $message }}</div> @enderror
                                </div>

                                <div class="field-full">
                                    <label for="email">Correo</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', $empresa->email) }}" required>
                                    @error('email') <div class="error">{{ $message }}</div> @enderror
                                </div>

                                <div class="field-full">
                                    <label for="password">Contraseña de acceso de la empresa</label>
                                    <input id="password" type="password" name="password" {{ $isEdit ? '' : 'required' }}>
                                    @error('password') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">{{ $isEdit ? 'Déjala vacía si no quieres cambiarla.' : 'La empresa utilizará esta contraseña para acceder a su panel privado.' }}</span>
                                </div>
                            </div>
                        </section>

                        <section class="panel">
                            <h2 class="panel-title">Enlaces legales</h2>

                            <div class="form-grid">
                                <div class="field-full">
                                    <label for="politica_privacidad_url">Política de privacidad</label>
                                    <input id="politica_privacidad_url" type="url" name="politica_privacidad_url" value="{{ old('politica_privacidad_url', $empresa->politica_privacidad_url) }}" required>
                                    @error('politica_privacidad_url') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Introduce la URL completa. Este enlace se mostrará en el semipie del canal.</span>
                                </div>

                                <div class="field-full">
                                    <label for="politica_cookies_url">Política de cookies</label>
                                    <input id="politica_cookies_url" type="url" name="politica_cookies_url" value="{{ old('politica_cookies_url', $empresa->politica_cookies_url) }}" required>
                                    @error('politica_cookies_url') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Introduce la URL completa. Este enlace se mostrará en el semipie del canal.</span>
                                </div>

                                <div class="field-full">
                                    <label for="aviso_legal_url">Aviso legal</label>
                                    <input id="aviso_legal_url" type="url" name="aviso_legal_url" value="{{ old('aviso_legal_url', $empresa->aviso_legal_url) }}" required>
                                    @error('aviso_legal_url') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Introduce la URL completa. Este enlace se mostrará en el semipie del canal.</span>
                                </div>
                            </div>
                        </section>

                        <section class="panel">
                            <h2 class="panel-title">Recursos del canal</h2>

                            <div class="form-grid">
                                <div>
                                    <label for="logo">Logo</label>
                                    <input id="logo" type="file" name="logo" {{ $isEdit ? '' : 'required' }}>
                                    @error('logo') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Formatos admitidos: JPG, PNG, WEBP o SVG.</span>
                                </div>

                                <div>
                                    <label for="pdf_normativa">PDF de normativa</label>
                                    <input id="pdf_normativa" type="file" name="pdf_normativa">
                                    @error('pdf_normativa') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Documento que se mostrará en el canal público de la empresa.</span>
                                </div>
                            </div>
                        </section>

                        <section class="panel">
                            <h2 class="panel-title">Identidad cromática</h2>

                            <div class="stack">
                                <div class="color-block">
                                    <label for="color_principal_hex">Color principal</label>
                                    <div class="color-input-row">
                                        <input id="color_principal_picker" class="color-picker" type="color" value="{{ old('color_principal', $empresa->color_principal ?: '#1d4f8c') }}">
                                        <input id="color_principal_hex" class="hex-input" type="text" name="color_principal" value="{{ old('color_principal', $empresa->color_principal ?: '#1d4f8c') }}" required>
                                        <button type="button" class="picker-button" data-open-picker="color_principal_picker">Elegir</button>
                                    </div>
                                    @error('color_principal') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Pulsa en la barra o en <strong>Elegir</strong> para abrir el panel de color, o escribe el HEX manualmente.</span>
                                </div>

                                <div class="color-block">
                                    <label for="color_secundario_hex">Color secundario</label>
                                    <div class="color-input-row">
                                        <input id="color_secundario_picker" class="color-picker" type="color" value="{{ old('color_secundario', $empresa->color_secundario ?: '#0f2744') }}">
                                        <input id="color_secundario_hex" class="hex-input" type="text" name="color_secundario" value="{{ old('color_secundario', $empresa->color_secundario ?: '') }}" placeholder="Opcional">
                                        <button type="button" class="picker-button" data-open-picker="color_secundario_picker">Elegir</button>
                                    </div>
                                    @error('color_secundario') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Este color es independiente. Si lo dejas vacío, simplemente no habrá color secundario definido.</span>

                                    <div class="secondary-actions">
                                        <button type="button" class="ghost-button" id="clear-secondary">Sin color secundario</button>
                                    </div>
                                </div>

                                <div class="color-block">
                                    <label for="color_inputs_hex">Color inputs</label>
                                    <div class="color-input-row">
                                        <input id="color_inputs_picker" class="color-picker" type="color" value="{{ old('color_inputs', $empresa->color_inputs ?: ($empresa->color_inputs_hex ?? '#1d4f8c')) }}">
                                        <input id="color_inputs_hex" class="hex-input" type="text" name="color_inputs" value="{{ old('color_inputs', $empresa->color_inputs ?: '') }}" placeholder="Opcional">
                                        <button type="button" class="picker-button" data-open-picker="color_inputs_picker">Elegir</button>
                                    </div>
                                    @error('color_inputs') <div class="error">{{ $message }}</div> @enderror
                                    <span class="hint">Define el color real de líneas, calendario y controles de formulario. Si lo dejas vacío, se generará a partir del principal.</span>

                                    <div class="secondary-actions">
                                        <button type="button" class="ghost-button" id="clear-inputs">Usar automático</button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="submit-row">
                            <button class="primary-button" type="submit">{{ $isEdit ? 'Guardar cambios' : 'Crear empresa' }}</button>
                        </div>
                    </form>
                </div>

                <aside class="stack">
                    <section class="panel">
                        <h2 class="panel-title">Vista rápida</h2>

                        <div class="preview-box">
                            <div class="preview-colors">
                                <div class="preview-color" id="primary-preview" style="--preview-fill: {{ old('color_principal', $empresa->color_principal ?: '#1d4f8c') }};">
                                    <strong>Principal</strong>
                                    <div class="preview-token" id="primary-preview-text">{{ old('color_principal', $empresa->color_principal ?: '#1d4f8c') }}</div>
                                </div>
                                <div class="preview-color {{ old('color_secundario', $empresa->color_secundario ?: '') ? '' : 'is-empty' }}" id="secondary-preview" style="--preview-fill: {{ old('color_secundario', $empresa->color_secundario ?: '#0f2744') }};">
                                    <strong>Secundario</strong>
                                    <div class="preview-token" id="secondary-preview-text">{{ old('color_secundario', $empresa->color_secundario ?: 'Sin definir') }}</div>
                                </div>
                                <div class="preview-color {{ old('color_inputs', $empresa->color_inputs ?: '') ? '' : 'is-empty' }}" id="inputs-preview" style="--preview-fill: {{ old('color_inputs', $empresa->color_inputs ?: ($empresa->color_inputs_hex ?? '#1d4f8c')) }};">
                                    <strong>Inputs</strong>
                                    <div class="preview-token" id="inputs-preview-text">{{ old('color_inputs', $empresa->color_inputs ?: 'Automático') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="meta" style="margin-top:18px;">
                            <div class="meta-item">
                                <strong>Acceso público</strong>
                                <span>/canaldedenuncias/{{ old('dominio', $empresa->dominio ?: 'dominio-empresa') }}</span>
                            </div>

                            <div class="meta-item">
                                <strong>Acceso empresa</strong>
                                <span>/canaldedenuncias/empresa/{{ old('dominio', $empresa->dominio ?: 'dominio-empresa') }}</span>
                            </div>

                            <div class="meta-item">
                                <strong>Correo de referencia</strong>
                                <span>{{ old('email', $empresa->email ?: 'Sin definir') }}</span>
                            </div>

                            <div class="meta-item">
                                <strong>Normativa</strong>
                                @if ($empresa->normativa_url)
                                    <a href="{{ $empresa->normativa_url }}" target="_blank" rel="noopener noreferrer">Documento disponible</a>
                                @else
                                    <span>Sin documento cargado</span>
                                @endif
                            </div>

                            <div class="meta-item">
                                <strong>Política de privacidad</strong>
                                <a href="{{ old('politica_privacidad_url', $empresa->politica_privacidad_url ?: '#') }}" target="_blank" rel="noopener noreferrer">{{ old('politica_privacidad_url', $empresa->politica_privacidad_url ?: 'Sin definir') }}</a>
                            </div>

                            <div class="meta-item">
                                <strong>Política de cookies</strong>
                                <a href="{{ old('politica_cookies_url', $empresa->politica_cookies_url ?: '#') }}" target="_blank" rel="noopener noreferrer">{{ old('politica_cookies_url', $empresa->politica_cookies_url ?: 'Sin definir') }}</a>
                            </div>

                            <div class="meta-item">
                                <strong>Aviso legal</strong>
                                <a href="{{ old('aviso_legal_url', $empresa->aviso_legal_url ?: '#') }}" target="_blank" rel="noopener noreferrer">{{ old('aviso_legal_url', $empresa->aviso_legal_url ?: 'Sin definir') }}</a>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </section>
    </main>

    <script>
        const primaryPicker = document.getElementById('color_principal_picker');
        const primaryHex = document.getElementById('color_principal_hex');
        const secondaryPicker = document.getElementById('color_secundario_picker');
        const secondaryHex = document.getElementById('color_secundario_hex');
        const inputsPicker = document.getElementById('color_inputs_picker');
        const inputsHex = document.getElementById('color_inputs_hex');
        const primaryPreview = document.getElementById('primary-preview');
        const primaryPreviewText = document.getElementById('primary-preview-text');
        const secondaryPreview = document.getElementById('secondary-preview');
        const secondaryPreviewText = document.getElementById('secondary-preview-text');
        const inputsPreview = document.getElementById('inputs-preview');
        const inputsPreviewText = document.getElementById('inputs-preview-text');
        const clearSecondaryButton = document.getElementById('clear-secondary');
        const clearInputsButton = document.getElementById('clear-inputs');

        function normalizeHex(value, fallback = '') {
            const normalized = String(value || '').trim().toUpperCase();
            return /^#([0-9A-F]{3}|[0-9A-F]{6})$/.test(normalized) ? normalized : fallback;
        }

        function syncPreview() {
            const primary = normalizeHex(primaryHex.value, '#1D4F8C');
            const secondary = normalizeHex(secondaryHex.value, '');
            const inputs = normalizeHex(inputsHex.value, '');

            primaryPreview.style.setProperty('--preview-fill', primary);
            primaryPreviewText.textContent = primary;
            primaryPicker.value = primary;

            if (secondary) {
                secondaryPreview.style.setProperty('--preview-fill', secondary);
                secondaryPreview.classList.remove('is-empty');
                secondaryPreviewText.textContent = secondary;
                secondaryPicker.value = secondary;
            } else {
                secondaryPreview.style.setProperty('--preview-fill', '#F2ECE4');
                secondaryPreview.classList.add('is-empty');
                secondaryPreviewText.textContent = 'Sin definir';
            }

            if (inputs) {
                inputsPreview.style.setProperty('--preview-fill', inputs);
                inputsPreview.classList.remove('is-empty');
                inputsPreviewText.textContent = inputs;
                inputsPicker.value = inputs;
            } else {
                inputsPreview.style.setProperty('--preview-fill', primary);
                inputsPreview.classList.add('is-empty');
                inputsPreviewText.textContent = 'Automático';
                inputsPicker.value = primary;
            }
        }

        primaryPicker.addEventListener('input', () => {
            primaryHex.value = primaryPicker.value.toUpperCase();
            syncPreview();
        });

        primaryHex.addEventListener('input', () => {
            const normalized = normalizeHex(primaryHex.value);
            if (normalized) {
                primaryPicker.value = normalized;
            }
            syncPreview();
        });

        secondaryPicker.addEventListener('input', () => {
            secondaryHex.value = secondaryPicker.value.toUpperCase();
            syncPreview();
        });

        secondaryHex.addEventListener('input', () => {
            const normalized = normalizeHex(secondaryHex.value);
            if (normalized) {
                secondaryPicker.value = normalized;
            }
            syncPreview();
        });

        inputsPicker.addEventListener('input', () => {
            inputsHex.value = inputsPicker.value.toUpperCase();
            syncPreview();
        });

        inputsHex.addEventListener('input', () => {
            const normalized = normalizeHex(inputsHex.value);
            if (normalized) {
                inputsPicker.value = normalized;
            }
            syncPreview();
        });

        clearSecondaryButton.addEventListener('click', () => {
            secondaryHex.value = '';
            syncPreview();
        });

        clearInputsButton.addEventListener('click', () => {
            inputsHex.value = '';
            syncPreview();
        });

        document.querySelectorAll('[data-open-picker]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.openPicker);

                if (input) {
                    input.click();
                }
            });
        });

        syncPreview();
    </script>
</body>
</html>
