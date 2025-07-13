<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest
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
            'status' => 'required|string',
            'placelocated' => 'required|string',
            'category' => 'required|string',
            'itemname' => 'required|string|max:255',
            'receivedby' => 'required|string|max:255',
            'receivedfrom' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}
