<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Validator;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        $user->gravatar('140');
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt( $request->password ),
        ]);

        Auth::login($user);
        session()->flash( 'success' , '欢迎,您将在这里开启一段新旅程' );
        return redirect()->route('users.show' , [$user]);
    }
}
