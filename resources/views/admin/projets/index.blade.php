@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
<div class="header-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center header-content">
            <div>
                <h1 class="page-title"><i class="bi bi-briefcase"></i> Tableau de bord Administrateur</h1>
                <p class="welcome-text mb-0">Bienvenue, <strong>{{ Auth::user()->prenom }} {{ Auth::user()->name }}</strong></p>
            </div>
            <div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Se déconnecter
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Statistiques améliorées -->
    <div class="stats-container animate-fade">
        <div class="stats-card stats-card-primary">
            <i class="bi bi-briefcase"></i>
            <h2>{{ $projets->count() }}</h2>
            <p>Projets enregistrés</p>
        </div>
        <div class="stats-card stats-card-success">
            <i class="bi bi-check-circle"></i>
            <h2>{{ $projets->where('etat', 'Terminé')->count() }}</h2>
            <p>Projets terminés</p>
        </div>
        <div class="stats-card stats-card-warning">
            <i class="bi bi-clock"></i>
            <h2>{{ $projets->where('etat', 'En cours')->count() }}</h2>
            <p>Projets en cours</p>
        </div>
    </div>

    <!-- Carte des projets avec design amélioré -->
    <div class="card animate-fade">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0">Liste des projets</h3>
                    <span class="stage-dates">Gestion complète des projets</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary badge-custom">{{ $projets->count() }} projets</span>
                    <a class="btn btn-success btn-icon" href="{{ route('admin.projets.create') }}">
                        <i class="bi bi-plus-lg"></i> Nouveau
                    </a>
                    <a class="btn btn-primary btn-icon" href="{{ route('admin.projets.assign') }}">
                        <i class="bi bi-person-plus"></i> Assigner membres
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($projets->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-folder-x"></i>
                    <h4 class="mt-3">Aucun projet enregistré</h4>
                    <p class="text-muted">Commencez par créer un nouveau projet</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Dates</th>
                                <th>État</th>
                                <th>Responsable</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projets as $projet)
                                <tr class="projet-item">
                                    <td class="fw-bold text-primary">{{ $projet->nom }}</td>
                                    <td>{{ Str::limit($projet->description, 50) }}</td>
                                    <td>
                                        <small class="text-muted">{{ $projet->date_debut }} - {{ $projet->date_fin }}</small>
                                    </td>
                                    <td>
                                        @if($projet->etat == 'Planifié')
                                            <span class="badge bg-info">{{ $projet->etat }}</span>
                                        @elseif($projet->etat == 'En cours')
                                            <span class="badge bg-warning text-dark">{{ $projet->etat }}</span>
                                        @elseif($projet->etat == 'Terminé')
                                            <span class="badge bg-success">{{ $projet->etat }}</span>
                                        @elseif($projet->etat == 'Annulé')
                                            <span class="badge bg-danger">{{ $projet->etat }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($projet->responsable)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-initial bg-light rounded-circle">
                                                        {{ substr($projet->responsable->prenom, 0, 1) }}{{ substr($projet->responsable->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    {{ $projet->responsable->prenom }} {{ $projet->responsable->name }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Non assigné</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.projets.edit', $projet->idPr) }}" class="btn btn-sm btn-outline-primary btn-icon" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.projets.destroy', $projet->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-icon" title="Supprimer" onclick="return confirm('Êtes-vous sûr ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #7c3aed;
        --success-color: #16a34a;
        --warning-color: #ea580c;
        --danger-color: #dc2626;
        --info-color: #0284c7;
        --light-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-color: #1e293b;
        --border-radius: 12px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --transition: all 0.3s ease;
    }
    body, html, .admin-dashboard {
        background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 100%) !important;
        font-family: 'Poppins', 'Segoe UI', Arial, sans-serif !important;
        color: var(--text-color) !important;
    }
    .admin-dashboard .header-section {
        background: linear-gradient(135deg, #475569, #334155) !important;
        color: white !important;
        position: relative;
        overflow: hidden;
    }
    .admin-dashboard .header-section::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
    }
    .admin-dashboard .stats-card-primary {
        background: linear-gradient(135deg, var(--primary-color), #3b82f6) !important;
    }
    .admin-dashboard .stats-card-success {
        background: linear-gradient(135deg, var(--success-color), #22c55e) !important;
    }
    .admin-dashboard .stats-card-warning {
        background: linear-gradient(135deg, var(--warning-color), #f97316) !important;
    }
    .admin-dashboard .card {
        background-color: var(--card-bg) !important;
    }
    .admin-dashboard .badge.bg-primary {
        background-color: var(--primary-color) !important;
        color: #fff !important;
    }
    .admin-dashboard .badge.bg-success {
        background-color: var(--success-color) !important;
        color: #fff !important;
    }
    .admin-dashboard .badge.bg-warning {
        background-color: var(--warning-color) !important;
        color: #fff !important;
    }
    .admin-dashboard .badge.bg-info {
        background-color: var(--info-color) !important;
        color: #fff !important;
    }
    .admin-dashboard .badge.bg-danger {
        background-color: var(--danger-color) !important;
        color: #fff !important;
    }
    /* Header amélioré */
    .header-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 1.5rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .header-section::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
        transform: rotate(30deg);
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.75rem;
        font-weight: 700;
    }
    
    .welcome-text {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    /* Bouton de déconnexion amélioré */
    .logout-btn {
        background-color: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .logout-btn:hover {
        background-color: rgba(255, 255, 255, 0.3);
        color: white;
    }
    
    /* Stats cards améliorées */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stats-card {
        border-radius: var(--border-radius);
        padding: 1.5rem;
        color: white;
        display: flex;
        flex-direction: column;
        min-height: 140px;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-card::before {
        content: "";
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
    }
    
    .stats-card i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        z-index: 1;
    }
    
    .stats-card h2 {
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 0.25rem;
        z-index: 1;
    }
    
    .stats-card p {
        margin-bottom: 0;
        font-size: 1rem;
        z-index: 1;
    }
    
    .stats-card-primary {
        background: linear-gradient(135deg, var(--primary-color), #3b82f6);
    }
    
    .stats-card-success {
        background: linear-gradient(135deg, var(--success-color), #22c55e);
    }
    
    .stats-card-warning {
        background: linear-gradient(135deg, var(--warning-color), #f97316);
    }
    
    /* Carte améliorée */
    .card {
        background-color: var(--card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: none;
        margin-bottom: 1.5rem;
        transition: var(--transition);
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .card-header {
        background-color: var(--card-bg);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }
    
    /* Tableau amélioré */
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8fafc;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border-bottom-width: 1px;
    }
    
    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
    }
    
    .projet-item:hover {
        background-color: rgba(37, 99, 235, 0.03);
    }
    
    /* Badges */
    .badge {
        font-weight: 500;
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .badge-custom {
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
    }
    
    /* Boutons */
    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem;
        border-radius: 8px;
        transition: var(--transition);
    }
    
    .btn-icon i {
        font-size: 1rem;
    }
    
    /* Avatar */
    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-initial {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary-color);
    }
    
    /* Empty state */
    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #64748b;
    }
    
    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }
    
    /* Stage dates */
    .stage-dates {
        font-size: 0.9rem;
        color: #64748b;
        margin-top: 0.25rem;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade {
        animation: fadeIn 0.5s ease-out;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            padding: 1rem 0;
        }
        
        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>
@endpush
