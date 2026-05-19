<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use App\Enums\AccessLevel;

new class extends Component {
    use WithFileUploads;

    public Article $article;
    public string $title;
    public string $content;
    public $newPicture;
    public string $oldPicture;
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

<div class="max-w-4xl mx-auto p-6 bg-white rounded-sm shadow-sm border border-[#E8EAF0] font-['DM_Sans',sans-serif]">

    <div class="flex items-center gap-2 mb-6">
        <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
        <h2 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider">Modifier l'article</h2>
    </div>

    <form wire:submit="update" class="space-y-6">
        <div>
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Titre de l'article</label>
            <input wire:model="title" type="text" class="w-full px-4 py-2.5 rounded-sm border border-[#E8EAF0] bg-[#F5F6FA] text-sm text-gray-900 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
            @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Image de couverture</label>
            <div class="flex items-center gap-4">
                @if($oldPicture && !$newPicture)
                    <div class="relative w-32 h-20 rounded-sm overflow-hidden border border-[#E8EAF0]">
                        <img src="{{ asset('storage/' . $oldPicture) }}" class="object-cover w-full h-full">
                        <div class="absolute inset-0 bg-gray-900/40 flex items-center justify-center font-['Syne',sans-serif] text-white text-[9px] font-bold uppercase tracking-wider">Actuelle</div>
                    </div>
                @endif

                <label class="flex-1 flex flex-col items-center justify-center h-20 border-2 border-[#E8EAF0] border-dashed rounded-sm cursor-pointer bg-[#F5F6FA] hover:bg-[#FFF7ED] hover:border-orange-300 transition-all">
                    <span class="font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ $newPicture ? 'Image prête !' : 'Remplacer l\'image' }}</span>
                    <input type="file" wire:model="newPicture" class="hidden" />
                </label>
            </div>
            @error('newPicture') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
                    content_style: `
                        body { font-family: 'DM Sans', sans-serif; font-size: 14px; color: #111111; }
                        .mce-content-body:focus { outline: none !important; }
                    `,
                    setup: (editor) => {
                        editor.on('init', () => { editor.setContent(this.content); });
                        editor.on('focus', () => {
                            editor.getContainer().style.borderColor = '#F97316';
                            editor.getContainer().style.boxShadow = '0 0 0 1px #F97316';
                        });
                        editor.on('blur', () => {
                            editor.getContainer().style.borderColor = '#E8EAF0';
                            editor.getContainer().style.boxShadow = 'none';
                        });
                        editor.on('change', () => { this.content = editor.getContent(); });
                    }
                });
            }
        }" x-init="initTiny()">
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Contenu</label>
            <textarea x-ref="tinydisplay"></textarea>
            @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        @if(auth()->user()->hasPermission('articles', \App\Enums\AccessLevel::FULL))
            <div class="flex items-center gap-3 py-2">
                <button type="button" @click="$wire.public = !$wire.public" :class="$wire.public ? 'bg-orange-500' : 'bg-gray-200'" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none">
                    <span :class="$wire.public ? 'translate-x-5' : 'translate-x-1'" class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform"></span>
                </button>
                <span class="font-['Syne',sans-serif] text-[10px] font-bold tracking-wider uppercase text-gray-700">Article public</span>
            </div>
        @else
            <div class="flex items-center gap-3 p-3 bg-[#F5F6FA] rounded-sm border border-dashed border-[#E8EAF0]">
                <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-gray-200 cursor-not-allowed">
                    <span class="translate-x-1 inline-block h-3 w-3 transform rounded-full bg-white"></span>
                </div>
                <div>
                    <span class="block font-['Syne',sans-serif] text-[10px] font-bold tracking-wider uppercase text-gray-500">Publication restreinte</span>
                    <span class="block text-[10px] text-gray-400 mt-0.5">Soumis à validation.</span>
                </div>
                <div x-init="$wire.public = false"></div>
            </div>
        @endif

        <div class="flex justify-end items-center gap-4 pt-6 border-t border-[#E8EAF0]">
            <a href="{{ route('articles.index') }}" class="font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-orange-500 transition-colors">Annuler</a>
            <button type="submit" class="bg-orange-500 text-white px-6 py-2.5 rounded-sm font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:bg-[#EA580C] shadow-sm active:scale-[0.98] transition-all">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
