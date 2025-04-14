<?php

namespace App\Service;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log;

class VisitorTracking
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function track(): void
    {
        try {
            $agent = new Agent();
            $agent->setUserAgent($this->request->userAgent());

            $ipAddress = $this->request->ip();

            $location = null;
            try {
                $location = retry(2, fn() => Location::get($ipAddress), 100);            } catch (\Exception $e) {
                Log::warning('Erreur de géolocalisation pour IP: ' . $ipAddress, ['error' => $e->getMessage()]);
            } catch (\Throwable $e) {
                Log::warning('Erreur de géolocalisation pour IP: ' . $ipAddress, ['error' => $e->getMessage()]);
            }

            $visitorData = [
                'ip_address' => $ipAddress,
                'user_agent' => $this->request->userAgent(),
                'page_visited' => $this->request->fullUrl(),
                'referrer' => $this->request->header('referer'),
                'country' => $location ? $location->countryName : null,
                'city' => $location ? $location->cityName : null,
                'visit_date' => now(),
            ];

            Visitor::create($visitorData)->dispatch();
        } catch (\Exception $e) {
            Log::error('Erreur lors du suivi du visiteur', [
                'ip' => $ipAddress ?? 'inconnu',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}