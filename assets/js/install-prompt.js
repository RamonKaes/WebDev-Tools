/**
 * Install button
 *
 * Shows the floating "Install as app" button (#bd-install in
 * partials/header-with-sidebar.php) only while the browser offers to install
 * the site, which Chromium announces with `beforeinstallprompt`, and never
 * inside the installed app. The event is intercepted so the browser shows no
 * bar of its own; a click on the button opens the browser's install dialog.
 * Each offer is good for one dialog, so the button disappears once it is
 * used. There is no service worker: nothing is cached on the device, the
 * button only puts the site on the home screen or desktop.
 */
(function () {
  'use strict';

  let offer = null;

  function isStandalone() {
    return typeof window.matchMedia === 'function'
      && window.matchMedia('(display-mode: standalone)').matches;
  }

  function render() {
    const wrapper = document.querySelector('.bd-install-toggle');
    if (!wrapper) return;
    wrapper.classList.toggle('d-none', offer === null || isStandalone());
  }

  window.addEventListener('beforeinstallprompt', function (event) {
    event.preventDefault();
    offer = event;
    render();
  });

  window.addEventListener('appinstalled', function () {
    offer = null;
    render();
  });

  document.addEventListener('click', function (event) {
    const button = event.target.closest ? event.target.closest('#bd-install') : null;
    if (!button || offer === null) return;
    const current = offer;
    offer = null;
    render();
    Promise.resolve(current.prompt()).catch(function () {});
  });

  render();
})();
