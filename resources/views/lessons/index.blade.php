@extends('layouts.dashboard')

@section('content')

<h1 class="text-3xl font-extrabold mb-8 text-gray-900">Lessons</h1>

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@if(Auth::check() && Auth::user()->role_id === 1 || Auth::user()->role_id === 3)
    <button onclick="openModal()" class="mb-8 bg-green-600 text-white px-5 py-3 rounded-lg shadow hover:bg-green-700 transition">
        + Add Lesson
    </button>
@endif

@foreach($groupedLessons as $level => $lessons)
    <h2 class="text-xl font-bold mt-8 mb-4 text-gray-800">
        {{ ucfirst($level) }} Level
    </h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
        @foreach($lessons as $lesson)
            <div class="rounded-lg shadow p-3 relative
                {{ 
                    $level === 'basic' ? 'bg-green-50 border-l-4 border-green-500' : 
                    ($level === 'intermediate' ? 'bg-yellow-50 border-l-4 border-yellow-400' : 
                    'bg-green-50 border-l-4 border-green-500') 
                }}">
                <div class="flex justify-center mb-1">
                    @if($level === 'basic')
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    @elseif($level === 'intermediate')
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 19 21 5 21 12 2" />
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    @endif
                </div>
                <h3 class="font-semibold text-sm text-center text-gray-900 mb-1 truncate" title="{{ $lesson->title }}">{{ $lesson->title }}</h3>
                <p class="text-xs text-gray-600 mb-1 truncate" title="{{ $lesson->description }}">{{ $lesson->description }}</p>
                <p class="text-xs text-gray-500 text-center"><strong>Order:</strong> {{ $lesson->order }}</p>
                <a href="{{ route('lessons.exercises', $lesson->id) }}"class="mt-4 block text-center bg-indigo-600 text-white py-1.5 rounded hover:bg-indigo-700 transition"aria-label="View Exercises for {{ $lesson->title }}"title="View Exercises">
                    Ver ejercicios
                </a>
                @if (!in_array($lesson->id, $completedLessonIds))
                    <a href="{{ route('lessons.resolve', $lesson->id) }}" class="mt-2 block text-center bg-green-600 text-white py-1.5 rounded hover:bg-green-700 transition" aria-label="Resolve Lesson" title="Resolver lección">
                        Resolver lección
                    </a>
                @endif
                @if(Auth::check() && (Auth::user()->role_id === 1 || Auth::user()->role_id === 3))
                    <div class="flex justify-center mt-3 space-x-4">
                        <form method="POST" action="{{ route('lessons.destroy', $lesson->id) }}" onsubmit="event.preventDefault(); confirmDelete({{ $lesson->id }}, '{{ $lesson->title }}')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar lección" aria-label="Eliminar lección">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                            </button>
                        </form>
                        <button class="text-green-600 hover:text-green-800" 
                            onclick='openModal(@json($lesson))' 
                            aria-label="Edit Lesson" title="Edit Lesson">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endforeach

<div id="lessonModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-8 w-full max-w-xl relative shadow-lg">
        <button class="absolute top-5 right-5 text-gray-500 hover:text-gray-900 text-3xl font-bold leading-none" onclick="closeModal()" aria-label="Close modal">
            &times;
        </button>
        <h3 class="text-2xl font-bold mb-6" id="modalTitle">Add Lesson</h3>
        <form method="POST" action="{{ route('lessons.store') }}">
            @csrf
            <input type="hidden" name="id" id="lessonId"/>
            <label class="block mb-4">
                <span class="font-semibold">Title</span>
                <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-green-400"required/>
            </label>
            <label class="block mb-4">
                <span class="font-semibold">Description</span>
                <textarea name="description" id="description" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
            </label>
            <label class="block mb-4">
                <span class="font-semibold">Level</span>
                <select name="level" id="level" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-green-400"required>
                    <option value="">Select Level</option>
                    <option value="basic">Basic</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </label>
            <label class="block mb-4">
                <span class="font-semibold">Order</span>
                <input type="number" name="order" id="order" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-green-400" value="0"/>
            </label>
            <label class="block mb-6">
                <span class="font-semibold">Content (JSON)</span>
                <textarea name="content" id="content" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 font-mono text-sm" rows="6" placeholder='Ejemplo: {"text":"Hola"}'></textarea>
            </label>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                Save Lesson
            </button>
        </form>
    </div>
</div>
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md relative shadow-lg">
        <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-900 text-2xl font-bold" onclick="closeDeleteModal()">&times;</button>
        <h3 class="text-xl font-semibold text-gray-900 mb-4">¿Eliminar lección?</h3>
        <p class="text-gray-700 mb-6">¿Estás seguro de que deseas eliminar la lección <strong id="deleteLessonTitle"></strong>? Esta acción no se puede deshacer.</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">Sí, eliminar</button>
        </form>
    </div>
</div>

<script>
    function openModal(lesson = null) {
        document.getElementById('lessonModal').classList.remove('hidden');
        if (lesson) {
            document.getElementById('modalTitle').textContent = 'Edit Lesson';
            document.getElementById('lessonId').value = lesson.id;
            document.getElementById('title').value = lesson.title;
            document.getElementById('description').value = lesson.description ?? '';
            document.getElementById('level').value = lesson.level;
            document.getElementById('order').value = lesson.order;
            try {
                const content = lesson.content ? JSON.parse(lesson.content) : {};
                document.getElementById('content').value = JSON.stringify(content, null, 2);
            } catch(e) {
                document.getElementById('content').value = lesson.content ?? '';
            }
        } else {
            document.getElementById('modalTitle').textContent = 'Add Lesson';
            document.getElementById('lessonId').value = '';
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('level').value = '';
            document.getElementById('order').value = 0;
            document.getElementById('content').value = '';
        }
    }


    function closeModal() {
        document.getElementById('lessonModal').classList.add('hidden');
    }
    function confirmDelete(lessonId, title) {
        document.getElementById('deleteLessonTitle').textContent = title;
        document.getElementById('deleteForm').action = `/lessons/${lessonId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

</script>
@endsection
