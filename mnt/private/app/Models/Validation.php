<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Validation extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'grp2_validation'; // The model is associated with the 'grp2_validation' table

    // Specify the primary key
    protected $primaryKey = 'VALID_ID'; // The primary key for the 'grp2_validation' table is 'VALID_ID'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // Disabling automatic timestamp management for this model

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'SKILL_ID', 'ABI_ID', 'LEVEL_ID', 'EVAL_ID', 'VALID_DATE', // Attributes of the 'grp2_validation' table
    ];

    /**
     * @OA\Schema(
     *     schema="Validation",
     *     type="object",
     *     required={"VALID_ID", "VALID_DATE", "SKILL_ID", "ABI_ID", "LEVEL_ID", "EVAL_ID"},
     *     @OA\Property(property="VALID_ID", type="integer", description="ID of the validation"),
     *     @OA\Property(property="SKILL_ID", type="integer", description="ID of the validated skill"),
     *     @OA\Property(property="ABI_ID", type="integer", description="ID of the validated ability"),
     *     @OA\Property(property="LEVEL_ID", type="integer", description="ID of the validation level"),
     *     @OA\Property(property="EVAL_ID", type="integer", description="ID of the evaluation associated with the validation"),
     *     @OA\Property(property="VALID_DATE", type="string", format="date", description="Date of the validation")
     * )
     */

    // Relationships

    /**
     * Relationship with the `Skill` model.
     * Each validation is associated with a skill.
     */
    public function skill() {
        return $this->belongsTo(Skill::class, 'SKILL_ID'); // A validation belongs to one skill identified by SKILL_ID
    }

    /**
     * Relationship with the `Ability` model.
     * Each validation is associated with an ability.
     */
    public function ability()
    {
        return $this->belongsTo(Ability::class, 'ABI_ID', 'ABI_ID'); // A validation belongs to one ability identified by ABI_ID
    }

    /**
     * Relationship with the `Level` model.
     * Each validation is associated with a validation level.
     */
    public function level() {
        return $this->belongsTo(Level::class, 'LEVEL_ID'); // A validation belongs to one level identified by LEVEL_ID
    }

    /**
     * Relationship with the `Evaluation` model.
     * Each validation is associated with an evaluation.
     */
    public function evaluation() {
        return $this->belongsTo(Evaluation::class, 'EVAL_ID'); // A validation belongs to one evaluation identified by EVAL_ID
    }
}
?>
