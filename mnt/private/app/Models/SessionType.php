<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class SessionType extends Model
{
    use HasFactory;

    // Spécifier le nom de la table
    protected $table = 'grp2_sessiontype';

    // Spécifier la clé primaire
    protected $primaryKey = 'SESSTYPE_ID';

    // Indiquer que cette table n'a pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'SESSTYPE_ID', 'SESSTYPE_LABEL', // Attributs de la table
    ];

    /**
     * @OA\Schema(
     *     schema="SessionType",
     *     type="object",
     *     required={"SESSTYPE_ID", "SESSTYPE_LABEL"},
     *     @OA\Property(property="SESSTYPE_ID", type="integer", description="ID du type de session"),
     *     @OA\Property(property="SESSTYPE_LABEL", type="string", description="Libellé du type de session")
     * )
     */

    
    public function sessions()
    {
        return $this->hasMany(Session::class, 'SESSTYPE_ID', 'SESSTYPE_ID');
    }
}
