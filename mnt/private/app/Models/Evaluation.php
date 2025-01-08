<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Evaluation extends Model
{
    use HasFactory;

    // Spécifier le nom de la table
    protected $table = 'grp2_evaluation';

    // Spécifier la clé primaire
    protected $primaryKey = 'EVAL_ID';

    // Indiquer que cette table n'a pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'EVAL_LABEL', 'EVAL_DATE',
    ];

    /**
     * @OA\Schema(
     *     schema="Evaluation",
     *     type="object",
     *     required={"EVAL_ID", "EVAL_LABEL", "EVAL_DATE"},
     *     @OA\Property(property="EVAL_ID", type="integer", description="ID de l'évaluation"),
     *     @OA\Property(property="EVAL_LABEL", type="string", description="Label de l'évaluation"),
     *     @OA\Property(property="EVAL_DATE", type="string", format="date", description="Date de l'évaluation")
     * )
     */

    /**
     * Relation avec `User` pour obtenir les utilisateurs associés à l'évaluation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'USER_ID');
    }

    /**
     * Relation avec `Validation` pour obtenir les validations associées à l'évaluation
     */
    public function validations()
    {
        return $this->hasMany(Validation::class, 'EVAL_ID', 'EVAL_ID');
    }
}
