<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserActivationMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function create()
    {
        return view('admin.users.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make(Str::random(12)), //
            'activation_token' => Str::random(60),

        ]);

        Mail::to($user->email)->send(new UserActivationMail($user));

        $user->assignRole('Admin');

        return redirect()->route('admin.users')->with('success', 'Admin user created!');
    }

    public function index(Request $request) 
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->with('roles');
        if ($request->filled('search')) {
            $search = $request->input('search');
            $users->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $users->paginate(15);
    
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user) 
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit',['user' => $user]);
    }

    public function update(User $user)
    {
       $attributes = request()->validate([
            'first_name' => ['required','string','max:100'],
            'middle_name' => ['string', 'sometimes', 'nullable', 'max:100'],
            'last_name' => ['required','string'],
            'email' => ['email','required',Rule::unique('users','email')->ignore($user->id)],
            'phone_number' => 'required'

       ]);

       $user->update($attributes);

       return back()->with('success', 'User updated!');
    }

    public function destroy(User $user)
    {
       $user->delete();

       return back()->with('success', 'User deleted!');
    }
}
