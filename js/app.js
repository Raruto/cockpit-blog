/**
 * Simple blog implementation with a router
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 */

/**
 * Detect javascript browsers.
 */
(function(){
  document.documentElement.classList.remove('no-js');
  document.documentElement.classList.add('js');
})();

/*
 * Cookie Alert.
 */
(function() {
  "use strict";

  // (() => {
  //   const e = sessionStorage,
  //     t = e.getItem('dismissedPrivacyPolicyNotice'),
  //     i = document.getElementById('privacy-notice');
  //   t && i.classList.add('hidden'),
  //   document.getElementById('privacy-notice-button-container').addEventListener('click', (() => {
  //     e.setItem('dismissedPrivacyPolicyNotice', 'true'),
  //     i.classList.add('hidden')
  //   }))
  // })(),


  // Cookie functions from w3schools.
  window.setCookie = function(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;samesite=Strict;";
  };

  window.getCookie = function(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) === 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  var cookieAlert = document.querySelector(".cookiealert");
  var acceptButton = cookieAlert.querySelector(".acceptcookies");
  var acceptEvent = document.createEvent('CustomEvent');
  acceptEvent.initCustomEvent('acceptCookies', false, false, null); // ie9 polyfill.
  var acceptCookies = function(e) {
    if (e.type == "scroll" && window.pageYOffset < 100) return;
    // Set cookie expiration to 7 days.
    setCookie("acceptCookies", true, 7);
    cookieAlert.classList.add("d-none");
    cookieAlert.classList.remove("d-block");
    window.removeEventListener('scroll', acceptCookies);
    window.dispatchEvent(acceptEvent);
  };

  if (!cookieAlert || getCookie("acceptCookies")) {
    return window.dispatchEvent(acceptEvent);
  }

  // Show the alert if we cant find the "acceptCookies" cookie.
  if (!getCookie("acceptCookies")) {
    cookieAlert.classList.add("d-block");
    cookieAlert.classList.remove("d-none");
  }

  // Accept cookies on click / scroll.
  acceptButton.addEventListener("click", acceptCookies);
  window.addEventListener('scroll', acceptCookies);

})();

/**
 * Native lazy loading.
 */
(function() {
  // Fade-in effect.
  var images = document.querySelectorAll('img[loading="lazy"]');
  var links = document.querySelectorAll('a[href^="#"]');
  for (var i = 0; i < images.length; i++) {
    if (images[i].complete) images[i].classList.add('lazyloaded');
    else images[i].addEventListener("load", function fadeIn() {
      this.classList.add('lazyloaded');
      this.removeEventListener('load', fadeIn);
    });
  }
  // Fix for: https://github.com/eisbehr-/jquery.lazy/issues/98
  if (!window.chrome)
    for (var j = 0; j < links.length; j++) {
      links[j].addEventListener('click', function(e) {
        if (!this.hash || this.getAttribute('data-scroll') == 'false') return;
        var element = document.querySelector(this.hash);
        if (element) {
          e.preventDefault();
          // scroll to anchor.
          var scrollingElement = document.scrollingElement || document.body;
          var cycle = 0;
          var timer = setInterval(function next() {
            var delta = element.getBoundingClientRect().top - 50;
            var oldScroll = scrollingElement.scrollTop;
            var newScroll = scrollingElement.scrollTop + delta;
            var isBottom = (window.innerHeight + window.pageYOffset) >= scrollingElement.offsetHeight;
            if (cycle++ == 0 || ((delta < -1 || delta > 1) && !isBottom)) scrollingElement.scrollTop = newScroll;
            else clearInterval(timer);
          }, 5);
          // if supported, update the URL
          if (window.history && window.history.pushState) {
            history.pushState("", document.title, this.hash);
          }
        }
      });
    }
})();
