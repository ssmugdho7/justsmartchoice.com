<?php
require_once __DIR__ . '/includes/cms-engine.php';

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

/* TELEGRAM STEPS FROM CMS */
$rawTelegram = cms_field('new-project-process', 'telegram_steps', []);
$telegramSteps = [];
if (!empty($rawTelegram) && is_array($rawTelegram)) {
    foreach ($rawTelegram as $t) {
        $telegramSteps[] = [$t['title'] ?? '', $t['icon'] ?? 'fa-telegram'];
    }
}
if (empty($telegramSteps)) {
    $telegramSteps = [
        ["Create Telegram Group (123 MAIN ST. TAMPA 34345 - SHIVAM MARTINEZ)", "fa-telegram"],
        ["Push Google Map Location in Group", "fa-map-location-dot"],
        ["Scope of Work", "fa-file-lines"]
    ];
}

/* CRM STEPS FROM CMS */
$rawCrm = cms_field('new-project-process', 'crm_steps', []);
$crmSteps = [];
if (!empty($rawCrm) && is_array($rawCrm)) {
    foreach ($rawCrm as $c) {
        $crmSteps[] = [$c['title'] ?? '', $c['icon'] ?? 'fa-check'];
    }
}
if (empty($crmSteps)) {
    $crmSteps = [
        ["Create Lead", "fa-user-plus"],
        ["Create Customer", "fa-user"],
        ["Create Contact", "fa-address-book"],
        ["Create Project", "fa-diagram-project"],
        ["Create Invoice", "fa-file-invoice"],
        ["Create Contract", "fa-file-signature"],
        ["Create NOC in Contract (Customer Sign)", "fa-pen-to-square"],
        ["Add Property Appraiser", "fa-building"],
        ["Create Home Depot Quote", "fa-store"],
        ["Create Official NOC", "fa-file-circle-check"],
        ["Send to Record (After Boss Verification)", "fa-paper-plane"],
        ["After Recording - Send in Group & Project Files", "fa-folder-open"]
    ];
}

$allSteps = array_merge($telegramSteps, $crmSteps);
$totalSteps = count($allSteps);

if (!isset($_SESSION['completed']) || count($_SESSION['completed']) !== $totalSteps) {
    $_SESSION['completed'] = array_fill(0, $totalSteps, false);
}

/* RESET */
if (isset($_POST['reset'])) {
    $_SESSION['completed'] = array_fill(0, $totalSteps, false);
}

/* SAVE WITH SERVER VALIDATION */
if (isset($_POST['save'])) {
    $new = array_fill(0, $totalSteps, false);
    if (isset($_POST['steps'])) {
        foreach ($_POST['steps'] as $i => $val) {
            if ($i == 0 || $new[$i - 1] === true) {
                $new[$i] = true;
            }
        }
    }
    $_SESSION['completed'] = $new;
}

$completedCount = count(array_filter($_SESSION['completed']));
$progress = $totalSteps > 0 ? ($completedCount / $totalSteps) * 100 : 0;

/* SEND EMAIL */
$emailStatus = "";
if (isset($_POST['send_report']) && $progress >= 100) {

    $projectName = htmlspecialchars($_POST['project_name'] ?? '');
    $ownerName = htmlspecialchars($_POST['owner_name'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $map = htmlspecialchars($_POST['map'] ?? '');

    $stepList = "";
    foreach ($allSteps as $step) {
        $stepList .= "- " . $step[0] . "\n";
    }

    $to = cms_field('new-project-process', 'header.report_recipient_emails', 'shivamskb03@gmail.com, haroldcabrerausa@gmail.com, shivam@justsmartchoice.com');
    $subject = "Project Completed - $projectName";

    $message = "PROJECT COMPLETION REPORT\n\n";
    $message .= "Project Name: $projectName\n";
    $message .= "Owner Name: $ownerName\n";
    $message .= "Address: $address\n";
    $message .= "Google Map: $map\n\n";
    $message .= "Completed Steps:\n$stepList";

    $headers = "From: noreply@justsmartchoice.com\r\n";
    $headers .= "Reply-To: shivam@justsmartchoice.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (@mail($to, $subject, $message, $headers)) {
        $emailStatus = "Report Sent Successfully!";
    } else {
        $emailStatus = "Report logged locally (mail delivery requires configured server SMTP).";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars(cms_field('new-project-process', 'seo.title', 'Project Workflow Dashboard | Just Smart Choice Construction USA')); ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php include __DIR__ . '/includes/cookie-consent-head.php'; ?>
<?php echo cms_head_scripts(); ?>

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    min-height: 100vh;
}
.container{
    width:95%;
    max-width:1100px;
    margin:40px auto;
    background:#fff;
    padding:35px 40px;
    border-radius:20px;
    box-shadow:0 30px 60px rgba(0,0,0,0.3);
    position:relative;
}
.logo{text-align:center;}
.logo img{height:75px;}
h1{text-align:center;margin-bottom:10px;color:#2c3e50;font-size:28px;}
.subtitle-text{text-align:center;color:#64748b;font-size:15px;max-width:750px;margin:0 auto 25px auto;}

.section-heading{
    text-align:center;
    font-size:17px;
    font-weight:bold;
    margin:25px 0 15px 0;
    padding:8px;
    background:#ecf0f1;
    border-radius:8px;
    letter-spacing:0.5px;
}

input[type=text]{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ccc;
    margin-bottom:12px;
    box-sizing:border-box;
}

.progress-bar{
    width:100%;
    height:28px;
    background:#e2e8f0;
    border-radius:50px;
    overflow:hidden;
    margin:20px 0;
}
.progress{
    height:100%;
    width:<?= round($progress) ?>%;
    background: <?= $progress >= 100 ? '#10b981' : '#2563eb' ?>;
    transition:0.4s;
    text-align:center;
    color:#fff;
    font-weight:bold;
    line-height:28px;
    font-size:14px;
}

.timeline{
    position:relative;
    padding-left:60px;
}
.timeline-line{
    position:absolute;
    left:24px;
    top:0;
    width:4px;
    height:100%;
    background:#cbd5e1;
}
.timeline-fill{
    position:absolute;
    left:24px;
    top:0;
    width:4px;
    height:<?= round($progress) ?>%;
    background:#10b981;
    transition:0.4s;
}

.step{
    position:relative;
    margin-bottom:18px;
    padding:14px 18px;
    border-radius:10px;
    border:1.5px solid #e2e8f0;
    background:#f8fafc;
    display:flex;
    align-items:center;
    gap:12px;
    font-size:14.5px;
    color:#1e293b;
}
.step.completed{
    border-color:#10b981;
    background:#f0fdf4;
    color:#065f46;
}
.step-circle{
    position:absolute;
    left:-50px;
    top:12px;
    width:26px;
    height:26px;
    border-radius:50%;
    background:#94a3b8;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:12px;
}
.step.completed .step-circle{
    background:#10b981;
}

.buttons{
    display:flex;
    gap:12px;
    justify-content:center;
    flex-wrap:wrap;
    margin-top:25px;
}
.buttons button{
    padding:12px 24px;
    border-radius:8px;
    border:none;
    font-weight:700;
    cursor:pointer;
    font-size:14px;
}
.save{background:#2563eb;color:#fff;}
.reset{background:#64748b;color:#fff;}
.send{background:#10b981;color:#fff;}
.send:disabled{background:#cbd5e1;cursor:not-allowed;}
.pricing-link-btn{
    display:inline-block;
    padding:10px 20px;
    background:#f1f5f9;
    border:1px solid #cbd5e1;
    border-radius:6px;
    color:#1e293b;
    font-weight:700;
    text-decoration:none;
    font-size:13px;
}
.pricing-link-btn:hover{background:#e2e8f0;}
</style>
</head>
<body>

<div class="container">
    <div class="logo">
        <img src="images/logo-638x310.png" alt="Smart Choice Logo">
    </div>

    <h1 <?php echo cms_bind('new-project-process', 'header.title'); ?>>
        <?php echo htmlspecialchars(cms_field('new-project-process', 'header.title', 'PROJECT WORKFLOW DASHBOARD')); ?>
    </h1>
    <p class="subtitle-text" <?php echo cms_bind('new-project-process', 'header.subtitle'); ?>>
        <?php echo htmlspecialchars(cms_field('new-project-process', 'header.subtitle', 'Standard operating procedure for new construction, remodeling, and trade projects from group creation through official recording.')); ?>
    </p>

    <div style="text-align:center; margin-bottom: 20px;">
        <a href="/pricing.php" class="pricing-link-btn">
            <i class="fa fa-calculator" style="margin-right:6px;"></i> View Construction Pricing &amp; Estimates Guide
        </a>
    </div>

    <form method="POST">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <input type="text" name="project_name" placeholder="Project Name (e.g. 123 Main St Tampa Remodel)" required>
            <input type="text" name="owner_name" placeholder="Property Owner Name" required>
        </div>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <input type="text" name="address" placeholder="Jobsite Address, City, Zip" required>
            <input type="text" name="map" placeholder="Google Maps Location URL" required>
        </div>

        <div class="progress-bar">
            <div class="progress"><?= round($progress) ?>% Completed (<?= $completedCount ?>/<?= $totalSteps ?> Steps)</div>
        </div>

        <div class="timeline">
            <div class="timeline-line"></div>
            <div class="timeline-fill"></div>

            <div class="section-heading">TELEGRAM INITIATION TASKS</div>
            <?php foreach($telegramSteps as $i => $step): ?>
            <div class="step <?= (!empty($_SESSION['completed'][$i])) ? 'completed' : '' ?>">
                <div class="step-circle"><i class="<?= htmlspecialchars($step[1]) ?>"></i></div>
                <input type="checkbox" name="steps[<?= $i ?>]" value="1" <?= (!empty($_SESSION['completed'][$i])) ? 'checked' : '' ?>>
                <span <?php echo cms_bind('new-project-process', "telegram_steps.{$i}.title"); ?>><?= htmlspecialchars($step[0]) ?></span>
            </div>
            <?php endforeach; ?>

            <div class="section-heading">CRM &amp; RECORDING TASKS</div>
            <?php foreach($crmSteps as $i => $step):
                $index = $i + count($telegramSteps); ?>
            <div class="step <?= (!empty($_SESSION['completed'][$index])) ? 'completed' : '' ?>">
                <div class="step-circle"><i class="<?= htmlspecialchars($step[1]) ?>"></i></div>
                <input type="checkbox" name="steps[<?= $index ?>]" value="1" <?= (!empty($_SESSION['completed'][$index])) ? 'checked' : '' ?>>
                <span <?php echo cms_bind('new-project-process', "crm_steps.{$i}.title"); ?>><?= htmlspecialchars($step[0]) ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="buttons">
            <button type="submit" name="save" class="save"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Save Progress</button>
            <button type="submit" name="reset" class="reset"><i class="fa-solid fa-rotate-left" style="margin-right:6px;"></i> Reset</button>
            <button type="submit" name="send_report" class="send" <?= $progress < 100 ? 'disabled' : '' ?>><i class="fa-solid fa-paper-plane" style="margin-right:6px;"></i> Submit Report</button>
        </div>

        <?php if($emailStatus != ""): ?>
            <div style="margin-top:20px;text-align:center;font-weight:bold;color:#10b981;"><?= htmlspecialchars($emailStatus) ?></div>
        <?php endif; ?>
    </form>
</div>

</body>
</html>