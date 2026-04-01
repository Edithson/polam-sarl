
<style>

    canvas {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .grain::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url("https://grainy-gradients.vercel.app/noise.svg");
        opacity: 0.05;
        pointer-events: none;
    }

    .glow {
        text-shadow: 0 0 40px rgba(34, 197, 94, .35);
    }
</style>

{{-- mettre cette couleur en fond #050607 --}}
<section class="bg-[#050607] relative min-h-screen flex items-center justify-center grain overflow-hidden">
    <img src="{{ asset('media/img/services/cta_service2.png') }}" alt="appel à l'action service" class="absolute inset-0 w-full h-full object-cover object-center opacity-40 z-0" />

    <!-- Canvas animé -->
    <canvas id="flow"></canvas>

    <!-- Contenu -->
    <div class="relative z-10 max-w-5xl px-6 text-center">
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-white glow">
            La mémoire<br />
            <span class="text-emerald-400">n’est pas figée.</span>
        </h1>

        <p class="mt-8 text-xl md:text-2xl text-gray-300 leading-relaxed">
            Chaque document a une vie.<br />
            Nous concevons les systèmes qui lui donnent
            <span class="text-white font-semibold">sens, traçabilité et valeur probante</span>.
        </p>

        <div class="mt-12 flex justify-center gap-6">
            <a href="{{ route('contact') }}" class="px-8 py-4 bg-emerald-400 text-black font-bold rounded-xl hover:scale-105 transition">
                Contactez-nous
            </a>
            <a href="{{ route('about') }}" class="px-8 py-4 border border-white/30 text-white rounded-xl hover:bg-white/10 transition">
                Comprendre notre vision
            </a>
        </div>
    </div>

</section>

<script>
    const canvas = document.getElementById("flow");
    const ctx = canvas.getContext("2d");

    let w, h;
    function resize() {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener("resize", resize);

    const nodes = Array.from({ length: 120 }, () => ({
        x: Math.random() * w,
        y: Math.random() * h,
        vx: (Math.random() - 0.5) * 0.4,
        vy: (Math.random() - 0.5) * 0.4,
    }));

    function draw() {
        ctx.clearRect(0, 0, w, h);

        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            n.x += n.vx;
            n.y += n.vy;

            if (n.x < 0 || n.x > w) n.vx *= -1;
            if (n.y < 0 || n.y > h) n.vy *= -1;

            ctx.beginPath();
            ctx.arc(n.x, n.y, 2, 0, Math.PI * 2);
            ctx.fillStyle = "rgba(34,197,94,0.8)";
            ctx.fill();

            for (let j = i + 1; j < nodes.length; j++) {
                const m = nodes[j];
                const dx = n.x - m.x;
                const dy = n.y - m.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.moveTo(n.x, n.y);
                    ctx.lineTo(m.x, m.y);
                    ctx.strokeStyle = `rgba(34,197,94,${1 - dist / 120})`;
                    ctx.stroke();
                }
            }
        }

        requestAnimationFrame(draw);
    }

    draw();
</script>
