@extends('layouts.dashboard')

@section('content')
<div class="w-full px-4 mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Insignias</h1>
    @if (auth()->user()->role_id == 1)
    <button onclick="openModalForCreate()" class="mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Badge
    </button>
    @endif

    @foreach ($badges as $level => $levelBadges)
        <h2 class="text-xl font-bold mt-8 mb-4 capitalize">{{ $level }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
            @foreach ($levelBadges as $badge)
                <div class="bg-white p-4 rounded shadow relative text-center">
                    <img src="{{ $badge->icon_url ?: 'https://cdn-icons-png.flaticon.com/512/7937/7937877.png' }}" alt="Icono" class="w-16 h-16 mt-2 mx-auto">
                    <h3 class="text-sm font-semibold mt-2">{{ $badge->title }}</h3>
                    <p class="text-xs">{{ $badge->description }}</p>
                    @if (auth()->user()->role_id == 1)
                    <div class="absolute top-1 right-1 flex space-x-1">
                        <button onclick="openModalForEdit({{ $badge }})" class="text-blue-600 hover:text-blue-800 text-sm" title="Editar">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                            </svg>
                        </button>
                        <button onclick="openDeleteModal({{ $badge->id }}, '{{ addslashes($badge->title) }}')" class="text-red-600 hover:text-red-800 text-sm" title="Eliminar">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach

</div>

<div id="badgeModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Agregar Nueva Insignia</h2>
        <form id="badgeForm" method="POST" action="{{ route('badges.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST" />
            <div class="mb-4">
                <label for="title" class="block mb-1 font-medium">Título</label>
                <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block mb-1 font-medium">Descripción</label>
                <textarea name="description" id="description" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
            </div>
            <div class="mb-4">
                <label for="icon_url" class="block mb-1 font-medium">URL del Icono</label>
                <input type="url" name="icon_url" id="icon_url" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="criteria_json" class="block mb-1 font-medium">Criterios (JSON opcional)</label>
                <textarea name="criteria_json" id="criteria_json" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
            </div>
            <div class="mb-4">
                <label for="level" class="block mb-1 font-medium">Nivel</label>
                <input type="text" name="level" id="level" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" 
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h3 class="text-lg font-semibold mb-4">Confirmar Eliminación</h3>
        <p class="mb-6">¿Estás seguro que quieres eliminar la insignia <span id="deleteBadgeTitle" class="font-bold"></span>?</p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalForCreate() {
        document.getElementById('modalTitle').textContent = 'Agregar Nueva Insignia';
        const form = document.getElementById('badgeForm');
        form.action = "{{ route('badges.store') }}";
        document.getElementById('formMethod').value = 'POST';
        form.reset();
        document.getElementById('badgeModal').classList.remove('hidden');
    }

    function openModalForEdit(badge) {
        document.getElementById('modalTitle').textContent = 'Editar Insignia';
        const form = document.getElementById('badgeForm');
        form.action = `/badges/${badge.id}`;
        document.getElementById('formMethod').value = 'PUT';

        document.getElementById('title').value = badge.title;
        document.getElementById('description').value = badge.description;
        document.getElementById('icon_url').value = badge.icon_url || '';
        document.getElementById('criteria_json').value = badge.criteria_json ? JSON.stringify(badge.criteria_json) : '';

        document.getElementById('badgeModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('badgeModal').classList.add('hidden');
    }

    function openDeleteModal(id, title) {
        document.getElementById('deleteBadgeTitle').textContent = title;
        const form = document.getElementById('deleteForm');
        form.action = `/badges/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
