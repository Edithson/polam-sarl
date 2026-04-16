<section class="relative py-24 overflow-hidden">

    <div class="absolute top-0 left-0 w-96 h-96 bg-[var(--orange)]/10 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[var(--orange)]/5 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>

    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(color-mix(in srgb, var(--orange) 40%, transparent) 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div class="container mx-auto px-6 relative z-10 max-w-7xl">
        <div class="bg-[var(--dark-3)] border border-[color-mix(in_srgb,var(--orange)_15%,transparent)] rounded-[4px] p-8 md:p-16 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] overflow-hidden relative transition-colors duration-300">

            <img src="{{ asset('media/img/autres/cta.jpg') }}" alt="" class="w-full h-full absolute top-0 left-0 object-cover object-center opacity-90 pointer-events-none mix-blend-overlay">

            <div class="absolute top-0 right-0 p-8 opacity-10 hidden lg:block text-[var(--orange)]">
                <svg class="w-48 h-48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12 relative z-10">

                <div class="lg:w-2/3 text-center lg:text-left">
                    <div class="inline-flex items-center space-x-2 bg-[color-mix(in_srgb,var(--orange)_10%,transparent)] border border-[color-mix(in_srgb,var(--orange)_20%,transparent)] text-[var(--orange)] px-4 py-2 mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[var(--orange)] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[var(--orange)]"></span>
                        </span>
                        <span class="font-heading text-[10px] font-bold uppercase tracking-widest">Équipes d'intervention disponibles</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-display text-[var(--white)] mb-6 leading-[1.1] tracking-wide">
                        Propulsez vos infrastructures dans <br>
                        <span class="text-[var(--orange)]">l'ère de l'innovation.</span>
                    </h2>

                    <p class="text-[var(--gray-light)] text-lg md:text-xl mb-10 max-w-2xl leading-relaxed font-light">
                        Ne laissez pas des installations obsolètes freiner votre développement. Sécurisez vos locaux, passez à l'énergie solaire et modernisez vos équipements avec l'expertise POLAM SARL.
                    </p>

                    <div class="flex flex-wrap justify-center lg:justify-start gap-6 items-center">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-[var(--dark-3)]" src="https://ui-avatars.com/api/?name=J+K&background=F97316&color=fff&font-size=0.4" alt="Client">
                            <img class="w-10 h-10 rounded-full border-2 border-[var(--dark-3)]" src="https://ui-avatars.com/api/?name=P+S&background=111111&color=F97316&font-size=0.4" alt="Client">
                            <img class="w-10 h-10 rounded-full border-2 border-[var(--dark-3)]" src="https://ui-avatars.com/api/?name=M+E&background=222222&color=fff&font-size=0.4" alt="Client">
                        </div>
                        <p class="text-sm text-[var(--gray)] italic font-heading tracking-wide">+150 chantiers livrés au Cameroun.</p>
                    </div>
                </div>

                <div class="lg:w-1/3 w-full flex flex-col gap-4">
                    <a href="{{ route('contact') }}" class="group relative flex items-center justify-center bg-[var(--orange)] text-[#000] px-8 py-5 font-heading font-bold text-sm uppercase tracking-widest hover:bg-[var(--orange-glow)] transition-all duration-300 shadow-[0_10px_30px_rgba(249,115,22,0.2)] overflow-hidden" style="clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);">
                        <span class="relative z-10 flex items-center">
                            Démarrer mon projet
                            <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </span>
                        <div class="absolute inset-0 w-1/2 h-full bg-white/30 skew-x-[-20deg] -translate-x-[150%] group-hover:translate-x-[250%] transition-transform duration-700"></div>
                    </a>

                    <a href="tel:+237698359954" class="flex items-center justify-center border border-[color-mix(in_srgb,var(--orange)_30%,transparent)] text-[var(--white)] px-8 py-4 font-heading font-bold text-sm uppercase tracking-widest hover:bg-[color-mix(in_srgb,var(--orange)_5%,transparent)] transition-all" style="clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);">
                        <svg class="w-4 h-4 mr-3 text-[var(--orange)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Parler à un expert
                    </a>

                    <p class="text-center text-xs text-[var(--gray)] mt-2 font-heading tracking-wide">Réponse garantie sous 24h ouvrables.</p>
                </div>

            </div>
        </div>
    </div>
</section>
