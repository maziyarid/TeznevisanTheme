(function () {
  'use strict';

  if (window.TeznevisanMobileMenu && window.TeznevisanMobileMenu.initialized) {
    return;
  }

  var api = {
    initialized: false,
    open: false,
    trigger: null,
    menu: null,
    closeButton: null,
    overlay: null,
    lastFocused: null,
    scrollTop: 0,
    focusHandler: null,
    keyHandler: null
  };

  function first(selectors) {
    for (var i = 0; i < selectors.length; i += 1) {
      var element = document.querySelector(selectors[i]);
      if (element) return element;
    }
    return null;
  }

  function getFocusable() {
    if (!api.menu) return [];
    return Array.prototype.slice.call(api.menu.querySelectorAll(
      'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    ));
  }

  function setState(isOpen) {
    api.open = isOpen;
    document.body.classList.toggle('mobile-menu-open', isOpen);
    document.body.classList.toggle('mobile-menu-active', isOpen);

    if (api.trigger) {
      api.trigger.classList.toggle('active', isOpen);
      api.trigger.classList.toggle('is-active', isOpen);
      api.trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    if (api.menu) {
      api.menu.classList.toggle('is-open', isOpen);
      api.menu.classList.toggle('active', isOpen);
      api.menu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
      if ('hidden' in api.menu) api.menu.hidden = !isOpen;
    }

    if (api.overlay && api.overlay !== api.menu) {
      api.overlay.classList.toggle('is-open', isOpen);
      api.overlay.classList.toggle('active', isOpen);
      api.overlay.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    }
  }

  function lockScroll() {
    api.scrollTop = window.pageYOffset || document.documentElement.scrollTop || 0;
    document.body.style.position = 'fixed';
    document.body.style.top = '-' + api.scrollTop + 'px';
    document.body.style.left = '0';
    document.body.style.right = '0';
    document.body.style.width = '100%';
  }

  function unlockScroll() {
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.left = '';
    document.body.style.right = '';
    document.body.style.width = '';
    window.scrollTo(0, api.scrollTop);
  }

  function openMenu() {
    if (api.open) return;
    api.lastFocused = document.activeElement;
    setState(true);
    lockScroll();
    if (api.focusHandler) document.removeEventListener('keydown', api.focusHandler);
    api.focusHandler = function (event) {
      if (!api.open || event.key !== 'Tab') return;
      var items = getFocusable();
      if (!items.length) return;
      var firstItem = items[0];
      var lastItem = items[items.length - 1];
      if (event.shiftKey && document.activeElement === firstItem) {
        event.preventDefault();
        lastItem.focus();
      } else if (!event.shiftKey && document.activeElement === lastItem) {
        event.preventDefault();
        firstItem.focus();
      }
    };
    document.addEventListener('keydown', api.focusHandler);
    var items = getFocusable();
    if (items.length) items[0].focus();
  }

  function closeMenu() {
    if (!api.open) return;
    setState(false);
    unlockScroll();
    if (api.focusHandler) {
      document.removeEventListener('keydown', api.focusHandler);
      api.focusHandler = null;
    }
    if (api.lastFocused && typeof api.lastFocused.focus === 'function') api.lastFocused.focus();
  }

  function toggleMenu(event) {
    if (event) event.preventDefault();
    if (api.open) closeMenu(); else openMenu();
  }

  function init() {
    api.trigger = first(['.mobile-menu-toggle', '#mobile-menu-toggle', '.hamburger-menu', '.mobile-nav-toggle', '[data-mobile-toggle]']);
    api.menu = first(['#mobile-menu-overlay', '#mobile-navigation', '.mobile-menu-overlay', '.mobile-menu']);
    api.overlay = first(['#mobile-menu-overlay', '.mobile-menu-overlay']) || api.menu;
    api.closeButton = first(['#mobile-menu-close', '.mobile-menu-close', '[data-mobile-close]']);

    if (!api.trigger || !api.menu) return;
    api.initialized = true;
    window.TeznevisanMobileMenu = api;
    api.trigger.addEventListener('click', toggleMenu);
    if (api.closeButton) api.closeButton.addEventListener('click', function (event) {
      event.preventDefault();
      closeMenu();
    });
    if (api.overlay && api.overlay !== api.menu) api.overlay.addEventListener('click', function (event) {
      if (event.target === api.overlay) closeMenu();
    });
    api.menu.addEventListener('click', function (event) {
      if (event.target.closest && event.target.closest('a')) closeMenu();
    });
    api.keyHandler = function (event) {
      if (event.key === 'Escape' && api.open) closeMenu();
    };
    document.addEventListener('keydown', api.keyHandler);
    window.addEventListener('resize', function () {
      if (window.innerWidth > 768 && api.open) closeMenu();
    });
    setState(false);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();