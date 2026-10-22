<?php
session_start();

/* TELEGRAM STEPS */
$telegramSteps = [
    ["Create Telegram Group (123 MAIN ST. TAMPA 34345 - SHIVAM MARTINEZ)", "fa-telegram"],
    ["Push Google Map Location in Group", "fa-map-location-dot"],
    ["Scope of Work", "fa-file-lines"]
];

/* CRM STEPS */
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

$allSteps = array_merge($telegramSteps, $crmSteps);
$totalSteps = count($allSteps);

if (!isset($_SESSION['completed'])) {
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
$progress = ($completedCount / $totalSteps) * 100;

/* SEND EMAIL */
$emailStatus = "";
if (isset($_POST['send_report']) && $progress == 100) {

    $projectName = htmlspecialchars($_POST['project_name']);
    $ownerName = htmlspecialchars($_POST['owner_name']);
    $address = htmlspecialchars($_POST['address']);
    $map = htmlspecialchars($_POST['map']);

    $stepList = "";
    foreach ($allSteps as $step) {
        $stepList .= "- " . $step[0] . "\n";
    }

    $to = "shivamskb03@gmail.com, haroldcabrerausa@gmail.com, shivam@justsmartchoice.com";
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

    if (mail($to, $subject, $message, $headers)) {
        $emailStatus = "Report Sent Successfully!";
    } else {
        $emailStatus = "Email failed. SMTP may not be enabled on server.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Enterprise Workflow Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
}
.container{
    width:95%;
    max-width:1200px;
    margin:40px auto;
    background:#fff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 30px 60px rgba(0,0,0,0.4);
    position:relative;
}
.logo{text-align:center;}
.logo img{height:85px;}
h1{text-align:center;margin-bottom:20px;color:#2c3e50;}

.section-heading{
    text-align:center;
    font-size:20px;
    font-weight:bold;
    margin:30px 0;
    padding:8px;
    background:#ecf0f1;
    border-radius:8px;
}

input[type=text]{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    margin-bottom:15px;
}

.progress-bar{
    width:100%;
    height:30px;
    background:#eee;
    border-radius:50px;
    overflow:hidden;
    margin:25px 0;
}
.progress{
    height:100%;
    width:<?= $progress ?>%;
    background:red;
    transition:0.4s;
    text-align:center;
    color:#fff;
    font-weight:bold;
    line-height:30px;
}

.timeline{
    position:relative;
    padding-left:70px;
}
.timeline-line{
    position:absolute;
    left:30px;
    top:0;
    width:6px;
    height:100%;
    background:#ccc;
}
.timeline-fill{
    position:absolute;
    left:30px;
    top:0;
    width:6px;
    height:<?= $progress ?>%;
    background:#27ae60;
    transition:0.4s;
}

.step{
    position:relative;
    margin-bottom:25px;
    padding:15px 20px;
    border-radius:12px;
    border:2px solid #e0e0e0;
    background:#fafafa;
}
.step.completed{
    border-color:#27ae60;
    background:#f2fff5;
}
.step-circle{
    position:absolute;
    left:-55px;
    top:15px;
    width:28px;
    height:28px;
    border-radius:50%;
    background:#ccc;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
}
.step.completed .step-circle{
    background:#27ae60;
}

.buttons{text-align:center;margin-top:30px;}
button{
    padding:12px 28px;
    border:none;
    border-radius:50px;
    margin:10px;
    font-weight:bold;
    cursor:pointer;
}
.save{background:#2980b9;color:white;}
.reset{background:#c0392b;color:white;}
.send{background:#27ae60;color:white;}
button:disabled{background:#999;}

.summary-box{
    position:fixed;
    bottom:20px;
    right:20px;
    width:350px;
    background:#fff;
    border:2px solid #27ae60;
    border-radius:12px;
    padding:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    display:none;
}
.summary-box textarea{
    width:100%;
    height:160px;
    border:none;
    resize:none;
}
</style>

<script>
function updateUI(){
    const steps=document.querySelectorAll(".step");
    const checkboxes=document.querySelectorAll(".step input");
    const progressBar=document.querySelector(".progress");
    const fill=document.querySelector(".timeline-fill");
    const summary=document.getElementById("summaryBox");
    const summaryText=document.getElementById("summaryText");

    let checked=0;
    let completedSteps=[];

    checkboxes.forEach((box,index)=>{
        if(box.checked){
            steps[index].classList.add("completed");
            checked++;
            completedSteps.push(steps[index].innerText.trim());
        } else {
            steps[index].classList.remove("completed");
        }
    });

    let percent=(checked/checkboxes.length)*100;

    progressBar.style.width=percent+"%";
    progressBar.innerHTML=Math.round(percent)+"%";

    if(percent<40){progressBar.style.background="red";}
    else if(percent<80){progressBar.style.background="orange";}
    else{progressBar.style.background="green";}

    fill.style.height=percent+"%";
    document.getElementById("sendBtn").disabled=(percent!==100);

    checkboxes.forEach((box,index)=>{
        if(index===0){
            box.disabled=false;
        } else {
            box.disabled=!checkboxes[index-1].checked;
        }
    });

    if(percent===100){
        const project=document.getElementById("project_name").value;
        const owner=document.getElementById("owner_name").value;
        const address=document.getElementById("address").value;

        summaryText.value=
        "PROJECT COMPLETED\n\n"+
        "Project Name: "+project+"\n"+
        "Owner Name: "+owner+"\n"+
        "Address: "+address+"\n\n"+
        "Completed Steps:\n"+completedSteps.join("\n");

        summary.style.display="block";
    } else {
        summary.style.display="none";
    }
}

window.onload=function(){
    const checkboxes=document.querySelectorAll(".step input");
    checkboxes.forEach(box=>box.addEventListener("change",updateUI));
    updateUI();
};
</script>

</head>
<body>

<div class="container">

<div class="logo">
<img src="https://crm.justsmartchoice.com/media/public/smartchoice%20logo.png">
</div>

<h1>PROJECT WORKFLOW DASHBOARD</h1>

<form method="post">

<label>Project Name</label>
<input type="text" name="project_name" id="project_name" required>

<label>Owner Name</label>
<input type="text" name="owner_name" id="owner_name" required>

<label>Project Address</label>
<input type="text" name="address" id="address" required>

<label>Google Map Link</label>
<input type="text" name="map" required>

<div class="progress-bar">
<div class="progress"><?= round($progress) ?>%</div>
</div>

<div class="timeline">
<div class="timeline-line"></div>
<div class="timeline-fill"></div>

<div class="section-heading">TELEGRAM TASKS</div>
<?php foreach($telegramSteps as $i=>$step): ?>
<div class="step <?= $_SESSION['completed'][$i]?'completed':'' ?>">
<div class="step-circle"><i class="fa-brands <?= $step[1] ?>"></i></div>
<input type="checkbox" name="steps[<?= $i ?>]" value="1" <?= $_SESSION['completed'][$i]?'checked':'' ?>>
<?= $step[0] ?>
</div>
<?php endforeach; ?>

<div class="section-heading">CRM TASKS</div>
<?php foreach($crmSteps as $i=>$step):
$index=$i+count($telegramSteps); ?>
<div class="step <?= $_SESSION['completed'][$index]?'completed':'' ?>">
<div class="step-circle"><i class="fa-solid <?= $step[1] ?>"></i></div>
<input type="checkbox" name="steps[<?= $index ?>]" value="1" <?= $_SESSION['completed'][$index]?'checked':'' ?>>
<?= $step[0] ?>
</div>
<?php endforeach; ?>

</div>

<div class="buttons">
<button type="submit" name="save" class="save">Save Process</button>
<button type="submit" name="reset" class="reset">Reset</button>
<button type="submit" name="send_report" id="sendBtn" class="send" <?= $progress<100?'disabled':'' ?>>Send Report</button>
</div>

<?php if($emailStatus!="") echo "<div style='margin-top:20px;text-align:center;font-weight:bold;'>$emailStatus</div>"; ?>

</form>
</div>

<div class="summary-box" id="summaryBox">
<b>Completion Summary</b>
<textarea id="summaryText" readonly></textarea>
</div>

</body>
</html>