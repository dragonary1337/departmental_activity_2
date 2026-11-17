<?php

namespace App\Http\Requests;

use App\Models\Equipment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(Equipment::CATEGORIES)],
            'unit_price' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
            'description' => ['required', 'string'],
            'availability_status' => ['required', Rule::in(Equipment::AVAILABILITY_STATUSES)],
        ];
    }
}
