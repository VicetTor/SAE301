<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

class Club extends Model
{
    use HasFactory;

    // Spécifier le nom de la table
    protected $table = 'grp2_club';

    // Définir la clé primaire
    protected $primaryKey = 'club_id';

    // Indiquer que cette table n'a pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'club_name', 'club_postalcode', 'club_city', 'club_address',
    ];

    /**
     * @OA\Schema(
     *     schema="Club",
     *     type="object",
     *     required={"club_id", "club_name", "club_postalcode", "club_city", "club_address"},
     *     @OA\Property(property="club_id", type="integer", description="ID du club"),
     *     @OA\Property(property="club_name", type="string", description="Nom du club"),
     *     @OA\Property(property="club_postalcode", type="integer", description="Code postal du club"),
     *     @OA\Property(property="club_city", type="string", description="Ville du club"),
     *     @OA\Property(property="club_address", type="string", description="Adresse du club")
     * )
     */

    public function users() {
        return $this->hasMany(User::class, 'CLUB_ID');
    }

    public function trainings() {
        return $this->hasMany(Training::class);
    }

    public function reports() {
        return $this->hasMany(Report::class, 'CLUB_ID');
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'CLUB_ID');
    }
}

?>