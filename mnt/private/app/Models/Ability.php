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

    // Specify the name of the table
    protected $table = 'grp2_ability'; // The table name in the database is 'grp2_ability'

    // Specify the primary key
    protected $primaryKey = 'ABI_ID'; // The primary key of the 'grp2_ability' table is 'ABI_ID'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // No automatic timestamping for 'created_at' and 'updated_at' columns

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'SKILL_ID', 'ABI_LABEL', // These are the fields that can be filled when creating or updating an Ability record
    ];

    /**
     * Relationship with `Skill` model.
     * This defines a many-to-one relationship between the `Ability` and `Skill` models.
     * An ability belongs to a skill.
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'SKILL_ID', 'SKILL_ID'); // The 'SKILL_ID' in the ability model is related to the 'SKILL_ID' in the skill model.
    }

    /**
     * Relationship with `Evaluation` model.
     * This defines a one-to-many relationship between the `Ability` and `Evaluation` models.
     * An ability can have many evaluations.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'ABI_ID', 'ABI_ID'); // The 'ABI_ID' in the evaluation model refers to the 'ABI_ID' in the ability model.
    }

    /**
     * Relationship with `Validation` model.
     * This defines a one-to-many relationship between the `Ability` and `Validation` models.
     * An ability can have many validations.
     */
    public function validations()
    {
        return $this->hasMany(Validation::class, 'ABI_ID', 'ABI_ID'); // The 'ABI_ID' in the validation model refers to the 'ABI_ID' in the ability model.
    }
}
