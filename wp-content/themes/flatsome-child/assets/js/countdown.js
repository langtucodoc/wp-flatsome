/**
 * countdown.js
 * Rolling countdown timer for urgency on landing page.
 *
 * Usage: add data-countdown-end attribute (Unix ms timestamp) to any element
 * with class "js-countdown". The timer displays HH:MM:SS.
 *
 * End date is stored in a cookie so it persists across page views for 3 days.
 * After expiry it resets automatically (rolling urgency).
 */

(function () {
  'use strict';

  var COOKIE_KEY = 'btts_countdown_end';
  var DURATION_MS = 3 * 24 * 60 * 60 * 1000; // 3 days

  /**
   * Read a cookie value.
   * @param {string} name
   * @returns {string|null}
   */
  function getCookie(name) {
    var matches = document.cookie.match(
      new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + '=([^;]*)')
    );
    return matches ? decodeURIComponent(matches[1]) : null;
  }

  /**
   * Set a cookie.
   * @param {string} name
   * @param {string} value
   * @param {number} daysToLive
   */
  function setCookie(name, value, daysToLive) {
    var expires = new Date(Date.now() + daysToLive * 86400 * 1000).toUTCString();
    document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/; SameSite=Lax';
  }

  /**
   * Get (or create) the countdown end timestamp.
   * @returns {number} Unix milliseconds
   */
  function getEndTimestamp() {
    var stored = getCookie(COOKIE_KEY);
    if (stored) {
      var ts = parseInt(stored, 10);
      if (ts > Date.now()) {
        return ts;
      }
    }
    // No valid cookie — set new rolling end
    var newEnd = Date.now() + DURATION_MS;
    setCookie(COOKIE_KEY, String(newEnd), 3);
    return newEnd;
  }

  /**
   * Format milliseconds remaining into an object with days/hours/minutes/seconds.
   * @param {number} ms
   * @returns {{days:number, hours:number, minutes:number, seconds:number}}
   */
  function formatRemaining(ms) {
    if (ms <= 0) return { days: 0, hours: 0, minutes: 0, seconds: 0 };
    var totalSeconds = Math.floor(ms / 1000);
    var days         = Math.floor(totalSeconds / 86400);
    var hours        = Math.floor((totalSeconds % 86400) / 3600);
    var minutes      = Math.floor((totalSeconds % 3600) / 60);
    var seconds      = totalSeconds % 60;
    return { days: days, hours: hours, minutes: minutes, seconds: seconds };
  }

  /**
   * Pad number to 2 digits.
   * @param {number} n
   * @returns {string}
   */
  function pad(n) {
    return n < 10 ? '0' + n : String(n);
  }

  /**
   * Update all countdown timer elements in the DOM.
   * @param {number} endTs
   */
  function updateTimers(endTs) {
    var remaining = endTs - Date.now();
    var parts     = formatRemaining(remaining);
    var timers    = document.querySelectorAll('.js-countdown, .countdown-timer');

    timers.forEach(function (el) {
      var daysEl    = el.querySelector('[data-countdown="days"]');
      var hoursEl   = el.querySelector('[data-countdown="hours"]');
      var minsEl    = el.querySelector('[data-countdown="minutes"]');
      var secsEl    = el.querySelector('[data-countdown="seconds"]');

      if (daysEl)  daysEl.textContent  = pad(parts.days);
      if (hoursEl) hoursEl.textContent = pad(parts.hours);
      if (minsEl)  minsEl.textContent  = pad(parts.minutes);
      if (secsEl)  secsEl.textContent  = pad(parts.seconds);

      // If remaining <= 0, reset the cookie so it rolls over
      if (remaining <= 0) {
        setCookie(COOKIE_KEY, String(Date.now() + DURATION_MS), 3);
      }
    });
  }

  /**
   * Bootstrap all countdown timers on the page.
   */
  function init() {
    var timers = document.querySelectorAll('.js-countdown, .countdown-timer');
    if (!timers.length) return;

    var endTs = getEndTimestamp();

    // Initial render
    updateTimers(endTs);

    // Update every second
    setInterval(function () {
      // Re-read in case cookie was refreshed
      endTs = getEndTimestamp();
      updateTimers(endTs);
    }, 1000);
  }

  // Boot when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
