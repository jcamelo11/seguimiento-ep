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
            margin-bottom: 50px;
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
        .report-periods {
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .report-periods th, .report-periods td {
          transition: background-color 0.3s ease;
        }
        .report-periods tr:hover {
          background-color: #f0f0f0 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('/images/logoo.svg') }}" alt="Logo" style="width: 30%; max-width: 150px; height: auto;" />
        </div>

        <h2>{{ $esReasignacion ? 'Reasignación de Instructor de Seguimiento' : 'Asignación de Instructor de Seguimiento' }}</h2>

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
            <p>Le informo que se le ha asignado a <strong>{{ $instructorNombre }}</strong> como su <span> <strong>Instructor de Seguimiento </strong></span>. Puede comunicarse con el/lla mediante correo electrónico a <a href="{{ $instructorCorreo }}">{{ $instructorCorreo }}</a>. A continuación, le detallo algunas sugerencias para iniciar el procedimiento de Seguimiento a Etapa Productiva:</p>

            <ul>
                <li><strong>Contacto Inicial</strong>: Comuníquese con su instructor de seguimiento a través del correo electrónico.</li>
                <li><strong>Comunicación Continua</strong>: Mantenga contacto regular con el instructor para resolver dudas sobre el diligenciamiento de formatos y para informar sobre los avances en su etapa productiva. Pregunte sobre su progreso, si ha enfrentado dificultades, etc.</li>
                <li><strong>Recursos Adicionales</strong>: Haga clic en el siguiente enlace para acceder a una cartilla digital que le enseñará cómo diligenciar los informes de seguimiento y obtener las fechas de cada período. También encontrará las fechas de los informes más abajo en este correo. 
                    <a href="https://view.genial.ly/637be4990267b300127b99ab/presentation-diligenciamientos-de-formatos-en-seguimiento-de-etapa-productiva" target="_blank">Cartilla Digital: Diligenciamiento de Formatos en Seguimiento de Etapa Productiva</a>
                </li>
            </ul>

            <h3>Entregas de Informes</h3>
            
            <p>Durante los 6 meses de etapa productiva, deberá entregar un total de <strong>15 informes</strong> a su instructor de seguimiento. Estos se entregarán en dos formatos:</p>
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

            <p>Al final de este correo, encontrará un cuadro con los informes a entregar y sus respectivas fechas.</p>

            <p>Quedo atento a cualquier inquietud que pueda tener, puede comunicarse conmigo a través de este correo electrónico: <a href="mailto:productivacbc@sena.edu.co">productivacbc@sena.edu.co</a>.</p>
            <p>Cordialmente,</p>
            <p><em><span>Equipo de Seguimiento de Etapa Productiva</span></em></p>

            <table class="report-periods" style="width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 20px;">
                <thead>
                  <tr>
                    <th colspan="6" style="text-align: center; padding: 10px; border: 1px solid #39A900; background-color: #39A900; color: white; font-size: 14px;">FECHA INICIAL Y FINAL DE LOS PERÍODOS DE LOS INFORMES</th>
                  </tr>
                  <tr>
                    <th style="text-align: center; padding: 8px; border: 1px solid #e0e0e0; background-color: #f0f0f0;">Informe</th>
                    <th style="text-align: center; padding: 8px; border: 1px solid #e0e0e0; background-color: #f0f0f0;">Fecha Inicio</th>
                    <th style="text-align: center; padding: 8px; border: 1px solid #e0e0e0; background-color: #f0f0f0;">Fecha Final</th>
                    <th style="text-align: center; padding: 8px; border: 1px solid #e0e0e0; background-color: #f0f0f0;">Informe</th>
                    <th style="text-align: center; padding: 8px; border: 1px solid #e0e0e0; background-color: #f0f0f0;">Fecha Inicio</th>
                    <th style="text-align: center; padding: 8px; border: 1px solid #e0e0e0; background-color: #f0f0f0;">Fecha Final</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Form 023 - 1 - Concertación</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">02-oct-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">16-oct-23</td>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 1</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">17-oct-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">31-oct-23</td>
                  </tr>
                  <tr style="background-color: #f9f9f9;">
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 2</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">01-nov-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">15-nov-23</td>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 3</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">16-nov-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">30-nov-23</td>
                  </tr>
                  <tr>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 4</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">01-dic-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">15-dic-23</td>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 5</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">16-dic-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">30-dic-23</td>
                  </tr>
                  <tr style="background-color: #f9f9f9;">
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 6</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">02-oct-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">31-dic-23</td>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Form 023 - 2 - Parcial</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">31-dic-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">14-ene-24</td>
                  </tr>
                  <tr>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 7</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">15-ene-24</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">29-ene-24</td>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 8</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">30-ene-24</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">13-feb-24</td>
                  </tr>
                  <tr style="background-color: #f9f9f9;">
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 9</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">14-feb-24</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">28-feb-24</td>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 10</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">29-feb-24</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">14-mar-24</td>
                  </tr>
                  <tr>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 11</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">15-mar-24</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">01-abr-24</td>
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Bitacora - 12</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">02-oct-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">01-abr-24</td>
                  </tr>
                  <tr style="background-color: #f9f9f9;">
                    <td style="text-align: left; padding: 8px; border: 1px solid #e0e0e0;">Form 023 - 3 - Final</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">02-oct-23</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;">01-abr-24</td>
                    <td style="text-align: center; padding: 8px; border: 1px solid #e0e0e0;" colspan="3"></td>
                  </tr>
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