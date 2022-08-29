<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:10'],
            'voter_id' => ['required', 'integer', 'exists:users,id'],
            'voted_id' => ['required', 'integer', 'exists:users,id'],
            'text' => ['string', 'min:3', 'max:255', 'nullable'],
        ];
    }
}
