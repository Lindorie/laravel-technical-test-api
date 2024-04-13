<?php

// Necessary to access Laravel testing helpers and database factory stuff
use App\Models\Administrateur;
use App\Models\Commentaire;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(
    RefreshDatabase::class
);

it('seeds comments', function () {
    $this->assertDatabaseCount(Commentaire::class, 0);

    $this->artisan('db:seed', ['--class' => 'CommentaireSeeder']);

    $this->assertDatabaseCount(Commentaire::class, 5);
});

test('Unauthenticated users cannot add comments', function () {
    $profil = Profil::factory()->create();
    $commentaire = [
        'contenu' => 'Lorem ipsum dolor sit amet.',
    ];

    $this->json('POST', '/api/profil/'.$profil->id.'/add-comment', $commentaire)->assertStatus(401);
});

test('an Administrateur can comment on a given Profil', function () {
    $profil = Profil::factory()->create();
    $commentaire = [
        'contenu' => 'Lorem ipsum dolor sit amet.',
    ];

    Sanctum::actingAs(
        Administrateur::factory()->create(),
        ['*']
    );

    $this->json('POST', '/api/profil/'.$profil->id.'/add-comment', $commentaire)->assertStatus(201);
});

test('an Administrateur cannot comment more than once on a given Profil', function () {
    $profil = Profil::factory()->create();
    $commentaire = [
        'contenu' => 'Lorem ipsum dolor sit amet.',
    ];

    Sanctum::actingAs(
        Administrateur::factory()->create(),
        ['*']
    );

    // First time is authorized.
    $this->json('POST', '/api/profil/'.$profil->id.'/add-comment', $commentaire)->assertStatus(201);
    // Cannot comment a second time o the same Profil.
    $this->json('POST', '/api/profil/'.$profil->id.'/add-comment', $commentaire)->assertStatus(403);
});
