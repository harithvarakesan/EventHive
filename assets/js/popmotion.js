// Popmotion CDN loader and simple spring animation demo
// https://popmotion.io/

(function(){
  var script = document.createElement('script');
  script.src = 'https://unpkg.com/@popmotion/popmotion/dist/popmotion.global.min.js';
  script.onload = function() {
    // Example: animate .popmotion-move elements
    if (window.popmotion) {
      var { styler, spring, listen, pointer, value } = window.popmotion;
      document.querySelectorAll('.popmotion-move').forEach(function(el) {
        var divStyler = styler(el);
        listen(el, 'mousedown touchstart').start(function(e) {
          pointer({ x: el.offsetLeft, y: el.offsetTop })
            .pipe(function(v) { return v; })
            .start(spring({
              from: { x: el.offsetLeft, y: el.offsetTop },
              to: { x: el.offsetLeft + 50, y: el.offsetTop },
              stiffness: 200
            }).start(function(v) {
              divStyler.set('x', v.x);
              divStyler.set('y', v.y);
            }));
        });
      });
    }
  };
  document.head.appendChild(script);
})();
