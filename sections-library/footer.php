<?php require_once __DIR__ . '/../includes/cms-engine.php'; ?>
<!-- START: Footer Section -->
<section class="footer-section smart-choice-footer-wrapper">

  <style>
    /* =========================================================
       SMART CHOICE CONTRACTORS USA - MUTED LIGHT THEMED FOOTER
       Soft Cool Slate / Gentle Sage undertone (#edf3f2 -> #e4ecea).
       Not bright, not harsh white: gentle on eyes with high contrast,
       crisp elevated white cards, brand teal (#169179), and orange (#f47c20).
    ========================================================= */
    .smart-choice-footer-wrapper {
      position: relative;
      background: linear-gradient(180deg, #edf3f2 0%, #e4ecea 100%) !important;
      color: #334155;
      font-family: 'Raleway', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      width: 100% !important;
      display: block;
      clear: both;
      overflow: hidden;
      margin-top: 0;
      border-top: none;
    }

    /* Top Accent Gradient Border */
    .smart-footer-top-accent {
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, #169179 0%, #0057b8 50%, #f47c20 100%);
      display: block;
    }

    /* Trust & License Strip */
    .smart-footer-trust-strip {
      padding: 34px 0 28px;
      border-bottom: 1px solid rgba(22, 145, 121, 0.16);
      background: rgba(255, 255, 255, 0.45);
    }

    .smart-footer-licenses-card {
      background: #ffffff;
      border: 1px solid rgba(22, 145, 121, 0.28);
      border-radius: 12px;
      padding: 16px 20px;
      margin-bottom: 24px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 14px;
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05);
    }

    .smart-footer-lic-label {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #0f172a;
      font-weight: 800;
      font-size: 13.5px;
      letter-spacing: 0.4px;
      text-transform: uppercase;
    }

    .smart-footer-lic-label i {
      color: #f47c20;
      font-size: 18px;
    }

    .smart-footer-lic-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      align-items: center;
    }

    .smart-footer-lic-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
      color: #334155;
      font-weight: 600;
      transition: all 0.25s ease;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .smart-footer-lic-badge:hover {
      border-color: #169179;
      background: #e6f7f3;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(22, 145, 121, 0.15);
    }

    .smart-footer-lic-badge strong {
      color: #0f766e;
      font-family: monospace, sans-serif;
      font-size: 12px;
      letter-spacing: 0.5px;
      font-weight: 800;
    }

    .smart-footer-lic-badge .lic-sep {
      color: #94a3b8;
    }

    /* Review Cards Grid */
    .smart-footer-reviews-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      width: 100%;
    }

    .smart-footer-review-card {
      display: flex;
      align-items: center;
      gap: 12px;
      background: #ffffff;
      border: 1px solid #dbe4ec;
      border-radius: 10px;
      padding: 12px 14px;
      text-decoration: none !important;
      color: #334155 !important;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
      box-shadow: 0 3px 12px rgba(15, 23, 42, 0.05);
    }

    .smart-footer-review-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #169179, #f47c20);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .smart-footer-review-card:hover {
      background: #ffffff;
      border-color: #169179;
      transform: translateY(-3px);
      box-shadow: 0 10px 24px rgba(22, 145, 121, 0.18), 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .smart-footer-review-card:hover::before {
      opacity: 1;
    }

    .smart-footer-review-img {
      width: 38px;
      height: 38px;
      min-width: 38px;
      max-width: 38px;
      object-fit: contain;
      display: block;
      filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.1));
    }

    .smart-footer-review-text {
      min-width: 0;
      flex: 1 1 auto;
      line-height: 1.25;
    }

    .smart-footer-review-stars {
      color: #f59e0b;
      font-size: 12px;
      letter-spacing: 1.5px;
      display: flex;
      align-items: center;
      gap: 4px;
      margin-bottom: 2px;
    }

    .smart-footer-review-stars .star-score {
      font-size: 11px;
      font-weight: 800;
      color: #92400e;
      background: #fef3c7;
      border: 1px solid #fde68a;
      padding: 1px 5px;
      border-radius: 4px;
      letter-spacing: 0;
      margin-left: 2px;
    }

    .smart-footer-review-platform {
      display: block;
      font-size: 13.5px;
      font-weight: 700;
      color: #0f172a;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .smart-footer-review-sub {
      display: block;
      font-size: 11.5px;
      color: #64748b;
      font-weight: 500;
      margin-top: 1px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* Main Footer Columns */
    .smart-footer-main {
      padding: 55px 0 45px;
      background: transparent !important;
    }

    .smart-footer-col {
      margin-bottom: 30px;
    }

    /* Brand Column */
    .smart-footer-logo-box {
      display: inline-block;
      background: #ffffff;
      padding: 8px 16px;
      border-radius: 8px;
      border: 1px solid #dbe4ec;
      box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
      margin-bottom: 18px;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .smart-footer-logo-box:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(15, 23, 42, 0.1);
    }

    .smart-footer-logo-box img {
      height: 48px;
      width: auto;
      max-width: 210px;
      display: block;
      object-fit: contain;
    }

    .smart-footer-tagline {
      font-size: 14px;
      font-weight: 800;
      color: #0f766e;
      margin-bottom: 10px;
      letter-spacing: 0.2px;
      line-height: 1.4;
    }

    .smart-footer-about {
      font-size: 13.5px;
      line-height: 1.65;
      color: #475569;
      margin-bottom: 18px;
    }

    .smart-footer-trust-pills {
      display: flex;
      flex-direction: column;
      gap: 7px;
      margin-bottom: 22px;
    }

    .smart-footer-trust-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 12.5px;
      color: #1e293b;
      font-weight: 600;
    }

    .smart-footer-trust-pill i {
      color: #169179;
      font-size: 15px;
    }

    /* Social Icons in Brand Column */
    .smart-footer-socials {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      align-items: center;
    }

    .smart-footer-socials a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #ffffff;
      border: 1px solid #cbd5e1;
      box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05);
      transition: all 0.25s ease;
      overflow: hidden;
      padding: 4px;
    }

    .smart-footer-socials a img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
      transition: transform 0.25s ease;
    }

    .smart-footer-socials a:hover {
      background: #fff7ed;
      border-color: #f47c20;
      transform: translateY(-3px) scale(1.08);
      box-shadow: 0 6px 14px rgba(244, 124, 32, 0.25);
    }

    .smart-footer-socials a:hover img {
      transform: scale(1.1);
    }

    /* Headings */
    .smart-footer-heading {
      color: #0f172a;
      font-size: 16px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin-bottom: 20px;
      position: relative;
      padding-bottom: 10px;
    }

    .smart-footer-heading::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 36px;
      height: 3px;
      background: linear-gradient(90deg, #169179, #f47c20);
      border-radius: 2px;
    }

    /* Navigation Lists */
    .smart-footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .smart-footer-links li {
      margin-bottom: 10px;
      line-height: 1.4;
    }

    .smart-footer-links a {
      color: #334155;
      text-decoration: none !important;
      font-size: 13.5px;
      font-weight: 600;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .smart-footer-links a i.link-arrow {
      font-size: 10px;
      color: #169179;
      transition: transform 0.2s ease, color 0.2s ease;
    }

    .smart-footer-links a:hover {
      color: #0f172a;
      transform: translateX(4px);
    }

    .smart-footer-links a:hover i.link-arrow {
      color: #f47c20;
      transform: translateX(2px);
    }

    .smart-footer-links a .portal-tag {
      background: #ffedd5;
      color: #c2410c;
      border: 1px solid #fed7aa;
      font-size: 10px;
      font-weight: 800;
      padding: 1px 6px;
      border-radius: 4px;
      text-transform: uppercase;
      margin-left: 6px;
    }

    /* Contact Details Column */
    .smart-footer-contact-list {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-bottom: 20px;
    }

    .smart-footer-contact-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .smart-footer-contact-icon {
      width: 34px;
      height: 34px;
      min-width: 34px;
      border-radius: 8px;
      background: #e6f5f2;
      border: 1px solid #bce6dc;
      color: #0d9488;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      margin-top: 2px;
      flex-shrink: 0;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .smart-footer-contact-content {
      line-height: 1.35;
      font-size: 13px;
    }

    .smart-footer-contact-lbl {
      display: block;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #64748b;
      font-weight: 700;
      margin-bottom: 2px;
    }

    .smart-footer-contact-val {
      color: #1e293b;
      font-size: 13.5px;
      font-weight: 600;
      text-decoration: none !important;
    }

    .smart-footer-contact-val:hover {
      color: #169179;
    }

    .smart-footer-phone-big {
      font-size: 16px;
      font-weight: 800;
      color: #d96512;
      display: block;
      letter-spacing: 0.3px;
    }

    .smart-footer-phone-big:hover {
      color: #b84a00;
      text-decoration: underline;
    }

    .smart-footer-cta-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      background: linear-gradient(135deg, #f47c20 0%, #d96512 100%);
      color: #ffffff !important;
      font-weight: 800;
      font-size: 13.5px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 12px 18px;
      border-radius: 8px;
      text-decoration: none !important;
      box-shadow: 0 6px 18px rgba(244, 124, 32, 0.35);
      transition: all 0.25s ease;
      margin-top: 8px;
    }

    .smart-footer-cta-btn:hover {
      background: linear-gradient(135deg, #e06509 0%, #b84a00 100%);
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(244, 124, 32, 0.45);
      color: #ffffff !important;
    }

    /* Sub-Footer Bottom Bar: Soft Muted Slate */
    .smart-footer-bottom-bar {
      border-top: 1px solid #cbd5e1;
      padding: 22px 0 24px;
      background: #dbe4ea;
      font-size: 12.5px;
      color: #475569;
    }

    .smart-footer-bottom-inner {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 14px;
    }

    .smart-footer-copyright p {
      margin: 0;
      line-height: 1.5;
      color: #475569;
      font-size: 12.5px;
    }

    .smart-footer-copyright strong {
      color: #0f172a;
      font-weight: 800;
    }

    .smart-footer-copyright a {
      color: #0d9488;
      font-weight: 700;
      text-decoration: none;
    }

    .smart-footer-copyright a:hover {
      color: #d96512;
      text-decoration: underline;
    }

    .smart-footer-legal {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 8px 12px;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .smart-footer-legal a {
      color: #334155;
      text-decoration: none;
      font-size: 12px;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .smart-footer-legal a:hover {
      color: #0f766e;
      text-decoration: underline;
    }

    .smart-footer-legal .legal-dot {
      color: #94a3b8;
      font-size: 10px;
    }

    /* Responsive Breakpoints */
    @media (max-width: 1199px) {
      .smart-footer-reviews-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 991px) {
      .smart-footer-main {
        padding: 40px 0 25px;
      }
      .smart-footer-col {
        margin-bottom: 35px;
      }
      .smart-footer-licenses-card {
        flex-direction: column;
        align-items: flex-start;
      }
    }

    @media (max-width: 767px) {
      .smart-footer-reviews-grid {
        grid-template-columns: 1fr;
        gap: 10px;
      }
      .smart-footer-bottom-inner {
        flex-direction: column;
        text-align: center;
        justify-content: center;
      }
      .smart-footer-legal {
        justify-content: center;
      }
      .smart-footer-lic-badges {
        width: 100%;
      }
      .smart-footer-lic-badge {
        flex: 1 1 100%;
        justify-content: space-between;
      }
    }
  </style>

  <!-- Accent top border -->
  <div class="smart-footer-top-accent"></div>

  <!-- Trust & Florida Licensing Verification Strip -->
  <div class="smart-footer-trust-strip">
    <div class="container">

      <!-- Florida State Licenses Badge Bar -->
      <div class="smart-footer-licenses-card">
        <div class="smart-footer-lic-label">
          <i class="fa fa-shield" aria-hidden="true"></i>
          <span>Florida Licensed &amp; Certified Contractor</span>
        </div>
        <div class="smart-footer-lic-badges">
          <?php 
          $footer_lics = cms_global('licenses');
          if (!empty($footer_lics) && is_array($footer_lics)):
              foreach ($footer_lics as $lic): ?>
                <div class="smart-footer-lic-badge">
                  <strong><?php echo htmlspecialchars($lic['code'] ?? ''); ?></strong>
                  <span class="lic-sep">|</span>
                  <span><?php echo htmlspecialchars($lic['title'] ?? ''); ?></span>
                </div>
              <?php endforeach;
          else: ?>
            <div class="smart-footer-lic-badge">
              <strong>CFC1433090</strong> <span class="lic-sep">|</span> <span>Certified Plumbing Contractor</span>
            </div>
            <div class="smart-footer-lic-badge">
              <strong>CGC1505749</strong> <span class="lic-sep">|</span> <span>Certified General Contractor</span>
            </div>
            <div class="smart-footer-lic-badge">
              <strong>EC13013330</strong> <span class="lic-sep">|</span> <span>Certified Electrical Contractor</span>
            </div>
            <div class="smart-footer-lic-badge">
              <strong>CCC1337302</strong> <span class="lic-sep">|</span> <span>Certified Roofing Contractor</span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Verified Customer Review Platforms -->
      <div class="smart-footer-reviews-grid">

        <!-- Google Reviews -->
        <a class="smart-footer-review-card" href="https://g.page/r/CSGK2pvNH07nEAI/review" target="_blank" rel="noopener" aria-label="Review Smart Choice on Google">
          <img class="smart-footer-review-img" src="/images/social/googlereviews1.png" alt="Google Reviews" width="38" height="38" loading="lazy">
          <div class="smart-footer-review-text">
            <div class="smart-footer-review-stars">
              ★★★★★ <span class="star-score">5.0</span>
            </div>
            <strong class="smart-footer-review-platform">Google Reviews</strong>
            <small class="smart-footer-review-sub">Click to leave a review</small>
          </div>
        </a>

        <!-- Trustpilot -->
        <a class="smart-footer-review-card" href="https://www.trustpilot.com/review/justsmartchoice.com?utm_medium=trustbox&amp;utm_source=TrustBoxReviewCollector" target="_blank" rel="noopener" aria-label="Review Smart Choice on Trustpilot">
          <img class="smart-footer-review-img" src="/images/social/trustpilotreviews.png" alt="Trustpilot Reviews" width="38" height="38" loading="lazy">
          <div class="smart-footer-review-text">
            <div class="smart-footer-review-stars">
              ★★★★★ <span class="star-score">4.9</span>
            </div>
            <strong class="smart-footer-review-platform">Trustpilot Verified</strong>
            <small class="smart-footer-review-sub">Verified customer reviews</small>
          </div>
        </a>

        <!-- Facebook Reviews -->
        <a class="smart-footer-review-card" href="https://www.facebook.com/profile.php?id=100079490918155&amp;sk=reviews" target="_blank" rel="noopener" aria-label="Review Smart Choice on Facebook">
          <img class="smart-footer-review-img" src="/images/social/facebook.png" alt="Facebook Reviews" width="38" height="38" loading="lazy">
          <div class="smart-footer-review-text">
            <div class="smart-footer-review-stars">
              ★★★★★ <span class="star-score">5.0</span>
            </div>
            <strong class="smart-footer-review-platform">Facebook Community</strong>
            <small class="smart-footer-review-sub">Recommended by local clients</small>
          </div>
        </a>

        <!-- Yelp -->
        <a class="smart-footer-review-card" href="https://www.yelp.com/search?find_desc=Electricians&amp;find_loc=Brooksville%2C+FL" target="_blank" rel="noopener" aria-label="Review Smart Choice on Yelp">
          <img class="smart-footer-review-img" src="/images/social/yelp.png" alt="Yelp Reviews" width="38" height="38" loading="lazy">
          <div class="smart-footer-review-text">
            <div class="smart-footer-review-stars">
              ★★★★★ <span class="star-score">4.8</span>
            </div>
            <strong class="smart-footer-review-platform">Yelp Local Pro</strong>
            <small class="smart-footer-review-sub">Rated for quality service</small>
          </div>
        </a>

      </div>

    </div>
  </div>

  <!-- Main Multi-Column Footer Grid -->
  <footer class="footer smart-footer-main" role="contentinfo">
    <div class="container">
      <div class="row">

        <!-- Column 1: Brand & Credibility -->
        <div class="col-lg-4 col-md-6 smart-footer-col">
          <div class="smart-footer-logo-box">
            <a href="/index.php" aria-label="Smart Choice Contractors USA Home">
              <img src="<?php echo htmlspecialchars(cms_global('branding.logos.desktop.url', '/images/logo-638x310.png')); ?>" alt="Smart Choice Contractors USA logo" width="210" height="102" loading="lazy">
            </a>
          </div>

          <p class="smart-footer-tagline">
            <?php echo htmlspecialchars(cms_global('branding.tagline', 'Florida Residential and Commercial General Contractor')); ?>
          </p>

          <p class="smart-footer-about">
            Serving Tampa Bay, Spring Hill, Hernando, Pasco, and Hillsborough counties with certified craftsmanship, dependable project management, and transparent pricing.
          </p>

          <div class="smart-footer-trust-pills">
            <span class="smart-footer-trust-pill"><i class="fa fa-check-circle" aria-hidden="true"></i> State Certified &amp; Fully Insured</span>
            <span class="smart-footer-trust-pill"><i class="fa fa-check-circle" aria-hidden="true"></i> Bonded General &amp; Specialty Trades</span>
            <span class="smart-footer-trust-pill"><i class="fa fa-check-circle" aria-hidden="true"></i> Free In-Person Estimates</span>
          </div>

          <!-- Social media icons -->
          <div class="smart-footer-socials" aria-label="Social media links">
            <a href="https://www.facebook.com/smartchoicsolar" target="_blank" rel="noopener" aria-label="Facebook">
              <img src="/images/social/facebook.png" alt="Facebook" width="32" height="32" loading="lazy">
            </a>
            <a href="https://x.com/justsmartchoice" target="_blank" rel="noopener" aria-label="Twitter / X">
              <img src="/images/social/x.png" alt="Twitter / X" width="32" height="32" loading="lazy">
            </a>
            <a href="https://www.instagram.com/justsmartchoice/" target="_blank" rel="noopener" aria-label="Instagram">
              <img src="/images/social/instagram.png" alt="Instagram" width="32" height="32" loading="lazy">
            </a>
            <a href="https://www.linkedin.com/company/justsmartchoice" target="_blank" rel="noopener" aria-label="LinkedIn">
              <img src="/images/social/linkedin.png" alt="LinkedIn" width="32" height="32" loading="lazy">
            </a>
            <a href="https://www.tiktok.com/@justsmartchoice" target="_blank" rel="noopener" aria-label="TikTok">
              <img src="/images/social/tiktok.png" alt="TikTok" width="32" height="32" loading="lazy">
            </a>
            <a href="https://www.pinterest.com/justsmartchoice" target="_blank" rel="noopener" aria-label="Pinterest">
              <img src="/images/social/pinterest.png" alt="Pinterest" width="32" height="32" loading="lazy">
            </a>
            <a href="https://www.youtube.com/@Justsmartchoice" target="_blank" rel="noopener" aria-label="YouTube">
              <img src="/images/social/youtube.png" alt="YouTube" width="32" height="32" loading="lazy">
            </a>
            <a href="https://wa.me/181686896239" target="_blank" rel="noopener" aria-label="WhatsApp">
              <img src="/images/social/whatsapp.png" alt="WhatsApp" width="32" height="32" loading="lazy">
            </a>
            <a href="https://nextdoor.com/page/smart-choice-contractors-usa-spring-hill-fl" target="_blank" rel="noopener" aria-label="Nextdoor">
              <img src="/images/social/nextdoor.png" alt="Nextdoor" width="32" height="32" loading="lazy">
            </a>
          </div>
        </div>

        <!-- Column 2: Contractor Services -->
        <div class="col-lg-3 col-md-6 col-sm-6 smart-footer-col">
          <h5 class="smart-footer-heading">Services</h5>
          <ul class="smart-footer-links">
            <li><a href="/services.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> New Construction &amp; Additions</a></li>
            <li><a href="/services.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Kitchen &amp; Bathroom Remodeling</a></li>
            <li><a href="/services.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Certified Roofing &amp; Repairs</a></li>
            <li><a href="/services.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Electrical &amp; Panel Upgrades</a></li>
            <li><a href="/services.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Certified Plumbing &amp; Repiping</a></li>
            <li><a href="/services/architect-near-me-tampa.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> 3D Drawings &amp; Permit Plans</a></li>
            <li><a href="/concretecalc.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Concrete, Driveways &amp; Slabs</a></li>
            <li><a href="/services.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Commercial Tenant Build-Outs</a></li>
          </ul>
        </div>

        <!-- Column 3: Company & Quick Links -->
        <div class="col-lg-2 col-md-6 col-sm-6 smart-footer-col">
          <h5 class="smart-footer-heading">Company</h5>
          <ul class="smart-footer-links">
            <li><a href="/about.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> About Us</a></li>
            <li><a href="/pricing.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Pricing Guide</a></li>
            <li><a href="/financing.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Financing (0% Avail)</a></li>
            <li><a href="/toolbox.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Contractor Toolbox</a></li>
            <li><a href="/contracts.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Client Contracts</a></li>
            <li><a href="/forms.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Project Forms</a></li>
            <li><a href="/blog.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Construction Blog</a></li>
            <li><a href="/career.php"><i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Join Our Team</a></li>
            <li>
              <a href="https://crm.justsmartchoice.com/" target="_blank" rel="noopener">
                <i class="fa fa-chevron-right link-arrow" aria-hidden="true"></i> Customer Portal <span class="portal-tag">CRM</span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Column 4: Contact & Florida Office -->
        <div class="col-lg-3 col-md-6 smart-footer-col">
          <h5 class="smart-footer-heading">Contact Us</h5>

          <div class="smart-footer-contact-list">

            <!-- Phone -->
            <div class="smart-footer-contact-item">
              <div class="smart-footer-contact-icon">
                <i class="fa fa-phone" aria-hidden="true"></i>
              </div>
              <div class="smart-footer-contact-content">
                <span class="smart-footer-contact-lbl">Call For Estimate</span>
                <a class="smart-footer-phone-big" href="tel:<?php echo htmlspecialchars(cms_global('contact.phone_raw', '+17277553786')); ?>">
                  <?php echo htmlspecialchars(cms_global('contact.phone', '(727) 755-3786')); ?>
                </a>
              </div>
            </div>

            <!-- Email -->
            <div class="smart-footer-contact-item">
              <div class="smart-footer-contact-icon">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </div>
              <div class="smart-footer-contact-content">
                <span class="smart-footer-contact-lbl">Customer Support</span>
                <a class="smart-footer-contact-val" href="mailto:<?php echo htmlspecialchars(cms_global('contact.email', 'customerservice@justsmartchoice.com')); ?>">
                  <?php echo htmlspecialchars(cms_global('contact.email', 'customerservice@justsmartchoice.com')); ?>
                </a>
              </div>
            </div>

            <!-- Address -->
            <div class="smart-footer-contact-item">
              <div class="smart-footer-contact-icon">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </div>
              <div class="smart-footer-contact-content">
                <span class="smart-footer-contact-lbl">Main Office</span>
                <span class="smart-footer-contact-val">
                  <?php echo htmlspecialchars(cms_global('contact.address_street', '1663 US Highway 41')); ?><br>
                  <?php echo htmlspecialchars(cms_global('contact.address_city', 'Spring Hill')); ?>, <?php echo htmlspecialchars(cms_global('contact.address_state', 'FL')); ?> <?php echo htmlspecialchars(cms_global('contact.address_zip', '34610')); ?>
                </span>
              </div>
            </div>

            <!-- Working Hours -->
            <div class="smart-footer-contact-item">
              <div class="smart-footer-contact-icon">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
              </div>
              <div class="smart-footer-contact-content">
                <span class="smart-footer-contact-lbl">Working Hours</span>
                <span class="smart-footer-contact-val">
                  <?php echo htmlspecialchars(cms_global('contact.hours_weekdays', 'Monday–Friday: 8:00 AM–4:00 PM')); ?><br>
                  <?php echo htmlspecialchars(cms_global('contact.hours_saturday', 'Saturday: 8:00 AM–3:00 PM')); ?>
                </span>
              </div>
            </div>

          </div>

          <!-- Appointment Booking Button -->
          <a class="smart-footer-cta-btn" href="<?php echo htmlspecialchars(cms_global('contact.appointment_btn_url', 'https://crm.justsmartchoice.com/appointly/appointments')); ?>" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            <span><?php echo htmlspecialchars(cms_global('contact.appointment_btn_label', 'Book Appointment')); ?></span>
          </a>

        </div>

      </div>
    </div>
  </footer>

  <!-- Bottom Legal & Copyright Bar -->
  <div class="smart-footer-bottom-bar">
    <div class="container">
      <div class="smart-footer-bottom-inner">

        <div class="smart-footer-copyright">
          <p>
            &copy; <?php echo date('Y'); ?> <strong>Smart Choice Contractors USA</strong>. All Rights Reserved.<br class="d-sm-none">
            Design by <a href="https://www.justsmartchoice.com/">Smart Choice USA</a>
          </p>
        </div>

        <ul class="smart-footer-legal" aria-label="Legal links">
          <li><a href="/terms.php">Terms of Service</a></li>
          <li class="legal-dot">&bull;</li>
          <li><a href="/privacy.php">Privacy Policy</a></li>
          <li class="legal-dot">&bull;</li>
          <li><a href="/cookie-policy.php">Cookie Policy</a></li>
          <li class="legal-dot">&bull;</li>
          <li><a href="#" id="open-cookie-preferences" rel="nofollow">Cookie Preferences</a></li>
          <li class="legal-dot">&bull;</li>
          <li><a href="/legal.php">Legal</a></li>
          <li class="legal-dot">&bull;</li>
          <li><a href="/sitemap.php">Sitemap</a></li>
        </ul>

      </div>
    </div>
  </div>

  <div class="form-output snackbars" id="form-output-global"></div>

  <script src="/js/core.min.js"></script>
  <script src="/js/script.js"></script>
  <script src="/js/smartchoice-mobile-fix.js?v=20260630"></script>

  <?php include __DIR__ . '/ai-chatbot.php'; ?>

</section>
<!-- END: Footer Section -->
