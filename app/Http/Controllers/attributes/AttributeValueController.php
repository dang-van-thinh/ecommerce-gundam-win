<?php

namespace App\Http\Controllers\attributes;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\attrbuteValue\UpdateAttributvalueRequest;
use App\Http\Requests\attributeValue\AttributeValueRequest;
use Flasher\Prime\Notification\NotificationInterface;

class AttributeValueController extends Controller
{
   
    public function index()
    {
        $attributeModel =  Attribute::query()
            ->orderBy('id', 'asc')
            ->paginate(10);
        $listAttributes = $attributeModel;
        $attributeValueModel =  AttributeValue::query()
            ->orderBy('id', 'asc')
            ->paginate(4);
        $listAttributeValues = $attributeValueModel;
        return view('admin.pages.attributes.attributeValue.index', [
            'listAttributes' => $listAttributes,
            'listAttributeValues' => $listAttributeValues
        ]);
    }

    public function store(AttributeValueRequest $request)
    {
        //
        AttributeValue::create([
            'attribute_id' => $request['attribute_id'],
            'name' => $request['name'],
        ]);
        toastr("Chúc mừng bạn thêm mới thành công ", NotificationInterface::SUCCESS, "Thêm mới thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributeValues.index');
    }
    public function edit(string $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $listAttributes = Attribute::all();
        return view('admin.pages.attributes.attributeValue.update', compact('attributeValue', 'listAttributes'));
    }

    public function update(UpdateAttributvalueRequest $request, string $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->update([
            'attribute_id' => $request->input('attribute_id'),
            'name' => $request->input('name'),
        ]);
        toastr("Chúc mừng bạn cập thành công ", NotificationInterface::SUCCESS, "Cập nhật thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributeValues.index');
    }

    public function destroy(string $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();
        toastr("Chúc mừng bạn xóa thành công ", NotificationInterface::SUCCESS, "Thành công ", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('attributeValues.index');
    }
}