<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Laws;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public Laws $laws; // Reçoit l'instance du modèle depuis la vue Blade
    public string $title = '';
    public string $description = '';
    public $document; // Nouveau document optionnel
    public $oldDocumentPath;

    public function mount(Laws $law)
    {
        $this->laws = $law;
        $this->title = $law->title;
        $this->description = $law->description;
        $this->oldDocumentPath = $law->document_path;
    }

    public function update()
    {
        // 1. Validation
        $this->validate([
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:10',
            // Le document est optionnel ici (nullable)
            'document' => 'nullable|mimes:pdf,jpg,jpeg,png|extensions:pdf,jpg,jpeg,png|max:4096',
        ]);

        // 2. Gestion du document (On ne remplace que si un nouveau est fourni)
        if ($this->document) {
            // Suppression physique de l'ancien fichier
            if ($this->oldDocumentPath && Storage::disk('public')->exists($this->oldDocumentPath)) {
                Storage::disk('public')->delete($this->oldDocumentPath);
            }

            // Sauvegarde du nouveau fichier
            $path = $this->document->store('laws', 'public');
        } else {
            // Si aucun nouveau document n'est fourni, on garde l'ancien chemin
            $path = $this->oldDocumentPath;
        }

        // 3. Mise à jour
        $this->laws->update([
            'title' => $this->title,
            'description' => $this->description,
            'document_path' => $path,
        ]);
        $this->oldDocumentPath = $path;

        session()->flash('status', 'La loi a été mise à jour avec succès !');

        return redirect()->route('laws.index_admin');
    }
}; ?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-sm border border-slate-200">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Modifier la loi</h2>
        <p class="text-slate-500 text-sm">Mettez à jour les informations ou le document légal associé.</p>
    </div>

    <form wire:submit="update" class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Titre de la loi</label>
            <input wire:model="title" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
            @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
            <textarea wire:model="description" cols="30" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all"></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="p-4 bg-slate-50 rounded-xl border border-dashed border-slate-300">
            <label class="block text-sm font-bold text-slate-700 mb-3">Document légal</label>

            @if($oldDocumentPath)
                <div class="flex items-center gap-3 mb-4 p-3 bg-white rounded-lg border border-slate-200 shadow-sm">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Fichier actuel</p>
                        <p class="text-sm text-slate-800 truncate">{{ basename($oldDocumentPath) }}</p>
                    </div>
                    <a href="{{ Storage::url($oldDocumentPath) }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:underline">Voir</a>
                </div>
            @endif

            <input wire:model="document" type="file" accept=".pdf, .jpg, .jpeg, .png" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
            <p class="mt-2 text-[11px] text-slate-400">Laissez vide pour conserver le document actuel. PDF ou Image (Max 4MB).</p>
            @error('document') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" wire:loading.attr="disabled" class="flex items-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-600 transition-all shadow-lg active:scale-95 disabled:opacity-70">
                <svg wire:loading class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove>Mettre à jour</span>
                <span wire:loading>Mise à jour...</span>
            </button>
        </div>
    </form>
</div>
