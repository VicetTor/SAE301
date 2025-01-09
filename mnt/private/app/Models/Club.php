<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Club extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'grp2_club'; // The table name in the database is 'grp2_club'

    // Define the primary key
    protected $primaryKey = 'club_id'; // The primary key of the 'grp2_club' table is 'club_id'

    // Indicate that this table does not have timestamps (created_at, updated_at)
    public $timestamps = false; // No automatic timestamping for 'created_at' and 'updated_at' columns

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'club_name', 'club_postalcode', 'club_city', 'club_address', // These are the fields that can be filled when creating or updating a club record
    ];

    /**
     * @OA\Schema(
     *     schema="Club",
     *     type="object",
     *     required={"club_id", "club_name", "club_postalcode", "club_city", "club_address"},
     *     @OA\Property(property="club_id", type="integer", description="ID of the club"),
     *     @OA\Property(property="club_name", type="string", description="Name of the club"),
     *     @OA\Property(property="club_postalcode", type="integer", description="Postal code of the club"),
     *     @OA\Property(property="club_city", type="string", description="City of the club"),
     *     @OA\Property(property="club_address", type="string", description="Address of the club")
     * )
     */
     
    /**
     * Relationship with `User` model.
     * This defines a one-to-many relationship between the `Club` and `User` models.
     * A club can have many users (members).
     */
    public function users() {
        return $this->hasMany(User::class, 'CLUB_ID'); // The 'CLUB_ID' in the User model refers to the 'club_id' in the Club model.
    }

    /**
     * Relationship with `Training` model.
     * This defines a one-to-many relationship between the `Club` and `Training` models.
     * A club can have many training sessions.
     */
    public function trainings() {
        return $this->hasMany(Training::class); // A club can have many training sessions.
    }

    /**
     * Relationship with `Report` model.
     * This defines a one-to-many relationship between the `Club` and `Report` models.
     * A club can have many reports.
     */
    public function reports() {
        return $this->hasMany(Report::class, 'CLUB_ID'); // The 'CLUB_ID' in the Report model refers to the 'club_id' in the Club model.
    }

    /**
     * Relationship with `Evaluation` model.
     * This defines a one-to-many relationship between the `Club` and `Evaluation` models.
     * A club can have many evaluations.
     */
    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'CLUB_ID'); // The 'CLUB_ID' in the Evaluation model refers to the 'club_id' in the Club model.
    }
}
?>
