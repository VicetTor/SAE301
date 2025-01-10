<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Training extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'grp2_training'; // The model is associated with the 'grp2_training' table

    // Specify the primary key
    protected $primaryKey = 'TRAIN_ID'; // The primary key of the 'grp2_training' table is 'TRAIN_ID'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // Disabling automatic timestamp management for this model

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'TRAIN_ID', // The attribute for identifying the training
    ];

    /**
     * @OA\Schema(
     *     schema="Training",
     *     type="object",
     *     required={"TRAIN_ID"},
     *     @OA\Property(property="TRAIN_ID", type="integer", description="ID of the training")
     * )
     */

    /**
     * Relationship with the `Session` model.
     * This defines a one-to-many relationship where a training can have many sessions.
     * The foreign key in the `Session` model is `TRAIN_ID`, which corresponds to the primary key `TRAIN_ID` in the `Training` model.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class, 'TRAIN_ID', 'TRAIN_ID'); // A training can have many sessions
    }

    /**
     * Relationship with the `User` model through a pivot table `grp2_attendee`.
     * This defines a many-to-many relationship where a training can have many users (attendees) and vice versa.
     * The pivot table `grp2_attendee` has the foreign keys `TRAIN_ID` and `USER_ID` to connect the two models.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'grp2_attendee', 'TRAIN_ID', 'USER_ID'); // A training can have many users (attendees) via the pivot table
    }
}
