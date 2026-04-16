<section id="hero-tech" class="h-[90vh] min-h-[600px] max-h-[900px] overflow-hidden bg-[var(--dark)]">

    <img id="hero-bg-bottom" src="/media/img/fake/slide-1-electricite.jpg" class="absolute inset-0 w-full h-full object-cover opacity-60">

    <div id="hero-bg-top-wrapper" class="absolute inset-0 w-full h-full z-10" style="clip-path: inset(0 100% 0 0);">
        <img id="hero-bg-top" src="/media/img/fake/slide-2-solaire.jpg" class="absolute inset-0 w-full h-full object-cover opacity-60">
    </div>

    <div class="absolute inset-0 z-20 bg-gradient-to-r from-[var(--dark)] via-[var(--dark)]/80 to-[var(--dark)]/20 md:to-transparent pointer-events-none"></div>

    <div class="absolute inset-0 z-20 opacity-20 pointer-events-none" style="background-image: radial-gradient(color-mix(in srgb, var(--orange) 50%, transparent) 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div id="hero-scanner" class="absolute top-0 bottom-0 left-0 w-1 bg-[var(--orange)] z-30 opacity-0 shadow-[0_0_25px_var(--orange),0_0_10px_#fff]">
        <div class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-2 h-12 bg-white rounded-full blur-[2px]"></div>
    </div>

    <div class="absolute inset-0 z-40 flex items-center">
        <div class="container mx-auto px-6 max-w-7xl">
            <div id="hero-content" class="max-w-2xl transition-all duration-500 transform translate-y-0 opacity-100">

                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-[2px] bg-[var(--orange)]"></span>
                    <span id="hero-tag" class="text-[var(--orange)] font-heading font-bold tracking-[0.2em] uppercase text-xs">Électricité Générale</span>
                </div>

                <h2 id="hero-title" class="text-5xl md:text-6xl lg:text-7xl font-display text-[var(--white)] mb-6 leading-[1.05] tracking-wide">
                    L'énergie qui <br><span class="text-[var(--orange)]">propulse</span> vos projets
                </h2>

                <p id="hero-desc" class="text-[var(--gray-light)] text-lg md:text-xl font-light mb-10 max-w-xl">
                    Installations domestiques et industrielles certifiées, pour une performance optimale et sécurisée au quotidien.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="group relative flex items-center justify-center bg-[var(--orange)] text-[#000] px-8 py-4 font-heading font-bold text-sm uppercase tracking-widest hover:bg-[var(--orange-glow)] transition-all duration-300" style="clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);">
                        Démarrer un projet
                        <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <a href="{{ route('service') }}" class="btn-ghost" style="padding: 1rem 2rem;">
                        Nos expertises
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-0 right-0 z-50">
        <div class="container mx-auto px-6 max-w-7xl flex gap-3" id="hero-nav">
            </div>
    </div>

</section>

<style>
    /* Utilitaires pour le slider */
    .hero-nav-dot {
        height: 3px;
        width: 30px;
        background-color: color-mix(in srgb, var(--white) 20%, transparent);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .hero-nav-dot.active {
        width: 60px;
        background-color: var(--orange);
    }
    .hero-nav-dot:hover:not(.active) {
        background-color: color-mix(in srgb, var(--white) 50%, transparent);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Définition des fausses données (à remplacer dynamiquement via Laravel plus tard)
    const slides = [
        {
            tag: "Électricité Générale",
            title: "L'énergie qui <br><span class='text-[var(--orange)]'>propulse</span> vos projets",
            desc: "Installations domestiques et industrielles certifiées, pour une performance optimale et sécurisée au quotidien.",
            img: "/media/img/slides/electricite.avif"
        },
        {
            tag: "Énergie Solaire",
            title: "Passez à l'autonomie <br><span class='text-[var(--orange)]'>durable</span>",
            desc: "Solutions photovoltaïques de pointe pour réduire vos coûts et sécuriser votre alimentation électrique face aux coupures.",
            img: "/media/img/slides/autonomie.png"
        },
        {
            tag: "Sécurité & Domotique",
            title: "Contrôle total, <br><span class='text-[var(--orange)]'>sécurité absolue</span>",
            desc: "Vidéosurveillance IP, contrôle d'accès biométrique et systèmes intelligents pour protéger vos infrastructures.",
            img: "/media/img/slides/securite.png"
        }
    ];

    let currentIndex = 0;
    let isAnimating = false;
    let slideInterval;

    // Éléments du DOM
    const bgBottom = document.getElementById('hero-bg-bottom');
    const bgTop = document.getElementById('hero-bg-top');
    const bgTopWrapper = document.getElementById('hero-bg-top-wrapper');
    const scanner = document.getElementById('hero-scanner');

    const contentBox = document.getElementById('hero-content');
    const tagEl = document.getElementById('hero-tag');
    const titleEl = document.getElementById('hero-title');
    const descEl = document.getElementById('hero-desc');
    const navContainer = document.getElementById('hero-nav');

    // Initialisation
    bgBottom.src = slides[0].img;

    // Créer la navigation
    slides.forEach((_, idx) => {
        const dot = document.createElement('div');
        dot.className = `hero-nav-dot ${idx === 0 ? 'active' : ''}`;
        dot.addEventListener('click', () => goToSlide(idx));
        navContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.hero-nav-dot');

    // Fonction principale de transition (Effet Scanner)
    function goToSlide(index) {
        if (isAnimating || index === currentIndex) return;
        isAnimating = true;

        clearInterval(slideInterval); // Pause l'auto-play

        // Préparer la nouvelle image au-dessus, cachée sur la droite
        bgTop.src = slides[index].img;
        bgTopWrapper.style.transition = 'none';
        bgTopWrapper.style.clipPath = 'inset(0 100% 0 0)';

        // Cacher le contenu actuel (Animation sortie)
        contentBox.style.opacity = '0';
        contentBox.style.transform = 'translateY(20px)';

        // Laisser le temps au navigateur d'appliquer le CSS initial
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {

                // 1. Lancer le scanner et révéler l'image
                const duration = 1200; // 1.2 secondes

                scanner.style.transition = 'none';
                scanner.style.left = '0%';
                scanner.style.opacity = '1';

                setTimeout(() => {
                    scanner.style.transition = `left ${duration}ms cubic-bezier(0.65, 0, 0.35, 1)`;
                    bgTopWrapper.style.transition = `clip-path ${duration}ms cubic-bezier(0.65, 0, 0.35, 1)`;

                    scanner.style.left = '100%';
                    bgTopWrapper.style.clipPath = 'inset(0 0 0 0)';
                }, 50);

                // 2. Mettre à jour les textes pendant que l'image change
                setTimeout(() => {
                    tagEl.textContent = slides[index].tag;
                    titleEl.innerHTML = slides[index].title;
                    descEl.textContent = slides[index].desc;

                    // Réafficher le contenu (Animation entrée)
                    contentBox.style.opacity = '1';
                    contentBox.style.transform = 'translateY(0)';
                }, duration / 2); // Le texte change quand le scanner est au milieu

                // 3. Fin de l'animation
                setTimeout(() => {
                    // L'image du dessus devient l'image du dessous
                    bgBottom.src = slides[index].img;

                    // Cacher le scanner
                    scanner.style.opacity = '0';

                    // Réinitialiser le wrapper du dessus
                    bgTopWrapper.style.transition = 'none';
                    bgTopWrapper.style.clipPath = 'inset(0 100% 0 0)';

                    // Mettre à jour la navigation
                    dots[currentIndex].classList.remove('active');
                    dots[index].classList.add('active');

                    currentIndex = index;
                    isAnimating = false;

                    startAutoPlay(); // Relancer l'auto-play
                }, duration + 100);
            });
        });
    }

    // Auto-play
    function startAutoPlay() {
        slideInterval = setInterval(() => {
            let nextIndex = (currentIndex + 1) % slides.length;
            goToSlide(nextIndex);
        }, 7000); // Change toutes les 7 secondes
    }

    startAutoPlay();
});
</script>
