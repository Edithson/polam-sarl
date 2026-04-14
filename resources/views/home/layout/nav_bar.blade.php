<!-- Progress Bar -->
<div id="progress-bar"></div>

<!-- NAV -->
<nav id="navbar">
  <div class="logo-mark">
    <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="19" cy="19" r="17" stroke="#F97316" stroke-width="1.5" stroke-dasharray="3 2"/>
      <circle cx="19" cy="19" r="17" stroke="#333" stroke-width="1.5" stroke-dasharray="3 2" stroke-dashoffset="5"/>
      <line x1="12" y1="19" x2="26" y2="19" stroke="#F97316" stroke-width="1.5"/>
      <line x1="19" y1="12" x2="19" y2="14" stroke="#F97316" stroke-width="1.5"/>
      <line x1="19" y1="24" x2="19" y2="26" stroke="#F97316" stroke-width="1.5"/>
      <circle cx="27" cy="19" r="2" fill="#F97316"/>
      <circle cx="19" cy="13" r="2" fill="#F97316"/>
      <circle cx="19" cy="25" r="2" fill="#F97316"/>
      <line x1="12" y1="15" x2="16" y2="15" stroke="#888" stroke-width="1"/>
      <line x1="12" y1="23" x2="16" y2="23" stroke="#888" stroke-width="1"/>
    </svg>
    <div>
      <div style="font-family:'Bebas Neue',sans-serif;font-size:1.35rem;letter-spacing:0.1em;line-height:1;">POLAM SARL</div>
      <div style="font-size:0.55rem;color:var(--orange);font-family:'Syne',sans-serif;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;line-height:1.2;">Fondé en 2019</div>
    </div>
  </div>

  <ul class="nav-links">
    <li><a href="{{ route('home') }}">Accueil</a></li>
    <li><a href="{{ route('about') }}">À propos</a></li>
    <li><a href="{{ route('service') }}">Services</a></li>
    <li><a href="{{ route('article') }}">Articles</a></li>
    <li><a href="{{ route('contact') }}">Contact</a></li>
  </ul>

  <button class="btn-nav" onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Demander un devis</button>

  <div class="hamburger" id="ham" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobile-menu">
  <button class="mobile-close" onclick="toggleMenu()">✕</button>
    <a href="{{ route('home') }}" onclick="toggleMenu()">Accueil</a>
    <a href="{{ route('about') }}" onclick="toggleMenu()">À Propos</a>
    <a href="{{ route('service') }}" onclick="toggleMenu()">Services</a>
    <a href="{{ route('article') }}" onclick="toggleMenu()">Articles</a>
    <a href="{{ route('contact') }}" onclick="toggleMenu()">Contact</a>
</div>
