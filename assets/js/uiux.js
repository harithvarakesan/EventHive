  // assets/js/uiux.js
// Core UI/UX enhancements for EventHive
// Requires: gsap.js, anime.js, framer-motion.js, scrollmagic.js, popmotion.js, lottie.js (if needed)

// Fade/slide in cards and sections on load
window.addEventListener('DOMContentLoaded', () => {
  // GSAP fade/slide-in for cards
  if (window.gsap) {
    gsap.utils.toArray('.rounded-2xl, .rounded-xl, .card, .dashboard-widget').forEach((el, i) => {
      gsap.fromTo(el, {opacity: 0, y: 40}, {opacity: 1, y: 0, duration: 0.7, delay: i * 0.08, ease: 'power2.out'});
    });
  }
  // Anime.js for button hover/click
  document.querySelectorAll('button, a').forEach(btn => {
    btn.addEventListener('mouseenter', () => {
      if (window.anime) anime({targets: btn, scale: 1.05, duration: 200, easing: 'easeOutQuad'});
    });
    btn.addEventListener('mouseleave', () => {
      if (window.anime) anime({targets: btn, scale: 1, duration: 200, easing: 'easeOutQuad'});
    });
    btn.addEventListener('mousedown', () => {
      if (window.anime) anime({targets: btn, scale: 0.97, duration: 80, easing: 'easeOutQuad'});
    });
    btn.addEventListener('mouseup', () => {
      if (window.anime) anime({targets: btn, scale: 1.05, duration: 120, easing: 'easeOutQuad'});
    });
  });
  // ScrollMagic for stats/cards
  if (window.ScrollMagic) {
    const controller = new ScrollMagic.Controller();
    document.querySelectorAll('.dashboard-widget, .stat-card').forEach((el) => {
      new ScrollMagic.Scene({triggerElement: el, triggerHook: 0.85, reverse: false})
        .on('enter', function () {
          el.classList.add('animate-pop');
        })
        .addTo(controller);
    });
  }
  // Lottie for animated icons (optional)
  // Example: lottie.loadAnimation({container: document.getElementById('lottie-icon'), ...})
});

// Utility: add animate-pop CSS
(function(){
  const style = document.createElement('style');
  style.innerHTML = `.animate-pop {animation: popIn .5s cubic-bezier(.2,1.5,.5,1) forwards;}
    @keyframes popIn {0%{opacity:0;transform:scale(.8);}100%{opacity:1;transform:scale(1);}}`;
  document.head.appendChild(style);
})();
