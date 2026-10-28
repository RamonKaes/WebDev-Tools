'use strict';

/**
 * Unit tests for assets/js/install-prompt.js
 *
 * The floating install button is hidden until the browser fires
 * `beforeinstallprompt`, a click opens the browser's dialog once, and the
 * button never shows inside the installed (standalone) app.
 */

const path = require('path');

let standalone = false;

function mountButton() {
  document.body.innerHTML = `
    <div class="position-fixed end-0 me-3 bd-install-toggle d-none">
      <button id="bd-install" type="button"><svg></svg></button>
    </div>`;
}

function offerInstall() {
  const event = new Event('beforeinstallprompt', { cancelable: true });
  event.prompt = jest.fn(() => Promise.resolve());
  window.dispatchEvent(event);
  return event;
}

function isHidden() {
  return document.querySelector('.bd-install-toggle').classList.contains('d-none');
}

beforeAll(() => {
  window.matchMedia = jest.fn(() => ({ matches: standalone }));
  mountButton();
  require(path.join(__dirname, '../../assets/js/install-prompt.js'));
});

beforeEach(() => {
  standalone = false;
  mountButton();
});

describe('install button', () => {
  test('stays hidden until the browser offers an install', () => {
    expect(isHidden()).toBe(true);
  });

  test('shows after beforeinstallprompt and intercepts the browser bar', () => {
    const event = offerInstall();
    expect(event.defaultPrevented).toBe(true);
    expect(isHidden()).toBe(false);
    window.dispatchEvent(new Event('appinstalled'));
  });

  test('a click opens the dialog once and hides the button again', () => {
    const event = offerInstall();
    document.getElementById('bd-install').querySelector('svg').dispatchEvent(new MouseEvent('click', { bubbles: true }));
    expect(event.prompt).toHaveBeenCalledTimes(1);
    expect(isHidden()).toBe(true);
    document.getElementById('bd-install').click();
    expect(event.prompt).toHaveBeenCalledTimes(1);
  });

  test('hides after the app was installed', () => {
    offerInstall();
    expect(isHidden()).toBe(false);
    window.dispatchEvent(new Event('appinstalled'));
    expect(isHidden()).toBe(true);
  });

  test('never shows inside the installed app', () => {
    standalone = true;
    offerInstall();
    expect(isHidden()).toBe(true);
    window.dispatchEvent(new Event('appinstalled'));
  });

  test('survives a failing prompt()', () => {
    const event = offerInstall();
    event.prompt = jest.fn(() => Promise.reject(new Error('no')));
    expect(() => document.getElementById('bd-install').click()).not.toThrow();
    expect(isHidden()).toBe(true);
  });
});
