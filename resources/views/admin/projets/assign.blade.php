@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-lg mx-auto" style="max-width: 700px;">
        <div class="card-header bg-white border-0 py-4">
            <h2 class="mb-0 text-center fw-bold text-primary">
                <i class="bi bi-people me-2"></i>Assigner des membres à un projet
            </h2>
        </div>
        <div class="card-body px-5 py-4">
            <form method="POST" action="{{ route('admin.projets.assignMembers') }}">
                @csrf
                <div class="mb-4">
                    <label for="projet_id" class="form-label fw-semibold text-gradient">Projet</label>
                    <select class="form-select input-gradient" id="projet_id" name="projet_id" required>
                        <option value="">-- Sélectionnez un projet --</option>
                        @foreach($projets as $projet)
                            <option value="{{ $projet->idPr }}">{{ $projet->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="membres" class="form-label fw-semibold text-gradient">Membres à assigner</label>
                    <div class="member-list-box p-3 mb-2" style="background: #f3f4f6; border-radius: 8px; border: 1px solid #e0e7ef; max-height: 220px; overflow-y: auto;">
                        @foreach($users as $user)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="membres[]" id="membre_{{ $user->id }}" value="{{ $user->id }}">
                                <label class="form-check-label" for="membre_{{ $user->id }}">
                                    <span class="fw-semibold">{{ $user->prenom }} {{ $user->name }}</span>
                                    <span class="text-muted small">({{ $user->email }})</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('admin.projets.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-person-plus me-2"></i>Assigner
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
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
</style>
@endpush
@endsection
