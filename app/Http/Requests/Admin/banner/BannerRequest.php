<?php

namespace App\Http\Requests\Admin\banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest 
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Define validation rules
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_type' => 'required|in:header,content',
            'link' => 'required|nullable|url',
        ];
    }

    // Custom error messages
    public function messages()
    {
        return [
            'title.required' => 'Không được để trống',
            'image.required' => 'Không được để trống hình ảnh',
            'link.required' => 'Không được để trống',
        ];
    }
}
