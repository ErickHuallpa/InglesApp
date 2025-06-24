@extends('layouts.dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-6">Perfil de usuario</h1>

<div class="bg-white p-6 rounded shadow max-w-md">
    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Nivel:</strong> {{ $user->level ?? 'No asignado' }}</p>
    <p><strong>Rol:</strong> {{ $user->role->name ?? 'Sin rol' }}</p>

    <button 
        onclick="document.getElementById('editModal').classList.remove('hidden')" 
        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
    >
        Editar perfil
    </button>

</div>
<h2 class="text-2xl font-semibold mt-8 mb-4">Mis Insignias</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    @forelse($user->badges as $badge)
        <div class="bg-gray-100 p-4 rounded shadow">
            <div class="flex items-center gap-4">
                @if($badge->icon_url)
                    <img src="{{ $badge->icon_url }}" alt="{{ $badge->title }}" class="w-12 h-12 object-contain">
                @else
                    <div class="w-12 h-12 bg-gray-300 flex items-center justify-center rounded text-xl">🏅</div>
                @endif
                <div>
                    <h3 class="text-lg font-bold">{{ $badge->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $badge->description }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Obtenida: {{ \Carbon\Carbon::parse($badge->pivot->achieved_at)->format('d/m/Y') }}
                    </p>

                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-600">Aún no has conseguido ninguna insignia.</p>
    @endforelse
</div>



<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded shadow-lg p-6 w-full max-w-lg relative">
        <button 
            onclick="document.getElementById('editModal').classList.add('hidden')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700"
            title="Cerrar"
        >
            &times;
        </button>

        <h2 class="text-2xl mb-4 font-semibold">Editar perfil</h2>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name" class="block font-medium mb-1">Nombre</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $user->name) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required
                >
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block font-medium mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email', $user->email) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    required
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nueva contraseña --}}
            <div class="mb-4">
                <label for="password" class="block font-medium mb-1">Nueva contraseña (dejar vacío para no cambiar)</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                >
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div class="mb-4">
                <label for="password_confirmation" class="block font-medium mb-1">Confirmar nueva contraseña</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                >
            </div>

            <div class="flex justify-end gap-2">
                <button 
                    type="button" 
                    onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="px-4 py-2 border rounded hover:bg-gray-100 transition"
                >
                    Cancelar
                </button>
                <button 
                    type="submit" 
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition"
                >
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
