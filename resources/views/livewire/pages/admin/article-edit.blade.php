<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use App\Enums\AccessLevel;

new class extends Component {
    use WithFileUploads;

    public Article $article; // L'article passé par le contrôleur
    public string $title;
    public string $content;
    public $newPicture; // Pour la nouvelle image éventuelle
    public string $oldPicture; // Pour l'affichage de l'actuelle
    public bool $public;

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->content = $article->content;
        $this->oldPicture = $article->picture ?? '';
        $this->public = (bool) $article->public;
    }

    public function update()
    {
        if (auth()->user()->cannot('update', $this->article)) {
            return redirect()->route('articles.index')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour mettre à jour cet article.");
        }

        $this->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required',
            'newPicture' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        if ($this->newPicture) {
            // Supprimer l'ancienne image du stockage si elle existe
            if ($this->oldPicture) {
                Storage::disk('public')->delete($this->oldPicture);
            }
            $data['picture'] = $this->newPicture->store('articles', 'public');
        }

        $isPublic = auth()->user()->hasPermission('articles', AccessLevel::FULL)
                    ? $this->public
                    : false;
        $data['public'] = $isPublic;

        $this->article->update($data);

        session()->flash('status', 'Article mis à jour avec succès !');
        return redirect()->route('articles.index');
    }
}; ?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-sm border border-slate-200">
    <form wire:submit="update" class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Titre de l'article</label>
            <input wire:model="title" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Image de couverture</label>
            <div class="flex items-center gap-4 mb-4">
                @if($oldPicture && !$newPicture)
                    <div class="relative w-32 h-20 rounded-lg overflow-hidden border">
                        <img src="{{ asset('storage/' . $oldPicture) }}" class="object-cover w-full h-full">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-white text-[10px] font-bold uppercase">Actuelle</div>
                    </div>
                @endif

                <label class="flex-1 flex flex-col items-center justify-center h-20 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-emerald-50 transition-all">
                    <span class="text-sm text-slate-500">{{ $newPicture ? 'Image prête !' : 'Remplacer l\'image' }}</span>
                    <input type="file" wire:model="newPicture" class="hidden" />
                </label>
            </div>
        </div>

        <div wire:ignore x-data="{
            content: @entangle('content'),
            initTiny() {
                tinymce.init({
                    target: $refs.tinydisplay,
                    language: 'fr_FR',
                    plugins: 'advlist autolink lists link image table code help wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | table | removeformat',
                    promotion: false,
                    branding: false,
                    setup: (editor) => {
                        editor.on('init', () => { editor.setContent(this.content); });
                        editor.on('change', () => { this.content = editor.getContent(); });
                    }
                });
            }
        }" x-init="initTiny()">
            <textarea x-ref="tinydisplay"></textarea>
        </div>

        {{-- Vérification du droit FULL pour le module 'articles' --}}
        @if(auth()->user()->hasPermission('articles', \App\Enums\AccessLevel::FULL))
            <div class="flex items-center gap-3">
                <button type="button" @click="$wire.public = !$wire.public" :class="$wire.public ? 'bg-emerald-600' : 'bg-slate-300'" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                    <span :class="$wire.public ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                </button>
                <span class="text-sm font-medium">Article public</span>
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

        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('articles.index') }}" class="px-6 py-3 text-slate-500 font-bold">Annuler</a>
            <button type="submit" class="bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-700 shadow-lg active:scale-95 transition-all">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
