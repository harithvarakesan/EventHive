// Lottie CDN loader and demo animation
// https://airbnb.io/lottie/

(function(){
  var script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js';
  script.onload = function() {
    // Example: play animation if #lottie-demo exists
    var container = document.getElementById('lottie-demo');
    if (!container) return;
    lottie.loadAnimation({
      container: container,
      renderer: 'svg',
      loop: true,
      autoplay: true,
      path: 'https://assets4.lottiefiles.com/packages/lf20_5ngs2ksb.json' // Example animation
    });
  };
  document.head.appendChild(script);
})();
