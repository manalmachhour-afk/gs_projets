@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card border-0 shadow-sm rounded-lg mx-auto" style="max-width:520px;width:100%;background:#f6fff9;border:2px solid #b6e7c9;">
        <div class="card-header bg-white border-0 py-4">
            <h2 class="mb-0 text-center fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i>Modifier le projet
            </h2>
        </div>
        <div class="card-body px-4 py-4">
            <form method="POST" action="{{ route('admin.projets.update') }}">
                @csrf
                <input type="hidden" name="idPr" value="{{ $projet->idPr }}">
                <div class="mb-4">
                    <label for="nom" class="form-label fw-semibold text-gradient">Nom du projet</label>
                    <input type="text" class="form-control form-control-lg input-gradient" id="nom" name="nom" required maxlength="50" value="{{ old('nom', $projet->nom) }}">
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold text-gradient">Description</label>
                    <textarea class="form-control input-gradient" id="description" name="description" rows="4" maxlength="500">{{ old('description', $projet->description) }}</textarea>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="date_debut" class="form-label fw-semibold text-gradient">Date de début</label>
                        <input type="date" class="form-control input-gradient" id="date_debut" name="date_debut" required value="{{ old('date_debut', $projet->date_debut) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="date_fin" class="form-label fw-semibold text-gradient">Date de fin</label>
                        <input type="date" class="form-control input-gradient" id="date_fin" name="date_fin" required value="{{ old('date_fin', $projet->date_fin) }}">
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="etat" class="form-label fw-semibold text-gradient">État</label>
                        <select class="form-select input-gradient" id="etat" name="etat" required>
                            <option value="Planifié" {{ old('etat', $projet->etat) == 'Planifié' ? 'selected' : '' }}>Planifié</option>
                            <option value="En cours" {{ old('etat', $projet->etat) == 'En cours' ? 'selected' : '' }}>En cours</option>
                            <option value="Terminé" {{ old('etat', $projet->etat) == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                            <option value="Annulé" {{ old('etat', $projet->etat) == 'Annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="responsable_id" class="form-label fw-semibold text-gradient">Responsable</label>
                        <select class="form-select input-gradient" id="responsable_id" name="responsable_id" required>
                            <option value="">-- Choisir un responsable --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('responsable_id', $projet->responsable_id) == $user->id ? 'selected' : '' }}>{{ $user->prenom }} {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('admin.projets.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .text-gradient {
        background: linear-gradient(90deg, #7c3aed, #4f46e5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }
    .input-gradient {
        background: linear-gradient(90deg, #f3e8ff 0%, #e0e7ff 100%);
        border: 1px solid #a5b4fc;
        color: #312e81;
    }
    .input-gradient:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.15);
    }
    .btn-gradient {
        background: linear-gradient(90deg, #7c3aed, #4f46e5);
        color: #fff;
        border: none;
        transition: background 0.3s;
    }
    .btn-gradient:hover {
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
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
