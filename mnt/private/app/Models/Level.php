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
 *     @OA\Property(property="LEVEL_ID", type="integer", description="ID of the level"),
 *     @OA\Property(property="LEVEL_LABEL", type="string", description="Label of the level")
 * )
 */
class Level extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Specify the table name
    protected $table = 'grp2_level'; // The table associated with this model is 'grp2_level'

    // Define the primary key
    protected $primaryKey = 'LEVEL_ID'; // The primary key of the table is 'LEVEL_ID'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // No automatic timestamps for 'created_at' and 'updated_at'

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'LEVEL_LABEL', // 'LEVEL_LABEL' is the only mass-assignable attribute in this table
    ];

    /**
     * @OA\Schema(
     *     schema="Level",
     *     type="object",
     *     required={"LEVEL_ID", "LEVEL_LABEL"},
     *     @OA\Property(property="LEVEL_ID", type="integer", description="ID of the level"),
     *     @OA\Property(property="LEVEL_LABEL", type="string", description="Label of the level")
     * )
     */
     
    /**
     * Relationship with `Skill` model.
     * This defines a one-to-many relationship between the `Level` and `Skill` models.
     * A level can have many skills associated with it.
     */
    public function skills()
    {
        return $this->hasMany(Skill::class, 'LEVEL_ID', 'LEVEL_ID'); // A level can have many skills, with 'LEVEL_ID' as the foreign key in the `Skill` model
    }

    /**
     * Relationship with `User` model.
     * This defines a one-to-many relationship between the `Level` and `User` models.
     * A level can have many users associated with it.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'LEVEL_ID', 'LEVEL_ID'); // A level can have many users, with 'LEVEL_ID' as the foreign key in the `User` model
    }
}
