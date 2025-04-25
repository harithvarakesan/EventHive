// GSAP CDN loader and simple animation demo
// https://greensock.com/gsap/

(function(){
  var script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js';
  script.onload = function() {
    // Example: animate .gsap-bounce elements
    if (window.gsap) {
      gsap.from('.gsap-bounce', {
        y: -50,
        opacity: 0,
        duration: 1,
        stagger: 0.15,
        ease: 'bounce'
      });
    }
  };
  document.head.appendChild(script);
})();
