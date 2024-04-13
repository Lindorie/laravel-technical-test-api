<?php

namespace App\Http\Requests;

use App\Enums\ProfilStatutEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can make this request.
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Attributes are not required when updating.
        return [
            'nom' => 'string|max:250',
            'prenom' => 'string|max:250',
            'image' => 'image|mimetypes:image/jpeg,image/png',
            'statut' => [
                Rule::enum(ProfilStatutEnum::class),
            ],
            'administrateur_id' => 'exists:App\Models\Administrateur,id',
        ];
    }
}
