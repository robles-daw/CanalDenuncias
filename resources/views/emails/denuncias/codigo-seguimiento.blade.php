<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código de seguimiento</title>
</head>
<body style="margin:0;padding:24px;background:#eef4fb;font-family:Segoe UI,Arial,sans-serif;color:#18212b;">
    <div style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #d8e3f0;border-radius:20px;padding:28px;">
        <h1 style="margin:0 0 16px;font-size:28px;line-height:1.1;color:#18212b;">Código de seguimiento</h1>

        <p style="margin:0 0 18px;line-height:1.6;">
            Este es el código asociado a tu comunicación en el canal de <strong>{{ $denuncia->empresa->nombre }}</strong>.
        </p>

        <div style="margin:24px 0;padding:18px 22px;border-radius:18px;background:#eef4fb;border:1px solid #c8d9eb;color:#0f2744;font-size:24px;font-weight:800;letter-spacing:.08em;text-align:center;">
            {{ $denuncia->codigo_seguimiento }}
        </div>

        <p style="margin:0;line-height:1.6;">
            Podrás utilizar este código para consultar el estado de la denuncia cuando lo necesites.
        </p>
    </div>
</body>
</html>
