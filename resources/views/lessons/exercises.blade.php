@extends('layouts.dashboard')

@section('content')
<h1 class="text-3xl font-extrabold mb-6">Exercises for: {{ $lesson->title }}</h1>

@if($exercises->isEmpty())
    <p>No exercises found for this lesson.</p>
@else
    <ul class="space-y-4">
        @foreach($exercises as $exercise)
            <li class="p-4 border rounded shadow-sm bg-white">
                <p><strong>Question:</strong> {{ $exercise->question }}</p>
                <p><strong>Type:</strong> {{ ucfirst($exercise->type) }}</p>
            </li>
        @endforeach
    </ul>
@endif

<a href="{{ route('lessons.index') }}" class="inline-block mt-6 text-blue-600 hover:underline">&larr; Back to Lessons</a>
@endsection
