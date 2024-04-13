<?php

namespace Database\Seeders;

use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Administrateur::factory()->create();

        Profil::factory()
            ->count(5)
            ->for($user)
            ->create();
    }
}
