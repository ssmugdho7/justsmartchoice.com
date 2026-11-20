# Repair 42: homepage accessibility

Run `php tests/accessibility_regression.php` for rendered landmark, navigation,
control-name, cookie-label, and dialog markup checks.

For a local browser audit, download axe-core from its official npm package and
point `A11Y_AXE_PATH` at its extracted `axe.min.js`:

```sh
A11Y_AXE_PATH=/private/tmp/axe.min.js php -S 127.0.0.1:53279 -t . tests/accessibility_router.php
```

Open the homepage and select **Run accessibility audit**. The router is restricted
to PHP's development server; HTTP access to the PHP test files returns 404 on the
production PHP runtime. No audit library or test interface is loaded by the site.

Optional private `A11Y_INDEX_PATH` and `A11Y_GALLERY_PATH` snapshots allow testing
production's customized homepage and gallery without replacing their source.

Manual release checks: skip-link focus; cookie dialog Tab/Shift+Tab wrapping,
Escape and focus restoration; mobile menu/contact-panel expansion and Escape;
keyboard slideshow play/pause and Space slide selection; inactive-slide exclusion;
reduced-motion autoplay suppression; 320px reflow; visible focus and image-backed
text contrast. Automated checks do not establish legal ADA compliance or coverage
of every page, content change, or third-party widget.
