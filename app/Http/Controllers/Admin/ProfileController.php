<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Education;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileController extends Controller
{


    public function view(): \Illuminate\Contracts\View\View|RedirectResponse{
        try {
            $user = Auth::guard('admin')->user();
            $profile = $user->profile ?? Profile::create(['user_id' => $user->id, 'full_name' => $user->name]);
            $educations = $profile->educations()->orderBy('start_date', 'desc')->get();
            $experiences = $profile->experiences()->orderBy('start_date', 'desc')->get();
            
            return view('admin.profile.edit', compact('profile', 'educations', 'experiences'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du profil: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'affichage du profil. Veuillez réessayer.');
        }
    }
    

    public function update(Request $request): RedirectResponse
    {
        try {
            $user = Auth::guard('admin')->user();
            $profile = $user->profile;
            
            if (!$profile) {
                $profile = Profile::create(['user_id' => $user->id, 'full_name' => $user->name]);
            }
            
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'title' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'github' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
            ]);
            
            $profile->update($validated);
            
            return redirect()->route('admin.profile.edit')->with('status', 'Profil mis à jour avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour du profil: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du profil: ' . $e->getMessage());
        }
    }
    

    public function updatePhoto(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'photo' => 'required|image|max:2048',
            ]);
            
            $user = Auth::guard('admin')->user();
            $profile = $user->profile;
            

            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            
            $path = $request->file('photo')->store('profile', 'public');
            $profile->update(['photo' => $path]);
            
            return redirect()->route('admin.profile.edit')->with('status', 'Photo de profil mise à jour avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour de la photo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de la photo: ' . $e->getMessage());
        }
    }

    public function updateCV(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'cv' => 'required|mimes:pdf,doc,docx|max:5120',
            ]);
            
            $user = Auth::guard('admin')->user();
            $profile = $user->profile;
            
            if (!$profile) {
                $profile = Profile::create(['user_id' => $user->id, 'full_name' => $user->name]);
            }
            
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            
            $path = $request->file('cv')->store('cv', 'public');
            $profile->update(['cv_path' => $path]);
            
            return redirect()->route('admin.profile.edit')->with('status', 'CV mis à jour avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour du CV: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du CV: ' . $e->getMessage());
        }
    }
}
