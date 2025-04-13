<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class ProjectController extends Controller
{
    public function index(): View | RedirectResponse
    {
        try {
            $projects = Project::with('categories')->latest()->paginate(10);
            return view('admin.projects.index', compact('projects'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage des projets: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Une erreur est survenue lors de l\'affichage des projets. Veuillez réessayer.');
        }
    }

    public function create(): View | RedirectResponse
    {
        try {
            $categories = Category::all();
            return view('admin.projects.create', compact('categories'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du formulaire de création de projet: ' . $e->getMessage());
            return redirect()->route('admin.projects.index')->with('error', 'Une erreur est survenue lors de l\'affichage du formulaire. Veuillez réessayer.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:projects',
                'description' => 'required|string',
                'content' => 'nullable|string',
                'client' => 'nullable|string|max:255',
                'date' => 'nullable|date',
                'url' => 'nullable|url|max:255',
                'featured_image' => 'required|image|max:2048',
                'is_published' => 'boolean',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
                'additional_images.*' => 'nullable|image|max:2048',
                'video_url' => 'nullable|url|max:255',
            ]);

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $request->file('featured_image')->store('projects', 'public');
            }

            $validated['user_id'] = Auth::guard('admin')->user()->id;

            $project = Project::create($validated);

            if (!empty($validated['categories'])) {
                $project->categories()->attach($validated['categories']);
            }

            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $path = $image->store('projects', 'public');
                    $project->images()->create(['path' => $path]);
                }
            }

            return redirect()->route('admin.projects.index')->with('status', 'Projet créé avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la création du projet: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du projet. Veuillez réessayer.')
                ->withInput();
        }
    }

    public function edit(Project $project): View | RedirectResponse
    {
        try {
            $project->load('categories', 'images');
            return view('admin.projects.edit', compact('project'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du formulaire d\'édition: ' . $e->getMessage());
            return redirect()->route('admin.projects.index')->with('error', 'Une erreur est survenue lors de l\'affichage du formulaire d\'édition. Veuillez réessayer.');
        }
    }

    public function destroy(Project $project): RedirectResponse
    {
        try {
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }

            foreach ($project->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }

            $project->delete();

            return redirect()->route('admin.projects.index')->with('status', 'Projet supprimé avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression du projet: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du projet. Veuillez réessayer.');
        }
    }

    public function togglePublished(Project $project): RedirectResponse
    {
        try {
            $project->update(['is_published' => !$project->is_published]);

            $status = $project->is_published ? 'publié' : 'masqué';
            return redirect()->route('admin.projects.index')->with('status', "Projet {$status} avec succès.");
        } catch (Exception $e) {
            Log::error('Erreur lors du changement de statut du projet: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors du changement de statut du projet. Veuillez réessayer.');
        }
    }
}