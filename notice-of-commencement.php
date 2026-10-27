<?php
require_once __DIR__ . '/includes/cms-engine.php';

$seoTitle = cms_field('notice-of-commencement', 'seo.title', 'Florida Notice of Commencement (NOC) Guide & Forms | Just Smart Choice');
$seoDesc  = cms_field('notice-of-commencement', 'seo.description', 'Official Florida Notice of Commencement (F.S. § 713.13) requirements, recording deadlines, county clerk links, and downloadable forms.');
$seoKeywords = cms_field('notice-of-commencement', 'seo.keywords', 'Notice of Commencement Florida, NOC forms, F.S. 713.13, Just Smart Choice');
$heroBg = cms_image('notice-of-commencement', 'hero.bg_image', 'images/slides/slide-02-2050x610.jpg');

$statuteCards = cms_field('notice-of-commencement', 'statute_cards', []);
if (!is_array($statuteCards)) $statuteCards = [];

$steps = cms_field('notice-of-commencement', 'steps', []);
if (!is_array($steps)) $steps = [];

$countyResources = cms_field('notice-of-commencement', 'county_resources', []);
if (!is_array($countyResources)) $countyResources = [];

$faqs = cms_field('notice-of-commencement', 'faqs', []);
if (!is_array($faqs)) $faqs = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($seoTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seoDesc) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($seoKeywords) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seoDesc) ?>">
    <meta property="og:type" content="website">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <?php cms_head_scripts(); ?>

    <style>
        .noc-hero {
            position: relative;
            background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.92)), url('<?= htmlspecialchars($heroBg) ?>') center/cover no-repeat;
            color: #ffffff;
            padding: 70px 20px 50px;
            text-align: center;
        }
        .noc-hero .eyebrow {
            display: inline-block;
            background: rgba(31, 164, 99, 0.2);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.4);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .noc-hero h1 {
            font-size: 38px;
            font-weight: 800;
            margin: 0 0 14px;
            letter-spacing: -0.5px;
        }
        .noc-hero p {
            max-width: 720px;
            margin: 0 auto 24px;
            font-size: 17px;
            color: #cbd5e1;
            line-height: 1.6;
        }
        .noc-hero-btns {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .noc-hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: 0.25s ease;
        }
        .btn-pricing-hero {
            background: #f39c12;
            color: #0f172a;
        }
        .btn-pricing-hero:hover {
            background: #e67e22;
            color: #fff;
            transform: translateY(-2px);
        }
        .btn-forms-hero {
            background: #1fa463;
            color: #fff;
        }
        .btn-forms-hero:hover {
            background: #188a52;
            color: #fff;
            transform: translateY(-2px);
        }

        .noc-body {
            background: #f8fafc;
            padding: 50px 20px 70px;
        }
        .noc-container {
            max-width: 1040px;
            margin: 0 auto;
        }

        .statute-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        @media (max-width: 800px) {
            .statute-grid { grid-template-columns: 1fr; }
        }
        .statute-card {
            background: #ffffff;
            padding: 28px 24px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 6px 18px rgba(0,0,0,0.04);
            position: relative;
        }
        .statute-card .card-badge {
            display: inline-block;
            background: rgba(31, 164, 99, 0.12);
            color: #1fa463;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        .statute-card .card-value {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .statute-card h3 {
            font-size: 17px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .statute-card p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
            margin: 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 35px;
        }
        .section-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 8px;
        }
        .section-header p {
            color: #64748b;
            font-size: 15px;
            margin: 0;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        @media (max-width: 768px) {
            .steps-grid { grid-template-columns: 1fr; }
        }
        .step-card {
            background: #ffffff;
            padding: 28px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            gap: 20px;
        }
        .step-num {
            font-size: 26px;
            font-weight: 800;
            color: #1fa463;
            background: #eef9f2;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .step-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px;
        }
        .step-card p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        .county-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        @media (max-width: 768px) {
            .county-grid { grid-template-columns: 1fr; }
        }
        .county-card {
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .county-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 8px;
        }
        .county-card p {
            font-size: 13px;
            color: #64748b;
            margin: 0 0 16px;
            line-height: 1.5;
        }
        .county-card-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn-county-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-county-clerk {
            background: #0f172a;
            color: #ffffff;
        }
        .btn-county-clerk:hover {
            background: #1e293b;
            color: #ffffff;
        }
        .btn-county-form {
            background: #eef9f2;
            color: #1fa463;
            border: 1px solid #bbf0d0;
        }
        .btn-county-form:hover {
            background: #1fa463;
            color: #ffffff;
        }

        .faq-block {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            margin-bottom: 50px;
        }
        .faq-item {
            border-bottom: 1px solid #f1f5f9;
            padding: 18px 0;
        }
        .faq-item:first-child { padding-top: 0; }
        .faq-item:last-child { border-bottom: none; padding-bottom: 0; }
        .faq-q {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .faq-q i { color: #1fa463; font-size: 14px; }
        .faq-a {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
            padding-left: 22px;
        }

        .pricing-banner {
            background: linear-gradient(135deg, #0a192f 0%, #1e293b 100%);
            border-radius: 16px;
            padding: 35px 30px;
            text-align: center;
            color: #ffffff;
        }
        .pricing-banner h3 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 10px;
        }
        .pricing-banner p {
            color: #cbd5e1;
            font-size: 15px;
            margin: 0 auto 20px;
            max-width: 600px;
            line-height: 1.6;
        }
        .pricing-banner .btn-pricing {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #1fa463;
            color: #ffffff;
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }
        .pricing-banner .btn-pricing:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(31, 164, 99, 0.3);
            color: #fff;
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/sections-library/header.php'; ?>

<!-- HERO -->
<section class="noc-hero">
    <div class="noc-container">
        <span class="eyebrow" <?= cms_bind('notice-of-commencement', 'hero.eyebrow') ?>><?= htmlspecialchars(cms_field('notice-of-commencement', 'hero.eyebrow', 'Florida Statute § 713.13 Compliance Guide')) ?></span>
        <h1 <?= cms_bind('notice-of-commencement', 'hero.title') ?>><?= htmlspecialchars(cms_field('notice-of-commencement', 'hero.title', 'Florida Notice of Commencement (NOC) Resource Center')) ?></h1>
        <p <?= cms_bind('notice-of-commencement', 'hero.subtitle') ?>><?= htmlspecialchars(cms_field('notice-of-commencement', 'hero.subtitle', 'Clear, step-by-step guidance for Tampa Bay property owners and contractors to prepare, notarize, record, and post an official Notice of Commencement.')) ?></p>
        <div class="noc-hero-btns">
            <a href="forms.php#notice-of-commencement" class="noc-hero-btn btn-forms-hero">
                <i class="fa-solid fa-file-pdf"></i> Download County NOC Forms
            </a>
            <a href="pricing.php" class="noc-hero-btn btn-pricing-hero">
                <i class="fa-solid fa-calculator"></i> View Permitted Pricing
            </a>
        </div>
    </div>
</section>

<!-- MAIN BODY -->
<div class="noc-body">
    <div class="noc-container">

        <!-- STATUTE CARDS -->
        <?php if (!empty($statuteCards)): ?>
        <div class="statute-grid">
            <?php foreach ($statuteCards as $sIdx => $sCard): ?>
            <div class="statute-card">
                <span class="card-badge" <?= cms_bind('notice-of-commencement', "statute_cards.$sIdx.badge") ?>><?= htmlspecialchars($sCard['badge'] ?? '') ?></span>
                <div class="card-value" <?= cms_bind('notice-of-commencement', "statute_cards.$sIdx.threshold") ?>><?= htmlspecialchars($sCard['threshold'] ?? '') ?></div>
                <h3 <?= cms_bind('notice-of-commencement', "statute_cards.$sIdx.title") ?>><?= htmlspecialchars($sCard['title'] ?? '') ?></h3>
                <p <?= cms_bind('notice-of-commencement', "statute_cards.$sIdx.description") ?>><?= htmlspecialchars($sCard['description'] ?? '') ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- STEPS SECTION -->
        <div class="section-header">
            <h2>4-Step Notice of Commencement Workflow</h2>
            <p>Ensure compliance with Florida construction lien statutes before commencing work.</p>
        </div>

        <?php if (!empty($steps)): ?>
        <div class="steps-grid">
            <?php foreach ($steps as $stIdx => $st): ?>
            <div class="step-card">
                <div class="step-num" <?= cms_bind('notice-of-commencement', "steps.$stIdx.number") ?>><?= htmlspecialchars($st['number'] ?? '0' . ($stIdx + 1)) ?></div>
                <div>
                    <h3 <?= cms_bind('notice-of-commencement', "steps.$stIdx.title") ?>><?= htmlspecialchars($st['title'] ?? '') ?></h3>
                    <p <?= cms_bind('notice-of-commencement', "steps.$stIdx.description") ?>><?= htmlspecialchars($st['description'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- COUNTY RESOURCES SECTION -->
        <div class="section-header">
            <h2>Tampa Bay County Clerk Recording Portals</h2>
            <p>Official recording departments and downloadable Notice of Commencement templates.</p>
        </div>

        <?php if (!empty($countyResources)): ?>
        <div class="county-grid">
            <?php foreach ($countyResources as $cIdx => $county): ?>
            <div class="county-card">
                <h3 <?= cms_bind('notice-of-commencement', "county_resources.$cIdx.county") ?>><?= htmlspecialchars($county['county'] ?? '') ?></h3>
                <p <?= cms_bind('notice-of-commencement', "county_resources.$cIdx.notes") ?>><?= htmlspecialchars($county['notes'] ?? '') ?></p>
                <div class="county-card-actions">
                    <?php if (!empty($county['clerk_url'])): ?>
                    <a href="<?= htmlspecialchars($county['clerk_url']) ?>" target="_blank" rel="noopener" class="btn-county-action btn-county-clerk">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Official Clerk Recording
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($county['form_url'])): ?>
                    <a href="<?= htmlspecialchars($county['form_url']) ?>" class="btn-county-action btn-county-form">
                        <i class="fa-solid fa-download"></i> County Form
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- FAQS SECTION -->
        <div class="section-header">
            <h2>Notice of Commencement Frequently Asked Questions</h2>
            <p>Common questions property owners ask about Florida recording rules.</p>
        </div>

        <?php if (!empty($faqs)): ?>
        <div class="faq-block">
            <?php foreach ($faqs as $fIdx => $faq): ?>
            <div class="faq-item">
                <div class="faq-q">
                    <i class="fa-solid fa-circle-question"></i>
                    <span <?= cms_bind('notice-of-commencement', "faqs.$fIdx.question") ?>><?= htmlspecialchars($faq['question'] ?? '') ?></span>
                </div>
                <div class="faq-a" <?= cms_bind('notice-of-commencement', "faqs.$fIdx.answer") ?>><?= htmlspecialchars($faq['answer'] ?? '') ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- PRICING LINK CTA BANNER -->
        <div class="pricing-banner">
            <h3 <?= cms_bind('notice-of-commencement', 'pricing_cta.heading') ?>><?= htmlspecialchars(cms_field('notice-of-commencement', 'pricing_cta.heading', 'Planning Permitted Remodeling or Construction?')) ?></h3>
            <p <?= cms_bind('notice-of-commencement', 'pricing_cta.subheading') ?>><?= htmlspecialchars(cms_field('notice-of-commencement', 'pricing_cta.subheading', 'Explore transparent itemized pricing for whole-home remodeling, roofing, additions, and permitting expediting in our comprehensive guide.')) ?></p>
            <a href="pricing.php" class="btn-pricing">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span <?= cms_bind('notice-of-commencement', 'pricing_cta.btn_label') ?>><?= htmlspecialchars(cms_field('notice-of-commencement', 'pricing_cta.btn_label', 'View Project Pricing Guide')) ?></span>
            </a>
        </div>

    </div>
</div>

<?php include __DIR__ . '/sections-library/footer.php'; ?>

</body>
</html>
