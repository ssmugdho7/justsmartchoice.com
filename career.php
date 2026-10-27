<?php
// career.php
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

<title><?php echo htmlspecialchars(cms_field('career', 'seo.title', 'Construction Careers Tampa Bay FL | Smart Choice Contractors USA Jobs')); ?></title>
<link rel="canonical" href="https://justsmartchoice.com/career.php">

<meta name="description" content="<?php echo htmlspecialchars(cms_field('career', 'seo.description', 'Apply for construction careers with Smart Choice Contractors USA. Hiring project managers, sales managers, electricians, plumbers, HVAC technicians, remodelers, carpenters, painters, tile installers, drywall installers, laborers, office staff, and construction professionals in Tampa Bay Florida.')); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars(cms_field('career', 'seo.keywords', 'Construction Jobs Tampa Bay, Contractor Careers Florida, Remodeling Jobs Spring Hill FL, Electrician Jobs Tampa Bay, Plumbing Jobs Florida, HVAC Jobs Tampa, Roofing Jobs Florida, Smart Choice Contractors USA Careers')); ?>">
<meta name="author" content="Smart Choice Contractors USA">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

<meta property="og:title" content="<?php echo htmlspecialchars(cms_field('career', 'seo.title', 'Construction Careers Tampa Bay FL | Smart Choice Contractors USA')); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars(cms_field('career', 'seo.description', 'Join Smart Choice Contractors USA. Apply for construction, remodeling, sales, management, trade, field, office, and support positions in Tampa Bay Florida.')); ?>">
<meta property="og:url" content="https://justsmartchoice.com/career.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="<?php echo htmlspecialchars(cms_field('career', 'seo.og_image', '/images/fg-image.png')); ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars(cms_field('career', 'seo.title', 'Construction Careers Tampa Bay FL')); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars(cms_field('career', 'seo.description', 'Apply online for construction careers with Smart Choice Contractors USA.')); ?>">
<meta name="twitter:image" content="<?php echo htmlspecialchars(cms_field('career', 'seo.og_image', '/images/fg-image.png')); ?>">

<script src="https://analytics.ahrefs.com/analytics.js" data-key="9gWoEoaoQSTW3cXLEcA/Qg" async></script>
<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>

<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"CollectionPage",
  "@id":"https://justsmartchoice.com/career.php#careers",
  "url":"https://justsmartchoice.com/career.php",
  "name":"Construction Careers Tampa Bay Florida",
  "description":"Construction jobs and career opportunities with Smart Choice Contractors USA in Tampa Bay Florida.",
  "isPartOf":{
    "@type":"WebSite",
    "@id":"https://justsmartchoice.com/#website",
    "name":"Just Smart Choice Construction USA",
    "url":"https://justsmartchoice.com/"
  },
  "about":{
    "@type":"Organization",
    "@id":"https://justsmartchoice.com/#organization",
    "name":"Smart Choice Contractors USA",
    "url":"https://justsmartchoice.com/",
    "telephone":"+1-727-755-3786",
    "sameAs":[
      "https://crm.justsmartchoice.com/recruitment/recruitment_portal"
    ]
  }
}
</script>

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
  <section class="section-sm smart-career-hero">
    <div class="container">
      <div class="smart-career-card">
        <span class="smart-eyebrow" <?php echo cms_bind('career', 'hero.eyebrow'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'hero.eyebrow', 'Now Hiring')); ?>
        </span>
        <h1 <?php echo cms_bind('career', 'hero.title'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'hero.title', 'Join Our Team')); ?>
        </h1>

        <p <?php echo cms_bind('career', 'hero.p1'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'hero.p1', 'Build your future with Smart Choice Contractors USA, a growing Florida construction, remodeling, electrical, plumbing, roofing, HVAC, drafting, engineering, and home improvement company serving Tampa Bay and surrounding communities.')); ?>
        </p>

        <p <?php echo cms_bind('career', 'hero.p2'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'hero.p2', 'We are looking for motivated professionals who take pride in quality workmanship, customer service, leadership, communication, safety, and teamwork. Whether you are an experienced project manager, skilled trade professional, estimator, salesperson, office administrator, IT specialist, or someone ready to start a career in construction, we offer opportunities for growth, training, advancement, and long-term success.')); ?>
        </p>

        <p <?php echo cms_bind('career', 'hero.p3'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'hero.p3', 'Our projects include residential remodeling, commercial construction, kitchens, bathrooms, roofing, electrical installations, plumbing systems, HVAC work, flooring, drywall, painting, additions, construction drawings, permit preparation, inspections, project management, and complete property improvement services throughout Florida.')); ?>
        </p>

        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-top: 20px;">
          <a class="smart-career-main-button" href="<?php echo htmlspecialchars(cms_field('career', 'hero.apply_button_url', 'https://crm.justsmartchoice.com/recruitment/recruitment_portal')); ?>" target="_blank" rel="noopener" <?php echo cms_bind('career', 'hero.apply_button_text'); ?>>
            <?php echo htmlspecialchars(cms_field('career', 'hero.apply_button_text', 'Apply Online Now')); ?>
          </a>
          <a href="/pricing.php" class="btn btn-outline" style="font-weight: 700; border: 2px solid var(--forest-green, #1fa463); color: var(--forest-green, #1fa463); padding: 12px 20px; border-radius: 6px; text-decoration: none;">
            <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Project Pricing Guide
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- OPEN POSITIONS SECTION -->
  <section class="section-sm">
    <div class="container">

      <div class="smart-section-heading">
        <h2 <?php echo cms_bind('career', 'positions_section.title'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'positions_section.title', 'Open Career Opportunities')); ?>
        </h2>
        <p <?php echo cms_bind('career', 'positions_section.subtitle'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'positions_section.subtitle', 'Review available career categories below. Click each position to read the role overview, responsibilities, requirements, and application link.')); ?>
        </p>
      </div>

      <div class="smart-career-grid">
        <?php 
        $positions = cms_field('career', 'positions_section.positions', []);
        foreach ($positions as $pIdx => $pos): 
        ?>
        <details class="smart-career-item" <?php echo ($pIdx === 0) ? 'open' : ''; ?>>
          <summary <?php echo cms_bind('career', "positions_section.positions.{$pIdx}.title"); ?>>
            <?php echo htmlspecialchars($pos['title'] ?? ''); ?>
          </summary>
          <div class="smart-career-details">
            <p><strong <?php echo cms_bind('career', "positions_section.positions.{$pIdx}.overview"); ?>>Role Overview:</strong> <?php echo htmlspecialchars($pos['overview'] ?? ''); ?></p>
            <ul>
              <?php if (!empty($pos['bullet_1'])): ?>
                <li <?php echo cms_bind('career', "positions_section.positions.{$pIdx}.bullet_1"); ?>><?php echo htmlspecialchars($pos['bullet_1']); ?></li>
              <?php endif; ?>
              <?php if (!empty($pos['bullet_2'])): ?>
                <li <?php echo cms_bind('career', "positions_section.positions.{$pIdx}.bullet_2"); ?>><?php echo htmlspecialchars($pos['bullet_2']); ?></li>
              <?php endif; ?>
              <?php if (!empty($pos['bullet_3'])): ?>
                <li <?php echo cms_bind('career', "positions_section.positions.{$pIdx}.bullet_3"); ?>><?php echo htmlspecialchars($pos['bullet_3']); ?></li>
              <?php endif; ?>
            </ul>
            <p><strong <?php echo cms_bind('career', "positions_section.positions.{$pIdx}.requirements"); ?>>Requirements:</strong> <?php echo htmlspecialchars($pos['requirements'] ?? ''); ?></p>
            <a class="smart-career-apply" href="<?php echo htmlspecialchars($pos['apply_url'] ?? 'https://crm.justsmartchoice.com/recruitment/recruitment_portal'); ?>" target="_blank" rel="noopener">
              Apply for This Position
            </a>
          </div>
        </details>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- LOCATIONS & REGIONAL HIRING -->
  <section class="section-sm bg-gray-100">
    <div class="container">
      <div class="smart-career-seo-box">
        <h2 <?php echo cms_bind('career', 'locations_section.title'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'locations_section.title', 'Construction Careers in Tampa Bay Florida')); ?>
        </h2>
        <p <?php echo cms_bind('career', 'locations_section.p1'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'locations_section.p1', 'Smart Choice Contractors USA recruits construction professionals throughout Spring Hill, Tampa, Brooksville, Clearwater, St. Petersburg, New Port Richey, Wesley Chapel, Pasco County, Hernando County, Hillsborough County, Pinellas County, and surrounding Florida communities.')); ?>
        </p>
        <p <?php echo cms_bind('career', 'locations_section.p2'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'locations_section.p2', 'We are interested in candidates with experience in residential remodeling, commercial construction, electrical contracting, plumbing, roofing, HVAC, flooring, drywall, painting, carpentry, framing, tile, estimating, sales, project management, bookkeeping, office administration, IT support, customer service, and construction operations.')); ?>
        </p>
        <p <?php echo cms_bind('career', 'locations_section.p3'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'locations_section.p3', 'Our recruiting portal allows applicants to apply online, submit contact information, upload resumes, and review available opportunities in one centralized system.')); ?>
        </p>
        <a class="smart-career-main-button" href="<?php echo htmlspecialchars(cms_field('career', 'locations_section.button_url', 'https://crm.justsmartchoice.com/recruitment/recruitment_portal')); ?>" target="_blank" rel="noopener" <?php echo cms_bind('career', 'locations_section.button_text'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'locations_section.button_text', 'View All Open Positions')); ?>
        </a>
      </div>
    </div>
  </section>

  <!-- WHY WORK WITH US -->
  <section class="section-sm">
    <div class="container">
      <div class="smart-career-closing">
        <h2 <?php echo cms_bind('career', 'why_work.title'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'why_work.title', 'Why Work With Smart Choice Contractors USA?')); ?>
        </h2>

        <p <?php echo cms_bind('career', 'why_work.p1'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'why_work.p1', 'Smart Choice Contractors USA is committed to building a professional workplace where talented people can grow, lead, learn, and build rewarding careers. We believe our success comes from the quality of our team members, the organization of our systems, and our commitment to customers.')); ?>
        </p>

        <p <?php echo cms_bind('career', 'why_work.p2'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'why_work.p2', 'Our team works with clear standards, structured processes, modern technology, CRM organization, project documentation, customer communication, safety expectations, and performance accountability. We value people who are reliable, respectful, solution-focused, and serious about building a long-term future in the construction industry.')); ?>
        </p>

        <p <?php echo cms_bind('career', 'why_work.p3'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'why_work.p3', 'We promote professional development, leadership opportunities, technical training, jobsite discipline, quality workmanship, and customer-first service. Our goal is to create long-term careers, not temporary jobs.')); ?>
        </p>

        <p <?php echo cms_bind('career', 'why_work.eeo_text'); ?>>
          <strong>Equal Opportunity Employer:</strong> <?php echo htmlspecialchars(cms_field('career', 'why_work.eeo_text', 'Smart Choice Contractors USA is an Equal Opportunity Employer. Employment decisions are made without regard to race, color, religion, sex, gender identity, sexual orientation, national origin, age, disability, veteran status, marital status, genetic information, or any other protected characteristic under applicable federal, state, or local laws.')); ?>
        </p>

        <p <?php echo cms_bind('career', 'why_work.closing_p'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'why_work.closing_p', 'If you are passionate about construction, remodeling, customer service, innovation, craftsmanship, and building a better future, we encourage you to apply today.')); ?>
        </p>

        <a class="smart-career-main-button" href="<?php echo htmlspecialchars(cms_field('career', 'why_work.button_url', 'https://crm.justsmartchoice.com/recruitment/recruitment_portal')); ?>" target="_blank" rel="noopener" <?php echo cms_bind('career', 'why_work.button_text'); ?>>
          <?php echo htmlspecialchars(cms_field('career', 'why_work.button_text', 'Apply Through Our Career Portal')); ?>
        </a>
      </div>
    </div>
  </section>

  <?php include 'sections-library/bottom-banner.html'; ?>
  <?php include __DIR__ . '/sections-library/footer.php'; ?>

</div>

</body>
</html>