namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {
    // Si nécessaire, exclure des routes de la vérification CSRF :
    protected $except = [
        // 'route/to/exclude',
    ];
}