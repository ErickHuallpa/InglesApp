@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Words List</h1>

    @if($words->count())
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ route('words.index') }}" class="w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by word, translate or language..." class="px-4 py-2 border border-gray-300 rounded-md w-full sm:w-80 focus:outline-none focus:ring-2 focus:ring-green-400" onkeydown="if(event.key === 'Enter') this.form.submit();">
            </form>
            <div>
                {{ $words->links() }}
            </div>
        </div>

        <table class="min-w-full bg-white border border-gray-300 rounded-md">
            <thead>
                <tr class="bg-green-100 text-green-900">
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Word</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Translate</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Example</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Language</th>
                </tr>
            </thead>
            <tbody>
                @foreach($words as $word)
                    <tr class="hover:bg-green-50">
                        <td class="py-2 px-4 border-b border-gray-300">{{ $word->word }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $word->translate }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 font-mono text-sm bg-gray-50 rounded-md whitespace-pre-wrap">{{ $word->example }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            @php
                                $languages = [
                                    'c++' => [
                                        'color' => 'bg-blue-100 text-blue-800 border-blue-400',
                                        'icon' => '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M7 12h10M12 7v10"/></svg>',
                                        'label' => 'C++',
                                    ],
                                    'c#' => [
                                        'color' => 'bg-purple-100 text-purple-800 border-purple-400',
                                        'icon' => '<svg class="w-4 h-4 mr-1 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 10v8"/></svg>',
                                        'label' => 'C#',
                                    ],
                                    'python' => [
                                        'color' => 'bg-yellow-100 text-yellow-800 border-yellow-400',
                                        'icon' => '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 2c2.2 0 4 1.8 4 4v2H8V6c0-2.2 1.8-4 4-4z"/></svg>',
                                        'label' => 'Python',
                                    ],
                                    'javascript' => [
                                        'color' => 'bg-yellow-300 text-yellow-900 border-yellow-600',
                                        'icon' => '<svg class="w-4 h-4 mr-1 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/></svg>',
                                        'label' => 'JS',
                                    ],
                                    'general' => [
                                        'color' => 'bg-gray-100 text-gray-800 border-gray-400',
                                        'icon' => '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
                                        'label' => 'General',
                                    ],
                                    'html' => [
                                        'color' => 'bg-red-100 text-red-700 border-red-400',
                                        'icon' => '<svg class="w-4 h-4 mr-1 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="m3 2 1.578 17.824L12 22l7.467-2.175L21 2H3Zm14.049 6.048H9.075l.172 2.016h7.697l-.626 6.565-4.246 1.381-4.281-1.455-.288-2.932h2.024l.16 1.411 2.4.815 2.346-.763.297-3.005H7.416l-.562-6.05h10.412l-.217 2.017Z"/>
                                                    </svg>
                                                    ',
                                        'label' => 'HTML',
                                    ],
                                    'css' => [
                                        'color' => 'bg-blue-200 text-blue-900 border-blue-600',
                                        'icon' => '<svg class="w-4 h-4 mr-1 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="m3 2 1.578 17.834L12 22l7.468-2.165L21 2H3Zm13.3 14.722-4.293 1.204H12l-4.297-1.204-.297-3.167h2.108l.15 1.526 2.335.639 2.34-.64.245-3.05h-7.27l-.187-2.006h7.64l.174-2.006H6.924l-.176-2.006h10.506l-.954 10.71Z"/>
                                                    </svg>
                                                    ',
                                        'label' => 'CSS',
                                    ],
                                ];

                                $langKey = strtolower($word->language);
                                $badge = $languages[$langKey] ?? $languages['general'];
                            @endphp

                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold rounded-md border {{ $badge['color'] }}">
                                {!! $badge['icon'] !!}
                                {{ $badge['label'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Se eliminó la paginación inferior --}}
    @else
        <p>No words found.</p>
    @endif
</div>
@endsection
