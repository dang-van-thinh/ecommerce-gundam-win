<?php

namespace App\Http\Controllers;

class DefaultController extends Controller
{
    public function pageNotFound()
    {
        return view('client.pages.404');
    }
}
