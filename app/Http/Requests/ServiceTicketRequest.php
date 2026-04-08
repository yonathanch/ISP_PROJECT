<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_wo' => 'required|date',
            'branch' => 'required|string|max:255',
            'no_wo_client' => 'required|string|max:255',
            'type_wo' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'teknisi' => 'required|string|max:255',
            'is_active' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'date_wo.required'      => 'The WO date is required.',
            'branch.required'       => 'The branch field is required.',
            'no_wo_client.required' => 'The client WO number is required.',
            'type_wo.required'      => 'The WO type is required.',
            'client.required'       => 'The client name is required.',
            'teknisi.required'      => 'The technician name is required.',
        ];
    }
}
