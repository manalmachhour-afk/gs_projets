@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    .task-card {
        --primary: #6d28d9; --primary-2: #4f46e5; --primary-soft: #f5f3ff; --border: #e5e7eb;
        max-width: 640px; background: #fff; border-radius: 18px; overflow: hidden;
        box-shadow: 0 18px 40px -16px rgba(79,70,229,.3);
    }
    .task-header {
        display: flex; align-items: center; gap: 14px; color: #fff;
        padding: 20px 28px; background: linear-gradient(135deg, var(--primary), var(--primary-2));
    }
    .task-header h2 { margin: 0; font-size: 1.2rem; font-weight: 700; }
    .task-header p  { margin: 0; font-size: .8rem; opacity: .8; }
    .task-header-icon {
        width: 42px; height: 42px; flex-shrink: 0; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        background: rgba(255,255,255,.18);
    }
    .task-body { padding: 24px 28px; }

    .t-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: 5px; display: block; }
    .req { color: #dc2626; }
    .counter { color: #9ca3af; font-size: .72rem; }
    .t-error { color: #dc2626; font-size: .75rem; margin-top: 4px; }

    .t-input { position: relative; }
    .t-input > i {
        position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
        color: #9ca3af; pointer-events: none; z-index: 5; font-size: .95rem;
    }
    .task-card .form-control, .task-card .form-select {
        border: 1.5px solid var(--border); border-radius: 10px; background-color: #fafafa;
        font-size: .9rem; padding: 9px 12px; transition: all .15s;
    }
    .t-input .form-control, .t-input .form-select { padding-left: 38px; }
    .task-card .form-control:focus, .task-card .form-select:focus {
        background-color: #fff; border-color: var(--primary);
        box-shadow: 0 0 0 .22rem rgba(109,40,217,.12);
    }
    .t-input:focus-within > i { color: var(--primary); }
    .t-textarea { resize: vertical; min-height: 84px; }

    .duration { font-size: .78rem; color: var(--primary); min-height: 18px; padding-left: 2px; }
    .duration.invalid { color: #dc2626; }

    .etat-group { display: flex; flex-wrap: wrap; gap: 8px; }
    .etat-group > div { position: relative; }
    .etat-group input { position: absolute; opacity: 0; pointer-events: none; }
    .etat-pill {
        display: inline-flex; align-items: center; gap: 7px; cursor: pointer; margin: 0;
        padding: 7px 14px; border-radius: 50px; font-size: .82rem; font-weight: 600;
        background: #fff; color: #6b7280; border: 1.5px solid var(--border); transition: all .15s;
    }
    .etat-pill::before { content: ""; width: 8px; height: 8px; border-radius: 50%; background: currentColor; opacity: .6; }
    .etat-pill:hover { border-color: #c4b5fd; }
    .etat-group input:focus-visible + .etat-pill { box-shadow: 0 0 0 .2rem rgba(109,40,217,.2); }
    .etat-group input:checked + .etat-planifie { background: #e0f2fe; color: #0369a1; border-color: #7dd3fc; }
    .etat-group input:checked + .etat-en-cours { background: #ffedd5; color: #c2410c; border-color: #fdba74; }
    .etat-group input:checked + .etat-termine  { background: #dcfce7; color: #15803d; border-color: #86efac; }
    .etat-group input:checked + .etat-annule   { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }
    .etat-group input:checked + .etat-pill::before { opacity: 1; }

    .btn-gradient {
        background: linear-gradient(135deg, var(--primary), var(--primary-2)); color: #fff;
        border: none; border-radius: 10px; font-weight: 600; padding: 9px 20px;
        box-shadow: 0 6px 14px -4px rgba(79,70,229,.45); transition: transform .15s, box-shadow .15s;
    }
    .btn-gradient:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 10px 18px -4px rgba(79,70,229,.55); }
    .btn-gradient:disabled { opacity: .7; transform: none; }
    .btn-light-t { border: 1.5px solid var(--border); border-radius: 10px; background: #fff; color: #4b5563; padding: 9px 18px; }
    .btn-light-t:hover { background: #f9fafb; color: #111827; }

    @media (max-width: 576px) { .task-body { padding: 20px; } .task-header { padding: 18px 20px; } }
</style>

<div class="container py-4">
    <div class="task-card mx-auto">

        <div class="task-header">
            <span class="task-header-icon"><i class="bi bi-plus-lg"></i></span>
            <div>
                <h2>Nouvelle tâche</h2>
                <p>Renseignez les informations de la tâche à créer</p>
            </div>
        </div>

        <form method="POST" action="{{ route('chef.taches.store') }}" id="taskForm" class="task-body">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 py-2 small">
                    <i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les champs en erreur.
                </div>
            @endif

            {{-- Titre --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label for="titre" class="t-label">Titre <span class="req">*</span></label>
                    <small class="counter" id="titreCount">0/100</small>
                </div>
                <div class="t-input">
                    <i class="bi bi-card-heading"></i>
                    <input type="text" id="titre" name="titre" required maxlength="100"
                           placeholder="Ex : Maquette de la page d'accueil"
                           value="{{ old('titre') }}"
                           class="form-control @error('titre') is-invalid @enderror">
                </div>
                @error('titre') <div class="t-error">{{ $message }}</div> @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label for="description" class="t-label">Description</label>
                    <small class="counter" id="descCount">0/500</small>
                </div>
                <textarea id="description" name="description" rows="3" maxlength="500"
                          placeholder="Décrivez brièvement la tâche…"
                          class="form-control t-textarea @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description') <div class="t-error">{{ $message }}</div> @enderror
            </div>

            {{-- Dates --}}
            <div class="row g-3 mb-1">
                <div class="col-sm-6">
                    <label for="date_debut" class="t-label">Date de début <span class="req">*</span></label>
                    <div class="t-input">
                        <i class="bi bi-calendar-event"></i>
                        <input type="date" id="date_debut" name="date_debut" required
                               value="{{ old('date_debut') }}"
                               class="form-control @error('date_debut') is-invalid @enderror">
                    </div>
                    @error('date_debut') <div class="t-error">{{ $message }}</div> @enderror
                </div>
                <div class="col-sm-6">
                    <label for="date_fin" class="t-label">Date de fin <span class="req">*</span></label>
                    <div class="t-input">
                        <i class="bi bi-calendar-check"></i>
                        <input type="date" id="date_fin" name="date_fin" required
                               value="{{ old('date_fin') }}"
                               class="form-control @error('date_fin') is-invalid @enderror">
                    </div>
                    @error('date_fin') <div class="t-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="duration mb-3" id="duration"></div>

            {{-- Projet + assignation --}}
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label for="projet_id" class="t-label">Projet <span class="req">*</span></label>
                    <div class="t-input">
                        <i class="bi bi-folder2-open"></i>
                        <select id="projet_id" name="projet_id" required
                                class="form-select @error('projet_id') is-invalid @enderror">
                            <option value="">Choisir un projet…</option>
                            @foreach($projets as $projet)
                                <option value="{{ $projet->idPr }}" {{ old('projet_id') == $projet->idPr ? 'selected' : '' }}>
                                    {{ $projet->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('projet_id') <div class="t-error">{{ $message }}</div> @enderror
                </div>
                <div class="col-sm-6">
                    <label for="assignee_id" class="t-label">Assignée à</label>
                    <div class="t-input">
                        <i class="bi bi-person"></i>
                        <select id="assignee_id" name="assignee_id"
                                class="form-select @error('assignee_id') is-invalid @enderror">
                            <option value="">Non assignée</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assignee_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->prenom }} {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('assignee_id') <div class="t-error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- État --}}
            @php
                $etats = ['Planifiée' => 'planifie', 'En cours' => 'en-cours', 'Terminée' => 'termine', 'Annulée' => 'annule'];
                $etatActuel = old('etat', 'Planifiée');
            @endphp
            <div class="mb-4">
                <label class="t-label">État <span class="req">*</span></label>
                <div class="etat-group">
                    @foreach($etats as $etat => $slug)
                        <div>
                            <input type="radio" name="etat" id="etat_{{ $slug }}" value="{{ $etat }}"
                                   {{ $etatActuel === $etat ? 'checked' : '' }} required>
                            <label for="etat_{{ $slug }}" class="etat-pill etat-{{ $slug }}">{{ $etat }}</label>
                        </div>
                    @endforeach
                </div>
                @error('etat') <div class="t-error">{{ $message }}</div> @enderror
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="{{ route('chef.taches.index') }}" class="btn btn-light-t">
                    <i class="bi bi-arrow-left me-1"></i>Retour
                </a>
                <button type="submit" class="btn btn-gradient" id="submitBtn">
                    <i class="bi bi-check2-circle me-1"></i>Créer la tâche
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var titre = document.getElementById('titre');
    var desc  = document.getElementById('description');
    var debut = document.getElementById('date_debut');
    var fin   = document.getElementById('date_fin');
    var info  = document.getElementById('duration');
    var form  = document.getElementById('taskForm');

    function count(el, out) {
        function update() { out.textContent = el.value.length + '/' + el.maxLength; }
        el.addEventListener('input', update);
        update();
    }
    count(titre, document.getElementById('titreCount'));
    count(desc,  document.getElementById('descCount'));

    function checkDates() {
        if (debut.value) fin.min = debut.value;
        info.className = 'duration';
        if (debut.value && fin.value) {
            var days = Math.round((new Date(fin.value) - new Date(debut.value)) / 86400000) + 1;
            if (days < 1) {
                info.classList.add('invalid');
                info.textContent = 'La date de fin doit être après la date de début.';
                fin.setCustomValidity('Date de fin invalide');
            } else {
                info.textContent = 'Durée : ' + days + ' jour' + (days > 1 ? 's' : '');
                fin.setCustomValidity('');
            }
        } else {
            info.textContent = '';
            fin.setCustomValidity('');
        }
    }
    debut.addEventListener('change', checkDates);
    fin.addEventListener('change', checkDates);
    checkDates();

    form.addEventListener('submit', function () {
        if (form.checkValidity()) {
            var btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Création…';
        }
    });
});
</script>
@endsection
