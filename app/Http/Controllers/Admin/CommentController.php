<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Exception;

class CommentController extends Controller
{

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $comments = Comment::with('project')->latest()->paginate(15);
            return view('admin.comments.index', compact('comments'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage des commentaires: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Une erreur est survenue lors de l\'affichage des commentaires. Veuillez réessayer.');
        }
    }


    public function projectComments(Project $project) : \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $comments = $project->comments()->latest()->paginate(15);
            return view('admin.comments.project', compact('project', 'comments'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage des commentaires du projet: ' . $e->getMessage());
            return redirect()->route('admin.projects.index')->with('error', 'Une erreur est survenue lors de l\'affichage des commentaires du projet. Veuillez réessayer.');
        }
    }


    public function update(Request $request, Comment $comment) : \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string',
            ]);

            $comment->update($validated);

            return redirect()->back()->with('status', 'Commentaire mis à jour avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour du commentaire: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du commentaire. Veuillez réessayer.')
                ->withInput();
        }
    }


    public function destroy(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        try {
            $comment->delete();

            return redirect()->back()->with('status', 'Commentaire supprimé avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression du commentaire: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du commentaire. Veuillez réessayer.');
        }
    }


    public function approve(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        try {
            $comment->update(['is_approved' => true]);

            return redirect()->back()->with('status', 'Commentaire approuvé avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'approbation du commentaire: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'approbation du commentaire. Veuillez réessayer.');
        }
    }


    public function reject(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        try {
            $comment->update(['is_approved' => false]);

            return redirect()->back()->with('status', 'Commentaire rejeté avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors du rejet du commentaire: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors du rejet du commentaire. Veuillez réessayer.');
        }
    }
}
