<?php

namespace App\Http\Requests\Surgicare;

use App\Support\Surgicare\SiapOperasi\SiapOperasiTrack;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class SaveGuideChecklistRequest extends FormRequest
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
            'track' => ['required', Rule::enum(SiapOperasiTrack::class)],
            'item_id' => ['required', 'string', 'max:100'],
            'checked' => ['required', 'boolean'],
        ];
    }

    public function track(): SiapOperasiTrack
    {
        return SiapOperasiTrack::from($this->validated('track'));
    }
}
