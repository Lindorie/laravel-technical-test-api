<?php

use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

// Necessary to access Laravel testing helpers and database factory stuff
uses(
    RefreshDatabase::class
);

it('seeds profiles', function () {
    $this->assertDatabaseCount(Profil::class, 0);

    $this->artisan('db:seed', ['--class' => 'ProfilSeeder']);

    $this->assertDatabaseCount(Profil::class, 5);
});

test('an Administrateur can create profiles', function () {
    $profil = Profil::factory()->raw();

    // Check that the request returns a Not authorized response before authentication.
    $this->json('POST', '/api/profil/create', $profil)->assertStatus(401);

    Sanctum::actingAs(
        Administrateur::factory()->create(),
        ['*']
    );

    // Request should be successful now the user is authenticated.
    $this->json('POST', '/api/profil/create', $profil)->assertStatus(201);
});

test('anyone can see the list of profils', function () {
    // This route should not need any authentication.
    $this->get('/api/profils')->assertStatus(200);
});

test('Guests cannot see the statut attribute', function () {
    Profil::factory()->actif()->create();

    $response = $this->getJson('/api/profils');

    // The statut should be missing from the Json response.
    $response
        ->assertJson(function (AssertableJson $json) {
            return $json->first(function (AssertableJson $json) {
                return $json->missing('statut')
                    ->etc();
            }
            );
        }
        );
});

test('Administrateurs can see the statut attribute', function () {
    Profil::factory()->actif()->create();

    Sanctum::actingAs(
        Administrateur::factory()->create(),
        ['*']
    );

    $response = $this->getJson('/api/profils');

    // The statut should be present in the Json response.
    $response
        ->assertJson(function (AssertableJson $json) {
            return $json->first(function (AssertableJson $json) {
                return $json->has('statut')
                    ->etc();
            }
            );
        }
        );
});

test('an Administrateur can update profiles', function () {
    Sanctum::actingAs(
        Administrateur::factory()->create(),
        ['*']
    );

    $profil = Profil::factory()->create([
        'nom' => 'Robert',
    ]);

    $updated_profil_data = [
        'nom' => 'Carine',
    ];

    $response = $this->json('PUT', '/api/profil/'.$profil->id, $updated_profil_data);
    $response->assertJsonFragment(['nom' => 'Carine']);
});

test('an unauthenticated user cannot update profiles', function () {
    $profil = Profil::factory()->create([
        'nom' => 'Robert',
    ]);

    $updated_profil_data = [
        'nom' => 'Carine',
    ];

    $this->json('PUT', '/api/profil/'.$profil->id, $updated_profil_data)->assertStatus(401);
});

test('an Administrateur can delete profiles', function () {
    $profil = Profil::factory()->create();
    $this->assertModelExists($profil);

    Sanctum::actingAs(
        Administrateur::factory()->create(),
        ['*']
    );

    $this->json('DELETE', '/api/profil/'.$profil->id);
    $this->assertModelMissing($profil);
});

test('an unauthenticated user cannot delete profiles', function () {
    $profil = Profil::factory()->create();

    $this->json('DELETE', '/api/profil/'.$profil->id)->assertStatus(401);
    $this->assertModelExists($profil);
});
