```blade
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="project-form-wrapper">

        <div class="project-form-card">

            {{-- En-tête --}}
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h2>Modifier le projet</h2>
                <p>Modifiez les informations de votre projet</p>
            </div>

            <div class="form-body">

                <form method="POST" action="{{ route('admin.projets.update') }}">
                    @csrf

                    <input type="hidden" name="idPr" value="{{ $projet->idPr }}">

                    {{-- Informations générales --}}
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="bi bi-info-circle"></i>
                            Informations générales
                        </h5>

                        <div class="mb-4">
                            <label for="nom" class="form-label">
                                Nom du projet <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control custom-input @error('nom') is-invalid @enderror"
                                id="nom"
                                name="nom"
                                maxlength="50"
                                required
                                value="{{ old('nom', $projet->nom) }}"
                                placeholder="Entrez le nom du projet"
                            >

                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea
                                class="form-control description-field @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="5"
                                maxlength="500"
                                placeholder="Décrivez brièvement les objectifs et le contenu du projet..."
                            >{{ old('description', $projet->description) }}</textarea>

                            <div class="description-footer">
                                <small>Présentez les objectifs principaux du projet (facultatif).</small>
                                <small><span id="charCount">0</span> / 500 caractères</small>
                            </div>

                            @error('description')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Planification --}}
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="bi bi-calendar-week"></i>
                            Planification
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="date_debut" class="form-label">
                                    Date de début <span class="required">*</span>
                                </label>

                                <input
                                    type="date"
                                    class="form-control custom-input @error('date_debut') is-invalid @enderror"
                                    id="date_debut"
                                    name="date_debut"
                                    required
                                    value="{{ old('date_debut', $projet->date_debut) }}"
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
                                    class="form-control custom-input @error('date_fin') is-invalid @enderror"
                                    id="date_fin"
                                    name="date_fin"
                                    required
                                    value="{{ old('date_fin', $projet->date_fin) }}"
                                >

                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Responsabilité et suivi --}}
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="bi bi-people"></i>
                            Responsabilité et suivi
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="etat" class="form-label">
                                    État du projet <span class="required">*</span>
                                </label>

                                <select
                                    class="form-select custom-input @error('etat') is-invalid @enderror"
                                    id="etat"
                                    name="etat"
                                    required
                                >
                                    <option value="Planifié" {{ old('etat', $projet->etat) == 'Planifié' ? 'selected' : '' }}>Planifié</option>
                                    <option value="En cours" {{ old('etat', $projet->etat) == 'En cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="Terminé" {{ old('etat', $projet->etat) == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                                    <option value="Annulé" {{ old('etat', $projet->etat) == 'Annulé' ? 'selected' : '' }}>Annulé</option>
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
                                    class="form-select custom-input @error('responsable_id') is-invalid @enderror"
                                    id="responsable_id"
                                    name="responsable_id"
                                    required
                                >
                                    <option value="">-- Choisir un responsable --</option>

                                    @foreach($users as $user)
                                        <option
                                            value="{{ $user->id }}"
                                            {{ old('responsable_id', $projet->responsable_id) == $user->id ? 'selected' : '' }}
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
                    </div>

                    {{-- Boutons --}}
                    <div class="form-actions">
                        <a href="{{ route('admin.projets.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left me-2"></i>
                            Retour
                        </a>

                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-check-circle me-2"></i>
                            Enregistrer les modifications
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .project-form-wrapper {
        max-width: 850px;
        margin: 0 auto;
    }

    .project-form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .form-header {
        text-align: center;
        padding: 30px 25px 25px;
        border-bottom: 1px solid #eef0f4;
    }

    .form-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        border-radius: 14px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 25px;
    }

    .form-header h2 {
        color: #1e293b;
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .form-header p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }

    .form-body {
        padding: 30px;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #334155;
        font-size: 16px;
        font-weight: 700;
        padding-bottom: 12px;
        margin-bottom: 20px;
        border-bottom: 1px solid #eef0f4;
    }

    .section-title i {
        color: #4f46e5;
        font-size: 19px;
    }

    .form-label {
        display: block;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .required {
        color: #dc2626;
    }

    .custom-input {
        width: 100%;
        min-height: 46px;
        padding: 11px 14px;
        border: 1px solid #dbe1ea;
        border-radius: 9px;
        background-color: #fff;
        color: #1e293b;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .custom-input:focus,
    .description-field:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        outline: none;
    }

    .description-field {
        display: block;
        width: 100%;
        min-height: 160px;
        height: 160px;
        padding: 16px 18px;
        border: 1px solid #dbe1ea;
        border-radius: 10px;
        background: #fff;
        color: #1e293b;
        font-size: 14px;
        line-height: 1.7;
        resize: vertical;
        overflow-y: auto;
        white-space: pre-wrap;
        transition: all 0.2s ease;
    }

    .description-field::placeholder {
        color: #9ca3af;
    }

    .description-footer {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 8px;
        color: #64748b;
        font-size: 12px;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding-top: 22px;
        border-top: 1px solid #eef0f4;
    }

    .btn-back,
    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 10px 20px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-back {
        color: #475569;
        background: #fff;
        border: 1px solid #cbd5e1;
    }

    .btn-back:hover {
        background: #f8fafc;
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
    }

    @media (max-width: 576px) {
        .form-body {
            padding: 20px 16px;
        }

        .form-header {
            padding: 25px 15px;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .form-actions .btn {
            width: 100%;
        }

        .description-footer {
            flex-direction: column;
            gap: 4px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Compteur de caractères de la description
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        charCount.textContent = description.value.length;
    }

    updateCharCount();
    description.addEventListener('input', updateCharCount);

    // Vérification des dates
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');

    function verifierDates() {
        dateFin.min = dateDebut.value;

        if (dateDebut.value && dateFin.value && dateFin.value < dateDebut.value) {
            dateFin.setCustomValidity(
                'La date de fin doit être postérieure ou égale à la date de début.'
            );
        } else {
            dateFin.setCustomValidity('');
        }
    }

    dateDebut.addEventListener('change', verifierDates);
    dateFin.addEventListener('change', verifierDates);

    verifierDates();
</script>
@endpush

@endsection
```
