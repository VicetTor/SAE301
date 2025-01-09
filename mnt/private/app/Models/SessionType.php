<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class SessionType extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'grp2_sessiontype'; // The model is associated with the 'grp2_sessiontype' table

    // Specify the primary key
    protected $primaryKey = 'SESSTYPE_ID'; // The primary key of the 'grp2_sessiontype' table is 'SESSTYPE_ID'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // Disabling automatic timestamp management for this model

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'SESSTYPE_ID', 'SESSTYPE_LABEL', // These are the attributes that can be mass-assigned
    ];

    /**
     * @OA\Schema(
     *     schema="SessionType",
     *     type="object",
     *     required={"SESSTYPE_ID", "SESSTYPE_LABEL"},
     *     @OA\Property(property="SESSTYPE_ID", type="integer", description="ID of the session type"),
     *     @OA\Property(property="SESSTYPE_LABEL", type="string", description="Label of the session type")
     * )
     */

    /**
     * Relationship with the `Session` model.
     * This defines a one-to-many relationship where a session type can have many sessions.
     * The foreign key in the `Session` model is `SESSTYPE_ID`, which corresponds to the primary key `SESSTYPE_ID` in the `SessionType` model.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class, 'SESSTYPE_ID', 'SESSTYPE_ID'); // A session type can have many sessions
    }
}
