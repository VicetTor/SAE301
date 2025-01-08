<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Session extends Model
{
    use HasFactory;

    protected $table = 'grp2_session';
    protected $primaryKey = 'SESS_ID';
    public $timestamps = false;

    protected $fillable = [
        'TRAIN_ID', 'TYPE_ID', 'SESSTYPE_ID'
    ];

    /**
     * @OA\Schema(
     *     schema="Session",
     *     type="object",
     *     required={"SESS_ID", "TRAIN_ID", "TYPE_ID", "SESSTYPE_ID"},
     *     @OA\Property(property="SESS_ID", type="integer", description="ID de la session"),
     *     @OA\Property(property="TRAIN_ID", type="integer", description="ID de la formation associée"),
     *     @OA\Property(property="TYPE_ID", type="integer", description="ID du type de session"),
     *     @OA\Property(property="SESSTYPE_ID", type="integer", description="ID du type de session")
     * )
     */

    // Relation avec `SessionType` pour obtenir le type de session
   
    public function sessionType()
    {
        return $this->belongsTo(SessionType::class, 'SESSTYPE_ID');
    }
}
