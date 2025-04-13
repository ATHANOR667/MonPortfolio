<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Education;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileViewController extends Controller
{

    public function show()
    {
        try {
            $user = User::first();
            
            $education = collect();
            $experience = collect();
            
            if (!$user) {
                Log::error('Aucun utilisateur trouvé pour afficher le profil.');
                return view('errors.profile-setup', [
                    'message' => 'Aucun utilisateur trouvé. Veuillez vous connecter à l\'administration pour configurer votre profil.'
                ]);
            }
            
            $profile = $user->profile;
            
            if (!$profile) {
                $profile = Profile::create([
                    'user_id' => $user->id,
                    'full_name' => $user->name ?? 'Nom par défaut',
                    'email' => $user->email ?? 'email@example.com',
                    'title' => 'Mon titre professionnel',
                    'bio' => 'Biographie à compléter',
                    'location' => 'Localisation à compléter',
                    'phone' => 'Téléphone à compléter',
                    'website' => 'https://example.com',
                    'github' => 'https://github.com',
                    'twitter' => 'https://twitter.com',
                    'linkedin' => 'https://linkedin.com',
                ]);
                
                Log::info('Profil créé automatiquement pour l\'utilisateur ' . $user->id);
                
                return view('profile.show', compact('profile', 'education', 'experience'))
                    ->with('info', 'Votre profil a été initialisé. Connectez-vous à l\'administration pour le compléter.');
            }
            
            try {
                $education = $profile->educations()->orderBy('start_date', 'desc')->get();

                $experience = $profile->experiences()->orderBy('start_date', 'desc')->get();

            } catch (Exception $relationException) {
                Log::warning('Erreur lors de la récupération des relations du profil: ' . $relationException->getMessage());
            }
            
            return view('profile.show', compact('profile', 'education', 'experience'));
            
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du profil public: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return view('errors.generic', [
                'message' => 'Une erreur est survenue lors de l\'affichage du profil. Veuillez réessayer plus tard.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ]);
        }
    }
}
