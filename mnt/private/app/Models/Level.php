<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Level",
 *     type="object",
 *     required={"LEVEL_ID", "LEVEL_LABEL"},
 *     @OA\Property(property="LEVEL_ID", type="integer", description="ID du niveau"),
 *     @OA\Property(property="LEVEL_LABEL", type="string", description="Libellé du niveau")
 * )
 */
class Level extends Model
{
    use HasFactory;

    protected $table = 'grp2_level';
    protected $primaryKey = 'LEVEL_ID';
    public $timestamps = false;

    protected $fillable = [
        'LEVEL_LABEL',
    ];

    /**
     * Relation avec `Skill` pour obtenir toutes les compétences associées à ce niveau
     */
    public function skills()
    {
        return $this->hasMany(Skill::class, 'LEVEL_ID', 'LEVEL_ID');
    }

    /**
     * Relation avec `User` pour obtenir tous les utilisateurs associés à ce niveau
     */
    public function users()
    {
        return $this->hasMany(User::class, 'LEVEL_ID', 'LEVEL_ID');
    }
}
