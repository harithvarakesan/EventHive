// assets/js/sidebar-effects.js
// Minimal sidebar transition: fast fade only
// Uses GSAP if available, else CSS opacity

function minimalFadeIn() {
  const main = document.querySelector('main, .main-content, .dashboard-widget, .content-area');
  if (main) {
    if (window.gsap) {
      gsap.fromTo(main, {opacity: 0}, {opacity: 1, duration: 0.25, ease: 'power1.out'});
    } else {
      main.style.transition = 'opacity 0.25s';
      main.style.opacity = 1;
    }
  }
}

window.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('#user-sidebar a').forEach(link => {
    if (link.getAttribute('href') && !link.getAttribute('target')) {
      link.addEventListener('click', function(e) {
        if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
        const main = document.querySelector('main, .main-content, .dashboard-widget, .content-area');
        if (main) {
          if (window.gsap) {
            gsap.to(main, {opacity: 0, duration: 0.15, ease: 'power1.in', onComplete: () => { window.location = link.href; }});
            e.preventDefault();
          } else {
            main.style.transition = 'opacity 0.15s';
            main.style.opacity = 0;
            setTimeout(() => { window.location = link.href; }, 150);
            e.preventDefault();
          }
        }
      });
    }
  });
  minimalFadeIn();
});
