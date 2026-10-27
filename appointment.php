<?php
// appointment.php
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

<title><?php echo htmlspecialchars(cms_field('appointment', 'seo.title', 'Schedule a Consultation & Appointment | Smart Choice Contractors USA')); ?></title>
<link rel="canonical" href="https://justsmartchoice.com/appointment.php">

<meta name="description" content="<?php echo htmlspecialchars(cms_field('appointment', 'seo.description', 'Book an appointment with Just Smart Choice Construction USA. Schedule in-person site visits, phone consultations, remodeling estimates, and permit planning across Tampa Bay Florida.')); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars(cms_field('appointment', 'seo.keywords', 'Schedule Contractor Appointment, Tampa Bay Construction Consultation, Remodeling Estimate Booking, Florida General Contractor Appointment')); ?>">
<meta name="author" content="Smart Choice Contractors USA">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

<meta property="og:title" content="<?php echo htmlspecialchars(cms_field('appointment', 'seo.title', 'Schedule a Consultation & Appointment | Smart Choice Contractors USA')); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars(cms_field('appointment', 'seo.description', 'Book an appointment with Just Smart Choice Construction USA across Tampa Bay Florida.')); ?>">
<meta property="og:url" content="https://justsmartchoice.com/appointment.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="<?php echo htmlspecialchars(cms_field('appointment', 'seo.og_image', '/images/fg-image.png')); ?>">

<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="css/custom.css?v=64">

<style>
.appointment-hero {
  background-size: cover;
  background-position: center;
  position: relative;
  padding: 80px 0 70px 0;
  color: #fff;
}
.appointment-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(13, 40, 32, 0.88);
}
.appointment-hero-content {
  position: relative;
  z-index: 2;
  max-width: 820px;
  margin: 0 auto;
  text-align: center;
}
.booking-card {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  border: 1px solid #e2e8f0;
  padding: 40px;
  text-align: center;
  margin-top: -40px;
  position: relative;
  z-index: 3;
}
.booking-btn {
  background: #2563eb;
  color: #fff;
  font-weight: 700;
  padding: 16px 36px;
  border-radius: 8px;
  display: inline-block;
  font-size: 16px;
  text-decoration: none;
  transition: all 0.2s;
  box-shadow: 0 4px 14px rgba(37,99,235,0.3);
}
.booking-btn:hover {
  background: #1d4ed8;
  color: #fff;
  transform: translateY(-2px);
}
.step-card {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 24px;
  height: 100%;
  transition: transform 0.2s;
}
.step-card:hover {
  transform: translateY(-3px);
  background: #fff;
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}
</style>
</head>

<body>

<?php include __DIR__ . '/includes/cookie-consent.php'; ?>
<?php include __DIR__ . '/sections-library/header.php'; ?>

<div class="page">

  <!-- HERO BANNER -->
  <section class="appointment-hero" style="background-image: url('<?php echo htmlspecialchars(cms_image('appointment', 'hero.bg_image', 'images/banner/banner-bg-03-1920x310.jpg')); ?>');" <?php echo cms_bind('appointment', 'hero.bg_image'); ?>>
    <div class="container">
      <div class="appointment-hero-content">
        <span class="smart-eyebrow" style="background: rgba(255,255,255,0.15); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 14px;" <?php echo cms_bind('appointment', 'hero.eyebrow'); ?>>
          <?php echo htmlspecialchars(cms_field('appointment', 'hero.eyebrow', 'Online Scheduling Center')); ?>
        </span>
        <h1 style="color: #fff; font-size: 36px; font-weight: 800; margin-bottom: 16px;" <?php echo cms_bind('appointment', 'hero.title'); ?>>
          <?php echo htmlspecialchars(cms_field('appointment', 'hero.title', 'Schedule Your Consultation & Appointment')); ?>
        </h1>
        <p style="font-size: 16px; color: rgba(255,255,255,0.9); line-height: 1.7;" <?php echo cms_bind('appointment', 'hero.subtitle'); ?>>
          <?php echo htmlspecialchars(cms_field('appointment', 'hero.subtitle', 'Book a project review with our Florida licensed general contracting team. Whether you need an estimate, drawings, roofing inspection, or remodeling consultation, select a convenient time below.')); ?>
        </p>
      </div>
    </div>
  </section>

  <!-- BOOKING CALENDAR CARD -->
  <section class="section-sm" style="padding-top: 0;">
    <div class="container">
      <div class="booking-card">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 16px;">
          <i class="fa-regular fa-calendar-check"></i>
        </div>
        <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 10px;" <?php echo cms_bind('appointment', 'appointment_card.heading'); ?>>
          <?php echo htmlspecialchars(cms_field('appointment', 'appointment_card.heading', 'Online Booking Calendar')); ?>
        </h2>
        <p style="color: #64748b; font-size: 16px; max-width: 600px; margin: 0 auto 24px auto;" <?php echo cms_bind('appointment', 'appointment_card.subtitle'); ?>>
          <?php echo htmlspecialchars(cms_field('appointment', 'appointment_card.subtitle', 'Choose your preferred date, time, and service type through our secure CRM scheduling system.')); ?>
        </p>
        <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; margin-bottom: 20px;">
          <a class="booking-btn" href="<?php echo htmlspecialchars(cms_field('appointment', 'appointment_card.crm_appointly_url', 'https://crm.justsmartchoice.com/appointly/appointments')); ?>" target="_blank" rel="noopener noreferrer" <?php echo cms_bind('appointment', 'appointment_card.btn_label'); ?>>
            <i class="fa-solid fa-arrow-up-right-from-square" style="margin-right: 8px;"></i> <?php echo htmlspecialchars(cms_field('appointment', 'appointment_card.btn_label', 'Open Appointment Calendar & Book Now')); ?>
          </a>
          <a href="/pricing.php" class="btn btn-primary" style="font-weight: 700; text-transform: uppercase; padding: 15px 28px; border-radius: 8px;">
            <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Pricing Guide First
          </a>
        </div>
        <div style="font-size: 14px; color: #475569;" <?php echo cms_bind('appointment', 'appointment_card.phone_help'); ?>>
          <?php echo htmlspecialchars(cms_field('appointment', 'appointment_card.phone_help', 'Prefer to schedule by phone? Call our office at (727) 755-3786')); ?>:
          <a href="tel:<?php echo htmlspecialchars(cms_field('appointment', 'appointment_card.phone_tel', '+17277553786')); ?>" style="font-weight: 700; color: #1fa463; margin-left: 6px;">
            (727) 755-3786
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW TO PREPARE STEPS -->
  <section class="section-md bg-gray-100">
    <div class="container">
      <div class="smart-section-heading text-center" style="margin-bottom: 35px;">
        <h2 <?php echo cms_bind('appointment', 'preparation_steps.heading'); ?>>
          <?php echo htmlspecialchars(cms_field('appointment', 'preparation_steps.heading', 'How to Prepare for Your Consultation')); ?>
        </h2>
        <p style="color: #64748b; font-size: 15.5px;">Having these items ready helps our construction team provide accurate, thorough initial guidance.</p>
      </div>

      <div class="row row-30">
        <?php 
        $steps = cms_field('appointment', 'preparation_steps.steps', []);
        foreach ($steps as $sIdx => $st):
        ?>
        <div class="col-md-6 col-lg-3">
          <div class="step-card">
            <div style="font-size: 28px; color: var(--forest-green, #1fa463); margin-bottom: 14px;">
              <i class="<?php echo htmlspecialchars($st['icon'] ?? 'fa-solid fa-check'); ?>"></i>
            </div>
            <h4 style="font-size: 17px; font-weight: 700; margin-bottom: 8px;" <?php echo cms_bind('appointment', "preparation_steps.steps.{$sIdx}.title"); ?>>
              <?php echo htmlspecialchars($st['title'] ?? ''); ?>
            </h4>
            <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin: 0;" <?php echo cms_bind('appointment', "preparation_steps.steps.{$sIdx}.description"); ?>>
              <?php echo htmlspecialchars($st['description'] ?? ''); ?>
            </p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <?php include 'sections-library/bottom-banner.html'; ?>
  <?php include __DIR__ . '/sections-library/footer.php'; ?>

</div>

</body>
</html>
