<style>
    /* Utilitaires pour l'effet 3D non présents par défaut dans Tailwind */
    .perspective {
        perspective: 1000px;
    }
    .preserve-3d {
        transform-style: preserve-3d;
    }
    .backface-hidden {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }
    .rotate-y-180 {
        transform: rotateY(180deg);
    }
    /* Classe activée par JS sur mobile */
    .is-flipped {
        transform: rotateY(180deg);
    }
</style>

<section class="py-20 bg-[var(--dark)] transition-colors duration-300" id="home_services">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="text-center mb-16">
            <div class="flex justify-center mb-2">
                <span class="inline-flex items-center gap-2 font-heading text-[10px] font-bold tracking-[0.2em] uppercase text-[var(--orange)]">
                    <span class="w-6 h-[1.5px] bg-[var(--orange)]"></span>
                    Ce que nous faisons
                </span>
            </div>
            <h2 class="text-4xl md:text-5xl font-display text-[var(--white)] mb-4 tracking-wide">
                Nos Domaines <span class="text-[var(--orange)]">d'Expertise</span>
            </h2>
            <p class="text-[var(--gray-light)] max-w-2xl mx-auto font-light">
                Découvrez les solutions technologiques que POLAM SARL déploie pour moderniser et sécuriser vos infrastructures.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="flip-card h-[400px] w-full perspective group cursor-pointer">
                <div class="flip-card-inner relative w-full h-full transition-transform duration-700 preserve-3d group-hover:rotate-y-180">

                    <div class="absolute inset-0 w-full h-full backface-hidden rounded-[4px] overflow-hidden shadow-[0_15px_30px_-10px_rgba(0,0,0,0.3)]">
                        <img src="{{ asset('media/img/services/electricite.jpg') }}" class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 transition-all duration-500" alt="Électricité">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent flex items-end p-8">
                            <h3 class="text-xl font-heading font-bold text-white uppercase tracking-widest">Électricité</h3>
                        </div>
                        <div class="absolute top-4 right-4 bg-[var(--orange)] text-black font-display text-xl w-10 h-10 flex items-center justify-center rounded-sm">01</div>
                    </div>

                    <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180 rounded-[4px] bg-[var(--dark-2)] border border-[color-mix(in_srgb,var(--orange)_20%,transparent)] flex flex-col items-center justify-center p-8 text-center text-[var(--white)] shadow-xl">
                        <div class="mb-4 text-4xl">⚡</div>
                        <h3 class="text-lg font-heading font-bold mb-4 uppercase tracking-widest text-[var(--orange)]">Installations</h3>
                        <p class="text-sm text-[var(--gray-light)] font-light leading-relaxed mb-8">
                            Étude, conception et câblage d'installations électriques domestiques, tertiaires et industrielles. Mise aux normes et dépannage.
                        </p>
                        <a href="{{ route('service') }}#electricite" class="btn-ghost" style="padding: 0.6rem 1.5rem; font-size: 0.7rem;">En savoir plus</a>
                    </div>

                </div>
            </div>

            <div class="flip-card h-[400px] w-full perspective group cursor-pointer">
                <div class="flip-card-inner relative w-full h-full transition-transform duration-700 preserve-3d group-hover:rotate-y-180">
                    <div class="absolute inset-0 w-full h-full backface-hidden rounded-[4px] overflow-hidden shadow-[0_15px_30px_-10px_rgba(0,0,0,0.3)]">
                        <img src="{{ asset('media/img/services/solaire.png') }}" class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 transition-all duration-500" alt="Énergie Solaire">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent flex items-end p-8">
                            <h3 class="text-xl font-heading font-bold text-white uppercase tracking-widest">Énergie Solaire</h3>
                        </div>
                        <div class="absolute top-4 right-4 bg-[var(--orange)] text-black font-display text-xl w-10 h-10 flex items-center justify-center rounded-sm">02</div>
                    </div>
                    <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180 rounded-[4px] bg-[var(--dark-2)] border border-[color-mix(in_srgb,var(--orange)_20%,transparent)] flex flex-col items-center justify-center p-8 text-center text-[var(--white)] shadow-xl">
                        <div class="mb-4 text-4xl">☀️</div>
                        <h3 class="text-lg font-heading font-bold mb-4 uppercase tracking-widest text-[var(--orange)]">Photovoltaïque</h3>
                        <p class="text-sm text-[var(--gray-light)] font-light leading-relaxed mb-8">
                            Indépendance énergétique grâce à nos solutions solaires hybrides et autonomes. Matériel premium et maintenance.
                        </p>
                        <a href="{{ route('service') }}#solaire" class="btn-ghost" style="padding: 0.6rem 1.5rem; font-size: 0.7rem;">En savoir plus</a>
                    </div>
                </div>
            </div>

            <div class="flip-card h-[400px] w-full perspective group cursor-pointer">
                <div class="flip-card-inner relative w-full h-full transition-transform duration-700 preserve-3d group-hover:rotate-y-180">
                    <div class="absolute inset-0 w-full h-full backface-hidden rounded-[4px] overflow-hidden shadow-[0_15px_30px_-10px_rgba(0,0,0,0.3)]">
                        <img src="{{ asset('media/img/services/securite2.png') }}" class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 transition-all duration-500" alt="Vidéosurveillance">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent flex items-end p-8">
                            <h3 class="text-xl font-heading font-bold text-white uppercase tracking-widest">Sécurité & Accès</h3>
                        </div>
                        <div class="absolute top-4 right-4 bg-[var(--orange)] text-black font-display text-xl w-10 h-10 flex items-center justify-center rounded-sm">03</div>
                    </div>
                    <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180 rounded-[4px] bg-[var(--dark-2)] border border-[color-mix(in_srgb,var(--orange)_20%,transparent)] flex flex-col items-center justify-center p-8 text-center text-[var(--white)] shadow-xl">
                        <div class="mb-4 text-4xl">📹</div>
                        <h3 class="text-lg font-heading font-bold mb-4 uppercase tracking-widest text-[var(--orange)]">Vidéosurveillance</h3>
                        <p class="text-sm text-[var(--gray-light)] font-light leading-relaxed mb-8">
                            Déploiement de caméras IP, contrôle d'accès biométrique, alarme et interphonie pour sécuriser vos locaux.
                        </p>
                        <a href="{{route('service')}}#securite" class="btn-ghost" style="padding: 0.6rem 1.5rem; font-size: 0.7rem;">En savoir plus</a>
                    </div>
                </div>
            </div>

            <div class="flip-card h-[400px] w-full perspective group cursor-pointer">
                <div class="flip-card-inner relative w-full h-full transition-transform duration-700 preserve-3d group-hover:rotate-y-180">
                    <div class="absolute inset-0 w-full h-full backface-hidden rounded-[4px] overflow-hidden shadow-[0_15px_30px_-10px_rgba(0,0,0,0.3)]">
                        <img src="{{ asset('media/img/services/informatique.png') }}" class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 transition-all duration-500" alt="Informatique">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent flex items-end p-8">
                            <h3 class="text-xl font-heading font-bold text-white uppercase tracking-widest">Informatique</h3>
                        </div>
                        <div class="absolute top-4 right-4 bg-[var(--orange)] text-black font-display text-xl w-10 h-10 flex items-center justify-center rounded-sm">04</div>
                    </div>
                    <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180 rounded-[4px] bg-[var(--dark-2)] border border-[color-mix(in_srgb,var(--orange)_20%,transparent)] flex flex-col items-center justify-center p-8 text-center text-[var(--white)] shadow-xl">
                        <div class="mb-4 text-4xl">🖥️</div>
                        <h3 class="text-lg font-heading font-bold mb-4 uppercase tracking-widest text-[var(--orange)]">Maintenance IT</h3>
                        <p class="text-sm text-[var(--gray-light)] font-light leading-relaxed mb-8">
                            Réseaux câblés, fibre optique, maintenance de parcs informatiques et dépannage matériel pour professionnels.
                        </p>
                        <a href="{{ route('service') }}#informatique" class="btn-ghost" style="padding: 0.6rem 1.5rem; font-size: 0.7rem;">En savoir plus</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    // Script pour gérer le flip au clic sur mobile (tactile)
    document.querySelectorAll('.flip-card').forEach(card => {
        card.addEventListener('click', function() {
            // On vérifie si on est sur un écran mobile/tablette
            if (window.innerWidth < 1024) {
                const inner = this.querySelector('.flip-card-inner');
                // Fermer les autres cartes avant d'ouvrir celle-ci
                document.querySelectorAll('.flip-card-inner').forEach(el => {
                    if (el !== inner) el.classList.remove('is-flipped');
                });
                inner.classList.toggle('is-flipped');
            }
        });
    });
</script>
