<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateProduct extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $id = $this->segment(2);
        $rules = [
            'name' => [
                Rule::unique('products')->ignore($id),
                'required',
                'min:3',
                'max:255'
            ],
            'image' => ['nullable', 'image'],
            'qty' => ['required', 'integer']
        ];

        if($this->method() == 'PUT') {
            // regras especificas de edicao
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    // public function messages() {
    //     return [
    //         'name.required' => 'O nome é obrigatório',
    //         'qty.required' => 'A quantidade é obrigatória',
    //     ];
    // }
}
