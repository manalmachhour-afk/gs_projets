```blade
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="task-form-wrapper">

        <div class="task-form-card">

            {{-- En-tête --}}
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h2>Modifier la tâche</h2>
                <p>Modifiez les informations et le suivi de votre tâche</p>
            </div>

            <div class="form-body">

                <form method="POST" action="{{ route('chef.taches.update', $tache->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Informations générales --}}
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="bi bi-info-circle"></i>
                            Informations générales
                        </h5>

                        <div class="mb-4">
                            <label for="titre" class="form-label">
                                Titre de la tâche <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control custom-input @error('titre') is-invalid @enderror"
                                id="titre"
                                name="titre"
                                required
                                maxlength="100"
                                value="{{ old('titre', $tache->titre) }}"
                                placeholder="Entrez le titre de la tâche"
                            >

                            @error('titre')
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
                                placeholder="Décrivez les détails et les objectifs de cette tâche..."
                            >{{ old('description', $tache->description) }}</textarea>

                            <div class="description-footer">
                                <small>Ajoutez des précisions sur le travail à réaliser (facultatif).</small>
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
                                    value="{{ old('date_debut', $tache->date_debut) }}"
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
                                    value="{{ old('date_fin', $tache->date_fin) }}"
                                >

                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Suivi et affectation --}}
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="bi bi-people"></i>
                            Suivi et affectation
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="etat" class="form-label">
                                    État de la tâche <span class="required">*</span>
                                </label>

                                <select
                                    class="form-select custom-input @error('etat') is-invalid @enderror"
                                    id="etat"
                                    name="etat"
                                    required
                                >
                                    <option value="Planifiée" {{ old('etat', $tache->etat) == 'Planifiée' ? 'selected' : '' }}>Planifiée</option>
                                    <option value="En cours" {{ old('etat', $tache->etat) == 'En cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="Terminée" {{ old('etat', $tache->etat) == 'Terminée' ? 'selected' : '' }}>Terminée</option>
                                    <option value="Annulée" {{ old('etat', $tache->etat) == 'Annulée' ? 'selected' : '' }}>Annulée</option>
                                </select>

                                @error('etat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="projet_id" class="form-label">
                                    Projet associé <span class="required">*</span>
                                </label>

                                <select
                                    class="form-select custom-input @error('projet_id') is-invalid @enderror"
                                    id="projet_id"
                                    name="projet_id"
                                    required
                                >
                                    <option value="">-- Choisir un projet --</option>

                                    @foreach($projets as $projet)
                                        <option
                                            value="{{ $projet->idPr }}"
                                            {{ (string)old('projet_id', $tache->projet_id) === (string)$projet->idPr ? 'selected' : '' }}
                                        >
                                            {{ $projet->nom }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('projet_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="assignee_id" class="form-label">
                                    Assignée à
                                </label>

                                <select
                                    class="form-select custom-input @error('assignee_id') is-invalid @enderror"
                                    id="assignee_id"
                                    name="assignee_id"
                                >
                                    <option value="">-- Non assignée --</option>

                                    @foreach($users as $user)
                                        <option
                                            value="{{ $user->id }}"
                                            {{ old('assignee_id', $tache->assignee_id) == $user->id ? 'selected' : '' }}
                                        >
                                            {{ $user->prenom }} {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('assignee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="form-actions">
                        <a href="{{ route('chef.taches.index') }}" class="btn btn-back">
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
    .task-form-wrapper {
        max-width: 850px;
        margin: 0 auto;
    }

    .task-form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    /* En-tête */
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
        background: #e8f5e9;
        color: #2e7d32;
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

    /* Corps du formulaire */
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
        color: #2e7d32;
        font-size: 19px;
    }

    /* Labels et champs */
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
        border-color: #43a047;
        box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.12);
        outline: none;
    }

    /* Description */
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

    /* Boutons */
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
        background: #2e7d32;
        border: 1px solid #2e7d32;
    }

    .btn-submit:hover {
        background: #256b29;
        border-color: #256b29;
        color: #fff;
        transform: translateY(-1px);
    }

    /* Responsive */
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
    // Compteur de caractères
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
