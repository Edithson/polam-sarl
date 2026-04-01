@if (isset($laws) && !$laws->isEmpty())

<section class="py-20 bg-slate-50 dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 dark:text-white mb-4">
                Cadre Légal & <span class="text-emerald-500">Réglementations</span>
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg">
                Consultez et téléchargez les textes de lois officiels régissant la gestion des archives et de l'information au Cameroun et à l'international.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($laws as $law)
            <div class="law-card group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300">
                <div class="flex items-start justify-between mb-6">
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded">{{ pathinfo($law->document_path, PATHINFO_EXTENSION) }}</span>
                </div>

                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3 group-hover:text-emerald-500 transition-colors">
                    {{ Str::limit(strip_tags($law->description), 30) }}
                </h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 line-clamp-2">
                    {{ Str::limit(strip_tags($law->description), 40) }}
                </p>

                <div class="flex items-center gap-4">
                    <a href="{{ Storage::url($law->document_path) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 bg-slate-900 dark:bg-white dark:text-slate-900 text-white py-3 rounded-xl font-semibold text-sm hover:bg-emerald-600 dark:hover:bg-emerald-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lire
                    </a>
                    <a href="{{ Storage::url($law->document_path) }}" download class="p-3 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                </div>
            </div>
            @empty
                {{-- RAS --}}
            @endforelse
        </div>
    </div>
</section>

<script>
    // Petit script pour filtrer les cartes par titre
    document.addEventListener('DOMContentLoaded', () => {
        // Si tu ajoutes un <input id="lawSearch">
        const searchInput = document.getElementById('lawSearch');
        const cards = document.querySelectorAll('.law-card');

        if(searchInput) {
            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                cards.forEach(card => {
                    const title = card.querySelector('h3').innerText.toLowerCase();
                    const desc = card.querySelector('p').innerText.toLowerCase();

                    if(title.includes(term) || desc.includes(term)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endif
