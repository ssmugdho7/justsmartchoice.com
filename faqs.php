<?php
// faqs.php
require_once __DIR__ . '/includes/cms-engine.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CLX99EJXW2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CLX99EJXW2');
</script>

<?php include __DIR__ . '/includes/cookie-consent-head.php'; ?>
<?php echo cms_head_scripts(); ?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">

<title><?php echo htmlspecialchars(cms_field('faqs', 'seo.title', 'Construction FAQs Tampa Bay FL | Smart Choice Contractors USA')); ?></title>
<link rel="canonical" href="https://justsmartchoice.com/faqs.php">

<meta name="description" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.description', 'Frequently asked questions about construction, remodeling, permits, Florida building codes, Notice of Commencement, financing, warranties, electrical, plumbing, roofing, kitchens, bathrooms, and project planning in Tampa Bay Florida.')); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.keywords', 'Construction FAQs Tampa Bay, Remodeling Questions Florida, Florida Contractor FAQ, Notice of Commencement Florida, Tampa Bay Building Permit Questions, Smart Choice Contractors USA FAQs')); ?>">
<meta name="author" content="Smart Choice Contractors USA">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

<meta property="og:title" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.title', 'Construction FAQs Tampa Bay FL | Smart Choice Contractors USA')); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.description', 'Answers to common questions about construction, remodeling, permits, Florida building code, financing, electrical, plumbing, roofing, and project planning.')); ?>">
<meta property="og:url" content="https://justsmartchoice.com/faqs.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.og_image', '/images/fg-image.png')); ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.title', 'Construction FAQs Tampa Bay FL')); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.description', 'Construction and remodeling FAQ page for Tampa Bay Florida homeowners and commercial property owners.')); ?>">
<meta name="twitter:image" content="<?php echo htmlspecialchars(cms_field('faqs', 'seo.og_image', '/images/fg-image.png')); ?>">

<script src="https://analytics.ahrefs.com/analytics.js" data-key="9gWoEoaoQSTW3cXLEcA/Qg" async></script>
<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&display=swap">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/custom.css?v=60">

</head>

<body>

<?php include __DIR__ . '/includes/cookie-consent.php'; ?>
<?php include __DIR__ . '/sections-library/header.php'; ?>

<div class="page">

  <!-- HERO SECTION -->
  <section class="section-sm smart-faq-hero">
    <div class="container">
      <div class="smart-faq-card">
        <span class="smart-eyebrow" <?php echo cms_bind('faqs', 'hero.eyebrow'); ?>>
          <?php echo htmlspecialchars(cms_field('faqs', 'hero.eyebrow', 'Construction Help Center')); ?>
        </span>
        <h1 <?php echo cms_bind('faqs', 'hero.title'); ?>>
          <?php echo htmlspecialchars(cms_field('faqs', 'hero.title', 'Frequently Asked Questions')); ?>
        </h1>
        <p <?php echo cms_bind('faqs', 'hero.description'); ?>>
          <?php echo htmlspecialchars(cms_field('faqs', 'hero.description', 'Find answers about construction, remodeling, Florida permits, Notice of Commencement, financing, warranties, electrical work, plumbing, roofing, kitchens, bathrooms, drawings, and project planning in Tampa Bay Florida.')); ?>
        </p>
        <div style="margin-top: 18px;">
          <a href="/pricing.php" class="btn btn-sm btn-primary" style="font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 6px;">
            <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Construction Pricing &amp; Rates Guide
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ GROUPS -->
  <?php 
  $groups = cms_field('faqs', 'groups', []);
  foreach ($groups as $gIdx => $group):
      $bgClass = ($gIdx % 2 === 1) ? 'bg-gray-100' : '';
  ?>
  <section class="section-sm <?php echo $bgClass; ?>">
    <div class="container">

      <div class="smart-section-heading">
        <h2 <?php echo cms_bind('faqs', "groups.{$gIdx}.heading"); ?>>
          <?php echo htmlspecialchars($group['heading'] ?? ''); ?>
        </h2>
        <p <?php echo cms_bind('faqs', "groups.{$gIdx}.subheading"); ?>>
          <?php echo htmlspecialchars($group['subheading'] ?? ''); ?>
        </p>
      </div>

      <div class="smart-faq-list">
        <?php 
        $items = $group['items'] ?? [];
        foreach ($items as $iIdx => $item):
        ?>
        <details class="smart-faq-item" <?php echo ($gIdx === 0 && $iIdx === 0) ? 'open' : ''; ?>>
          <summary <?php echo cms_bind('faqs', "groups.{$gIdx}.items.{$iIdx}.q"); ?>>
            <?php echo htmlspecialchars($item['q'] ?? ''); ?>
          </summary>
          <div class="smart-faq-answer">
            <p <?php echo cms_bind('faqs', "groups.{$gIdx}.items.{$iIdx}.a"); ?>>
              <?php echo htmlspecialchars($item['a'] ?? ''); ?>
            </p>
          </div>
        </details>
        <?php endforeach; ?>
      </div>

    </div>
  </section>
  <?php endforeach; ?>

  <!-- BOTTOM CTA SECTION -->
  <section class="section-sm bg-primary text-center" style="background: linear-gradient(135deg, #1b4d3e 0%, #0d2820 100%); color: #fff; padding: 48px 0;">
    <div class="container">
      <h2 class="text-white text-uppercase" style="font-weight: 700; margin-bottom: 12px; font-size: 26px;" <?php echo cms_bind('faqs', 'cta.heading'); ?>>
        <?php echo htmlspecialchars(cms_field('faqs', 'cta.heading', 'Still Have Questions About Your Project?')); ?>
      </h2>
      <p class="text-white-80" style="max-width: 680px; margin: 0 auto 20px auto; font-size: 15.5px; opacity: 0.9;" <?php echo cms_bind('faqs', 'cta.description'); ?>>
        <?php echo htmlspecialchars(cms_field('faqs', 'cta.description', 'Speak with our Florida construction team directly or schedule an upfront consultation to discuss scope, timeline, and pricing.')); ?>
      </p>
      <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
        <a class="btn btn-primary" href="<?php echo htmlspecialchars(cms_field('faqs', 'cta.btn_url', 'contacts.php')); ?>" <?php echo cms_bind('faqs', 'cta.btn_label'); ?> style="font-weight: 700; text-transform: uppercase;">
          <?php echo htmlspecialchars(cms_field('faqs', 'cta.btn_label', 'Schedule a Consultation')); ?>
        </a>
        <a class="btn btn-outline-white" href="/pricing.php" style="color: #fff; border: 2px solid #fff; font-weight: 700; text-transform: uppercase; padding: 10px 22px; border-radius: 4px; text-decoration: none;">
          <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Pricing Guide
        </a>
      </div>
    </div>
  </section>

  <!-- BOTTOM BANNER & FOOTER -->
  <?php include 'sections-library/bottom-banner.html'; ?>
  <?php include __DIR__ . '/sections-library/footer.php'; ?>

</div>

</body>
</html>