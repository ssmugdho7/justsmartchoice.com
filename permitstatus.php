<?php
require_once __DIR__ . '/includes/cms-engine.php';

$seoTitle = cms_field('permitstatus', 'seo.title', 'Permit & Inspection Lookup | Just Smart Choice Construction USA');
$seoDesc  = cms_field('permitstatus', 'seo.description', 'Look up Florida building permits and schedule inspections across all 67 Florida counties and municipal portals.');
$seoKeywords = cms_field('permitstatus', 'seo.keywords', 'Florida building permit lookup, Florida inspection scheduling, Just Smart Choice');
$heroBg = cms_image('permitstatus', 'hero.bg_image', 'images/slides/slide-01-2050x610.jpg');

$guidanceCards = cms_field('permitstatus', 'guidance_cards', []);
if (!is_array($guidanceCards)) $guidanceCards = [];
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
        .permit-hero {
            position: relative;
            background: linear-gradient(rgba(10, 25, 47, 0.82), rgba(10, 25, 47, 0.90)), url('<?= htmlspecialchars($heroBg) ?>') center/cover no-repeat;
            color: #ffffff;
            padding: 70px 20px 50px;
            text-align: center;
        }
        .permit-hero .eyebrow {
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
        .permit-hero h1 {
            font-size: 38px;
            font-weight: 800;
            margin: 0 0 14px;
            letter-spacing: -0.5px;
        }
        .permit-hero p {
            max-width: 720px;
            margin: 0 auto 20px;
            font-size: 17px;
            color: #cbd5e1;
            line-height: 1.6;
        }
        .permit-hero .hero-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f39c12;
            color: #0f172a;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: 0.25s ease;
        }
        .permit-hero .hero-cta-btn:hover {
            background: #e67e22;
            color: #fff;
            transform: translateY(-2px);
        }

        .permit-page-body {
            background: #f8fafc;
            padding: 50px 20px 70px;
        }
        .permit-container {
            max-width: 960px;
            margin: 0 auto;
        }

        .portal-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 12px 36px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            margin-bottom: 40px;
            text-align: center;
        }
        .portal-box h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 10px;
        }
        .portal-box .inst {
            color: #64748b;
            font-size: 15px;
            max-width: 620px;
            margin: 0 auto 28px;
            line-height: 1.6;
        }
        .lookup-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
            text-align: left;
        }
        @media (max-width: 640px) {
            .lookup-grid { grid-template-columns: 1fr; }
            .portal-box { padding: 25px 18px; }
            .permit-hero h1 { font-size: 28px; }
        }
        .lookup-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }
        .portal-box select {
            width: 100%;
            padding: 14px 16px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            font-size: 15px;
            color: #1e293b;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .portal-box select:focus {
            border-color: #1fa463;
            box-shadow: 0 0 0 3px rgba(31, 164, 99, 0.15);
            background: #fff;
        }
        .portal-submit-btn {
            width: 100%;
            padding: 16px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(135deg, #1fa463 0%, #16804d 100%);
            color: #ffffff;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .portal-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(31, 164, 99, 0.25);
        }

        .guidance-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        @media (max-width: 800px) {
            .guidance-cards-grid { grid-template-columns: 1fr; }
        }
        .guide-card {
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-align: left;
            transition: transform 0.2s;
        }
        .guide-card:hover {
            transform: translateY(-3px);
            border-color: #cbd5e1;
        }
        .guide-card .card-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(31, 164, 99, 0.1);
            color: #1fa463;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }
        .guide-card h3 {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 8px;
        }
        .guide-card p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
            margin: 0;
        }

        .support-card {
            background: #eef9f2;
            border: 1px solid #bbf0d0;
            border-radius: 12px;
            padding: 24px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
            text-align: left;
        }
        @media (max-width: 768px) {
            .support-card { flex-direction: column; text-align: center; }
        }
        .support-card h4 {
            margin: 0 0 6px;
            font-size: 18px;
            color: #0f5132;
            font-weight: 700;
        }
        .support-card p {
            margin: 0;
            font-size: 14px;
            color: #1e3a2b;
            line-height: 1.5;
        }
        .support-contact-pill {
            background: #1fa463;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .support-contact-pill:hover {
            background: #188a52;
            color: #fff;
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
<section class="permit-hero">
    <div class="permit-container">
        <span class="eyebrow" <?= cms_bind('permitstatus', 'hero.eyebrow') ?>><?= htmlspecialchars(cms_field('permitstatus', 'hero.eyebrow', 'Florida Building Department Directory')) ?></span>
        <h1 <?= cms_bind('permitstatus', 'hero.title') ?>><?= htmlspecialchars(cms_field('permitstatus', 'hero.title', 'Florida Permit & Inspection Lookup Portal')) ?></h1>
        <p <?= cms_bind('permitstatus', 'hero.subtitle') ?>><?= htmlspecialchars(cms_field('permitstatus', 'hero.subtitle', 'Direct, official building department access across all 67 Florida counties and major municipal building portals.')) ?></p>
        <div>
            <a href="pricing.php" class="hero-cta-btn">
                <i class="fa-solid fa-calculator"></i> View Permitted Work Pricing
            </a>
        </div>
    </div>
</section>

<!-- MAIN BODY -->
<div class="permit-page-body">
    <div class="permit-container">

        <!-- LOOKUP PORTAL BOX -->
        <div class="portal-box">
            <h2 <?= cms_bind('permitstatus', 'portal_card.heading') ?>><?= htmlspecialchars(cms_field('permitstatus', 'portal_card.heading', 'Permit / Inspection Lookup')) ?></h2>
            <p class="inst" <?= cms_bind('permitstatus', 'portal_card.instruction') ?>><?= htmlspecialchars(cms_field('permitstatus', 'portal_card.instruction', 'Select your Florida county and municipality below to navigate directly to official permit records, inspection requests, and plan review status.')) ?></p>

            <div class="lookup-grid">
                <div class="lookup-group">
                    <label for="county"><i class="fa-solid fa-map-location-dot"></i> Florida County (Required)</label>
                    <select id="county" onchange="updateCities()">
                        <option value=""><?= htmlspecialchars(cms_field('permitstatus', 'portal_card.county_placeholder', 'Select County (All 67 Florida Counties)')) ?></option>
                        <option>Alachua County</option>
                        <option>Baker County</option>
                        <option>Bay County</option>
                        <option>Bradford County</option>
                        <option>Brevard County</option>
                        <option>Broward County</option>
                        <option>Calhoun County</option>
                        <option>Charlotte County</option>
                        <option>Citrus County</option>
                        <option>Clay County</option>
                        <option>Collier County</option>
                        <option>Columbia County</option>
                        <option>DeSoto County</option>
                        <option>Dixie County</option>
                        <option>Duval County</option>
                        <option>Escambia County</option>
                        <option>Flagler County</option>
                        <option>Franklin County</option>
                        <option>Gadsden County</option>
                        <option>Gilchrist County</option>
                        <option>Glades County</option>
                        <option>Gulf County</option>
                        <option>Hamilton County</option>
                        <option>Hardee County</option>
                        <option>Hendry County</option>
                        <option>Hernando County</option>
                        <option>Highlands County</option>
                        <option>Hillsborough County</option>
                        <option>Holmes County</option>
                        <option>Indian River County</option>
                        <option>Jackson County</option>
                        <option>Jefferson County</option>
                        <option>Lafayette County</option>
                        <option>Lake County</option>
                        <option>Lee County</option>
                        <option>Leon County</option>
                        <option>Levy County</option>
                        <option>Liberty County</option>
                        <option>Madison County</option>
                        <option>Manatee County</option>
                        <option>Marion County</option>
                        <option>Martin County</option>
                        <option>Miami-Dade County</option>
                        <option>Monroe County</option>
                        <option>Nassau County</option>
                        <option>Okaloosa County</option>
                        <option>Okeechobee County</option>
                        <option>Orange County</option>
                        <option>Osceola County</option>
                        <option>Palm Beach County</option>
                        <option>Pasco County</option>
                        <option>Pinellas County</option>
                        <option>Polk County</option>
                        <option>Putnam County</option>
                        <option>Santa Rosa County</option>
                        <option>Sarasota County</option>
                        <option>Seminole County</option>
                        <option>St. Johns County</option>
                        <option>St. Lucie County</option>
                        <option>Sumter County</option>
                        <option>Suwannee County</option>
                        <option>Taylor County</option>
                        <option>Union County</option>
                        <option>Volusia County</option>
                        <option>Wakulla County</option>
                        <option>Walton County</option>
                        <option>Washington County</option>
                    </select>
                </div>

                <div class="lookup-group">
                    <label for="city"><i class="fa-solid fa-city"></i> City / Municipality (Optional)</label>
                    <select id="city">
                        <option value=""><?= htmlspecialchars(cms_field('permitstatus', 'portal_card.city_placeholder', 'Select City / Municipality (Optional)')) ?></option>
                    </select>
                </div>
            </div>

            <button type="button" class="portal-submit-btn" onclick="goPortal()">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span <?= cms_bind('permitstatus', 'portal_card.button_label') ?>><?= htmlspecialchars(cms_field('permitstatus', 'portal_card.button_label', 'Open Official Building Department Portal')) ?></span>
            </button>
        </div>

        <!-- GUIDANCE CARDS -->
        <?php if (!empty($guidanceCards)): ?>
        <div class="guidance-cards-grid">
            <?php foreach ($guidanceCards as $gIdx => $gCard): ?>
            <div class="guide-card">
                <div class="card-icon"><i class="fa-solid <?= htmlspecialchars($gCard['icon'] ?? 'fa-check') ?>"></i></div>
                <h3 <?= cms_bind('permitstatus', "guidance_cards.$gIdx.title") ?>><?= htmlspecialchars($gCard['title'] ?? '') ?></h3>
                <p <?= cms_bind('permitstatus', "guidance_cards.$gIdx.description") ?>><?= htmlspecialchars($gCard['description'] ?? '') ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- SUPPORT CARD -->
        <div class="support-card">
            <div>
                <h4 <?= cms_bind('permitstatus', 'support_box.title') ?>><?= htmlspecialchars(cms_field('permitstatus', 'support_box.title', 'Need Help Finding Your Permit Record?')) ?></h4>
                <p <?= cms_bind('permitstatus', 'support_box.text') ?>><?= htmlspecialchars(cms_field('permitstatus', 'support_box.text', 'If you are an active client and need assistance with permit status or NOC recording, our project coordinators are available to assist.')) ?></p>
            </div>
            <div>
                <a href="tel:7277553786" class="support-contact-pill">
                    <i class="fa-solid fa-phone"></i>
                    <span <?= cms_bind('permitstatus', 'support_box.phone') ?>><?= htmlspecialchars(cms_field('permitstatus', 'support_box.phone', '(727) 755-3786')) ?></span>
                </a>
            </div>
        </div>

        <!-- PRICING LINK CTA BANNER -->
        <div class="pricing-banner">
            <h3 <?= cms_bind('permitstatus', 'pricing_cta.heading') ?>><?= htmlspecialchars(cms_field('permitstatus', 'pricing_cta.heading', 'Planning Permitted Construction or Remodeling?')) ?></h3>
            <p <?= cms_bind('permitstatus', 'pricing_cta.subheading') ?>><?= htmlspecialchars(cms_field('permitstatus', 'pricing_cta.subheading', 'Review transparent itemized costs, labor rates, and permit fees in our detailed pricing guide.')) ?></p>
            <a href="pricing.php" class="btn-pricing">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span <?= cms_bind('permitstatus', 'pricing_cta.btn_label') ?>><?= htmlspecialchars(cms_field('permitstatus', 'pricing_cta.btn_label', 'View Upfront Pricing Guide')) ?></span>
            </a>
        </div>

    </div>
</div>

<?php include __DIR__ . '/sections-library/footer.php'; ?>

<script>
// ALL 67 FLORIDA COUNTIES OFFICIAL PORTALS
const counties = {
    "Alachua County":"https://aca.alachuacounty.us",
    "Baker County":"https://www.bakercountyfl.org",
    "Bay County":"https://aca.baycountyfl.gov",
    "Bradford County":"https://www.bradfordcountyfl.gov",
    "Brevard County":"https://aca-prod.accela.com/BREVARD",
    "Broward County":"https://aca-prod.accela.com/BROWARD",
    "Calhoun County":"https://www.calhouncountygov.com",
    "Charlotte County":"https://aca.charlottecountyfl.gov",
    "Citrus County":"https://aca.citrusbocc.com",
    "Clay County":"https://aca.claycountygov.com",
    "Collier County":"https://aca.colliergov.net",
    "Columbia County":"https://www.columbiacountyfla.com",
    "DeSoto County":"https://www.desotobocc.com",
    "Dixie County":"https://www.dixiecounty.us",
    "Duval County":"https://aca.coj.net",
    "Escambia County":"https://aca.escambiacountyfl.gov",
    "Flagler County":"https://aca.flaglercounty.org",
    "Franklin County":"https://www.franklincountyflorida.com",
    "Gadsden County":"https://www.gadsdencountyfl.gov",
    "Gilchrist County":"https://gilchrist.fl.us",
    "Glades County":"https://www.myglades.com",
    "Gulf County":"https://www.gulfcounty-fl.gov",
    "Hamilton County":"https://hamiltoncountyfl.com",
    "Hardee County":"https://www.hardeecounty.net",
    "Hendry County":"https://aca.hendryfla.net",
    "Hernando County":"https://pvweb.hernandopa-fl.us/",
    "Highlands County":"https://aca.highlandsfl.gov",
    "Hillsborough County":"https://aca-prod.accela.com/hcfl",
    "Holmes County":"https://holmescountyfl.org",
    "Indian River County":"https://aca.indianriver.gov",
    "Jackson County":"https://www.jacksoncountyfl.gov",
    "Jefferson County":"https://www.jeffersoncountyfl.gov",
    "Lafayette County":"https://lafayettecountyfl.com",
    "Lake County":"https://c.lakecountyfl.gov/offices/building_services/permit_activity_reports/permit_search_by_address.aspx",
    "Lee County":"https://aca.leegov.com",
    "Leon County":"https://aca.leoncountyfl.gov",
    "Levy County":"https://www.levycounty.org",
    "Liberty County":"https://www.libertycountyfl.org",
    "Madison County":"https://madisoncountyfl.com",
    "Manatee County":"https://aca.mymanatee.org",
    "Marion County":"https://selfservice.marionfl.org/energov_prod/selfservice#/search",
    "Martin County":"https://aca.martin.fl.us",
    "Miami-Dade County":"https://aca.miamidade.gov",
    "Monroe County":"https://aca.monroecounty-fl.gov",
    "Nassau County":"https://aca.nassaucountyfl.com",
    "Okaloosa County":"https://aca.okaloosafl.com",
    "Okeechobee County":"https://www.co.okeechobee.fl.us",
    "Orange County":"https://fasttrack.ocfl.net/OnlineServices/Inspections.aspx?filter=Search",
    "Osceola County":"https://permits.osceola.org",
    "Palm Beach County":"https://aca.pbcgov.org",
    "Pasco County":"https://aca-prod.accela.com/PASCO",
    "Pinellas County":"https://aca-prod.accela.com/PINELLAS/Cap/CapHome.aspx?module=Building&TabName=Building",
    "Polk County":"https://inspections.polk-county.net/",
    "Putnam County":"https://aca.putnam-fl.com",
    "Santa Rosa County":"https://aca.santarosa.fl.gov",
    "Sarasota County":"https://aca.scgov.net",
    "Seminole County":"https://semc-egov.aspgov.com/Click2GovBP/selectpermit.html",
    "St. Johns County":"https://aca.sjcfl.us",
    "St. Lucie County":"https://aca.stlucieco.gov",
    "Sumter County":"https://sumtercountyfl.gov/131/Permit-Application",
    "Suwannee County":"https://www.suwcounty.org",
    "Taylor County":"https://www.taylorcountygov.com",
    "Union County":"https://union.floridapa.com",
    "Volusia County":"https://connectlivepermits.org/citizenportal/app/public-search",
    "Wakulla County":"https://www.mywakulla.com",
    "Walton County":"https://aca.waltoncountyfl.com",
    "Washington County":"https://www.washingtonfl.com"
};

// CITY SPECIFIC PORTALS
const cityLinks = {
    "Orlando":"https://cityoforlandofl-permits.myrelayview.com/",
    "Tampa":"https://aca-prod.accela.com/TAMPA",
    "Daytona Beach":"https://daytonabeach.ims16.com/ims/Find3?cat=Permits",
    "St. Petersburg":"https://access.stpete.org/",
    "Clearwater":"https://www.myclearwater.com/government/departments/planning-development/building-permits",
    "Lakeland":"https://www.lakelandgov.net/departments/community-development/building-inspection-division/"
};

// COUNTY TO CITY MAPPING
const countyCities = {
    "Orange County":["Orlando","Winter Park","Apopka","Ocoee"],
    "Hillsborough County":["Tampa","Temple Terrace","Plant City"],
    "Pinellas County":["St. Petersburg","Clearwater","Largo","Dunedin"],
    "Polk County":["Lakeland","Winter Haven"],
    "Volusia County":["Daytona Beach","Deltona","Ormond Beach"]
};

function updateCities() {
    const county = document.getElementById("county").value;
    const city = document.getElementById("city");
    city.innerHTML = '<option value=""><?= htmlspecialchars(cms_field('permitstatus', 'portal_card.city_placeholder', 'Select City / Municipality (Optional)')) ?></option>';
    if (countyCities[county]) {
        countyCities[county].forEach(c => {
            const opt = document.createElement("option");
            opt.value = c;
            opt.text = c;
            city.add(opt);
        });
    }
}

function goPortal() {
    const county = document.getElementById("county").value;
    const city = document.getElementById("city").value;

    if (!county) {
        alert("Please select your Florida county first.");
        return;
    }

    if (city && cityLinks[city]) {
        window.open(cityLinks[city], "_blank");
        return;
    }

    if (counties[county]) {
        window.open(counties[county], "_blank");
        return;
    }

    alert("Direct portal link not found for selected county. Opening official county directory.");
    window.open("https://floridabuilding.org", "_blank");
}
</script>

</body>
</html>