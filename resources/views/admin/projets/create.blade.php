
@extends('layouts.app')

@section('content')

<div class="container py-5 project-form-page">

    <div class="project-form-card">

        {{-- En-tête --}}
        <div class="form-header">
            <div class="header-icon">
                <i class="bi bi-folder-plus"></i>
            </div>

            <div>
                <h2>Créer un nouveau projet</h2>
                <p>Renseignez les informations nécessaires pour créer votre projet.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.projets.store') }}">
            @csrf

            <div class="form-content">

                {{-- Informations générales --}}
                <div class="section-title">
                    <i class="bi bi-info-circle"></i>
                    <span>Informations générales</span>
                </div>

                <div class="mb-4">
                    <label for="nom" class="form-label">
                        Nom du projet <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        class="form-control @error('nom') is-invalid @enderror"
                        id="nom"
                        name="nom"
                        placeholder="Ex : Développement d'une application web"
                        required
                        maxlength="50"
                        value="{{ old('nom') }}"
                    >

                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-4 description-group">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        class="form-control description-field @error('description') is-invalid @enderror"
                        id="description"
                        name="description"
                        rows="5"
                        maxlength="500"
                        placeholder="Décrivez les objectifs, les fonctionnalités et le contenu de votre projet..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="description-footer">
                        <small>Présentez brièvement les objectifs du projet.</small>

                        <span class="character-count">
                            <span id="charCount">0</span> / 500 caractères
                        </span>
                    </div>
                </div>

                <div class="form-divider"></div>

                {{-- Planification --}}
                <div class="section-title">
                    <i class="bi bi-calendar3"></i>
                    <span>Planification du projet</span>
                </div>

                <div class="row g-3 mb-4">

                    <div class="col-md-6">
                        <label for="date_debut" class="form-label">
                            Date de début <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            class="form-control @error('date_debut') is-invalid @enderror"
                            id="date_debut"
                            name="date_debut"
                            required
                            value="{{ old('date_debut') }}"
                        >

                        @error('date_debut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="date_fin" class="form-label">
                            Date de fin <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            class="form-control @error('date_fin') is-invalid @enderror"
                            id="date_fin"
                            name="date_fin"
                            required
                            value="{{ old('date_fin') }}"
                        >

                        @error('date_fin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-divider"></div>

                {{-- Responsabilité --}}
                <div class="section-title">
                    <i class="bi bi-people"></i>
                    <span>Responsabilité et suivi</span>
                </div>

                <div class="row g-3 mb-4">

                    <div class="col-md-6">
                        <label for="etat" class="form-label">
                            État du projet <span class="required">*</span>
                        </label>

                        <select
                            class="form-select @error('etat') is-invalid @enderror"
                            id="etat"
                            name="etat"
                            required
                        >
                            <option value="">Sélectionner un état</option>

                            <option value="Planifié" {{ old('etat') == 'Planifié' ? 'selected' : '' }}>
                                Planifié
                            </option>

                            <option value="En cours" {{ old('etat') == 'En cours' ? 'selected' : '' }}>
                                En cours
                            </option>

                            <option value="Terminé" {{ old('etat') == 'Terminé' ? 'selected' : '' }}>
                                Terminé
                            </option>

                            <option value="Annulé" {{ old('etat') == 'Annulé' ? 'selected' : '' }}>
                                Annulé
                            </option>
                        </select>

                        @error('etat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="responsable_id" class="form-label">
                            Responsable <span class="required">*</span>
                        </label>

                        <select
                            class="form-select @error('responsable_id') is-invalid @enderror"
                            id="responsable_id"
                            name="responsable_id"
                            required
                        >
                            <option value="">Choisir un responsable</option>

                            @foreach($users as $user)
                                <option
                                    value="{{ $user->id }}"
                                    {{ old('responsable_id') == $user->id ? 'selected' : '' }}
                                >
                                    {{ $user->prenom }} {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <p class="required-note">
                    <span class="required">*</span> Champs obligatoires
                </p>

            </div>

            {{-- Pied du formulaire --}}
            <div class="form-footer">

                <a href="{{ route('admin.projets.index') }}" class="btn btn-cancel">
                    <i class="bi bi-arrow-left me-2"></i>
                    Retour
                </a>

                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check2-circle me-2"></i>
                    Créer le projet
                </button>

            </div>

        </form>

    </div>

</div>

@push('styles')
<style>

    .project-form-page {
        max-width: 950px;
    }

    .project-form-card {
        background: #fff;
        border: 1px solid #e9edf3;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    /* En-tête */

    .form-header {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 30px 35px;
        background: #fff;
        border-bottom: 1px solid #edf0f5;
    }

    .header-icon {
        width: 54px;
        height: 54px;
        min-width: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: #4f46e5;
        border-radius: 13px;
        font-size: 25px;
    }

    .form-header h2 {
        font-size: 23px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .form-header p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    /* Contenu */

    .form-content {
        padding: 32px 35px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 22px;
    }

    .section-title i {
        color: #4f46e5;
        font-size: 19px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 9px;
    }

    .required {
        color: #e11d48;
    }

    /* Champs classiques */

    .project-form-card .form-control,
    .project-form-card .form-select {
        min-height: 46px;
        width: 100%;
        border: 1px solid #dce2eb;
        border-radius: 9px;
        background-color: #fff;
        color: #334155;
        font-size: 14px;
        padding: 11px 14px;
        transition: all 0.2s ease;
        box-shadow: none;
    }

    .project-form-card .form-control::placeholder {
        color: #a0aaba;
    }

    .project-form-card .form-control:focus,
    .project-form-card .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.10);
        outline: none;
    }

    /* Zone de description */

    .description-group {
        width: 100%;
    }

    .project-form-card .description-field {
        display: block;
        width: 100%;
        min-height: 160px;
        height: 160px;
        padding: 16px 18px;
        line-height: 1.7;
        font-size: 14px;
        color: #334155;
        background-color: #fff;
        border: 1px solid #dce2eb;
        border-radius: 10px;
        resize: vertical;
        white-space: pre-wrap;
        overflow-y: auto;
    }

    .project-form-card .description-field::placeholder {
        color: #a0aaba;
        opacity: 1;
        line-height: 1.7;
    }

    .project-form-card .description-field:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.10);
    }

    .description-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .description-footer small {
        color: #94a3b8;
        font-size: 12px;
    }

    .character-count {
        color: #64748b;
        font-size: 12px;
        white-space: nowrap;
    }

    .form-divider {
        height: 1px;
        background: #edf0f5;
        margin: 30px 0;
    }

    .required-note {
        font-size: 12px;
        color: #94a3b8;
        margin: 0;
    }

    /* Pied du formulaire */

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 22px 35px;
        background: #f8fafc;
        border-top: 1px solid #edf0f5;
    }

    .btn-cancel,
    .btn-submit {
        padding: 11px 22px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-cancel {
        color: #475569;
        background: #fff;
        border: 1px solid #dce2eb;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .btn-submit {
        color: #fff;
        background: #4f46e5;
        border: 1px solid #4f46e5;
    }

    .btn-submit:hover {
        background: #4338ca;
        border-color: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
    }

    /* Responsive */

    @media (max-width: 576px) {

        .form-header,
        .form-content {
            padding: 22px 18px;
        }

        .form-footer {
            padding: 18px;
            gap: 10px;
        }

        .form-header h2 {
            font-size: 19px;
        }

        .btn-cancel,
        .btn-submit {
            padding: 10px 13px;
            font-size: 13px;
        }

        .description-footer {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Compteur de caractères
        const description = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        function updateCount() {
            charCount.textContent = description.value.length;
        }

        description.addEventListener('input', updateCount);
        updateCount();

        // Vérification des dates
        const dateDebut = document.getElementById('date_debut');
        const dateFin = document.getElementById('date_fin');

        function updateDateMin() {
            dateFin.min = dateDebut.value;

            if (dateDebut.value && dateFin.value && dateFin.value < dateDebut.value) {
                dateFin.setCustomValidity(
                    'La date de fin doit être postérieure ou égale à la date de début.'
                );
            } else {
                dateFin.setCustomValidity('');
            }
        }

        dateDebut.addEventListener('change', updateDateMin);
        dateFin.addEventListener('change', updateDateMin);

        updateDateMin();

    });
</script>
@endpush

@endsection
