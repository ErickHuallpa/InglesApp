@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Lista de Usuarios</h2>
    <button id="openCreateModalBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">+ Crear Usuario</button>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($users->sortBy('id') as $user)
    <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
        <img src="https://static.vecteezy.com/system/resources/previews/019/879/186/non_2x/user-icon-on-transparent-background-free-png.png"
             class="w-24 h-24 mx-auto mb-4 rounded-full object-cover" alt="User">
        <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
        <p class="text-indigo-600 font-medium mt-2">{{ $user->role->name ?? 'N/A' }}</p>
        <p class="text-xs text-gray-500 mt-1">ID: {{ $user->id }}</p>
        <div class="mt-4 flex justify-center space-x-2">
            <button class="editBtn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded"
                    data-id="{{ $user->id }}"
                    data-name="{{ $user->name }}"
                    data-email="{{ $user->email }}"
                    data-role="{{ $user->role_id }}">
                Editar
            </button>
            <button class="deleteBtn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                    data-id="{{ $user->id }}"
                    data-name="{{ $user->name }}">
                Eliminar
            </button>
        </div>
    </div>
    @endforeach
</div>

<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
    <button onclick="closeUserModal()" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">&times;</button>
    <h3 id="userModalTitle" class="text-xl font-bold mb-4">Crear Usuario</h3>
    <form id="userForm" method="POST" action="{{ route('users.store') }}">
      @csrf
      <input type="hidden" name="_method" id="userFormMethod" value="POST">
      <input type="hidden" name="user_id" id="userId">
      <div class="mb-4">
        <label class="block font-semibold mb-1">Nombre</label>
        <input type="text" name="name" id="userName" class="w-full border rounded px-3 py-2" required>
      </div>
      <div class="mb-4">
        <label class="block font-semibold mb-1">Email</label>
        <input type="email" name="email" id="userEmail" class="w-full border rounded px-3 py-2" required>
      </div>
      <div class="mb-4">
        <label class="block font-semibold mb-1">Rol</label>
        <select name="role_id" id="userRole" class="w-full border rounded px-3 py-2" required>
          @foreach(\App\Models\Role::all() as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-4">
        <label class="block font-semibold mb-1">Contraseña</label>
        <input type="password" name="password" id="userPassword" class="w-full border rounded px-3 py-2">
        <p class="text-xs text-gray-500 mt-1">Déjelo en blanco para no cambiarla.</p>
      </div>

      <div class="flex justify-end space-x-2">
        <button type="button" onclick="closeUserModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
      </div>
    </form>
  </div>
</div>

<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white rounded-lg w-full max-w-sm p-6 relative">
    <button onclick="closeDeleteModal()" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">&times;</button>
    <h3 class="text-lg font-bold mb-4">Eliminar Usuario</h3>
    <p class="mb-4">¿Seguro que deseas eliminar a <span id="deleteUserName" class="font-semibold"></span>?</p>
    <form id="deleteForm" method="POST" action="">
      @csrf @method('DELETE')
      <div class="flex justify-end space-x-2">
        <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>

const userModal = document.getElementById('userModal');
const deleteModal = document.getElementById('deleteModal');

document.getElementById('openCreateModalBtn').addEventListener('click', () => {
  document.getElementById('userModalTitle').textContent = "Crear Usuario";
  document.getElementById('userForm').action = "{{ route('users.store') }}";
  document.getElementById('userFormMethod').value = "POST";
  userModal.classList.remove('hidden');
});

document.querySelectorAll('.editBtn').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    document.getElementById('userModalTitle').textContent = "Editar Usuario";
    document.getElementById('userForm').action = `/users/${id}`;
    document.getElementById('userFormMethod').value = "PUT";
    document.getElementById('userId').value = id;
    document.getElementById('userName').value = btn.dataset.name;
    document.getElementById('userEmail').value = btn.dataset.email;
    document.getElementById('userRole').value = btn.dataset.role;
    userModal.classList.remove('hidden');
  });
});

document.querySelectorAll('.deleteBtn').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    document.getElementById('deleteUserName').textContent = btn.dataset.name;
    document.getElementById('deleteForm').action = `/users/${id}`;
    deleteModal.classList.remove('hidden');
  });
});

function closeUserModal() {
  userModal.classList.add('hidden');
  document.getElementById('userForm').reset();
  document.getElementById('userId').value = '';
  document.getElementById('userFormMethod').value = 'POST';
  document.getElementById('userForm').action = "{{ route('users.store') }}";
}

function closeDeleteModal() {
  deleteModal.classList.add('hidden');
}

window.addEventListener('click', function(e) {
  if (e.target === userModal) closeUserModal();
  if (e.target === deleteModal) closeDeleteModal();
});


</script>
@endsection
