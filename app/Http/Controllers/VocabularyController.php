<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $vocabulary = $user->vocabulary()->get();

        return view('vocabulary.index', compact('vocabulary'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:255',
            'translate' => 'required|string|max:255',
            'example' => 'nullable|string|max:255',
            'pronunciation' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->vocabulary()->create([
            'word' => $request->word,
            'translate' => $request->translate,
            'example' => $request->example,
            'pronunciation' => $request->pronunciation,
        ]);

        return redirect()->route('vocabulary.index')->with('success', 'Palabra añadida correctamente');
    }
}
