<?php

namespace App\Http\Controllers;

class ChatController extends Controller
{
    public function showViewAdmin()
    {
        return view("admin.pages.chat.index");
    }
}
