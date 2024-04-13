<?php

namespace App\Http\Requests;

use App\Models\Commentaire;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommentaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user already commented on this profile before authorizing.
        $profil = $this->route('profil');
        $user = Auth::user();

        if (Commentaire::where('profil_id', $profil->id)->where('administrateur_id', $user->id)->exists()) {
            // There is already a Commentaire for this Profil by this Administrateur, so the request is not authorized.
            return false;
        }

        // Only authenticated users can make this request.
        return Auth::check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Add relationships ids to the request, so they can be validated.
        $this->merge([
            'administrateur_id' => Auth::user()->id,
            'profil_id' => $this->route('profil')->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contenu' => 'required|string|max:500',
            'administrateur_id' => 'required|exists:App\Models\Administrateur,id',
            'profil_id' => 'required|exists:App\Models\Profil,id',
        ];
    }
}
