<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email',
                \Illuminate\Validation\Rule::unique('users', 'email')
                    ->ignore($req->user_id ?? null)
            ],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6',
        ]);

        if ($req->method() === 'PUT') {
            $user = User::findOrFail($req->user_id);
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
            ];
            if (!empty($data['password'])) {
                $userData['password'] = bcrypt($data['password']);
            }
            $user->update($userData);
        } else {
            $data['password'] = !empty($data['password']) ? bcrypt($data['password']) : bcrypt('secret123');
            $data['level'] = 'basic';
            User::create($data);
        }

        return redirect()->route('users.index')->with('success', 'Usuario guardado.');
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado.');
    }
}
