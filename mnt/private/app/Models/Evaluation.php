<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Evaluation",
 *     type="object",
 *     required={"USER_ID", "STATUSTYPE_ID", "SESS_ID", "ABI_ID"},
 *     @OA\Property(property="id", type="integer", description="Evaluation ID"),
 *     @OA\Property(property="USER_ID", type="integer", description="User ID"),
 *     @OA\Property(property="STATUSTYPE_ID", type="integer", description="Status Type ID"),
 *     @OA\Property(property="SESS_ID", type="integer", description="Session ID"),
 *     @OA\Property(property="ABI_ID", type="integer", description="Ability ID")
 * )
 */
class Evaluation extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $table = 'grp2_evaluation';
    protected $primaryKey = 'EVAL_ID';

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID');
    }

    public function validation()
    {
        return $this->hasOne(Validation::class, 'EVAL_ID');
    }
}
?>