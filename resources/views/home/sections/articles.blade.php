<section class="py-20 overflow-hidden bg-[var(--dark-2)] transition-colors duration-300">
    <div class="text-center max-w-3xl mx-auto px-6 mb-16">
        <div class="flex justify-center mb-6 text-[var(--orange)]">
            <svg width="48" height="48" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="19" cy="19" r="17" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 2"/>
              <line x1="12" y1="19" x2="26" y2="19" stroke="currentColor" stroke-width="1.5"/>
              <circle cx="27" cy="19" r="2" fill="currentColor"/>
              <circle cx="19" cy="13" r="2" fill="currentColor"/>
              <circle cx="19" cy="25" r="2" fill="currentColor"/>
              <line x1="19" y1="12" x2="19" y2="14" stroke="currentColor" stroke-width="1.5"/>
              <line x1="19" y1="24" x2="19" y2="26" stroke="currentColor" stroke-width="1.5"/>
            </svg>
        </div>
        <div class="section-tag justify-center mb-2">Nos actualités</div>
        <h2 class="text-4xl md:text-5xl font-display text-[var(--white)] tracking-wide">
            Focus <span class="text-[var(--orange)]">Expertise</span>
        </h2>
        <p class="text-[var(--gray-light)] mt-3 text-sm md:text-base font-light">
            Découvrez nos dernières réflexions sur l'innovation technologique et nos interventions sur le terrain.
        </p>
    </div>

    <div class="viewport-stack relative h-[600px] md:h-[500px] w-full flex items-center justify-center" id="articleStack" style="perspective: 2000px;">
        @forelse ($articles->take(3) as $index => $article)
            {{-- La carte utilise var(--dark-3) pour le fond et un border mixé avec l'orange --}}
            <article class="article-card absolute w-[90%] max-w-[750px] h-[450px] md:h-[400px] bg-[var(--dark-3)] rounded-[4px] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] border border-[color-mix(in_srgb,var(--orange)_15%,transparent)] overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.25,1,0.3,1)] cursor-pointer flex flex-col md:flex-row {{ $index === 0 ? 'active' : ($index === 1 ? 'next' : 'prev') }}"
                     onclick="manualNav({{ $index }})"
                     data-index="{{ $index }}">

                <div class="p-8 md:p-10 flex-1 flex flex-col justify-center {{ $index % 2 != 0 ? 'md:order-last' : '' }}">
                    <span class="text-[var(--orange)] font-heading font-bold text-[10px] tracking-[0.2em] uppercase mb-3">
                        {{ $article->category->name ?? 'Expertise' }}
                    </span>
                    <h3 class="text-xl md:text-2xl font-heading font-bold mb-3 leading-tight text-[var(--white)]">
                        {{ Str::limit(strip_tags($article->title), 45) }}
                    </h3>
                    <p class="text-[var(--gray)] text-sm leading-relaxed mb-6 font-light">
                        {{ Str::limit(strip_tags($article->content), 130) }}
                    </p>

                    <div class="flex items-center justify-between mt-auto">
                        <div class="flex items-center gap-3 text-[10px] font-heading font-bold text-[var(--gray-light)] uppercase tracking-wider">
                            <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
                            <span class="w-1.5 h-1.5 bg-[var(--orange)] rounded-full"></span>
                            <span>{{ $article->user->name ?? 'Rédaction' }}</span>
                        </div>
                        <a href="{{ route('home.article.show', $article->slug) }}" class="text-[var(--orange)] font-heading font-bold text-xs uppercase tracking-widest hover:translate-x-1 transition-transform">
                            Lire →
                        </a>
                    </div>
                </div>

                <div class="card-image w-full md:w-1/3 h-48 md:h-full bg-[var(--dark-4)] relative overflow-hidden">
                    @if($article->picture)
                        <img src="{{ asset('storage/' . $article->picture) }}" alt="{{ $article->title }}" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity">
                    @else
                        {{-- Image de remplacement stylisée Tech --}}
                        <div class="w-full h-full bg-[color-mix(in_srgb,var(--orange)_5%,transparent)] flex items-center justify-center">
                            <svg class="w-12 h-12 text-[var(--orange)] opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="progress-bar absolute bottom-0 left-0 h-1 bg-[var(--orange)] w-0 transition-none" id="pb-{{ $index }}"></div>
            </article>
        @empty
            <div class="text-center text-[var(--gray-light)]">
                <p>Aucun article disponible pour le moment.</p>
            </div>
        @endforelse
    </div>

    @if($articles->count() > 0)
    <div class="flex justify-center gap-2 mt-12">
        @foreach($articles->take(3) as $index => $article)
            <button onclick="manualNav({{ $index }})"
                    class="nav-dot h-1.5 rounded-full transition-all duration-500 {{ $index === 0 ? 'active-dot' : '' }}"
                    id="dot-{{ $index }}"></button>
        @endforeach
    </div>

    <div class="w-full flex justify-center text-center mt-10">
        <a href="{{ route('article') }}" class="btn-ghost">Voir tous nos articles</a>
    </div>
    @endif
</section>

<style>
    /* CSS des points de navigation pour correspondre au thème dynamique */
    .nav-dot {
        width: 0.5rem;
        background-color: color-mix(in srgb, var(--orange) 20%, transparent);
    }
    .nav-dot.active-dot {
        width: 2rem;
        background-color: var(--orange);
    }

    /* Classes d'état pour le stack 3D (Inchangées) */
    .article-card.active { transform: translateZ(100px); z-index: 40; opacity: 1; }
    .article-card.next { transform: translateX(35%) translateZ(-300px) rotateY(-25deg) scale(0.85); z-index: 30; opacity: 0.5; }
    .article-card.prev { transform: translateX(-35%) translateZ(-300px) rotateY(25deg) scale(0.85); z-index: 30; opacity: 0.5; }
    .article-card.hidden { transform: translateZ(-600px) scale(0.6); opacity: 0; z-index: 10; }

    @media (max-width: 768px) {
        .article-card.next { transform: translateY(40px) translateZ(-200px) scale(0.9); opacity: 0.3; }
        .article-card.prev { transform: translateY(-40px) translateZ(-200px) scale(0.9); opacity: 0.3; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let current = 0;
        const cards = document.querySelectorAll('.article-card');
        const dots = document.querySelectorAll('.nav-dot');
        const total = cards.length;
        const duration = 7000; // 7 secondes
        let start = Date.now();

        if(total === 0) return;

        function updateDisplay() {
            cards.forEach((card, i) => {
                card.classList.remove('active', 'prev', 'next', 'hidden');
                // Nettoyage simplifié des dots
                dots[i].classList.remove('active-dot');

                if (i === current) {
                    card.classList.add('active');
                    dots[i].classList.add('active-dot');
                } else if (i === (current + 1) % total) {
                    card.classList.add('next');
                } else if (i === (current - 1 + total) % total) {
                    card.classList.add('prev');
                } else {
                    card.classList.add('hidden');
                }
            });
            start = Date.now();
        }

        window.manualNav = function(index) {
            current = index;
            updateDisplay();
        };

        function step() {
            const elapsed = Date.now() - start;
            const progress = Math.min((elapsed / duration) * 100, 100);

            // Gestion des barres de progression
            document.querySelectorAll('.progress-bar').forEach(bar => bar.style.width = '0%');
            const activeBar = document.getElementById(`pb-${current}`);
            if(activeBar) activeBar.style.width = `${progress}%`;

            if (progress >= 100) {
                current = (current + 1) % total;
                updateDisplay();
            }
            requestAnimationFrame(step);
        }

        updateDisplay();
        requestAnimationFrame(step);
    });
</script>
