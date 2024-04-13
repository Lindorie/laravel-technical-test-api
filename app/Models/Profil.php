<?php

namespace App\Models;

use App\Enums\ProfilStatutEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profil extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => ProfilStatutEnum::class,
        ];
    }

    /**
     * Get the Administrateur who created the profile.
     */
    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(Administrateur::class);
    }

    /**
     * Get the Commentaires of this Profil.
     */
    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }
}
