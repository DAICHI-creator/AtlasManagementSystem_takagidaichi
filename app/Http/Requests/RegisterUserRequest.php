<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー]+$/u', 'max:30'],
            'under_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー]+$/u', 'max:30'],
            'mail_address' => ['required', 'string', 'email', 'max:100', 'unique:users,mail_address'],
            'sex' => ['required', 'in:1,2,3'],
            'old_year' => ['required', 'integer', 'between:2000,' . now()->year],
            'old_month' => ['required', 'integer', 'between:1,12'],
            'old_day' => ['required', 'integer', 'between:1,31'],
            'role' => ['required', 'in:1,2,3,4'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'over_name.required' => '',
            'under_name.required' => '',
            'over_name_kana.required' => '',
            'under_name_kana.required' => '',
            'mail_address.required' => 'メールアドレスは必ず入力してください。',
            'mail_address.email' => '正しいメールアドレス形式で入力してください。',
            'mail_address.unique' => 'このメールアドレスは既に登録されています。',
            'mail_address.max' => 'メールアドレスは100文字以内で入力してください。',
            'old_year.required' => '',
            'old_month.required' => '',
            'old_day.required' => '',
            'password.required' => 'パスワードは必ず入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以下で入力してください。',
            'password.confirmed' => 'パスワードと確認用パスワードが一致しません。',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (
                empty($this->over_name) ||
                empty($this->under_name) ||
                empty($this->over_name_kana) ||
                empty($this->under_name_kana)
            ) {
                $validator->errors()->add('name_group', '名前は必ず入力してください。');
            }
        });

        $validator->after(function ($validator) {
            $year = $this->input('old_year');
            $month = $this->input('old_month');
            $day = $this->input('old_day');

            if (!checkdate((int)$month, (int)$day, (int)$year)) {
            $validator->errors()->add('old_day', '存在しない日付です。');
            }
        });
    }
}
