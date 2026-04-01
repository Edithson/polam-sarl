<section class="py-16 bg-linear-to-br from-gray-50 to-gray-100 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Nos Partenaires</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Ils nous font confiance pour leurs solutions technologiques
            </p>
        </div>

        <!-- Carrousel de logos -->
        <div class="relative">
            <div class="overflow-hidden">
                <div id="partnerSlider" class="flex transition-transform duration-500 ease-in-out gap-8 md:gap-12">
                    <!-- Les logos seront insérés ici par JavaScript -->
                </div>
            </div>

            <!-- Boutons de navigation -->
            <button id="prevBtn" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white shadow-lg rounded-full p-3 transition-all duration-300 hover:scale-110 z-10 opacity-50">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button id="nextBtn" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white shadow-lg rounded-full p-3 transition-all duration-300 hover:scale-110 z-10 opacity-50">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Indicateurs doit etre en vert emrode -->
        <div id="indicators" class="flex justify-center gap-2 mt-8 text-emrode-600">
            <!-- Les indicateurs seront générés par JavaScript -->
        </div>
    </div>

    <script>
        // Tableau d'images des partenaires
        const partnerLogos = [
            '/media/img/partners/aaq.png',
            '/media/img/partners/antic.png',
            '/media/img/partners/camtel.png',
            '/media/img/partners/canal2.png',
            '/media/img/partners/congres.png',
            '/media/img/partners/crtv.png',
            '/media/img/partners/itc.png',
            '/media/img/partners/saa.png',
            '/media/img/partners/vision4.png',
            '/media/img/partners/esstic.png',
            '/media/img/partners/mac.png',
            '/media/img/partners/csa_aas.png',
        ];

        const slider = document.getElementById('partnerSlider');
        const indicators = document.getElementById('indicators');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentIndex = 0;
        let itemsPerView = window.innerWidth < 768 ? 2 : window.innerWidth < 1024 ? 3 : 4;
        let autoSlideInterval;

        // Générer les logos
        function renderLogos() {
            slider.innerHTML = partnerLogos.map(logo => `
                <div class="flex-shrink-0 flex items-center justify-center bg-white rounded-lg shadow-md p-2 hover:shadow-xl transition-shadow duration-300" style="width: calc((100% - ${(itemsPerView - 1) * (window.innerWidth < 768 ? 2 : 3)}rem) / ${itemsPerView})">
                    <img src="${logo}" alt="Logo partenaire" class="max-h-16 w-auto object-contain transition-transform duration-300 hover:scale-110">
                </div>
            `).join('');
        }

        // Générer les indicateurs
        function renderIndicators() {
            const totalPages = Math.ceil(partnerLogos.length / itemsPerView);
            indicators.innerHTML = Array.from({length: totalPages}, (_, i) => `
                <button class="w-3 h-3 rounded-full transition-all duration-300 ${i === currentIndex ? 'bg-green-600 w-8' : 'bg-gray-300 hover:bg-gray-400'}" data-index="${i}"></button>
            `).join('');

            // Ajouter les événements aux indicateurs
            indicators.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentIndex = parseInt(btn.dataset.index);
                    updateSlider();
                    resetAutoSlide();
                });
            });
        }

        // Mettre à jour le slider
        function updateSlider() {
            const totalPages = Math.ceil(partnerLogos.length / itemsPerView);
            if (currentIndex >= totalPages) currentIndex = 0;
            if (currentIndex < 0) currentIndex = totalPages - 1;

            const offset = currentIndex * 100;
            slider.style.transform = `translateX(-${offset}%)`;
            renderIndicators();
        }

        // Navigation
        function nextSlide() {
            currentIndex++;
            updateSlider();
        }

        function prevSlide() {
            currentIndex--;
            updateSlider();
        }

        // Auto-slide
        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 4000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Événements
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetAutoSlide();
        });

        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetAutoSlide();
        });

        // Responsive
        window.addEventListener('resize', () => {
            const newItemsPerView = window.innerWidth < 768 ? 2 : window.innerWidth < 1024 ? 3 : 4;
            if (newItemsPerView !== itemsPerView) {
                itemsPerView = newItemsPerView;
                currentIndex = 0;
                renderLogos();
                renderIndicators();
                updateSlider();
            }
        });

        // Pause au survol
        slider.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
        slider.addEventListener('mouseleave', startAutoSlide);

        // Initialisation
        renderLogos();
        renderIndicators();
        startAutoSlide();
    </script>
</section>
