<!-- Navigation -->
<style>
    .language-toggle {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 10px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .language-toggle:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(34, 197, 94, 0.3);
    }

    .language-option {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #a0a0a0;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .language-option:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.05);
    }

    .language-option.active {
        color: #22c55e;
        background: rgba(34, 197, 94, 0.1);
    }

    .divider {
        width: 1px;
        height: 16px;
        background: rgba(255, 255, 255, 0.1);
    }
</style>
<nav class="fixed top-0 left-0 right-0 z-50" id="navbar">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
                    <img src="{{ $siteLogo ? asset('storage/' . $siteLogo) : asset('media/img/logo.png') }}" alt="Logo CINV-CORSA">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $siteName ? $siteName : "CINV-CORSA" }}</h1>
                    <p class="text-xs text-gray-500">{{ $siteSlogan ? $siteSlogan : "Solutions Documentaires" }}</p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <a id="menu_home" href="{{route('home')}}" class="text-gray-700 hover:text-green-600 font-medium transition">{{ __('home.home_link') }}</a>
                <a id="menu_service" href="{{route('service')}}" class="text-gray-700 hover:text-green-600 font-medium transition">{{ __('home.service_link') }}</a>
                <a id="menu_article" href="{{route('article')}}" class="text-gray-700 hover:text-green-600 font-medium transition">{{ __('home.article_link') }}</a>
                <a id="menu_about" href="{{route('about')}}" class="text-gray-700 hover:text-green-600 font-medium transition">{{ __('home.about_link') }}</a>
                <a id="menu_contact" href="{{route('contact')}}" class="text-gray-700 hover:text-green-600 font-medium transition">{{ __('home.contact_link') }}</a>
                <div class="language-toggle">
                    <div class="language-option {{ app()->getLocale() == 'fr' ? 'active' : '' }}"
                        onclick="window.location.href='/lang/fr'">
                        🇫🇷 <span>FR</span>
                    </div>
                    <span class="divider"></span>
                    <div class="language-option {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                        onclick="window.location.href='/lang/en'">
                        🇬🇧 <span>EN</span>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-btn" class="lg:hidden text-gray-700 focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="mobile-overlay" id="mobile-overlay"></div>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobile-menu">
    <button id="close-mobile" class="absolute top-6 right-6 text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div class="mt-12 space-y-6">
        <a id="mobile_menu_home" href="{{route('home')}}" class="block text-lg font-medium text-gray-700 hover:text-green-600">{{ __('home.home_link') }}</a>
        <a id="mobile_menu_service" href="{{route('service')}}" class="block text-lg font-medium text-gray-700 hover:text-green-600">{{ __('home.service_link') }}</a>
        <a id="mobile_menu_article" href="{{route('article')}}" class="block text-lg font-medium text-gray-700 hover:text-green-600">{{ __('home.article_link') }}</a>
        <a id="mobile_menu_about" href="{{route('about')}}" class="block text-lg font-medium text-gray-700 hover:text-green-600">{{ __('home.about_link') }}</a>
        <a id="mobile_menu_contact" href="{{route('contact')}}" class="block text-lg font-medium text-gray-700 hover:text-green-600">{{ __('home.contact_link') }}</a>
    </div>
</div>

<script>
    //script pour colorier le lien actif
    /**
     * Extrait le premier segment du chemin de l'URL
     * @returns {string} Le premier argument (ex: "service", "articles") ou une chaîne vide
     */
    if (getFirstPathArgument() == "") {
        // Cas spécial de la page d'accueil
        let homeLink = document.getElementById("menu_home");
        let homeMobileLink = document.getElementById("mobile_menu_home");
        homeLink.classList.add("text-green-600");
        homeLink.classList.remove("text-gray-700");
        homeMobileLink.classList.add("text-green-600");
        homeMobileLink.classList.remove("text-gray-700");

    }
    let linkId = "menu_" + getFirstPathArgument();
    let mobileLinkId = "mobile_menu_" + getFirstPathArgument();
    let activeLink = document.getElementById(linkId);
    let activeMobileLink = document.getElementById(mobileLinkId);
    if (activeLink) {
        activeLink.classList.add("text-green-600");
        activeLink.classList.remove("text-gray-700");
    }
    if (activeMobileLink) {
        activeMobileLink.classList.add("text-green-600");
        activeMobileLink.classList.remove("text-gray-700");
    }
    function getFirstPathArgument() {
        // window.location.pathname retourne tout ce qui est après le domaine (ex: "/articles/2")
        const path = window.location.pathname;

        // On découpe par le caractère "/"
        // .split('/') sur "/articles/2" donne ["", "articles", "2"]
        const segments = path.split('/');

        // Le premier argument se trouve toujours à l'index 1
        // car le chemin commence par un "/" (créant un index 0 vide)
        return segments[1] || "";
    }

</script>
