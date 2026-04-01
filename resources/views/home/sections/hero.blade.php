<!-- Hero Section -->
<section id="accueil" class="hero-gradient relative pt-10">
    <div class="relative w-full h-screen overflow-hidden bg-slate-900 group shadow-2xl">

        <img id="next-slide" src="" class="absolute inset-0 w-full h-full object-cover opacity-0">

        <div id="current-slide-container" class="absolute inset-0 w-full h-full z-10" style="clip-path: inset(0 0 0 0);">
            <img id="current-slide" src="/media/img/slides/photo2.jpg" class="w-full h-full object-cover">
        </div>

        <div id="scanner-bar" class="absolute inset-y-0 left-0 w-1 bg-linear-to-b from-transparent via-emerald-400 to-transparent z-20 opacity-0 shadow-[0_0_20px_rgba(16,185,129,0.8)]">
            <div class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/2 w-4 h-4 bg-emerald-400 rounded-full blur-sm"></div>
        </div>

        <div class="absolute inset-0 z-30 flex items-center bg-linear-to-r from-slate-900/80 to-transparent">
            <div class="container mx-auto px-12">
                <div id="slide-content" class="max-w-xl transition-all duration-700 transform translate-y-0 opacity-100">
                    <span id="slide-tag" class="text-emerald-400 font-bold tracking-widest uppercase text-sm mb-4 block">{{ __('home.slide1_tag') }}</span>
                    <h2 id="slide-title" class="text-5xl font-black text-white mb-6 leading-tight">{{ __('home.slide1_title') }}</h2>
                    <p id="slide-desc" class="text-gray-300 text-lg mb-8">{{ __('home.slide1_desc') }}</p>
                    <a href="#home_services" class="inline-block bg-emerald-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-emerald-500 transition-colors">{{ __('home.hero_button') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
