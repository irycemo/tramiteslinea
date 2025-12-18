<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcreditarPagoRequest extends FormRequest
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

        if(app()->isProduction()){

            return [
                'c_referencia' => 'required',
                'n_autoriz' => 'required',
            ];

        }else{

            return [
                'referencia' => 'required',
                'folio_acreditacion' => 'required',
                'estatus' => 'required',
                'forma_pago' => 'required',
                'tkn' => 'nullable',
            ];

        }
    }

    public function getClientIpAddresses():array
    {
        return $this->ips();
    }

}
