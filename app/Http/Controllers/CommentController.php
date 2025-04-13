<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Exception;

class CommentController extends Controller
{

    public function store(Request $request, Project $project) : RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'content' => 'required|string',
                'website' => 'nullable|url|max:255',
            ]);

            $validated['project_id'] = $project->id;
            $validated['is_approved'] = false;

            Comment::create($validated);

            return redirect()->back()->with('comment_status', 'Votre commentaire a été soumis et sera visible après modération. Merci !');
        } catch (Exception $e) {
            Log::error('Erreur lors de la création d\'un commentaire: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoi du commentaire. Veuillez réessayer.')
                ->withInput();
        }
    }
}
