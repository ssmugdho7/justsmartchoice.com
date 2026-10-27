<?php require_once __DIR__ . '/includes/cms-engine.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CLX99EJXW2"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-CLX99EJXW2', {
    'anonymize_ip': true
});
</script>
<?php include __DIR__ . '/includes/cookie-consent-head.php'; ?>
<?php echo cms_head_scripts(); ?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">

<script src="https://analytics.ahrefs.com/analytics.js" data-key="9gWoEoaoQSTW3cXLEcA/Qg" async></script>
<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>

<title><?php echo htmlspecialchars(cms_field('home', 'seo.title', 'Tampa Bay Construction & Remodeling | Just Smart Choice')); ?></title>

<link rel="canonical" href="https://justsmartchoice.com/">

<meta name="description" content="<?php echo htmlspecialchars(cms_field('home', 'seo.description', 'Tampa Bay construction and remodeling for homes and businesses. Kitchens, bathrooms, roofing, additions, electrical, plumbing, plans and permits.')); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars(cms_field('home', 'seo.keywords', 'Construction Tampa Bay FL, Remodeling Tampa Florida, General Contractor Tampa Bay, New Construction Florida, Roofing Contractor Tampa, Electrical Contractor Tampa, Plumbing Contractor Tampa, Kitchen Remodeling Florida, Bathroom Remodeling Tampa, Construction Drawings Tampa, Permit Support Florida, Home Additions Tampa Bay')); ?>">
<meta name="author" content="Just Smart Choice Construction USA">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

<meta property="og:title" content="<?php echo htmlspecialchars(cms_field('home', 'seo.title', 'Tampa Bay Construction & Remodeling | Just Smart Choice')); ?>">
<meta property="og:description" content="Tampa Bay construction and remodeling for homes and businesses, including kitchens, bathrooms, roofing, additions, electrical, plumbing, plans and permits.">
<meta property="og:url" content="https://justsmartchoice.com/">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="https://justsmartchoice.com/images/fg-image.png">
<meta property="og:image:secure_url" content="https://justsmartchoice.com/images/fg-image.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Just Smart Choice Construction USA Tampa Bay construction and remodeling contractor">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Tampa Bay Construction & Remodeling | Just Smart Choice">
<meta name="twitter:description" content="Professional Tampa Bay construction and remodeling for residential and commercial projects. Request an estimate from Just Smart Choice.">
<meta name="twitter:image" content="https://justsmartchoice.com/images/fg-image.png">

<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/custom.css?v=64">
<meta name="ahrefs-site-verification" content="ea7d03c067833893acef13969fe9f074f746e3126ce547228f74e80e1bcb6e73">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": ["GeneralContractor", "HomeAndConstructionBusiness"],
      "@id": "https://justsmartchoice.com/#organization",
      "name": "Smart Choice Contractors USA",
      "alternateName": "Just Smart Choice Construction USA",
      "url": "https://justsmartchoice.com/",
      "logo": "https://justsmartchoice.com/images/fg-image.png",
      "image": "https://justsmartchoice.com/images/fg-image.png",
      "telephone": "+1-727-755-3786",
      "email": "customerservice@justsmartchoice.com",
      "description": "Florida residential and commercial general contractor serving Tampa Bay, Spring Hill, Hernando County, Pasco County, Hillsborough County and nearby communities.",
      "areaServed": [
        {"@type":"City","name":"Spring Hill","containedInPlace":{"@type":"State","name":"Florida"}},
        {"@type":"City","name":"Tampa","containedInPlace":{"@type":"State","name":"Florida"}},
        {"@type":"City","name":"Lutz","containedInPlace":{"@type":"State","name":"Florida"}},
        {"@type":"City","name":"Brooksville","containedInPlace":{"@type":"State","name":"Florida"}},
        {"@type":"City","name":"New Port Richey","containedInPlace":{"@type":"State","name":"Florida"}},
        {"@type":"AdministrativeArea","name":"Hernando County, Florida"},
        {"@type":"AdministrativeArea","name":"Pasco County, Florida"},
        {"@type":"AdministrativeArea","name":"Hillsborough County, Florida"},
        {"@type":"AdministrativeArea","name":"Citrus County, Florida"}
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+1-727-755-3786",
        "contactType": "customer service",
        "areaServed": "US-FL",
        "availableLanguage": ["English", "Spanish"]
      }
    },
    {
      "@type": "WebSite",
      "@id": "https://justsmartchoice.com/#website",
      "url": "https://justsmartchoice.com/",
      "name": "Smart Choice Contractors USA",
      "publisher": {"@id": "https://justsmartchoice.com/#organization"},
      "inLanguage": "en-US"
    },
    {
      "@type": "WebPage",
      "@id": "https://justsmartchoice.com/#webpage",
      "url": "https://justsmartchoice.com/",
      "name": "Tampa Bay Construction and Remodeling Contractor",
      "isPartOf": {"@id": "https://justsmartchoice.com/#website"},
      "about": {"@id": "https://justsmartchoice.com/#organization"},
      "inLanguage": "en-US"
    }
  ]
}
</script>

</head>

<body>

<?php include __DIR__ . '/includes/cookie-consent.php'; ?>
<?php include __DIR__ . '/sections-library/header.php'; ?>

<!-- SWIPER SLIDER -->
<section class="swiper-container" data-autoplay="<?php echo htmlspecialchars(cms_field('home', 'hero_slider.autoplay', '5000')); ?>" data-loop="true">
<div class="swiper-wrapper">

<div class="swiper-slide" data-slide-bg="<?php echo htmlspecialchars(cms_image('home', 'hero_slider.slides.0.bg_image', 'images/slides/slide-01-2050x610.jpg')); ?>" <?php echo cms_bind('home', 'hero_slider.slides.0.bg_image'); ?>>
<div class="swiper-slide-caption">
<div class="container">
<div class="row">
<div class="col-lg-6">
<a class="cta-box cta-box-primary" href="<?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.0.link', 'services.php')); ?>" data-caption-animate="fadeInRight" data-caption-duration="800">
<h1 class="cta-box-heading" <?php echo cms_bind('home', 'hero_slider.slides.0.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.0.heading', 'Tampa Bay Construction and Remodeling Contractor')); ?></h1>
<div class="cta-box-inner">
<p class="cta-box-content" <?php echo cms_bind('home', 'hero_slider.slides.0.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.0.description', 'At Just Smart Choice Construction USA, we focus on successful project delivery through professional construction management, experienced craftsmanship, and attention to every detail.')); ?></p>
<div class="cta-box-icon fa-angle-right"></div>
</div>
</a>
</div>
</div>
</div>
</div>
</div>

<div class="swiper-slide" data-slide-bg="<?php echo htmlspecialchars(cms_image('home', 'hero_slider.slides.1.bg_image', 'images/slides/slide-02-2050x610.jpg')); ?>" <?php echo cms_bind('home', 'hero_slider.slides.1.bg_image'); ?>>
<div class="swiper-slide-caption">
<div class="container">
<div class="row">
<div class="col-lg-6">
<a class="cta-box cta-box-secondary" href="<?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.1.link', 'services.php')); ?>" data-caption-animate="fadeInRight" data-caption-duration="800">
<h2 class="cta-box-heading" <?php echo cms_bind('home', 'hero_slider.slides.1.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.1.heading', 'Quality Construction')); ?></h2>
<div class="cta-box-inner">
<p class="cta-box-content" <?php echo cms_bind('home', 'hero_slider.slides.1.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.1.description', 'Quality is the foundation of every project completed by Just Smart Choice Construction USA. We use professional methods, reliable materials, and skilled craftsmanship to deliver lasting results.')); ?></p>
<div class="cta-box-icon fa-angle-right"></div>
</div>
</a>
</div>
</div>
</div>
</div>
</div>

<div class="swiper-slide" data-slide-bg="<?php echo htmlspecialchars(cms_image('home', 'hero_slider.slides.2.bg_image', 'images/slides/slide-03-2050x610.jpg')); ?>" <?php echo cms_bind('home', 'hero_slider.slides.2.bg_image'); ?>>
<div class="swiper-slide-caption">
<div class="container">
<div class="row">
<div class="col-lg-7">
<a class="cta-box" href="<?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.2.link', 'contacts.php')); ?>" data-caption-animate="fadeInRight" data-caption-duration="800">
<h2 class="cta-box-heading" <?php echo cms_bind('home', 'hero_slider.slides.2.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.2.heading', 'Complete Property Solutions')); ?></h2>
<div class="cta-box-inner">
<p class="cta-box-content" <?php echo cms_bind('home', 'hero_slider.slides.2.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'hero_slider.slides.2.description', 'From remodeling and renovations to complete construction projects, Just Smart Choice provides customized solutions for residential and commercial properties throughout Florida.')); ?></p>
<div class="cta-box-icon fa-angle-right"></div>
</div>
</a>
</div>
</div>
</div>
</div>
</div>

</div>

<div class="swiper-overlay">
<div class="container">
<div class="swiper-pagination"></div>
</div>
</div>
</section>

<!-- FEATURE OFFERS -->
<section class="section-xs">
<div class="container">
<div class="row row-30">

<div class="col-sm-6 col-lg-4 text-center">
<a class="thumbnail thumbnail-secondary" href="<?php echo htmlspecialchars(cms_field('home', 'feature_offers.0.link', 'services.php')); ?>" style="background-image:url(<?php echo htmlspecialchars(cms_image('home', 'feature_offers.0.image', 'images/img-01-370x370.jpg')); ?>)" <?php echo cms_bind('home', 'feature_offers.0.image'); ?>>
<div class="thumbnail-caption">
<h3 class="thumbnail-heading" <?php echo cms_bind('home', 'feature_offers.0.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.0.heading', 'Premium Craftsmanship')); ?></h3>
<div class="thumbnail-inner">
<div class="thumbnail-content" <?php echo cms_bind('home', 'feature_offers.0.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.0.description', 'Professional construction solutions using quality materials and skilled workmanship to ensure durable results.')); ?></div>
<div class="thumbnail-icon fa-angle-right"></div>
</div>
</div>
</a>
</div>

<div class="col-sm-6 col-lg-8 text-center">
<a class="thumbnail thumbnail-wide" href="<?php echo htmlspecialchars(cms_field('home', 'feature_offers.1.link', 'services.php')); ?>" style="background-image:url(<?php echo htmlspecialchars(cms_image('home', 'feature_offers.1.image', 'images/img-02-770x370.webp')); ?>)" <?php echo cms_bind('home', 'feature_offers.1.image'); ?>>
<div class="thumbnail-caption">
<h3 class="thumbnail-heading" <?php echo cms_bind('home', 'feature_offers.1.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.1.heading', 'Trusted Local Expertise')); ?></h3>
<div class="thumbnail-inner">
<div class="thumbnail-content" <?php echo cms_bind('home', 'feature_offers.1.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.1.description', 'With extensive experience in residential and commercial construction, Just Smart Choice delivers reliable solutions, professional communication, and quality results.')); ?></div>
<div class="thumbnail-icon fa-angle-right"></div>
</div>
</div>
</a>
</div>

<div class="col-sm-6 col-lg-4 text-center">
<a class="thumbnail" href="<?php echo htmlspecialchars(cms_field('home', 'feature_offers.2.link', 'services.php')); ?>" style="background-image:url(<?php echo htmlspecialchars(cms_image('home', 'feature_offers.2.image', 'images/img-03-370x370.jpg')); ?>)" <?php echo cms_bind('home', 'feature_offers.2.image'); ?>>
<div class="thumbnail-caption">
<h3 class="thumbnail-heading" <?php echo cms_bind('home', 'feature_offers.2.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.2.heading', 'Industry-Leading Experience')); ?></h3>
<div class="thumbnail-inner">
<div class="thumbnail-content" <?php echo cms_bind('home', 'feature_offers.2.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.2.description', 'Our construction team provides expertise in remodeling, new construction, repairs, and property improvements.')); ?></div>
<div class="thumbnail-icon fa-angle-right"></div>
</div>
</div>
</a>
</div>

<div class="col-sm-6 col-lg-4 text-center">
<a class="thumbnail thumbnail-primary" href="<?php echo htmlspecialchars(cms_field('home', 'feature_offers.3.link', 'contacts.php')); ?>" style="background-image:url(<?php echo htmlspecialchars(cms_image('home', 'feature_offers.3.image', 'images/img-04-370x370.jpg')); ?>)" <?php echo cms_bind('home', 'feature_offers.3.image'); ?>>
<div class="thumbnail-caption">
<h3 class="thumbnail-heading" <?php echo cms_bind('home', 'feature_offers.3.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.3.heading', 'Complete Project Support')); ?></h3>
<div class="thumbnail-inner">
<div class="thumbnail-content" <?php echo cms_bind('home', 'feature_offers.3.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.3.description', 'From consultation and planning to construction completion, we guide every customer through the entire process.')); ?></div>
<div class="thumbnail-icon fa-angle-right"></div>
</div>
</div>
</a>
</div>

<div class="col-sm-6 col-lg-4 text-center">
<a class="thumbnail thumbnail-secondary" href="<?php echo htmlspecialchars(cms_field('home', 'feature_offers.4.link', 'services.php')); ?>" style="background-image:url(<?php echo htmlspecialchars(cms_image('home', 'feature_offers.4.image', 'images/img-05-370x370.jpg')); ?>)" <?php echo cms_bind('home', 'feature_offers.4.image'); ?>>
<div class="thumbnail-caption">
<h3 class="thumbnail-heading" <?php echo cms_bind('home', 'feature_offers.4.heading'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.4.heading', 'Innovative Construction Solutions')); ?></h3>
<div class="thumbnail-inner">
<div class="thumbnail-content" <?php echo cms_bind('home', 'feature_offers.4.description'); ?>><?php echo htmlspecialchars(cms_field('home', 'feature_offers.4.description', 'Energy-efficient upgrades, modern materials, and professional construction methods that improve property value.')); ?></div>
<div class="thumbnail-icon fa-angle-right"></div>
</div>
</div>
</a>
</div>

</div>
</div>
</section>

<!-- WELCOME SECTION -->
<section class="section-sm bg-gray-100">
<div class="container">
<div class="row row-10">

<div class="col-12">
<h2 class="text-uppercase text-primary" <?php echo cms_bind('home', 'welcome_section.heading'); ?>>
<?php echo htmlspecialchars(cms_field('home', 'welcome_section.heading', 'Welcome to Just Smart Choice Construction USA')); ?>
</h2>
</div>

<div class="col-md-6">
<p <?php echo cms_bind('home', 'welcome_section.body_left'); ?>><?php echo htmlspecialchars(cms_field('home', 'welcome_section.body_left', 'Welcome to Just Smart Choice Construction USA, your trusted partner for residential and commercial construction services in Florida. We specialize in new construction, complete remodeling, renovations, electrical services, plumbing, roofing, concrete work, fencing, carpentry, windows and doors, structural repairs, kitchens, bathrooms, and more.')); ?></p>
</div>

<div class="col-md-6">
<p <?php echo cms_bind('home', 'welcome_section.body_right'); ?>><?php echo htmlspecialchars(cms_field('home', 'welcome_section.body_right', 'Our experienced team focuses on quality workmanship, professional project management, and customer satisfaction. From small improvements to complete property transformations, we provide dependable construction solutions designed around your goals.')); ?>
<a class="custom-link" href="<?php echo htmlspecialchars(cms_field('home', 'welcome_section.btn_url', 'services.php')); ?>">
<span class="custom-link-icon fa-angle-right"></span>
</a>
</p>
<div style="margin-top: 15px;">
  <a href="/pricing.php" class="btn btn-sm btn-primary" style="font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 6px;">
    <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Pricing &amp; Cost Guide
  </a>
</div>
</div>

</div>
</div>
</section>

<!-- SERVICES -->
<section class="section-md">
<div class="container">
<div class="row row-30">

<div class="col-12">
<h2 class="text-uppercase" <?php echo cms_bind('home', 'services_section.title'); ?>>
<?php echo htmlspecialchars(cms_field('home', 'services_section.title', 'Our Services')); ?>
</h2>
</div>

<div class="col-md-6">
<?php 
$homeServices = cms_field('home', 'services_section.items', [
  ['title' => 'New Construction & Remodeling', 'link' => 'services.php'],
  ['title' => 'Custom Carpentry and Kitchen & Bathroom Remodeling', 'link' => 'services.php'],
  ['title' => 'Electrical & Green Energy Solutions', 'link' => 'services.php'],
  ['title' => 'Roofing Installation & Repairs', 'link' => 'services.php']
]);
foreach ($homeServices as $hIdx => $hServ):
?>
<a class="panel" href="<?php echo htmlspecialchars($hServ['link'] ?? 'services.php'); ?>">
<h4 class="panel-heading" <?php echo cms_bind('home', "services_section.items.{$hIdx}.title"); ?>><?php echo htmlspecialchars($hServ['title'] ?? ''); ?></h4>
<div class="panel-icon fa-angle-right"></div>
</a>
<?php endforeach; ?>
</div>

<div class="col-md-6">
<img src="<?php echo htmlspecialchars(cms_image('home', 'services_section.side_image', 'images/img-06-570x350.png')); ?>" alt="Construction and remodeling services" width="570" height="350" <?php echo cms_bind('home', 'services_section.side_image'); ?>/>
</div>

</div>
</div>
<!-- READY TO START CTA BANNER -->
<section class="section-sm bg-primary text-center" style="background: linear-gradient(135deg, #1b4d3e 0%, #0d2820 100%); color: #fff; padding: 48px 0;">
  <div class="container">
    <h2 class="text-white text-uppercase" style="font-weight: 700; margin-bottom: 12px; font-size: 28px;" <?php echo cms_bind('home', 'cta_banner.heading'); ?>>
      <?php echo htmlspecialchars(cms_field('home', 'cta_banner.heading', 'Ready to Start Your Construction or Remodeling Project?')); ?>
    </h2>
    <p class="text-white-80" style="max-width: 720px; margin: 0 auto 20px auto; font-size: 16px; opacity: 0.9;" <?php echo cms_bind('home', 'cta_banner.subtitle'); ?>>
      <?php echo htmlspecialchars(cms_field('home', 'cta_banner.subtitle', 'Contact our Florida licensed contractors today for an honest, upfront estimate and professional guidance.')); ?>
    </p>
    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
      <a class="btn btn-primary" href="<?php echo htmlspecialchars(cms_field('home', 'cta_banner.btn_url', 'contacts.php')); ?>" <?php echo cms_bind('home', 'cta_banner.btn_label'); ?> style="font-weight: 700; text-transform: uppercase;">
        <?php echo htmlspecialchars(cms_field('home', 'cta_banner.btn_label', 'Request an Estimate')); ?>
      </a>
      <a class="btn btn-outline-white" href="/pricing.php" style="color: #fff; border: 2px solid #fff; font-weight: 700; text-transform: uppercase; padding: 10px 22px; border-radius: 4px; text-decoration: none;">
        <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Pricing Guide
      </a>
    </div>
  </div>
</section>

<!-- Our customers Finished Projects -->
<?php include 'sections-library/call-to-action.html'; ?>

<!-- BOTTOM BANNER -->
<?php include 'sections-library/bottom-banner.html'; ?>

<!-- FOOTER -->
<?php include __DIR__ . '/sections-library/footer.php'; ?>

<!-- Smart Choice PRChat AI Assistant -->
<script type="text/javascript">
(function () {
    var widgetUrl = "https://crm.justsmartchoice.com/prchat/Chatbot_Controller/widget/44ed6803c32d9b16cee9e825b9e0ecaf";

    function loadSmartChoiceAIChat() {
        if (document.getElementById("smart-choice-prchat-ai-widget")) {
            return;
        }

        var s = document.createElement("script");
        s.id = "smart-choice-prchat-ai-widget";
        s.type = "text/javascript";
        s.src = widgetUrl + "?v=322";
        s.async = true;
        s.defer = true;

        s.onerror = function () {
            console.error("Smart Choice PRChat AI widget failed to load:", widgetUrl);
        };

        document.body.appendChild(s);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", loadSmartChoiceAIChat);
    } else {
        loadSmartChoiceAIChat();
    }
})();
</script>

</body>
</html>

