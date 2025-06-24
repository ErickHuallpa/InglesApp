@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-center">Resolver: {{ $lesson->title }}</h1>

<form id="exerciseForm" action="{{ route('lessons.resolve.submit', $lesson->id) }}" method="POST" autocomplete="off">
    @csrf

    <div id="exerciseContainer">
        @foreach($exercises as $index => $exercise)
            <div class="exercise-step hidden" data-index="{{ $index }}">
                <div class="p-6 border rounded shadow-lg bg-white">
                    <p class="text-lg font-semibold mb-4">{{ $exercise->question }}</p>

                    @if($exercise->media_url)
                        <div class="mb-4">
                            <img src="{{ $exercise->media_url }}" alt="media" class="max-w-full h-auto rounded" />
                        </div>
                    @endif

                    @if($exercise->type === 'multiple_choice')
                        <div class="space-y-2">
                            @foreach($exercise->options as $option)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="exercise_{{ $exercise->id }}[]" value="{{ $option }}" class="accent-blue-600">
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($exercise->type === 'short_answer')
                        <input type="text" name="exercise_{{ $exercise->id }}" class="w-full mt-2 p-2 border rounded" placeholder="Tu respuesta">
                    @elseif($exercise->type === 'true_false')
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="exercise_{{ $exercise->id }}" value="true" class="accent-green-600">
                                <span>Verdadero</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="exercise_{{ $exercise->id }}" value="false" class="accent-red-600">
                                <span>Falso</span>
                            </label>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-between mt-6">
        <button type="button" onclick="prevExercise()" id="prevBtn" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 hidden">
            Anterior
        </button>
        <button type="button" onclick="nextExercise()" id="nextBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Siguiente
        </button>
        <button type="submit" id="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 hidden">
            Enviar respuestas
        </button>
    </div>
</form>

<script>
    let currentStep = 0;
    const steps = document.querySelectorAll('.exercise-step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showStep(index) {
        steps.forEach((step, i) => {
            step.classList.toggle('hidden', i !== index);
        });
        prevBtn.classList.toggle('hidden', index === 0);
        nextBtn.classList.toggle('hidden', index === steps.length - 1);
        submitBtn.classList.toggle('hidden', index !== steps.length - 1);
    }

    function nextExercise() {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevExercise() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    }
    showStep(currentStep);
</script>
@endsection
