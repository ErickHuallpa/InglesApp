<!DOCTYPE html>
<html lang="en">
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
        <div class="flex justify-center items-center py-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
        </div>
        <nav class="flex-grow pl-3 space-y-4">
            <a href="{{ route('home.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                </svg>
                <span class="font-semibold">Home</span>
            </a>
            @if(auth()->user()->role_id === 1)
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-50 transition">
                    <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <span class="font-semibold">Users</span>
                </a>
            @endif
            <a href="{{ route('profile') }}" class="flex items-center px-3 gap-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                </svg>
                <span class="font-semibold">My Profile</span>
            </a>
            <a href="{{ route('lessons.index') }}" class="flex items-center px-3 gap-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4"/>
                </svg>
                <span class="font-semibold">Lessons</span>
            </a>
            <a href="{{ route('badges.index') }}" class="flex items-center px-3 gap-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                </svg>
                <span class="font-semibold">Badges</span>
            </a>
            <a href="{{ route('vocabulary.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-50 transition">
                <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m4 4 1 5 2-3.333L14 17l1-5m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
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
                English<span class="text-green-800">App</span>
            </h1>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-700 flex items-center justify-center text-white font-bold text-xl uppercase">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="text-right">
                        <p class="font-semibold flex items-center gap-1">{{ auth()->user()->name }}
                        @if(auth()->user()->role_id === 1)
                            <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                            </svg>
                        @elseif(auth()->user()->role_id === 3)
                            <svg class="w-5 h-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        </p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H7a3 3 0 01-3-3V7a3 3 0 013-3h3a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Logout
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
                    <input type="text" id="word" name="word" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
                </div>
                <div class="mb-4">
                    <label for="translate" class="block font-semibold mb-1">Translate <span class="text-red-500">*</span></label>
                    <input type="text" id="translate" name="translate" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
                </div>
                <div class="mb-4">
                    <label for="example" class="block font-semibold mb-1">Example</label>
                    <input type="text" id="example" name="example" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
                </div>
                <div class="mb-4">
                    <label for="pronunciation" class="block font-semibold mb-1">Pronunciation</label>
                    <input type="text" id="pronunciation" name="pronunciation" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none" />
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
