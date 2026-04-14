import './bootstrap';

// Progress bar
  window.addEventListener('scroll', () => {
    const st = window.scrollY;
    const dh = document.documentElement.scrollHeight - window.innerHeight;
    document.getElementById('progress-bar').style.width = (st / dh * 100) + '%';
  });

  // Navbar scroll effect
  window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (window.scrollY > 60) {
      nav.style.background = 'rgba(5,5,5,0.97)';
      nav.style.padding = '0.8rem 2rem';
    } else {
      nav.style.background = 'rgba(10,10,10,0.85)';
      nav.style.padding = '1.2rem 2rem';
    }
  });

  // Mobile menu
  function toggleMenu() {
    document.getElementById('mobile-menu').classList.toggle('open');
    document.body.style.overflow = document.getElementById('mobile-menu').classList.contains('open') ? 'hidden' : '';
  }

  // Form handler
  function handleForm(e) {
    e.preventDefault();
    const btn = e.target.querySelector('button[type="submit"]');
    btn.textContent = '✅ Demande envoyée !';
    btn.style.background = '#16a34a';
    btn.style.color = '#fff';
    setTimeout(() => {
      btn.textContent = 'Envoyer la demande →';
      btn.style.background = '';
      btn.style.color = '';
      e.target.reset();
    }, 3000);
  }

  // Intersection Observer for reveal animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.service-card, .pillar, .why-card, .real-item, .contact-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
  });
