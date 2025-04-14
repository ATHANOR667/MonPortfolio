<?php

namespace App\Http\Middleware;

use App\Service\VisitorTracking;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $tracker = new VisitorTracking($request);
            $tracker->track();
        } catch (\Exception $e) {
            Log::error('Erreur dans le middleware TrackVisitor', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}