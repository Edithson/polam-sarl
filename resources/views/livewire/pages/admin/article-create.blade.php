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
    public string $content = '';
    public $picture;
    public bool $public = false;

    public function save()
    {
        if (auth()->user()->cannot('create', Article::class)) {
            return redirect()->route('articles.index')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour créer un article.");
        }

        $this->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'picture' => 'nullable|image|max:2048',
        ]);

        $path = $this->picture
            ? $this->picture->store('articles', 'public')
            : null;

        $isPublic = auth()->user()->hasPermission('articles', AccessLevel::FULL)
                    ? $this->public
                    : false;

        Article::create([
            'title' => $this->title,
            'content' => $this->content,
            'picture' => $path,
            'public' => $isPublic,
            'user_id' => Auth::id(),
        ]);

        session()->flash('status', 'L\'article a été publié avec succès !');
        return redirect()->route('articles.index');
    }
}; ?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-sm shadow-sm border border-[#E8EAF0] font-['DM_Sans',sans-serif]">

    <div class="flex items-center gap-2 mb-6">
        <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
        <h2 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider">Créer un article</h2>
    </div>

    <form wire:submit="save" class="space-y-6">

        <div>
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Titre de l'article</label>
            <input wire:model="title" type="text" class="w-full px-4 py-2.5 rounded-sm border border-[#E8EAF0] bg-[#F5F6FA] text-sm text-gray-900 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all" placeholder="Titre percutant...">
            @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Image de couverture</label>
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-[#E8EAF0] border-dashed rounded-sm cursor-pointer bg-[#F5F6FA] hover:bg-[#FFF7ED] hover:border-orange-300 transition-all">
                    @if ($picture)
                        <img src="{{ $picture->temporaryUrl() }}" class="h-full w-full object-cover rounded-sm">
                    @else
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-6 h-6 mb-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <p class="font-['Syne',sans-serif] text-[10px] font-bold tracking-wider uppercase text-gray-400">Cliquez pour uploader</p>
                            <p class="text-[10px] text-gray-400 mt-1">JPG, PNG (Max 2MB)</p>
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
                    plugins: 'advlist autolink lists link image table code help wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | table | removeformat',
                    promotion: false,
                    branding: false,
                    content_style: `
                        body { font-family: 'DM Sans', sans-serif; font-size: 14px; color: #111111; }
                        .mce-content-body:focus { outline: none !important; }
                    `,
                    setup: (editor) => {
                        editor.on('focus', () => {
                            editor.getContainer().style.borderColor = '#F97316';
                            editor.getContainer().style.boxShadow = '0 0 0 1px #F97316';
                        });
                        editor.on('blur', () => {
                            editor.getContainer().style.borderColor = '#E8EAF0';
                            editor.getContainer().style.boxShadow = 'none';
                        });
                        editor.on('change', () => {
                            this.content = editor.getContent();
                        });
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
                <button type="button"
                    @click="$wire.public = !$wire.public"
                    :class="$wire.public ? 'bg-orange-500' : 'bg-gray-200'"
                    class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none">
                    <span :class="$wire.public ? 'translate-x-5' : 'translate-x-1'" class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform"></span>
                </button>
                <span class="font-['Syne',sans-serif] text-[10px] font-bold tracking-wider uppercase text-gray-700">Rendre l'article public</span>
            </div>
        @else
            <div class="flex items-center gap-3 p-3 bg-[#F5F6FA] rounded-sm border border-dashed border-[#E8EAF0]">
                <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-gray-200 cursor-not-allowed">
                    <span class="translate-x-1 inline-block h-3 w-3 transform rounded-full bg-white"></span>
                </div>
                <div>
                    <span class="block font-['Syne',sans-serif] text-[10px] font-bold tracking-wider uppercase text-gray-500">Publication restreinte</span>
                    <span class="block text-[10px] text-gray-400 mt-0.5">L'article sera soumis à validation.</span>
                </div>
                <div x-init="$wire.public = false"></div>
            </div>
        @endif

        <div class="flex justify-end pt-6 border-t border-[#E8EAF0]">
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="flex items-center gap-2 bg-orange-500 text-white px-6 py-2.5 rounded-sm font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:bg-[#EA580C] transition-all shadow-sm active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed">

                <svg wire:loading class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span wire:loading.remove>Enregistrer</span>
                <span wire:loading>En cours...</span>
            </button>
        </div>
    </form>
</div>
