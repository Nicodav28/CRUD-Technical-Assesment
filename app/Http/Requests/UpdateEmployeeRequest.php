<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'      => 'sometimes|required|string|max:255',
            'email'       => [ 'sometimes', 'required', 'email', Rule::unique('employees', 'email')->ignore($this->route('id')) ],
            'sexo'        => 'sometimes|required|in:M,F',
            'area_id'     => 'sometimes|required|exists:areas,id',
            'descripcion' => 'sometimes|required|string',
            'boletin'     => 'sometimes|required',
            'roles'       => 'sometimes|required|array|min:1',
            'roles.*'     => 'exists:roles,id'
        ];
    }
}
