<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report'; // Nom de la table
    public $timestamps = false; // Si vous n'avez pas de colonnes created_at et updated_at

    protected $fillable = [
        'CLUB_ID', 'USER_ID', 'ANNU_YEAR'
    ];

    // Relation avec le modèle User
    public function user() {
        return $this->belongsTo(User::class, 'USER_ID');
    }

    // Relation avec le modèle Club
    public function club() {
        return $this->belongsTo(Club::class, 'CLUB_ID');
    }
}
