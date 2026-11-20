(function () {
  'use strict';
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  function init() {
    // Retain the current homepage templates, including production's newer gallery.
    function replaceHeading(heading, tag) {
      var replacement = document.createElement(tag);
      Array.from(heading.attributes).forEach(function (attribute) { replacement.setAttribute(attribute.name, attribute.value); });
      while (heading.firstChild) replacement.appendChild(heading.firstChild);
      heading.replaceWith(replacement);
    }
    document.querySelectorAll('#main-content h1:not(.sc-page-title)').forEach(function (heading) {replaceHeading(heading,'h2');});
    document.querySelectorAll('#main-content h4.panel-heading').forEach(function (heading) {replaceHeading(heading,'h3');});
    document.querySelectorAll('.cta-box-icon,.thumbnail-icon,.btn-icon,.custom-link-icon,.link-arrow').forEach(function (icon) {icon.setAttribute('aria-hidden','true');});
    document.querySelectorAll('a.custom-link').forEach(function (link) {
      if (!link.textContent.trim() && !link.getAttribute('aria-label')) link.setAttribute('aria-label', 'Learn more about Smart Choice');
    });
    document.querySelectorAll('a.section-cta-btn[href="#"]').forEach(function (link) {
      link.setAttribute('href', '/about.php');
      link.setAttribute('aria-label', 'Read more about Smart Choice');
    });

    var mobileLayout = window.matchMedia('(max-width: 991px)');
    ['site-menu-links', 'site-contact-information'].forEach(function (id) {
      var panel = document.getElementById(id);
      var button = document.querySelector('[aria-controls="' + id + '"]');
      if (!panel || !button) return;
      function syncPanel() {
        var open = panel.classList.contains('active');
        panel.inert = mobileLayout.matches && !open;
        button.setAttribute('aria-expanded', String(open));
        var name = id === 'site-menu-links' ? 'main menu' : 'contact information';
        button.setAttribute('aria-label', (open ? 'Close ' : 'Open ') + name);
      }
      new MutationObserver(syncPanel).observe(panel, {attributes:true,attributeFilter:['class']});
      if (mobileLayout.addEventListener) mobileLayout.addEventListener('change', syncPanel);
      panel.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && panel.classList.contains('active')) {
          event.preventDefault();button.click();button.focus();
        }
      });
      syncPanel();
    });

    var oldTop = document.getElementById('ui-to-top');
    if (oldTop) {
      var topButton = document.createElement('button');
      topButton.type = 'button';topButton.id = oldTop.id;topButton.className = oldTop.className;
      topButton.setAttribute('aria-label', 'Back to top');
      oldTop.replaceWith(topButton);
      topButton.addEventListener('click', function () {
        window.scrollTo({top:0,behavior:reducedMotion.matches ? 'auto' : 'smooth'});
      });
      var syncTop = function () {
        var visible = topButton.classList.contains('active');
        topButton.tabIndex = visible ? 0 : -1;
        topButton.setAttribute('aria-hidden', String(!visible));
      };
      new MutationObserver(syncTop).observe(topButton,{attributes:true,attributeFilter:['class']});
      syncTop();
    }

    document.querySelectorAll('.swiper-container').forEach(function (slider) {
      var swiper = slider.swiper;
      if (!swiper) return;
      slider.setAttribute('role', 'region');slider.setAttribute('aria-roledescription', 'carousel');
      slider.setAttribute('aria-label', 'Construction and remodeling highlights');
      var toggle = document.createElement('button');
      toggle.type = 'button';toggle.className = 'sc-carousel-toggle';
      var controls = document.createElement('div');controls.className = 'sc-carousel-controls';controls.appendChild(toggle);
      var pagination = slider.querySelector('.swiper-pagination');
      var container = slider.querySelector('.swiper-overlay .container') || slider;
      container.appendChild(controls);
      if (pagination) { pagination.setAttribute('role','group');pagination.setAttribute('aria-label','Choose a slide'); }
      function syncRotation() {
        var running = !!(swiper.autoplay && swiper.autoplay.running);
        toggle.textContent = running ? 'Pause slideshow' : 'Play slideshow';
        var wrapper = slider.querySelector('.swiper-wrapper');
        if (wrapper) wrapper.setAttribute('aria-live',running ? 'off' : 'polite');
      }
      function pause() { if (swiper.autoplay) swiper.autoplay.stop();syncRotation(); }
      function syncSlides() {
        slider.querySelectorAll('.swiper-slide').forEach(function (slide) {
          var active = slide.classList.contains('swiper-slide-active');
          slide.setAttribute('aria-hidden',String(!active));slide.inert = !active;
        });
        slider.querySelectorAll('.swiper-pagination-bullet').forEach(function (bullet) {
          if (bullet.classList.contains('swiper-pagination-bullet-active')) bullet.setAttribute('aria-current','true');
          else bullet.removeAttribute('aria-current');
        });
      }
      toggle.addEventListener('click',function () {
        if (swiper.autoplay && swiper.autoplay.running) pause();
        else if (swiper.autoplay) {swiper.autoplay.start();syncRotation();}
      });
      slider.addEventListener('focusin',function (event) {if (event.target !== toggle) pause();});
      slider.addEventListener('mouseenter',pause);
      slider.addEventListener('keydown',function (event) {
        if (event.key === ' ' && event.target.classList.contains('swiper-pagination-bullet')) {
          event.preventDefault();event.target.click();
        }
      });
      swiper.on('slideChangeTransitionStart',syncSlides);swiper.on('transitionEnd',syncSlides);
      swiper.on('autoplayStart',syncRotation);swiper.on('autoplayStop',syncRotation);
      if (reducedMotion.addEventListener) reducedMotion.addEventListener('change',function () {if (reducedMotion.matches) pause();});
      if (reducedMotion.matches) pause();
      syncRotation();syncSlides();
    });
  }
  if (window.jQuery) window.jQuery(init);
  else if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded',init);
  else init();
})();
