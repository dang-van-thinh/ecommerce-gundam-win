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

    
    public function rules()
    {
        // Định nghĩa các quy tắc xác thực ban đầu
        $rules = [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_type' => 'required|in:HEADER,CONTENT-LEFT-TOP,CONTENT-LEFT-BELOW,CONTENT-RIGHT,SUBSCRIBE-NOW-EMAIL,BANNER-LEFT,BANNER-RIGHT',
            'link' => 'required|nullable|url',
        ];

        // Kiểm tra image_type và thêm quy tắc kích thước ảnh
        switch ($this->input('image_type')) {
            case 'HEADER':
                $rules['image'] .= '|dimensions:max_width=930,max_height=380'; // Header yêu cầu kích thước tối thiểu 930x380
                break;
            case 'CONTENT-LEFT-TOP':
                $rules['image'] .= '|dimensions:max_width=650,max_height=300'; // CONTENT-LEFT-TOP yêu cầu 650x300
                break;
            case 'CONTENT-LEFT-BELOW':
                $rules['image'] .= '|dimensions:max_width=650,max_height=300'; // CONTENT-LEFT-BELOW yêu cầu 650x300
                break;
            case 'CONTENT-RIGHT':
                $rules['image'] .= '|dimensions:max_width=500,max_height=550'; // CONTENT-RIGHT yêu cầu 500x550
                break;
            case 'SUBSCRIBE-NOW-EMAIL':
                $rules['image'] .= '|dimensions:max_width=1100,max_height=700'; // SUBSCRIBE-NOW-EMAIL yêu cầu 1100x700
                break;
            case 'BANNER-LEFT':
                $rules['image'] .= '|dimensions:max_width=700,max_height=700'; // BANNER-LEFT yêu cầu 700x700
                break;
            case 'BANNER-RIGHT':
                $rules['image'] .= '|dimensions:max_width=700,max_height=500'; // BANNER-RIGHT yêu cầu 700x500
                break;
        }
        

        return $rules;
        
    }

   
    public function messages()
    {
        return [
            'title.required' => 'Không được để trống',
            'image.required' => 'Không được để trống hình ảnh',
            'image.image' => 'Định dạng hình ảnh không hợp lệ',
            'image.dimensions' => 'Kích thước hình ảnh không hợp lệ cho loại hình ảnh đã chọn',
            'link.url' => 'Đường link không hợp lệ',  // Thêm thông báo lỗi cho link nếu cần
        ];
    }
}
