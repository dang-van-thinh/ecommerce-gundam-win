<?php

namespace App\Http\Controllers;


use App\Models\Voucher;
use App\Http\Requests\voucher\CreateVoucherRequest;

use Flasher\Prime\Notification\NotificationInterface;

use Carbon\Carbon;

class VocuherController extends Controller
{
    public function index()
    {
        $getAllVoucher = Voucher::latest('id')->paginate(1);
        return view('admin.pages.voucher.index', compact('getAllVoucher'));
    }

    public function create()
    {
        return view('admin.pages.voucher.create');
    }

    public function store(CreateVoucherRequest $request)
    {
        Voucher::create([
            'name' => $request->name,
            'description' => $request->description,
            'limit' => $request->limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value,
            'max_order_value' => $request->max_order_value,
            'status' => $request->status,
        ]);

        toastr("Thêm thành công dữ liệu voucher", NotificationInterface::SUCCESS, "Thành công !", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return back();
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.pages.voucher.edit', compact('voucher'));
    }

    public function update(CreateVoucherRequest $request, string $id)
    {
        $voucher = Voucher::findOrFail($id);

        $dataUpdate = [
            'name' => $request->name,
            'description' => $request->description,
            'limit' => $request->limit,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value,
            'max_order_value' => $request->max_order_value,
            'status' => $request->status,
        ];
        $updateSuccess = $voucher->update($dataUpdate);

        if ($updateSuccess) {
            toastr("Cập nhật thành công voucher !", NotificationInterface::SUCCESS, "Thành công !", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->route('voucher.index');
        }
        toastr("Cập nhật không thành công !", NotificationInterface::ERROR, "Thất bại !", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $voucherDestroy = Voucher::destroy($id);
        if ($voucherDestroy) {
            toastr("Xóa voucher thành công !", NotificationInterface::SUCCESS, "Thành công !", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->route('voucher.index');
        }
        toastr("Xóa voucher không thành công !", NotificationInterface::ERROR, "Thất bại !", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('voucher.index');
    }
}