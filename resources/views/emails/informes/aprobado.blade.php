<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Certificación</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap');
        body {
            font-family: 'Work Sans', Arial, sans-serif;
            color: #04324d;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        h1, h2, h3 {
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
        .signature {
            margin-top: 30px;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .signature-table th, .signature-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .signature-table th {
            font-weight: 600;
            color: #39A900;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('/images/seguimiento-logo.svg') }}" alt="Logo" style="width: 60%; max-width: 400px; height: auto;" />


        </div>

        <p>Saludo Aprendiz <strong>{{ $nombreCompleto }} </strong>,</p>

        <p>Haz hecho un gran esfuerzo para capacitarte y cumpliste con una parte importante del proceso de formación. En esta oportunidad te comunico que todos los informes de seguimiento a Etapa Productiva están revisados y aceptados para poder pasar al procedimiento de <strong>CERTIFICACIÓN</strong>.</p>

        <img src="{{ asset('/images/ilustacion-certificacion.svg') }}" alt="ilustracion-certificacion" style="width: 50%; max-width: 300px; height: auto; display: block; margin: 20px auto;"/>

        <h2>Próximos Pasos</h2>

        <p>Por favor, procede a enviar, lo más pronto posible, toda la documentación (ver adjuntos) para certificación a la Sra. Leidiana Liñan, Líder de procedimiento, al correo <a href="mailto:llinan@sena.edu.co">llinan@sena.edu.co</a>.</p>

        <p>Si ya enviaste los documentos completos a la Sra. Leidiana, estate pendiente en el link de certificados del Sena que se encuentra en el procedimiento adjunto de certificación, aproximadamente entre 5 y 10 días hábiles después de la entrega de documentos.</p>

        <h2>Documentos Adjuntos</h2>

        <ul>
            <li>El informe final (formato 023) diligenciado y firmado por el instructor de seguimiento.</li>
            <li>El procedimiento de CERTIFICACIÓN, para que conozcas qué documentos debes enviar y cómo puedes obtenerlos. Cualquier duda sobre estos documentos, consulta a la Sra. Leidiana.</li>
        </ul>

        <p>Cordialmente,</p>
        <p><em><span>Equipo de Seguimiento de Etapa Productiva</span></em></p>


        <div class="signature">
            
            <table class="signature-table">
                <tr>
                    <th>Nombres</th>
                    <td>{{ $nombreCompleto }}</td>
                    <th>Ficha</th>
                    <td>{{ $ficha }}</td>
                </tr>
                <tr>
                    <th>Programa</th>
                    <td>{{ $programa }}</td>
                    <th>Nivel</th>
                    <td>{{ $nivel }}</td>
                </tr>
                <tr>
                    <th>Documento</th>
                    <td>{{ $documento }}</td>
                    <th>Teléfono</th>
                    <td>{{ $telefono }}</td>
                   
                </tr>
                
                <tr>
                    <th>Correo</th>
                    <td>{{ $correo }}</td>
                    <th>Modalidad</th>
                    <td>{{ $modalidad }}</td>
                   
                </tr>
                <tr>
                    <th>Instructor Lider</th>
                    <td>{{ $instructorLider }}</td>
                    <th>modalidad EP</th>
                    <td>{{ $modalidadEtapa }}</td>
                </tr>
                <tr>
                    <th>Fecha Inicio EP</th>
                    <td>{{ $inicio }}</td>
                    <th>Fecha Final EP</th>
                    <td>{{ $final }}</td>
                </tr>
                <tr>
                    <th>Empresa</th>
                    <td>{{ $empresa }}</td>
                    <th>Instructor de Seguimiento</th>
                    <td colspan="3">{{ $instructorNombre }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>