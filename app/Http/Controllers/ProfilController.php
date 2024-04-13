<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfilRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\Http\Resources\ProfilResource;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        // Get all Profils with "actif" status.
        $profils = Profil::where('statut', 'actif')->get();

        // Return successful 200 response with the resource collection.
        return response()->json(ProfilResource::collection($profils));
    }

    public function store(StoreProfilRequest $request)
    {
        // Store image file after validation.
        $validated_data = $request->validated();
        $validated_data['image'] = $request->file('image')->store('image');

        // Create Profil.
        $profil = Profil::create($validated_data);

        // Return Profil resource.
        return response()->json(new ProfilResource($profil), 201);
    }

    public function update(UpdateProfilRequest $request, Profil $profil)
    {
        // Update Profil data when validated.
        $profil->update($request->validated());

        // Return successful 200 response with Profil resource.
        return response()->json(new ProfilResource($profil));
    }

    public function destroy(Profil $profil)
    {
        // Delete given Profil.
        $profil->delete();

        return response()->json(204);
    }
}
