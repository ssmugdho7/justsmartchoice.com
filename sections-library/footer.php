<!-- START: Footer Section -->
<section class="footer-section">

  <!-- REVIEW BOXES: Equal size, complete text, smaller labels and hover shadow -->
  <style>
    .footer-review-blocks {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: stretch;
      gap: 12px;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }

    .footer-review-blocks .footer-review-box {
      flex: 0 1 220px;
      width: 220px;
      max-width: 220px;
      min-width: 0;
      box-sizing: border-box;
      border: 1px solid rgba(0, 0, 0, 0.12);
      border-radius: 8px;
      transition:
        border-color 0.25s ease,
        box-shadow 0.25s ease,
        transform 0.25s ease;
    }

    .footer-review-blocks .footer-review-box:hover {
      border-color: rgba(0, 0, 0, 0.80);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.32);
      transform: translateY(-1px);
    }

    .footer-review-blocks .footer-review-box a {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      width: 100%;
      min-height: 58px;
      padding: 9px 12px;
      box-sizing: border-box;
      text-decoration: none;
      overflow: hidden;
    }

    .footer-review-blocks .footer-review-box img {
      width: 35px;
      height: 35px;
      min-width: 35px;
      max-width: 35px;
      object-fit: contain;
      margin-right: 10px;
      flex-shrink: 0;
    }

    .footer-review-blocks .footer-review-box span {
      display: block;
      min-width: 0;
      flex: 1 1 auto;
      text-align: left;
      line-height: 1.15;
      overflow: hidden;
    }

    .footer-review-blocks .footer-review-box strong {
      display: block;
      font-size: 11px;
      font-weight: 600;
      line-height: 1.2;
      white-space: nowrap;
      overflow: visible;
      text-overflow: clip;
    }

    .footer-review-blocks .footer-review-box small {
      display: block;
      margin-top: 2px;
      font-size: 10px;
      font-weight: 500;
      line-height: 1.2;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    @media (max-width: 991px) {
      .footer-review-blocks .footer-review-box {
        flex: 0 1 220px;
        width: 220px;
        max-width: 220px;
      }
    }

    @media (max-width: 575px) {
      .footer-review-blocks {
        gap: 8px;
      }

      .footer-review-blocks .footer-review-box {
        flex: 0 1 100%;
        width: 100%;
        max-width: 280px;
      }
    }
  </style>

  <footer class="footer section-xs" role="contentinfo">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">

          <p class="footer-cookie-link">
            <a href="#" id="open-cookie-preferences" rel="nofollow">Cookie Preferences</a>
          </p>

          <div class="footer-social-icons" aria-label="Social media links">

            <a href="https://www.facebook.com/smartchoicsolar" target="_blank" rel="noopener" aria-label="Facebook">
              <img src="/images/social/facebook.png" alt="Facebook" width="35" height="35" loading="lazy">
            </a>

            <a href="https://x.com/justsmartchoice" target="_blank" rel="noopener" aria-label="Twitter / X">
              <img src="/images/social/x.png" alt="Twitter / X" width="35" height="35" loading="lazy">
            </a>

            <a href="https://www.instagram.com/justsmartchoice/" target="_blank" rel="noopener" aria-label="Instagram">
              <img src="/images/social/instagram.png" alt="Instagram" width="35" height="35" loading="lazy">
            </a>

            <a href="https://www.linkedin.com/company/justsmartchoice" target="_blank" rel="noopener" aria-label="LinkedIn">
              <img src="/images/social/linkedin.png" alt="LinkedIn" width="35" height="35" loading="lazy">
            </a>

            <a href="https://www.tiktok.com/@justsmartchoice" target="_blank" rel="noopener" aria-label="TikTok">
              <img src="/images/social/tiktok.png" alt="TikTok" width="35" height="35" loading="lazy">
            </a>

            <a href="https://www.pinterest.com/justsmartchoice" target="_blank" rel="noopener" aria-label="Pinterest">
              <img src="/images/social/pinterest.png" alt="Pinterest" width="35" height="35" loading="lazy">
            </a>

            <a href="https://www.youtube.com/@Justsmartchoice" target="_blank" rel="noopener" aria-label="YouTube">
              <img src="/images/social/youtube.png" alt="YouTube" width="35" height="35" loading="lazy">
            </a>

            <a href="https://wa.me/181686896239" target="_blank" rel="noopener" aria-label="WhatsApp">
              <img src="/images/social/whatsapp.png" alt="WhatsApp" width="35" height="35" loading="lazy">
            </a>

            <a href="https://www.trustpilot.com/review/justsmartchoice.com" target="_blank" rel="noopener" aria-label="Trustpilot Reviews">
              <img src="/images/social/trustpilotreviews.png" alt="Trustpilot Reviews" width="35" height="35" loading="lazy">
            </a>

            <a href="https://g.page/r/CSGK2pvNH07nEAI/review" target="_blank" rel="noopener" aria-label="Google Reviews">
              <img src="/images/social/googlereviews1.png" alt="Google Reviews" width="35" height="35" loading="lazy">
            </a>

            <a href="https://nextdoor.com/page/smart-choice-contractors-usa-spring-hill-fl?utm_campaign=1789033134600&amp;share_action_id=b7cafa66-bfe9-4baf-b626-5fa2162dd17d" target="_blank" rel="noopener" aria-label="Nextdoor">
              <img src="/images/social/nextdoor.png" alt="Nextdoor" width="35" height="35" loading="lazy">
            </a>

            <a href="https://www.yelp.com/search?find_desc=Electricians&amp;find_loc=Brooksville%2C+FL" target="_blank" rel="noopener" aria-label="Yelp">
              <img src="/images/social/yelp.png" alt="Yelp" width="35" height="35" loading="lazy">
            </a>

          </div>

          <p class="rights footer-rights">
            Smart Choice Contractors USA &copy; <?php echo date('Y'); ?>. All Rights Reserved.<br>
            Design by <a href="https://www.justsmartchoice.com/">Smart Choice USA</a>
          </p>

          <div class="footer-licenses">
            <strong>CFC1433090</strong> Certified Plumbing Contractor &nbsp;|&nbsp;
            <strong>CGC1505749</strong> Certified General Contractor &nbsp;|&nbsp;
            <strong>EC13013330</strong> Certified Electrical Contractor &nbsp;|&nbsp;
            <strong>CCC1337302</strong> Certified Roofing Contractor
          </div>

          <!-- START: Review Links -->
          <div class="footer-review-blocks">

            <div class="footer-review-box">
              <a href="https://www.trustpilot.com/review/justsmartchoice.com?utm_medium=trustbox&amp;utm_source=TrustBoxReviewCollector" target="_blank" rel="noopener">
                <img src="/images/social/trustpilotreviews.png" alt="Trustpilot Reviews" width="35" height="35" loading="lazy">
                <span>
                  <strong>Leave a review</strong>
                  <small>Trustpilot</small>
                </span>
              </a>
            </div>

            <div class="footer-review-box">
              <a href="https://g.page/r/CSGK2pvNH07nEAI/review" target="_blank" rel="noopener">
                <img src="/images/social/googlereviews1.png" alt="Google Reviews" width="35" height="35" loading="lazy">
                <span>
                  <strong>Leave a review</strong>
                  <small>Google</small>
                </span>
              </a>
            </div>

            <div class="footer-review-box">
              <a href="https://www.facebook.com/profile.php?id=100079490918155&amp;sk=reviews" target="_blank" rel="noopener">
                <img src="/images/social/facebook.png" alt="Facebook Reviews" width="35" height="35" loading="lazy">
                <span>
                  <strong>Leave a review</strong>
                  <small>Facebook</small>
                </span>
              </a>
            </div>

            <div class="footer-review-box">
              <a href="https://www.yelp.com/search?find_desc=Electricians&amp;find_loc=Brooksville%2C+FL" target="_blank" rel="noopener">
                <img src="/images/social/yelp.png" alt="Yelp Reviews" width="35" height="35" loading="lazy">
                <span>
                  <strong>Leave a review</strong>
                  <small>Yelp</small>
                </span>
              </a>
            </div>

          </div>
          <!-- END: Review Links -->

          <div class="row footer-links">

            <div class="col-md-4">
              <h5>Company</h5>
              <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about.php">About Us</a></li>
                <li><a href="/services.php">Services</a></li>
                <li><a href="/pricing.php">Pricing</a></li>
                <li><a href="/financing.php">Financing</a></li>
                <li><a href="/contacts.php">Contact Us</a></li>
                <li><a href="/blog.php">Blog</a></li>
                <li><a href="/login.php">Login</a></li>
              </ul>
            </div>

            <div class="col-md-4">
              <h5>Resources</h5>
              <ul>
                <li><a href="/contracts.php">Contracts</a></li>
                <li><a href="/forms.php">Forms</a></li>
                <li><a href="/faqs.php">FAQs</a></li>
                <li><a href="/toolbox.php">Toolbox</a></li>
                <li><a href="/career.php">Career</a></li>
                <li><a href="/partners.php">Partners</a></li>
                <li><a href="/investors.php">Investors</a></li>
                <li><a href="https://crm.justsmartchoice.com/" target="_blank" rel="noopener">Customer Portal</a></li>
              </ul>
            </div>

            <div class="col-md-4">
              <h5>Legal &amp; Policies</h5>
              <ul>
                <li><a href="/terms.php">Terms of Service</a></li>
                <li><a href="/privacy.php">Privacy Policy</a></li>
                <li><a href="/cookie-policy.php">Cookies Policy</a></li>
                <li><a href="/accessibility.php">Accessibility Statement</a></li>
                <li><a href="/payment-refund-policy.php">Payment &amp; Refund Policy</a></li>
                <li><a href="/sms-communications-policy.php">SMS &amp; Communications Policy</a></li>
                <li><a href="/legal.php">Legal</a></li>
                <li><a href="/sitemap.php">Sitemap</a></li>
              </ul>
            </div>

          </div>

        </div>
      </div>
    </div>
  </footer>

  <div class="form-output snackbars" id="form-output-global"></div>

  <script src="/js/core.min.js"></script>
  <script src="/js/script.js"></script>
  <script src="/js/smartchoice-mobile-fix.js?v=20260630"></script>

  <?php include __DIR__ . '/ai-chatbot.php'; ?>

</section>
<!-- END: Footer Section -->