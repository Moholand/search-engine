<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'title'      => 'nullable|string|max:255',
            'category'   => 'nullable|string',
            'price_from' => 'nullable|integer',
            'price_to'   => 'nullable|integer',
            'brand'      => 'nullable|string',
            'sort'       => 'nullable|string'
        ];
    }
}
