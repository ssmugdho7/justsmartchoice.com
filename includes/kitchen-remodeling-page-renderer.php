<?php
if (!isset($sc_renderer)) { http_response_code(500); exit('Invalid page bootstrap.'); }
$root = dirname(__DIR__);
$service = (string)($page_service ?? 'Kitchen Remodeling');
$slug = (string)($page_service_slug ?? 'kitchen-remodeling');
$loc = (string)($page_location ?? 'Tampa Bay');
$locslug = (string)($page_location_slug ?? 'tampa-bay');
$county = (string)($page_county ?? 'Florida');
$intent = (string)($page_intent ?? 'service guide');
$zip = (string)($page_zip ?? '');
$style = (string)($page_style ?? '');
$requestPath = (string)(parse_url($_SERVER['REQUEST_URI'] ?? '/services/kitchen-remodeling/', PHP_URL_PATH) ?: '/services/kitchen-remodeling/');
if (substr($requestPath, -9) === 'index.php') { $requestPath = substr($requestPath, 0, -9); }
elseif (substr($requestPath, -4) === '.php') { $requestPath = substr($requestPath, 0, -4); }
if ($requestPath === '' || $requestPath[0] !== '/') { $requestPath = '/' . ltrim($requestPath, '/'); }
$canonical = 'https://justsmartchoice.com' . $requestPath;
$title = $service . ' in ' . $loc . ($zip !== '' ? ' ' . $zip : '') . ' | Smart Choice Contractors USA';
$description = 'Professional ' . strtolower($service) . ' guidance for ' . $loc . ', ' . $county . ', including design, cabinets, countertops, permits, budgeting, planning and contractor selection.';
$faq = [
 ['How much does a kitchen remodel cost?', 'Cost depends on kitchen size, cabinet scope, countertop material, plumbing and electrical changes, structural work, appliances, permits and finish level. A written site-specific estimate is required.'],
 ['Does a kitchen remodel require a permit?', 'Cosmetic work may be exempt, but structural, electrical, plumbing, mechanical or layout changes commonly require permits. Confirm current requirements with the local building department before work begins.'],
 ['How long does kitchen remodeling take?', 'Design, product lead times, permits, demolition, rough trades, inspections, cabinets, countertops and finish work all affect the schedule.'],
 ['How can homeowners reduce remodeling risk?', 'Verify licenses and insurance, require a detailed written scope, confirm permit responsibility, document selections and use milestone-based payments.']
];
$schema = ['@context'=>'https://schema.org','@graph'=>[
 ['@type'=>'WebPage','@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$title,'description'=>$description,'isPartOf'=>['@type'=>'WebSite','@id'=>'https://justsmartchoice.com/#website','url'=>'https://justsmartchoice.com/','name'=>'Smart Choice Contractors USA']],
 ['@type'=>'Service','@id'=>$canonical.'#service','name'=>$service,'serviceType'=>$service,'areaServed'=>[['@type'=>'City','name'=>$loc],['@type'=>'AdministrativeArea','name'=>$county]],'provider'=>['@type'=>'GeneralContractor','@id'=>'https://justsmartchoice.com/#organization','name'=>'Smart Choice Contractors USA','url'=>'https://justsmartchoice.com/','telephone'=>'+1-727-755-3786'],'description'=>$description,'url'=>$canonical],
 ['@type'=>'BreadcrumbList','itemListElement'=>[
   ['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>'https://justsmartchoice.com/'],
   ['@type'=>'ListItem','position'=>2,'name'=>'Services','item'=>'https://justsmartchoice.com/services.php'],
   ['@type'=>'ListItem','position'=>3,'name'=>'Kitchen Remodeling','item'=>'https://justsmartchoice.com/services/kitchen-remodeling/'],
   ['@type'=>'ListItem','position'=>4,'name'=>$service.' '.$loc,'item'=>$canonical]
 ]],
 ['@type'=>'FAQPage','mainEntity'=>array_map(static fn($f)=>['@type'=>'Question','name'=>$f[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$f[1]]],$faq)]
]];
$seo=['title'=>$title,'description'=>$description,'canonical'=>$canonical,'image'=>'https://justsmartchoice.com/images/fg-image.png','schema'=>$schema];
$headFile=$root.'/includes/kitchen-remodeling-seo-head.php';
$headerFile=$root.'/sections-library/header.php';
$footerFile=$root.'/sections-library/footer.php';
$cookieHead=$root.'/includes/cookie-consent-head.php';
$cookieBody=$root.'/includes/cookie-consent.php';
?><!DOCTYPE html>
<html lang="en">
<head>
<?php if (is_file($cookieHead)) { include $cookieHead; } ?>
<?php require $headFile; ?>
</head>
<body>
<?php if (is_file($cookieBody)) { include $cookieBody; } ?>
<?php if (is_file($headerFile)) { include $headerFile; } else { http_response_code(500); echo '<p>Shared website header is missing.</p>'; } ?>
<main class="sc-k-page" id="main-content">
<section class="sc-k-hero"><div class="sc-k-wrap">
<p class="sc-k-eyebrow">Smart Choice Contractors USA · <?=htmlspecialchars($county,ENT_QUOTES,'UTF-8')?><?= $zip !== '' ? ' · ZIP '.htmlspecialchars($zip,ENT_QUOTES,'UTF-8') : '' ?></p>
<h1><?=htmlspecialchars($service.' in '.$loc,ENT_QUOTES,'UTF-8')?></h1>
<p><?=htmlspecialchars($description,ENT_QUOTES,'UTF-8')?></p>
<div class="sc-k-actions"><a class="button button-primary" href="/contacts.php">Request an Estimate</a><a class="button button-default-outline" href="tel:+17277553786">Call (727) 755-3786</a></div>
</div></section>
<section class="sc-k-section"><div class="sc-k-wrap"><div class="sc-k-grid">
<article class="sc-k-card"><h2>Project Scope</h2><p>Kitchen projects can include design, demolition, cabinets, countertops, flooring, backsplash, lighting, plumbing, electrical work, ventilation, appliances, painting and finish carpentry.</p></article>
<article class="sc-k-card"><h2>Local Planning</h2><p>For work in <?=htmlspecialchars($loc,ENT_QUOTES,'UTF-8')?>, verify existing conditions, utility locations, jurisdiction, permit requirements, inspections, HOA restrictions and material lead times before finalizing the schedule.</p></article>
<article class="sc-k-card"><h2><?=htmlspecialchars(ucwords($intent),ENT_QUOTES,'UTF-8')?></h2><p>This resource addresses local contractor selection, costs, design options, cabinets, countertops, permits and practical kitchen remodeling decisions<?= $style !== '' ? ' for a '.htmlspecialchars(strtolower($style),ENT_QUOTES,'UTF-8').' design direction' : '' ?>.</p></article>
</div></div></section>
<section class="sc-k-section"><div class="sc-k-wrap"><h2>Kitchen Remodeling Priorities</h2><div class="sc-k-grid">
<div class="sc-k-card"><h3>Layout and Function</h3><p>Plan workflow, appliance clearances, storage, landing areas, lighting, ventilation and safe circulation before selecting finishes.</p></div>
<div class="sc-k-card"><h3>Cabinets and Storage</h3><p>Compare refacing, stock, semi-custom and custom cabinetry based on existing condition, layout, budget, durability and lead time.</p></div>
<div class="sc-k-card"><h3>Countertops and Surfaces</h3><p>Evaluate quartz, granite, porcelain, solid surface and butcher block for durability, maintenance, seams, support and appearance.</p></div>
<div class="sc-k-card"><h3>Trade Coordination</h3><p>Plumbing, electrical, ventilation, framing and appliance requirements should be coordinated before cabinets and finishes are ordered.</p></div>
</div></div></section>
<section class="sc-k-section"><div class="sc-k-wrap"><h2>Permits and Consumer Resources</h2><div class="sc-k-links">
<a target="_blank" rel="noopener" href="https://www.hernandocounty.us/building-development/building/">Hernando County Building Department</a>
<a target="_blank" rel="noopener" href="https://aca-prod.accela.com/pasco/default.aspx">Pasco County Permitting Portal</a>
<a target="_blank" rel="noopener" href="https://www.hillsboroughcounty.org/en/businesses/permits-and-records/permits">Hillsborough County Permits</a>
<a target="_blank" rel="noopener" href="https://www.floridabuilding.org/">Florida Building Code</a>
</div></div></section>
<section class="sc-k-section"><div class="sc-k-wrap"><h2>Frequently Asked Questions</h2><?php foreach($faq as $f): ?><article class="sc-k-card sc-k-faq"><h3><?=htmlspecialchars($f[0],ENT_QUOTES,'UTF-8')?></h3><p><?=htmlspecialchars($f[1],ENT_QUOTES,'UTF-8')?></p></article><?php endforeach; ?></div></section>
<section class="sc-k-section"><div class="sc-k-wrap"><div class="sc-k-callout"><h2>Written Scope and Consumer Protection</h2><p>Compare complete written scopes rather than headline prices. Confirm credentials, insurance, permits, allowances, exclusions, change orders, payment milestones, cleanup, warranties and final inspection responsibilities before signing.</p></div></div></section>
<section class="sc-k-section"><div class="sc-k-wrap sc-k-cta"><h2>Discuss Your <?=htmlspecialchars($loc,ENT_QUOTES,'UTF-8')?> Kitchen Project</h2><p>Request a consultation for design, planning, permit coordination and construction pricing.</p><a class="button button-primary" href="/contacts.php">Contact Smart Choice Contractors USA</a></div></section>
</main>
<?php if (is_file($footerFile)) { include $footerFile; } else { http_response_code(500); echo '<p>Shared website footer is missing.</p>'; } ?>
</body></html>
