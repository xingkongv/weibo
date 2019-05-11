<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StaticPagesController extends Controller
{

    public function home()
    {
        // return view( 'static_page/home' );
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        return view('static_page/home', compact('feed_items'));
    }

    public function help()
    {
        return view( 'static_page/help' );
    }

    public function about()
    {
        return view( 'static_page/about' );
    }
}
