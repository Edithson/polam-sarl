<div id="progress-bar"></div>

<nav id="navbar">
  <div class="logo-mark">
    <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="19" cy="19" r="17" stroke="var(--orange)" stroke-width="1.5" stroke-dasharray="3 2"/>
      <circle cx="19" cy="19" r="17" stroke="var(--gray)" stroke-width="1.5" stroke-dasharray="3 2" stroke-dashoffset="5"/>
      <line x1="12" y1="19" x2="26" y2="19" stroke="var(--orange)" stroke-width="1.5"/>
      <line x1="19" y1="12" x2="19" y2="14" stroke="var(--orange)" stroke-width="1.5"/>
      <line x1="19" y1="24" x2="19" y2="26" stroke="var(--orange)" stroke-width="1.5"/>
      <circle cx="27" cy="19" r="2" fill="var(--orange)"/>
      <circle cx="19" cy="13" r="2" fill="var(--orange)"/>
      <circle cx="19" cy="25" r="2" fill="var(--orange)"/>
      <line x1="12" y1="15" x2="16" y2="15" stroke="var(--gray-light)" stroke-width="1"/>
      <line x1="12" y1="23" x2="16" y2="23" stroke="var(--gray-light)" stroke-width="1"/>
    </svg>
    <div>
      <div style="font-family:'Bebas Neue',sans-serif;font-size:1.35rem;letter-spacing:0.1em;line-height:1;color:var(--white);">POLAM SARL</div>
      <div style="font-size:0.55rem;color:var(--orange);font-family:'Syne',sans-serif;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;line-height:1.2;">Fondé en 2019</div>
    </div>
  </div>

  <ul class="nav-links">
    {{-- La classe active est gérée dynamiquement par Blade --}}
    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a></li>
    <li><a href="{{ route('service') }}" class="{{ request()->routeIs('service') ? 'active' : '' }}">Services</a></li>
    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">À propos</a></li>
    <li><a href="{{ route('article') }}" class="{{ request()->routeIs('article') ? 'active' : '' }}">Articles</a></li>
    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
  </ul>

  <div class="nav-actions">
    <x-theme-toggle />
    <a class="btn-nav" href="{{ route('contact') }}">Demander un devis</a>

    <div class="hamburger" id="ham" onclick="toggleMenu()" aria-label="Menu">
      <span class="line-top"></span>
      <span class="line-mid"></span>
      <span class="line-bot"></span>
    </div>
  </div>
</nav>

<div class="mobile-menu" id="mobile-menu">
    <div class="mobile-menu-content">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
        <a href="{{ route('service') }}" class="{{ request()->routeIs('service') ? 'active' : '' }}">Services</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">À Propos</a>
        <a href="{{ route('article') }}" class="{{ request()->routeIs('article') ? 'active' : '' }}">Articles</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
    </div>
    <div class="mobile-menu-footer">
        <div>POLAM SARL © 2026</div>
        <div style="color:var(--orange); font-size:0.8rem; letter-spacing:0.1em;">La Tech & l'Innovation</div>
    </div>
</div>

<style>
/* ─── VARIABLES ET BASE NAVBAR ─── */
#navbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    padding: 1.2rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    /* Utilisation de color-mix pour la transparence qui s'adapte au thème */
    background: color-mix(in srgb, var(--dark) 85%, transparent);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid color-mix(in srgb, var(--orange) 15%, transparent);
    transition: padding 0.3s ease, background 0.3s ease;
}

#navbar.nav-scrolled {
    padding: 0.8rem 2rem;
    background: color-mix(in srgb, var(--dark) 96%, transparent);
    box-shadow: 0 4px 30px rgba(0,0,0,0.05);
}

.nav-actions {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

/* ─── LIENS ET ÉTAT ACTIF (DESKTOP) ─── */
.nav-links a {
    color: var(--gray-light);
    position: relative;
    padding-bottom: 4px;
    transition: color 0.3s ease;
}

.nav-links a:hover,
.nav-links a.active {
    color: var(--white);
}

.nav-links a::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 0; height: 1.5px;
    background: var(--orange);
    transition: width 0.3s ease;
}

.nav-links a:hover::after,
.nav-links a.active::after {
    width: 100%;
}

/* ─── HAMBURGER ANIMÉ ─── */
.hamburger {
    display: none; /* Remplacé par flex en mobile */
    flex-direction: column;
    gap: 6px;
    cursor: pointer;
    z-index: 101; /* Pour passer au-dessus du menu mobile */
    padding: 5px;
}

.hamburger span {
    width: 28px;
    height: 2px;
    background: var(--white);
    border-radius: 2px;
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

/* Animation d'ouverture (la croix) */
.hamburger.open .line-top { transform: translateY(8px) rotate(45deg); }
.hamburger.open .line-mid { opacity: 0; transform: translateX(-10px); }
.hamburger.open .line-bot { transform: translateY(-8px) rotate(-45deg); }


/* ─── MENU MOBILE MODERNE ─── */
.mobile-menu {
    position: fixed;
    inset: 0;
    background: color-mix(in srgb, var(--dark) 98%, transparent);
    backdrop-filter: blur(15px);
    z-index: 99;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 8rem 2rem 3rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.4s ease;
}

.mobile-menu.open {
    opacity: 1;
    pointer-events: auto;
}

.mobile-menu-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    align-items: center;
}

.mobile-menu a {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 3.5rem;
    letter-spacing: 0.05em;
    color: var(--gray-light);
    text-decoration: none;
    transform: translateY(30px);
    opacity: 0;
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.5s ease, color 0.3s;
}

.mobile-menu a.active {
    color: var(--orange);
}

.mobile-menu a:hover {
    color: var(--white);
}

/* Apparition en cascade (Stagger effect) */
.mobile-menu.open a {
    transform: translateY(0);
    opacity: 1;
}
.mobile-menu.open a:nth-child(1) { transition-delay: 0.1s; }
.mobile-menu.open a:nth-child(2) { transition-delay: 0.15s; }
.mobile-menu.open a:nth-child(3) { transition-delay: 0.2s; }
.mobile-menu.open a:nth-child(4) { transition-delay: 0.25s; }
.mobile-menu.open a:nth-child(5) { transition-delay: 0.3s; }

.mobile-menu-footer {
    text-align: center;
    font-family: 'Syne', sans-serif;
    color: var(--gray);
    font-size: 0.7rem;
    text-transform: uppercase;
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.5s ease 0.4s;
}

.mobile-menu.open .mobile-menu-footer {
    transform: translateY(0);
    opacity: 1;
}

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
    .nav-links, .btn-nav { display: none; }
    .hamburger { display: flex; }
}
</style>

<script>
// Gestion de l'état "Scrolled" pour la navbar
window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (window.scrollY > 50) {
        nav.classList.add('nav-scrolled');
    } else {
        nav.classList.remove('nav-scrolled');
    }
});

// Menu mobile et animation du Hamburger
function toggleMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburger = document.getElementById('ham');

    mobileMenu.classList.toggle('open');
    hamburger.classList.toggle('open');

    // Bloquer le scroll du site quand le menu est ouvert
    document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : '';
}
</script>
