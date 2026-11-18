@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-lg mx-auto" style="max-width: 600px;">
        <div class="card-header bg-white border-0 py-4">
            <h2 class="mb-0 text-center fw-bold text-success">
                <i class="bi bi-plus-circle me-2"></i>Nouvelle Tâche
            </h2>
        </div>
        <div class="card-body px-5 py-4">
            <form method="POST" action="{{ route('chef.taches.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="titre" class="form-label fw-semibold text-gradient-green">Titre</label>
                    <input type="text" class="form-control form-control-lg input-gradient-green" id="titre" name="titre" required maxlength="100" value="{{ old('titre') }}">
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold text-gradient-green">Description</label>
                    <textarea class="form-control input-gradient-green" id="description" name="description" rows="4" maxlength="500">{{ old('description') }}</textarea>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="date_debut" class="form-label fw-semibold text-gradient-green">Date de début</label>
                        <input type="date" class="form-control input-gradient-green" id="date_debut" name="date_debut" required value="{{ old('date_debut') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="date_fin" class="form-label fw-semibold text-gradient-green">Date de fin</label>
                        <input type="date" class="form-control input-gradient-green" id="date_fin" name="date_fin" required value="{{ old('date_fin') }}">
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="etat" class="form-label fw-semibold text-gradient-green">État</label>
                        <select class="form-select input-gradient-green" id="etat" name="etat" required>
                            <option value="Planifiée" {{ old('etat')=='Planifiée' ? 'selected' : '' }}>Planifiée</option>
                            <option value="En cours" {{ old('etat')=='En cours' ? 'selected' : '' }}>En cours</option>
                            <option value="Terminée" {{ old('etat')=='Terminée' ? 'selected' : '' }}>Terminée</option>
                            <option value="Annulée" {{ old('etat')=='Annulée' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="projet_id" class="form-label fw-semibold text-gradient-green">Projet</label>
                        <select class="form-select input-gradient-green" id="projet_id" name="projet_id" required>
                            <option value="">-- Choisir un projet --</option>
                            @foreach($projets as $projet)
                                <option value="{{ $projet->idPr }}" {{ old('projet_id')==$projet->idPr ? 'selected' : '' }}>{{ $projet->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="assignee_id" class="form-label fw-semibold text-gradient-green">Assignée à</label>
                    <select class="form-select input-gradient-green" id="assignee_id" name="assignee_id">
                        <option value="">-- Non assignée --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assignee_id')==$user->id ? 'selected' : '' }}>{{ $user->prenom }} {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('chef.taches.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-gradient-green px-4">
                        <i class="bi bi-save me-2"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .text-gradient-green {
        background: linear-gradient(90deg, #16a34a, #22d3ee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }
    .input-gradient-green {
        background: linear-gradient(90deg, #e0ffe8 0%, #e0f7fa 100%);
        border: 1px solid #34d399;
        color: #065f46;
    }
    .input-gradient-green:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.15);
    }
    .btn-gradient-green {
        background: linear-gradient(90deg, #16a34a, #22d3ee);
        color: #fff;
        border: none;
        transition: background 0.3s;
    }
    .btn-gradient-green:hover {
        background: linear-gradient(90deg, #22d3ee, #16a34a);
        color: #fff;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s;
    }
    textarea.form-control {
        min-height: 120px;
    }
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
</style>
@endpush
@endsection
