<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>InglesApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex text-gray-800">
    <aside class="w-64 bg-white shadow-xl border-r border-gray-200 flex flex-col">
        <nav class="flex-grow p-6 space-y-4">
            <a href="{{ route('home.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="h-5 w-5 mr-2 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                <span class="font-semibold">Home</span>
            </a>
            @if(auth()->user()->role_id === 1)
                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-green-50 transition">
                    <svg class="h-5 w-5 mr-2 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M17 20h5v-2a3 3 0 00-3-3h-2M9 20H4v-2a3 3 0 013-3h2m6-4a4 4 0 10-8 0 4 4 0 008 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                    <span class="font-semibold">Users</span>
                </a>
            @endif
            <a href="{{ route('profile') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="h-5 w-5 mr-2 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M5.121 17.804A10.94 10.94 0 0112 15c2.15 0 4.142.68 5.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                <span class="font-semibold">My Profile</span>
            </a>
            <a href="{{ route('lessons.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="h-5 w-5 mr-2 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 6v6l4 2M8 18h8" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                <span class="font-semibold">Lessons</span>
            </a>
            <a href="{{ route('badges.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="h-5 w-5 mr-2 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M9.75 17L15 12l-5.25-5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                <span class="font-semibold">Badges</span>
            </a>
            <a href="{{ route('vocabulary.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="h-5 w-5 mr-2 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M16 7a4 4 0 00-8 0v4a4 4 0 008 0V7zM12 14v1m0 4h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                <span class="font-semibold">My Vocabulary</span>
            </a>
            <div class="p-6 border-t border-gray-200">
                <button id="openModalBtn" class="w-full bg-green-800 hover:bg-green-900 text-white py-2 rounded-md font-semibold transition">
                    + Add New Word
                </button>
            </div>
        </nav>
    </aside>

    <main class="flex-grow flex flex-col">
        <header class="w-full bg-white p-6 border-b border-gray-200 flex items-center justify-between shadow-sm">
            <h1 class="text-5xl font-black text-gray-900 tracking-tight">
                Ingles<span class="text-green-800">App</span>
            </h1>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                    <img 
                        src="https://static.vecteezy.com/system/resources/previews/019/879/186/non_2x/user-icon-on-transparent-background-free-png.png" 
                        alt="User Icon" 
                        class="w-12 h-12 rounded-full object-cover bg-gray-200"
                    />
                    <div class="text-right">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition flex items-center">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <div class="p-6 flex-grow">
            @yield('content')
        </div>
    </main>

    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 relative">
            <h2 class="text-xl font-bold mb-4">Add New Word</h2>
            <form action="{{ route('vocabulary.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-4">
                    <label for="word" class="block font-semibold mb-1">Word <span class="text-red-500">*</span></label>
                    <input type="text" id="word" name="word" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
                </div>
                <div class="mb-4">
                    <label for="translate" class="block font-semibold mb-1">Translate <span class="text-red-500">*</span></label>
                    <input type="text" id="translate" name="translate" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
                </div>
                <div class="mb-4">
                    <label for="example" class="block font-semibold mb-1">Example</label>
                    <input type="text" id="example" name="example"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
                </div>
                <div class="mb-4">
                    <label for="pronunciation" class="block font-semibold mb-1">Pronunciation</label>
                    <input type="text" id="pronunciation" name="pronunciation"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModalBtn" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-800 text-white hover:bg-green-900">
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
