@extends('layouts.dashboard')

@section('content')
    @php
        $orderedLevels = ['Basic', 'Intermediate', 'Advanced'];
        $levelDescriptions = [
            'Basic' => 'Comienza con fundamentos y vocabulario básico para arrancar con buen pie.',
            'Intermediate' => 'Perfecciona tus habilidades y amplía tus conocimientos en inglés.',
            'Advanced' => 'Domina el idioma con ejercicios complejos y contenido avanzado.',
        ];
        $levelImages = [
            'Basic' => 'https://s3.amazonaws.com/sk.assets/web/img/courses/illu-basic-large.svg',
            'Intermediate' => 'https://s3.amazonaws.com/sk.assets/web/img/courses/illu-intermedio-large.svg',
            'Advanced' => 'https://s3.amazonaws.com/sk.assets/web/img/courses/illu-avanzado-large.svg',
        ];
    @endphp

    <h1 class="text-3xl font-bold text-gray-800 mb-3 text-center uppercase tracking-wide">Cursos de Inglés</h1>
    <h2 class="text-lg text-gray-600 mb-8 max-w-3xl mx-auto text-center leading-relaxed">
        Estos son nuestros cursos de inglés listos para que empieces a aprender y avances a tu propio ritmo.
    </h2>

    <div class="max-w-6xl mx-auto flex justify-center gap-8">
        @foreach ($orderedLevels as $level)
            <div 
                class="bg-white rounded-3xl shadow-lg max-w-sm cursor-pointer flex flex-col items-center p-8 hover:shadow-2xl transition relative"
                onclick="openModal('{{ $level }}')"
            >
                <img src="{{ $levelImages[$level] }}" alt="{{ $level }} illustration" class="w-full h-auto mb-6">
                <h2 class="text-3xl font-extrabold mb-3 text-center text-blue-700 tracking-tight">{{ $level }}</h2>
                <p class="text-gray-700 mb-8 text-center leading-relaxed px-2">{{ $levelDescriptions[$level] }}</p>
                <button 
                    class="bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition font-semibold tracking-wide"
                    type="button"
                >
                    Ver lecciones
                </button>
            </div>
        @endforeach
    </div>

    <h1 class="mt-16 text-3xl font-bold text-gray-800 mb-2 text-center uppercase tracking-wide">Temas Populares</h1>
    <h2 class="text-gray-600 mb-10 max-w-3xl mx-auto text-center leading-relaxed text-lg">
        Estas son las lecciones más visitadas en los últimos 30 días
    </h2>
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-12">
        @foreach ($popularLessons as $lesson)
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between cursor-pointer hover:shadow-xl transition">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 tracking-wide">{{ $lesson->title }}</h3>
                <p class="text-gray-700 text-sm mb-4 flex-grow leading-relaxed">{{ Str::limit($lesson->description, 100) }}</p>
                <p class="text-xs text-gray-500 italic tracking-wide">Completado {{ $lesson->completions }} veces</p>
            </div>
        @endforeach
    </div>

    <p class="mb-12 text-gray-700 max-w-3xl mx-auto text-center text-base leading-relaxed">
        Aprende inglés a tu ritmo con nuestras lecciones organizadas por niveles: 
        <span class="font-semibold">Basic</span>, 
        <span class="font-semibold">Intermediate</span> y 
        <span class="font-semibold">Advanced</span>.
        Explora contenido interactivo, ejercicios prácticos y consigue insignias a medida que progresas.
    </p>
    <div id="lessonsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl max-w-6xl w-full max-h-[90vh] overflow-y-auto p-8 relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
            <h3 id="modalTitle" class="text-2xl font-bold mb-6 text-center"></h3>
            <div id="modalLessons" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            </div>
        </div>
    </div>

    <script>
        const lessonsByLevel = @json($lessonsByLevel);
        const iconsByLevel = {
            'Basic': `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 20V6a2 2 0 012-2h8a2 2 0 012 2v14" />
                </svg>
            `,
            'Intermediate': `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            `,
            'Advanced': `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12l2 2 4-4" />
                </svg>
            `,
        };

        function openModal(level) {
            const modal = document.getElementById('lessonsModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalLessons = document.getElementById('modalLessons');
            modalTitle.textContent = level + ' Lessons';
            modalLessons.innerHTML = '';
            if (lessonsByLevel[level]) {
                lessonsByLevel[level].forEach(lesson => {
                    const card = document.createElement('div');
                    card.className = 'bg-gray-50 rounded-lg shadow p-4 flex flex-col items-center cursor-pointer hover:shadow-lg transition';

                    card.innerHTML = `
                        ${iconsByLevel[level] || ''}
                        <h4 class="text-lg font-semibold text-center text-gray-800 mb-2">${lesson.title}</h4>
                        <p class="text-gray-600 text-sm text-center">${lesson.description.length > 100 ? lesson.description.substring(0, 100) + '...' : lesson.description}</p>
                    `;
                    modalLessons.appendChild(card);
                });
            } else {
                modalLessons.innerHTML = '<p class="col-span-full text-center text-gray-600">No lessons found.</p>';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeModal() {
            const modal = document.getElementById('lessonsModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
        document.getElementById('lessonsModal').addEventListener('click', (e) => {
            if (e.target.id === 'lessonsModal') {
                closeModal();
            }
        });
    </script>
@endsection
