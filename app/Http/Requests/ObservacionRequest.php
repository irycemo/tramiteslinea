<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObservacionRequest extends FormRequest
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
            'observacion' => 'required',
            'tipo_tramite' => 'nullable',
            'tramite_sgc' => 'nullable',
            'oficina_sgc' => 'required',
            'aviso_id' => 'nullable',
            'entidad_id' => 'required'
        ];
    }
}
