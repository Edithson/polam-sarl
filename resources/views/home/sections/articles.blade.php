<style>
    /* ══════════════════════════════════════
       SECTION WRAPPER
    ══════════════════════════════════════ */
    .articles-section {
        background: #0D0D0D;
        padding: 6rem 0;
        overflow: hidden;
        position: relative;
    }

    /* Grille circuit en fond */
    .articles-section::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(244,123,32,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(244,123,32,0.04) 1px, transparent 1px);
        background-size: 52px 52px;
        pointer-events: none;
    }

    /* Lueur ambiante */
    .articles-section::after {
        content: '';
        position: absolute;
        top: -200px; left: 50%;
        transform: translateX(-50%);
        width: 700px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(ellipse, rgba(244,123,32,0.08) 0%, transparent 65%);
        pointer-events: none;
    }

    /* ══════════════════════════════════════
       HEADER
    ══════════════════════════════════════ */
    .articles-header {
        text-align: center;
        max-width: 680px;
        margin: 0 auto 4rem;
        padding: 0 1.5rem;
        position: relative; z-index: 2;
    }

    .articles-badge {
        display: inline-flex; align-items: center; gap: 0.45rem;
        font-size: 0.7rem; font-weight: 700; letter-spacing: 0.14em;
        text-transform: uppercase; color: #F47B20;
        border: 1.5px solid rgba(244,123,32,0.35);
        border-radius: 50px; padding: 0.3rem 0.88rem;
        margin-bottom: 1.1rem;
    }
    .articles-badge::before { content: '●'; font-size: 0.42rem; }

    .articles-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 900;
        color: #ffffff;
        letter-spacing: -0.03em;
        line-height: 1.05;
        margin-bottom: 0.9rem;
    }

    .articles-title .accent { color: #F47B20; }

    .articles-subtitle {
        font-size: 1rem;
        color: rgba(255,255,255,0.45);
        line-height: 1.7;
    }

    /* ══════════════════════════════════════
       STACK 3D
    ══════════════════════════════════════ */
    .viewport-stack {
        position: relative;
        height: 440px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 2000px;
    }

    /* ══════════════════════════════════════
       CARTES
    ══════════════════════════════════════ */
    .article-card {
        position: absolute;
        width: 90%;
        max-width: 780px;
        height: 370px;
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        cursor: pointer;
        transition: all 0.7s cubic-bezier(0.25, 1, 0.3, 1);

        /* Fond sombre */
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.07);
        box-shadow: 0 24px 64px rgba(0,0,0,0.5);
    }

    /* États de la pile 3D */
    .article-card.active {
        transform: translateZ(80px);
        z-index: 40; opacity: 1;
        border-color: rgba(244,123,32,0.25);
        box-shadow: 0 24px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(244,123,32,0.15);
    }

    .article-card.next {
        transform: translateX(32%) translateZ(-260px) rotateY(-22deg) scale(0.86);
        z-index: 30; opacity: 0.45;
    }

    .article-card.prev {
        transform: translateX(-32%) translateZ(-260px) rotateY(22deg) scale(0.86);
        z-index: 30; opacity: 0.45;
    }

    .article-card.hidden {
        transform: translateZ(-600px) scale(0.6);
        opacity: 0; z-index: 10;
    }

    @media (max-width: 768px) {
        .viewport-stack { height: 480px; }
        .article-card {
            flex-direction: column;
            height: 420px;
        }
        .article-card.next {
            transform: translateY(38px) translateZ(-180px) scale(0.9);
            opacity: 0.25;
        }
        .article-card.prev {
            transform: translateY(-38px) translateZ(-180px) scale(0.9);
            opacity: 0.25;
        }
        .card-image {
            width: 100% !important;
            height: 160px !important;
            order: -1;
        }
    }

    /* ══════════════════════════════════════
       CONTENU CARTE
    ══════════════════════════════════════ */
    .card-body {
        flex: 1;
        padding: 2.2rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
    }

    .card-category {
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #F47B20;
        margin-bottom: 0.85rem;
        display: inline-flex; align-items: center; gap: 0.4rem;
    }

    .card-category::before {
        content: '';
        display: block;
        width: 14px; height: 2px;
        background: #F47B20;
        border-radius: 1px;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.3;
        letter-spacing: -0.02em;
        margin-bottom: 0.85rem;
        transition: color 0.25s;
    }

    .article-card.active:hover .card-title { color: #F47B20; }

    .card-excerpt {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.45);
        line-height: 1.7;
        margin-bottom: 1.75rem;
        /* Clamp à 3 lignes */
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255,255,255,0.07);
    }

    .card-meta {
        display: flex; align-items: center; gap: 0.6rem;
        font-size: 0.72rem; font-weight: 600;
        color: rgba(255,255,255,0.3);
        text-transform: uppercase; letter-spacing: 0.06em;
    }

    .card-meta-sep {
        width: 3px; height: 3px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        flex-shrink: 0;
    }

    .card-author-dot {
        width: 22px; height: 22px;
        border-radius: 50%;
        background: rgba(244,123,32,0.15);
        border: 1.5px solid rgba(244,123,32,0.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem; font-weight: 800;
        color: #F47B20; text-transform: uppercase;
        flex-shrink: 0;
    }

    .card-read-link {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.8rem; font-weight: 800;
        color: #F47B20; text-decoration: none;
        letter-spacing: 0.04em; text-transform: uppercase;
        transition: gap 0.25s, color 0.25s;
        pointer-events: auto;
    }

    .card-read-link:hover { gap: 0.65rem; }

    /* ══════════════════════════════════════
       IMAGE CÔTÉ DROIT
    ══════════════════════════════════════ */
    .card-image {
        width: 280px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        background: #242424;
    }

    .card-image img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .article-card.active:hover .card-image img { transform: scale(1.05); }

    /* Overlay latéral sur l'image */
    .card-image::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(to right, rgba(26,26,26,0.7) 0%, transparent 40%);
        z-index: 1; pointer-events: none;
    }

    /* Placeholder image */
    .card-img-placeholder {
        width: 100%; height: 100%;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 0.6rem;
        background: linear-gradient(135deg, #1A1A1A, #242424);
    }

    .card-img-placeholder svg { color: rgba(244,123,32,0.25); }

    /* ══════════════════════════════════════
       BARRE DE PROGRESSION
    ══════════════════════════════════════ */
    .progress-bar {
        position: absolute;
        bottom: 0; left: 0;
        height: 3px;
        background: linear-gradient(90deg, #F47B20, #FF9A45);
        width: 0;
        transition: none;
        z-index: 10;
    }

    /* ══════════════════════════════════════
       NAVIGATION DOTS
    ══════════════════════════════════════ */
    .nav-dots {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2.5rem;
        position: relative; z-index: 2;
    }

    .nav-dot {
        height: 6px;
        border-radius: 3px;
        border: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255,255,255,0.15);
        width: 6px;
    }

    .nav-dot.active-dot {
        width: 28px;
        background: #F47B20;
    }

    /* ══════════════════════════════════════
       CTA BAS
    ══════════════════════════════════════ */
    .articles-cta {
        text-align: center;
        margin-top: 2.5rem;
        position: relative; z-index: 2;
    }

    .articles-cta a {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: #F47B20; color: #fff;
        padding: 0.75rem 2rem; border-radius: 50px;
        font-weight: 700; font-size: 0.88rem; letter-spacing: 0.03em;
        text-decoration: none;
        transition: background 0.25s, transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 4px 20px rgba(244,123,32,0.3);
    }

    .articles-cta a:hover {
        background: #C55E00;
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(244,123,32,0.4);
    }

    /* ══════════════════════════════════════
       EMPTY STATE
    ══════════════════════════════════════ */
    .articles-empty {
        text-align: center;
        padding: 4rem 2rem;
        position: relative; z-index: 2;
    }

    .articles-empty-icon {
        width: 72px; height: 72px; border-radius: 50%;
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.07);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
    }
</style>

<section class="articles-section">
    {{-- ── Header ── --}}
    <div class="articles-header">
        <div class="articles-badge">Actualités & Blog</div>
        <h2 class="articles-title">
            Nos dernières <span class="accent">actualités</span>
        </h2>
        <p class="articles-subtitle">
            Conseils techniques, projets réalisés et tendances en installation électrique,
            énergie solaire et systèmes de sécurité.
        </p>
    </div>

    {{-- ── Stack 3D ── --}}
    <div class="viewport-stack" id="articleStack" style="perspective:2000px">

        @forelse ($articles->take(3) as $index => $article)

            <article class="article-card {{ $index === 0 ? 'active' : ($index === 1 ? 'next' : 'prev') }}"
                     onclick="manualNav({{ $index }})"
                     data-index="{{ $index }}">

                {{-- Corps texte --}}
                <div class="card-body {{ $index % 2 != 0 ? 'md-order-last' : '' }}">

                    <span class="card-category">
                        {{ $article->category->name ?? 'Actualité' }}
                    </span>

                    <h3 class="card-title">
                        {{ Str::limit(strip_tags($article->title), 55) }}
                    </h3>

                    <p class="card-excerpt">
                        {{ Str::limit(strip_tags($article->content), 140) }}
                    </p>

                    <div class="card-footer">
                        <div class="card-meta">
                            <div class="card-author-dot">
                                {{ substr($article->user->name ?? 'P', 0, 1) }}
                            </div>
                            <span>{{ $article->user->name ?? 'Rédaction' }}</span>
                            <div class="card-meta-sep"></div>
                            <span>{{ $article->created_at->translatedFormat('d M Y') }}</span>
                        </div>

                        <a href="{{ route('home.article.show', $article->slug) }}"
                           class="card-read-link"
                           onclick="event.stopPropagation()">
                            Lire <span>→</span>
                        </a>
                    </div>

                </div>

                {{-- Image --}}
                <div class="card-image">
                    @if($article->picture)
                        <img src="{{ asset('storage/' . $article->picture) }}"
                             alt="{{ $article->title }}">
                    @else
                        <div class="card-img-placeholder">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span style="font-size:0.65rem;color:rgba(255,255,255,0.18);
                                         text-transform:uppercase;letter-spacing:0.1em">
                                POLAM SARL
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Barre de progression --}}
                <div class="progress-bar" id="pb-{{ $index }}"></div>

            </article>

        @empty

            <div class="articles-empty">
                <div class="articles-empty-icon">
                    <svg class="w-8 h-8" style="color:rgba(244,123,32,0.35)"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 3v4h4"/>
                    </svg>
                </div>
                <p style="color:rgba(255,255,255,0.5);font-size:0.95rem">
                    Aucun article disponible pour le moment.
                </p>
            </div>

        @endforelse

    </div>

    {{-- ── Navigation dots + CTA ── --}}
    @if($articles->count() > 0)

        <div class="nav-dots">
            @foreach($articles->take(3) as $index => $article)
                <button class="nav-dot {{ $index === 0 ? 'active-dot' : '' }}"
                        id="dot-{{ $index }}"
                        onclick="manualNav({{ $index }})"
                        aria-label="Article {{ $index + 1 }}">
                </button>
            @endforeach
        </div>

        <div class="articles-cta">
            <a href="{{ route('article') }}">
                Voir tous nos articles
                <svg width="14" height="14" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" style="flex-shrink:0">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    @endif

</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards  = document.querySelectorAll('.article-card');
    const dots   = document.querySelectorAll('.nav-dot');
    const total  = cards.length;
    const DURATION = 7000; // ms par slide

    if (total === 0) return;

    let current = 0;
    let start   = Date.now();
    let rafId   = null;

    /* ─── Mise à jour visuelle ─── */
    function updateDisplay() {
        cards.forEach((card, i) => {
            card.classList.remove('active', 'prev', 'next', 'hidden');
            dots[i]?.classList.remove('active-dot');

            if (i === current) {
                card.classList.add('active');
                dots[i]?.classList.add('active-dot');
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

    /* ─── Navigation manuelle ─── */
    window.manualNav = function (index) {
        if (index === current) return;
        current = index;
        updateDisplay();
    };

    /* ─── Boucle RAF ─── */
    function step() {
        const elapsed  = Date.now() - start;
        const progress = Math.min((elapsed / DURATION) * 100, 100);

        // Reset toutes les barres
        document.querySelectorAll('.progress-bar')
                .forEach(bar => bar.style.width = '0%');

        // Avancer la barre active
        const activeBar = document.getElementById(`pb-${current}`);
        if (activeBar) activeBar.style.width = `${progress}%`;

        // Passage au suivant
        if (progress >= 100) {
            current = (current + 1) % total;
            updateDisplay();
        }

        rafId = requestAnimationFrame(step);
    }

    /* ─── Pause au survol ─── */
    const stack = document.getElementById('articleStack');
    if (stack) {
        stack.addEventListener('mouseenter', () => {
            cancelAnimationFrame(rafId);
            document.querySelectorAll('.progress-bar')
                    .forEach(bar => bar.style.transition = 'none');
        });
        stack.addEventListener('mouseleave', () => {
            start = Date.now(); // repart de zéro
            rafId = requestAnimationFrame(step);
        });
    }

    updateDisplay();
    rafId = requestAnimationFrame(step);
});
</script>
