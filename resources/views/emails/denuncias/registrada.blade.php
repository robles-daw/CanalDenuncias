<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva denuncia registrada</title>
</head>
<body style="margin:0;padding:24px;background:#eef4fb;font-family:Segoe UI,Arial,sans-serif;color:#18212b;">
    <div style="max-width:680px;margin:0 auto;background:#ffffff;border:1px solid #d8e3f0;border-radius:20px;padding:28px;">
        <h1 style="margin:0 0 16px;font-size:28px;line-height:1.1;color:#18212b;">Nueva denuncia registrada</h1>

        <p style="margin:0 0 18px;line-height:1.6;">
            Se ha registrado una nueva denuncia en el canal de <strong>{{ $denuncia->empresa->nombre }}</strong>.
        </p>

        <table style="width:100%;border-collapse:collapse;margin:0 0 18px;">
            <tr>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;"><strong>Código</strong></td>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;">{{ $denuncia->codigo_seguimiento }}</td>
            </tr>
            <tr>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;"><strong>Tipo</strong></td>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;">{{ $denuncia->causa?->nombre }}</td>
            </tr>
            <tr>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;"><strong>Fecha de recepción</strong></td>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;">{{ $denuncia->fecha_recepcion?->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;"><strong>Anónima</strong></td>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;">{{ $denuncia->anonima ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;vertical-align:top;"><strong>Riesgo inmediato</strong></td>
                <td style="padding:10px 0;border-top:1px solid #eee2d5;">{{ $denuncia->riesgo_inmediato ? 'Sí' : 'No' }}</td>
            </tr>
        </table>

        <div style="padding:18px;border-radius:16px;background:#f4f8fc;border:1px solid #d8e3f0;">
            <strong style="display:block;margin-bottom:8px;">Descripción de los hechos</strong>
            <div style="white-space:pre-line;line-height:1.6;">{{ $denuncia->descripcion_hechos }}</div>
        </div>
    </div>
</body>
</html>
