<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex">

    <aside class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col">

        <div class="p-6 border-b border-gray-200">
            <p class="font-semibold text-gray-800 mb-2">
                {{ auth()->user()->email }}
            </p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit" 
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded transition"
                >
                    Cerrar sesión
                </button>
            </form>
        </div>

        <nav class="flex-grow p-6 space-y-4">
            <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                Dashboard
            </a>
            <a href="{{ route('profile') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                Perfil
            </a>
            <a href="{{ route('lessons.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                Lessons
            </a>
            <a href="{{ route('badges.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                Insignias
            </a>
        </nav>

    </aside>

    <main class="flex-grow p-6">
        @yield('content')
    </main>

</body>
</html>
