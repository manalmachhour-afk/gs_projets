@extends('layouts.app')

@section('content')
@php
    $etats = [
        'Planifié' => 'planifie',
        'En cours' => 'en-cours',
        'Terminé'  => 'termine',
        'Annulé'   => 'annule',
    ];
    $fmt = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d/m/Y') : '—';
@endphp

<div class="admin-dashboard">

    {{-- En-tête --}}
    <div class="dash-header">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h1 class="dash-title"><i class="bi bi-briefcase-fill"></i> Tableau de bord</h1>
                <p class="mb-0 opacity-75">Bienvenue, <strong>{{ Auth::user()->prenom }} {{ Auth::user()->name }}</strong></p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Se déconnecter
                </button>
            </form>
        </div>
    </div>

    <div class="container pb-5">

        @if (session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Statistiques --}}
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-icon stat-total"><i class="bi bi-folder2-open"></i></span>
                <div>
                    <div class="stat-value">{{ $projets->count() }}</div>
                    <div class="stat-label">Projets au total</div>
                </div>
            </div>
            <div class="stat-card">
                <span class="stat-icon stat-en-cours"><i class="bi bi-hourglass-split"></i></span>
                <div>
                    <div class="stat-value">{{ $projets->where('etat', 'En cours')->count() }}</div>
                    <div class="stat-label">En cours</div>
                </div>
            </div>
            <div class="stat-card">
                <span class="stat-icon stat-termine"><i class="bi bi-check-circle"></i></span>
                <div>
                    <div class="stat-value">{{ $projets->where('etat', 'Terminé')->count() }}</div>
                    <div class="stat-label">Terminés</div>
                </div>
            </div>
            <div class="stat-card">
                <span class="stat-icon stat-planifie"><i class="bi bi-calendar-event"></i></span>
                <div>
                    <div class="stat-value">{{ $projets->where('etat', 'Planifié')->count() }}</div>
                    <div class="stat-label">Planifiés</div>
                </div>
            </div>
        </div>

        {{-- Liste des projets --}}
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h3 class="mb-0 fs-5 fw-bold">Liste des projets</h3>
                    <small class="text-muted">Gestion complète des projets</small>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-soft" href="{{ route('admin.projets.assign') }}">
                        <i class="bi bi-person-plus-fill me-1"></i> Assigner des membres
                    </a>
                    <a class="btn btn-gradient" href="{{ route('admin.projets.create') }}">
                        <i class="bi bi-plus-lg me-1"></i> Nouveau projet
                    </a>
                </div>
            </div>

            @if($projets->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-folder-x"></i>
                    <h4 class="mt-3">Aucun projet enregistré</h4>
                    <p class="text-muted mb-4">Commencez par créer votre premier projet.</p>
                    <a class="btn btn-gradient" href="{{ route('admin.projets.create') }}">
                        <i class="bi bi-plus-lg me-1"></i> Créer un projet
                    </a>
                </div>
            @else
                {{-- Barre d'outils : recherche + filtres --}}
                <div class="toolbar">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchProjet" class="form-control" placeholder="Rechercher un projet ou un responsable…">
                    </div>
                    <div class="chips" id="etatFilters">
                        <button type="button" class="chip active" data-etat="all">
                            Tous <span>{{ $projets->count() }}</span>
                        </button>
                        @foreach($etats as $etat => $slug)
                            <button type="button" class="chip" data-etat="{{ $etat }}">
                                {{ $etat }} <span>{{ $projets->where('etat', $etat)->count() }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Projet</th>
                                <th class="d-none d-lg-table-cell">Période</th>
                                <th>État</th>
                                <th class="d-none d-md-table-cell">Responsable</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projets as $projet)
                                @php
                                    $resp = $projet->responsable;
                                    $slug = $etats[$projet->etat] ?? 'planifie';
                                @endphp
                                <tr class="projet-row"
                                    data-etat="{{ $projet->etat }}"
                                    data-search="{{ mb_strtolower($projet->nom . ' ' . ($resp->prenom ?? '') . ' ' . ($resp->name ?? '')) }}">
                                    <td>
                                        <div class="projet-name">{{ $projet->nom }}</div>
                                        <div class="projet-desc">{{ Str::limit($projet->description, 60) }}</div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="date-range">
                                            <i class="bi bi-calendar3"></i>
                                            {{ $fmt($projet->date_debut) }} <i class="bi bi-arrow-right-short"></i> {{ $fmt($projet->date_fin) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="etat etat-{{ $slug }}">{{ $projet->etat }}</span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        @if($resp)
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="avatar">{{ mb_strtoupper(mb_substr($resp->prenom, 0, 1) . mb_substr($resp->name, 0, 1)) }}</span>
                                                <span class="fw-medium">{{ $resp->prenom }} {{ $resp->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">Non assigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.projets.edit', $projet->idPr) }}"
                                               class="icon-btn" title="Modifier" aria-label="Modifier {{ $projet->nom }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('admin.projets.destroy', $projet->idPr) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="icon-btn icon-btn-danger" title="Supprimer"
                                                        aria-label="Supprimer {{ $projet->nom }}"
                                                        onclick="return confirm('Supprimer le projet « {{ addslashes($projet->nom) }} » ?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr id="noResult" class="d-none">
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-search fs-2 d-block mb-2"></i>Aucun projet ne correspond à votre recherche
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .admin-dashboard {
        --primary: #6d28d9;
        --primary-2: #4f46e5;
        --primary-soft: #f5f3ff;
        --border: #e5e7eb;
        --text: #1f2937;
        font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        color: var(--text);
        background: #f8fafc;
        min-height: 100vh;
    }

    /* En-tête */
    .dash-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-2));
        color: #fff;
        padding: 2rem 0 4.5rem;
        margin-bottom: -3rem;
    }
    .dash-title { font-size: 1.6rem; font-weight: 700; display: flex; align-items: center; gap: .6rem; margin-bottom: .25rem; }
    .logout-btn {
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.3);
        color: #fff; padding: .5rem 1.2rem; border-radius: 50px;
        display: inline-flex; align-items: center; gap: .5rem;
        transition: background .2s; cursor: pointer;
    }
    .logout-btn:hover { background: rgba(255,255,255,.28); }

    /* Statistiques */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .stat-card {
        background: #fff; border-radius: 16px; padding: 1.2rem 1.3rem;
        display: flex; align-items: center; gap: 1rem;
        box-shadow: 0 4px 14px -4px rgba(15,23,42,.12);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 22px -6px rgba(15,23,42,.18); }
    .stat-icon {
        width: 52px; height: 52px; flex-shrink: 0; border-radius: 14px;
        display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
    }
    .stat-total    { background: #ede9fe; color: #6d28d9; }
    .stat-en-cours { background: #ffedd5; color: #ea580c; }
    .stat-termine  { background: #dcfce7; color: #16a34a; }
    .stat-planifie { background: #e0f2fe; color: #0284c7; }
    .stat-value { font-size: 1.9rem; font-weight: 700; line-height: 1.1; }
    .stat-label { color: #6b7280; font-size: .88rem; }

    /* Panneau */
    .panel {
        background: #fff; border-radius: 18px; overflow: hidden;
        box-shadow: 0 4px 14px -4px rgba(15,23,42,.1);
    }
    .panel-head {
        display: flex; flex-wrap: wrap; gap: 1rem;
        justify-content: space-between; align-items: center;
        padding: 1.3rem 1.5rem; border-bottom: 1px solid var(--border);
    }

    /* Boutons */
    .btn-gradient {
        background: linear-gradient(135deg, var(--primary), var(--primary-2));
        color: #fff; border: none; border-radius: 12px; font-weight: 600;
        box-shadow: 0 6px 16px -4px rgba(79,70,229,.45);
        transition: transform .15s, box-shadow .15s;
    }
    .btn-gradient:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px -4px rgba(79,70,229,.55); }
    .btn-soft {
        background: var(--primary-soft); color: var(--primary);
        border: none; border-radius: 12px; font-weight: 600;
    }
    .btn-soft:hover { background: #ede9fe; color: var(--primary); }

    /* Barre d'outils */
    .toolbar {
        display: flex; flex-wrap: wrap; gap: .8rem;
        justify-content: space-between; align-items: center;
        padding: 1rem 1.5rem; background: #fafafa; border-bottom: 1px solid var(--border);
    }
    .search-box { position: relative; flex: 1 1 260px; max-width: 360px; }
    .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
    .search-box .form-control {
        padding-left: 2.5rem; border-radius: 12px; border: 1.5px solid var(--border);
    }
    .search-box .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 .25rem rgba(109,40,217,.12); }

    .chips { display: flex; flex-wrap: wrap; gap: .4rem; }
    .chip {
        border: 1.5px solid var(--border); background: #fff; color: #4b5563;
        padding: .35rem .85rem; border-radius: 50px; font-size: .85rem; font-weight: 500;
        transition: all .15s; cursor: pointer;
    }
    .chip span {
        background: #f3f4f6; border-radius: 50px; padding: .05rem .5rem;
        margin-left: .25rem; font-size: .75rem;
    }
    .chip:hover { border-color: #c4b5fd; }
    .chip.active { background: var(--primary); border-color: var(--primary); color: #fff; }
    .chip.active span { background: rgba(255,255,255,.25); color: #fff; }

    /* Tableau */
    .table thead th {
        background: #fff; color: #6b7280; font-size: .78rem; text-transform: uppercase;
        letter-spacing: .04em; font-weight: 600; padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    .table tbody td { padding: 1rem 1.5rem; border-color: #f1f5f9; }
    .projet-row { transition: background .15s; }
    .projet-row:hover { background: var(--primary-soft); }
    .projet-name { font-weight: 600; color: var(--text); }
    .projet-desc { color: #6b7280; font-size: .82rem; }
    .date-range { color: #4b5563; font-size: .85rem; white-space: nowrap; }
    .date-range i:first-child { color: #9ca3af; margin-right: .25rem; }

    /* Badges d'état */
    .etat {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .3rem .8rem; border-radius: 50px; font-size: .78rem; font-weight: 600;
    }
    .etat::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .etat-planifie { background: #e0f2fe; color: #0369a1; }
    .etat-en-cours { background: #ffedd5; color: #c2410c; }
    .etat-termine  { background: #dcfce7; color: #15803d; }
    .etat-annule   { background: #fee2e2; color: #b91c1c; }

    /* Avatar */
    .avatar {
        width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #a78bfa, var(--primary-2));
        color: #fff; font-size: .75rem; font-weight: 600;
    }

    /* Boutons d'action */
    .icon-btn {
        width: 36px; height: 36px; border-radius: 10px; border: none;
        display: inline-flex; align-items: center; justify-content: center;
        background: #f3f4f6; color: #4b5563; font-size: .9rem;
        transition: all .15s; text-decoration: none; cursor: pointer;
    }
    .icon-btn:hover { background: var(--primary-soft); color: var(--primary); }
    .icon-btn-danger:hover { background: #fee2e2; color: #dc2626; }

    /* État vide */
    .empty-state { padding: 4rem 1rem; text-align: center; color: #6b7280; }
    .empty-state > i { font-size: 3.5rem; color: #cbd5e1; }

    @media (max-width: 768px) {
        .dash-header { text-align: center; padding-bottom: 4rem; }
        .table tbody td, .table thead th { padding: .85rem 1rem; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows     = document.querySelectorAll('.projet-row');
    const search   = document.getElementById('searchProjet');
    const chips    = document.querySelectorAll('.chip');
    const noResult = document.getElementById('noResult');
    if (!search) return;

    let etat = 'all';

    function applyFilters() {
        const q = search.value.trim().toLowerCase();
        let shown = 0;
        rows.forEach(row => {
            const ok = (etat === 'all' || row.dataset.etat === etat) && row.dataset.search.includes(q);
            row.classList.toggle('d-none', !ok);
            if (ok) shown++;
        });
        noResult.classList.toggle('d-none', shown > 0);
    }

    chips.forEach(chip => chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        etat = chip.dataset.etat;
        applyFilters();
    }));

    search.addEventListener('input', applyFilters);
});
</script>
@endpush
@endsection
