<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'date' => ['required'],
            'partner_name' => ['max:100'],
            'secondary_category_id' => ['required'],
            'price' => ['required', 'numeric'],
            'user_id' => ['required'],
        ];
    }
}
