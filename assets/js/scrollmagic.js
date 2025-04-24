// ScrollMagic CDN loader and scroll-based animation demo
// https://scrollmagic.io/

(function(){
  var script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.8/ScrollMagic.min.js';
  script.onload = function() {
    // Example: fade in .scrollmagic-fade elements on scroll
    var controller = new ScrollMagic.Controller();
    document.querySelectorAll('.scrollmagic-fade').forEach(function(el) {
      new ScrollMagic.Scene({
        triggerElement: el,
        triggerHook: 0.9,
        reverse: false
      })
      .setClassToggle(el, 'visible')
      .addTo(controller);
    });
  };
  document.head.appendChild(script);
})();
