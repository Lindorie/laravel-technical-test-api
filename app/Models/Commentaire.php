<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the Administrateur who created the comment.
     */
    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(Administrateur::class);
    }

    /**
     * Get the Profil associated with this comment.
     */
    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }
}
