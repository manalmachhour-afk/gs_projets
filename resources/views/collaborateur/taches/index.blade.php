```blade
@extends('layouts.app')

@section('content')

<div class="collaborator-dashboard">

    {{-- En-tête --}}
    <div class="header-section">
        <div class="container">
            <div class="header-content">

                <div>
                    <div class="header-icon">
                        <i class="bi bi-person-check"></i>
                    </div>

                    <h1 class="page-title">
                        Tableau de bord Collaborateur
                    </h1>

                    <p class="welcome-text">
                        Bienvenue,
                        <strong>{{ Auth::user()->prenom }} {{ Auth::user()->name }}</strong>
                    </p>

                    <p class="header-subtitle">
                        Consultez vos tâches et suivez votre progression.
                    </p>
                </div>

                <div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    <a href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="btn btn-logout">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Se déconnecter
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="container dashboard-content">

        {{-- Statistiques --}}
        <div class="stats-container">

            <div class="stats-card stats-card-primary">
                <div class="stats-icon">
                    <i class="bi bi-list-task"></i>
                </div>

                <div class="stats-info">
                    <h2>{{ $taches->count() }}</h2>
                    <p>Tâches assignées</p>
                </div>

                <i class="bi bi-list-task stats-decoration"></i>
            </div>

            <div class="stats-card stats-card-success">
                <div class="stats-icon">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div class="stats-info">
                    <h2>{{ $taches->where('etat', 'Terminée')->count() }}</h2>
                    <p>Tâches terminées</p>
                </div>

                <i class="bi bi-check-circle stats-decoration"></i>
            </div>

        </div>

        {{-- Liste des tâches --}}
        <div class="tasks-card">

            <div class="tasks-card-header">
                <div>
                    <h3>
                        <i class="bi bi-clipboard-check me-2"></i>
                        Mes tâches assignées
                    </h3>

                    <p>Retrouvez ici toutes les tâches qui vous sont attribuées.</p>
                </div>

                <span class="tasks-count">
                    {{ $taches->count() }} tâches
                </span>
            </div>

            <div class="table-responsive">

                <table class="table tasks-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>État</th>
                            <th>Projet</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($taches as $tache)

                            <tr>

                                <td>
                                    <span class="task-title">
                                        {{ $tache->titre }}
                                    </span>
                                </td>

                                <td>
                                    <span class="task-description"
                                          title="{{ $tache->description }}">
                                        {{ $tache->description ?: 'Aucune description' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="date-text">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ $tache->date_debut }}
                                    </span>
                                </td>

                                <td>
                                    <span class="date-text">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        {{ $tache->date_fin }}
                                    </span>
                                </td>

                                <td>
                                    @if($tache->etat == 'Planifiée')

                                        <span class="status-badge status-planned">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $tache->etat }}
                                        </span>

                                    @elseif($tache->etat == 'En cours')

                                        <span class="status-badge status-progress">
                                            <i class="bi bi-arrow-repeat me-1"></i>
                                            {{ $tache->etat }}
                                        </span>

                                    @elseif($tache->etat == 'Terminée')

                                        <span class="status-badge status-completed">
                                            <i class="bi bi-check-circle me-1"></i>
                                            {{ $tache->etat }}
                                        </span>

                                    @elseif($tache->etat == 'Annulée')

                                        <span class="status-badge status-cancelled">
                                            <i class="bi bi-x-circle me-1"></i>
                                            {{ $tache->etat }}
                                        </span>

                                    @else
                                        <span>{{ $tache->etat }}</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="project-name">
                                        <i class="bi bi-folder2 me-1"></i>
                                        {{ $tache->projet->nom ?? '-' }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            <i class="bi bi-clipboard-x"></i>
                                        </div>

                                        <h5>Aucune tâche assignée</h5>

                                        <p>
                                            Vous n'avez actuellement aucune tâche à réaliser.
                                            Les nouvelles tâches apparaîtront ici.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>
</div>

@endsection


@push('styles')

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* Général */
    .collaborator-dashboard {
        min-height: 100vh;
        padding-bottom: 40px;
        background: #f8fafc;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: #1e293b;
    }

    /* En-tête */
    .collaborator-dashboard .header-section {
        position: relative;
        overflow: hidden;
        padding: 35px 0;
        margin-bottom: 30px;
        background: linear-gradient(120deg, #1e40af, #2563eb, #3b82f6);
        color: #fff;
    }

    .collaborator-dashboard .header-section::before {
        content: "";
        position: absolute;
        width: 350px;
        height: 350px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.07);
        top: -200px;
        right: 5%;
    }

    .collaborator-dashboard .header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .collaborator-dashboard .header-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.17);
        font-size: 24px;
    }

    .collaborator-dashboard .page-title {
        font-size: 27px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .collaborator-dashboard .welcome-text {
        font-size: 15px;
        margin-bottom: 5px;
        color: #eff6ff;
    }

    .collaborator-dashboard .welcome-text strong {
        color: #fff;
    }

    .collaborator-dashboard .header-subtitle {
        color: #dbeafe;
        font-size: 13px;
        margin-bottom: 0;
    }

    .collaborator-dashboard .btn-logout {
        display: inline-flex;
        align-items: center;
        padding: 11px 17px;
        border-radius: 9px;
        color: #fff;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.35);
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .collaborator-dashboard .btn-logout:hover {
        color: #fff;
        background: #dc2626;
        border-color: #dc2626;
    }

    /* Statistiques */
    .collaborator-dashboard .stats-container {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
        margin-bottom: 30px;
    }

    .collaborator-dashboard .stats-card {
        position: relative;
        display: flex;
        align-items: center;
        gap: 18px;
        min-height: 145px;
        padding: 25px;
        overflow: hidden;
        border-radius: 15px;
        color: #fff;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.07);
        transition: transform 0.2s ease;
    }

    .collaborator-dashboard .stats-card:hover {
        transform: translateY(-4px);
    }

    .collaborator-dashboard .stats-card-primary {
        background: linear-gradient(120deg, #1e40af, #3b82f6);
    }

    .collaborator-dashboard .stats-card-success {
        background: linear-gradient(120deg, #15803d, #22a447);
    }

    .collaborator-dashboard .stats-icon {
        width: 58px;
        height: 58px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: rgba(255, 255, 255, 0.19);
        font-size: 27px;
    }

    .collaborator-dashboard .stats-info {
        position: relative;
        z-index: 1;
    }

    .collaborator-dashboard .stats-info h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .collaborator-dashboard .stats-info p {
        font-size: 14px;
        margin-bottom: 0;
        color: rgba(255, 255, 255, 0.9);
    }

    .collaborator-dashboard .stats-decoration {
        position: absolute;
        right: 20px;
        bottom: -20px;
        font-size: 100px;
        opacity: 0.10;
    }

    /* Carte des tâches */
    .collaborator-dashboard .tasks-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        box-shadow: 0 6px 22px rgba(15, 23, 42, 0.045);
        overflow: hidden;
    }

    .collaborator-dashboard .tasks-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 23px 25px;
        border-bottom: 1px solid #eef0f4;
    }

    .collaborator-dashboard .tasks-card-header h3 {
        color: #1e293b;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .collaborator-dashboard .tasks-card-header h3 i {
        color: #2563eb;
    }

    .collaborator-dashboard .tasks-card-header p {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 0;
    }

    .collaborator-dashboard .tasks-count {
        padding: 7px 13px;
        border-radius: 30px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Tableau */
    .collaborator-dashboard .tasks-table {
        min-width: 850px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .collaborator-dashboard .tasks-table thead th {
        padding: 16px 14px;
        background: #f8fafc;
        color: #475569;
        border-bottom: 1px solid #e5e7eb;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .collaborator-dashboard .tasks-table tbody td {
        padding: 16px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .collaborator-dashboard .tasks-table tbody tr:last-child td {
        border-bottom: none;
    }

    .collaborator-dashboard .tasks-table tbody tr {
        transition: background 0.2s ease;
    }

    .collaborator-dashboard .tasks-table tbody tr:hover {
        background: #f8fafc;
    }

    .collaborator-dashboard .task-title {
        color: #1e40af;
        font-weight: 700;
    }

    .collaborator-dashboard .task-description {
        display: inline-block;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #64748b;
    }

    .collaborator-dashboard .date-text {
        color: #475569;
        white-space: nowrap;
    }

    .collaborator-dashboard .date-text i {
        color: #64748b;
    }

    .collaborator-dashboard .project-name {
        color: #334155;
        font-weight: 600;
        white-space: nowrap;
    }

    /* États */
    .collaborator-dashboard .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .collaborator-dashboard .status-planned {
        background: #e0f2fe;
        color: #0369a1;
    }

    .collaborator-dashboard .status-progress {
        background: #fef3c7;
        color: #b45309;
    }

    .collaborator-dashboard .status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .collaborator-dashboard .status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Aucune tâche */
    .collaborator-dashboard .empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .collaborator-dashboard .empty-icon {
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 28px;
    }

    .collaborator-dashboard .empty-state h5 {
        color: #1e293b;
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .collaborator-dashboard .empty-state p {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .collaborator-dashboard .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .collaborator-dashboard .header-content > div:last-child {
            width: 100%;
        }

        .collaborator-dashboard .btn-logout {
            width: 100%;
            justify-content: center;
        }

        .collaborator-dashboard .page-title {
            font-size: 22px;
        }

        .collaborator-dashboard .stats-container {
            grid-template-columns: 1fr;
        }

        .collaborator-dashboard .tasks-card-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {

        .collaborator-dashboard .header-section {
            padding: 25px 0;
        }

        .collaborator-dashboard .stats-card {
            padding: 20px;
            min-height: 120px;
        }

        .collaborator-dashboard .tasks-card-header {
            padding: 20px 16px;
        }
    }

</style>
@endpush
```
