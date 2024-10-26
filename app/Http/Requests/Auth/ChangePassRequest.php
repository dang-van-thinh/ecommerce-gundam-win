<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangePassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả người dùng thực hiện yêu cầu này
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();

        return [
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                Rule::notIn([$user->password]), // đảm bảo mật khẩu mới không trùng với mật khẩu cũ
            ],
            'new_password_confirmation' => 'required|string|min:8', // xác nhận mật khẩu mới
        ];
    }

    /**
     * Customize the error messages.
     */
    public function messages()
    {
        return [
            'current_password.required' => 'Vui lòng không bỏ trống.',
            'new_password.required' => 'Vui lòng không bỏ trống.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'new_password_confirmation.required' => 'Vui lòng không bỏ trống.',
            'new_password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.',
            'new_password.not_in' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.',
        ];
    }
}
