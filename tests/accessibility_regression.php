<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
chdir(dirname(__DIR__));
$_SERVER['REQUEST_URI']='/';
ob_start();require 'index.php';$html=ob_get_clean();
libxml_use_internal_errors(true);$dom=new DOMDocument();$dom->loadHTML($html);$xp=new DOMXPath($dom);
$checks=0;function verify($ok,$message){if(!$ok)throw new RuntimeException($message);$GLOBALS['checks']++;}
verify($xp->query('//main[@id="main-content"]')->length===1,'one main landmark wraps homepage content');
verify($xp->query('//main//header|//main//footer')->length===0,'site header and footer stay outside main');
verify($xp->query('//a[@href="#main-content" and contains(@class,"sc-skip-link")]')->length===1,'keyboard skip link targets the main landmark');
verify($xp->query('//nav[@aria-label="Main navigation"]//ul[@id="site-menu-links"]')->length===1,'navigation landmark contains the menu');
verify($xp->query('//button[@aria-controls="site-menu-links" and @aria-expanded="false"]')->length===1,'mobile menu exposes its controlled element and initial state');
verify($xp->query('//button[@aria-controls="site-contact-information" and @aria-expanded="false"]')->length===1,'mobile contact panel exposes its controlled element and state');
verify($xp->query('//footer[contains(@class,"smart-choice-footer-wrapper")]')->length===1,'legal links and company details share one footer landmark');
verify($xp->query('//footer//footer')->length===0,'footer landmarks are not nested');
verify($xp->query('//button[@id="open-cookie-preferences" and @type="button"]')->length===1,'preferences action is a native button');
verify($xp->query('//*[@id="cookie-modal" and @hidden and @aria-labelledby="cookie-preferences-title"]')->length===1,'closed dialog is hidden and named by its visible heading');
foreach(['necessary','analytics','marketing'] as $name){
 verify($xp->query('//label[@for="opt-'.$name.'"]')->length===1,'native cookie label: '.$name);
 verify($xp->query('//*[@id="opt-'.$name.'-description"]')->length===1,'cookie description: '.$name);
}
verify($xp->query('//a[contains(@class,"smart-footer-review-card") and @aria-label]')->length===0,'review names preserve visible text');
verify($xp->query('//a[contains(@class,"sc-header-phone-number") and @aria-label]')->length===0,'phone number remains in its accessible name');
verify($xp->query('//a[contains(@class,"section-banner") and @href="charger.php" and @aria-label]')->length===1,'linked charger promotion has an accessible name');
verify($xp->query('//script[contains(@src,"/js/accessibility.js")]')->length===1,'accessibility enhancements load once');
echo "PASS $checks rendered accessibility markup checks.\n";
