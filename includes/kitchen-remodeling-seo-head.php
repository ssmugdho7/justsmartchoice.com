<?php
if (!isset($seo) || !is_array($seo)) { $seo = []; }
$title = (string)($seo['title'] ?? 'Kitchen Remodeling | Smart Choice Contractors USA');
$description = (string)($seo['description'] ?? 'Kitchen remodeling, cabinets, countertops, design, permits and project planning across Tampa Bay.');
$canonical = (string)($seo['canonical'] ?? 'https://justsmartchoice.com/services/kitchen-remodeling/');
$image = (string)($seo['image'] ?? 'https://justsmartchoice.com/images/fg-image.png');
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
<title><?=htmlspecialchars($title, ENT_QUOTES, 'UTF-8')?></title>
<meta name="description" content="<?=htmlspecialchars($description, ENT_QUOTES, 'UTF-8')?>">
<meta name="author" content="Smart Choice Contractors USA">
<meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
<link rel="canonical" href="<?=htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8')?>">
<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Smart Choice Contractors USA">
<meta property="og:locale" content="en_US">
<meta property="og:title" content="<?=htmlspecialchars($title, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:description" content="<?=htmlspecialchars($description, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:url" content="<?=htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:image" content="<?=htmlspecialchars($image, ENT_QUOTES, 'UTF-8')?>">
<meta property="og:image:alt" content="Kitchen remodeling services by Smart Choice Contractors USA">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=htmlspecialchars($title, ENT_QUOTES, 'UTF-8')?>">
<meta name="twitter:description" content="<?=htmlspecialchars($description, ENT_QUOTES, 'UTF-8')?>">
<meta name="twitter:image" content="<?=htmlspecialchars($image, ENT_QUOTES, 'UTF-8')?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/custom.css?v=60">
<link rel="stylesheet" href="/services/kitchen-remodeling/assets/kitchen-seo.css?v=3">
<?php if (!empty($seo['schema'])): ?>
<script type="application/ld+json"><?=json_encode($seo['schema'], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP)?></script>
<?php endif; ?>
