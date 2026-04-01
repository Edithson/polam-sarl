
<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #020617;
        margin: 0;
        overflow-x: hidden;
    }

    .text-gradient {
        background: linear-gradient(to right, #22c55e, #10b981, #a855f7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    #canvas-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .glass-card:hover {
        background: rgba(34, 197, 94, 0.08);
        border-color: rgba(34, 197, 94, 0.4);
        transform: translateY(-10px) scale(1.02);
    }
</style>

<section class="relative min-h-screen w-full flex items-center justify-center overflow-hidden py-20 px-6">

    <canvas id="nexusCanvas"></canvas>

    <div class="relative z-10 max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">

        <div class="space-y-8">
            <div
                class="inline-block px-4 py-2 rounded-full border border-green-500/30 bg-green-500/10 text-green-400 text-sm font-bold tracking-widest uppercase mb-4 animate-pulse">
                Ingénierie Documentaire
            </div>
            <h2 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight">
                Domptez le <span class="text-gradient">Chaos</span>, Libérez la <span class="italic">Valeur.</span>
            </h2>
            <p class="text-gray-400 text-lg md:text-xl leading-relaxed max-w-xl">
                Chez {{ $siteName }}, nous ne classons pas de simples papiers. Nous transformons vos flux documentaires en
                un <strong>actif stratégique</strong> liquide, sécurisé et instantanément exploitable.
            </p>
            <div class="flex flex-wrap gap-6 pt-4">
                <a href="{{ route('contact') }}"
                    class="px-8 py-4 bg-green-600 hover:bg-green-500 text-white font-bold rounded-xl transition-all shadow-[0_0_20px_rgba(34,197,94,0.4)] hover:shadow-[0_0_30px_rgba(34,197,94,0.6)] transform hover:-translate-y-1">
                    Contacter notre équipe
                </a>
                <a href="{{ route('service') }}"
                    class="px-8 py-4 border border-white/20 hover:border-white/50 text-white font-bold rounded-xl transition-all backdrop-blur-sm">
                    Consulter tout nos services
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-purple-600/20 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-green-600/20 rounded-full blur-[120px]"></div>

            <div class="glass-card p-8 rounded-3xl space-y-4 reveal">
                <div
                    class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center text-green-400 font-bold text-2xl">
                    01</div>
                <h4 class="text-xl font-bold text-white">Flux Prioritaire</h4>
                <p class="text-gray-400 text-sm">Nous maîtrisons vos données entrantes avant qu'elles ne deviennent
                    un stock encombrant.</p>
            </div>

            <div class="glass-card p-8 rounded-3xl space-y-4 mt-8 reveal">
                <div
                    class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center text-purple-400 font-bold text-2xl">
                    02</div>
                <h4 class="text-xl font-bold text-white">Valeur Probante</h4>
                <p class="text-gray-400 text-sm">Chaque document numérisé conserve sa force juridique intégrale
                    (SAE).</p>
            </div>

            <div class="glass-card p-8 rounded-3xl space-y-4 reveal">
                <div
                    class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center text-blue-400 font-bold text-2xl">
                    03</div>
                <h4 class="text-xl font-bold text-white">Zéro Papier</h4>
                <p class="text-gray-400 text-sm">Une transition écologique et ergonomique vers le bureau du futur.
                </p>
            </div>

            <div class="glass-card p-8 rounded-3xl space-y-4 mt-8 reveal">
                <div
                    class="w-12 h-12 bg-orange-500/20 rounded-lg flex items-center justify-center text-orange-400 font-bold text-2xl">
                    04</div>
                <h4 class="text-xl font-bold text-white">Intelligence</h4>
                <p class="text-gray-400 text-sm">GEIDE intuitive pour une recherche d'information en moins de 3
                    secondes.</p>
            </div>
        </div>
    </div>
</section>

<script>
    // --- ANIMATION DU CANVA (LE NEXUS) ---
    const canvas = document.getElementById('nexusCanvas');
    const ctx = canvas.getContext('2d');
    let particles = [];
    const particleCount = 80;
    let mouse = { x: null, y: null, radius: 150 };

    window.addEventListener('mousemove', (e) => {
        mouse.x = e.x;
        mouse.y = e.y;
    });

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        canvas.style.position = 'absolute';
        canvas.style.top = '0';
        canvas.style.left = '0';
    }
    window.addEventListener('resize', resize);
    resize();

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2 + 1;
            this.baseX = this.x;
            this.baseY = this.y;
            this.density = (Math.random() * 30) + 1;
            this.color = Math.random() > 0.5 ? '#22c55e' : '#a855f7';
        }

        draw() {
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.closePath();
            ctx.fill();
        }

        update() {
            let dx = mouse.x - this.x;
            let dy = mouse.y - this.y;
            let distance = Math.sqrt(dx * dx + dy * dy);
            let forceDirectionX = dx / distance;
            let forceDirectionY = dy / distance;
            let maxDistance = mouse.radius;
            let force = (maxDistance - distance) / maxDistance;
            let directionX = forceDirectionX * force * this.density;
            let directionY = forceDirectionY * force * this.density;

            if (distance < mouse.radius) {
                this.x -= directionX;
                this.y -= directionY;
            } else {
                if (this.x !== this.baseX) {
                    let dx = this.x - this.baseX;
                    this.x -= dx / 10;
                }
                if (this.y !== this.baseY) {
                    let dy = this.y - this.baseY;
                    this.y -= dy / 10;
                }
            }
        }
    }

    function init() {
        particles = [];
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < particles.length; i++) {
            particles[i].draw();
            particles[i].update();
        }
        connect();
        requestAnimationFrame(animate);
    }

    function connect() {
        let opacityValue = 1;
        for (let a = 0; a < particles.length; a++) {
            for (let b = a; b < particles.length; b++) {
                let dx = particles[a].x - particles[b].x;
                let dy = particles[a].y - particles[b].y;
                let distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < 150) {
                    opacityValue = 1 - (distance / 150);
                    ctx.strokeStyle = `rgba(34, 197, 94, ${opacityValue * 0.2})`;
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(particles[a].x, particles[a].y);
                    ctx.lineTo(particles[b].x, particles[b].y);
                    ctx.stroke();
                }
            }
        }
    }

    init();
    animate();

    // --- ANIMATIONS GSAP AU SCROLL ---
    gsap.registerPlugin(ScrollTrigger);

    gsap.from(".reveal", {
        duration: 1,
        y: 50,
        opacity: 0,
        stagger: 0.2,
        ease: "power4.out",
        scrollTrigger: {
            trigger: "section",
            start: "top 60%",
        }
    });
</script>
