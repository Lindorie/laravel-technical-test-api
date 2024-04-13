<?php

use App\Models\Administrateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    RefreshDatabase::class
);

it('seeds administrateurs', function () {
    $this->assertDatabaseCount(Administrateur::class, 0);

    $this->artisan('db:seed', ['--class' => 'AdministrateurSeeder']);

    $this->assertDatabaseCount(Administrateur::class, 2);
});
