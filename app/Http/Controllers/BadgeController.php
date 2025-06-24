<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::orderByRaw("
            CASE level
                WHEN 'basic' THEN 1
                WHEN 'intermediate' THEN 2
                WHEN 'advanced' THEN 3
                ELSE 4
            END
        ")->get()->groupBy('level');

        return view('badges.index', compact('badges'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_url' => 'nullable|url',
            'criteria_json' => 'nullable|json',
        ]);

        Badge::create($request->all());

        return redirect()->route('badges.index')->with('success', 'Insignia creada exitosamente.');
    }


    public function update(Request $request, Badge $badge)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_url' => 'nullable|url',
            'criteria_json' => 'nullable|json',
        ]);

        $badge->update($request->all());

        return redirect()->route('badges.index')->with('success', 'Insignia actualizada exitosamente.');
    }

    public function destroy(Badge $badge)
    {
        $badge->delete();
        return redirect()->route('badges.index')->with('success', 'Insignia eliminada exitosamente.');
    }


}
