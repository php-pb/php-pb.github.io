// Scroll Reveal Animation
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                // Optional: stop observing after reveal
                // observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with scroll-reveal class
    const revealElements = document.querySelectorAll('.scroll-reveal');
    revealElements.forEach(el => observer.observe(el));
});

// Sombra no header ao rolar
document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('[data-site-header]');
    if (!header) {
        return;
    }

    const onScroll = () => header.classList.toggle('shadow-[0_4px_20px_rgba(8,45,82,.08)]', window.scrollY > 8);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});
