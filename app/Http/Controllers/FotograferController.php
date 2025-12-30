<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class FotograferController extends Controller
{
    /**
     * LIST FOTOGRAFER
     */
    public function index()
    {
        $fotografer = User::whereIn('role', [
            'fotografer',
            'videografer',
            'fotografer_videografer'
        ])->orderBy('username')->get();

        return view('fotografer.index', compact('fotografer'));
    }

    /**
     * STORE (CREATE)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'role' => ['required', Rule::in([
                'fotografer',
                'videografer',
                'fotografer_videografer'
            ])],
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $data['username'],
            'role'     => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Fotografer berhasil ditambahkan');
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'username' => [
                'required','string','max:255',
                Rule::unique('users','username')->ignore($user->id)
            ],
            'role' => ['required', Rule::in([
                'fotografer',
                'videografer',
                'fotografer_videografer'
            ])],
            'password' => 'nullable|min:6',
        ]);

        $user->username = $data['username'];
        $user->role = $data['role'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('success', 'Fotografer berhasil diupdate');
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Fotografer berhasil dihapus');
    }
}
