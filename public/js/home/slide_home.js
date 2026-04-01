document.addEventListener('DOMContentLoaded', () => {
    const slides = [
        {
            url: "/media/img/slides/photo2.png",
            tag: window.translations.slides[0].tag,
            title: window.translations.slides[0].title,
            desc: window.translations.slides[0].desc
        },
        {
            url: "/media/img/slides/photo3.png",
            tag: window.translations.slides[1].tag,
            title: window.translations.slides[1].title,
            desc: window.translations.slides[1].desc
        },
        {
            url: "/media/img/slides/photo1.png",
            tag: window.translations.slides[2].tag,
            title: window.translations.slides[2].title,
            desc: window.translations.slides[2].desc
        }
    ];

    let index = 0;
    const currentContainer = document.getElementById('current-slide-container');
    const currentImg = document.getElementById('current-slide');
    const nextImg = document.getElementById('next-slide');
    const scannerBar = document.getElementById('scanner-bar');
    const content = document.getElementById('slide-content');

    function startScan() {
        // 1. Préparer l'image suivante en fond
        let nextIndex = (index + 1) % slides.length;
        nextImg.src = slides[nextIndex].url;
        nextImg.style.opacity = "1";

        // 2. Animation du contenu (Fade out bas)
        content.classList.add('translate-y-10', 'opacity-0');

        // 3. Animation du Scan
        scannerBar.style.opacity = "1";
        scannerBar.style.left = "0%";

        // Animation fluide de la barre et du clip-path
        let startTime = null;
        const duration = 1800; // 1.8 secondes pour le scan

        function animate(timestamp) {
            if (!startTime) startTime = timestamp;
            let progress = (timestamp - startTime) / duration;

            if (progress <= 1) {
                let percentage = progress * 100;
                scannerBar.style.left = percentage + "%";
                // On "découpe" l'image actuelle de gauche à droite
                currentContainer.style.clipPath = `inset(0 0 0 ${percentage}%)`;
                requestAnimationFrame(animate);
            } else {
                finalizeTransition(nextIndex);
            }
        }
        requestAnimationFrame(animate);
    }

    function finalizeTransition(nextIndex) {
        // Mettre à jour l'image actuelle
        index = nextIndex;
        currentImg.src = slides[index].url;
        currentContainer.style.clipPath = `inset(0 0 0 0%)`;

        // Mettre à jour le texte
        document.getElementById('slide-tag').innerText = slides[index].tag;
        document.getElementById('slide-title').innerText = slides[index].title;
        document.getElementById('slide-desc').innerText = slides[index].desc;

        // Réinitialiser la barre
        scannerBar.style.opacity = "0";
        scannerBar.style.left = "0%";

        // Faire réapparaître le texte
        content.classList.remove('translate-y-10', 'opacity-0');
    }

    // Lancer toutes les 6 secondes (1.8s de scan + 4.2s de lecture)
    setInterval(startScan, 6000);
});
