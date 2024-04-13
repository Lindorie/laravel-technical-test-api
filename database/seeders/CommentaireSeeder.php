<?php

namespace Database\Seeders;

use App\Models\Administrateur;
use App\Models\Commentaire;
use App\Models\Profil;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Administrateur with 5 Profils and a Commentaire for each.
        Administrateur::factory()
            ->has(
                Profil::factory()
                    ->has(
                        Commentaire::factory()
                            ->state(function (array $attributes, Profil $profil) {
                                return [
                                    'administrateur_id' => $profil->administrateur_id,
                                    'profil_id' => $profil->id,
                                ];
                            })
                    )
                    ->count(5)
                    ->state(function (array $attributes, Administrateur $user) {
                        return ['administrateur_id' => $user->id];
                    })
            )
            ->create();
    }
}
