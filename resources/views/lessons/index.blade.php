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
                <button class="absolute top-2 right-2 text-green-600 hover:text-green-800"onclick="openModal({{ $lesson }})"aria-label="Edit Lesson"title="Edit Lesson">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 17h2M12 14v3m-4-7l3 3m-3-3a2.5 2.5 0 013.54 0l3 3a2.5 2.5 0 010 3.54l-3 3a2.5 2.5 0 01-3.54 0l-3-3a2.5 2.5 0 010-3.54l3-3z" />
                    </svg>
                </button>
                <a href="{{ route('lessons.exercises', $lesson->id) }}"class="mt-4 block text-center bg-indigo-600 text-white py-1.5 rounded hover:bg-indigo-700 transition"aria-label="View Exercises for {{ $lesson->title }}"title="View Exercises">
                    Ver ejercicios
                </a>
                @if (!in_array($lesson->id, $completedLessonIds))
                    <a href="{{ route('lessons.resolve', $lesson->id) }}" class="mt-2 block text-center bg-green-600 text-white py-1.5 rounded hover:bg-green-700 transition" aria-label="Resolve Lesson" title="Resolver lección">
                        Resolver lección
                    </a>
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
            document.getElementById('content').value = JSON.stringify(lesson.content ?? {}, null, 2);
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
</script>
@endsection
