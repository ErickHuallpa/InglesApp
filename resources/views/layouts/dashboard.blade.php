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

        <div class="p-6 border-b border-gray-200 flex flex-col items-center space-y-3">
            <div class="bg-gray-200 rounded-full p-2">
                <img 
                    src="https://static.vecteezy.com/system/resources/previews/019/879/186/non_2x/user-icon-on-transparent-background-free-png.png" 
                    alt="User Icon" 
                    class="w-20 h-20 rounded-full object-cover"
                />
            </div>
            <p class="font-semibold text-gray-800 text-center break-all">
                {{ auth()->user()->name }}
            </p>
            <p class="font-semibold text-gray-400  text-center break-all">
                {{ auth()->user()->email }}
            </p>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button 
                    type="submit" 
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded transition"
                >
                    Cerrar sesión
                </button>
            </form>
        </div>


        <nav class="flex-grow p-6 space-y-4 text-gray-700">
            <a href="{{ route('home.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
                Home
            </a>
            @if(auth()->user()->role_id === 1)
                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-3-3h-2M9 20H4v-2a3 3 0 013-3h2m6-4a4 4 0 10-8 0 4 4 0 008 0z" />
                    </svg>
                    Users
                </a>
            @endif
            <a href="{{ route('profile') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A10.94 10.94 0 0112 15c2.15 0 4.142.68 5.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                My Profile
            </a>
            <a href="{{ route('lessons.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 18h8" />
                </svg>
                Lessons
            </a>
            <a href="{{ route('badges.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L15 12l-5.25-5" />
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" fill="none"/>
                </svg>
                Badges
            </a>
            <a href="{{ route('vocabulary.index') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 00-8 0v4a4 4 0 008 0V7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v1m0 4h.01" />
                </svg>
                My Vocabulary
            </a>
            <div class="p-6 border-t border-gray-200">
                <button id="openModalBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition" type="button">
                    Add new word
                </button>
            </div>
        </nav>

    </aside>

    <main class="flex-grow p-6">
        <header class="w-full bg-gray-50">
            <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-10">
                Ingles<span class="text-blue-600">App</span>
            </h1>
        </header>
        @yield('content')
    </main>

    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h2 class="text-xl font-bold mb-4">Add New Word</h2>

            <form action="{{ route('vocabulary.store') }}" method="POST" autocomplete="off">
                @csrf

                <div class="mb-4">
                    <label for="word" class="block font-semibold mb-1">Word <span class="text-red-500">*</span></label>
                    <input type="text" id="word" name="word" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div class="mb-4">
                    <label for="translate" class="block font-semibold mb-1">Translate <span class="text-red-500">*</span></label>
                    <input type="text" id="translate" name="translate" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div class="mb-4">
                    <label for="example" class="block font-semibold mb-1">Example</label>
                    <input type="text" id="example" name="example"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div class="mb-4">
                    <label for="pronunciation" class="block font-semibold mb-1">Pronunciation</label>
                    <input type="text" id="pronunciation" name="pronunciation"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModalBtn" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalOverlay = document.getElementById('modalOverlay');

        openModalBtn.addEventListener('click', () => {
            modalOverlay.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            modalOverlay.classList.add('hidden');
        });
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.add('hidden');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
