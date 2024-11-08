<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Acceso a la Plataforma de Seguimiento</title>
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
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.8em;
            color: #666;
        }
        .button {
            display: block;
            width: fit-content;
            padding: 10px 20px;
            background-color: #39A900;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px auto; /* Centra el botón horizontalmente */
        }


    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('/images/seguimiento-logo.svg') }}" alt="Logo" style="width: 60%; max-width: 400px; height: auto;" />
        </div>

        <p>Bienvenido/a, <strong>{{ $user->name }}</strong></p> 

        <p>
            Le damos la bienvenida a nuestro <strong><span>sistema de gestión de aprendices en etapa Productiva</strong>. 
            Su cuenta ha sido creada con éxito.
        </p> 
        <p>A continuación, encontrará sus credenciales de acceso:</p> 
        <ul> 
            <li><strong>Usuario:</strong> {{ $user->email }}</li> 
            <li><strong>Contraseña Temporal:</strong> {{ $password }}</li> 
        </ul> 
        <p>Por favor, cambie su contraseña después de iniciar sesión por primera vez.</p>

            <a href="{{ url('/instructorseguimiento/login') }}" class="button">Iniciar Sesión</a>
        
        <p>Si tiene alguna pregunta o necesita asistencia, no dude en contactar a nuestro equipo de soporte.</p>
        
        <p>¡Le deseamos mucho éxito en su rol como instructor de seguimiento!</p>

        <p>Cordialmente,</p>
        <p><em><span>Equipo de Seguimiento de Etapa Productiva</span></em></p>
    </div>
    {{-- <div class="footer">
        <p>Este es un correo electrónico automático, por favor no responda a este mensaje.</p>
        <p>&copy; {{ date('Y') }} Sistema de Seguimiento. Todos los derechos reservados.</p>
    </div> --}}
</body>
</html>