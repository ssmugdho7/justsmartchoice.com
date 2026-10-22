<?php
if (!isset($seo)) $seo=[];
$title=$seo['title']??'Plumbing Services | Smart Choice Contractors USA';
$description=$seo['description']??'Professional plumbing information and project coordination across Tampa Bay.';
$canonical=$seo['canonical']??'https://justsmartchoice.com/services/plumbing/';
?><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=htmlspecialchars($title,ENT_QUOTES,'UTF-8')?></title>
<meta name="description" content="<?=htmlspecialchars($description,ENT_QUOTES,'UTF-8')?>">
<link rel="canonical" href="<?=htmlspecialchars($canonical,ENT_QUOTES,'UTF-8')?>">
<meta property="og:type" content="website"><meta property="og:title" content="<?=htmlspecialchars($title,ENT_QUOTES,'UTF-8')?>"><meta property="og:description" content="<?=htmlspecialchars($description,ENT_QUOTES,'UTF-8')?>"><meta property="og:url" content="<?=htmlspecialchars($canonical,ENT_QUOTES,'UTF-8')?>">
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="<?=htmlspecialchars($title,ENT_QUOTES,'UTF-8')?>"><meta name="twitter:description" content="<?=htmlspecialchars($description,ENT_QUOTES,'UTF-8')?>">
<link rel="stylesheet" href="/services/plumbing/assets/plumbing-seo.css">
<?php if(!empty($seo['schema'])):?><script type="application/ld+json"><?=json_encode($seo['schema'],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)?></script><?php endif;?>
