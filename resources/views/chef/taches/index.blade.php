@extends('layouts.app')

@section('content')
<div class="header-section mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center header-content">
            <div>
                <h1 class="page-title"><i class="bi bi-list-task"></i> Tableau de bord Chef de Projet</h1>
                <p class="welcome-text mb-0">Bienvenue, <strong>{{ Auth::user()->prenom }} {{ Auth::user()->name }}</strong></p>
            </div>
            <div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="stats-container animate-fade">
        <div class="stats-card stats-card-primary">
            <i class="bi bi-list-task"></i>
            <h2>{{ $taches->count() }}</h2>
            <p>Tâches totales</p>
        </div>
        <div class="stats-card stats-card-success">
            <i class="bi bi-check-circle"></i>
            <h2>{{ $taches->where('etat','Terminée')->count() }}</h2>
            <p>Tâches terminées</p>
        </div>
    </div>
    <div class="card animate-fade">
        <div class="card-header">
            <h3 class="mb-0">Liste des tâches</h3>
            <span class="badge bg-primary badge-custom">{{ $taches->count() }} tâches</span>
            <a class="btn btn-success float-end" href="{{ route('chef.taches.create') }}">
                <i class="bi bi-plus-lg"></i> Nouvelle Tâche
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle table-bordered" style="width: 100%; background: #e6f9ec; border-collapse: separate; border-spacing: 0 0.5rem;">
                <thead class="table-success">
                    <tr>
                        <th class="text-center">Titre</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Date début</th>
                        <th class="text-center">Date fin</th>
                        <th class="text-center">État</th>
                        <th class="text-center">Projet</th>
                        <th class="text-center">Assignée à</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($taches as $tache)
                        <tr style="background: #fff; box-shadow: 0 2px 8px #e0f2f1; border-radius: 8px;">
                            <td class="fw-bold text-success text-center align-middle" style="background: #e8f5e9; border-radius: 8px 0 0 8px;">{{ $tache->titre }}</td>
                            <td class="text-center align-middle" style="background: #f9fbe7;">{{ $tache->description }}</td>
                            <td class="text-center align-middle" style="background: #e3f2fd;">{{ $tache->date_debut }}</td>
                            <td class="text-center align-middle" style="background: #e3f2fd;">{{ $tache->date_fin }}</td>
                            <td class="text-center align-middle" style="background: #f1f8e9;">
                                @if($tache->etat == 'Planifiée')
                                    <span class="badge bg-info text-dark">{{ $tache->etat }}</span>
                                @elseif($tache->etat == 'En cours')
                                    <span class="badge bg-warning text-dark">{{ $tache->etat }}</span>
                                @elseif($tache->etat == 'Terminée')
                                    <span class="badge bg-success">{{ $tache->etat }}</span>
                                @elseif($tache->etat == 'Annulée')
                                    <span class="badge bg-danger">{{ $tache->etat }}</span>
                                @else
                                    {{ $tache->etat }}
                                @endif
                            </td>
                            <td class="text-center align-middle" style="background: #f1f8e9;">{{ $tache->projet->nom ?? '-' }}</td>
                            <td class="text-center align-middle" style="background: #f1f8e9; border-radius: 0 8px 8px 0;">{{ $tache->assignee->prenom ?? '' }} {{ $tache->assignee->name ?? '-' }}</td>
                            <td class="text-center align-middle" style="background: #f1f8e9;">
                                <a href="{{ route('chef.taches.edit', $tache->id) }}" class="btn btn-sm btn-primary me-2">Modifier</a>
                                <form action="{{ route('chef.taches.destroy', $tache->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette tâche ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted text-center">Aucune tâche trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        :root {
            --primary-color: #1e293b;
            --secondary-color: #ff9800;
            --success-color: #16a34a;
            --light-bg: #f8fafc;
            --card-bg: #fff;
            --text-color: #1e293b;
            --border-radius: 16px;
            --shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.03);
            --transition: all 0.3s ease;
        }
        body { background: linear-gradient(135deg, #f0f9ff 0%, #f8fafc 100%); font-family: 'Inter', 'Segoe UI', Arial, sans-serif; color: var(--text-color); }
        .header-section {
            background: linear-gradient(135deg, #475569, #334155) !important;
            color: white !important;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: var(--border-radius);
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
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        .header-content { position: relative; z-index: 1; }
        .card { background: var(--card-bg); border-radius: var(--border-radius); box-shadow: var(--shadow); border: none; margin-bottom: 1.5rem; transition: var(--transition); }
        .card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.08), 0 10px 10px -5px rgba(0,0,0,0.03); }
        .card-header { background: var(--card-bg); border-bottom: 1px solid #eee; padding: 1.25rem 1.5rem; border-radius: var(--border-radius) var(--border-radius) 0 0 !important; font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
        .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stats-card { border-radius: var(--border-radius); padding: 1.5rem; color: white; display: flex; flex-direction: column; min-height: 120px; position: relative; overflow: hidden; transition: var(--transition); }
        .stats-card-primary { background: linear-gradient(135deg, var(--primary-color), #3b82f6); }
        .stats-card-success { background: linear-gradient(135deg, var(--success-color), #22c55e); }
        .stats-card i { font-size: 2.2rem; margin-bottom: 0.5rem; }
        .stats-card h2 { font-weight: 700; font-size: 2rem; margin-bottom: 0.25rem; }
        .stats-card p { margin-bottom: 0; font-size: 1rem; }
        .badge-custom { font-weight: 500; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; }
        .animate-fade { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .table th, .table td { vertical-align: middle !important; }
        .table th { background: #f1f5f9; font-weight: 600; }
        .table-hover tbody tr:hover { background: #f3f4f6; }
        .btn { border-radius: 8px; }
        .sidebar { background: var(--primary-color); color: #fff; min-width: 200px; border-radius: var(--border-radius); }
        .sidebar-link { color: #fff; display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1rem; border-radius: 8px; transition: background 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: var(--secondary-color); color: #fff; }
        .form-control, .form-select { border-radius: 8px; }
        .badge.bg-info, .badge.bg-warning, .badge.bg-success, .badge.bg-danger { font-size: 0.95em; }
    </style>
@endpush
