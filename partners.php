<?php
// partners.php
require_once __DIR__ . '/includes/cms-engine.php';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZDN6L6KPP7"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-ZDN6L6KPP7');
    </script>

    <?php include __DIR__ . '/includes/cookie-consent-head.php'; ?>
    <?php echo cms_head_scripts(); ?>

    <title><?php echo htmlspecialchars(cms_field('partners', 'seo.title', 'Partners & Suppliers | Smart Choice Contractors USA Tampa Bay')); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo htmlspecialchars(cms_field('partners', 'seo.description', 'Smart Choice Contractors USA partners with trusted vendors and governing agencies to deliver quality, compliant construction and remodeling across the Tampa Bay area.')); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars(cms_field('partners', 'seo.keywords', 'Partners, Building Materials Tampa, Construction Vendors Florida, Smart Choice Contractors USA')); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars(cms_field('partners', 'seo.title', 'Partners - Smart Choice Contractors USA')); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(cms_field('partners', 'seo.description', 'Explore our network of counties, cities, and suppliers that help us deliver durable, compliant, and safe projects for our customers.')); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars(cms_field('partners', 'seo.og_image', 'images/logo-638x310.png')); ?>">
    <meta property="og:url" content="https://www.justsmartchoice.com/partners.php">
    <meta property="og:type" content="website">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="css/style.css">
    
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "Smart Choice USA",
      "url": "https://www.smartchoiceusa.com",
      "logo": "https://www.smartchoiceusa.com/images/logo-638x310.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+1-727-755-3786",
        "contactType": "Customer Service",
        "areaServed": "US",
        "availableLanguage": "English"
      }
    }
    </script>

    <!-- Scoped styles -->
    <style>
      #scu-partners { padding: 30px 0 !important; }
      #scu-partners .intro { max-width: 960px; margin: 0 auto 20px auto; text-align: left; }
      #scu-partners .intro p { font-size: 15.5px; color: #444; line-height: 1.7; margin: 0 0 16px 0; }
      #scu-partners .scroller-shell { display: flex !important; justify-content: center !important; margin: 16px auto !important; }
      #scu-partners .scroller-bg {
        background: #f9f9f9 !important;
        padding: 12px 14px !important;
        border-radius: 10px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,.06) !important;
        max-width: 1200px !important;
        width: 100% !important;
        overflow: hidden !important;
      }
      #scu-partners .rail-title {
        font-size: 18px; font-weight: 700; text-align: center; color: #222; margin: 0 0 10px 0;
      }
      #scu-partners .partners-track {
        display: flex !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        gap: 12px !important;
        will-change: transform !important;
        transform: translateX(0);
        width: max-content !important;
      }
      #scu-partners .partner-chip {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 7px 14px !important;
        border-radius: 9999px !important;
        background: #fff !important;
        border: 1px solid rgba(0,0,0,.08) !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: var(--chip-color, #333) !important;
        white-space: nowrap !important;
        user-select: none !important;
      }
      #scu-partners .row-gap { height: 12px; }
    </style>
</head>
<body>
  <div class="page">
    <?php include __DIR__ . '/includes/cookie-consent.php'; ?>
    <?php include __DIR__ . '/sections-library/header.php'; ?>

    <!-- Partners Intro Section -->
    <section id="scu-partners">
      <div class="container">
        <h1 class="h2 text-center text-uppercase" style="margin-bottom: 18px;" <?php echo cms_bind('partners', 'hero.title'); ?>>
          <?php echo htmlspecialchars(cms_field('partners', 'hero.title', 'Our Trusted Partners & Suppliers')); ?>
        </h1>
        
        <div class="intro">
          <p style="font-size: 17px; font-weight: 500; color: #1e293b; margin-bottom: 20px; line-height: 1.8;" <?php echo cms_bind('partners', 'hero.lead'); ?>>
            <?php echo htmlspecialchars(cms_field('partners', 'hero.lead', 'At Smart Choice Contractors USA, we take pride in delivering exceptional construction, renovation, and remodeling services across the Tampa Bay area. Our results are strengthened by strategic relationships with national retailers, regional distributors, specialty trade suppliers, and local permitting agencies that support consistent lead times, reliable material availability, and code-aligned execution.')); ?>
          </p>

          <?php 
          $paras = cms_field('partners', 'content_paragraphs', []);
          foreach ($paras as $pIdx => $pText):
          ?>
            <p <?php echo cms_bind('partners', "content_paragraphs.{$pIdx}"); ?>>
              <?php echo htmlspecialchars($pText); ?>
            </p>
          <?php endforeach; ?>

          <div style="margin: 25px 0; text-align: center;">
            <a href="/pricing.php" class="btn btn-primary" style="font-weight: 700; text-transform: uppercase; padding: 12px 24px; border-radius: 6px;">
              <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Project Pricing &amp; Rates Guide
            </a>
          </div>
        </div>

        <!-- Counties & Cities Track -->
        <div class="scroller-shell">
          <div class="scroller-bg">
            <div class="rail-title" <?php echo cms_bind('partners', 'counties_cities.rail_title'); ?>>
              <?php echo htmlspecialchars(cms_field('partners', 'counties_cities.rail_title', 'Few of the Counties & Cities We Serve')); ?>
            </div>
            <div class="partners-track" id="track-counties">
              <?php 
              $counties = cms_field('partners', 'counties_cities.chips', []);
              foreach ($counties as $cName):
              ?>
                <span class="partner-chip"><?php echo htmlspecialchars($cName); ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="row-gap"></div>

        <!-- Suppliers & Vendors Track -->
        <div class="scroller-shell">
          <div class="scroller-bg">
            <div class="rail-title" <?php echo cms_bind('partners', 'suppliers_vendors.rail_title'); ?>>
              <?php echo htmlspecialchars(cms_field('partners', 'suppliers_vendors.rail_title', 'Our most important Suppliers & Vendors')); ?>
            </div>
            <div class="partners-track" id="track-suppliers">
              <?php 
              $suppliers = cms_field('partners', 'suppliers_vendors.chips', []);
              foreach ($suppliers as $s):
                $sName = is_array($s) ? ($s['name'] ?? '') : (string)$s;
                $sColor = is_array($s) ? ($s['color'] ?? '#333') : '#333';
              ?>
                <span class="partner-chip" style="--chip-color: <?php echo htmlspecialchars($sColor); ?>;">
                  <?php echo htmlspecialchars($sName); ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- Bottom Banner & Footer -->
    <?php include 'sections-library/bottom-banner.html'; ?>
    <?php include __DIR__ . '/sections-library/footer.php'; ?>
  </div>

  <script>
    (function(){
      function initLooper(trackId, speedPxPerFrame) {
        const track = document.getElementById(trackId);
        if (!track) return;

        const originals = Array.from(track.children);
        if (originals.length === 0) return;
        originals.forEach(node => track.appendChild(node.cloneNode(true)));

        const shell = track.closest('.scroller-bg');
        function ensureWidth(){
          let guard = 0;
          while (track.scrollWidth < shell.clientWidth * 2 && guard < 8) {
            originals.forEach(node => track.appendChild(node.cloneNode(true)));
            guard++;
          }
        }
        ensureWidth();

        let x = 0;
        function step(){
          x -= speedPxPerFrame;
          const resetAt = track.scrollWidth / 2;
          if (Math.abs(x) >= resetAt) x = 0;
          track.style.transform = 'translateX(' + x + 'px)';
          requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
      }

      document.addEventListener('DOMContentLoaded', function(){
        initLooper('track-counties', 1.2);
        initLooper('track-suppliers', 1.6);
      });
    })();
  </script>
</body>
</html>
