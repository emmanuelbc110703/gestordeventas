<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Restablece tu contraseña</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f3ee; font-family:Georgia, 'Times New Roman', serif;">
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:#f5f3ee;">
        Usa este enlace para crear una nueva contraseña. Es válido por {{ $minutos ?? 5 }} minutos.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f3ee; padding:40px 12px;">
        <tr>
            <td align="center">

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background-color:#ffffff; border:1px solid #e8e3d8;">
                    <tr>
                        <td style="height:4px; background-color:#1f4d3a; font-size:0; line-height:0;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:40px 40px 8px;">
                            <div style="font-family:Georgia, 'Times New Roman', serif; font-size:13px; letter-spacing:3px; text-transform:uppercase; color:#1f4d3a;">
                                Orquídeas y más
                            </div>
                            <div style="font-family:Georgia, 'Times New Roman', serif; font-size:13px; letter-spacing:3px; text-transform:uppercase; color:#b08d57; margin-top:4px;">
                                Los Amates
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:24px 40px 8px;">
                            <table role="presentation" width="48" cellpadding="0" cellspacing="0">
                                <tr><td style="height:1px; background-color:#b08d57; font-size:0; line-height:0;">&nbsp;</td></tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 48px 8px; color:#2b2b2b;">
                            <h1 style="margin:0 0 20px; font-family:Georgia, 'Times New Roman', serif; font-size:26px; font-weight:normal; color:#1f4d3a; text-align:center;">
                                Restablece tu contraseña
                            </h1>
                            <p style="margin:0 0 16px; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.7; color:#444444;">
                                Hola, {{ $nombre }}:
                            </p>
                            <p style="margin:0 0 8px; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.7; color:#444444;">
                                Recibimos una solicitud para restablecer la contraseña de tu cuenta.
                                Para continuar, utiliza el siguiente botón:
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:24px 48px 28px;">
                            <a href="{{ $url }}"
                               style="display:inline-block; background-color:#1f4d3a; color:#ffffff; text-decoration:none; font-family:Arial, Helvetica, sans-serif; font-size:14px; letter-spacing:1.5px; text-transform:uppercase; padding:15px 38px; border-radius:2px;">
                                Restablecer contraseña
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 48px 32px; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:1.7; color:#6b6b6b;">
                            <p style="margin:0 0 10px;">
                                Por seguridad, este enlace es válido por <strong style="color:#2b2b2b;">{{ $minutos ?? 5 }} minutos</strong>.
                                Pasado ese tiempo deberás solicitar uno nuevo.
                            </p>
                            <p style="margin:0;">
                                Si no realizaste esta solicitud, puedes ignorar este mensaje. Tu contraseña seguirá siendo la misma.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 48px; background-color:#faf8f4; border-top:1px solid #e8e3d8; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:1.6; color:#8a8a8a;">
                            Si tienes problemas con el botón, copia y pega esta dirección en tu navegador:<br>
                            <a href="{{ $url }}" style="color:#1f4d3a; word-break:break-all;">{{ $url }}</a>
                        </td>
                    </tr>
                </table>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">
                    <tr>
                        <td align="center" style="padding:24px 20px 0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#9a9a9a; line-height:1.6;">
                            © {{ date('Y') }} Orquídeas y más "Los Amates"<br>
                            Este es un mensaje automático, por favor no respondas a este correo.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>