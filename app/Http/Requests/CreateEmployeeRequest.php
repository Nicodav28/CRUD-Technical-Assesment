<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            'nombre'      => 'required|string|max:255',
            'email'       => 'required|email|unique:employees,email',
            'sexo'        => 'required|in:M,F',
            'area_id'     => 'required|exists:areas,id',
            'descripcion' => 'required|string',
            'boletin'     => 'required',
            'roles'       => 'required|array|min:1',
            'roles.*'     => 'exists:roles,id'
        ];
    }
}
