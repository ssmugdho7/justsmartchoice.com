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

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">

<script src="https://analytics.ahrefs.com/analytics.js" data-key="9gWoEoaoQSTW3cXLEcA/Qg" async></script>
<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>

<title>Construction Pricing Tampa Bay FL | Remodeling, Electrical, Plumbing & Roofing</title>

<link rel="canonical" href="https://justsmartchoice.com/pricing.php">

<meta name="description" content="Review Tampa Bay construction pricing for remodeling, electrical, plumbing, roofing, kitchens, bathrooms, additions, drawings, permits, engineering support, and complete property improvement services.">
<meta name="keywords" content="Construction Pricing Tampa Bay, Remodeling Prices Tampa FL, Electrical Pricing Florida, Plumbing Pricing Tampa, Roofing Cost Tampa Bay, Contractor Price List Florida, Kitchen Remodel Cost Tampa, Bathroom Remodel Cost Florida, Home Addition Pricing Tampa">
<meta name="author" content="Just Smart Choice Construction USA">
<meta name="robots" content="index, follow">

<meta property="og:title" content="Construction Pricing Tampa Bay FL | Just Smart Choice Construction USA">
<meta property="og:description" content="Transparent construction, remodeling, electrical, plumbing, roofing, kitchen, bathroom, and property improvement pricing guide for Tampa Bay Florida.">
<meta property="og:url" content="https://justsmartchoice.com/pricing.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="https://justsmartchoice.com/images/fg-image.png">
<meta property="og:image:secure_url" content="https://justsmartchoice.com/images/fg-image.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Just Smart Choice Construction USA pricing guide">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Construction Pricing Tampa Bay FL">
<meta name="twitter:description" content="Construction, remodeling, electrical, plumbing, roofing, kitchen and bathroom pricing guide for Tampa Bay Florida.">
<meta name="twitter:image" content="https://justsmartchoice.com/images/fg-image.png">

<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"WebPage",
  "@id":"https://justsmartchoice.com/pricing.php#pricingpage",
  "url":"https://justsmartchoice.com/pricing.php",
  "name":"Construction Pricing Tampa Bay Florida",
  "description":"Pricing guide for construction, remodeling, electrical, plumbing, roofing, kitchens, bathrooms, additions, drawings, engineering, permits, and property improvement services in Tampa Bay Florida.",
  "isPartOf":{
    "@type":"WebSite",
    "@id":"https://justsmartchoice.com/#website",
    "name":"Just Smart Choice Construction USA",
    "url":"https://justsmartchoice.com/"
  },
  "about":{
    "@type":"GeneralContractor",
    "@id":"https://justsmartchoice.com/#organization",
    "name":"Just Smart Choice Construction USA",
    "url":"https://justsmartchoice.com/",
    "telephone":"+1-727-755-3786"
  }
}
</script>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&display=swap">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/custom.css?v=20261023">

</head>

<body>

<?php include __DIR__ . '/includes/cookie-consent.php'; ?>
<?php include __DIR__ . '/sections-library/header.php'; ?>

<!-- Offers -->
<section class="section-xs smart-offers-section">
  <div class="container">
    <div class="row row-30">
      <?php 
      $offerCards = cms_field('pricing', 'offer_cards', []);
      if (!empty($offerCards) && is_array($offerCards)):
        foreach ($offerCards as $oIdx => $offer):
          $colClass = ($oIdx === 1) ? 'col-sm-6 col-lg-8' : 'col-sm-6 col-lg-4';
          $thumbClass = ($oIdx === 0 || $oIdx === 4) ? 'thumbnail-secondary' : (($oIdx === 1) ? 'thumbnail-wide' : (($oIdx === 3) ? 'thumbnail-primary' : ''));
          $offerImg = cms_image('pricing', "offer_cards.{$oIdx}.image", $offer['image'] ?? '');
      ?>
        <div class="<?php echo $colClass; ?> text-center">
          <a class="thumbnail <?php echo $thumbClass; ?> smart-hover-card" 
             href="<?php echo htmlspecialchars($offer['link'] ?? '#'); ?>" 
             style="background-image: url('<?php echo htmlspecialchars($offerImg); ?>');"
             <?php echo cms_bind('pricing', "offer_cards.{$oIdx}.image"); ?>>
            <div class="thumbnail-caption">
              <h3 class="thumbnail-heading" <?php echo cms_bind('pricing', "offer_cards.{$oIdx}.heading"); ?>>
                <?php echo htmlspecialchars($offer['heading'] ?? ''); ?>
              </h3>
              <div class="thumbnail-inner">
                <div class="thumbnail-content" <?php echo cms_bind('pricing', "offer_cards.{$oIdx}.description"); ?>>
                  <?php echo htmlspecialchars($offer['description'] ?? ''); ?>
                </div>
                <div class="thumbnail-icon fa-angle-right"></div>
              </div>
            </div>
          </a>
        </div>
      <?php 
        endforeach;
      endif; 
      ?>
    </div>
  </div>
</section>

<!-- Price List -->
<section class="section-sm smart-pricing-section" id="pricing">
  <div class="container">
    <div class="row row-20">
      <div class="col-12">
        <div class="smart-section-heading text-center">
          <span class="smart-eyebrow" <?php echo cms_bind('pricing', 'hero.eyebrow'); ?>><?php echo htmlspecialchars(cms_field('pricing', 'hero.eyebrow', 'Tampa Bay Construction Pricing')); ?></span>
          <h1 class="h2 text-uppercase" <?php echo cms_bind('pricing', 'hero.title'); ?>><?php echo htmlspecialchars(cms_field('pricing', 'hero.title', 'Smart Choice Contractors USA Service Price Guide')); ?></h1>
          <p <?php echo cms_bind('pricing', 'hero.subtitle'); ?>>
            <?php echo htmlspecialchars(cms_field('pricing', 'hero.subtitle', 'Transparent starting ranges for Tampa Bay homeowners, investors, and commercial property owners. Final pricing depends on jobsite conditions, engineering requirements, permit scope, materials, access, and finish selections.')); ?>
          </p>
        </div>
      </div>

      <div class="col-12">
        <div class="smart-pricing-shell">
          <div id="pricing-tables">
            <?php 
            $tables = cms_field('pricing', 'tables', []);
            if (!empty($tables) && is_array($tables)):
              foreach ($tables as $tIdx => $t):
            ?>
              <div class="price-table-wrapper <?php echo ($tIdx === 0) ? 'active' : ''; ?>">
                <div class="smart-price-card">
                  <h3 <?php echo cms_bind('pricing', "tables.{$tIdx}.category"); ?>><?php echo htmlspecialchars($t['category'] ?? ''); ?></h3>
                  <div class="table-responsive">
                    <table class="table text-center price-table">
                      <thead>
                        <tr><th>Service</th><th>Starting Price</th><th>Service</th><th>Starting Price</th></tr>
                      </thead>
                      <tbody>
                        <?php 
                        $rows = $t['rows'] ?? [];
                        foreach ($rows as $rIdx => $r):
                        ?>
                          <tr>
                            <td data-label="Service" <?php echo cms_bind('pricing', "tables.{$tIdx}.rows.{$rIdx}.s1"); ?>><?php echo htmlspecialchars($r['s1'] ?? ''); ?></td>
                            <td data-label="Price" <?php echo cms_bind('pricing', "tables.{$tIdx}.rows.{$rIdx}.p1"); ?>><?php echo htmlspecialchars($r['p1'] ?? ''); ?></td>
                            <td data-label="Service" <?php echo cms_bind('pricing', "tables.{$tIdx}.rows.{$rIdx}.s2"); ?>><?php echo htmlspecialchars($r['s2'] ?? ''); ?></td>
                            <td data-label="Price" <?php echo cms_bind('pricing', "tables.{$tIdx}.rows.{$rIdx}.p2"); ?>><?php echo htmlspecialchars($r['p2'] ?? ''); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php 
              endforeach;
            endif; 
            ?>
          </div>

          <div class="smart-pricing-controls text-center">
            <button id="prevTable" class="btn-nav" type="button" disabled>&laquo; Back</button>
            <button id="nextTable" class="btn-nav" type="button">Next &raquo;</button>
          </div>

          <div class="smart-buy-services text-center">
            <a href="<?php echo htmlspecialchars(cms_field('pricing', 'buy_services.btn_url', 'https://crm.justsmartchoice.com/products/client')); ?>"
               class="smart-buy-services-link"
               target="_blank"
               rel="noopener noreferrer"
               <?php echo cms_bind('pricing', 'buy_services.btn_label'); ?>>
                <?php echo htmlspecialchars(cms_field('pricing', 'buy_services.btn_label', 'Buy Services Online')); ?>
            </a>
          </div>

          <p class="smart-price-note">
            <strong>Pricing note:</strong> 
            <span <?php echo cms_bind('pricing', 'buy_services.disclaimer'); ?>>
              <?php echo htmlspecialchars(cms_field('pricing', 'buy_services.disclaimer', 'These Tampa Bay starting ranges are for budget planning only and are updated for 2026 market conditions. Final proposals require field verification, scope confirmation, material selections, permit review, and trade-specific requirements.')); ?>
            </span>
          </p>
        </div>
      </div>

      <div class="col-12 text-right">
        <a class="custom-link" href="services.php"><span class="custom-link-icon fa-angle-right"></span> View More Services</a>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tables = document.querySelectorAll('.price-table-wrapper');
    const prevButton = document.getElementById('prevTable');
    const nextButton = document.getElementById('nextTable');
    let currentIndex = 0;

    function showTable(index) {
      tables.forEach(function (table, i) {
        table.classList.toggle('active', i === index);
      });

      if (prevButton) {
        prevButton.disabled = index === 0;
      }

      if (nextButton) {
        nextButton.disabled = index === tables.length - 1;
      }
    }

    if (prevButton) {
      prevButton.addEventListener('click', function () {
        if (currentIndex > 0) {
          currentIndex--;
          showTable(currentIndex);
        }
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', function () {
        if (currentIndex < tables.length - 1) {
          currentIndex++;
          showTable(currentIndex);
        }
      });
    }

    showTable(currentIndex);
  });
</script>

<style>
  :root {
    --smart-green: #169179;
    --smart-green-dark: #0f6f5d;
    --smart-dark: #18211f;
    --smart-muted: #5f6f6b;
    --smart-light: #f4faf8;
    --smart-border: rgba(22, 145, 121, 0.22);
    --smart-shadow: 0 18px 45px rgba(18, 36, 32, 0.16);
  }

  .smart-pricing-section,
  .smart-pricing-section * {
    font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif;
  }

  .smart-pricing-section {
    background:
      radial-gradient(circle at top left, rgba(22, 145, 121, 0.14), transparent 35%),
      linear-gradient(180deg, #ffffff 0%, #f3faf8 100%);
  }

  .smart-section-heading {
    max-width: 920px;
    margin: 0 auto 30px;
  }

  .smart-eyebrow {
    display: inline-block;
    margin-bottom: 10px;
    padding: 7px 16px;
    border-radius: 999px;
    background: rgba(22, 145, 121, 0.10);
    color: var(--smart-green-dark);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .smart-section-heading :is(h1, h2) {
    color: var(--smart-green);
    margin-bottom: 14px;
    font-weight: 800;
  }

  .smart-section-heading p {
    color: var(--smart-muted);
    font-size: 17px;
    line-height: 1.7;
  }

  .smart-pricing-shell {
    background: #ffffff;
    border: 1px solid var(--smart-border);
    border-radius: 24px;
    padding: 26px;
    box-shadow: var(--smart-shadow);
  }

  .price-table-wrapper {
    display: none;
    opacity: 0;
    transform: translateY(8px);
  }

  .price-table-wrapper.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
    animation: smartFadeUp 0.35s ease both;
  }

  @keyframes smartFadeUp {
    from {
      opacity: 0;
      transform: translateY(12px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .smart-price-card h3 {
    color: var(--smart-dark);
    font-size: 24px;
    margin-bottom: 18px;
    text-align: center;
    font-weight: 800;
  }

  .price-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    overflow: hidden;
    border: 1px solid var(--smart-border);
    border-radius: 18px;
    background: #ffffff;
    font-size: 15px;
  }

  .price-table th {
    background: var(--smart-green);
    color: #ffffff;
    padding: 15px 12px;
    border: none;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .price-table td {
    padding: 15px 12px;
    border-bottom: 1px solid rgba(22, 145, 121, 0.16);
    color: var(--smart-dark);
    font-weight: 600;
    vertical-align: middle;
  }

  .price-table tbody tr:nth-child(even) {
    background-color: var(--smart-light);
  }

  .price-table tbody tr:hover {
    background-color: rgba(22, 145, 121, 0.10);
  }

  .price-table tbody tr:last-child td {
    border-bottom: none;
  }

  .price-table td:nth-child(2),
  .price-table td:nth-child(4) {
    color: var(--smart-dark);
    font-weight: 700;
  }

  .smart-pricing-controls {
    margin-top: 22px;
  }

  .btn-nav {
    display: inline-block;
    min-width: 130px;
    margin: 5px;
    padding: 12px 22px;
    border: 2px solid var(--smart-green);
    border-radius: 999px;
    background: var(--smart-green);
    color: #ffffff;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 8px 22px rgba(22, 145, 121, 0.25);
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
  }

  .btn-nav:hover:not(:disabled) {
    transform: translateY(-3px);
    background: var(--smart-green-dark);
    box-shadow: 0 14px 30px rgba(22, 145, 121, 0.35);
  }

  .btn-nav:disabled {
    background-color: var(--smart-green);
    opacity: 1;
    cursor: not-allowed;
    box-shadow: none;
  }

  .smart-buy-services {
    margin-top: 18px;
    margin-bottom: 18px;
  }

  .smart-buy-services-link {
    display: inline-block;
    padding: 13px 28px;
    border-radius: 999px;
    background: var(--smart-dark);
    color: #ffffff;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 10px 26px rgba(18, 33, 31, 0.25);
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
  }

  .smart-buy-services-link:hover {
    background: var(--smart-green-dark);
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-3px);
    box-shadow: 0 16px 36px rgba(18, 33, 31, 0.30);
  }

  .smart-price-note {
    margin: 20px 0 0;
    padding: 16px 18px;
    border-left: 5px solid var(--smart-green);
    border-radius: 14px;
    background: var(--smart-light);
    color: var(--smart-muted);
    font-size: 14px;
    line-height: 1.6;
  }

  .custom-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 20px;
    font-size: 18px;
    color: var(--smart-green);
    text-decoration: none;
    font-weight: 900;
  }

  .custom-link:hover {
    color: var(--smart-green-dark);
    text-decoration: underline;
  }

  @media (max-width: 992px) {
    .smart-pricing-shell {
      padding: 18px;
    }

    .price-table {
      font-size: 14px;
    }

    .price-table th,
    .price-table td {
      padding: 12px 10px;
    }
  }

  @media (max-width: 768px) {
    .price-table,
    .price-table thead,
    .price-table tbody,
    .price-table th,
    .price-table td,
    .price-table tr {
      display: block;
      width: 100%;
    }

    .price-table thead {
      display: none;
    }

    .price-table tr {
      margin-bottom: 15px;
      border: 1px solid var(--smart-border);
      border-radius: 16px;
      overflow: hidden;
      background: #ffffff;
    }

    .price-table td {
      display: flex;
      justify-content: space-between;
      gap: 15px;
      text-align: right;
      border-bottom: 1px solid rgba(22, 145, 121, 0.14);
      font-size: 15px;
    }

    .price-table td::before {
      content: attr(data-label);
      text-align: left;
      font-weight: 900;
      color: var(--smart-green);
    }

    .price-table td:nth-child(2),
    .price-table td:nth-child(4) {
      background: var(--smart-light);
      color: var(--smart-dark);
    }

    .btn-nav {
      width: 100%;
      max-width: 260px;
    }

    .smart-buy-services-link {
      width: 100%;
      max-width: 300px;
    }

    .custom-link {
      justify-content: center;
      width: 100%;
    }
  }
</style>
<!-- Additional Service Pages / SEO Service Cards -->
<!-- Additional Service Pages / SEO Service Cards -->
<section class="section-md smart-services-pages">
  <div class="container">
    <div class="row row-30">
      <div class="col-12 text-center">
        <span class="smart-eyebrow" <?php echo cms_bind('pricing', 'specialized_section.eyebrow'); ?>><?php echo htmlspecialchars(cms_field('pricing', 'specialized_section.eyebrow', 'More Construction Services')); ?></span>
        <h2 class="text-uppercase" style="color: #169179;" <?php echo cms_bind('pricing', 'specialized_section.heading'); ?>><?php echo htmlspecialchars(cms_field('pricing', 'specialized_section.heading', 'Specialized Service Pages')); ?></h2>
        <p class="smart-section-intro" <?php echo cms_bind('pricing', 'specialized_section.intro'); ?>>
          <?php echo htmlspecialchars(cms_field('pricing', 'specialized_section.intro', 'These three service pages are designed for local SEO, Google AI Overview, Bing Copilot, ChatGPT Search, and Tampa Bay construction search visibility.')); ?>
        </p>
      </div>

      <?php 
      $specCards = cms_field('pricing', 'specialized_cards', []);
      if (!empty($specCards) && is_array($specCards)):
        foreach ($specCards as $scIdx => $sc):
          $scImg = cms_image('pricing', "specialized_cards.{$scIdx}.image", $sc['image'] ?? '');
      ?>
        <div class="col-md-4">
          <article class="smart-service-page-card">
            <img src="<?php echo htmlspecialchars($scImg); ?>" 
                 alt="<?php echo htmlspecialchars($sc['title'] ?? ''); ?>" 
                 loading="lazy"
                 <?php echo cms_bind('pricing', "specialized_cards.{$scIdx}.image"); ?>>
            <div class="smart-service-page-body">
              <h3 <?php echo cms_bind('pricing', "specialized_cards.{$scIdx}.title"); ?>>
                <?php echo htmlspecialchars($sc['title'] ?? ''); ?>
              </h3>
              <p <?php echo cms_bind('pricing', "specialized_cards.{$scIdx}.description"); ?>>
                <?php echo htmlspecialchars($sc['description'] ?? ''); ?>
              </p>
              <?php if (!empty($sc['items']) && is_array($sc['items'])): ?>
                <ul>
                  <?php foreach ($sc['items'] as $itemIdx => $item): ?>
                    <li <?php echo cms_bind('pricing', "specialized_cards.{$scIdx}.items.{$itemIdx}"); ?>>
                      <?php echo htmlspecialchars($item); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <a href="<?php echo htmlspecialchars($sc['link'] ?? '#'); ?>" class="smart-service-link" <?php echo cms_bind('pricing', "specialized_cards.{$scIdx}.link_text"); ?>>
                <?php echo htmlspecialchars($sc['link_text'] ?? 'Open Service Page'); ?>
              </a>
            </div>
          </article>
        </div>
      <?php 
        endforeach;
      endif; 
      ?>
    </div>
  </div>
</section>

<!-- Suppliers -->
<section class="section-md smart-suppliers-section">
  <div class="container">
    <div class="row row-30">
      <div class="col-12">
        <h2 class="text-uppercase" style="color: #169179;" <?php echo cms_bind('pricing', 'suppliers_heading'); ?>>
          <?php echo htmlspecialchars(cms_field('pricing', 'suppliers_heading', 'Our Suppliers')); ?>
        </h2>
      </div>
      <?php 
      $suppliers = cms_field('pricing', 'suppliers', []);
      if (!empty($suppliers) && is_array($suppliers)):
        foreach ($suppliers as $sIdx => $supp):
          $suppImg = cms_image('pricing', "suppliers.{$sIdx}.image", $supp['image'] ?? '');
      ?>
        <div class="col-6 col-sm-4 col-lg-3">
          <a class="client smart-supplier-card" href="<?php echo htmlspecialchars($supp['link'] ?? '#'); ?>">
            <img class="client-img" 
                 src="<?php echo htmlspecialchars($suppImg); ?>" 
                 alt="Construction supplier logo" 
                 width="270" height="170" loading="lazy"
                 <?php echo cms_bind('pricing', "suppliers.{$sIdx}.image"); ?>/>
          </a>
        </div>
      <?php 
        endforeach;
      endif; 
      ?>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tables = document.querySelectorAll('.price-table-wrapper');
    const prevButton = document.getElementById('prevTable');
    const nextButton = document.getElementById('nextTable');
    let currentIndex = 0;

    function showTable(index) {
      tables.forEach(function (table, i) {
        table.classList.toggle('active', i === index);
      });

      if (prevButton) {
        prevButton.disabled = index === 0;
      }

      if (nextButton) {
        nextButton.disabled = index === tables.length - 1;
      }
    }

    if (prevButton) {
      prevButton.addEventListener('click', function () {
        if (currentIndex > 0) {
          currentIndex--;
          showTable(currentIndex);
        }
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', function () {
        if (currentIndex < tables.length - 1) {
          currentIndex++;
          showTable(currentIndex);
        }
      });
    }

    showTable(currentIndex);
  });
</script>

<style>
  :root {
    --smart-green: #169179;
    --smart-green-dark: #0f6f5d;
    --smart-dark: #18211f;
    --smart-muted: #5f6f6b;
    --smart-light: #f4faf8;
    --smart-border: rgba(22, 145, 121, 0.22);
    --smart-shadow: 0 18px 45px rgba(18, 36, 32, 0.16);
    --smart-shadow-hover: 0 26px 70px rgba(18, 36, 32, 0.28);
  }

  .smart-offers-section .thumbnail,
  .smart-hover-card {
    position: relative;
    overflow: hidden;
    border-radius: 18px;
    min-height: 370px;
    background-size: cover;
    background-position: center;
    box-shadow: var(--smart-shadow);
    transform: translateY(0) scale(1);
    transition: transform 0.35s ease, box-shadow 0.35s ease, filter 0.35s ease;
  }

  .smart-hover-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.14), rgba(0, 0, 0, 0.62));
    z-index: 1;
    transition: background 0.35s ease;
  }

  .smart-hover-card::after {
    content: "";
    position: absolute;
    inset: -20%;
    background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.32), transparent 35%);
    opacity: 0;
    transform: translateX(-20px);
    transition: opacity 0.35s ease, transform 0.35s ease;
    z-index: 2;
    pointer-events: none;
  }

  .smart-hover-card:hover {
    transform: translateY(-10px) scale(1.025);
    box-shadow: var(--smart-shadow-hover);
    filter: saturate(1.08);
  }

  .smart-hover-card:hover::before {
    background: linear-gradient(180deg, rgba(22, 145, 121, 0.20), rgba(0, 0, 0, 0.70));
  }

  .smart-hover-card:hover::after {
    opacity: 1;
    transform: translateX(0);
  }

  .smart-hover-card .thumbnail-caption {
    position: relative;
    z-index: 3;
  }

  .smart-hover-card .thumbnail-heading,
  .smart-hover-card .thumbnail-content {
    text-shadow: 0 3px 14px rgba(0, 0, 0, 0.45);
  }

  .smart-hover-card .thumbnail-icon {
    transition: transform 0.35s ease, color 0.35s ease;
  }

  .smart-hover-card:hover .thumbnail-icon {
    transform: translateX(8px);
    color: #ffffff;
  }

  .smart-pricing-section {
    background:
      radial-gradient(circle at top left, rgba(22, 145, 121, 0.14), transparent 35%),
      linear-gradient(180deg, #ffffff 0%, #f3faf8 100%);
  }

  .smart-section-heading {
    max-width: 920px;
    margin: 0 auto 30px;
  }

  .smart-eyebrow {
    display: inline-block;
    margin-bottom: 10px;
    padding: 7px 16px;
    border-radius: 999px;
    background: rgba(22, 145, 121, 0.10);
    color: var(--smart-green-dark);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .smart-section-heading :is(h1, h2) {
    color: var(--smart-green);
    margin-bottom: 14px;
  }

  .smart-section-heading p,
  .smart-section-intro {
    color: var(--smart-muted);
    font-size: 17px;
    line-height: 1.7;
  }

  .smart-pricing-shell {
    background: #ffffff;
    border: 1px solid var(--smart-border);
    border-radius: 24px;
    padding: 26px;
    box-shadow: var(--smart-shadow);
  }

  .price-table-wrapper {
    display: none;
    opacity: 0;
    transform: translateY(8px);
  }

  .price-table-wrapper.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
    animation: smartFadeUp 0.35s ease both;
  }

  @keyframes smartFadeUp {
    from {
      opacity: 0;
      transform: translateY(12px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .smart-price-card h3 {
    color: var(--smart-dark);
    font-size: 24px;
    margin-bottom: 18px;
    text-align: center;
  }

  .price-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    overflow: hidden;
    border: 1px solid var(--smart-border);
    border-radius: 18px;
    background: #ffffff;
    font-size: 15px;
  }

  .price-table th {
    background: var(--smart-green);
    color: #ffffff;
    padding: 15px 12px;
    border: none;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .price-table td {
    padding: 15px 12px;
    border-bottom: 1px solid rgba(22, 145, 121, 0.16);
    color: var(--smart-dark);
    font-weight: 700;
    vertical-align: middle;
  }

  .price-table tbody tr:nth-child(even) {
    background-color: var(--smart-light);
  }

  .price-table tbody tr:hover {
    background-color: rgba(22, 145, 121, 0.12);
  }

  .price-table tbody tr:last-child td {
    border-bottom: none;
  }

  .price-table td:nth-child(2),
  .price-table td:nth-child(4) {
    color: var(--smart-green-dark);
    font-weight: 900;
  }

  .smart-pricing-controls {
    margin-top: 22px;
  }

  .btn-nav {
    display: inline-block;
    min-width: 130px;
    margin: 5px;
    padding: 12px 22px;
    border: 2px solid var(--smart-green);
    border-radius: 999px;
    background: var(--smart-green);
    color: #ffffff;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 8px 22px rgba(22, 145, 121, 0.25);
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
  }

  .btn-nav:hover:not(:disabled) {
    transform: translateY(-3px);
    background: var(--smart-green-dark);
    box-shadow: 0 14px 30px rgba(22, 145, 121, 0.35);
  }

  .btn-nav:disabled {
    background-color: var(--smart-green);
    opacity: 1;
    cursor: not-allowed;
    box-shadow: none;
  }

  .smart-price-note {
    margin: 20px 0 0;
    padding: 16px 18px;
    border-left: 5px solid var(--smart-green);
    border-radius: 14px;
    background: var(--smart-light);
    color: var(--smart-muted);
    font-size: 14px;
    line-height: 1.6;
  }

  .custom-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 20px;
    font-size: 18px;
    color: var(--smart-green);
    text-decoration: none;
    font-weight: 900;
  }

  .custom-link:hover {
    color: var(--smart-green-dark);
    text-decoration: underline;
  }

  .smart-services-pages {
    background: #ffffff;
  }

  .smart-service-page-card {
    height: 100%;
    overflow: hidden;
    border-radius: 22px;
    background: #ffffff;
    border: 1px solid var(--smart-border);
    box-shadow: var(--smart-shadow);
    transition: transform 0.35s ease, box-shadow 0.35s ease;
  }

  .smart-service-page-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--smart-shadow-hover);
  }

  .smart-service-page-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
    transition: transform 0.45s ease;
  }

  .smart-service-page-card:hover img {
    transform: scale(1.08);
  }

  .smart-service-page-body {
    padding: 24px;
  }

  .smart-service-page-body h3 {
    color: var(--smart-green);
    font-size: 22px;
    margin-bottom: 12px;
  }

  .smart-service-page-body p {
    color: var(--smart-muted);
    line-height: 1.65;
  }

  .smart-service-page-body ul {
    margin: 16px 0;
    padding-left: 19px;
    color: var(--smart-dark);
    font-weight: 700;
  }

  .smart-service-link {
    display: inline-block;
    margin-top: 8px;
    padding: 10px 18px;
    border-radius: 999px;
    background: var(--smart-green);
    color: #ffffff;
    font-weight: 800;
    text-decoration: none;
  }

  .smart-service-link:hover {
    background: var(--smart-green-dark);
    color: #ffffff;
    text-decoration: none;
  }

  .smart-supplier-card {
    display: block;
    border-radius: 16px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 10px 26px rgba(18, 36, 32, 0.10);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .smart-supplier-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 42px rgba(18, 36, 32, 0.20);
  }

  .smart-supplier-card img {
    transition: transform 0.35s ease;
  }

  .smart-supplier-card:hover img {
    transform: scale(1.05);
  }

  @media (max-width: 992px) {
    .smart-pricing-shell {
      padding: 18px;
    }

    .price-table {
      font-size: 14px;
    }

    .price-table th,
    .price-table td {
      padding: 12px 10px;
    }
  }

  @media (max-width: 768px) {
    .smart-hover-card {
      min-height: 310px;
    }

    .price-table,
    .price-table thead,
    .price-table tbody,
    .price-table th,
    .price-table td,
    .price-table tr {
      display: block;
      width: 100%;
    }

    .price-table thead {
      display: none;
    }

    .price-table tr {
      margin-bottom: 15px;
      border: 1px solid var(--smart-border);
      border-radius: 16px;
      overflow: hidden;
      background: #ffffff;
    }

    .price-table td {
      display: flex;
      justify-content: space-between;
      gap: 15px;
      text-align: right;
      border-bottom: 1px solid rgba(22, 145, 121, 0.14);
      font-size: 15px;
    }

    .price-table td::before {
      content: attr(data-label);
      text-align: left;
      font-weight: 900;
      color: var(--smart-green);
    }

    .price-table td:nth-child(2),
    .price-table td:nth-child(4) {
      background: var(--smart-light);
    }

    .btn-nav {
      width: 100%;
      max-width: 260px;
    }

    .custom-link {
      justify-content: center;
      width: 100%;
    }
  }
</style>

<!-- bottom-banner -->
<?php include 'sections-library/bottom-banner.html'; ?>

<!-- Footer -->
<?php include __DIR__ . '/sections-library/footer.php'; ?>

</body>
</html>
