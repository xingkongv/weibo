<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Illuminate\Validation\Validator;


class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [            
            'except' => ['show', 'create', 'store']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $request->validate([
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data[ 'name' ] = $request->name;
        if( $request->password )
        {
            $data[ 'password' ] = bcrypt( $request->password );
        }

        $user->update( $data );

        session()->flash( 'success' , '个人资料更新成功' );

        return redirect()->route('users.show', $user);
    }
}
