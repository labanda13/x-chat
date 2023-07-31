<?php

namespace App\Http\Requests;

use App\Models\Guest;
use Illuminate\Foundation\Http\FormRequest;

class StoreGuest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => ['required'],
            'age' => ['required', 'integer', 'min:16', 'max:99'],
            'gender' => ['required', 'string', 'in:'.implode(',', Guest::getGenders())]
        ];
    }
}
