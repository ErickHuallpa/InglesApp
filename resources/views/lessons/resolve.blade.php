@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[80vh]">
    <h1 class="text-3xl font-extrabold text-center text-green-700 mb-8 flex items-center gap-2 animate-pulse">
        <svg class="w-8 h-8 text-green-700" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.09 3.294c1.924.95 3.422 1.69 5.472.692a1 1 0 0 1 1.438.9v9.54a1 1 0 0 1-.562.9c-2.981 1.45-5.382.24-7.25-.701a38.739 38.739 0 0 0-.622-.31c-1.033-.497-1.887-.812-2.756-.77-.76.036-1.672.357-2.81 1.396V21a1 1 0 1 1-2 0V4.971a1 1 0 0 1 .297-.71c1.522-1.506 2.967-2.185 4.417-2.255 1.407-.068 2.653.453 3.72.967.225.108.443.216.655.32Z" />
        </svg>
        Resolver: {{ $lesson->title }}
    </h1>

    <form id="exerciseForm" action="{{ route('lessons.resolve.submit', $lesson->id) }}" method="POST" autocomplete="off" class="w-full max-w-2xl px-4">
        @csrf
        <div id="exerciseContainer">
            @foreach($exercises as $index => $exercise)
            <div class="exercise-step hidden transition duration-500 ease-in-out transform" data-index="{{ $index }}" data-correct="{{ implode(',', $exercise->correct_answer) }}">
                <div class="bg-white p-6 rounded-2xl shadow-xl border-2 border-green-100 flex flex-col gap-4">
                    <p class="text-xl font-bold text-green-800">Pregunta {{ $index + 1 }}:</p>
                    <p class="text-lg font-medium text-gray-800">{{ $exercise->question }}</p>
                    @if($exercise->media_url)
                        <div class="flex justify-center">
                            <img src="{{ $exercise->media_url }}" alt="media" class="rounded-lg max-h-60 object-contain" />
                        </div>
                    @endif
                    @if($exercise->type === 'multiple_choice')
                        <div class="grid gap-3">
                            @foreach($exercise->options as $option)
                                <label class="flex items-center gap-3 bg-green-50 hover:bg-green-100 p-3 rounded-lg cursor-pointer transition">
                                    <input type="checkbox" name="exercise_{{ $exercise->id }}[]" value="{{ $option }}" class="accent-green-600">
                                    <span class="text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($exercise->type === 'short_answer')
                        <input type="text" name="exercise_{{ $exercise->id }}" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="Escribe tu respuesta">
                    @elseif($exercise->type === 'true_false')
                        <div class="grid gap-3">
                            <label class="flex items-center gap-3 bg-blue-50 hover:bg-blue-100 p-3 rounded-lg cursor-pointer transition">
                                <input type="radio" name="exercise_{{ $exercise->id }}" value="true" class="accent-blue-600">
                                <span class="text-gray-700">Verdadero</span>
                            </label>
                            <label class="flex items-center gap-3 bg-red-50 hover:bg-red-100 p-3 rounded-lg cursor-pointer transition">
                                <input type="radio" name="exercise_{{ $exercise->id }}" value="false" class="accent-red-600">
                                <span class="text-gray-700">Falso</span>
                            </label>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between items-center mt-8">
            <button type="button" onclick="prevExercise()" id="prevBtn" class="flex items-center gap-2 bg-gray-300 px-6 py-2 rounded-lg hover:bg-gray-400 hidden transition-all">
                <svg class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M13.729 5.575c1.304-1.074 3.27-.146 3.27 1.544v9.762c0 1.69-1.966 2.618-3.27 1.544l-5.927-4.881a2 2 0 0 1 0-3.088l5.927-4.88Z" clip-rule="evenodd" />
                </svg>
                Anterior
            </button>
            <button type="button" onclick="nextExercise()" id="nextBtn" class="flex items-center gap-2 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all">
                Siguiente
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd" />
                </svg>
            </button>
            <button type="button" onclick="submitExercises()" id="submitBtn" class="flex items-center gap-2 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 hidden transition-all">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2ZM7.99 9a1 1 0 0 1 1-1H9a1 1 0 0 1 0 2h-.01a1 1 0 0 1-1-1ZM14 9a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H15a1 1 0 0 1-1-1Zm-5.506 7.216A5.5 5.5 0 0 1 6.6 13h10.81a5.5 5.5 0 0 1-8.916 3.216Z" clip-rule="evenodd" />
                </svg>
                Enviar respuestas
            </button>
        </div>
    </form>
</div>

<div id="feedbackModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full text-center border-t-4 border-green-500">
        <p id="feedbackMessage" class="text-xl font-semibold text-gray-800"></p>
        <button onclick="closeFeedbackModal()" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Continuar</button>
    </div>
</div>

<div id="finalModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md text-center shadow-2xl border-t-4 border-purple-500">
        <p id="finalMessage" class="text-2xl font-bold text-gray-800 mb-6"></p>
        <button onclick="window.location.href='{{ route('lessons.index') }}'" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
            </svg>
            Finalizar
        </button>
    </div>
</div>

<script>
    let currentStep = 0;
    const steps = document.querySelectorAll('.exercise-step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    let correctCount = 0;
    const totalSteps = steps.length;

    function showStep(index) {
        steps.forEach((step, i) => {
            step.classList.toggle('hidden', i !== index);
        });
        prevBtn.classList.toggle('hidden', index === 0);
        nextBtn.classList.toggle('hidden', index === steps.length - 1);
        submitBtn.classList.toggle('hidden', index !== steps.length - 1);
    }

    function nextExercise() {
        const currentExercise = steps[currentStep];
        const exerciseId = currentExercise.querySelector('input, textarea')?.name?.match(/\d+/)?.[0];

        let isCorrect = false;

        if (exerciseId) {
            const inputName = `exercise_${exerciseId}`;
            const inputs = currentExercise.querySelectorAll(`[name^="${inputName}"]`);
            const userValues = [];

            inputs.forEach(input => {
                if ((input.type === 'checkbox' || input.type === 'radio') && input.checked) {
                    userValues.push(input.value.trim().toLowerCase());
                } else if (input.type === 'text' && input.value.trim() !== '') {
                    userValues.push(input.value.trim().toLowerCase());
                }
            });

            const correctAnswers = currentExercise.getAttribute('data-correct')?.toLowerCase().split(',');

            if (correctAnswers) {
                const sortedUser = [...userValues].sort();
                const sortedCorrect = [...correctAnswers].sort();
                isCorrect = JSON.stringify(sortedUser) === JSON.stringify(sortedCorrect);
            }

            if (isCorrect) correctCount++;

            showFeedbackModal(isCorrect ? "✅ ¡Respuesta correcta!" : "❌ Respuesta incorrecta");
        } else {
            continueToNextStep();
        }
    }

    function continueToNextStep() {
        if (currentStep < totalSteps - 1) {
            currentStep++;
            showStep(currentStep);
        } else {
            const message = correctCount >= totalSteps
                ? `🎉 ¡Lección completada! Obtuviste la insignia. Puntaje: ${correctCount}/${totalSteps}`
                : `🔔 Resolviste ${correctCount}/${totalSteps} correctamente. Intenta mejorar para obtener la insignia.`;
            showFeedbackModal(message, true);
        }
    }

    function prevExercise() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    }

    function showFeedbackModal(message, final = false) {
        document.getElementById('feedbackMessage').innerText = message;
        const modal = document.getElementById('feedbackModal');
        modal.classList.remove('hidden');

        if (final) {
            document.getElementById('submitBtn').classList.remove('hidden');
            document.getElementById('nextBtn').classList.add('hidden');
        }
    }

    function closeFeedbackModal() {
        document.getElementById('feedbackModal').classList.add('hidden');
        continueToNextStep();
    }

    function submitExercises() {
        const form = document.getElementById('exerciseForm');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            const finalModal = document.getElementById('finalModal');
            document.getElementById('finalMessage').innerText = data.message || 'Gracias por resolver la lección.';
            finalModal.classList.remove('hidden');
        })
        .catch(err => {
            alert("Ocurrió un error al enviar las respuestas.");
            console.error(err);
        });
    }

    showStep(currentStep);
</script>
@endsection
