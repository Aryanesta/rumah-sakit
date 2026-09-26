<?php

namespace App\Http\Requests\Surgicare;

use Illuminate\Foundation\Http\FormRequest;

final class SubmitSiapCheckRequest extends FormRequest
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
            'answers' => ['required', 'array'],
            'answers.*' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function answers(): array
    {
        /** @var array<string, string> $answers */
        $answers = $this->validated('answers');

        return $answers;
    }
}
