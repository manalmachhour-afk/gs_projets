<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        if ($user->role && $user->role->nom === 'administrateur') {
            return redirect()->route('admin.projets.index');
        }
        if ($user->role && $user->role->nom === 'chef_projet') {
            return redirect()->route('chef.taches.index');
        }
        if ($user->role && $user->role->nom === 'collaborateur') {
            return redirect()->route('collaborateur.taches.index');
        }
        // Ajoutez ici d'autres redirections selon le rôle si besoin
        return view('dashboard');
    }
}
