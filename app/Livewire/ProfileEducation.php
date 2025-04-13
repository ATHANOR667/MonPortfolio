<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileEducation extends Component
{
    public Collection $educations;

    public ?int $educationId = null;
    public ?string $institution = null;
    public ?string $degree = null;
    public ?string $field_of_study = null;
    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?string $location = null;
    public ?string $description = null;
    public bool $is_current = false;

    public bool $isEditing = false;
    public bool $showForm = false;

    protected array $rules = [
        'institution' => 'required|string|max:255',
        'degree' => 'required|string|max:255',
        'field_of_study' => 'nullable|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'location' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'is_current' => 'boolean',
    ];

    protected array $messages = [
        'institution.required' => 'Le nom de l\'établissement est requis.',
        'degree.required' => 'Le diplôme est requis.',
        'start_date.required' => 'La date de début est requise.',
        'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
    ];

    public function mount(): void
    {
        $this->loadEducations();
    }

    public function loadEducations(): void
    {
        try {
            $user = Auth::guard('admin')->user();
            $profile = $user?->profile;

            $this->educations = $profile->educations()->orderBy('start_date', 'desc')->get();
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement des formations: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors du chargement des formations.');
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
            'educationId',
            'institution',
            'degree',
            'field_of_study',
            'start_date',
            'end_date',
            'location',
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

            $education = Education::findOrFail($id);

            if ($education->profile->user_id !== Auth::guard('admin')->id()) {
                throw new Exception('Vous n\'êtes pas autorisé à modifier cette formation.');
            }

            $this->educationId = $education->id;
            $this->institution = $education->institution;
            $this->degree = $education->degree;
            $this->field_of_study = $education->field_of_study;
            $this->start_date = $education->start_date?->format('Y-m-d');
            $this->end_date = $education->end_date?->format('Y-m-d');
            $this->location = $education->location;
            $this->description = $education->description;
            $this->is_current = $education->is_current ?? false;
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'édition d\'une formation: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de l\'édition de la formation.');
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
                'institution' => $this->institution,
                'degree' => $this->degree,
                'field_of_study' => $this->field_of_study ?: null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'location' => $this->location ?: null,
                'description' => $this->description ?: null,
                'is_current' => $this->is_current,
            ];

            if ($this->isEditing) {
                $education = Education::findOrFail($this->educationId);

                if ($education->profile->user_id !== Auth::guard('admin')->id()) {
                    throw new Exception('Vous n\'êtes pas autorisé à modifier cette formation.');
                }

                $education->update($data);
                session()->flash('status', 'Formation mise à jour avec succès.');
            } else {
                $profile->educations()->create($data);
                session()->flash('status', 'Formation ajoutée avec succès.');
            }

            $this->resetForm();
            $this->showForm = false;
            $this->loadEducations();
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'enregistrement d\'une formation: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de l\'enregistrement de la formation.');
        }
    }

    public function delete($id): void
    {
        try {
            $education = Education::findOrFail($id);

            if ($education->profile->user_id !== Auth::guard('admin')->id()) {
                throw new Exception('Vous n\'êtes pas autorisé à supprimer cette formation.');
            }

            $education->delete();

            session()->flash('status', 'Formation supprimée avec succès.');
            $this->loadEducations();
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression d\'une formation: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue lors de la suppression de la formation.');
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.profile-education');
    }
}