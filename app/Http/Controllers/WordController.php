<?php

namespace App\Http\Controllers;

use App\Models\Word;

class WordController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Word::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('word', 'LIKE', "%{$search}%")
                ->orWhere('translate', 'LIKE', "%{$search}%")
                ->orWhere('language', 'LIKE', "%{$search}%");
            });
        }

        $words = $query->orderBy('word', 'asc')->paginate(20)->appends(['search' => $search]);
        return view('words.index', compact('words'));
    }
}
