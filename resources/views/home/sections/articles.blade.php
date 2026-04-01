<section class="py-20 bg-slate-50 overflow-hidden">
    <div class="text-center max-w-3xl mx-auto px-6 mb-16">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('media/img/logo/logo3.png') }}" alt="Logo CINV-COR" class="h-14 w-auto">
        </div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Focus <span class="text-green-600">Expertise</span></h2>
        <p class="text-slate-500 mt-3 text-lg">Découvrez nos dernières réflexions sur l'ingénierie documentaire et la gestion des flux.</p>
    </div>

    <div class="viewport-stack relative h-[600px] md:h-[500px] w-full flex items-center justify-center" id="articleStack" style="perspective: 2000px;">
        @forelse ($articles->take(3) as $index => $article)
            <article class="article-card absolute w-[90%] max-w-[750px] h-[450px] md:h-[400px] bg-white rounded-[32px] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.25,1,0.3,1)] cursor-pointer flex flex-col md:flex-row {{ $index === 0 ? 'active' : ($index === 1 ? 'next' : 'prev') }}"
                     onclick="manualNav({{ $index }})"
                     data-index="{{ $index }}">

                <div class="p-8 md:p-10 flex-1 flex flex-col justify-center {{ $index % 2 != 0 ? 'md:order-last' : '' }}">
                    <span class="text-green-600 font-bold text-[10px] tracking-[0.2em] uppercase mb-3">
                        {{ $article->category->name ?? 'Expertise' }}
                    </span>
                    <h3 class="text-xl md:text-2xl font-extrabold mb-3 leading-tight text-slate-800">
                        {{ Str::limit(strip_tags($article->title), 45) }}
                    </h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        {{ Str::limit(strip_tags($article->content), 130) }}
                    </p>

                    <div class="flex items-center justify-between mt-auto">
                        <div class="flex items-center gap-3 text-[11px] font-bold text-slate-400 uppercase">
                            <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span>{{ $article->user->name ?? 'Rédaction' }}</span>
                        </div>
                        <a href="{{ route('home.article.show', $article->slug) }}" class="text-green-600 font-bold text-sm hover:translate-x-1 transition-transform">
                            Lire →
                        </a>
                    </div>
                </div>

                <div class="card-image w-full md:w-1/3 h-48 md:h-full bg-slate-100 relative overflow-hidden">
                    @if($article->picture)
                        <img src="{{ asset('storage/' . $article->picture) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                            <svg class="w-12 h-12 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="progress-bar absolute bottom-0 left-0 h-1.5 bg-green-500 w-0 transition-none" id="pb-{{ $index }}"></div>
            </article>
        @empty
            <div class="text-center text-slate-400">
                <p>Aucun article disponible pour le moment.</p>
            </div>
        @endforelse
    </div>

    @if($articles->count() > 0)
    <div class="flex justify-center gap-2 mt-12">
        @foreach($articles->take(3) as $index => $article)
            <button onclick="manualNav({{ $index }})"
                    class="nav-dot h-2 rounded-full transition-all duration-500 {{ $index === 0 ? 'w-8 bg-green-600' : 'w-2 bg-green-200' }}"
                    id="dot-{{ $index }}"></button>
        @endforeach
    </div>
    {{-- centre le bouton --}}
    <div class="w-full justify-center text-center mt-8">
        <a href="{{ route('article') }}" class="bg-emerald-500 text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-emerald-400 transition-colors justify-center">Voir tous nos articles</a>
    </div>
    @endif
</section>

<style>
    /* Classes d'état pour le stack 3D */
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
                dots[i].classList.remove('w-8', 'bg-green-600');
                dots[i].classList.add('w-2', 'bg-green-200');

                if (i === current) {
                    card.classList.add('active');
                    dots[i].classList.add('w-8', 'bg-green-600');
                    dots[i].classList.remove('bg-green-200');
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
