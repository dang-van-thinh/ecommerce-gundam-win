<?php

namespace App\Http\Controllers\Admin;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use App\Http\Requests\attrbutes\UpdateAttributeRequest;
use App\Http\Requests\attributes\AttributeRequest;
use Flasher\Prime\Notification\NotificationInterface;

class AttributeController extends Controller
{
    public function index()
    {
        $attribute =  Attribute::query()
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view("admin.pages.attributes.attribute.index",['attribute' => $attribute]);
    }

    public function store(AttributeRequest $request)
    {
        Attribute::insert([
            'name' => $request->name,
        ]);

        toastr("Chúc mừng bạn thêm mới thành công ", NotificationInterface::SUCCESS, "Thêm mới thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributes.index');
    }

    public function edit(string $id)
    {
        $attribute = Attribute::find($id);
        return view("admin.pages.attributes.attribute.update", compact('attribute'));
    }

    public function update(UpdateAttributeRequest $request, string $id)
    {
        $attribute = Attribute::find($id);
        $attribute->update([
            'name' => $request->name,
        ]);
        toastr("Chúc mừng bạn cập nhật mới thành công ", NotificationInterface::SUCCESS, "Cập nhật thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributes.index');
    }

    public function destroy(string $id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        toastr("Chúc mừng bạn cập nhật mới thành công ", NotificationInterface::SUCCESS, "Cập nhật thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributes.index');
    }
}
