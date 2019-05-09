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
        // $this->validate( $request , [
        //     'name' => 'required|max:50',
        //     'email' => 'required|email|uniqe:users|max:255',
        //     'password' => 'required|confirmed|min:6',
        // ] );

        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
        return;
    }
}
