<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function dropMenu()
    {
        return view('testes.dropMenu');
    }
}
