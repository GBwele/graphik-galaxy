
// Créer le champ d'étoiles
function createStarField() {
    const wrapper = document.querySelector('.stars-wrapper');
    if (!wrapper) return;
    
    wrapper.innerHTML = '';
    const starCount = window.innerWidth > 768 ? 200 : 100;
    
    for (let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = `${Math.random() * 100}%`;
        star.style.top = `${Math.random() * 100}%`;
        star.style.animationDelay = `${Math.random() * 3}s`;
        const size = Math.random() * 3 + 1;
        star.style.width = `${size}px`;
        star.style.height = `${size}px`;
        wrapper.appendChild(star);
    }
}

// Initialiser quand le DOM est chargé
document.addEventListener('DOMContentLoaded', createStarField);

// Réinitialiser lors du redimensionnement
let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(createStarField, 250);
});