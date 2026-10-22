<?php
declare(strict_types=1);

/**
 * Smart Choice Contractors USA - Instant Reward Center
 * Upload to: public_html/cardcoupon.php
 * PHP 8.5 / Bluehost compatible.
 */

const SC_COMPANY_NAME  = 'Smart Choice Contractors USA';
const SC_WEBSITE_URL   = 'https://justsmartchoice.com/';
const SC_PAGE_URL      = 'https://justsmartchoice.com/cardcoupon.php';
const SC_BOOKING_URL   = 'https://crm.justsmartchoice.com/appointly/appointments_public/book?col=col-md-8+col-md-offset-2';
const SC_PHONE_DISPLAY = '(727) 755-5737';
const SC_PHONE_LINK    = '+17277555737';
const SC_EMAIL         = 'info@justsmartchoice.com';
const SC_VIDEO_URL     = 'https://justsmartchoice.com/assets/videos/smart-choice-commercial.mp4';
const SC_LOGO_URL      = 'https://justsmartchoice.com/images/smart-choice-logo.png';
const SC_TIMEZONE      = 'America/New_York';
const SC_COUPON_DAYS   = 30;
const SC_REVEAL_SECONDS = 12;

date_default_timezone_set(SC_TIMEZONE);

$storageRoot = __DIR__ . '/storage/cardcoupon';
$claimsDir   = $storageRoot . '/claims';
$logsDir     = $storageRoot . '/logs';
foreach ([$storageRoot, $claimsDir, $logsDir] as $dir) {
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        http_response_code(500);
        exit('Unable to initialize coupon storage.');
    }
}
if (!is_file($storageRoot . '/.htaccess')) {
    @file_put_contents($storageRoot . '/.htaccess', "Options -Indexes\nRequire all denied\n");
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('sc_cardcoupon');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
if (empty($_SESSION['sc_coupon_csrf'])) {
    $_SESSION['sc_coupon_csrf'] = bin2hex(random_bytes(32));
}

header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

function sc_e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sc_client_ip(): string
{
    foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'] as $key) {
        if (empty($_SERVER[$key])) {
            continue;
        }
        $ip = trim(explode(',', (string) $_SERVER[$key])[0]);
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }
    return '0.0.0.0';
}

function sc_phone(string $phone): string
{
    return substr((string) preg_replace('/\D+/', '', $phone), 0, 15);
}

function sc_services(): array
{
    return [
        'bathroom-remodeling' => 'Bathroom Remodeling',
        'kitchen-remodeling' => 'Kitchen Remodeling',
        'whole-home-remodeling' => 'Whole-Home Remodeling',
        'flooring' => 'Flooring and Tile',
        'roofing' => 'Roofing',
        'windows-doors' => 'Windows and Doors',
        'painting' => 'Interior and Exterior Painting',
        'electrical' => 'Electrical',
        'plumbing' => 'Plumbing',
        'hvac' => 'HVAC',
        'new-construction' => 'New Construction',
        'commercial' => 'Commercial Construction',
        'engineering' => 'Engineering and Drawings',
        'other' => 'Other Construction Service',
    ];
}

function sc_reward_pool(): array
{
    return [
        ['title' => '$100 Project Credit', 'type' => 'discount', 'value' => 100, 'minimum' => 2500, 'weight' => 25, 'details' => 'Valid toward an eligible Smart Choice project of $2,500 or more.'],
        ['title' => '$200 Project Credit', 'type' => 'discount', 'value' => 200, 'minimum' => 5000, 'weight' => 22, 'details' => 'Valid toward an eligible Smart Choice project of $5,000 or more.'],
        ['title' => '$300 Project Credit', 'type' => 'discount', 'value' => 300, 'minimum' => 7500, 'weight' => 14, 'details' => 'Valid toward an eligible Smart Choice project of $7,500 or more.'],
        ['title' => '$500 Project Credit', 'type' => 'discount', 'value' => 500, 'minimum' => 15000, 'weight' => 6, 'details' => 'Valid toward an eligible Smart Choice project of $15,000 or more.'],
        ['title' => 'Complimentary Design Consultation', 'type' => 'service', 'value' => 0, 'minimum' => 0, 'weight' => 12, 'details' => 'Receive a complimentary project design consultation with an eligible appointment.'],
        ['title' => 'Complimentary Permit Readiness Review', 'type' => 'service', 'value' => 0, 'minimum' => 0, 'weight' => 8, 'details' => 'Receive a preliminary permit-readiness review for your proposed project.'],
        ['title' => 'Complimentary Project Upgrade', 'type' => 'service', 'value' => 0, 'minimum' => 7500, 'weight' => 8, 'details' => 'Receive an eligible project upgrade selected with your representative.'],
        ['title' => 'A New Reward Unlocks Tomorrow', 'type' => 'retry', 'value' => 0, 'minimum' => 0, 'weight' => 5, 'details' => 'Today\'s reward window has closed. Return tomorrow for another opportunity.'],
    ];
}

function sc_select_reward(): array
{
    $pool = sc_reward_pool();
    $draw = random_int(1, array_sum(array_column($pool, 'weight')));
    foreach ($pool as $reward) {
        $draw -= (int) $reward['weight'];
        if ($draw <= 0) {
            return $reward;
        }
    }
    return $pool[0];
}

function sc_coupon_code(): string
{
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $groups = [];
    for ($g = 0; $g < 3; $g++) {
        $part = '';
        for ($i = 0; $i < 4; $i++) {
            $part .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $groups[] = $part;
    }
    return 'SC-' . implode('-', $groups);
}

function sc_fingerprint(string $email, string $phone): string
{
    return hash('sha256', implode('|', [
        sc_client_ip(),
        (string) ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'),
        strtolower(trim($email)),
        sc_phone($phone),
        date('Y-m-d'),
    ]));
}

function sc_signature(string $code, string $expires): string
{
    $secret = hash('sha256', __FILE__ . SC_COMPANY_NAME . SC_PAGE_URL);
    return substr(hash_hmac('sha256', $code . '|' . $expires, $secret), 0, 16);
}

$isAjax = strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAjax) {
    header('Content-Type: application/json; charset=UTF-8');

    $csrf = (string) ($_POST['csrf'] ?? '');
    if (!hash_equals((string) $_SESSION['sc_coupon_csrf'], $csrf)) {
        http_response_code(419);
        echo json_encode(['success' => false, 'message' => 'Your secure session expired. Refresh the page.']);
        exit;
    }

    $firstName = trim((string) ($_POST['first_name'] ?? ''));
    $lastName  = trim((string) ($_POST['last_name'] ?? ''));
    $email     = strtolower(trim((string) ($_POST['email'] ?? '')));
    $phone     = sc_phone((string) ($_POST['phone'] ?? ''));
    $service   = trim((string) ($_POST['service'] ?? ''));
    $consent   = (string) ($_POST['consent'] ?? '') === '1';
    $services  = sc_services();
    $errors    = [];

    if ($firstName === '' || mb_strlen($firstName) > 80) $errors[] = 'Enter a valid first name.';
    if ($lastName === '' || mb_strlen($lastName) > 80) $errors[] = 'Enter a valid last name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) $errors[] = 'Enter a valid email address.';
    if (strlen($phone) < 10) $errors[] = 'Enter a valid phone number.';
    if (!array_key_exists($service, $services)) $errors[] = 'Select a service.';
    if (!$consent) $errors[] = 'Consent is required to validate your reward.';

    if ($errors !== []) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    $fingerprint = sc_fingerprint($email, $phone);
    $claimFile = $claimsDir . '/' . $fingerprint . '.json';
    if (is_file($claimFile)) {
        $existing = json_decode((string) file_get_contents($claimFile), true);
        if (is_array($existing)) {
            echo json_encode(['success' => true, 'existing' => true, 'claim' => $existing]);
            exit;
        }
    }

    $reward = sc_select_reward();
    $code = sc_coupon_code();
    $issued = date(DATE_ATOM);
    $expires = date(DATE_ATOM, strtotime('+' . SC_COUPON_DAYS . ' days'));

    $claim = [
        'coupon_code' => $code,
        'verification' => sc_signature($code, $expires),
        'reward_title' => $reward['title'],
        'reward_type' => $reward['type'],
        'reward_value' => $reward['value'],
        'minimum_project' => $reward['minimum'],
        'reward_details' => $reward['details'],
        'service_key' => $service,
        'service_name' => $services[$service],
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'phone' => $phone,
        'issued_at' => $issued,
        'expires_at' => $expires,
        'redeemed' => false,
        'source' => 'Business Card QR',
        'ip_hash' => hash('sha256', sc_client_ip()),
        'user_agent' => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500),
    ];

    $json = json_encode($claim, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    if ($json === false || file_put_contents($claimFile, $json, LOCK_EX) === false) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'The reward could not be saved. Please call Smart Choice.']);
        exit;
    }
    @file_put_contents($logsDir . '/claims-' . date('Y-m') . '.jsonl', json_encode($claim, JSON_UNESCAPED_SLASHES) . PHP_EOL, FILE_APPEND | LOCK_EX);

    echo json_encode(['success' => true, 'existing' => false, 'claim' => $claim]);
    exit;
}

$headerCandidates = [__DIR__ . '/includes/header.php', __DIR__ . '/library/header.php', __DIR__ . '/inc/header.php'];
$footerCandidates = [__DIR__ . '/includes/footer.php', __DIR__ . '/library/footer.php', __DIR__ . '/inc/footer.php'];
$headerHtml = '';
$footerFile = null;
foreach ($headerCandidates as $candidate) {
    if (is_file($candidate)) {
        ob_start();
        include $candidate;
        $headerHtml = (string) ob_get_clean();
        break;
    }
}
foreach ($footerCandidates as $candidate) {
    if (is_file($candidate)) {
        $footerFile = $candidate;
        break;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Unlock Your Smart Choice Reward | Smart Choice Contractors USA</title>
<meta name="description" content="Watch the Smart Choice video, select your project, and unlock a limited construction reward.">
<meta name="robots" content="index,follow,max-image-preview:large">
<link rel="canonical" href="<?= sc_e(SC_PAGE_URL) ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="Unlock Your Smart Choice Reward">
<meta property="og:description" content="Watch, select your project, and reveal your Smart Choice reward.">
<meta property="og:url" content="<?= sc_e(SC_PAGE_URL) ?>">
<style>
:root{--g:#169179;--gd:#0e6f5b;--b:#2ca8ff;--o:#f96302;--y:#f5b400;--k:#111827;--gr:#4b5563;--lt:#f8fafc;--bd:#d1d5db;--m:#eef7f4;--w:#fff;--sh:0 18px 45px rgba(17,24,39,.12)}*{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;color:var(--k);background:var(--lt);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;line-height:1.55;-webkit-font-smoothing:antialiased}img,video{max-width:100%}a{color:inherit}button,input,select{font:inherit}.shell{width:min(1180px,calc(100% - 28px));margin:auto}.fallback-header{position:sticky;top:0;z-index:1000;background:rgba(255,255,255,.97);border-bottom:1px solid var(--bd);backdrop-filter:blur(12px)}.nav{min-height:74px;display:flex;align-items:center;justify-content:space-between;gap:24px}.brand{display:flex;align-items:center;gap:12px;text-decoration:none}.brand img{height:54px;width:auto;object-fit:contain}.brand-text{font-size:1.15rem;font-weight:900}.brand-text span{color:var(--g)}.navlinks{display:flex;align-items:center;gap:18px;font-size:.92rem;font-weight:800}.navlinks a{text-decoration:none}.navcta{padding:10px 15px;border-radius:10px;color:#fff;background:var(--g)}.hero{padding:54px 0 34px;background:#fff;border-bottom:1px solid var(--bd)}.hero-grid{display:grid;grid-template-columns:1.02fr .98fr;gap:42px;align-items:center}.eyebrow{display:inline-flex;margin-bottom:16px;padding:7px 11px;border:1px solid rgba(22,145,121,.25);border-radius:999px;color:var(--gd);background:var(--m);font-size:.78rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em}.hero h1{margin:0;font-size:clamp(2.35rem,6vw,5.2rem);line-height:.98;letter-spacing:-.065em}.hero h1 strong{color:var(--g)}.hero p{max-width:660px;color:var(--gr);font-size:clamp(1rem,1.8vw,1.24rem)}.pills{display:flex;flex-wrap:wrap;gap:10px;margin-top:24px}.pill{padding:9px 12px;border:1px solid var(--bd);border-radius:999px;background:#fff;font-size:.85rem;font-weight:800}.video-card{overflow:hidden;border:1px solid var(--bd);border-radius:24px;background:#000;box-shadow:var(--sh)}.video-wrap{position:relative;aspect-ratio:16/9}.video-wrap video{width:100%;height:100%;display:block;object-fit:cover}.sound{position:absolute;right:14px;bottom:14px;border:0;border-radius:999px;padding:10px 13px;color:#fff;background:rgba(17,24,39,.88);font-weight:800;cursor:pointer}.video-note{padding:14px 18px;color:#d1d5db;background:#111827;font-size:.84rem}.main{padding:42px 0 80px}.steps{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:26px}.step{padding:14px;border:1px solid var(--bd);border-radius:14px;background:#fff;text-align:center;font-size:.83rem;font-weight:900}.step.active{border-color:var(--g);color:var(--gd);background:var(--m)}.panel{padding:clamp(22px,4vw,42px);border:1px solid var(--bd);border-radius:24px;background:#fff;box-shadow:var(--sh)}.panel h2{margin:0;font-size:clamp(1.8rem,4vw,3rem);letter-spacing:-.045em}.panel p{color:var(--gr)}.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.field.full{grid-column:1/-1}.field label{display:block;margin-bottom:7px;font-size:.86rem;font-weight:900}.input,.select{width:100%;min-height:48px;border:1px solid var(--bd);border-radius:11px;padding:11px 13px;background:#fff;outline:none}.input:focus,.select:focus{border-color:var(--b);box-shadow:0 0 0 4px rgba(44,168,255,.14)}.consent{display:flex;gap:11px;align-items:flex-start;padding:14px;border:1px solid var(--bd);border-radius:12px;background:var(--lt);color:var(--gr);font-size:.84rem}.consent input{width:18px;height:18px;margin-top:2px;accent-color:var(--g)}.buttons{display:flex;flex-wrap:wrap;gap:12px;margin-top:24px}.btn{min-height:46px;display:inline-flex;align-items:center;justify-content:center;border:1px solid transparent;border-radius:11px;padding:11px 17px;text-decoration:none;font-weight:900;cursor:pointer}.btn.primary{color:#fff;background:var(--g)}.btn.secondary{color:#fff;background:var(--b)}.btn.orange{color:#fff;background:var(--o)}.btn.light{border-color:var(--bd);background:#fff}.status{min-height:24px;margin-top:14px;color:#b91c1c;font-weight:800}.reveal,.result{display:none;text-align:center}.reveal.show,.result.show{display:block}.machine{min-height:290px;display:grid;place-items:center;margin:18px 0;border:1px solid var(--bd);border-radius:20px;background:#111827}.machine-core{width:min(420px,calc(100% - 40px));padding:28px;border:1px solid rgba(255,255,255,.2);border-radius:18px;color:#fff;background:rgba(255,255,255,.08)}.spinner{width:78px;height:78px;margin:0 auto 18px;border:7px solid rgba(255,255,255,.16);border-top-color:var(--y);border-right-color:var(--g);border-radius:50%;animation:spin .9s linear infinite}@keyframes spin{to{transform:rotate(360deg)}}.progress{height:10px;overflow:hidden;margin-top:18px;border-radius:999px;background:rgba(255,255,255,.14)}.progress span{display:block;width:0;height:100%;background:var(--y);transition:width .45s}.result-card{padding:clamp(24px,5vw,44px);border:2px dashed var(--g);border-radius:22px;background:var(--m);text-align:center}.result-title{margin:10px 0;font-size:clamp(2rem,7vw,4.5rem);line-height:1;letter-spacing:-.055em}.code{display:inline-block;margin:14px 0;padding:12px 16px;border:1px solid var(--bd);border-radius:10px;background:#fff;font-family:ui-monospace,monospace;font-weight:900;letter-spacing:.08em;word-break:break-word}.meta{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:20px}.meta>div{padding:12px;border:1px solid var(--bd);border-radius:12px;background:#fff}.meta small{display:block;color:var(--gr)}.section{padding:64px 0;background:#fff;border-top:1px solid var(--bd)}.section-title{max-width:740px;margin:0 auto 28px;text-align:center}.services{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.service{padding:18px;border:1px solid var(--bd);border-radius:15px;background:var(--lt)}.fallback-footer{padding:34px 0;color:#d1d5db;background:#111827}.footer-grid{display:grid;grid-template-columns:1.2fr .8fr;gap:28px}.footer-links{display:flex;flex-wrap:wrap;gap:12px 18px}.footer-links a{color:#fff;text-decoration:none}.toast{position:fixed;z-index:9999;right:18px;bottom:18px;max-width:min(420px,calc(100% - 36px));padding:14px 16px;border:1px solid var(--bd);border-left:5px solid var(--g);border-radius:12px;background:#fff;box-shadow:var(--sh);font-weight:800;opacity:0;transform:translateY(14px);pointer-events:none;transition:.22s}.toast.show{opacity:1;transform:translateY(0)}.confetti{position:fixed;z-index:9998;top:-12px;width:10px;height:16px;pointer-events:none;animation:fall 2.8s linear forwards}@keyframes fall{to{transform:translate3d(var(--drift),110vh,0) rotate(720deg);opacity:.95}}.hidden{display:none!important}@media(max-width:900px){.hero-grid,.footer-grid{grid-template-columns:1fr}.services{grid-template-columns:repeat(2,1fr)}.navlinks{display:none}}@media(max-width:640px){.shell{width:min(100% - 18px,1180px)}.grid,.meta,.steps,.services{grid-template-columns:1fr}.buttons .btn{width:100%}.brand img{height:46px}}@media print{body *{visibility:hidden!important}#couponResult,#couponResult *{visibility:visible!important}#couponResult{position:absolute;inset:0;width:100%;display:block!important}.no-print{display:none!important}}
</style>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Smart Choice Instant Reward Center","url":"<?= sc_e(SC_PAGE_URL) ?>","about":{"@type":"HomeAndConstructionBusiness","name":"<?= sc_e(SC_COMPANY_NAME) ?>","url":"<?= sc_e(SC_WEBSITE_URL) ?>","telephone":"<?= sc_e(SC_PHONE_LINK) ?>","email":"<?= sc_e(SC_EMAIL) ?>"}}</script>
</head>
<body>
<?php if ($headerHtml !== ''): ?><?= $headerHtml ?><?php else: ?>
<header class="fallback-header"><div class="shell nav"><a class="brand" href="<?= sc_e(SC_WEBSITE_URL) ?>"><img src="<?= sc_e(SC_LOGO_URL) ?>" alt="<?= sc_e(SC_COMPANY_NAME) ?>" onerror="this.style.display='none';this.nextElementSibling.style.display='inline-block'"><span class="brand-text" style="display:none">Smart <span>Choice</span> Contractors</span></a><nav class="navlinks"><a href="<?= sc_e(SC_WEBSITE_URL) ?>">Home</a><a href="<?= sc_e(SC_WEBSITE_URL) ?>services.php">Services</a><a href="<?= sc_e(SC_WEBSITE_URL) ?>about.php">About</a><a href="<?= sc_e(SC_WEBSITE_URL) ?>contacts.php">Contact</a><a class="navcta" href="<?= sc_e(SC_BOOKING_URL) ?>">Book Appointment</a></nav></div></header>
<?php endif; ?>
<section class="hero"><div class="shell hero-grid"><div><div class="eyebrow">Business Card Exclusive</div><h1>Watch. Select. <strong>Unlock Your Reward.</strong></h1><p>Choose your project and reveal a limited Smart Choice reward. Save the unique code to your phone and present it to your representative.</p><div class="pills"><span class="pill">Unique code</span><span class="pill">30-day validity</span><span class="pill">Mobile ready</span><span class="pill">Appointment access</span></div></div><article class="video-card"><div class="video-wrap"><video id="promoVideo" autoplay muted playsinline preload="metadata" controls><source src="<?= sc_e(SC_VIDEO_URL) ?>" type="video/mp4"></video><button type="button" class="sound" id="soundButton">Tap for sound</button></div><div class="video-note">The video starts muted because mobile browsers require a tap before enabling sound.</div></article></div></section>
<main class="main" id="rewardCenter"><div class="shell"><div class="steps"><div class="step active" id="step1">1. Project and contact</div><div class="step" id="step2">2. Reward search</div><div class="step" id="step3">3. Save and book</div></div>
<section class="panel" id="leadPanel"><div class="eyebrow">Step 1</div><h2>Tell us what you are planning.</h2><p>Every participant receives one reward check per day. Your information validates the reward and appointment.</p><form id="rewardForm" novalidate><input type="hidden" name="csrf" value="<?= sc_e((string) $_SESSION['sc_coupon_csrf']) ?>"><div class="grid"><div class="field"><label for="first_name">First name</label><input class="input" id="first_name" name="first_name" maxlength="80" autocomplete="given-name" required></div><div class="field"><label for="last_name">Last name</label><input class="input" id="last_name" name="last_name" maxlength="80" autocomplete="family-name" required></div><div class="field"><label for="email">Email</label><input class="input" type="email" id="email" name="email" maxlength="190" autocomplete="email" required></div><div class="field"><label for="phone">Mobile phone</label><input class="input" type="tel" id="phone" name="phone" maxlength="24" autocomplete="tel" required></div><div class="field full"><label for="service">Which service are you considering?</label><select class="select" id="service" name="service" required><option value="">Select a service</option><?php foreach (sc_services() as $key => $label): ?><option value="<?= sc_e($key) ?>"><?= sc_e($label) ?></option><?php endforeach; ?></select></div><div class="field full"><label class="consent" for="consent"><input type="checkbox" id="consent" name="consent" value="1" required><span>I authorize Smart Choice Contractors USA to contact me regarding this request, appointments, and this reward. Consent is not a condition of purchase. Message and data rates may apply.</span></label></div></div><div class="buttons"><button class="btn primary" type="submit" id="revealButton">Reveal My Reward</button><a class="btn light" href="<?= sc_e(SC_BOOKING_URL) ?>">Book Without Reward</a></div><div class="status" id="formStatus" role="alert"></div></form></section>
<section class="panel reveal" id="revealPanel"><div class="eyebrow">Step 2</div><h2>Searching for your Smart Choice reward.</h2><p>Please keep this page open while we securely register your unique code.</p><div class="machine"><div class="machine-core"><div class="spinner"></div><strong id="machineMessage">Reviewing available rewards...</strong><div class="progress"><span id="progressBar"></span></div></div></div></section>
<section class="panel result" id="couponResult"><div class="result-card"><div class="eyebrow" id="resultKicker">Congratulations</div><h2 class="result-title" id="rewardTitle">Your Reward</h2><p id="rewardDetails"></p><div class="code" id="couponCode">SC-XXXX-XXXX-XXXX</div><div class="meta"><div><small>Project</small><strong id="resultService">Selected service</strong></div><div><small>Expires</small><strong id="resultExpiration">—</strong></div><div><small>Verification</small><strong id="resultVerification">—</strong></div></div><div class="buttons no-print" style="justify-content:center"><button class="btn primary" type="button" id="saveCouponButton">Save / Print Coupon</button><button class="btn light" type="button" id="copyCouponButton">Copy Code</button><a class="btn orange" href="<?= sc_e(SC_BOOKING_URL) ?>">Book Appointment</a><a class="btn secondary" href="tel:<?= sc_e(SC_PHONE_LINK) ?>">Call <?= sc_e(SC_PHONE_DISPLAY) ?></a></div></div><p style="font-size:.82rem;text-align:center">One opportunity per person/device per day. Reward must be presented before contract execution. No cash value. Cannot be combined with other offers. Minimum project value may apply.</p></section>
</div></main>
<section class="section"><div class="shell"><div class="section-title"><div class="eyebrow">Built for your project</div><h2>One company. Multiple construction solutions.</h2></div><div class="services"><article class="service"><strong>Remodeling</strong><br>Kitchens, bathrooms, additions, flooring, painting, drywall, and full renovations.</article><article class="service"><strong>Mechanical trades</strong><br>Electrical, plumbing, HVAC, fixtures, upgrades, and coordinated installations.</article><article class="service"><strong>Exterior work</strong><br>Roofing, windows, doors, stucco, siding, concrete, decks, and fencing.</article><article class="service"><strong>Planning and construction</strong><br>Engineering, drawings, permitting support, management, and new construction.</article></div></div></section>
<?php if ($footerFile !== null): include $footerFile; else: ?><footer class="fallback-footer"><div class="shell footer-grid"><div><strong><?= sc_e(SC_COMPANY_NAME) ?></strong><p>Construction, remodeling, engineering, and coordinated project services across Florida.</p><p><a href="tel:<?= sc_e(SC_PHONE_LINK) ?>"><?= sc_e(SC_PHONE_DISPLAY) ?></a> · <a href="mailto:<?= sc_e(SC_EMAIL) ?>"><?= sc_e(SC_EMAIL) ?></a></p></div><nav class="footer-links"><a href="<?= sc_e(SC_WEBSITE_URL) ?>">Home</a><a href="<?= sc_e(SC_WEBSITE_URL) ?>services.php">Services</a><a href="<?= sc_e(SC_WEBSITE_URL) ?>privacy-policy.php">Privacy</a><a href="<?= sc_e(SC_WEBSITE_URL) ?>terms.php">Terms</a><a href="<?= sc_e(SC_BOOKING_URL) ?>">Appointments</a></nav></div></footer><?php endif; ?>
<div class="toast" id="toast"></div>
<script>
(()=>{'use strict';const form=document.getElementById('rewardForm'),btn=document.getElementById('revealButton'),status=document.getElementById('formStatus'),lead=document.getElementById('leadPanel'),reveal=document.getElementById('revealPanel'),result=document.getElementById('couponResult'),bar=document.getElementById('progressBar'),msg=document.getElementById('machineMessage'),video=document.getElementById('promoVideo'),sound=document.getElementById('soundButton'),toast=document.getElementById('toast'),steps=[document.getElementById('step1'),document.getElementById('step2'),document.getElementById('step3')];const messages=['Reviewing available rewards...','Matching your selected service...','Checking today’s reward inventory...','Generating a secure coupon code...','Finalizing your Smart Choice reward...'];function active(n){steps.forEach(x=>x.classList.remove('active'));steps[n-1].classList.add('active')}function toastMsg(t){toast.textContent=t;toast.classList.add('show');setTimeout(()=>toast.classList.remove('show'),3000)}function dateFmt(v){return new Intl.DateTimeFormat('en-US',{year:'numeric',month:'short',day:'numeric'}).format(new Date(v))}function confetti(){const c=['#169179','#2ca8ff','#f96302','#f5b400','#111827'];for(let i=0;i<70;i++){const e=document.createElement('span');e.className='confetti';e.style.left=Math.random()*100+'vw';e.style.background=c[Math.floor(Math.random()*c.length)];e.style.setProperty('--drift',(Math.random()*240-120)+'px');e.style.animationDelay=Math.random()*.7+'s';document.body.appendChild(e);setTimeout(()=>e.remove(),3800)}}function showClaim(c){document.getElementById('resultKicker').textContent=c.reward_type==='retry'?'Return Tomorrow':'Congratulations';document.getElementById('rewardTitle').textContent=c.reward_title;document.getElementById('rewardDetails').textContent=c.reward_details;document.getElementById('couponCode').textContent=c.coupon_code;document.getElementById('resultService').textContent=c.service_name;document.getElementById('resultExpiration').textContent=dateFmt(c.expires_at);document.getElementById('resultVerification').textContent=c.verification;reveal.classList.remove('show');result.classList.add('show');active(3);result.scrollIntoView({behavior:'smooth'});if(c.reward_type!=='retry')confetti();try{localStorage.setItem('sc_last_coupon',JSON.stringify(c))}catch(e){}}async function send(fd){const r=await fetch(location.href,{method:'POST',body:fd,headers:{'X-Requested-With':'XMLHttpRequest'},credentials:'same-origin'});let d;try{d=await r.json()}catch(e){throw new Error('Unexpected server response.')}if(!r.ok||!d.success)throw new Error(d.message||'Unable to generate reward.');return d}async function run(p){lead.classList.add('hidden');reveal.classList.add('show');active(2);reveal.scrollIntoView({behavior:'smooth'});let s=0,m=0;const total=<?= (int) SC_REVEAL_SECONDS ?>,timer=setInterval(()=>{s++;bar.style.width=Math.min(100,Math.round(s/total*100))+'%';if(s%2===0){m=Math.min(messages.length-1,m+1);msg.textContent=messages[m]}},1000);try{const d=await p;await new Promise(r=>setTimeout(r,total*1000));clearInterval(timer);bar.style.width='100%';msg.textContent='Reward secured.';setTimeout(()=>showClaim(d.claim),500)}catch(e){clearInterval(timer);reveal.classList.remove('show');lead.classList.remove('hidden');active(1);btn.disabled=false;btn.textContent='Reveal My Reward';status.textContent=e.message;lead.scrollIntoView({behavior:'smooth'})}}form.addEventListener('submit',e=>{e.preventDefault();status.textContent='';if(!form.checkValidity()){form.reportValidity();return}btn.disabled=true;btn.textContent='Securing Reward...';run(send(new FormData(form)))});sound.addEventListener('click',async()=>{video.muted=!video.muted;try{await video.play()}catch(e){}sound.textContent=video.muted?'Tap for sound':'Sound on'});video.addEventListener('ended',()=>document.getElementById('rewardCenter').scrollIntoView({behavior:'smooth'}));document.getElementById('saveCouponButton').addEventListener('click',()=>window.print());document.getElementById('copyCouponButton').addEventListener('click',async()=>{const code=document.getElementById('couponCode').textContent.trim();try{await navigator.clipboard.writeText(code)}catch(e){const t=document.createElement('textarea');t.value=code;document.body.appendChild(t);t.select();document.execCommand('copy');t.remove()}toastMsg('Coupon code copied.')});try{const saved=JSON.parse(localStorage.getItem('sc_last_coupon')||'null');if(saved&&saved.coupon_code&&new Date(saved.expires_at)>new Date()){const b=document.createElement('button');b.type='button';b.className='btn light';b.textContent='View My Saved Coupon';b.onclick=()=>{lead.classList.add('hidden');showClaim(saved)};document.querySelector('#rewardForm .buttons').appendChild(b)}}catch(e){}})();
</script>
</body>
</html>