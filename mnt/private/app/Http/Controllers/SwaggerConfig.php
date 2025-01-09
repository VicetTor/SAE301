<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Mon API",
 *     version="1.0.0",
 *     description="Documentation de l'API"
 * )
 *
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="API de développement"
 * )
 */
class SwaggerConfig
{
    // Ce fichier peut être vide sinon, car il s'agit uniquement d'annotations.
}
?>