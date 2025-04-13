<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditProject extends Component
{
    use WithFileUploads;

    public Project $project;
    public ?string $title;
    public ?string $slug;
    public ?string $description;
    public ?string $content;
    public ?string $client;
    public ?string $date;
    public ?string $url;
    public ?string $video_url;
    public bool $is_published;
    public array $categories;
    public null|TemporaryUploadedFile|string $featured_image;
    public array $additional_images;
    public Collection $existing_images;
    public Collection $allCategories;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug,' . $this->project->id,
            'description' => 'required|string',
            'content' => 'nullable|string',
            'client' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'url' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function mount($project): void
    {
        $this->project = $project instanceof Project ? $project : Project::findOrFail($project);
        $this->title = $this->project->title ?? '';
        $this->slug = $this->project->slug;
        $this->description = $this->project->description ?? '';
        $this->content = $this->project->content;
        $this->client = $this->project->client;
        $this->date = $this->project->date ? $this->project->date->format('Y-m-d') : null;
        $this->url = $this->project->url;
        $this->video_url = $this->project->video_url;
        $this->is_published = $this->project->is_published;
        $this->categories = $this->project->categories->pluck('id')->toArray();
        $this->existing_images = $this->project->images;
        $this->allCategories = Category::all();
        $this->featured_image = $this->project->featured_image;
        $this->additional_images = [];
    }

    /**
     * @throws ValidationException
     */
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function updatedTitle(string $value): void
    {
        if (!$this->slug || $this->slug === Str::slug($this->project->title)) {
            $this->slug = Str::slug($value);
        }
    }

    public function updatedAdditionalImages(): void
    {
        $this->validateOnly('additional_images');
    }

    public function update(): void
    {
        try {
            $validated = $this->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:projects,slug,' . $this->project->id,
                'description' => 'required|string',
                'content' => 'nullable|string',
                'client' => 'nullable|string|max:255',
                'date' => 'nullable|date',
                'url' => 'nullable|url|max:255',
                'video_url' => 'nullable|url|max:255',
                'is_published' => 'boolean',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ]);

            $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

            $this->project->update($validated);

            $this->project->categories()->sync($this->categories ?: []);

            session()->flash('status', 'Projet mis à jour avec succès.');
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->errors());
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du projet: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la mise à jour du projet. Veuillez réessayer.');
        }
    }

    public function updateFeaturedImage(): void
    {
        try {
            $this->validate([
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($this->featured_image instanceof TemporaryUploadedFile) {
                if ($this->project->featured_image) {
                    Storage::disk('public')->delete($this->project->featured_image);
                }
                $path = $this->featured_image->store('projects', 'public');
                $this->project->update(['featured_image' => $path]);
                $this->reset('featured_image');
                session()->flash('status', 'Image principale mise à jour avec succès.');
            }
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->errors());
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'image principale: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la mise à jour de l\'image principale.');
        }
    }

    public function addAdditionalImages(): void
    {
        try {
            $this->validate([
                'additional_images' => 'nullable|array',
                'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if (!empty($this->additional_images)) {
                foreach ($this->additional_images as $image) {
                    if ($image instanceof TemporaryUploadedFile) {
                        $path = $image->store('projects', 'public');
                        ProjectImage::create([
                            'project_id' => $this->project->id,
                            'path' => $path,
                            'alt' => null,
                            'order' => null,
                        ]);
                    }
                }
                $this->existing_images = $this->project->fresh()->images;
                $this->reset('additional_images');
                session()->flash('status', 'Images supplémentaires ajoutées avec succès.');
            }
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->errors());
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout des images supplémentaires: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de l\'ajout des images supplémentaires.');
        }
    }

    public function deleteImage(int $imageId): void
    {
        try {
            $image = ProjectImage::findOrFail($imageId);
            if ($image->project_id === $this->project->id) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
                $this->existing_images = $this->project->fresh()->images;
                session()->flash('status', 'Image supprimée avec succès.');
            } else {
                session()->flash('error', 'Image non associée à ce projet.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'image: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la suppression de l\'image.');
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.edit-project');
    }
}