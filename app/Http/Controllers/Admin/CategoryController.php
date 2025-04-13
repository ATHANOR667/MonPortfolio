<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index(): \Illuminate\Contracts\View\View
    {
        $categories = Category::withCount('projects')->get();
        return view('admin.categories.index', compact('categories'));
    }


    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie créée avec succès.');
    }


    public function update(Request $request, Category $category): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie mise à jour avec succès.');
    }


    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->projects()->detach();
        

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie supprimée avec succès.');
    }
}
