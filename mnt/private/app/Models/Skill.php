<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Skill extends Model
{
    use HasFactory;

    // Spécifier le nom de la table
    protected $table = 'grp2_skill';

    // Spécifier la clé primaire
    protected $primaryKey = 'SKILL_ID';

    // Indiquer que cette table n'a pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'LEVEL_ID', 'SKILL_LABEL', // Attributs de la table
    ];

    /**
     * @OA\Schema(
     *     schema="Skill",
     *     type="object",
     *     required={"SKILL_ID", "LEVEL_ID", "SKILL_LABEL"},
     *     @OA\Property(property="SKILL_ID", type="integer", description="ID de la compétence"),
     *     @OA\Property(property="LEVEL_ID", type="integer", description="ID du niveau associé à la compétence"),
     *     @OA\Property(property="SKILL_LABEL", type="string", description="Libellé de la compétence")
     * )
     */

    
    public function level()
    {
        return $this->belongsTo(Level::class, 'LEVEL_ID', 'LEVEL_ID');
    }

    
    public function abilities()
    {
        return $this->hasMany(Ability::class, 'SKILL_ID', 'SKILL_ID');
    }
}
