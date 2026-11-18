@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="assign-card card border-0 mx-auto">

        {{-- En-tête --}}
        <div class="assign-header text-center text-white">
            <div class="assign-icon mb-3">
                <i class="bi bi-people-fill"></i>
            </div>
            <h2 class="fw-bold mb-1">Assigner des membres</h2>
            <p class="mb-0 opacity-75">Choisissez un projet puis sélectionnez les membres de l'équipe</p>
        </div>

        <div class="card-body px-4 px-md-5 py-4">

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.projets.assignMembers') }}">
                @csrf

                {{-- Étape 1 : projet --}}
                <div class="mb-4">
                    <label for="projet_id" class="step-label">
                        <span class="step-number">1</span> Projet
                    </label>
                    <div class="input-icon">
                        <i class="bi bi-folder2-open"></i>
                        <select class="form-select form-select-lg" id="projet_id" name="projet_id" required>
                            <option value="">Sélectionnez un projet…</option>
                            @foreach($projets as $projet)
                                <option value="{{ $projet->idPr }}" {{ old('projet_id') == $projet->idPr ? 'selected' : '' }}>
                                    {{ $projet->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Étape 2 : membres --}}
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="step-label mb-0">
                            <span class="step-number">2</span> Membres à assigner
                        </label>
                        <span class="badge rounded-pill count-badge" id="selectedCount">0 sélectionné</span>
                    </div>

                    <div class="input-icon mb-2">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchMembers" class="form-control" placeholder="Rechercher par nom ou email…">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label small text-muted" for="selectAll">Tout sélectionner</label>
                        </div>
                        <small class="text-muted">{{ count($users) }} membre(s)</small>
                    </div>

                    <div class="member-list">
                        @forelse($users as $user)
                            @php
                                $initiales = strtoupper(mb_substr($user->prenom ?? '', 0, 1) . mb_substr($user->name ?? '', 0, 1));
                            @endphp
                            <label class="member-item" for="membre_{{ $user->id }}"
                                   data-search="{{ strtolower($user->prenom . ' ' . $user->name . ' ' . $user->email) }}">
                                <input class="member-check" type="checkbox" name="membres[]"
                                       id="membre_{{ $user->id }}" value="{{ $user->id }}"
                                       {{ in_array($user->id, old('membres', [])) ? 'checked' : '' }}>
                                <span class="avatar">{{ $initiales }}</span>
                                <span class="member-info">
                                    <span class="member-name">{{ $user->prenom }} {{ $user->name }}</span>
                                    <span class="member-email">{{ $user->email }}</span>
                                </span>
                                <i class="bi bi-check-circle-fill check-icon"></i>
                            </label>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-person-x fs-3 d-block mb-2"></i>Aucun membre disponible
                            </div>
                        @endforelse
                        <div class="text-center text-muted py-4 d-none" id="noResult">
                            <i class="bi bi-search fs-3 d-block mb-2"></i>Aucun résultat
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.projets.index') }}" class="btn btn-light px-4">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-gradient px-4 py-2">
                        <i class="bi bi-person-plus-fill me-2"></i>Assigner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary: #6d28d9;
        --primary-2: #4f46e5;
        --primary-soft: #f5f3ff;
        --border: #e5e7eb;
    }

    .assign-card {
        max-width: 720px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 45px -15px rgba(79, 70, 229, .25);
    }

    /* En-tête */
    .assign-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-2));
        padding: 2.2rem 1.5rem;
    }
    .assign-icon {
        width: 64px; height: 64px;
        margin: 0 auto;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
        background: rgba(255, 255, 255, .18);
        border-radius: 50%;
        backdrop-filter: blur(4px);
    }

    /* Étapes */
    .step-label {
        display: flex; align-items: center; gap: .6rem;
        font-weight: 600; color: #1f2937; margin-bottom: .6rem;
    }
    .step-number {
        width: 26px; height: 26px;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--primary-soft); color: var(--primary);
        border-radius: 50%; font-size: .8rem; font-weight: 700;
    }

    /* Champs avec icône */
    .input-icon { position: relative; }
    .input-icon > i {
        position: absolute; left: 14px; top: 50%;
        transform: translateY(-50%);
        color: #9ca3af; pointer-events: none; z-index: 5;
    }
    .input-icon .form-control,
    .input-icon .form-select {
        padding-left: 2.6rem;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background-color: #fafafa;
        transition: all .2s;
    }
    .input-icon .form-control:focus,
    .input-icon .form-select:focus {
        background-color: #fff;
        border-color: var(--primary);
        box-shadow: 0 0 0 .25rem rgba(109, 40, 217, .12);
    }

    /* Compteur */
    .count-badge {
        background: var(--primary-soft);
        color: var(--primary);
        font-weight: 600;
        padding: .45rem .8rem;
        transition: all .2s;
    }
    .count-badge.active { background: var(--primary); color: #fff; }

    /* Liste de membres */
    .member-list {
        max-height: 300px;
        overflow-y: auto;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: .5rem;
        background: #fafafa;
    }
    .member-list::-webkit-scrollbar { width: 6px; }
    .member-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }

    .member-item {
        display: flex; align-items: center; gap: .85rem;
        padding: .65rem .8rem;
        border-radius: 10px;
        border: 1.5px solid transparent;
        cursor: pointer;
        transition: all .15s;
        margin-bottom: .25rem;
        position: relative;
    }
    .member-item:hover { background: #fff; border-color: var(--border); }
    .member-item.checked {
        background: var(--primary-soft);
        border-color: #c4b5fd;
    }
    .member-check { position: absolute; opacity: 0; pointer-events: none; }

    .avatar {
        width: 40px; height: 40px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #a78bfa, var(--primary-2));
        color: #fff; font-weight: 600; font-size: .85rem;
    }
    .member-info { display: flex; flex-direction: column; min-width: 0; flex: 1; }
    .member-name { font-weight: 600; color: #1f2937; font-size: .95rem; }
    .member-email {
        color: #6b7280; font-size: .8rem;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .check-icon {
        color: var(--primary); font-size: 1.2rem;
        opacity: 0; transform: scale(.5);
        transition: all .2s;
    }
    .member-item.checked .check-icon { opacity: 1; transform: scale(1); }

    /* Bouton */
    .btn-gradient {
        background: linear-gradient(135deg, var(--primary), var(--primary-2));
        color: #fff; border: none; border-radius: 12px; font-weight: 600;
        box-shadow: 0 6px 16px -4px rgba(79, 70, 229, .45);
        transition: transform .15s, box-shadow .15s;
    }
    .btn-gradient:hover {
        color: #fff; transform: translateY(-2px);
        box-shadow: 0 10px 20px -4px rgba(79, 70, 229, .55);
    }
    .btn-light { border-radius: 12px; border: 1.5px solid var(--border); }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const items     = document.querySelectorAll('.member-item');
    const checks    = document.querySelectorAll('.member-check');
    const selectAll = document.getElementById('selectAll');
    const search    = document.getElementById('searchMembers');
    const badge     = document.getElementById('selectedCount');
    const noResult  = document.getElementById('noResult');

    const visibleItems = () => [...items].filter(i => i.style.display !== 'none');

    function refresh() {
        let count = 0;
        items.forEach(item => {
            const checked = item.querySelector('.member-check').checked;
            item.classList.toggle('checked', checked);
            if (checked) count++;
        });
        badge.textContent = count + (count > 1 ? ' sélectionnés' : ' sélectionné');
        badge.classList.toggle('active', count > 0);

        const visible = visibleItems();
        selectAll.checked = visible.length > 0 &&
            visible.every(i => i.querySelector('.member-check').checked);
    }

    checks.forEach(c => c.addEventListener('change', refresh));

    selectAll.addEventListener('change', () => {
        visibleItems().forEach(i => i.querySelector('.member-check').checked = selectAll.checked);
        refresh();
    });

    search.addEventListener('input', () => {
        const q = search.value.trim().toLowerCase();
        let shown = 0;
        items.forEach(item => {
            const match = item.dataset.search.includes(q);
            item.style.display = match ? '' : 'none';
            if (match) shown++;
        });
        noResult.classList.toggle('d-none', shown > 0 || items.length === 0);
        refresh();
    });

    refresh();
});
</script>
@endpush
@endsection
