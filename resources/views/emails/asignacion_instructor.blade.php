<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $esReasignacion ? 'Reasignación' : 'Asignación' }} de Instructor de Seguimiento</title>
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
            margin-bottom: 30px;
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
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
        }
        .table-wrapper {
            max-width: 1200px; /* Adjust this value as needed */
            width: 100%;
        }
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-family: Arial, sans-serif;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .modern-table th, .modern-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .modern-table thead th {
            background-color: #39A900;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .modern-table tbody tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        .modern-table tbody tr:hover {
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }
        .modern-table tbody td:first-child {
            font-weight: bold;
        }
        .table-header {
            background-color: #39A900;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('/images/seguimiento-logo.svg') }}" alt="Logo" style="width: 60%; max-width: 400px; height: auto;" />

        </div>

        {{-- <h2>{{ $esReasignacion ? 'Reasignación de Instructor de Seguimiento' : 'Asignación de Instructor de Seguimiento' }}</h2> --}}

        <p>Estimado/a <strong>{{ $aprendizNombre }}</strong>,</p>


        @if($esReasignacion)
            <p>
                Le informamos que su instructor de seguimiento ha sido reasignado. Por favor, comuníquese con el nuevo instructor, <strong>{{ $instructorNombre }}</strong> al correo <a href="{{ $instructorCorreo }}">{{ $instructorCorreo }}</a>
                para finalizar el envío de sus evidencias. 
            </p>
            <p>Agradecemos su comprensión y quedamos a su disposición para cualquier consulta.</p>
            <p>Cordialmente,</p>
            <p><em><span>Equipo de Seguimiento de Etapa Productiva</span></em></p>
        @else
            <p>
                Le informamos que se le ha asignado a <strong>{{ $instructorNombre }}</strong> como su <span> <strong>Instructor de Seguimiento </strong></span>. Puede comunicarse mediante correo electrónico a <a href="{{ $instructorCorreo }}">{{ $instructorCorreo }}</a>. A continuación, le detallo algunas sugerencias para iniciar el procedimiento de Seguimiento a Etapa Productiva:
            </p>

            <ul>
                <li><strong>Contacto Inicial</strong>: Comuníquese con su instructor de seguimiento a través del correo electrónico.</li>
                <li><strong>Comunicación Continua</strong>: Mantenga contacto regular con el instructor para resolver dudas sobre el diligenciamiento de formatos y para informar sobre los avances en su etapa productiva. Pregunte sobre su progreso, si ha enfrentado dificultades, etc.</li>
                <li><strong>Recursos Adicionales</strong>: Haga clic en el siguiente enlace para acceder a una cartilla digital que le enseñará cómo diligenciar los informes de seguimiento y obtener las fechas de cada período. También encontrará las fechas de los informes más abajo en este correo. 
                    <a href="https://view.genial.ly/637be4990267b300127b99ab/presentation-diligenciamientos-de-formatos-en-seguimiento-de-etapa-productiva" target="_blank">Cartilla Digital: Diligenciamiento de Formatos en Seguimiento de Etapa Productiva</a>
                </li>
            </ul>

            <h3>Entregas de Informes</h3>
            
            <p>
                Durante los 6 meses de etapa productiva, deberá entregar un total de <strong>15 informes</strong> a su instructor de seguimiento. Estos se entregarán en dos formatos:
            </p>
            <ul>
                <li><strong>Formato 023, Versión 4</strong>: Para planeación, seguimiento y evaluación de la etapa productiva.</li>
                <li><strong>Formato 147, Versión 3</strong>: Para la bitácora.</li>
            </ul>

            <h3>Detalles de Entrega:</h3>
            <p>
                <strong>Formato 023</strong>: Se debe entregar al inicio de las actividades, a los 3 meses para evaluar avances, y al finalizar la etapa productiva. En total, deberá entregar <strong>3 formatos</strong> F023.
            </p>
            <p>
                <strong>Formato 147 (Bitácora)</strong>: Se entregarán <strong>12 informes</strong> cada 15 días (1 a 12) en el Formato 147 – Bitácora Versión 3. Las fechas de inicio y finalización de cada bitácora se detallan en el cuadro que adjunto al final de este correo.
            </p>

            <h3>Archivos Adjuntos</h3>
            <ul>
                <li><strong>Formato 023 Versión 04</strong> - Planeación, seguimiento y evaluación (en blanco).</li>
                <li><strong>Formato 023 Versión 04</strong> - Modelo diligenciado (tres informes como ejemplo).</li>
                <li><strong>Formato 147 Bitácora Versión 03</strong> - En blanco.</li>
                <li><strong>Formato 147 Bitácora Versión 03</strong> - Modelo diligenciado.</li>
            </ul>

            <p>
                Al final de este correo, encontrará un cuadro con los informes a entregar y sus respectivas fechas.
            </p>

            <p>
                Quedomos atento a cualquier inquietud que pueda tener, puede comunicarse con nosotros a través de este correo electrónico: <a href="mailto:productivacbc@sena.edu.co">productivacbc@sena.edu.co</a>.
            </p>
            <p>Cordialmente,</p>
            <p><em><span>Equipo de Seguimiento de Etapa Productiva</span></em></p>

            <div class="signature">
            
                <table class="signature-table">
                    <tr>
                        <th>Nombres</th>
                        <td>{{ $aprendizNombre }}</td>
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

            <h3>Fecha inicial y final de los períodos de los informes</h3>

            
            <table class="modern-table">
              <thead>
                <tr>
                  <th>Informe</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Final</th>
                </tr>
              </thead>
              <tbody>
                @foreach($informes as $informe)
                    <tr>
                        <td>{{ $informe->nombre }}</td>
                        <td>{{ $informe->fecha_inicio ? \Carbon\Carbon::parse($informe->fecha_inicio)->format('d-m-Y') : 'N/A' }}</td> 
                        <td>{{ $informe->fecha_entrega ? \Carbon\Carbon::parse($informe->fecha_entrega)->format('d-m-Y') : 'N/A' }}</td> 
                    </tr>
                @endforeach
            </tbody>
            </table>
        @endif

        


        {{-- <div class="signature">
            
            <table class="signature-table">
                <tr>
                    <th>Ficha</th>
                    <td>{{ $ficha }}</td>
                    <th>Programa</th>
                    <td>{{ $programa }}</td>
                </tr>
                <tr>
                    <th>Nivel</th>
                    <td>{{ $nivel }}</td>
                    <th>Documento</th>
                    <td>{{ $documento }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $telefono }}</td>
                    <th>Correo</th>
                    <td>{{ $correo }}</td>
                </tr>
                
                <tr>
                    <th>Modalidad</th>
                    <td>{{ $modalidad }}</td>
                    <th>Instructor Lider</th>
                    <td>{{ $instructorLider }}</td>
                </tr>
                <tr>
                    <th>Contrato</th>
                    <td>{{ $modalidadEtapa }}</td>
                    <th>Inicio EP</th>
                    <td>{{ $inicio }}</td>
                </tr>
                <tr>
                    <th>Fin EP</th>
                    <td>{{ $final }}</td>
                    <th>Empresa</th>
                    <td>{{ $empresa }}</td>
                </tr>
                <tr>
                    <th>Instructor de Seguimiento</th>
                    <td colspan="3">{{ $instructorNombre }}</td>
                </tr>
            </table>
        </div> --}}
    </div>
</body>
</html>