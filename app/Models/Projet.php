<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $table = 'projets';
    protected $primaryKey = 'idPr';
    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'etat',
        'responsable_id',
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
    public function membres()
    {
        return $this->belongsToMany(User::class, 'membre_projet', 'projet_id', 'user_id');
    }
}
