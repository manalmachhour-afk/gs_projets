<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    public function index()
    {
        $projets = Projet::with('responsable')->get();
        return view('admin.projets.index', compact('projets'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.projets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'etat' => 'required|in:Planifié,En cours,Terminé,Annulé',
            'responsable_id' => 'required|exists:users,id',
        ]);
        Projet::create($request->all());
        return redirect()->route('admin.projets.index')->with('success', 'Projet créé avec succès.');
    }

    public function edit($id)
    {
        $projet = Projet::findOrFail($id);
        $users = User::all();
        return view('admin.projets.edit', compact('projet', 'users'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'idPr' => 'required|exists:projets,idPr',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'etat' => 'required|in:Planifié,En cours,Terminé,Annulé',
            'responsable_id' => 'required|exists:users,id',
        ]);
        $projet = Projet::findOrFail($request->idPr);
        $projet->update($request->except(['idPr', '_token']));
        return redirect()->route('admin.projets.index')->with('success', 'Projet modifié avec succès.');
    }

    public function destroy(Request $request)
    {
        $projet = Projet::findOrFail($request->idPr ?? $request->id);
        $projet->delete();
        return redirect()->route('admin.projets.index')->with('success', 'Projet supprimé avec succès.');
    }

    /**
     * Affiche le formulaire d'assignation des membres à un projet
     */
    public function showAssignMembers()
    {
        $projets = \App\Models\Projet::all();
        $users = \App\Models\User::all();
        return view('admin.projets.assign', compact('projets', 'users'));
    }

    /**
     * Traite l'assignation des membres à un projet
     */
    public function assignMembers(Request $request)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,idPr',
            'membres' => 'required|array',
            'membres.*' => 'exists:users,id',
        ]);
        $projet = \App\Models\Projet::findOrFail($request->projet_id);
        // On suppose qu'il existe une relation many-to-many 'membres' sur Projet
        $projet->membres()->sync($request->membres);
        return redirect()->route('admin.projets.index')->with('success', 'Membres assignés avec succès.');
    }
}
