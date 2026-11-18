<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/projets', [ProjetController::class, 'index'])->name('admin.projets.index');
    Route::get('/admin/projets/create', [ProjetController::class, 'create'])->name('admin.projets.create');
    Route::post('/admin/projets', [ProjetController::class, 'store'])->name('admin.projets.store');
    Route::post('/admin/projets/update', [ProjetController::class, 'update'])->name('admin.projets.update');
    Route::post('/admin/projets/destroy', [ProjetController::class, 'destroy'])->name('admin.projets.destroy');
    Route::get('/admin/projets/{id}/edit', [ProjetController::class, 'edit'])->name('admin.projets.edit');
    Route::get('/admin/projets/assign', [ProjetController::class, 'showAssignMembers'])->name('admin.projets.assign');
    Route::post('/admin/projets/assign', [ProjetController::class, 'assignMembers'])->name('admin.projets.assignMembers');
    Route::get('/chef/taches', [TacheController::class, 'index'])->name('chef.taches.index');
    Route::get('/chef/taches/create', [TacheController::class, 'create'])->name('chef.taches.create');
    Route::post('/chef/taches', [TacheController::class, 'store'])->name('chef.taches.store');
    Route::get('/chef/taches/{id}/edit', [TacheController::class, 'edit'])->name('chef.taches.edit');
    Route::put('/chef/taches/{id}', [TacheController::class, 'update'])->name('chef.taches.update');
    Route::delete('/chef/taches/{id}', [TacheController::class, 'destroy'])->name('chef.taches.destroy');
    Route::get('/collaborateur/taches', [TacheController::class, 'collaborateurIndex'])->name('collaborateur.taches.index');
});

require __DIR__.'/auth.php';
