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

  gtag('config', 'G-CLX99EJXW2');
</script>

<?php include __DIR__ . '/includes/cookie-consent-head.php'; ?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">

<script src="https://analytics.ahrefs.com/analytics.js" data-key="9gWoEoaoQSTW3cXLEcA/Qg" async></script>
<script type="text/javascript" src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>

<title>About Just Smart Choice Construction USA | Tampa Bay General Contractor</title>

<link rel="canonical" href="https://justsmartchoice.com/about.php">

<meta name="description" content="Learn about Just Smart Choice Construction USA, a Tampa Bay construction company specializing in remodeling, new construction, roofing, electrical, plumbing, kitchens, bathrooms, additions, permit support, and complete residential and commercial construction services.">
<meta name="keywords" content="About Just Smart Choice Construction USA, Tampa Bay General Contractor, Construction Company Florida, Remodeling Contractor Tampa, Home Remodeling Florida, Commercial Construction Tampa Bay, Roofing Contractor Florida, Electrical Contractor Tampa">
<meta name="author" content="Just Smart Choice Construction USA">
<meta name="robots" content="index, follow">

<meta property="og:title" content="About Just Smart Choice Construction USA | Tampa Bay General Contractor">
<meta property="og:description" content="Learn about our experience, values, construction services, and commitment to quality residential and commercial projects throughout Tampa Bay Florida.">
<meta property="og:url" content="https://justsmartchoice.com/about.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Just Smart Choice Construction USA">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="https://justsmartchoice.com/images/fg-image.png">
<meta property="og:image:secure_url" content="https://justsmartchoice.com/images/fg-image.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Just Smart Choice Construction USA">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="About Just Smart Choice Construction USA">
<meta name="twitter:description" content="Professional construction and remodeling company serving Tampa Bay Florida with quality workmanship and dependable service.">
<meta name="twitter:image" content="https://justsmartchoice.com/images/fg-image.png">

<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"AboutPage",
  "@id":"https://justsmartchoice.com/about.php#aboutpage",
  "url":"https://justsmartchoice.com/about.php",
  "name":"About Just Smart Choice Construction USA",
  "description":"About Just Smart Choice Construction USA and our residential and commercial construction services throughout Tampa Bay Florida.",
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
    "logo":"https://justsmartchoice.com/images/logo-638x310.png",
    "image":"https://justsmartchoice.com/images/fg-image.png",
    "telephone":"+1-727-755-3786",
    "address":{
      "@type":"PostalAddress",
      "streetAddress":"1663 US Highway 41",
      "addressLocality":"Spring Hill",
      "addressRegion":"FL",
      "postalCode":"34610",
      "addressCountry":"US"
    },
    "areaServed":[
      "Tampa Bay FL",
      "Tampa FL",
      "Spring Hill FL",
      "Clearwater FL",
      "St. Petersburg FL",
      "Pasco County FL",
      "Hernando County FL",
      "Hillsborough County FL",
      "Pinellas County FL"
    ],
    "description":"Residential and commercial construction, remodeling, roofing, plumbing, electrical, kitchens, bathrooms, additions, permit support, and property improvement services."
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



<!-- START: ABOUT US SECTION -->
<section class="section-sm">

  <div class="container">

    <div class="row row-30">

      <!-- COLUMN 1: ABOUT US -->
      <div class="col-lg-3 col-xl-4">

        <h1 class="h2 text-uppercase" <?php echo cms_bind('about', 'hero.title'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'hero.title', 'About Us')); ?>
        </h1>


        <!-- ABOUT US FOUR-PICTURE CAROUSEL -->
        <div class="smart-about-carousel"
             id="smartAboutCarousel"
             aria-label="Smart Choice Contractors USA photo gallery">

          <div class="smart-about-slide active">
            <img
              src="<?php echo htmlspecialchars(cms_image('about', 'hero.image', 'images/aboutus.webp')); ?>"
              alt="<?php echo htmlspecialchars(cms_field('about', 'hero.image_alt', 'Smart Choice Contractors USA construction experience and company history')); ?>"
              width="370"
              height="237" <?php echo cms_bind('about', 'hero.image'); ?>>
          </div>


          <!-- PICTURE 2 -->
          <div class="smart-about-slide">
            <img
              src="images/Our-Team.webp"
              alt="Smart Choice Contractors USA professional construction services"
              width="370"
              height="237"
              loading="lazy">
          </div>

          <!-- PICTURE 3 -->
          <div class="smart-about-slide">
            <img
              src="images/Smart_Choice_Hurricane_Cleanup.webp"
              alt="Smart Choice Contractors USA residential remodeling and craftsmanship"
              width="370"
              height="237"
              loading="lazy">
          </div>

          <!-- PICTURE 4 -->
          <div class="smart-about-slide">
            <img
              src="images/Smart_Choice_Team_Balcony.webp"
              alt="Smart Choice Contractors USA construction projects and teamwork"
              width="370"
              height="237"
              loading="lazy">
          </div>

          <!-- CAROUSEL NAVIGATION DOTS -->
          <div class="smart-about-dots">

            <button type="button"
                    class="smart-about-dot active"
                    data-slide="0"
                    aria-label="Show picture 1"
                    aria-current="true"></button>

            <button type="button"
                    class="smart-about-dot"
                    data-slide="1"
                    aria-label="Show picture 2"></button>

            <button type="button"
                    class="smart-about-dot"
                    data-slide="2"
                    aria-label="Show picture 3"></button>

            <button type="button"
                    class="smart-about-dot"
                    data-slide="3"
                    aria-label="Show picture 4"></button>

          </div>

        </div>
        <!-- END ABOUT US CAROUSEL -->

        <p class="text-primary font-weight-semibold" <?php echo cms_bind('about', 'hero.lead_paragraph'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'hero.lead_paragraph', 'This is the reason behind everything we do...')); ?>
        </p>

        <p class="text-justify" style="font-size:80%;line-height:1.2;" <?php echo cms_bind('about', 'hero.p1'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'hero.p1', 'After years of experience in the construction industry, I decided to continue working with a renewed purpose: helping families create safe, reliable, and comfortable homes. Construction is not only about materials and structures; it is about protecting families, improving communities, and creating spaces where people can live better lives.')); ?>
        </p>

        <p class="text-justify" style="font-size:80%;line-height:1.2;" <?php echo cms_bind('about', 'hero.p2'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'hero.p2', 'Throughout my career, I have learned that proper planning, organization, and experience allow problems to be identified before they become expensive issues. Good construction requires preparation, attention to detail, and the ability to provide solutions before challenges affect the project.')); ?>
        </p>

        <p class="text-justify" style="font-size:80%;line-height:1.2;" <?php echo cms_bind('about', 'hero.p3'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'hero.p3', 'Over the years, many homeowners have shared their experiences with unreliable contractors who failed to complete projects, exceeded budgets, or delivered poor-quality work. This motivated me to return to construction with a stronger commitment to honesty, communication, technology, and professional project management.')); ?>
        </p>

        <p class="text-justify" style="font-size:80%;line-height:1.2;" <?php echo cms_bind('about', 'hero.p4'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'hero.p4', 'At Smart Choice Contractors USA, our mission is simple: provide dependable construction services, treat every customer with respect, and deliver projects with quality craftsmanship. Our goal is to build trust one project at a time.')); ?>
        </p>

      </div>
      <!-- END COLUMN 1 -->


      <!-- COLUMN 2: OUR HISTORY -->
      <div class="col-lg-5 col-xl-4">

        <h2 class="text-uppercase" <?php echo cms_bind('about', 'history_heading'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'history_heading', 'Our History')); ?>
        </h2>

<?php foreach (cms_field('about', 'history', []) as $hIdx => $h): ?>
        <div class="time-point">
          <time class="time-point-date" datetime="<?php echo htmlspecialchars($h['year'] ?? ''); ?>" <?php echo cms_bind('about', "history.{$hIdx}.year"); ?>>
            <?php echo htmlspecialchars($h['year'] ?? ''); ?>
          </time>
          <div class="time-point-description text-justify" <?php echo cms_bind('about', "history.{$hIdx}.description"); ?>>
            <?php echo htmlspecialchars($h['description'] ?? ''); ?>
          </div>
        </div>
<?php endforeach; ?>

      </div>
      <!-- END COLUMN 2 -->


      <!-- COLUMN 3: JOBS -->
      <div class="col-lg-4">

        <h2 class="text-uppercase" <?php echo cms_bind('about', 'jobs.heading'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'jobs.heading', 'Jobs')); ?>
        </h2>

        <p class="text-primary font-weight-semibold" <?php echo cms_bind('about', 'jobs.subtitle'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'jobs.subtitle', 'Join Our Construction Team')); ?>
        </p>

        <p class="text-justify" <?php echo cms_bind('about', 'jobs.description'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'jobs.description', 'Smart Choice Contractors USA is always looking for skilled and motivated professionals to join our growing construction team. We offer opportunities for experienced workers who take pride in quality workmanship and professional service.')); ?>
        </p>

        <ul class="list-marked">
<?php foreach (cms_field('about', 'jobs.positions', []) as $jIdx => $jobPos): ?>
          <li>
            <a class="list-marked-item" href="career.php" <?php echo cms_bind('about', "jobs.positions.{$jIdx}"); ?>>
              <?php echo htmlspecialchars($jobPos); ?>
            </a>
          </li>
<?php endforeach; ?>
        </ul>

        <p class="text-justify" <?php echo cms_bind('about', 'jobs.footer_text'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'jobs.footer_text', 'We provide opportunities to work on residential remodeling, new construction, commercial improvements, and specialty construction projects throughout Florida.')); ?>
        </p>


        <p class="text-justify">
          <a href="career.php">
            Apply now
          </a>
          and become part of Smart Choice Contractors USA.
        </p>

      </div>
      <!-- END COLUMN 3 -->

    </div>
    <!-- END ROW -->

  </div>
  <!-- END CONTAINER -->

</section>
<!-- END: ABOUT US SECTION -->


<!-- ABOUT US CAROUSEL STYLING -->
<style>

  /* Carousel occupies the same width as the original image */
  #smartAboutCarousel {
    position: relative;
    width: 100%;
    max-width: 370px;
    aspect-ratio: 370 / 237;
    overflow: hidden;
    border-radius: 5px;
    margin-bottom: 20px;
    background: #f1f1f1;
  }

  /* Slides overlap inside the image area */
  #smartAboutCarousel .smart-about-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition:
      opacity 0.9s ease-in-out,
      visibility 0.9s ease-in-out;
  }

  /* Currently visible picture */
  #smartAboutCarousel .smart-about-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 1;
  }

  /* Image sizing */
  #smartAboutCarousel .smart-about-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    margin: 0;
    padding: 0;
  }

  /* Navigation dots */
  #smartAboutCarousel .smart-about-dots {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
  }

  /* Individual navigation dots */
  #smartAboutCarousel .smart-about-dot {
    width: 9px;
    height: 9px;
    min-width: 9px;
    padding: 0;
    border: 1px solid #ffffff;
    border-radius: 50%;
    background: rgba(0,0,0,0.35);
    cursor: pointer;
    transition:
      background-color 0.3s ease,
      transform 0.3s ease;
  }

  /* Active dot */
  #smartAboutCarousel .smart-about-dot.active,
  #smartAboutCarousel .smart-about-dot:hover {
    background: #ed7d22;
    transform: scale(1.2);
  }

  /* Keyboard accessibility */
  #smartAboutCarousel .smart-about-dot:focus-visible {
    outline: 2px solid #ffffff;
    outline-offset: 3px;
  }

  /* Reduced-motion support */
  @media (prefers-reduced-motion: reduce) {
    #smartAboutCarousel .smart-about-slide,
    #smartAboutCarousel .smart-about-dot {
      transition: none;
    }
  }

</style>


<!-- ABOUT US CAROUSEL JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

  const carousel = document.getElementById('smartAboutCarousel');

  if (!carousel) return;

  const slides = carousel.querySelectorAll('.smart-about-slide');
  const dots = carousel.querySelectorAll('.smart-about-dot');

  if (slides.length === 0 || slides.length !== dots.length) return;

  let currentSlide = 0;
  let carouselTimer = null;

  const slideDuration = 5000; // 5 seconds per image

  function showSlide(index) {

    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('active');
    dots[currentSlide].removeAttribute('aria-current');

    currentSlide = (index + slides.length) % slides.length;

    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
    dots[currentSlide].setAttribute('aria-current', 'true');
  }

  function startCarousel() {

    if (carouselTimer !== null) {
      clearInterval(carouselTimer);
    }

    carouselTimer = setInterval(function () {
      showSlide(currentSlide + 1);
    }, slideDuration);
  }

  dots.forEach(function (dot, index) {

    dot.addEventListener('click', function () {
      showSlide(index);
      startCarousel();
    });

  });

  startCarousel();

});
</script>



<!-- Meet Our Team Section -->
<section class="section-sm bg-gray-100 smart-choice-team-section">
  <div class="container">
    <div class="row row-30">
      <div class="col-12">
        <h2 class="text-uppercase" <?php echo cms_bind('about', 'team_heading'); ?>>
          <?php echo htmlspecialchars(cms_field('about', 'team_heading', 'Meet Our Team')); ?>
        </h2>
      </div>

<?php foreach (cms_field('about', 'team', []) as $mIdx => $m): ?>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="person smart-choice-team-card">
          <a class="person-img" href="#">
            <img src="<?php echo htmlspecialchars(cms_image('about', "team.{$mIdx}.image", $m['image'] ?? '')); ?>" alt="<?php echo htmlspecialchars($m['image_alt'] ?? (($m['name'] ?? '') . ' Smart Choice Contractors USA ' . ($m['role'] ?? ''))); ?>" width="270" height="290"<?php echo $mIdx >= 8 ? ' loading="lazy"' : ''; ?> <?php echo cms_bind('about', "team.{$mIdx}.image"); ?>>
          </a>
          <div class="person-name"><a href="#" <?php echo cms_bind('about', "team.{$mIdx}.role"); ?>><?php echo htmlspecialchars($m['role'] ?? ''); ?></a></div>
          <div class="person-employee-name" <?php echo cms_bind('about', "team.{$mIdx}.name"); ?>><?php echo htmlspecialchars($m['name'] ?? ''); ?></div>
          <div class="person-phone" <?php echo cms_bind('about', "team.{$mIdx}.phone"); ?>><?php echo htmlspecialchars($m['phone'] ?? ''); ?></div>
          <div class="person-desc" <?php echo cms_bind('about', "team.{$mIdx}.description"); ?>><?php echo htmlspecialchars($m['description'] ?? ''); ?></div>
        </div>
      </div>
<?php endforeach; ?>


    </div>
  </div>
</section>


<!-- ADVANTAGES / WHY US / TESTIMONIALS -->
<section class="section-sm smart-choice-info-section">
  <div class="container">
    <div class="row row-30 smart-choice-equal-row">

     
<!-- COLUMN 1: ADVANTAGES - 10 CLICKABLE ITEMS -->
<div class="col-md-6 col-lg-4 smart-choice-info-column">
  <div class="smart-choice-column-content">

    <h2 class="text-uppercase" <?php echo cms_bind('about', 'advantages_heading'); ?>>
      <?php echo htmlspecialchars(cms_field('about', 'advantages_heading', 'Advantages')); ?>
    </h2>

    <ol class="smart-choice-advantages-list">
<?php $advLinks = cms_field('about', 'advantages_links', []); foreach (cms_field('about', 'advantages', []) as $aIdx => $adv): ?>
      <li>
        <a href="<?php echo htmlspecialchars($advLinks[$aIdx] ?? 'services.php'); ?>" <?php echo cms_bind('about', "advantages.{$aIdx}"); ?>>
          <?php echo htmlspecialchars($adv); ?>
        </a>
      </li>
<?php endforeach; ?>
    </ol>


  </div>
</div>

<!-- ADVANTAGES CUSTOM STYLING -->
<style>

  /* Advantages list */
  .smart-choice-advantages-list {
    list-style: none;
    counter-reset: advantage-number;
    padding: 0;
    margin: 15px 0 0;
  }

  /* Compact item spacing */
  .smart-choice-advantages-list li {
    counter-increment: advantage-number;
    position: relative;
    margin-bottom: 8px;
    min-height: 36px;
  }

  /* Clickable links */
  .smart-choice-advantages-list li a {
    display: flex;
    align-items: center;
    position: relative;
    min-height: 36px;
    padding: 3px 0 3px 47px;

    font-size: 15px;
    line-height: 1.4;
    font-weight: 400;
    color: inherit;
    text-decoration: none;

    transition: color 0.25s ease;
  }

  /* Light blue numbered squares */
  .smart-choice-advantages-list li a::before {
    content: counter(advantage-number);

    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);

    width: 35px;
    height: 35px;

    display: flex;
    align-items: center;
    justify-content: center;

    background-color: #4A9DDB;
    border: 2px solid #ed7d22;
    border-radius: 4px;

    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    box-sizing: border-box;

    transition:
      background-color 0.25s ease,
      color 0.25s ease;
  }

  /* Hover: gray background, black numbers */
  .smart-choice-advantages-list li a:hover,
  .smart-choice-advantages-list li a:focus-visible {
    color: #000000;
  }

  .smart-choice-advantages-list li a:hover::before,
  .smart-choice-advantages-list li a:focus-visible::before {
    background-color: #e8e8e8;
    color: #000000;
    border-color: #ed7d22;
  }

  /* Keyboard accessibility */
  .smart-choice-advantages-list li a:focus-visible {
    outline: 2px solid #ed7d22;
    outline-offset: 3px;
    border-radius: 4px;
  }

  /* Mobile responsiveness */
  @media (max-width: 767px) {
    .smart-choice-advantages-list li a {
      font-size: 14px;
      padding-left: 45px;
    }

    .smart-choice-advantages-list li a::before {
      width: 33px;
      height: 33px;
      font-size: 15px;
    }
  }

</style>


      <!-- COLUMN 2: WHY US -->
      <div class="col-md-6 col-lg-4 smart-choice-info-column">
        <div class="smart-choice-column-content">

          <h2 class="text-uppercase" <?php echo cms_bind('about', 'why_us.heading'); ?>>
            <?php echo htmlspecialchars(cms_field('about', 'why_us.heading', 'Why Us')); ?>
          </h2>

          <p class="text-primary font-weight-semibold" <?php echo cms_bind('about', 'why_us.subtitle'); ?>>
            <?php echo htmlspecialchars(cms_field('about', 'why_us.subtitle', '10 Reasons to Choose Smart Choice')); ?>
          </p>

          <p <?php echo cms_bind('about', 'why_us.description'); ?>>
            <?php echo htmlspecialchars(cms_field('about', 'why_us.description', 'Quality construction, skilled professionals, and dependable service across Florida.')); ?>
          </p>

          <ul class="list-marked smart-choice-reasons">
<?php $reasonLinks = cms_field('about', 'why_us.reason_links', []); foreach (cms_field('about', 'why_us.reasons', []) as $rIdx => $reason): ?>
            <li>
              <a class="list-marked-item" href="<?php echo htmlspecialchars($reasonLinks[$rIdx] ?? 'services.php'); ?>" <?php echo cms_bind('about', "why_us.reasons.{$rIdx}"); ?>>
                <?php echo htmlspecialchars($reason); ?>
              </a>
            </li>
<?php endforeach; ?>
          </ul>


        </div>
      </div>

      <!-- COLUMN 3: TESTIMONIALS -->
      <div class="col-md-6 col-lg-4 smart-choice-info-column">
        <div class="smart-choice-column-content">

          <h2 class="text-uppercase" <?php echo cms_bind('about', 'testimonial.heading'); ?>>
            <?php echo htmlspecialchars(cms_field('about', 'testimonial.heading', 'Testimonials')); ?>
          </h2>

          <!-- TESTIMONIAL 1 -->
          <blockquote class="testimonial smart-choice-testimonial">

            <div class="testimonial-img">
              <img
                src="<?php echo htmlspecialchars(cms_image('about', 'testimonial.image', 'images/persons/Cristina Gobber.webp')); ?>"
                alt="Smart Choice Contractors USA customer testimonial"
                width="170"
                height="168"
                loading="lazy" <?php echo cms_bind('about', 'testimonial.image'); ?>>
            </div>

            <div class="testimonial-inner">

              <q class="testimonial-quote" <?php echo cms_bind('about', 'testimonial.quote'); ?>>
                <?php echo htmlspecialchars(cms_field('about', 'testimonial.quote', 'Excellent, amazing service, professional team,and quality workmanship from start to finish, I am Super happy and recommemd them 100% and sure they will do the right thing at your home like they did mine and My deck is just perfect! Thank you guys.')); ?>
              </q>

              <cite class="testimonial-author" <?php echo cms_bind('about', 'testimonial.author'); ?>>
                <?php echo htmlspecialchars(cms_field('about', 'testimonial.author', 'Deck Replacement Cristina Gobber Satisfied Client')); ?>
              </cite>

            </div>
          </blockquote>

          <!-- TESTIMONIAL 2: CUSTOMER DRYWALL REVIEW -->
          <blockquote class="testimonial smart-choice-testimonial">

            <div class="testimonial-img">
              <img
                src="<?php echo htmlspecialchars(cms_image('about', 'testimonial_2.image', 'images/persons/Jim-ferrero.webp')); ?>"
                alt="Customer review of Smart Choice Contractors USA drywall ceiling repair"
                width="170"
                height="168"
                loading="lazy" <?php echo cms_bind('about', 'testimonial_2.image'); ?>>
            </div>

            <div class="testimonial-inner">

              <q class="testimonial-quote" <?php echo cms_bind('about', 'testimonial_2.quote'); ?>>
                <?php echo htmlspecialchars(cms_field('about', 'testimonial_2.quote', 'The drywall patchwork that was taken care of on my ceiling is undetectable. Perfect! I\'m definitely keeping this phone number on speed dial. Some plumbing work next. Definitely.')); ?>
              </q>

              <cite class="testimonial-author" <?php echo cms_bind('about', 'testimonial_2.author'); ?>>
                <?php echo htmlspecialchars(cms_field('about', 'testimonial_2.author', 'Drywall Repair. - "Jim Ferrero"')); ?>
              </cite>

            </div>
          </blockquote>

          <!-- SEE MORE GOOGLE REVIEWS -->
          <div class="smart-choice-review-action">

            <a
              class="smart-choice-review-button"
              href="https://www.google.com/search?q=Smart+Choice+Contractors+USA+Spring+Hill+FL+reviews"
              target="_blank"
              rel="noopener noreferrer"
              aria-label="See more Smart Choice Contractors USA reviews on Google">

              <span class="smart-choice-google-icon" aria-hidden="true">
                G
              </span>

              <span>
                See More Reviews
              </span>

              <span aria-hidden="true">
                &#8594;
              </span>

            </a>

          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<!-- SECTION STYLING -->
<style>

  /* THREE EQUAL-HEIGHT COLUMNS */
  .smart-choice-equal-row {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
  }

  .smart-choice-info-column {
    display: flex;
    flex-direction: column;
  }

  .smart-choice-column-content {
    width: 100%;
    height: 100%;
  }

  /* KEEP ORIGINAL WHY US FONT SIZE */
  .smart-choice-reasons,
  .smart-choice-reasons .list-marked-item {
    font-size: inherit;
    line-height: 1.45;
  }

  .smart-choice-reasons li {
    margin-bottom: 7px;
  }

  /* TESTIMONIAL LAYOUT */
  .smart-choice-testimonial {
    margin: 0 0 20px;
  }

  /* SAME PHOTO SIZE FOR BOTH REVIEWS */
  .smart-choice-testimonial .testimonial-img img {
    display: block;
    width: 170px;
    height: 168px;
    max-width: 100%;
    object-fit: cover;
  }

  /* SMALLER, JUSTIFIED REVIEW TEXT */
  .smart-choice-testimonial .testimonial-quote {
    display: block;
    font-size: 12.5px;
    line-height: 1.45;
    font-weight: 400;
    text-align: justify;
    text-justify: inter-word;
  }

  .smart-choice-testimonial .testimonial-inner {
    margin-top: 8px;
  }

  .smart-choice-testimonial .testimonial-author {
    display: block;
    font-size: 12px;
    font-weight: 600;
    margin-top: 7px;
  }

  /* SEE MORE REVIEWS BUTTON */
  .smart-choice-review-action {
    text-align: center;
    margin-top: 14px;
  }

  .smart-choice-review-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 11px 17px;
    background-color: #278344;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.4;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color .2s ease,
                transform .2s ease;
  }

  .smart-choice-review-button:hover,
  .smart-choice-review-button:focus {
    background-color: #e87924;
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-2px);
  }

  .smart-choice-google-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: #ffffff;
    color: #4285f4;
    font-family: Arial, sans-serif;
    font-size: 17px;
    font-weight: 700;
  }

  /* TABLET */
  @media (min-width: 768px) and (max-width: 991px) {
    .smart-choice-info-column {
      margin-bottom: 25px;
    }
  }

  /* MOBILE */
  @media (max-width: 767px) {
    .smart-choice-info-column {
      margin-bottom: 25px;
    }

    .smart-choice-column-content {
      height: auto;
    }

    .smart-choice-testimonial .testimonial-quote {
      font-size: 13px;
    }

    .smart-choice-review-button {
      width: 100%;
      max-width: 280px;
    }
  }

</style>


<!-- Bottom Banner -->

<?php include 'sections-library/bottom-banner.html'; ?>



<!-- Footer -->

<?php include __DIR__ . '/sections-library/footer.php'; ?>



</body>

</html>