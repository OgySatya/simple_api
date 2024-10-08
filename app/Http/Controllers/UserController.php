<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles'])->get();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|max:255',
            // 'role_id' => 'required|' . Rule::in(['1', '2', '3', '4']),
            'role_id' => 'required|exists:App\Models\Role,id',
        ]);
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());

        return response([$user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(User::find($id)->loadMissing('roles:name,id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|' . Rule::in(['1', '2', '3', '4']),
        ]);
        $user->update($request->all());
        return response($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return 'user deleted successfully.';
        }

        return 'error user not found.';
    }
}
