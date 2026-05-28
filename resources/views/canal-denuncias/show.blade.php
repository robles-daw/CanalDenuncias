<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canal de denuncias · {{ $empresa->nombre }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: {{ $empresa->color_principal_hex }};
            --accent-deep: {{ $empresa->color_secundario_hex }};
            --accent-contrast: {{ $empresa->color_principal_contrast }};
            --accent-deep-contrast: {{ $empresa->color_secundario_contrast }};
            --field-accent: {{ $empresa->color_inputs_hex }};
            --field-accent-soft: {{ $empresa->color_inputs_soft }};
            --ink: #16202a;
            --ink-soft: #45515f;
            --muted: #687483;
            --line: rgba(22, 32, 42, 0.12);
            --line-strong: rgba(22, 32, 42, 0.18);
            --surface: #ffffff;
            --surface-soft: #f4f8fc;
            --surface-muted: #e8f0f7;
            --danger: #b42318;
            --ok: #166534;
            --shadow: 0 18px 42px rgba(22, 32, 42, 0.08);
            --radius-xl: 24px;
            --radius-lg: 18px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --ease: cubic-bezier(0.22, 1, 0.36, 1);
            --accent-tint: color-mix(in srgb, var(--accent) 8%, white);
            --accent-wash: color-mix(in srgb, var(--accent) 12%, white);
            --accent-edge: color-mix(in srgb, var(--accent) 18%, rgba(22, 32, 42, 0.12));
            --brand-tint: color-mix(in srgb, var(--accent) 10%, white);
            --brand-wash: color-mix(in srgb, var(--accent) 14%, white);
            --brand-edge: color-mix(in srgb, var(--accent) 20%, rgba(22, 32, 42, 0.16));
            --ui-tint: #f6f8fb;
            --ui-wash: #eef3f8;
            --ui-edge: rgba(74, 92, 115, 0.18);
            --ui-focus: #3d5875;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Inter", "Segoe UI", system-ui, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(720px 360px at 0% 0%, color-mix(in srgb, var(--accent) 12%, transparent), transparent 72%),
                radial-gradient(620px 300px at 100% 0%, color-mix(in srgb, var(--accent-deep) 10%, transparent), transparent 74%),
                linear-gradient(180deg, #f6f9fd 0%, #ecf3f9 100%);
        }

        h1, h2, h3, p {
            margin: 0;
        }

        h1, h2 {
            font-family: "Source Serif 4", Georgia, serif;
            letter-spacing: -0.02em;
            color: var(--ink);
        }

        h1 {
            font-size: clamp(2.4rem, 4.2vw, 3.8rem);
            line-height: 0.98;
            font-weight: 600;
        }

        h2 {
            font-size: 1.5rem;
            line-height: 1.08;
            font-weight: 600;
        }

        h3 {
            font-size: 0.8rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 700;
        }

        p {
            line-height: 1.65;
        }

        a {
            color: color-mix(in srgb, var(--accent) 62%, var(--ink));
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .page {
            max-width: 1280px;
            margin: 0 auto;
            padding: 28px 20px 48px;
        }

        .topbar {
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) minmax(280px, 0.75fr);
            gap: 20px;
            margin-bottom: 22px;
        }

        .hero,
        .brand-panel,
        .panel,
        .side-card,
        .side-note {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.72);
            box-shadow: var(--shadow);
        }

        .hero {
            padding: 30px;
            border-radius: var(--radius-xl);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--brand-tint);
            border: 1px solid var(--brand-edge);
            color: var(--ink-soft);
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--accent);
        }

        .hero h1 {
            margin-top: 18px;
            max-width: 10ch;
        }

        .hero-copy {
            max-width: 58ch;
            margin-top: 16px;
            color: var(--ink-soft);
            font-size: 1rem;
            border-left: 3px solid color-mix(in srgb, var(--accent) 64%, white);
            padding-left: 14px;
        }

        .hero-points {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 24px;
        }

        .hero-point {
            padding: 16px;
            border-radius: var(--radius-md);
            background: var(--brand-tint);
            border: 1px solid var(--brand-edge);
        }

        .hero-point strong {
            display: block;
            font-size: 0.94rem;
            color: var(--ink);
        }

        .hero-point span {
            display: block;
            margin-top: 6px;
            font-size: 0.9rem;
            color: var(--muted);
            line-height: 1.5;
        }

        .brand-panel {
            display: grid;
            gap: 16px;
            padding: 22px;
            border-radius: var(--radius-xl);
            align-content: start;
        }

        .brand-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px;
            border-radius: var(--radius-lg);
            background: #fff;
	    border: 1px solid var(--accent);
            color: var(--accent-contrast);
        }

	.brand-top {
	   display: flex;
	   gap: 35px;
	   align-items: center;
	}

        .brand-logo {
            width: 85px;
            height: 85px;
            border-radius: 14px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }

        .brand-logo svg {
            width: 36px;
            height: 36px;
            color: #fff;
        }

	.brand-meta {
	    color: #000
	}

        .brand-copy strong,
        .side-note strong {
            display: block;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            opacity: 0.78;
        }

        .brand-copy span {
            display: block;
            margin-top: 6px;
            font-size: 1.02rem;
            font-weight: 700;
        }

        .brand-copy p {
            margin-top: 6px;
            font-size: 0.9rem;
            color: color-mix(in srgb, var(--accent-contrast) 84%, white);
        }

        .brand-actions {
            display: flex;
        }

        .brand-info {
            display: grid;
            gap: 12px;
            padding-top: 4px;
        }

        .brand-info-row {
            display: grid;
            gap: 4px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.18);
        }

        .brand-info-row:first-child {
            border-top: 0;
            padding-top: 0;
        }

        .brand-info-row strong {
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            opacity: 0.78;
        }

        .brand-info-row span,
        .brand-info-row a {
            font-size: 0.9rem;
            line-height: 1.5;
            color: var(--ink);
            word-break: break-word;
        }

        .button,
        button {
            appearance: none;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 20px;
            border-radius: 999px;
            text-decoration: none;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.18s var(--ease), box-shadow 0.18s var(--ease), background 0.18s var(--ease);
        }

        .button:hover,
        button:hover {
            transform: translateY(-1px);
        }

        .button-secondary {
            width: 100%;
            background: var(--brand-wash);
            color: var(--ink);
            border-color: var(--brand-edge);
        }

        button {
            background: linear-gradient(135deg, color-mix(in srgb, var(--accent-deep) 88%, white) 0%, var(--accent-deep) 100%);
            color: var(--accent-deep-contrast);
            box-shadow: 0 12px 26px color-mix(in srgb, var(--accent-deep) 16%, transparent);
        }

        .layout {
            display: block;
        }

        .panel {
            padding: 28px;
            border-radius: var(--radius-xl);
            width: 100%;
        }

        .panel-heading {
            padding-bottom: 18px;
            border-bottom: 1px solid var(--ui-edge);
            margin-bottom: 22px;
        }

        .panel-heading p {
            margin-top: 8px;
            max-width: 56ch;
            color: var(--muted);
        }

        .stack > * + * {
            margin-top: 20px;
        }

        .section {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .section-block {
            padding-top: 18px;
            border-top: 1px solid var(--ui-edge);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
        }

        .input-shell {
            position: relative;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        textarea,
        .search-input {
            width: 100%;
            font: inherit;
            font-size: 0.95rem;
            color: var(--ink);
            background: transparent;
            border: none;
            border-bottom: 2px solid var(--field-accent-soft);
            border-radius: 0;
            padding: 14px 0 12px;
            outline: none;
            transition: border-bottom-color 0.18s var(--ease), box-shadow 0.18s var(--ease);
        }

        input[type="text"] {
            background: #EEF3F8;
        }

        textarea {
            background: #EEF3F8;
        }

        textarea {
            min-height: 144px;
            resize: vertical;
            line-height: 1.6;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        .search-input:focus {
            border-bottom-color: var(--field-accent);
            box-shadow: inset 0 -1px 0 var(--field-accent);
        }

        input[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .file-field {
            display: flex;
            align-items: center;
            gap: 16px;
            height: 48px;
            margin-top: -1px;
            border-bottom: 2px solid var(--field-accent-soft);
            padding: 0;
            transition: border-bottom-color 0.18s var(--ease), box-shadow 0.18s var(--ease);
        }

        .file-field:focus-within {
            border-bottom-color: var(--field-accent);
            box-shadow: inset 0 -1px 0 var(--field-accent);
        }

        .file-trigger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            padding: 0 18px;
            border: 1px solid color-mix(in srgb, var(--field-accent) 24%, transparent);
            border-radius: 999px;
            background: color-mix(in srgb, var(--field-accent) 10%, white);
            color: var(--field-accent);
            font-size: 0.84rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.18s var(--ease), border-color 0.18s var(--ease), transform 0.18s var(--ease);
        }

        .file-trigger:hover {
            transform: translateY(-1px);
            background: color-mix(in srgb, var(--field-accent) 14%, white);
        }

        .file-name {
            color: var(--muted);
            line-height: 1.5;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .flatpickr-calendar {
            width: 320px;
            padding: 18px 18px 14px;
            border: 1px solid color-mix(in srgb, var(--field-accent) 18%, rgba(22, 32, 42, 0.08));
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(247, 250, 253, 0.98) 100%);
            box-shadow: 0 26px 58px rgba(22, 32, 42, 0.16);
        }

        .flatpickr-calendar.arrowTop::before,
        .flatpickr-calendar.arrowTop::after {
            display: none;
        }

        .flatpickr-months {
            align-items: center;
            margin-bottom: 14px;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            top: 16px;
            width: 34px;
            height: 34px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: var(--field-accent);
            transition: background 0.18s var(--ease), color 0.18s var(--ease), transform 0.18s var(--ease);
        }

        .flatpickr-months .flatpickr-prev-month svg,
        .flatpickr-months .flatpickr-next-month svg {
            display: block;
            width: 18px;
            height: 18px;
        }

        .flatpickr-months .flatpickr-prev-month:hover,
        .flatpickr-months .flatpickr-next-month:hover {
            background: color-mix(in srgb, var(--field-accent) 12%, white);
            color: var(--field-accent);
            transform: translateY(-1px);
        }

        .flatpickr-current-month {
            left: 0;
            width: 100%;
            padding: 0 44px;
            font-family: "Source Serif 4", Georgia, serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink);
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            font: inherit;
            color: inherit;
            background: transparent;
        }

        .flatpickr-current-month .numInputWrapper:hover,
        .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
            background: transparent;
        }

        span.flatpickr-weekday {
            color: var(--muted);
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .flatpickr-weekdays {
            margin-bottom: 6px;
        }

        .flatpickr-days,
        .flatpickr-innerContainer,
        .flatpickr-rContainer,
        .dayContainer {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
        }

        .flatpickr-day {
            border-radius: 12px;
            border: 1px solid transparent;
            color: var(--ink);
            font-weight: 600;
            line-height: 38px;
        }

        .flatpickr-day:hover {
            background: color-mix(in srgb, var(--field-accent) 12%, white);
            border-color: color-mix(in srgb, var(--field-accent) 22%, white);
        }

        .flatpickr-day.today {
            border-color: color-mix(in srgb, var(--field-accent) 48%, white);
            color: var(--field-accent);
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: linear-gradient(135deg, var(--field-accent) 0%, color-mix(in srgb, var(--field-accent) 72%, white) 100%);
            border-color: var(--field-accent);
            color: #fff;
            box-shadow: 0 12px 24px color-mix(in srgb, var(--field-accent) 24%, transparent);
        }

        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover,
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: color-mix(in srgb, var(--muted) 72%, white);
        }

        .flatpickr-day.prevMonthDay:hover,
        .flatpickr-day.nextMonthDay:hover {
            background: transparent;
            border-color: transparent;
        }

        .flatpickr-monthDropdown-months,
        .numInput.cur-year {
            pointer-events: none;
        }

        .search-results {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: var(--surface);
            border: 1px solid var(--line-strong);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow);
            z-index: 20;
            max-height: 280px;
            overflow-y: auto;
            padding: 6px;
        }

        .search-results.is-open { display: block; }

        .search-option {
            width: 100%;
            text-align: left;
            background: transparent;
            color: var(--ink);
            border: 0;
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 4px;
            font: inherit;
            box-shadow: none;
        }

        .search-option:hover,
        .search-option.is-active {
            background: var(--ui-wash);
            color: var(--ink);
            transform: none;
        }

        .search-option strong {
            font-size: 0.92rem;
            font-weight: 700;
        }

        .search-option small {
            font-size: 0.82rem;
            color: var(--muted);
        }

        .empty-option {
            padding: 14px;
            font-size: 0.9rem;
            color: var(--muted);
            text-align: center;
        }

        .hint {
            font-size: 0.82rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .field-error {
            font-size: 0.84rem;
            color: var(--danger);
            margin-top: 6px;
            font-weight: 600;
        }

        .error-box {
            background: color-mix(in srgb, var(--danger) 8%, white);
            color: var(--danger);
            border: 1px solid color-mix(in srgb, var(--danger) 22%, transparent);
            border-radius: var(--radius-md);
            padding: 14px 16px;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        @media (max-width: 640px) { .grid-2 { grid-template-columns: 1fr; } }

        .check {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0 14px;
            border-bottom: 2px solid var(--field-accent-soft);
            background: transparent;
            transition: border-bottom-color 0.18s var(--ease);
        }

        .check:focus-within {
            border-bottom-color: var(--field-accent);
        }

        .check input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 1.5px solid var(--field-accent-soft);
            border-radius: 4px;
            background: transparent;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            transition: border-color 0.18s var(--ease), background 0.18s var(--ease), box-shadow 0.18s var(--ease);
        }

        .check input[type="checkbox"]:focus {
            outline: none;
            border-color: var(--field-accent);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--field-accent) 16%, transparent);
        }

        .check input[type="checkbox"]:checked {
            background: var(--field-accent);
            border-color: var(--field-accent);
        }

        .check input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            inset: 0;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 11px 11px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none'%3E%3Cpath d='M3.5 8.5 6.5 11.5 12.5 4.5' stroke='%23ffffff' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        }

        .check label {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--ink-soft);
            cursor: pointer;
        }

        .check label::before { content: ""; }

        h3 {
            font-size: 0.86rem;
            padding: 0;
            background: transparent;
            color: var(--muted);
            display: inline-block;
        }

        .contact-block {
            border-left: 3px solid var(--ink);
            padding-left: 18px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .contact-block.hidden { display: none; }

        .submit-row {
            display: flex;
            justify-content: flex-end;
            padding-top: 18px;
            border-top: 1px solid var(--ui-edge);
        }

        .submit-row button {
            font-size: 0.95rem;
            padding: 16px 28px;
        }

        .semi-footer {
            display: none;
        }

        .legal-links {
            margin-top: 24px;
            display: grid;
            gap: 14px;
            padding: 18px 20px;
            border-radius: var(--radius-lg);
            background: color-mix(in srgb, var(--accent) 8%, white);
            border: 1px solid color-mix(in srgb, var(--accent) 18%, rgba(22, 32, 42, 0.08));
        }

        .legal-links strong {
            font-size: 0.74rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .legal-links-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .legal-links-row a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 999px;
            background: var(--accent);
            color: var(--accent-contrast);
            border: 1px solid color-mix(in srgb, var(--accent) 82%, black);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 700;
            transition: transform 0.18s var(--ease), box-shadow 0.18s var(--ease), filter 0.18s var(--ease);
            box-shadow: 0 12px 24px color-mix(in srgb, var(--accent) 18%, transparent);
        }

        .legal-links-row a:hover {
            transform: translateY(-1px);
            filter: saturate(1.05) brightness(0.98);
        }

        .glass {}

        @media (max-width: 1080px) {
            .topbar {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                max-width: none;
            }
        }
    </style>
</head>
<body>
    @php
        $causaSeleccionada = old('causa_denuncia_id')
            ? optional($causas->firstWhere('id', (int) old('causa_denuncia_id')))->nombre
            : '';
        $usesFallbackLogo = ! $empresa->logo || str_ends_with((string) $empresa->logo, 'default-logo.svg');
        $causasJson = $causas->map(function ($causa) {
            return [
                'id' => $causa->id,
                'nombre' => $causa->nombre,
                'descripcion' => $causa->descripcion,
            ];
        })->values();
    @endphp
    <main class="page">
        <section class="topbar">
            <section class="hero glass">
                <span class="eyebrow">Canal confidencial</span>
                <h1>{{ $empresa->nombre }}</h1>
                <p class="hero-copy">Comunica hechos relevantes de forma segura, reservada y trazable. El sistema genera un código de seguimiento para que puedas consultar la evolución de la comunicación cuando lo necesites.</p>
            </section>

            <aside class="brand-panel hero-side glass">
                <div class="brand-card">
                    <div class="brand-top">
                        <div class="brand-logo">
                            @if (! $usesFallbackLogo && $empresa->logo)
                                <img src="{{ $empresa->logo_url }}" alt="Logo de {{ $empresa->nombre }}">
                            @else
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 3.25l6.5 2.5v4.73c0 4.2-2.6 7.96-6.5 9.27-3.9-1.31-6.5-5.07-6.5-9.27V5.75L12 3.25Z" fill="currentColor" opacity="0.92"/>
                                    <path d="M12 6.2l3.75 1.4v2.94c0 2.55-1.42 4.84-3.75 5.95-2.33-1.11-3.75-3.4-3.75-5.95V7.6L12 6.2Z" fill="rgba(255,255,255,0.22)"/>
                                    <path d="m10.65 12.85-1.55-1.55-1.15 1.15 2.7 2.7 5.4-5.4-1.15-1.15-4.25 4.25Z" fill="#fff"/>
                                </svg>
                            @endif
                        </div>
                        <div class="brand-meta">
                            <strong>Canal activo</strong>
                            <span>{{ $empresa->nombre }}</span>
                        </div>
                    </div>
                </div>

                <div class="hero-actions">
                    <a class="button button-secondary" href="{{ route('canal-denuncias.tracking', $empresa->dominio) }}">Consultar seguimiento</a>
                </div>

                <div class="brand-info">
                    <div class="brand-info-row">
                        <strong>Acceso</strong>
                        <span>/canaldedenuncias/{{ $empresa->dominio }}</span>
                    </div>

                    @if ($empresa->email)
                        <div class="brand-info-row">
                            <strong>Contacto</strong>
                            <span>{{ $empresa->email }}</span>
                        </div>
                    @endif

                    @if ($empresa->normativa_url)
                        <div class="brand-info-row">
                            <strong>Normativa</strong>
                            <a href="{{ $empresa->normativa_url }}" target="_blank" rel="noopener noreferrer">Ver documento</a>
                        </div>
                    @endif
                </div>
            </aside>
        </section>

        <section class="layout">
            <form class="panel glass stack" action="{{ route('canal-denuncias.store', $empresa->dominio) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="panel-heading">
                    <div>
                        <h2>Formulario de denuncia</h2>
                        <p>Completa la información esencial para registrar tu comunicación con claridad.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="error-box">Revisa los campos indicados antes de continuar.</div>
                @endif

                <div class="section">
                    <label for="causa_denuncia_texto">Motivo de la denuncia</label>
                    <div class="input-shell">
                        <input id="causa_denuncia_texto" class="search-input" type="text" name="causa_denuncia_texto" value="{{ old('causa_denuncia_texto', $causaSeleccionada) }}" placeholder="Escribe una palabra y selecciona la coincidencia" required>
                        <div id="causa-search-results" class="search-results" role="listbox" aria-label="Motivos disponibles"></div>
                    </div>
                    <input id="causa_denuncia_id" type="hidden" name="causa_denuncia_id" value="{{ old('causa_denuncia_id') }}">
                    <span class="hint">El campo filtra automáticamente los motivos disponibles conforme escribes.</span>
                    @error('causa_denuncia_id') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="section">
                    <label for="descripcion_hechos">Descripción de los hechos</label>
                    <textarea id="descripcion_hechos" name="descripcion_hechos" required placeholder="Describe los hechos con la mayor precisión posible…">{{ old('descripcion_hechos') }}</textarea>
                    <span class="hint">Cuanto más detalle aportes, mejor podremos analizar la situación.</span>
                    @error('descripcion_hechos') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="grid-2 section-block">
                    <div class="section">
                        <label for="fecha_hechos">Fecha aproximada</label>
                        <input id="fecha_hechos" type="text" name="fecha_hechos" value="{{ old('fecha_hechos') }}" placeholder="DD-MM-AAAA" autocomplete="off">
                        @error('fecha_hechos') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="section">
                        <label for="adjuntos">Documentación adjunta</label>
                        <div class="file-field">
                            <input id="adjuntos" type="file" name="adjuntos[]" multiple>
                            <label class="file-trigger" for="adjuntos">Elegir archivos</label>
                            <span id="adjuntos-text" class="file-name">Ningún archivo seleccionado</span>
                        </div>
                        <span class="hint">Puedes adjuntar varios archivos.</span>
                        @error('adjuntos.*') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="section section-block">
                    <label for="personas_implicadas">Personas implicadas</label>
                    <textarea id="personas_implicadas" name="personas_implicadas" placeholder="Una persona por línea…">{{ old('personas_implicadas') }}</textarea>
                    <span class="hint">Indica una persona por línea, si procede.</span>
                    @error('personas_implicadas') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="grid-2 section-block">
                    <div class="check">
                        <input id="sigue_ocurriendo" type="checkbox" name="sigue_ocurriendo" value="1" @checked(old('sigue_ocurriendo'))>
                        <label for="sigue_ocurriendo">El hecho continúa produciéndose</label>
                    </div>

                    <div class="check">
                        <input id="riesgo_inmediato" type="checkbox" name="riesgo_inmediato" value="1" @checked(old('riesgo_inmediato'))>
                        <label for="riesgo_inmediato">Existe un riesgo inmediato</label>
                    </div>
                </div>

                <div class="section stack section-block">
                    <h3>Anonimato</h3>

                    <div class="check">
                        <input id="anonima" type="checkbox" name="anonima" value="1" @checked(old('anonima'))>
                        <label for="anonima">Presentar la denuncia de forma anónima</label>
                    </div>
                    @error('anonima') <div class="field-error">{{ $message }}</div> @enderror

                    <div id="contacto-block" class="contact-block">
                        <div class="grid-2">
                            <div class="section">
                                <label for="nombre_denunciante">Nombre</label>
                                <input id="nombre_denunciante" type="text" name="nombre_denunciante" value="{{ old('nombre_denunciante') }}">
                                @error('nombre_denunciante') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="section">
                                <label for="email_denunciante">Correo electrónico</label>
                                <input id="email_denunciante" type="email" name="email_denunciante" value="{{ old('email_denunciante') }}">
                                @error('email_denunciante') <div class="field-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="section">
                            <label for="telefono_denunciante">Teléfono</label>
                            <input id="telefono_denunciante" type="text" name="telefono_denunciante" value="{{ old('telefono_denunciante') }}">
                            @error('telefono_denunciante') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="section stack section-block">
                    <div class="check">
                        <input id="acepta_política_privacidad" type="checkbox" name="acepta_política_privacidad" value="1" @checked(old('acepta_política_privacidad'))>
                        <label for="acepta_política_privacidad">He leído y acepto la política de privacidad.</label>
                    </div>
                    @error('acepta_política_privacidad') <div class="field-error">{{ $message }}</div> @enderror

                    <div class="check">
                        <input id="declara_veracidad" type="checkbox" name="declara_veracidad" value="1" @checked(old('declara_veracidad'))>
                        <label for="declara_veracidad">Declaro que la información facilitada es veraz según mi conocimiento.</label>
                    </div>
                    @error('declara_veracidad') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="submit-row">
                    <button type="submit">Enviar denuncia</button>
                </div>
            </form>

            <div class="legal-links">
                <strong>Información legal</strong>
                <div class="legal-links-row">
                    <a href="{{ $empresa->politica_privacidad_url }}" target="_blank" rel="noopener noreferrer">Política de privacidad</a>
                    <a href="{{ $empresa->politica_cookies_url }}" target="_blank" rel="noopener noreferrer">Política de cookies</a>
                    <a href="{{ $empresa->aviso_legal_url }}" target="_blank" rel="noopener noreferrer">Aviso legal</a>
                </div>
            </div>

            <div class="semi-footer">
                <a href="{{ $empresa->politica_privacidad_url }}" target="_blank" rel="noopener noreferrer">Política de privacidad</a>
                <a href="{{ $empresa->politica_cookies_url }}" target="_blank" rel="noopener noreferrer">Política de cookies</a>
                <a href="{{ $empresa->aviso_legal_url }}" target="_blank" rel="noopener noreferrer">Aviso legal</a>
            </div>

        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const anonimaCheckbox = document.getElementById('anonima');
        const contactoBlock = document.getElementById('contacto-block');
        const contactoInputs = [
            document.getElementById('nombre_denunciante'),
            document.getElementById('email_denunciante'),
            document.getElementById('telefono_denunciante'),
        ];

        const fechaInput = document.getElementById('fecha_hechos');
        const adjuntosInput = document.getElementById('adjuntos');
        const adjuntosText = document.getElementById('adjuntos-text');
        const causaTextoInput = document.getElementById('causa_denuncia_texto');
        const causaIdInput = document.getElementById('causa_denuncia_id');
        const causaResults = document.getElementById('causa-search-results');
        const causas = @json($causasJson);

        if (window.flatpickr && fechaInput) {
            flatpickr(fechaInput, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altInputClass: 'date-display-input',
                altFormat: 'j F Y',
                allowInput: false,
                disableMobile: true,
                monthSelectorType: 'static',
                prevArrow: '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 3.75L5.25 9L10.5 14.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                nextArrow: '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 3.75L12.75 9L7.5 14.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['L', 'M', 'X', 'J', 'V', 'S', 'D'],
                        longhand: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                    },
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    },
                    rangeSeparator: ' a ',
                    weekAbbreviation: 'Sem',
                    scrollTitle: 'Desplaza para cambiar',
                    toggleTitle: 'Pulsa para alternar',
                    amPM: ['AM', 'PM'],
                    yearAriaLabel: 'Año',
                    monthAriaLabel: 'Mes',
                    hourAriaLabel: 'Hora',
                    minuteAriaLabel: 'Minuto',
                    time_24hr: true,
                },
            });
        }

        function syncAdjuntosText() {
            if (!adjuntosInput || !adjuntosText) {
                return;
            }

            const total = adjuntosInput.files ? adjuntosInput.files.length : 0;

            if (total === 0) {
                adjuntosText.textContent = 'Ningún archivo seleccionado';
                return;
            }

            if (total === 1) {
                adjuntosText.textContent = adjuntosInput.files[0].name;
                return;
            }

            adjuntosText.textContent = `${total} archivos seleccionados`;
        }

        function syncAnonymousState() {
            const isAnonymous = anonimaCheckbox.checked;
            contactoBlock.classList.toggle('hidden', isAnonymous);
            contactoInputs.forEach((input) => { input.disabled = isAnonymous; });
        }

        function renderCausaResults(query = '') {
            const normalized = query.trim().toLowerCase();
            const filtered = causas.filter((causa) => {
                if (normalized === '') return true;
                return causa.nombre.toLowerCase().includes(normalized)
                    || (causa.descripcion || '').toLowerCase().includes(normalized);
            });

            causaResults.innerHTML = '';

            if (! filtered.length) {
                const empty = document.createElement('div');
                empty.className = 'empty-option';
                empty.textContent = 'No hay coincidencias para ese texto.';
                causaResults.appendChild(empty);
                causaResults.classList.add('is-open');
                return;
            }

            filtered.forEach((causa, index) => {
                const option = document.createElement('button');
                option.type = 'button';
                option.className = 'search-option';
                option.setAttribute('role', 'option');
                option.dataset.id = causa.id;
                option.dataset.name = causa.nombre;
                option.innerHTML = `<strong>${causa.nombre}</strong>${causa.descripcion ? `<small>${causa.descripcion}</small>` : ''}`;

                option.addEventListener('click', () => {
                    causaTextoInput.value = causa.nombre;
                    causaIdInput.value = causa.id;
                    closeCausaResults();
                });

                if (index === 0) option.classList.add('is-active');
                causaResults.appendChild(option);
            });

            causaResults.classList.add('is-open');
        }

        function closeCausaResults() { causaResults.classList.remove('is-open'); }

        function syncCausaSelection() {
            const normalizedValue = causaTextoInput.value.trim().toLowerCase();
            const matched = causas.find((causa) => causa.nombre.trim().toLowerCase() === normalizedValue);
            causaIdInput.value = matched ? matched.id : '';
        }

        anonimaCheckbox.addEventListener('change', syncAnonymousState);
        if (adjuntosInput) adjuntosInput.addEventListener('change', syncAdjuntosText);

        causaTextoInput.addEventListener('focus', () => { renderCausaResults(causaTextoInput.value); });
        causaTextoInput.addEventListener('input', () => {
            syncCausaSelection();
            renderCausaResults(causaTextoInput.value);
        });

        causaTextoInput.addEventListener('keydown', (event) => {
            const options = Array.from(causaResults.querySelectorAll('.search-option'));
            const currentIndex = options.findIndex((option) => option.classList.contains('is-active'));

            if (event.key === 'ArrowDown' && options.length) {
                event.preventDefault();
                const nextIndex = currentIndex < options.length - 1 ? currentIndex + 1 : 0;
                options.forEach((option) => option.classList.remove('is-active'));
                options[nextIndex].classList.add('is-active');
                options[nextIndex].scrollIntoView({ block: 'nearest' });
            }
            if (event.key === 'ArrowUp' && options.length) {
                event.preventDefault();
                const nextIndex = currentIndex > 0 ? currentIndex - 1 : options.length - 1;
                options.forEach((option) => option.classList.remove('is-active'));
                options[nextIndex].classList.add('is-active');
                options[nextIndex].scrollIntoView({ block: 'nearest' });
            }
            if (event.key === 'Enter' && causaResults.classList.contains('is-open')) {
                const activeOption = causaResults.querySelector('.search-option.is-active');
                if (activeOption) { event.preventDefault(); activeOption.click(); }
            }
            if (event.key === 'Escape') closeCausaResults();
        });

        causaTextoInput.addEventListener('blur', () => {
            setTimeout(() => { syncCausaSelection(); closeCausaResults(); }, 120);
        });

        document.addEventListener('click', (event) => {
            if (! causaResults.contains(event.target) && event.target !== causaTextoInput) {
                closeCausaResults();
            }
        });

        syncAnonymousState();
        syncAdjuntosText();
        syncCausaSelection();
    </script>
</body>
</html>
