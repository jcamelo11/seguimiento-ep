<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        custom: '#39a900'
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 flex items-center justify-center p-4">
        <div class="max-w-2xl w-full text-center">
            <div class="mb-8 flex justify-center">
                <svg class="h-32 w-32 text-custom animate-float" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 10h.01"></path>
                    <path d="M15 10h.01"></path>
                    <path d="M12 2a8 8 0 0 0-8 8v12l3-3 2.5 2.5L12 19l2.5 2.5L17 19l3 3V10a8 8 0 0 0-8-8z"></path>
                </svg>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">¡Página no encontrada!</h2>
            <p class="text-gray-600 mb-8 text-lg">
                Lo sentimos, no pudimos encontrar la página que estás buscando.         
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="javascript:history.back()" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-custom bg-green-50 hover:bg-green-100 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    Volver atrás
                </a>
                
                <a href="/" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-custom hover:bg-[#2d8400] transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Ir al inicio
                </a>
            </div>
        </div>
    </div>
</body>
</html>