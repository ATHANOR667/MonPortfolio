<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\QueryException;
use Throwable;
use Log;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Journalisation personnalisée des exceptions
            if ($this->shouldReport($e)) {
                Log::error('Exception détectée: ' . get_class($e), [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        });

        // Gestion des exceptions spécifiques
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Ressource non trouvée.',
                    'error' => 'not_found'
                ], 404);
            }
            
            return redirect()->back()->with('error', 'La ressource demandée n\'existe pas.');
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Page non trouvée.',
                    'error' => 'not_found'
                ], 404);
            }
            
            return response()->view('errors.404', [], 404);
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Les données fournies sont invalides.',
                    'errors' => $e->errors(),
                    'error' => 'validation_failed'
                ], 422);
            }
            
            return redirect()->back()->withErrors($e->errors())->withInput();
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Vous devez être connecté pour accéder à cette ressource.',
                    'error' => 'unauthenticated'
                ], 401);
            }
            
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Vous n\'êtes pas autorisé à effectuer cette action.',
                    'error' => 'unauthorized'
                ], 403);
            }
            
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Méthode non autorisée.',
                    'error' => 'method_not_allowed'
                ], 405);
            }
            
            return redirect()->back()->with('error', 'Méthode non autorisée.');
        });

        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Votre session a expiré. Veuillez rafraîchir la page et réessayer.',
                    'error' => 'token_mismatch'
                ], 419);
            }
            
            return redirect()->back()->with('error', 'Votre session a expiré. Veuillez rafraîchir la page et réessayer.');
        });

        $this->renderable(function (QueryException $e, $request) {
            // Journaliser l'erreur de base de données
            Log::error('Erreur de base de données: ' . $e->getMessage(), [
                'sql' => $e->getSql() ?? 'Non disponible',
                'bindings' => $e->getBindings() ?? [],
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Une erreur est survenue lors de l\'accès à la base de données.',
                    'error' => 'database_error'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'accès à la base de données. Veuillez réessayer plus tard.');
        });

        // Gestion générique des autres exceptions
        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Une erreur inattendue est survenue.',
                    'error' => 'server_error'
                ], 500);
            }
            
            if (config('app.debug')) {
                // En mode debug, laisser Laravel afficher l'erreur détaillée
                return null;
            }
            
            return response()->view('errors.500', ['exception' => $e], 500);
        });
    }
}
