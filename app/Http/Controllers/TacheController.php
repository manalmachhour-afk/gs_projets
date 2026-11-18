<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\Projet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TacheController extends Controller
{
    public function index()
    {
        // Afficher toutes les tâches à tous les chefs de projet
        $taches = Tache::with(['projet', 'assignee'])->get();
        return view('chef.taches.index', compact('taches'));
    }

    public function create()
    {
        // Afficher tous les projets pour le chef de projet (pas seulement ceux dont il est responsable)
        $projets = Projet::all();
        $users = User::all();
        return view('chef.taches.create', compact('projets', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'etat' => 'required|in:Planifiée,En cours,Terminée,Annulée',
            'projet_id' => 'required|exists:projets,idPr',
            'assignee_id' => 'nullable|exists:users,id',
        ]);
        Tache::create($request->all());
        return redirect()->route('chef.taches.index')->with('success', 'Tâche créée avec succès.');
    }

    public function collaborateurIndex()
    {
        $user = Auth::user();
        $taches = Tache::where('assignee_id', $user->id)->with('projet')->get();
        return view('collaborateur.taches.index', compact('taches'));
    }

    public function edit($id)
    {
        $tache = Tache::findOrFail($id);
        $projets = \App\Models\Projet::all(); // Correction : charger TOUS les projets
        $users = \App\Models\User::all();
        return view('chef.taches.edit', compact('tache', 'projets', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'etat' => 'required|in:Planifiée,En cours,Terminée,Annulée',
            'projet_id' => 'required|exists:projets,idPr',
            'assignee_id' => 'nullable|exists:users,id',
        ]);
        $tache = Tache::findOrFail($id);
        $tache->update($request->all());
        return redirect()->route('chef.taches.index')->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy($id)
    {
        $tache = Tache::findOrFail($id);
        $tache->delete();
        return redirect()->route('chef.taches.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
