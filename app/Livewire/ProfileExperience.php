<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileExperience extends Component
{
    public Collection $experiences;

    public ?int $experienceId = null;
    public ?string $company = null;
    public ?string $position = null;
    public ?string $location = null;
    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?string $description = null;
    public bool $is_current = false;

    public bool $isEditing = false;
    public bool $showForm = false;

    protected array $rules = [
        'company' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'description' => 'nullable|string',
        'is_current' => 'boolean',
    ];

    protected array $messages = [
        'company.required' => 'Le nom de l\'entreprise est requis.',
        'position.required' => 'Le poste est requis.',
        'start_date.required' => 'La date de début est requise.',
        'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
    ];

    public function mount(): void
    {
        $this->loadExperiences();
    }

    public function loadExperiences(): void
    {
        try {
            $user = Auth::guard('admin')->user();
            $profile = $user?->profile;

            $this->experiences = $profile->experiences()->orderBy('start_date', 'desc')->get();
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement des expériences: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors du chargement des expériences.');
        }
    }

    public function toggleForm(): void
    {
        $this->resetForm();
        $this->showForm = !$this->showForm;
        $this->isEditing = false;
    }

    public function resetForm(): void
    {
        $this->reset([
            'experienceId',
            'company',
            'position',
            'location',
            'start_date',
            'end_date',
            'description',
            'is_current'
        ]);
        $this->resetValidation();
    }

    public function edit($id): void
    {
        try {
            $this->isEditing = true;
            $this->showForm = true;

            $experience = Experience::findOrFail($id);

            if ($experience->profile->user_id !== Auth::guard('admin')->id()) {
                throw new Exception('Vous n\'êtes pas autorisé à modifier cette expérience.');
            }

            $this->experienceId = $experience->id;
            $this->company = $experience->company;
            $this->position = $experience->position;
            $this->location = $experience->location;
            $this->start_date = $experience->start_date?->format('Y-m-d');
            $this->end_date = $experience->end_date?->format('Y-m-d');
            $this->description = $experience->description;
            $this->is_current = $experience->is_current ?? false;
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'édition d\'une expérience: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de l\'édition de l\'expérience.');
        }
    }

    public function save(): void
    {
        try {
            // Ajuster la validation de end_date si is_current est true
            if ($this->is_current) {
                $this->rules['end_date'] = 'nullable';
                $this->end_date = null;
            }

            $this->validate();

            $user = Auth::guard('admin')->user();
            $profile = $user?->profile;

            if (!$profile) {
                throw new Exception('Profil non trouvé.');
            }

            $data = [
                'company' => $this->company,
                'position' => $this->position,
                'location' => $this->location ?: null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'description' => $this->description ?: null,
                'is_current' => $this->is_current,
            ];

            if ($this->isEditing) {
                $experience = Experience::findOrFail($this->experienceId);

                if ($experience->profile->user_id !== Auth::guard('admin')->id()) {
                    throw new Exception('Vous n\'êtes pas autorisé à modifier cette expérience.');
                }

                $experience->update($data);
                session()->flash('status', 'Expérience mise à jour avec succès.');
            } else {
                $profile->experiences()->create($data);
                session()->flash('status', 'Expérience ajoutée avec succès.');
            }

            $this->resetForm();
            $this->showForm = false;
            $this->loadExperiences();
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'enregistrement d\'une expérience: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de l\'enregistrement de l\'expérience.');
        }
    }

    public function delete($id): void
    {
        try {
            $experience = Experience::findOrFail($id);

            if ($experience->profile->user_id !== Auth::guard('admin')->id()) {
                throw new Exception('Vous n\'êtes pas autorisé à supprimer cette expérience.');
            }

            $experience->delete();

            session()->flash('status', 'Expérience supprimée avec succès.');
            $this->loadExperiences();
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression d\'une expérience: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la suppression de l\'expérience.');
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.profile-experience');
    }
}