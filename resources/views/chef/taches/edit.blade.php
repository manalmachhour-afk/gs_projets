@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card border-0 shadow-sm rounded-lg mx-auto" style="max-width:700px;width:100%;background:#f6fff9;border:2px solid #b6e7c9;">
        <div class="card-header bg-white border-0 py-3">
            <h2 class="mb-0 text-center fw-bold" style="color: #2e7d32;">
                <i class="bi bi-pencil-square me-2"></i>Modifier la tâche
            </h2>
        </div>
        <div class="card-body px-5 py-4">
            <form method="POST" action="{{ route('chef.taches.update', $tache->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titre" class="form-label fw-bold" style="color: #388e3c;">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required value="{{ old('titre', $tache->titre) }}" style="background: #e8f5e9;">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold" style="color: #388e3c;">Description</label>
                    <textarea class="form-control" id="description" name="description" style="background: #e8f5e9;">{{ old('description', $tache->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="date_debut" class="form-label fw-bold" style="color: #388e3c;">Date de début</label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" required value="{{ old('date_debut', $tache->date_debut) }}" style="background: #e8f5e9;">
                </div>
                <div class="mb-3">
                    <label for="date_fin" class="form-label fw-bold" style="color: #388e3c;">Date de fin</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" required value="{{ old('date_fin', $tache->date_fin) }}" style="background: #e8f5e9;">
                </div>
                <div class="mb-3">
                    <label for="etat" class="form-label fw-bold" style="color: #388e3c;">État</label>
                    <select class="form-control" id="etat" name="etat" required style="background: #e8f5e9;">
                        <option value="Planifiée" {{ old('etat', $tache->etat) == 'Planifiée' ? 'selected' : '' }}>Planifiée</option>
                        <option value="En cours" {{ old('etat', $tache->etat) == 'En cours' ? 'selected' : '' }}>En cours</option>
                        <option value="Terminée" {{ old('etat', $tache->etat) == 'Terminée' ? 'selected' : '' }}>Terminée</option>
                        <option value="Annulée" {{ old('etat', $tache->etat) == 'Annulée' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="projet_id" class="form-label fw-bold" style="color: #388e3c;">Projet</label>
                    <select class="form-control" id="projet_id" name="projet_id" required style="background: #e8f5e9;">
                        <option value="">-- Choisir un projet --</option>
                        @foreach($projets as $projet)
                            <option value="{{ $projet->idPr }}" {{ (string)old('projet_id', $tache->projet_id) === (string)$projet->idPr ? 'selected' : '' }}>{{ $projet->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="assignee_id" class="form-label fw-bold" style="color: #388e3c;">Assignée à</label>
                    <select class="form-control" id="assignee_id" name="assignee_id" style="background: #e8f5e9;">
                        <option value="">-- Non assignée --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assignee_id', $tache->assignee_id) == $user->id ? 'selected' : '' }}>{{ $user->prenom }} {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('chef.taches.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
