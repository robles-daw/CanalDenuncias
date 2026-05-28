@php
    $themeAccent = $themeAccent ?? (isset($empresa) ? $empresa->color_principal_hex : '#1d4f8c');
    $themeAccentDeep = $themeAccentDeep ?? (isset($empresa) ? $empresa->color_secundario_hex : '#0f2744');
    $themeAccentContrast = $themeAccentContrast ?? (isset($empresa) ? $empresa->color_principal_contrast : '#ffffff');
    $themeAccentDeepContrast = $themeAccentDeepContrast ?? (isset($empresa) ? $empresa->color_secundario_contrast : '#ffffff');
    $themeBrandContrast = $themeBrandContrast ?? (isset($empresa) ? $empresa->brand_contrast : '#ffffff');
    $themeFieldAccent = $themeFieldAccent ?? (isset($empresa) ? $empresa->color_inputs_hex : '#1d4f8c');
    $themeFieldAccentSoft = $themeFieldAccentSoft ?? (isset($empresa) ? $empresa->color_inputs_soft : '#567fb0');
@endphp
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --accent: {{ $themeAccent }};
        --accent-deep: {{ $themeAccentDeep }};
        --accent-contrast: {{ $themeAccentContrast }};
        --accent-deep-contrast: {{ $themeAccentDeepContrast }};
        --brand-contrast: {{ $themeBrandContrast }};
        --field-accent: {{ $themeFieldAccent }};
        --field-accent-soft: {{ $themeFieldAccentSoft }};

        --accent-soft: color-mix(in srgb, var(--accent) 16%, white);
        --accent-fog: color-mix(in srgb, var(--accent) 8%, white);
        --accent-tint: color-mix(in srgb, var(--accent-deep) 12%, white);

        --ink: #0f1822;
        --ink-soft: #2a3744;
        --muted: #64707d;
        --muted-2: #8893a0;
        --line: rgba(15, 24, 34, 0.08);
        --line-strong: rgba(15, 24, 34, 0.14);

        --surface: rgba(248, 251, 255, 0.76);
        --surface-strong: rgba(255, 255, 255, 0.96);
        --surface-frost: rgba(248, 251, 255, 0.62);

        --ok: #166534;
        --danger: #b42318;

        --shadow-sm: 0 2px 6px rgba(15, 24, 34, 0.04), 0 1px 2px rgba(15, 24, 34, 0.06);
        --shadow-md: 0 12px 28px rgba(15, 24, 34, 0.08), 0 2px 6px rgba(15, 24, 34, 0.04);
        --shadow-lg: 0 40px 80px -20px rgba(15, 24, 34, 0.22), 0 18px 36px -18px rgba(15, 24, 34, 0.14);
        --shadow-brand: 0 24px 60px -18px color-mix(in srgb, var(--accent-deep) 42%, transparent);

        --radius-xs: 10px;
        --radius-sm: 14px;
        --radius-md: 20px;
        --radius-lg: 28px;
        --radius-xl: 36px;

        --ease: cubic-bezier(0.22, 1, 0.36, 1);
    }

    *, *::before, *::after {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }

    body {
        margin: 0;
        min-height: 100vh;
        font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
        font-feature-settings: "ss01", "cv11";
        color: var(--ink);
        background:
            radial-gradient(1200px 700px at 8% -5%, color-mix(in srgb, var(--accent) 24%, transparent), transparent 60%),
            radial-gradient(900px 600px at 100% 10%, color-mix(in srgb, var(--accent-deep) 18%, transparent), transparent 55%),
            linear-gradient(180deg, #f6f9fd 0%, #edf3f9 100%);
        background-attachment: fixed;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        pointer-events: none;
        background-image: radial-gradient(rgba(15, 24, 34, 0.04) 1px, transparent 1px);
        background-size: 22px 22px;
        mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        opacity: 0.35;
        z-index: 0;
    }

    h1, h2, h3 {
        margin: 0;
        color: var(--ink);
        letter-spacing: -0.025em;
    }

    h1, .display-title {
        font-family: "Fraunces", "Iowan Old Style", "Palatino Linotype", serif;
        font-weight: 500;
        font-variation-settings: "opsz" 144, "SOFT" 30;
    }

    h2 {
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: -0.015em;
    }

    h3,
    .section-kicker {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--muted);
    }

    p {
        margin: 0;
        line-height: 1.65;
    }

    .page {
        position: relative;
        z-index: 1;
        max-width: 1280px;
        margin: 0 auto;
        padding: 36px 22px 72px;
    }

    .glass {
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.55);
        background: var(--surface);
        backdrop-filter: blur(22px) saturate(1.15);
        -webkit-backdrop-filter: blur(22px) saturate(1.15);
        box-shadow: var(--shadow-lg);
    }

    .glass::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.45), transparent 30%);
        mix-blend-mode: overlay;
        opacity: 0.6;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.85);
        color: var(--ink);
        border: 1px solid rgba(15, 24, 34, 0.06);
        box-shadow: var(--shadow-sm);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .eyebrow::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: var(--accent-deep);
        box-shadow: 0 0 0 4px color-mix(in srgb, var(--accent-deep) 22%, transparent);
    }

    .button,
    button,
    .back {
        appearance: none;
        border: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 50px;
        padding: 0 24px;
        border-radius: 999px;
        text-decoration: none;
        font: inherit;
        font-weight: 600;
        letter-spacing: -0.005em;
        cursor: pointer;
        transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease), background 0.25s var(--ease), border-color 0.25s var(--ease);
        will-change: transform;
    }

    .button:hover,
    button:hover,
    .back:hover {
        transform: translateY(-2px);
    }

    .button:active,
    button:active,
    .back:active {
        transform: translateY(0);
    }

    .button-primary,
    .primary-button,
    button[type="submit"],
    .delete-button {
        color: var(--accent-deep-contrast);
        background:
            linear-gradient(135deg,
                color-mix(in srgb, var(--accent-deep) 88%, white) 0%,
                var(--accent-deep) 50%,
                color-mix(in srgb, var(--accent-deep) 80%, black) 100%);
        box-shadow: var(--shadow-brand), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .button-primary:hover,
    .primary-button:hover,
    button[type="submit"]:hover,
    .delete-button:hover {
        box-shadow: 0 30px 70px -18px color-mix(in srgb, var(--accent-deep) 60%, transparent), inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .button-secondary,
    .ghost-button,
    .picker-button,
    .back {
        color: var(--ink);
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(15, 24, 34, 0.08);
        box-shadow: var(--shadow-sm);
    }

    .button-secondary:hover,
    .ghost-button:hover,
    .picker-button:hover,
    .back:hover {
        background: #fff;
        box-shadow: var(--shadow-md);
    }

    .panel,
    .shell,
    .card,
    .side-card,
    .side-panel,
    .stat-card {
        position: relative;
        border-radius: var(--radius-xl);
        padding: 32px;
        background: var(--surface-strong);
        border: 1px solid rgba(255, 255, 255, 0.55);
        box-shadow: var(--shadow-lg);
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--ink);
        letter-spacing: -0.005em;
    }

    input,
    select,
    textarea {
        width: 100%;
        border: none;
        border-bottom: 2px solid var(--field-accent-soft);
        border-radius: 0;
        padding: 14px 0 12px;
        font: inherit;
        font-size: 0.97rem;
        color: var(--ink);
        background: transparent;
        box-shadow: none;
        transition: border-bottom-color 0.2s var(--ease), box-shadow 0.2s var(--ease);
    }

    input::placeholder,
    textarea::placeholder {
        color: var(--muted-2);
    }

    input[type="text"] {
        background: #EEF3F8;
    }

    textarea {
        background: #EEF3F8;
    }

    input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):hover,
    select:hover,
    textarea:hover {
        border-bottom-color: var(--field-accent);
    }

    input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-bottom-color: var(--field-accent);
        box-shadow: inset 0 -1px 0 var(--field-accent);
    }

    input[type="file"] {
        border: none;
        border-bottom: 2px solid var(--field-accent-soft);
        border-radius: 0;
        padding: 12px 0 14px;
        background: transparent;
        color: var(--muted);
        transition: border-bottom-color 0.2s var(--ease), box-shadow 0.2s var(--ease);
    }

    input[type="file"]:focus {
        outline: none;
        border-bottom-color: var(--field-accent);
        box-shadow: inset 0 -1px 0 var(--field-accent);
    }

    input[type="file"]::file-selector-button {
        border: 0;
        border-bottom: 2px solid var(--field-accent);
        border-radius: 0;
        margin-right: 14px;
        padding: 8px 0 6px;
        background: transparent;
        color: var(--field-accent);
        font: inherit;
        font-weight: 700;
        cursor: pointer;
    }

    .notice,
    .status {
        padding: 14px 18px;
        border-radius: var(--radius-sm);
        border: 1px solid color-mix(in srgb, var(--ok) 22%, transparent);
        background: color-mix(in srgb, var(--ok) 8%, white);
        color: var(--ok);
        font-size: 0.92rem;
        font-weight: 500;
    }

    .error,
    .field-error,
    .delete-error {
        color: var(--danger);
        font-size: 0.88rem;
        font-weight: 500;
    }

    .hint,
    .subtitle,
    .intro,
    .meta,
    .empty,
    .delete-hint {
        color: var(--muted);
        line-height: 1.6;
    }

    @media (max-width: 820px) {
        .page {
            padding: 20px 14px 48px;
        }

        .panel,
        .shell,
        .card,
        .side-card,
        .side-panel,
        .stat-card {
            padding: 24px 22px;
            border-radius: var(--radius-lg);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
