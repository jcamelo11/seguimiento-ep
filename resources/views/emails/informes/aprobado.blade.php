<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Certificación</title>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Work Sans', sans-serif;
            color: #04324d;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #39A900;
        }
        a {
            color: #39A900;
        }
        span {
            color: #39A900;
        }
        ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ asset('/images/logoo.svg') }}" alt="Logo" />
    </div>

    <p>Saludo Aprendiz <strong>{{ $nombreCompleto }}</strong>,</p>

    <p>Haz hecho un gran esfuerzo para capacitarte y cumpliste con una parte importante del proceso de formación. En esta oportunidad te comunico que todos los informes de seguimiento a Etapa Productiva están revisados y aceptados para poder pasar al procedimiento de <strong>CERTIFICACIÓN</strong>.</p>

    <h2>Próximos Pasos</h2>

    <p>Por favor, procede a enviar, lo más pronto posible, toda la documentación (ver adjuntos) para certificación a la Sra. Leidiana Liñan, Líder de procedimiento, al correo <a href="mailto:llinan@sena.edu.co">llinan@sena.edu.co</a>.</p>

    <p>Si ya enviaste los documentos completos a la Sra. Leidiana, estate pendiente en el link de certificados del Sena que se encuentra en el procedimiento adjunto de certificación, aproximadamente entre 5 y 10 días hábiles después de la entrega de documentos.</p>

    <h2>Documentos Adjuntos</h2>

    <p>Adjunto encontrarás:</p>
    <ul>
        <li>El informe final (formato 023) diligenciado y firmado por el instructor de seguimiento.</li>
        <li>El procedimiento de CERTIFICACIÓN, para que conozcas qué documentos debes enviar y cómo puedes obtenerlos. Cualquier duda sobre estos documentos, consulta a la Sra. Leidiana.</li>
    </ul>

    <p>Cordialmente,</p>
    <p><strong><span>Equipo de seguimiento a Etapa Productiva</span></strong></p>

</body>
</html>