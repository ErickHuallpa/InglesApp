<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-green-800 mb-6 text-center">Registro de Usuario</h2>

        @if ($errors->any())
            <div class="mb-4">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/register" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-green-800">Nombre</label>
                <input type="text" name="name" required
                       class="mt-1 block w-full border border-black rounded-md shadow-sm focus:ring-green-800 focus:border-green-800 p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-green-800">Email</label>
                <input type="email" name="email" required
                       class="mt-1 block w-full border border-black rounded-md shadow-sm focus:ring-green-800 focus:border-green-800 p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-green-800">Contraseña</label>
                <input type="password" name="password" required
                       class="mt-1 block w-full border border-black rounded-md shadow-sm focus:ring-green-800 focus:border-green-800 p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-green-800">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" required
                       class="mt-1 block w-full border border-black rounded-md shadow-sm focus:ring-green-800 focus:border-green-800 p-2">
            </div>

            <div class="text-center">
                <button type="submit"
                        class="bg-green-800 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300">
                    Registrarse
                </button>
            </div>
        </form>
    </div>

</body>
</html>
