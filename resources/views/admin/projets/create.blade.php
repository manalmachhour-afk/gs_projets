@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-lg mx-auto" style="max-width: 600px;">
        <div class="card-header bg-white border-0 py-4">
            <h2 class="mb-0 text-center fw-bold text-primary">
                <i class="bi bi-plus-circle me-2"></i>Nouveau Projet
            </h2>
        </div>
        <div class="card-body px-5 py-4">
            <form method="POST" action="{{ route('admin.projets.store') }}">
                @csrf
                <!-- Champs groupés avec espacement amélioré -->
                <div class="mb-4">
                    <label for="nom" class="form-label fw-semibold text-gradient">Nom du projet</label>
                    <input type="text" class="form-control form-control-lg input-gradient" id="nom" name="nom" required maxlength="50" value="{{ old('nom') }}">
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="date_debut" class="form-label fw-semibold text-gradient">Date de début</label>
                        <input type="date" class="form-control input-gradient" id="date_debut" name="date_debut" required value="{{ old('date_debut') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="date_fin" class="form-label fw-semibold text-gradient">Date de fin</label>
                        <input type="date" class="form-control input-gradient" id="date_fin" name="date_fin" required value="{{ old('date_fin') }}">
                    </div>
                </div>
                <!-- Sélecteurs avec icônes -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="etat" class="form-label fw-semibold text-gradient">État</label>
                        <select class="form-select input-gradient" id="etat" name="etat" required>
                            <option value="Planifié" data-icon="bi-calendar-check" {{ old('etat')=='Planifié' ? 'selected' : '' }}>Planifié</option>
                            <option value="En cours" data-icon="bi-arrow-repeat" {{ old('etat')=='En cours' ? 'selected' : '' }}>En cours</option>
                            <option value="Terminé" data-icon="bi-check-circle" {{ old('etat')=='Terminé' ? 'selected' : '' }}>Terminé</option>
                            <option value="Annulé" data-icon="bi-x-circle" {{ old('etat')=='Annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="responsable_id" class="form-label fw-semibold text-gradient">Responsable</label>
                        <select class="form-select input-gradient" id="responsable_id" name="responsable_id" required>
                            <option value="">-- Sélectionnez --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('responsable_id')==$user->id ? 'selected' : '' }}>{{ $user->prenom }} {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Zone de texte améliorée -->
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold text-gradient">Description</label>
                    <textarea class="form-control input-gradient" id="description" name="description" rows="4" maxlength="500">{{ old('description') }}</textarea>
                </div>
                <!-- Boutons avec espacement optimal -->
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
    .header-section {
        background: linear-gradient(135deg, #475569, #334155) !important;
        color: white !important;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
    }
    .header-section::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
        z-index: 0;
    }
    .header-section > .container, .header-section * {
        position: relative;
        z-index: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Compteur de caractères pour la description
    document.addEventListener('DOMContentLoaded', function() {
        var desc = document.getElementById('description');
        var count = document.getElementById('charCount');
        function updateCount() {
            count.textContent = desc.value.length + '/500';
        }
        desc.addEventListener('input', updateCount);
        updateCount();
    });
</script>
@endpush
@endsection
