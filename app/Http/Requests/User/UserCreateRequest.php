<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'employee_id' => 'required',
            'username' => [
                'required',
                'max:255',
                Rule::unique('tbl_user', 'username'),
                Rule::unique('tbl_user_hospital', 'username'),
                Rule::unique('tbl_user_customer', 'username'),
                Rule::unique('tbl_user_staff', 'username'),
            ],
            'password' => 'required|max:255|min:6',
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => __('validation.custom.user.employee_id_required'),
            'role_id.required' => 'Vui lòng chọn quyền tài khoản.',
            'username.required' => __('validation.custom.user.username_required'),
            'username.max' => __('validation.custom.user.username_max'),
            'username.unique' => __('validation.custom.user.username_unique'),
            'password.required' => __('validation.custom.user.password_required'),
            'password.max' => __('validation.custom.user.password_max'),
            'password.min' => __('validation.custom.user.password_min'),
        ];
    }
}
