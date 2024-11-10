<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MyVoucherController extends Controller
{
    public function index()
    {
        $data = VoucherUsage::with('voucher')
            ->where('user_id', Auth::id())
            // ->Where('end_date', '>', Carbon::now())
            ->get();
        // dd($data->toArray());
        return view('client.pages.profile.voucher', compact('data'));
    }
    public function create()
    {
        $voucherId = 2;

        $voucher = Voucher::find($voucherId);

        if ($voucher) {
            $startDate = Carbon::now()->lt($voucher->start_date) ? $voucher->start_date : Carbon::now();

            $data = [
                "user_id"       => Auth::id(),
                "voucher_id"    => $voucherId,
                "vourcher_code" =>  strtoupper(string: Str::random(8)),
                "start_date"    => $startDate,
                "end_date"      => $voucher->end_date,
                "status"        => "ACTIVE",
            ];

            VoucherUsage::create($data);
        }

        return back()->with('success', 'Thành công');
    }
}
