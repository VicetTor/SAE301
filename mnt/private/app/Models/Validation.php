<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Validation extends Model
{
    use HasFactory;

    // Spécifier le nom de la table
    protected $table = 'grp2_validation';

    // Spécifier la clé primaire
    protected $primaryKey = 'VALID_ID';

    // Indiquer que cette table n'a pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'SKILL_ID', 'ABI_ID', 'LEVEL_ID', 'EVAL_ID', 'VALID_DATE',
    ];

    /**
     * @OA\Schema(
     *     schema="Validation",
     *     type="object",
     *     required={"VALID_ID", "VALID_DATE", "SKILL_ID", "ABI_ID", "LEVEL_ID", "EVAL_ID"},
     *     @OA\Property(property="VALID_ID", type="integer", description="ID de la validation"),
     *     @OA\Property(property="SKILL_ID", type="integer", description="ID de la compétence validée"),
     *     @OA\Property(property="ABI_ID", type="integer", description="ID de l'aptitude validée"),
     *     @OA\Property(property="LEVEL_ID", type="integer", description="ID du niveau de la validation"),
     *     @OA\Property(property="EVAL_ID", type="integer", description="ID de l'évaluation associée à la validation"),
     *     @OA\Property(property="VALID_DATE", type="string", format="date", description="Date de la validation")
     * )
     */

    
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'SKILL_ID', 'SKILL_ID');
    }

    
    public function ability()
    {
        return $this->belongsTo(Ability::class, 'ABI_ID', 'ABI_ID');
    }

    
    public function level()
    {
        return $this->belongsTo(Level::class, 'LEVEL_ID', 'LEVEL_ID');
    }

    
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'EVAL_ID', 'EVAL_ID');
    }
}
