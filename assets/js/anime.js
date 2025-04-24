// Anime.js CDN loader and simple fade-in animation demo
// https://animejs.com/

(function(){
  var script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js';
  script.onload = function() {
    // Example: fade in all .fade-in elements
    anime({
      targets: '.fade-in',
      opacity: [0, 1],
      easing: 'easeInOutQuad',
      duration: 1200,
      delay: anime.stagger(120)
    });
  };
  document.head.appendChild(script);
})();
