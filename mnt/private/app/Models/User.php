<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    // Specify the table name
    protected $table = 'grp2_user'; // The model is associated with the 'grp2_user' table

    // Specify the primary key
    protected $primaryKey = 'USER_ID'; // The primary key for the 'grp2_user' table is 'USER_ID'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // Disabling automatic timestamp management for this model

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'LEVEL_ID', 'TYPE_ID', 'LEVEL_ID_RESUME', 'USER_MAIL', 'USER_PASSWORD',
        'USER_FIRSTNAME', 'USER_LASTNAME', 'USER_PHONENUMBER', 'USER_BIRTHDATE',
        'USER_ADDRESS', 'USER_POSTALCODE', 'USER_LICENSENUMBER', 'USER_MEDICCERTIFICATEDATE'
    ];

    // Relationships:

    /**
     * Relationship with `Report` model.
     * A user can have many reports.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'USER_ID'); // A user can have many reports associated by USER_ID
    }

    /**
     * Relationship with `Evaluation` model.
     * A user can have many evaluations.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'USER_ID'); // A user can have many evaluations associated by USER_ID
    }

    /**
     * Relationship with `Level` model.
     * Each user belongs to one level (e.g., a level in a hierarchy or proficiency).
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'LEVEL_ID'); // A user belongs to one level identified by LEVEL_ID
    }

    /**
     * Relationship with `Skill` model through a pivot table.
     * A user can have many skills, and this relationship is defined through a pivot table `grp2_user_skill`.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'grp2_user_skill', 'USER_ID', 'SKILL_ID'); // A user can have many skills via the pivot table `grp2_user_skill`
    }

    /**
     * Relationship with `Club` model.
     * Each user belongs to a specific club.
     */
    public function club()
    {
        return $this->belongsTo(Club::class, 'CLUB_ID'); // A user belongs to one club identified by CLUB_ID
    }

    // Custom Authentication Methods:

    /**
     * Get the password used for authentication.
     */
    public function getAuthPassword() {
        return $this->USER_PASSWORD; // Return the password stored in the USER_PASSWORD field
    }

    /**
     * Get the name of the unique identifier for the user.
     * In this case, it's the email address.
     */
    public function getAuthIdentifierName() {
        return 'USER_MAIL'; // The unique identifier for authentication is the user's email address
    }

    /**
     * Get the unique identifier for the user.
     * This is used for identifying the user during authentication.
     */
    public function getAuthIdentifier() {
        return $this->USER_ID; // Return the user's ID as the unique identifier
    }
}
?>
