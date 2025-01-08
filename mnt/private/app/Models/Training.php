<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Training extends Model
{
    use HasFactory;

    // Spécifier le nom de la table
    protected $table = 'grp2_training';

    // Spécifier la clé primaire
    protected $primaryKey = 'TRAIN_ID';

    // Indiquer que cette table n'a pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'TRAIN_ID', // Le champ qui identifie la formation
    ];

    /**
     * @OA\Schema(
     *     schema="Training",
     *     type="object",
     *     required={"TRAIN_ID"},
     *     @OA\Property(property="TRAIN_ID", type="integer", description="ID de la formation")
     * )
     */

    
    public function sessions()
    {
        return $this->hasMany(Session::class, 'TRAIN_ID', 'TRAIN_ID');
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'grp2_attendee', 'TRAIN_ID', 'USER_ID');
    }
}
