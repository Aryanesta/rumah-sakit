<?php

namespace App\Http\Requests\Angsmart;

use App\Enums\Angsmart\SurgicalPhase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'medical_record' => ['required', 'string', 'max:20'],
            'bed' => ['required', 'string', 'max:20'],
            'diagnosis' => ['required', 'string', 'max:255'],
            'phase' => ['required', Rule::enum(SurgicalPhase::class)],
        ];
    }
}
