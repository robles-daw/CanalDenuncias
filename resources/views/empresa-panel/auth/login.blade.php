<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso empresa - {{ $empresa->nombre }}</title>
    @include('partials.theme-head')
    <style>
        body { display: grid; place-items: center; padding: 18px; }
        .card { width: min(500px, 100%); }
        h1 { margin: 18px 0 12px; font-size: clamp(2.8rem, 6vw, 4.1rem); line-height: 0.96; }
        p { margin: 0 0 22px; }
        .field + .field { margin-top: 18px; }
        button { margin-top: 22px; }
        .error { margin-top: 8px; }
    </style>
</head>
<body>
    <section class="card glass">
        <span class="eyebrow">Panel de empresa</span>
        <h1>{{ $empresa->nombre }}</h1>
        <p>Accede al panel privado para revisar y gestionar las denuncias recibidas en el canal.</p>

        <form method="POST" action="{{ route('empresa.panel.login.submit', $empresa->dominio) }}">
            @csrf

            <div class="field">
                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>

            <button type="submit">Entrar</button>
        </form>
    </section>
</body>
</html>
