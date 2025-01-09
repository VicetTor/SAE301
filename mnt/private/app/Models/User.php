<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

class User extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $table = 'grp2_user'; // Spécifie le nom de la table
    protected $primaryKey = 'USER_ID'; // Spécifie la clé primaire si elle n'est pas `id`
    public $timestamps = false; // Si vous n'avez pas de colonnes `created_at` et `updated_at`

    protected $fillable = [
        'LEVEL_ID', 'TYPE_ID', 'LEVEL_ID_RESUME', 'USER_MAIL', 'USER_PASSWORD',
        'USER_FIRSTNAME', 'USER_LASTNAME', 'USER_PHONENUMBER', 'USER_BIRTHDATE',
        'USER_ADDRESS', 'USER_POSTALCODE', 'USER_LICENSENUMBER', 'USER_MEDICCERTIFICATEDATE'
    ];

    /**
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     required={"USER_ID", "USER_MAIL", "USER_FIRSTNAME", "USER_LASTNAME"},
     *     @OA\Property(property="USER_ID", type="integer", description="ID de l'utilisateur"),
     *     @OA\Property(property="USER_MAIL", type="string", description="Email de l'utilisateur"),
     *     @OA\Property(property="USER_PASSWORD", type="string", description="Mot de passe de l'utilisateur"),
     *     @OA\Property(property="USER_FIRSTNAME", type="string", description="Prénom de l'utilisateur"),
     *     @OA\Property(property="USER_LASTNAME", type="string", description="Nom de l'utilisateur"),
     *     @OA\Property(property="USER_PHONENUMBER", type="string", description="Numéro de téléphone de l'utilisateur"),
     *     @OA\Property(property="USER_BIRTHDATE", type="string", format="date", description="Date de naissance de l'utilisateur"),
     *     @OA\Property(property="USER_ADDRESS", type="string", description="Adresse de l'utilisateur"),
     *     @OA\Property(property="USER_POSTALCODE", type="string", description="Code postal de l'utilisateur"),
     *     @OA\Property(property="USER_LICENSENUMBER", type="string", description="Numéro de licence de l'utilisateur"),
     *     @OA\Property(property="USER_MEDICCERTIFICATEDATE", type="string", format="date", description="Date du certificat médical de l'utilisateur")
     * )
     */
 
    public function formationsResponsable() {
        return $this->hasMany(Training::class, 'type_id');
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
