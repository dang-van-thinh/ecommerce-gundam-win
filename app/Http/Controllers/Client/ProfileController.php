<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
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
        $user_id =User::where('user_id')->get();
        $provinces = Province::all();
        $districts = District::where('province_id')->get();
        $wards = Ward::where('district_id')->get();

        return view('client.pages.profile.address', compact('provinces', 'districts', 'wards', 'user_id'));
    }
}
