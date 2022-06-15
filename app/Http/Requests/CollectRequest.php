<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'co2' => 'required|integer|max:10000',
            'time' => 'required',
        ];
    }


}
