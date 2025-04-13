<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ProjectController extends Controller
{

    public function index(?Category $category) : View | RedirectResponse
    {
        try {

            $projects = Project::with('categories')
                ->published()
                ->when($category && $category->id, function ($query) use ($category) {
                    return $query->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id));
                })
                ->latest()
                ->paginate(9);
            $categories = Category::all();

            return view('projects.index', compact('projects', 'categories', 'category'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage des projets: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Une erreur est survenue lors de l\'affichage des projets. Veuillez réessayer.');
        }
    }


    public function show(Project $project) : View | RedirectResponse
    {
        try {
            if (!$project->is_published) {
                return redirect()->route('projects.index')->with('error', 'Ce projet n\'est pas disponible.');
            }
            
            $project->incrementViewCount();
            
            $project->load(['comments' => function($query) {
                $query->where('is_approved', true)
                      ->latest();
            }]);
            
            $relatedProjects = Project::where('id', '!=', $project->id)
                ->whereHas('categories', function($query) use ($project) {
                    $query->whereIn('categories.id', $project->categories->pluck('id'));
                })
                ->where('is_published', true)
                ->take(3)
                ->get();
                
            return view('projects.show', compact('project', 'relatedProjects'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du projet: ' . $e->getMessage());
            return redirect()->route('projects.index')->with('error', 'Une erreur est survenue lors de l\'affichage du projet. Veuillez réessayer.');
        }
    }
}
