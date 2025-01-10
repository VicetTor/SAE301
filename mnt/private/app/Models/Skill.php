<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Skill extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'grp2_skill'; // The model is associated with the 'grp2_skill' table

    // Specify the primary key
    protected $primaryKey = 'SKILL_ID'; // The primary key of the 'grp2_skill' table is 'SKILL_ID'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // Disabling automatic timestamp management for this model

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'LEVEL_ID', 'SKILL_LABEL', // These are the attributes that can be mass-assigned
    ];

    /**
     * @OA\Schema(
     *     schema="Skill",
     *     type="object",
     *     required={"SKILL_ID", "LEVEL_ID", "SKILL_LABEL"},
     *     @OA\Property(property="SKILL_ID", type="integer", description="ID of the skill"),
     *     @OA\Property(property="LEVEL_ID", type="integer", description="ID of the level associated with the skill"),
     *     @OA\Property(property="SKILL_LABEL", type="string", description="Label of the skill")
     * )
     */

    /**
     * Relationship with the `Level` model.
     * This defines a many-to-one relationship where a skill belongs to a level.
     * The foreign key in the `Skill` model is `LEVEL_ID`, which corresponds to the primary key `LEVEL_ID` in the `Level` model.
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'LEVEL_ID', 'LEVEL_ID'); // A skill belongs to one level
    }

    /**
     * Relationship with the `Ability` model.
     * This defines a one-to-many relationship where a skill can have many abilities.
     * The foreign key in the `Ability` model is `SKILL_ID`, which corresponds to the primary key `SKILL_ID` in the `Skill` model.
     */
    public function abilities()
    {
        return $this->hasMany(Ability::class, 'SKILL_ID', 'SKILL_ID'); // A skill can have many abilities
    }
}
