<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController
{
    public function __invoke(Request $request)
    {
        return view('home');
    }
}
