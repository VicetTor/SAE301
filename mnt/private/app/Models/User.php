<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'grp2_user'; // Spécifie le nom de la table
    protected $primaryKey = 'USER_ID'; // Spécifie la clé primaire si elle n'est pas `id`
    public $timestamps = false; // Si vous n'avez pas de colonnes `created_at` et `updated_at`

    protected $fillable = [
        'LEVEL_ID', 'TYPE_ID', 'LEVEL_ID_RESUME', 'USER_MAIL', 'USER_PASSWORD',
        'USER_FIRSTNAME', 'USER_LASTNAME', 'USER_PHONENUMBER', 'USER_BIRTHDATE',
        'USER_ADDRESS', 'USER_POSTALCODE', 'USER_LICENSENUMBER', 'USER_MEDICCERTIFICATEDATE'
    ];

    // Relations
    public function reports()
    {
        return $this->hasMany(Report::class, 'USER_ID');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'USER_ID');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'LEVEL_ID');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'grp2_user_skill', 'USER_ID', 'SKILL_ID');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'CLUB_ID');
    }

    public function getAuthPassword() {
        return $this->USER_PASSWORD;
    }

    public function getAuthIdentifierName() {
        return 'USER_MAIL';
    }

    public function getAuthIdentifier() {
        return $this->USER_ID;
    }
}
?>