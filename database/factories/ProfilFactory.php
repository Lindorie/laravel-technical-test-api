<?php

namespace Database\Factories;

use App\Enums\ProfilStatutEnum;
use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profil>
 */
class ProfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'image' => UploadedFile::fake()->image('image.jpg'),
            'statut' => Arr::random(ProfilStatutEnum::cases())->value,
            'administrateur_id' => Administrateur::factory(),
        ];
    }

    /**
     * Indicate that the profile is active.
     */
    public function actif(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'statut' => ProfilStatutEnum::ACTIF->value,
        ]);
    }
}
