<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Laws;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Enums\AccessLevel;

new class extends Component {
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public $document;

    public function save()
    {
        //vérification des autorisations et validation des données
        if (auth()->user()->cannot('create', Laws::class)) {
            return redirect()->route('laws.index')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour créer une loi.");
        }

        // 1. Validation
        $this->validate([
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:10',
            // le document est obligatoire et foit etre une image ou un pdf
            'document' => 'required|mimes:pdf,jpg,jpeg,png|extensions:pdf,jpg,jpeg,png|max:2048',
        ]);

        // 2. Gestion du document
        $path = $this->document
            ? $this->document->store('laws', 'public')
            : null;

        // 3. Création en base de données
        // L'ID et le Slug sont gérés par le modèle Laws
        Laws::create([
            'title' => $this->title,
            'description' => $this->description,
            'document_path' => $path,
        ]);

        // 4. Notification et Redirection
        session()->flash('status', 'La loi a été publiée avec succès !');

        return redirect()->route('laws.index_admin');

    }
}; ?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-sm border border-slate-200">
    <form wire:submit="save" class="space-y-6">

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Titre de la loi</label>
            <input wire:model="title" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all" placeholder="Entrez un titre percutant...">
            @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Description</label>
            <textarea wire:model="description" name="description" id="description" cols="30" rows="5" placeholder="..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all"></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Document (PDF, Image)</label>
            <input wire:model="document" type="file" accept=".pdf, .jpg, .jpeg, .png" class="w-full">
            @error('document') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="flex items-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-600 transition-all shadow-lg active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">

                <svg wire:loading class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span wire:loading.remove>Enregistrer la loi</span>
                <span wire:loading>Enregistrement...</span>
            </button>
        </div>
    </form>
</div>

