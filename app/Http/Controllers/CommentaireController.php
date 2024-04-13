<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentaireRequest;
use App\Http\Resources\CommentaireResource;
use App\Models\Commentaire;
use App\Models\Profil;

class CommentaireController extends Controller
{
    public function store(StoreCommentaireRequest $request, Profil $profil)
    {
        // Store Commentaire that passed validation.
        $commentaire = Commentaire::create($request->validated());

        // Return Commentaire resource.
        return response()->json(new CommentaireResource($commentaire), 201);
    }
}
