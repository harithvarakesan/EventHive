// Three.js CDN loader and rotating 3D cube demo
// https://threejs.org/

(function(){
  var script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js';
  script.onload = function() {
    // Example: create a 3D cube if #three-demo exists
    var container = document.getElementById('three-demo');
    if (!container) return;
    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
    var renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(200, 200);
    container.appendChild(renderer.domElement);
    var geometry = new THREE.BoxGeometry();
    var material = new THREE.MeshBasicMaterial({ color: 0xff6600 });
    var cube = new THREE.Mesh(geometry, material);
    scene.add(cube);
    camera.position.z = 3;
    function animate() {
      requestAnimationFrame(animate);
      cube.rotation.x += 0.01;
      cube.rotation.y += 0.01;
      renderer.render(scene, camera);
    }
    animate();
  };
  document.head.appendChild(script);
})();
