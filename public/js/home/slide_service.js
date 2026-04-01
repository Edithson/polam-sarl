document.addEventListener('DOMContentLoaded', () => {
    // 1. Ton tableau d'images (Chemins relatifs au dossier public)
    const images = [
        "/media/img/slides/photo1.png",
        "/media/img/slides/photo2.png",
        "/media/img/slides/photo3.png",
        "/media/img/slides/photo4.jpg"
    ];

    let currentIndex = 0;
    const sliderElement = document.getElementById('hero-slider');
    const intervalTime = 5000; // 5 secondes

    function changeSlide() {
        // Étape A : On commence par faire disparaître l'image (Fade Out)
        sliderElement.style.opacity = '0';

        // Étape B : On attend la fin de la transition d'opacité (1s) pour changer la source
        setTimeout(() => {
            currentIndex++;

            // Si on arrive à la fin, on revient à 0
            if (currentIndex >= images.length) {
                currentIndex = 0;
            }

            // On change la source de l'image
            sliderElement.src = images[currentIndex];

            // Étape C : Une fois que l'image commence à charger, on la fait réapparaître (Fade In)
            // On utilise onload pour s'assurer que l'image est prête avant de l'afficher
            sliderElement.onload = () => {
                sliderElement.style.opacity = '1';
            };
        }, 1000); // Ce délai doit correspondre à la durée de transition CSS (duration-1000)
    }

    // Lancer le cycle toutes les 5 secondes
    setInterval(changeSlide, intervalTime);
});
