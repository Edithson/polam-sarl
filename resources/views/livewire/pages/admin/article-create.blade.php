<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Enums\AccessLevel;

new class extends Component {
    use WithFileUploads;

    public string $title = '';
    public string $content = ''; // Sera synchronisé via TinyMCE
    public $picture;
    public bool $public = false;

    public function save()
    {
        //vérification des autorisations et validation des données
        if (auth()->user()->cannot('create', Article::class)) {
            return redirect()->route('articles.index')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour créer un article.");
        }

        // 1. Validation
        $this->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'picture' => 'nullable|image|max:2048', // 2MB Max
        ]);

        // 2. Gestion de l'image de couverture
        $path = $this->picture
            ? $this->picture->store('articles', 'public')
            : null;

        // 3. Gestion de la sécurité sur la publication
        // Seul un utilisateur avec FULL peut décider du statut 'public'
        // Les autres (AUTHOR) voient leur article forcé à 'false' (en attente)
        $isPublic = auth()->user()->hasPermission('articles', AccessLevel::FULL)
                    ? $this->public
                    : false;

        // 3. Création en base de données
        // L'ID et le Slug sont gérés par le modèle Article
        Article::create([
            'title' => $this->title,
            'content' => $this->content,
            'picture' => $path,
            'public' => $isPublic,
            'user_id' => Auth::id(), //
        ]);

        // 4. Notification et Redirection
        session()->flash('status', 'L\'article a été publié avec succès !');

        return redirect()->route('articles.index');
    }
}; ?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-sm border border-slate-200">
    <form wire:submit="save" class="space-y-6">

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Titre de l'article</label>
            <input wire:model="title" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all" placeholder="Entrez un titre percutant...">
            @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Image de couverture</label>
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                    @if ($picture)
                        <img src="{{ $picture->temporaryUrl() }}" class="h-full w-full object-cover rounded-2xl">
                    @else
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm text-slate-500">Cliquez pour uploader (JPG, PNG)</p>
                        </div>
                    @endif
                    <input type="file" wire:model="picture" class="hidden" />
                </label>
            </div>
            @error('picture') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div wire:ignore x-data="{
    content: @entangle('content'),
    initTiny() {
        tinymce.init({
            target: $refs.tinydisplay,
            language: 'fr_FR',
            // On ne garde que les plugins gratuits pour retirer le badge Trial
            plugins: 'advlist autolink lists link image table code help wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | table | removeformat',
            promotion: false, // Désactive explicitement les messages de promotion
            branding: false,

            content_style: `
                body { font-family: 'Poppins', sans-serif; font-size: 14px; }
                .mce-content-body:focus { outline: none !important; }
            `,
            setup: (editor) => {
                // Changement de bordure au focus
                editor.on('focus', () => {
                    editor.getContainer().style.borderColor = '#10b981'; // emerald-500
                    editor.getContainer().style.ring = '4px';
                    editor.getContainer().style.boxShadow = '0 0 0 4px rgba(16, 185, 129, 0.1)';
                });
                editor.on('blur', () => {
                    editor.getContainer().style.borderColor = '#e2e8f0'; // slate-200
                    editor.getContainer().style.boxShadow = 'none';
                });

                editor.on('change', () => {
                    this.content = editor.getContent();
                });
            }
        });
    }
}" x-init="initTiny()">
    <textarea x-ref="tinydisplay"></textarea>
</div>

        {{-- Vérification du droit FULL pour le module 'articles' --}}
        @if(auth()->user()->hasPermission('articles', \App\Enums\AccessLevel::FULL))
            <div class="flex items-center gap-3">
                <button type="button"
                    @click="$wire.public = !$wire.public"
                    :class="$wire.public ? 'bg-emerald-600' : 'bg-slate-300'"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none">
                    <span :class="$wire.public ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                </button>
                <span class="text-sm font-medium text-slate-700">Rendre l'article public</span>
            </div>
        @else
            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                <div class="relative inline-flex h-6 w-11 items-center rounded-full bg-slate-200 cursor-not-allowed">
                    <span class="translate-x-1 inline-block h-4 w-4 transform rounded-full bg-white"></span>
                </div>
                <div>
                    <span class="block text-sm font-bold text-slate-500">Publication restreinte</span>
                    <span class="block text-xs text-slate-400">Votre article sera soumis à validation avant d'être publié.</span>
                </div>
                {{-- On s'assure que la propriété Livewire reste à false pour la sécurité visuelle --}}
                <div x-init="$wire.public = false"></div>
            </div>
        @endif

        <div class="flex justify-end pt-4">
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="flex items-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-600 transition-all shadow-lg active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">

                <svg wire:loading class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span wire:loading.remove>Enregistrer l'article</span>
                <span wire:loading>Enregistrement...</span>
            </button>
        </div>
    </form>
</div>

