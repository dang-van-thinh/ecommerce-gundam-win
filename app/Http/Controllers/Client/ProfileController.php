<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function infomation()
    {
        return view('client.pages.profile.information');
    }


    public function orderHistory()
    {
        return view('client.pages.profile.order');
    }

    public function address()
    {
        return view('client.pages.profile.address');
    }
}
