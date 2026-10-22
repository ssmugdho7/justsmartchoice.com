<?php
// /includes/cookie-consent.php
?>

<div id="cookie-banner" role="dialog" aria-live="polite" aria-label="Cookie consent">
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

<div id="cookie-modal" role="dialog" aria-modal="true" aria-label="Cookie preferences">
  <div class="cm-panel">
    <div class="cm-head">Cookie Preferences</div>

    <div class="cm-body">
      <div class="opt">
        <div>
          <input type="checkbox" id="opt-necessary" checked disabled>
        </div>
        <div>
          <h4>Necessary Cookies</h4>
          <p>Required for basic site functionality, security, cookie preferences, and website operation. These are always enabled.</p>
        </div>
      </div>

      <div class="opt">
        <div>
          <input type="checkbox" id="opt-analytics">
        </div>
        <div>
          <h4>Analytics Cookies</h4>
          <p>Allows Google Analytics to measure website visits, page performance, traffic sources, and visitor behavior so we can improve the website.</p>
        </div>
      </div>

      <div class="opt">
        <div>
          <input type="checkbox" id="opt-marketing">
        </div>
        <div>
          <h4>Marketing Cookies</h4>
          <p>Allows marketing tools such as Facebook Pixel or advertising platforms if configured in the future.</p>
        </div>
      </div>
    </div>

    <div class="cm-actions">
      <button id="cm-cancel" type="button">Cancel</button>
      <button id="cm-save" type="button">Save Preferences</button>
    </div>
  </div>
</div>