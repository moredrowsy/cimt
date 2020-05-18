<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user.view']);
    }

    public function index()
    {
        $data = [
            'verified' => Auth::user() ? Auth::user()->hasVerifiedEmail() : false,
        ];
        return view('pages.index')->with($data);
    }
}
