@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">
    <div class="flex flex-col sm:flex-row items-center gap-6 bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
        <div class="w-32 h-32 rounded-full bg-gradient-to-tr from-green-400 to-blue-500 text-white flex items-center justify-center text-4xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                <h1 class="text-3xl font-extrabold text-gray-800">{{ $user->name }}</h1>
                @if($user->role_id == 1)
                    <svg class="w-6 h-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                    </svg>
                @elseif($user->role_id == 3)
                    <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                    </svg>
                @endif
            </div>
            <p class="text-gray-600"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="text-gray-600"><strong>Nivel:</strong> {{ $user->level ?? 'No asignado' }}</p>
            <p class="text-gray-600"><strong>Rol:</strong> {{ $user->role->name ?? 'Sin rol' }}</p>
            <button onclick="document.getElementById('editModal').classList.remove('hidden')" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                ✏️ Editar perfil
            </button>
        </div>
    </div>
    <h2 class="text-2xl font-semibold mt-10 mb-4 text-gray-800">🎖️ Mis Insignias</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @forelse($user->badges as $badge)
            <div class="bg-gradient-to-br from-yellow-100 to-white p-4 rounded-xl shadow-sm border border-yellow-300 flex gap-4 items-center">
                @if($badge->icon_url)
                    <img src="{{ $badge->icon_url }}" alt="{{ $badge->title }}" class="w-14 h-14 object-contain">
                @else
                    <div class="w-14 h-14 bg-yellow-200 flex items-center justify-center rounded-full text-2xl">🏅</div>
                @endif
                <div>
                    <h3 class="text-lg font-bold text-yellow-800">{{ $badge->title }}</h3>
                    <p class="text-sm text-gray-700">{{ $badge->description }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Obtenida: {{ \Carbon\Carbon::parse($badge->pivot->achieved_at)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-600">Aún no has conseguido ninguna insignia.</p>
        @endforelse
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-lg relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl" title="Cerrar">
            &times;
        </button>

        <h2 class="text-2xl mb-6 font-semibold text-center text-gray-800">Editar perfil</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                <input type="password" name="password" id="password" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="(Opcional)">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 border rounded hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
