<?php
if (!isset($seo)) { $seo=[]; }
$title=$seo['title'] ?? 'Engineering Services | Smart Choice Contractors USA';
$description=$seo['description'] ?? 'Engineering coordination, drafting, construction drawings, permit plans, inspections, and blueprint printing in Tampa Bay.';
$canonical=$seo['canonical'] ?? 'https://justsmartchoice.com/services/engineering/';
$schema=$seo['schema'] ?? [];
?><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=htmlspecialchars($title,ENT_QUOTES,'UTF-8')?></title>
<meta name="description" content="<?=htmlspecialchars($description,ENT_QUOTES,'UTF-8')?>">
<link rel="canonical" href="<?=htmlspecialchars($canonical,ENT_QUOTES,'UTF-8')?>">
<meta property="og:type" content="website"><meta property="og:title" content="<?=htmlspecialchars($title,ENT_QUOTES,'UTF-8')?>"><meta property="og:description" content="<?=htmlspecialchars($description,ENT_QUOTES,'UTF-8')?>"><meta property="og:url" content="<?=htmlspecialchars($canonical,ENT_QUOTES,'UTF-8')?>">
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="<?=htmlspecialchars($title,ENT_QUOTES,'UTF-8')?>"><meta name="twitter:description" content="<?=htmlspecialchars($description,ENT_QUOTES,'UTF-8')?>">
<link rel="stylesheet" href="/services/engineering/assets/engineering-seo.css">
<?php if($schema):?><script type="application/ld+json"><?=json_encode($schema,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)?></script><?php endif;?>
