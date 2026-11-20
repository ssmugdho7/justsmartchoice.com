<?php
// /includes/cookie-consent.php
?>

<div id="cookie-banner" hidden role="dialog" aria-live="polite" aria-label="Cookie consent">
  <div class="cb-wrap">
    <p>
      We use cookies to improve site navigation, analyze website traffic, support Google Analytics, and improve our construction marketing.
      You can accept, decline, or manage your preferences at any time.
      Read our <a href="/cookie-policy.php" style="color:#9cf;text-decoration:underline;">Cookie Policy</a>.
    </p>

    <div class="cb-actions">
      <button id="cb-decline" type="button">Decline</button>
      <button id="cb-settings" type="button">Settings</button>
      <button id="cb-accept" type="button">Accept</button>
    </div>
  </div>
</div>

<div id="cookie-modal" hidden role="dialog" aria-modal="true" aria-labelledby="cookie-preferences-title" tabindex="-1">
  <div class="cm-panel">
    <h2 class="cm-head" id="cookie-preferences-title">Cookie Preferences</h2>

    <div class="cm-body">
      <div class="opt">
        <div>
          <input type="checkbox" id="opt-necessary" aria-describedby="opt-necessary-description" checked disabled>
        </div>
        <div>
          <h3><label for="opt-necessary">Necessary Cookies</label></h3>
          <p id="opt-necessary-description">Required for basic site functionality, security, cookie preferences, and website operation. These are always enabled.</p>
        </div>
      </div>

      <div class="opt">
        <div>
          <input type="checkbox" id="opt-analytics" aria-describedby="opt-analytics-description">
        </div>
        <div>
          <h3><label for="opt-analytics">Analytics Cookies</label></h3>
          <p id="opt-analytics-description">Allows Google Analytics to measure website visits, page performance, traffic sources, and visitor behavior so we can improve the website.</p>
        </div>
      </div>

      <div class="opt">
        <div>
          <input type="checkbox" id="opt-marketing" aria-describedby="opt-marketing-description">
        </div>
        <div>
          <h3><label for="opt-marketing">Marketing Cookies</label></h3>
          <p id="opt-marketing-description">Allows marketing tools such as Facebook Pixel or advertising platforms if configured in the future.</p>
        </div>
      </div>
    </div>

    <div class="cm-actions">
      <button id="cm-cancel" type="button">Cancel</button>
      <button id="cm-save" type="button">Save Preferences</button>
    </div>
  </div>
</div>