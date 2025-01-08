<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'grp2_evaluation'; // Nom de la table
    protected $primaryKey = 'EVAL_ID'; // Clé primaire
    public $timestamps = false; // Si vous n'avez pas de colonnes created_at et updated_at

    protected $fillable = [
        'STATUSTYPE_ID', 'USER_ID', 'SESS_ID', 'ABI_ID', 'EVAL_OBSERVATION'
    ];

    // Relation avec le modèle User
    public function user() {
        return $this->belongsTo(User::class, 'USER_ID');
    }

    // Relation avec le modèle Report
    public function report() {
        return $this->hasOneThrough(Report::class, User::class, 'USER_ID', 'USER_ID');
    }

    public function club() {
        return $this->belongsTo(Club::class, 'CLUB_ID');
    }


    public function level() {
        return $this->belongsTo(Level::class, 'LEVEL_ID');
    }

    public function skill() {
        return $this->belongsTo(Skill::class, 'SKILL_ID');
    }
}
