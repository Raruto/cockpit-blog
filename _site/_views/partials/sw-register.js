if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker
      .register('@base("/sw.js")')
      .then(function(registration) {
        console.log('PWA: service worker ready');
        registration.update();
      })
      .catch(function(error) {
        console.log('PWA: Registration failed with ' + error);
      });
  });
}
