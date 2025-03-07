<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'primary_category_id' => ['required'],
            'secondary_category_name' => ['max:50'],
            'thirdry_category_name' => ['max:50'],
        ];
    }

    public function messages()
    {
        return [
            'primary_category_id.required' => '収支区分の選択は必須です。',
            'secondary_category_name.max' => '大カテゴリ名は50文字以内で入力してください。',
            'thirdry_category_name.max' => '小カテゴリ名は50文字以内で入力してください。',
        ];
    }
}
