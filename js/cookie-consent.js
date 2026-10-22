// cookie-consent.js
(function () {
  "use strict";

  const COOKIE_NAME = "site_cookie_consent";
  const COOKIE_DAYS = 365;

  function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${encodeURIComponent(value)};path=/;SameSite=Lax;expires=${d.toUTCString()}`;
  }

  function getCookie(name) {
    const v = document.cookie.match("(^|;)\\s*" + name + "\\s*=\\s*([^;]+)");
    return v ? decodeURIComponent(v.pop()) : null;
  }

  function parseConsent() {
    const raw = getCookie(COOKIE_NAME);
    if (!raw) return null;
    try { return JSON.parse(raw); } catch (e) { return null; }
  }

  function openPreferences() {
    document.querySelector(".cc-modal").classList.add("open");
  }

  function closePreferences() {
    document.querySelector(".cc-modal").classList.remove("open");
  }

  function applyConsentAndClose(consentObj) {
    setCookie(COOKIE_NAME, JSON.stringify(consentObj), COOKIE_DAYS);
    closePreferences();
    hideBanner();
    loadConditionalScripts(consentObj);
  }

  function acceptAllThenClose() {
    const consentObj = {
      necessary: true,
      analytics: true,
      marketing: true,
      timestamp: new Date().toISOString()
    };
    applyConsentAndClose(consentObj);
  }

  function acceptOnlyNecessary() {
    const consentObj = {
      necessary: true,
      analytics: false,
      marketing: false,
      timestamp: new Date().toISOString()
    };
    applyConsentAndClose(consentObj);
  }

  function hideBanner() {
    const banner = document.querySelector(".cc-banner");
    if (banner) banner.classList.add("cc-hidden");
  }

  function showBanner() {
    const banner = document.querySelector(".cc-banner");
    if (banner) banner.classList.remove("cc-hidden");
  }

  function loadConditionalScripts(consentObj) {
    // If analytics consent, load Google Analytics (replace MEASUREMENT_ID in PHP include)
    if (consentObj && consentObj.analytics) {
      if (!window.__ga_loaded) {
        const gaScript = document.createElement("script");
        gaScript.async = true;
        // The actual GA script tag is injected server-side with your ID.
        // Here we also define gtag queue to allow inline calls.
        gaScript.src = "/?load=ga"; // small trigger - the PHP include places a handler for this (or fallback below)
        document.head.appendChild(gaScript);
        window.__ga_loaded = true;
      }
    }

    // If marketing consent, load Facebook Pixel
    if (consentObj && consentObj.marketing) {
      if (!window.__fb_loaded) {
        const fbScript = document.createElement("script");
        fbScript.async = true;
        fbScript.src = "/?load=fb"; // trigger handled by PHP include
        document.head.appendChild(fbScript);
        window.__fb_loaded = true;
      }
    }
  }

  // When user saves preferences in modal
  function bindModalControls() {
    const saveBtn = document.getElementById("cc-save-preferences");
    const acceptAllBtn = document.getElementById("cc-accept-all");
    const rejectAllBtn = document.getElementById("cc-reject-all");

    if (saveBtn) {
      saveBtn.addEventListener("click", function () {
        const analytics = document.getElementById("cc-analytics").checked;
        const marketing = document.getElementById("cc-marketing").checked;
        const consentObj = {
          necessary: true,
          analytics: !!analytics,
          marketing: !!marketing,
          timestamp: new Date().toISOString()
        };
        applyConsentAndClose(consentObj);
      });
    }

    if (acceptAllBtn) {
      acceptAllBtn.addEventListener("click", acceptAllThenClose);
    }

    if (rejectAllBtn) {
      rejectAllBtn.addEventListener("click", acceptOnlyNecessary);
    }

    const manageBtn = document.getElementById("cc-manage-btn");
    if (manageBtn) manageBtn.addEventListener("click", openPreferences);

    // Close modal when clicking outside content
    const modal = document.querySelector(".cc-modal");
    if (modal) {
      modal.addEventListener("click", function (e) {
        if (e.target === modal) closePreferences();
      });
    }
  }

  // Initialize
  function init() {
    const consent = parseConsent();
    if (!consent) {
      // show banner
      showBanner();
    } else {
      // If consent exists, hide banner and load conditional scripts
      hideBanner();
      loadConditionalScripts(consent);
    }
    bindModalControls();
  }

  // Wait for DOM
  if (document.readyState === "complete" || document.readyState === "interactive") {
    setTimeout(init, 20);
  } else {
    document.addEventListener("DOMContentLoaded", init);
  }
})();
