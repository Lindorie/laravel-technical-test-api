<?php

namespace App\Http\Requests;

use App\Enums\ProfilStatutEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreProfilRequest extends FormRequest
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
        return [
            'nom' => 'required|string|max:250',
            'prenom' => 'required|string|max:250',
            'image' => 'required|image|mimetypes:image/jpeg,image/png',
            'statut' => [
                'required',
                Rule::enum(ProfilStatutEnum::class),
            ],
            'administrateur_id' => 'required|exists:App\Models\Administrateur,id',
        ];
    }
}
