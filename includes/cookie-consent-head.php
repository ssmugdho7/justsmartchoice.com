<?php
// /includes/cookie-consent-head.php

$GA_MEASUREMENT_ID = 'G-CLX99EJXW2';
$FB_PIXEL_ID = '';
?>
<style>
#cookie-banner,
#cookie-modal {
  font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
}

#cookie-banner {
  position: fixed;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  background: #111;
  color: #fff;
  padding: 14px 16px;
  display: none;
  box-shadow: 0 -6px 18px rgba(0,0,0,.25);
}

#cookie-banner .cb-wrap {
  max-width: 1100px;
  margin: 0 auto;
  display: flex;
  gap: 12px;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}

#cookie-banner p {
  margin: 0;
  font-size: 14px;
  line-height: 1.45;
}

#cookie-banner .cb-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

#cookie-banner button,
#cookie-modal button {
  border: 0;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 700;
  padding: 10px 14px;
}

#cb-accept,
#cm-save {
  background: #169179;
  color: #fff;
}

#cb-decline,
#cb-settings,
#cm-cancel {
  background: #333;
  color: #fff;
}

#cookie-modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.5);
  display: none;
  z-index: 10000;
}

#cookie-modal .cm-panel {
  background: #fff;
  color: #111;
  max-width: 640px;
  margin: 8vh auto;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 10px 32px rgba(0,0,0,.35);
}

#cookie-modal .cm-head {
  padding: 16px 18px;
  background: #f5f5f5;
  font-weight: 800;
  font-size: 18px;
}

#cookie-modal .cm-body {
  padding: 18px;
}

#cookie-modal .opt {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}

#cookie-modal .opt:last-child {
  border-bottom: 0;
}

#cookie-modal .opt h4 {
  margin: 0 0 4px;
  font-size: 16px;
}

#cookie-modal .opt p {
  margin: 0;
  color: #555;
  font-size: 14px;
}

#cookie-modal .cm-actions {
  padding: 16px 18px;
  display: flex;
  gap: 8px;
  justify-content: flex-end;
  background: #fafafa;
}
</style>

<script>
(function () {
  var GA_ID = <?php echo json_encode($GA_MEASUREMENT_ID); ?>;
  var FB_ID = <?php echo json_encode($FB_PIXEL_ID); ?>;
  var KEY = 'cookie_consent_v2';
  var OLD_KEYS = ['jsc_cookie_ok','site_cookie_consent','cookie_consent'];

  function getConsent() {
    try {
      var raw = localStorage.getItem(KEY);
      return raw ? JSON.parse(raw) : null;
    } catch (e) {
      return null;
    }
  }

  function setConsent(obj) {
    try {
      localStorage.setItem(KEY, JSON.stringify(obj));
    } catch (e) {}
  }

  function loadGA() {
    if (!GA_ID || document.getElementById('ga4-loader')) return;

    var script = document.createElement('script');
    script.async = true;
    script.id = 'ga4-loader';
    script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(GA_ID);
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function () {
      window.dataLayer.push(arguments);
    };

    window.gtag('js', new Date());
    window.gtag('config', GA_ID, { anonymize_ip: true });
  }

  function loadFB() {
    if (!FB_ID || document.getElementById('fb-pixel-loader')) return;
  }

  function applyConsent() {
    var consent = getConsent();
    if (!consent) return;

    if (consent.analytics === true) {
      loadGA();
    }

    if (consent.marketing === true) {
      loadFB();
    }
  }

  function showBanner() {
    var banner = document.getElementById('cookie-banner');
    if (banner) banner.style.display = 'block';
  }

  function hideBanner() {
    var banner = document.getElementById('cookie-banner');
    if (banner) banner.style.display = 'none';
    var legacy = document.getElementById('jsc-cookie-banner');
    if (legacy) legacy.style.display = 'none';
  }

  function removeDuplicateCookieBanners() {
    var banners = document.querySelectorAll('#cookie-banner');
    for (var i = 1; i < banners.length; i++) { banners[i].remove(); }
    var modals = document.querySelectorAll('#cookie-modal');
    for (var j = 1; j < modals.length; j++) { modals[j].remove(); }
    var legacy = document.getElementById('jsc-cookie-banner');
    if (legacy) { legacy.style.display = 'none'; }
  }

  function setLegacyConsentKeys() {
    try {
      OLD_KEYS.forEach(function(k){ localStorage.setItem(k, '1'); });
    } catch (e) {}
  }

  function showModal() {
    var modal = document.getElementById('cookie-modal');
    if (modal) modal.style.display = 'block';
  }

  function hideModal() {
    var modal = document.getElementById('cookie-modal');
    if (modal) modal.style.display = 'none';
  }

  function openPreferences() {
    var consent = getConsent() || {
      necessary: true,
      analytics: false,
      marketing: false
    };

    var analytics = document.getElementById('opt-analytics');
    var marketing = document.getElementById('opt-marketing');

    if (analytics) analytics.checked = !!consent.analytics;
    if (marketing) marketing.checked = !!consent.marketing;

    showModal();
  }

  function wireUp() {
    var opener = document.getElementById('open-cookie-preferences');
    if (opener) {
      opener.addEventListener('click', function (event) {
        event.preventDefault();
        openPreferences();
      });
    }

    var accept = document.getElementById('cb-accept');
    var decline = document.getElementById('cb-decline');
    var settings = document.getElementById('cb-settings');
    var cancel = document.getElementById('cm-cancel');
    var save = document.getElementById('cm-save');

    if (accept) {
      accept.addEventListener('click', function () {
        setConsent({
          necessary: true,
          analytics: true,
          marketing: true,
          ts: Date.now()
        });
        setLegacyConsentKeys();
        hideBanner();
        hideModal();
        applyConsent();
      });
    }

    if (decline) {
      decline.addEventListener('click', function () {
        setConsent({
          necessary: true,
          analytics: false,
          marketing: false,
          ts: Date.now()
        });
        setLegacyConsentKeys();
        hideBanner();
        hideModal();
      });
    }

    if (settings) {
      settings.addEventListener('click', function () {
        openPreferences();
      });
    }

    if (cancel) {
      cancel.addEventListener('click', function () {
        hideModal();
      });
    }

    if (save) {
      save.addEventListener('click', function () {
        var analytics = document.getElementById('opt-analytics');
        var marketing = document.getElementById('opt-marketing');

        setConsent({
          necessary: true,
          analytics: analytics ? analytics.checked : false,
          marketing: marketing ? marketing.checked : false,
          ts: Date.now()
        });
        setLegacyConsentKeys();

        hideBanner();
        hideModal();
        applyConsent();
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    removeDuplicateCookieBanners();
    wireUp();

    if (!getConsent()) {
      showBanner();
    }

    applyConsent();
  });
})();
</script>