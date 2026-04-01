
    <style>
        .archive-container {
            position: relative;
            height: 600px;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%);
            overflow: hidden;
        }

        /* Particules flottantes représentant les documents */
        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(34, 197, 94, 0.6);
            border-radius: 50%;
            pointer-events: none;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(50px) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* Effet de scan */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #22c55e, transparent);
            animation: scan 4s linear infinite;
            opacity: 0.5;
        }

        @keyframes scan {
            0% {
                top: 0;
            }

            100% {
                top: 100%;
            }
        }

        /* Icon animation */
        .icon-float {
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Responsive text */
        .responsive-text {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
        }
    </style>

    <div class="archive-container">

        <img src="{{ asset('media/img/logo/logo3.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover object-center opacity-20 z-0">

        <!-- Grille de fond -->
        <div class="data-grid"></div>

        <!-- Ligne de scan -->
        <div class="scan-line"></div>

        <!-- Particules -->
        <div id="particles"></div>

        <!-- Contenu principal -->
        <div class="relative z-10 container mx-auto px-4 py-20">

            <!-- Section Hero -->
            <div class="text-center mb-4">
                <div class="mb-8 mt-16 opacity-0 animate-fade-in" style="animation-delay: 0.2s;">
                    <span
                        class="inline-block px-6 py-2 bg-green-500/10 border border-green-500/30 rounded-full text-green-400 font-mono text-sm tracking-wider mt-10">
                        Qui sommes-nous ?
                    </span>
                </div>

                <h1 class="text-emerald-500 font-bold text-5xl sm:text-7xl md:text-8xl lg:text-9xl mb-12 tracking-tighter mt-10 opacity-0 animate-fade-in">
                    {{ $siteName }}
                </h1>

                <p class="text-gray-400 text-xl md:text-2xl max-w-3xl mx-auto mb-0 opacity-0 animate-fade-in responsive-text"
                    style="animation-delay: 0.6s;">
                    Vos documents ne sont plus statiques. Ils respirent, évoluent et se transforment en temps réel dans
                    un écosystème numérique intelligent.
                </p>
            </div>

        </div>
    </div>

    <script>
        // Générer les particules
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 20 + 's';
            particle.style.animationDuration = (15 + Math.random() * 10) + 's';
            particlesContainer.appendChild(particle);
        }

        document.querySelectorAll('.counter').forEach(counter => {
            observer.observe(counter);
        });

        // Animations CSS personnalisées
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fade-in {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes slide-in-left {
                from { opacity: 0; transform: translateX(-100px); }
                to { opacity: 1; transform: translateX(0); }
            }

            @keyframes slide-in-right {
                from { opacity: 0; transform: translateX(100px); }
                to { opacity: 1; transform: translateX(0); }
            }

            .animate-fade-in {
                animation: fade-in 1s ease-out forwards;
            }

            .animate-slide-in-left {
                animation: slide-in-left 1s ease-out forwards;
            }

            .animate-slide-in-right {
                animation: slide-in-right 1s ease-out forwards;
            }
        `;
        document.head.appendChild(style);

        // Effet parallaxe sur la souris
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.doc-card');
            const x = e.clientX / window.innerWidth - 0.5;
            const y = e.clientY / window.innerHeight - 0.5;

            cards.forEach((card, index) => {
                const speed = (index + 1) * 10;
                card.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
            });
        });

        // Effet de halo sur le curseur
        const cursor = document.createElement('div');
        cursor.style.cssText = `
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34, 197, 94, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.2s ease;
        `;
        document.body.appendChild(cursor);

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = (e.clientX - 150) + 'px';
            cursor.style.top = (e.clientY - 150) + 'px';
        });
    </script>
