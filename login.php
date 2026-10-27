<?php
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

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">

<title <?php echo cms_bind('login', 'seo.title'); ?>><?php echo htmlspecialchars(cms_field('login', 'seo.title', 'Customer Portal Login | Just Smart Choice Construction USA')); ?></title>
<link rel="canonical" href="https://justsmartchoice.com/login.php">
<meta name="description" content="<?php echo htmlspecialchars(cms_field('login', 'seo.description', 'Access your Smart Choice Construction customer portal to review project updates, permit drawings, construction estimates, contracts, and invoices.')); ?>" <?php echo cms_bind('login', 'seo.description'); ?>>
<meta name="keywords" content="<?php echo htmlspecialchars(cms_field('login', 'seo.keywords', 'Customer Login, Client Portal, Smart Choice Construction Login, Project Tracker Tampa Bay')); ?>" <?php echo cms_bind('login', 'seo.keywords'); ?>>
<meta name="author" content="Just Smart Choice Construction USA">
<meta name="robots" content="index, follow">

<meta property="og:title" content="<?php echo htmlspecialchars(cms_field('login', 'seo.title', 'Customer Portal Login | Just Smart Choice Construction USA')); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars(cms_field('login', 'seo.description', 'Access your Smart Choice Construction customer portal to review project updates.')); ?>">
<meta property="og:url" content="https://justsmartchoice.com/login.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:image" content="<?php echo htmlspecialchars(cms_image('login', 'seo.og_image', '/images/fg-image.png')); ?>">

<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&display=swap">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/custom.css?v=60">

<style>
:root {
  --portal-green: #169179;
  --portal-green-dark: #0e6f5b;
  --portal-dark: #18211f;
  --portal-muted: #5f6f6b;
  --portal-light: #f4faf8;
  --portal-border: rgba(22, 145, 121, 0.22);
}

.smart-portal-hero {
  position: relative;
  background-size: cover;
  background-position: center;
  padding: 60px 0;
  color: #fff;
}
.smart-portal-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(24, 33, 31, 0.88) 0%, rgba(22, 145, 121, 0.78) 100%);
  z-index: 1;
}
.smart-portal-hero .container {
  position: relative;
  z-index: 2;
}
.smart-portal-eyebrow {
  display: inline-block;
  padding: 6px 14px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 999px;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-bottom: 12px;
}
.smart-portal-card {
  background: #ffffff;
  border-radius: 18px;
  border: 1px solid var(--portal-border);
  box-shadow: 0 16px 40px rgba(18, 36, 32, 0.10);
  padding: 36px;
  margin-top: -30px;
  position: relative;
  z-index: 3;
}
.smart-portal-card h2 {
  color: var(--portal-dark);
  font-weight: 800;
  margin-bottom: 8px;
  font-size: 26px;
}
.smart-portal-card p {
  color: var(--portal-muted);
  font-size: 15px;
  line-height: 1.6;
  margin-bottom: 24px;
}
.smart-portal-btn-primary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  padding: 15px 24px;
  background: var(--portal-green);
  color: #ffffff !important;
  font-weight: 800;
  font-size: 16px;
  border-radius: 10px;
  text-decoration: none !important;
  transition: all 0.25s ease;
  box-shadow: 0 8px 20px rgba(22, 145, 121, 0.25);
  border: none;
  cursor: pointer;
}
.smart-portal-btn-primary:hover {
  background: var(--portal-green-dark);
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(22, 145, 121, 0.35);
}
.smart-portal-btn-secondary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  padding: 12px 20px;
  background: transparent;
  color: var(--portal-dark) !important;
  font-weight: 700;
  font-size: 14px;
  border-radius: 10px;
  text-decoration: none !important;
  border: 1px solid #cbd5e1;
  transition: all 0.2s ease;
  margin-top: 12px;
}
.smart-portal-btn-secondary:hover {
  background: #f8fafc;
  border-color: var(--portal-green);
  color: var(--portal-green) !important;
}
.smart-portal-feature-card {
  background: var(--portal-light);
  border: 1px solid var(--portal-border);
  border-radius: 14px;
  padding: 24px;
  height: 100%;
  transition: transform 0.25s ease;
}
.smart-portal-feature-card:hover {
  transform: translateY(-4px);
}
.smart-portal-feature-icon {
  font-size: 28px;
  color: var(--portal-green);
  margin-bottom: 12px;
}
.smart-portal-feature-card h3 {
  font-size: 18px;
  font-weight: 700;
  color: var(--portal-dark);
  margin-bottom: 8px;
}
.smart-portal-feature-card p {
  color: var(--portal-muted);
  font-size: 14px;
  line-height: 1.55;
  margin: 0;
}
.smart-portal-support {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 24px;
  text-align: center;
  margin-top: 30px;
}
</style>
</head>

<body>
<?php include __DIR__ . '/includes/cookie-consent.php'; ?>
<?php include __DIR__ . '/sections-library/header.php'; ?>

<!-- HERO SECTION -->
<section class="smart-portal-hero" style="background-image: url('<?php echo htmlspecialchars(cms_image('login', 'hero.bg_image', 'images/banner/banner-bg-03-1920x310.webp')); ?>');" <?php echo cms_bind('login', 'hero.bg_image'); ?>>
  <div class="container text-center">
    <span class="smart-portal-eyebrow" <?php echo cms_bind('login', 'hero.eyebrow'); ?>>
      <?php echo htmlspecialchars(cms_field('login', 'hero.eyebrow', 'Smart Choice Online Portal')); ?>
    </span>
    <h1 class="h2 text-uppercase text-white font-weight-bold" <?php echo cms_bind('login', 'hero.title'); ?>>
      <?php echo htmlspecialchars(cms_field('login', 'hero.title', 'Customer & Client Portal')); ?>
    </h1>
    <p style="max-width: 720px; margin: 0 auto; color: rgba(255,255,255,0.9); font-size: 17px;" <?php echo cms_bind('login', 'hero.subtitle'); ?>>
      <?php echo htmlspecialchars(cms_field('login', 'hero.subtitle', 'Access your project estimates, contracts, daily progress, permit drawings, and invoices anytime.')); ?>
    </p>
  </div>
</section>

<!-- MAIN CONTENT -->
<section class="section-md" style="padding-top: 0;">
  <div class="container">
    <div class="row justify-content-center">
      
      <!-- LOGIN FORM / ACCESS CARD -->
      <div class="col-lg-6">
        <div class="smart-portal-card">
          <span style="font-size: 12px; font-weight: 800; color: var(--portal-green); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;" <?php echo cms_bind('login', 'login_card.eyebrow'); ?>>
            <?php echo htmlspecialchars(cms_field('login', 'login_card.eyebrow', 'Secure Account Sign In')); ?>
          </span>
          <h2 <?php echo cms_bind('login', 'login_card.heading'); ?>>
            <?php echo htmlspecialchars(cms_field('login', 'login_card.heading', 'Client Portal Login')); ?>
          </h2>
          <p <?php echo cms_bind('login', 'login_card.description'); ?>>
            <?php echo htmlspecialchars(cms_field('login', 'login_card.description', 'Enter your registered email address and password to manage your active construction or remodeling project.')); ?>
          </p>

          <form action="<?php echo htmlspecialchars(cms_field('login', 'login_card.crm_url', 'https://crm.justsmartchoice.com/authentication/login')); ?>" method="post" target="_blank">
            <div class="form-group" style="margin-bottom: 16px;">
              <label style="font-weight: 700; font-size: 13px; color: #334155; margin-bottom: 6px; display: block;">Email Address</label>
              <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com" required style="border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <label style="font-weight: 700; font-size: 13px; color: #334155; margin: 0;">Password</label>
                <a href="https://crm.justsmartchoice.com/authentication/forgot_password" target="_blank" style="font-size: 12px; color: var(--portal-green); text-decoration: none;">Forgot Password?</a>
              </div>
              <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required style="border-radius: 8px;">
            </div>

            <button type="submit" class="smart-portal-btn-primary" <?php echo cms_bind('login', 'login_card.btn_label'); ?>>
              <span><?php echo htmlspecialchars(cms_field('login', 'login_card.btn_label', 'Sign In to Client Portal')); ?></span>
              <span class="fa-solid fa-arrow-right"></span>
            </button>
          </form>

          <div style="text-align: center; margin-top: 20px; padding-top: 18px; border-top: 1px solid #e2e8f0;">
            <a href="<?php echo htmlspecialchars(cms_field('login', 'login_card.contractor_portal_url', 'https://crm.justsmartchoice.com/authentication/admin_login')); ?>" target="_blank" class="smart-portal-btn-secondary" <?php echo cms_bind('login', 'login_card.contractor_btn_label'); ?>>
              <span class="fa-solid fa-helmet-safety"></span>
              <span><?php echo htmlspecialchars(cms_field('login', 'login_card.contractor_btn_label', 'Trade Partner & Contractor Sign In')); ?></span>
            </a>
          </div>
        </div>
      </div>

    </div>

    <!-- PORTAL FEATURES -->
    <div class="row row-30" style="margin-top: 40px;">
      <?php 
      $features = cms_field('login', 'features', []);
      if (!empty($features) && is_array($features)):
        foreach ($features as $fIdx => $feat):
      ?>
        <div class="col-md-4">
          <div class="smart-portal-feature-card">
            <div class="smart-portal-feature-icon">
              <i class="<?php echo htmlspecialchars($feat['icon'] ?? 'fa-solid fa-check'); ?>"></i>
            </div>
            <h3 <?php echo cms_bind('login', "features.{$fIdx}.title"); ?>>
              <?php echo htmlspecialchars($feat['title'] ?? ''); ?>
            </h3>
            <p <?php echo cms_bind('login', "features.{$fIdx}.description"); ?>>
              <?php echo htmlspecialchars($feat['description'] ?? ''); ?>
            </p>
          </div>
        </div>
      <?php 
        endforeach;
      endif; 
      ?>
    </div>

    <!-- SUPPORT / CONTACT CALLOUT -->
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="smart-portal-support">
          <h3 style="font-size: 20px; font-weight: 800; color: #1e293b; margin-bottom: 8px;" <?php echo cms_bind('login', 'support.heading'); ?>>
            <?php echo htmlspecialchars(cms_field('login', 'support.heading', 'Need Assistance Accessing Your Project?')); ?>
          </h3>
          <p style="color: #64748b; font-size: 15px; margin-bottom: 16px;" <?php echo cms_bind('login', 'support.text'); ?>>
            <?php echo htmlspecialchars(cms_field('login', 'support.text', 'If you are a new homeowner or having trouble accessing your portal account, our office team is here to help.')); ?>
          </p>
          <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; font-size: 15px; font-weight: 700;">
            <a href="tel:<?php echo htmlspecialchars(cms_field('login', 'support.phone_raw', '+17277553786')); ?>" style="color: var(--portal-green); text-decoration: none;" <?php echo cms_bind('login', 'support.phone'); ?>>
              <i class="fa-solid fa-phone" style="margin-right: 6px;"></i> <?php echo htmlspecialchars(cms_field('login', 'support.phone', '(727) 755-3786')); ?>
            </a>
            <span style="color: #cbd5e1;">|</span>
            <a href="mailto:<?php echo htmlspecialchars(cms_field('login', 'support.email', 'support@justsmartchoice.com')); ?>" style="color: var(--portal-green); text-decoration: none;" <?php echo cms_bind('login', 'support.email'); ?>>
              <i class="fa-solid fa-envelope" style="margin-right: 6px;"></i> <?php echo htmlspecialchars(cms_field('login', 'support.email', 'support@justsmartchoice.com')); ?>
            </a>
            <span style="color: #cbd5e1;">|</span>
            <span style="color: #64748b;" <?php echo cms_bind('login', 'support.hours'); ?>>
              <i class="fa-regular fa-clock" style="margin-right: 6px;"></i> <?php echo htmlspecialchars(cms_field('login', 'support.hours', 'Monday - Friday: 8:00 AM - 5:00 PM EST')); ?>
            </span>
            <span style="color: #cbd5e1;">|</span>
            <a href="/pricing.php" style="color: var(--portal-green); text-decoration: none; font-weight: 700;">
              <i class="fa-solid fa-calculator" style="margin-right: 6px;"></i> View Pricing Guide
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- BOTTOM BANNER -->
<?php include 'sections-library/bottom-banner.html'; ?>

<!-- FOOTER -->
<?php include __DIR__ . '/sections-library/footer.php'; ?>

</body>
</html>
