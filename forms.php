<?php
// forms.php
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

<title><?php echo htmlspecialchars(cms_field('forms', 'seo.title', 'Construction Forms Tampa Bay FL | NOC, Permits, Bid Forms & Contractor Documents')); ?></title>
<link rel="canonical" href="https://justsmartchoice.com/forms.php">

<meta name="description" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.description', 'Access construction forms for Tampa Bay Florida including Notice of Commencement forms, county permit forms, bid proposal resources, lien waivers, change orders, subcontractor forms, and contractor documents.')); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.keywords', 'Florida Notice of Commencement, Tampa Bay Construction Forms, Hillsborough County NOC, Pasco County NOC, Hernando County NOC, Pinellas County NOC, Construction Bid Forms Florida, Contractor Forms Tampa Bay')); ?>">
<meta name="author" content="Smart Choice Contractors USA">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

<meta property="og:title" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.title', 'Construction Forms Tampa Bay FL | Smart Choice Contractors USA')); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.description', 'Construction forms, NOC links, permit forms, bid proposal resources, lien waivers, change orders, and contractor document resources for Florida projects.')); ?>">
<meta property="og:url" content="https://justsmartchoice.com/forms.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.og_image', '/images/fg-image.png')); ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.title', 'Construction Forms Tampa Bay FL')); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.description', 'Florida construction forms, NOC links, bid proposal resources, and contractor documents.')); ?>">
<meta name="twitter:image" content="<?php echo htmlspecialchars(cms_field('forms', 'seo.og_image', '/images/fg-image.png')); ?>">

<script src="https://analytics.ahrefs.com/analytics.js" data-key="9gWoEoaoQSTW3cXLEcA/Qg" async></script>
<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/custom.css?v=60">

</head>

<body>

<?php include __DIR__ . '/includes/cookie-consent.php'; ?>
<?php include __DIR__ . '/sections-library/header.php'; ?>

<div class="page">

  <!-- HERO SECTION -->
  <section class="section-sm smart-forms-hero">
    <div class="container">
      <div class="smart-forms-card">
        <span class="smart-eyebrow" <?php echo cms_bind('forms', 'hero.eyebrow'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'hero.eyebrow', 'Construction Document Center')); ?>
        </span>
        <h1 <?php echo cms_bind('forms', 'hero.title'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'hero.title', 'Construction Forms, NOC Links, Permit Forms & Bid Resources')); ?>
        </h1>
        <p <?php echo cms_bind('forms', 'hero.description'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'hero.description', 'Use this page to access Florida construction forms, Tampa Bay county Notice of Commencement resources, permit form pages, bid proposal resources, lien documents, change orders, and contractor paperwork used for residential and commercial construction projects.')); ?>
        </p>
        <div style="margin-top: 18px;">
          <a href="/pricing.php" class="btn btn-sm btn-primary" style="font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 6px;">
            <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Project Pricing &amp; Estimate Guide
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- COUNTY NOC FORMS -->
  <section class="section-sm">
    <div class="container">

      <div class="smart-section-heading">
        <h2 <?php echo cms_bind('forms', 'noc_section.heading'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'noc_section.heading', 'County Notice of Commencement Forms')); ?>
        </h2>
        <p <?php echo cms_bind('forms', 'noc_section.subheading'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'noc_section.subheading', 'NOC requirements may vary by project type, permit type, project value, and jurisdiction. Always confirm with the local building department or clerk before recording or uploading documents.')); ?>
        </p>
      </div>

      <div class="smart-forms-grid">
        <?php 
        $nocItems = cms_field('forms', 'noc_section.items', []);
        foreach ($nocItems as $nIdx => $noc):
        ?>
        <a class="smart-form-box" href="<?php echo htmlspecialchars($noc['url'] ?? '#'); ?>" target="_blank" rel="noopener">
          <strong <?php echo cms_bind('forms', "noc_section.items.{$nIdx}.title"); ?>><?php echo htmlspecialchars($noc['title'] ?? ''); ?></strong>
          <span <?php echo cms_bind('forms', "noc_section.items.{$nIdx}.description"); ?>><?php echo htmlspecialchars($noc['description'] ?? ''); ?></span>
        </a>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- COUNTY PERMIT & BID FORMS -->
  <section class="section-sm bg-gray-100">
    <div class="container">

      <div class="smart-section-heading">
        <h2 <?php echo cms_bind('forms', 'permit_bid_section.heading'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'permit_bid_section.heading', 'County Permit Forms & Bid Proposal Resources')); ?>
        </h2>
        <p <?php echo cms_bind('forms', 'permit_bid_section.subheading'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'permit_bid_section.subheading', 'Links to official county pages where contractors and owners can locate permit applications, building forms, procurement opportunities, bid forms, and proposal submission resources.')); ?>
        </p>
      </div>

      <div class="smart-forms-grid">
        <?php 
        $pbItems = cms_field('forms', 'permit_bid_section.items', []);
        foreach ($pbItems as $pIdx => $pb):
        ?>
        <a class="smart-form-box" href="<?php echo htmlspecialchars($pb['url'] ?? '#'); ?>" target="_blank" rel="noopener">
          <strong <?php echo cms_bind('forms', "permit_bid_section.items.{$pIdx}.title"); ?>><?php echo htmlspecialchars($pb['title'] ?? ''); ?></strong>
          <span <?php echo cms_bind('forms', "permit_bid_section.items.{$pIdx}.description"); ?>><?php echo htmlspecialchars($pb['description'] ?? ''); ?></span>
        </a>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- SMART CHOICE CONSTRUCTION FORMS ACCORDION -->
  <section id="notice-of-commencement" class="section-sm">
    <div class="container">

      <div class="smart-section-heading">
        <h2 <?php echo cms_bind('forms', 'smart_choice_forms.heading'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'smart_choice_forms.heading', 'Smart Choice Construction Forms')); ?>
        </h2>
        <p <?php echo cms_bind('forms', 'smart_choice_forms.subheading'); ?>>
          <?php echo htmlspecialchars(cms_field('forms', 'smart_choice_forms.subheading', 'Internal project forms and document categories used for estimates, contracts, project administration, payment records, construction changes, and closeout.')); ?>
        </p>
      </div>

      <div class="smart-forms-accordion">
        <?php 
        $scForms = cms_field('forms', 'smart_choice_forms.items', []);
        foreach ($scForms as $sIdx => $sc):
        ?>
        <details class="smart-forms-item" <?php echo ($sIdx === 0) ? 'open' : ''; ?>>
          <summary <?php echo cms_bind('forms', "smart_choice_forms.items.{$sIdx}.title"); ?>>
            <?php echo htmlspecialchars($sc['title'] ?? ''); ?>
          </summary>
          <div class="smart-forms-body">
            <p <?php echo cms_bind('forms', "smart_choice_forms.items.{$sIdx}.description"); ?>>
              <?php echo htmlspecialchars($sc['description'] ?? ''); ?>
            </p>
            <a href="contacts.php" class="btn btn-xs btn-outline" style="margin-top: 8px; display: inline-block;">
              Request This Form &rarr;
            </a>
          </div>
        </details>
        <?php endforeach; ?>
      </div>

      <div class="smart-forms-note" <?php echo cms_bind('forms', 'advisory_note'); ?> style="margin-top: 30px;">
        <?php echo htmlspecialchars(cms_field('forms', 'advisory_note', 'Important: Forms and public links are provided for convenience only. County requirements change often. Always confirm the latest official form, filing method, permit requirement, and recording requirement with the applicable county, city, building department, or Clerk of Court before submitting documents.')); ?>
      </div>

    </div>
  </section>

  <?php include 'sections-library/bottom-banner.html'; ?>
  <?php include __DIR__ . '/sections-library/footer.php'; ?>

</div>

</body>
</html>
