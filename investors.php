<?php
// investors.php
require_once __DIR__ . '/includes/cms-engine.php';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars(cms_field('investors', 'seo.title', 'Investors - Smart Choice Contractors USA')); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo htmlspecialchars(cms_field('investors', 'seo.description', 'Explore investment opportunities with Smart Choice Contractors USA. Learn about our growth strategy, financial performance, and how you can become a part of our success.')); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars(cms_field('investors', 'seo.title', 'Investors - Smart Choice Contractors USA')); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(cms_field('investors', 'seo.description', 'Discover how to invest in Smart Choice Contractors USA, a leading construction company in Florida.')); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars(cms_field('investors', 'seo.og_image', 'images/logo-638x310.png')); ?>">
    <meta property="og:url" content="https://www.justsmartchoice.com/investors.php">
    <meta property="og:type" content="website">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <?php include __DIR__ . '/includes/cookie-consent-head.php'; ?>
    <?php echo cms_head_scripts(); ?>
</head>
<body>
    <div class="page">
        <?php include __DIR__ . '/includes/cookie-consent.php'; ?>
        <?php include __DIR__ . '/sections-library/header.php'; ?>

        <!-- Investors Section -->
        <section class="investors-section section-md">
            <div class="container">
                <h1 class="h2 text-center text-uppercase" style="margin-bottom: 12px;" <?php echo cms_bind('investors', 'hero.title'); ?>>
                    <?php echo htmlspecialchars(cms_field('investors', 'hero.title', 'Invest in Smart Choice Contractors USA')); ?>
                </h1>
                <p class="lead text-center" style="max-width: 800px; margin: 0 auto 40px auto; color: #555;" <?php echo cms_bind('investors', 'hero.lead'); ?>>
                    <?php echo htmlspecialchars(cms_field('investors', 'hero.lead', 'Join us in shaping the future of construction in Florida. Discover the benefits of partnering with a leading contractor in the industry.')); ?>
                </p>

                <!-- Investment Opportunities & Benefits -->
                <div class="row row-40" style="margin-bottom: 30px;">
                    <div class="col-md-6">
                        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; height: 100%;">
                            <h3 style="color: var(--forest-green, #1b4d3e); font-size: 20px; margin-bottom: 12px;" <?php echo cms_bind('investors', 'how_to_invest.heading'); ?>>
                                <?php echo htmlspecialchars(cms_field('investors', 'how_to_invest.heading', 'How to Become an Investor')); ?>
                            </h3>
                            <p <?php echo cms_bind('investors', 'how_to_invest.description'); ?>>
                                <?php echo htmlspecialchars(cms_field('investors', 'how_to_invest.description', 'Investing in Smart Choice Contractors USA offers a unique opportunity to be part of a growing and dynamic industry. We welcome accredited investors who are interested in:')); ?>
                            </p>
                            <ul style="padding-left: 20px; line-height: 1.8;">
                                <?php 
                                $invItems = cms_field('investors', 'how_to_invest.items', []);
                                foreach ($invItems as $iIdx => $iTxt):
                                ?>
                                    <li <?php echo cms_bind('investors', "how_to_invest.items.{$iIdx}"); ?>><?php echo htmlspecialchars($iTxt); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p style="margin-top: 15px;">
                                To learn more about investment opportunities, please <a href="mailto:<?php echo htmlspecialchars(cms_field('investors', 'how_to_invest.contact_email', 'invest@justsmartchoice.com')); ?>">contact our Investor Relations team</a>.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; height: 100%;">
                            <h3 style="color: var(--forest-green, #1b4d3e); font-size: 20px; margin-bottom: 12px;" <?php echo cms_bind('investors', 'investor_benefits.heading'); ?>>
                                <?php echo htmlspecialchars(cms_field('investors', 'investor_benefits.heading', 'Investor Benefits')); ?>
                            </h3>
                            <ul style="padding-left: 20px; line-height: 1.8;">
                                <?php 
                                $benItems = cms_field('investors', 'investor_benefits.items', []);
                                foreach ($benItems as $bIdx => $bTxt):
                                ?>
                                    <li <?php echo cms_bind('investors', "investor_benefits.items.{$bIdx}"); ?>><?php echo htmlspecialchars($bTxt); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Financial Reports & Investor Program -->
                <div class="row row-30">
                    <div class="col-md-6">
                        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; height: 100%;">
                            <h3 style="color: var(--forest-green, #1b4d3e); font-size: 20px; margin-bottom: 12px;" <?php echo cms_bind('investors', 'financial_transparency.heading'); ?>>
                                <?php echo htmlspecialchars(cms_field('investors', 'financial_transparency.heading', 'Financial Transparency')); ?>
                            </h3>
                            <p <?php echo cms_bind('investors', 'financial_transparency.description'); ?>>
                                <?php echo htmlspecialchars(cms_field('investors', 'financial_transparency.description', 'We are committed to maintaining transparency with our investors. Our financial reports include:')); ?>
                            </p>
                            <ul style="padding-left: 20px; line-height: 1.8;">
                                <?php 
                                $finItems = cms_field('investors', 'financial_transparency.items', []);
                                foreach ($finItems as $fIdx => $fTxt):
                                ?>
                                    <li <?php echo cms_bind('investors', "financial_transparency.items.{$fIdx}"); ?>><?php echo htmlspecialchars($fTxt); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p style="margin-top: 15px;">
                                For access to our latest financial reports, please <a href="mailto:<?php echo htmlspecialchars(cms_field('investors', 'financial_transparency.contact_email', 'invest@justsmartchoice.com')); ?>">contact our Investor Relations team</a>.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; height: 100%;">
                            <h3 style="color: var(--forest-green, #1b4d3e); font-size: 20px; margin-bottom: 12px;" <?php echo cms_bind('investors', 'investor_program.heading'); ?>>
                                <?php echo htmlspecialchars(cms_field('investors', 'investor_program.heading', 'Investor Program')); ?>
                            </h3>
                            <p <?php echo cms_bind('investors', 'investor_program.description'); ?>>
                                <?php echo htmlspecialchars(cms_field('investors', 'investor_program.description', 'Our Investor Program is designed to provide our partners with:')); ?>
                            </p>
                            <ul style="padding-left: 20px; line-height: 1.8;">
                                <?php 
                                $progItems = cms_field('investors', 'investor_program.items', []);
                                foreach ($progItems as $pIdx => $pTxt):
                                ?>
                                    <li <?php echo cms_bind('investors', "investor_program.items.{$pIdx}"); ?>><?php echo htmlspecialchars($pTxt); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p style="margin-top: 15px;">
                                To learn more about our Investor Program, please <a href="mailto:<?php echo htmlspecialchars(cms_field('investors', 'investor_program.contact_email', 'invest@justsmartchoice.com')); ?>">contact our Investor Relations team</a>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Link to Pricing Guide CTA -->
                <div style="margin-top: 40px; text-align: center; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 24px;">
                    <h4 style="font-size: 18px; margin-bottom: 8px;">Explore Our Construction Services &amp; Market Rates</h4>
                    <p style="color: #64748b; margin-bottom: 16px;">Review our commercial, residential, roofing, electrical, and remodeling pricing structure across Florida.</p>
                    <a href="/pricing.php" class="btn btn-primary" style="font-weight: 700; text-transform: uppercase; padding: 12px 24px; border-radius: 6px;">
                        <i class="fa fa-calculator" aria-hidden="true" style="margin-right: 6px;"></i> View Construction Pricing Guide
                    </a>
                </div>

            </div>
        </section>

        <!--Footer-->
        <?php include __DIR__ . '/sections-library/footer.php'; ?>
    </div>
</body>
</html>
