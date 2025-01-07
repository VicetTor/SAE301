<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Ability",
 *     type="object",
 *     required={"id", "SKILL_ID", "ABI_LABEL"},
 *     @OA\Property(property="id", type="integer", description="ID of the ability"),
 *     @OA\Property(property="SKILL_ID", type="integer", description="Skill ID associated with the ability"),
 *     @OA\Property(property="ABI_LABEL", type="string", description="Label of the ability")
 * )
 */
class Ability extends Model
{
    use HasFactory;

    // Spécifier le nom de la table
    protected $table = 'grp2_ability';

    // Spécifier la clé primaire
    protected $primaryKey = 'ABI_ID';

    // Indiquer que cette table n'a pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'SKILL_ID', 'ABI_LABEL', // Attributs de la table
    ];

    // Relation avec `Grp2Skill` pour obtenir la compétence associée à l'aptitude
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'SKILL_ID', 'SKILL_ID');
    }

    // Relation avec `Grp2Evaluation` pour obtenir les évaluations associées à l'aptitude
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'ABI_ID', 'ABI_ID');
    }

    // Relation avec `Grp2Validation` pour obtenir les validations associées à l'aptitude
    public function validations()
    {
        return $this->hasMany(Validation::class, 'ABI_ID', 'ABI_ID');
    }
}
