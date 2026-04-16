<style>
    /* ── ANIMATED CANVAS ── */
    #flow-canvas {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none; /* Empêche le canvas de bloquer les clics sur les boutons */
    }

    /* ── NOISE OVERLAY (Mieux intégré au thème) ── */
    .tech-grain::after {
        content: "";
        position: absolute;
        inset: 0;
        /* Utilisation d'un bruit généré en SVG pur pour éviter les dépendances externes */
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
        opacity: 0.5;
        pointer-events: none;
    }

    /* ── TEXT GLOW (Orange dynamique) ── */
    .text-glow {
        text-shadow: 0 0 40px color-mix(in srgb, var(--orange) 45%, transparent);
    }
</style>

<section class="bg-[var(--dark)] relative min-h-[80vh] flex items-center justify-center tech-grain overflow-hidden transition-colors duration-300">

    <img src="{{ asset('media/img/services/cta_service.png') }}" alt="call to action" class="absolute inset-0 w-full h-full object-cover object-center opacity-10 z-0 mix-blend-luminosity" />

    <div class="absolute inset-0 bg-gradient-to-t from-[var(--dark)] via-transparent to-[var(--dark)] z-0 opacity-80"></div>

    <canvas id="flow-canvas"></canvas>

    <div class="relative z-10 max-w-4xl px-6 text-center">
        <div class="flex justify-center mb-6">
            <span class="inline-flex items-center gap-2 font-heading text-[10px] font-bold tracking-[0.2em] uppercase text-[var(--orange)] border border-[color-mix(in_srgb,var(--orange)_30%,transparent)] px-4 py-1.5 bg-[color-mix(in_srgb,var(--orange)_5%,transparent)]">
                <span class="w-1.5 h-1.5 bg-[var(--orange)] rounded-full animate-pulse"></span>
                Passez à l'action
            </span>
        </div>

        <h2 class="font-display text-5xl md:text-7xl tracking-wide text-[var(--white)] text-glow leading-[1.05]">
            L'innovation n'est pas <br />
            <span class="text-[var(--orange)]">qu'une idée.</span>
        </h2>

        <p class="mt-8 text-lg md:text-xl text-[var(--gray-light)] leading-relaxed font-light">
            Chaque installation, chaque réseau a un impact direct sur votre activité.<br />
            Nous déployons les infrastructures qui rendent votre environnement
            <span class="text-[var(--white)] font-medium">plus sûr, intelligent et performant</span>.
        </p>

        <div class="mt-12 flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="btn-primary" style="padding: 1.2rem 2.5rem;">
                Lancer mon projet
            </a>
            <a href="{{ route('about') }}" class="btn-ghost" style="padding: 1.2rem 2.5rem;">
                Découvrir notre vision
            </a>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById("flow-canvas");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");

        let w, h;
        function resize() {
            w = canvas.width = window.innerWidth;
            h = canvas.height = canvas.parentElement.clientHeight; // S'adapte à la hauteur de la section
        }
        resize();
        window.addEventListener("resize", resize);

        // Réduction du nombre de noeuds pour un effet plus "aéré" et tech
        const nodes = Array.from({ length: 90 }, () => ({
            x: Math.random() * w,
            y: Math.random() * h,
            vx: (Math.random() - 0.5) * 0.4,
            vy: (Math.random() - 0.5) * 0.4,
        }));

        // La couleur Orange de Polam (RGB)
        const orangeRgb = "249, 115, 22";

        function draw() {
            ctx.clearRect(0, 0, w, h);

            for (let i = 0; i < nodes.length; i++) {
                const n = nodes[i];
                n.x += n.vx;
                n.y += n.vy;

                // Rebond sur les bords
                if (n.x < 0 || n.x > w) n.vx *= -1;
                if (n.y < 0 || n.y > h) n.vy *= -1;

                // Dessin du point (noeud)
                ctx.beginPath();
                ctx.arc(n.x, n.y, 1.5, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${orangeRgb}, 0.8)`;
                ctx.fill();

                // Dessin des lignes de connexion
                for (let j = i + 1; j < nodes.length; j++) {
                    const m = nodes[j];
                    const dx = n.x - m.x;
                    const dy = n.y - m.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 130) {
                        ctx.beginPath();
                        ctx.moveTo(n.x, n.y);
                        ctx.lineTo(m.x, m.y);
                        // L'opacité diminue avec la distance, multipliée par 0.5 pour ne pas être trop agressive
                        ctx.strokeStyle = `rgba(${orangeRgb}, ${0.4 * (1 - dist / 130)})`;
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                }
            }

            requestAnimationFrame(draw);
        }

        draw();
    });
</script>
