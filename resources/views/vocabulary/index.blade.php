@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Mi Vocabulary</h1>

    @if($vocabulary->isEmpty())
        <p class="text-gray-600">No tienes palabras registradas.</p>
    @else
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">Palabra</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Traducción</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Ejemplo</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Pronunciación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vocabulary as $word)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $word->word }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $word->translate }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $word->example ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $word->pronunciation ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
