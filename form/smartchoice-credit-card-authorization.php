<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    function clean($data){
        return htmlspecialchars(trim($data));
    }

    $date = clean($_POST['date'] ?? '');
    $invoice = clean($_POST['invoice'] ?? '');
    $amount = clean($_POST['amount'] ?? '');
    $card_holder = clean($_POST['card_holder'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $company_name = clean($_POST['company_name'] ?? '');
    $name_on_card = clean($_POST['name_on_card'] ?? '');
    $card_number = clean($_POST['card_number'] ?? '');
    $exp_date = clean($_POST['exp_date'] ?? '');
    $cvv = clean($_POST['cvv'] ?? '');

    $address1 = clean($_POST['address1'] ?? '');
    $address2 = clean($_POST['address2'] ?? '');
    $city = clean($_POST['city'] ?? '');
    $state = clean($_POST['state'] ?? '');
    $zip = clean($_POST['zip'] ?? '');

    $billing_address1 = clean($_POST['billing_address1'] ?? '');
    $billing_address2 = clean($_POST['billing_address2'] ?? '');
    $billing_city = clean($_POST['billing_city'] ?? '');
    $billing_state = clean($_POST['billing_state'] ?? '');
    $billing_zip = clean($_POST['billing_zip'] ?? '');

    $signatureFile = "";
    $signatureHtml = "";

    if (!file_exists("signatures")) {
        mkdir("signatures", 0777, true);
    }

    if(isset($_POST['signature_type']) && $_POST['signature_type'] == "draw"){

        if (!empty($_POST['signature_data'])) {

            $signatureData = $_POST['signature_data'];

            $signatureImage =
            str_replace(
            'data:image/png;base64,',
            '',
            $signatureData
            );

            $signatureImage =
            str_replace(' ', '+', $signatureImage);

            $signatureFile =
            "signatures/sign_" . time() . ".png";

            file_put_contents(
                $signatureFile,
                base64_decode($signatureImage)
            );

        }

    }

    if(isset($_POST['signature_type']) && $_POST['signature_type'] == "upload"){

        if(
            isset($_FILES['signature_upload']) &&
            !empty($_FILES['signature_upload']['name'])
        ){

            $signatureFile =
            "signatures/" .
            time() .
            "_" .
            basename(
            $_FILES["signature_upload"]["name"]
            );

            move_uploaded_file(
                $_FILES["signature_upload"]["tmp_name"],
                $signatureFile
            );

        }

    }

    if(!empty($signatureFile) && file_exists($signatureFile)){

        $signatureUrl =
        "https://justsmartchoice.com/form/" . $signatureFile;

        $signatureHtml = "

        <tr>

            <td>
                <b>Customer Signature</b>
            </td>

            <td>

                <img
                src='$signatureUrl'
                style='
                max-width:300px;
                border:1px solid #dbeafe;
                border-radius:12px;
                padding:10px;
                background:#fff;
                '>

            </td>

        </tr>

        ";

    }

    $message = "

    <html>

    <body style='font-family:Arial;padding:20px;background:#f8fafc;'>

    <div style='
    max-width:900px;
    margin:auto;
    background:#ffffff;
    border-radius:20px;
    overflow:hidden;
    border:1px solid #e2e8f0;
    '>

        <div style='
        background:linear-gradient(135deg,#0f172a,#2563eb);
        padding:30px;
        text-align:center;
        '>

            <img
            src='https://crm.justsmartchoice.com/media/public/smartchoice%20logo.png'
            style='
            width:280px;
            background:#fff;
            padding:15px;
            border-radius:16px;
            '>

            <h2 style='
            color:#fff;
            margin-top:20px;
            '>

            Credit Card Authorization Submission

            </h2>

        </div>

        <div style='padding:30px;'>

        <table border='1'
        cellpadding='12'
        cellspacing='0'
        width='100%'
        style='
        border-collapse:collapse;
        border:1px solid #cbd5e1;
        '>

            <tr>
                <td><b>Date</b></td>
                <td>$date</td>
            </tr>

            <tr>
                <td><b>Invoice #</b></td>
                <td>$invoice</td>
            </tr>

            <tr>
                <td><b>Amount</b></td>
                <td>$amount</td>
            </tr>

            <tr>
                <td><b>Card Holder</b></td>
                <td>$card_holder</td>
            </tr>

            <tr>
                <td><b>Email</b></td>
                <td>$email</td>
            </tr>

            <tr>
                <td><b>Company Name</b></td>
                <td>$company_name</td>
            </tr>

            <tr>
                <td><b>Name On Card</b></td>
                <td>$name_on_card</td>
            </tr>

            <tr>
                <td><b>Card Number</b></td>
                <td>$card_number</td>
            </tr>

            <tr>
                <td><b>Expiration Date</b></td>
                <td>$exp_date</td>
            </tr>

            <tr>
                <td><b>CVV</b></td>
                <td>$cvv</td>
            </tr>

            <tr>
                <td><b>Address 1</b></td>
                <td>$address1</td>
            </tr>

            <tr>
                <td><b>Address 2</b></td>
                <td>$address2</td>
            </tr>

            <tr>
                <td><b>City</b></td>
                <td>$city</td>
            </tr>

            <tr>
                <td><b>State</b></td>
                <td>$state</td>
            </tr>

            <tr>
                <td><b>ZIP</b></td>
                <td>$zip</td>
            </tr>

            <tr>
                <td><b>Billing Address 1</b></td>
                <td>$billing_address1</td>
            </tr>

            <tr>
                <td><b>Billing Address 2</b></td>
                <td>$billing_address2</td>
            </tr>

            <tr>
                <td><b>Billing City</b></td>
                <td>$billing_city</td>
            </tr>

            <tr>
                <td><b>Billing State</b></td>
                <td>$billing_state</td>
            </tr>

            <tr>
                <td><b>Billing ZIP</b></td>
                <td>$billing_zip</td>
            </tr>

            $signatureHtml

        </table>

        </div>

    </div>

    </body>

    </html>

    ";

    $to =
    "haroldcabrerausa@gmail.com,admin@justsmartchoice.com";

    $subject =
    "New Credit Card Authorization Submission";

    $headers = "MIME-Version: 1.0" . "\r\n";

    $headers .=
    "Content-type:text/html;charset=UTF-8" . "\r\n";

    $headers .=
    "From: Smart Choice Contractor LLC <admin@justsmartchoice.com>" . "\r\n";

    $headers .=
    "Reply-To: $email" . "\r\n";

    if(mail($to, $subject, $message, $headers)){

        header(
        "Location:https://justsmartchoice.com/form/thank-you.php"
        );

        exit();

    }else{

        $error =
        "Unable to send email. Please contact administrator.";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Smart Choice Contractor LLC
</title>

<link href=
"https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:
    radial-gradient(circle at top left,#1e3a8a 0%,transparent 30%),
    radial-gradient(circle at bottom right,#2563eb 0%,transparent 30%),
    #eef2ff;
    min-height:100vh;
    padding:40px 15px;
    color:#1e293b;
}

.container{
    max-width:1150px;
    margin:auto;
    background:#ffffff;
    border-radius:30px;
    overflow:hidden;
    box-shadow:
    0 20px 60px rgba(15,23,42,0.18),
    0 8px 20px rgba(37,99,235,0.12);
}

.top-bar{
    background:
    linear-gradient(
    135deg,
    #0f172a 0%,
    #1e293b 40%,
    #2563eb 100%
    );
    padding:40px 50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:25px;
}

.logo img{
    width:340px;
    max-width:100%;
    background:#fff;
    padding:18px 28px;
    border-radius:20px;
    box-shadow:
    0 10px 30px rgba(0,0,0,0.18);
}

.company-details{
    color:#fff;
    text-align:right;
}

.company-details h2{
    font-size:30px;
    margin-bottom:10px;
}

.form-section{
    padding:50px;
}

.heading{
    text-align:center;
    margin-bottom:45px;
}

.heading h1{
    font-size:42px;
    margin-bottom:12px;
}

.form-grid{
    display:grid;
    grid-template-columns:
    repeat(auto-fit,minmax(280px,1fr));
    gap:24px;
}

.form-group{
    margin-bottom:22px;
}

label{
    display:block;
    margin-bottom:10px;
    font-weight:600;
}

input{
    width:100%;
    padding:16px 18px;
    border:1.5px solid #dbe4f0;
    border-radius:16px;
    font-size:15px;
    transition:0.3s;
}

input:focus{
    border-color:#2563eb;
    box-shadow:
    0 0 0 5px rgba(37,99,235,0.12);
    outline:none;
}

.section-title{
    margin:45px 0 25px;
    font-size:24px;
    font-weight:700;
    border-left:6px solid #2563eb;
    padding-left:18px;
}

.same-address-box{
    margin-bottom:25px;
    background:#eff6ff;
    padding:18px;
    border-radius:16px;
    border:1px solid #bfdbfe;
}

.signature-wrapper{
    background:#f8fbff;
    border:2px dashed #bfdbfe;
    border-radius:24px;
    padding:25px;
}

.radio-group{
    display:flex;
    gap:25px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

canvas{
    width:100%;
    max-width:500px;
    height:150px !important;
    border:2px solid #dbeafe;
    border-radius:18px;
    background:#fff;
    touch-action:none;
}

.submit-btn{
    width:100%;
    border:none;
    padding:20px;
    border-radius:18px;
    background:
    linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8,
    #0ea5e9
    );
    color:#fff;
    font-size:19px;
    font-weight:700;
    margin-top:40px;
    cursor:pointer;
}

.submit-btn:hover{
    transform:translateY(-3px);
}

.error-box{
    background:#fee2e2;
    color:#991b1b;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

@media(max-width:768px){

    .top-bar{
        text-align:center;
        justify-content:center;
    }

    .company-details{
        text-align:center;
    }

    .heading h1{
        font-size:32px;
    }

    .form-section{
        padding:25px;
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="top-bar">

        <div class="logo">

            <img src=
            "https://crm.justsmartchoice.com/media/public/smartchoice%20logo.png">

        </div>

        <div class="company-details">

            <h2>
            SMART CHOICE CONTRACTOR LLC
            </h2>

            <p>
            Secure Credit Card Authorization Portal
            </p>

        </div>

    </div>

    <div class="form-section">

        <div class="heading">

            <h1>
            Credit Card Authorization Form
            </h1>

        </div>

        <?php if($error): ?>

        <div class="error-box">

            <?php echo $error; ?>

        </div>

        <?php endif; ?>

        <form method="POST"
        enctype="multipart/form-data">

            <div class="form-grid">

                <div class="form-group">

                    <label>Date</label>

                    <input
                    type="text"
                    name="date"
                    placeholder="MM/DD/YYYY"
                    maxlength="10"
                    required
                    oninput="formatUSADate(this)"
                    >

                </div>

                <div class="form-group">

                    <label>Invoice #</label>

                    <input
                    type="text"
                    name="invoice"
                    >

                </div>

                <div class="form-group">

                    <label>Amount (USD)</label>

                    <input
                    type="text"
                    name="amount"
                    placeholder="$10,000.00"
                    required
                    oninput="formatCurrency(this)"
                    >

                </div>

                <div class="form-group">

                    <label>Email Address</label>

                    <input
                    type="email"
                    name="email"
                    required
                    >

                </div>

            </div>

            <div class="section-title">
            Card Holder Information
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label>
                    Card Holder Name
                    </label>

                    <input
                    type="text"
                    name="card_holder"
                    required
                    >

                </div>

                <div class="form-group">

                    <label>
                    Company Name
                    </label>

                    <input
                    type="text"
                    name="company_name"
                    >

                </div>

                <div class="form-group">

                    <label>
                    Name On Card
                    </label>

                    <input
                    type="text"
                    name="name_on_card"
                    required
                    >

                </div>

                <div class="form-group">

                    <label>
                    Card Number
                    </label>

                    <input
                    type="text"
                    name="card_number"
                    maxlength="19"
                    inputmode="numeric"
                    placeholder="1234 5678 9012 3456"
                    required
                    oninput="formatCardNumber(this)"
                    >

                </div>

                <div class="form-group">

                    <label>
                    Expiration Date
                    </label>

                    <input
                    type="month"
                    name="exp_date"
                    required
                    >

                </div>

                <div class="form-group">

                    <label>
                    CVV
                    </label>

                    <input
                    type="password"
                    name="cvv"
                    maxlength="4"
                    required
                    oninput=
                    "this.value=this.value.replace(/[^0-9]/g,'')"
                    >

                </div>

            </div>

            <div class="section-title">
            Primary Address
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label>Address 1</label>

                    <input
                    type="text"
                    name="address1"
                    required
                    >

                </div>

                <div class="form-group">

                    <label>Address 2</label>

                    <input
                    type="text"
                    name="address2"
                    >

                </div>

                <div class="form-group">

                    <label>City</label>

                    <input
                    type="text"
                    name="city"
                    required
                    >

                </div>

                <div class="form-group">

                    <label>State</label>

                    <input
                    type="text"
                    name="state"
                    required
                    >

                </div>

                <div class="form-group">

                    <label>ZIP Code</label>

                    <input
                    type="text"
                    name="zip"
                    maxlength="10"
                    required
                    oninput=
                    "this.value=this.value.replace(/[^0-9]/g,'')"
                    >

                </div>

            </div>

            <div class="section-title">
            Billing Address
            </div>

            <div class="same-address-box">

                <label style="
                display:flex;
                align-items:center;
                gap:12px;
                cursor:pointer;
                ">

                    <input
                    type="checkbox"
                    id="sameAddress"
                    onchange="copyPrimaryAddress()"
                    style="
                    width:20px;
                    height:20px;
                    accent-color:#2563eb;
                    "
                    >

                    Billing Address Same as Primary Address

                </label>

            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label>
                    Billing Address 1
                    </label>

                    <input
                    type="text"
                    name="billing_address1"
                    >

                </div>

                <div class="form-group">

                    <label>
                    Billing Address 2
                    </label>

                    <input
                    type="text"
                    name="billing_address2"
                    >

                </div>

                <div class="form-group">

                    <label>
                    Billing City
                    </label>

                    <input
                    type="text"
                    name="billing_city"
                    >

                </div>

                <div class="form-group">

                    <label>
                    Billing State
                    </label>

                    <input
                    type="text"
                    name="billing_state"
                    >

                </div>

                <div class="form-group">

                    <label>
                    Billing ZIP
                    </label>

                    <input
                    type="text"
                    name="billing_zip"
                    maxlength="10"
                    oninput=
                    "this.value=this.value.replace(/[^0-9]/g,'')"
                    >

                </div>

            </div>

            <div class="section-title">
            Digital Signature
            </div>

            <div class="signature-wrapper">

                <div class="radio-group">

                    <label style="
                    display:flex;
                    align-items:center;
                    gap:8px;
                    ">

                        <input
                        type="radio"
                        name="signature_type"
                        value="draw"
                        checked
                        onclick="toggleSignatureType()"
                        >

                        Draw Signature

                    </label>

                    <label style="
                    display:flex;
                    align-items:center;
                    gap:8px;
                    ">

                        <input
                        type="radio"
                        name="signature_type"
                        value="upload"
                        onclick="toggleSignatureType()"
                        >

                        Upload Signature

                    </label>

                </div>

                <div id="drawArea">

                    <canvas
                    id="signature-pad"
                    width="500"
                    height="150">
                    </canvas>

                    <div style="
                    margin-top:15px;
                    display:flex;
                    gap:12px;
                    flex-wrap:wrap;
                    ">

                        <button
                        type="button"
                        id="clearSignature"
                        style="
                        background:#ef4444;
                        color:#fff;
                        border:none;
                        padding:12px 22px;
                        border-radius:12px;
                        cursor:pointer;
                        font-weight:600;
                        font-size:14px;
                        transition:0.3s;
                        ">

                        Clear Signature

                        </button>

                    </div>

                    <input
                    type="hidden"
                    name="signature_data"
                    id="signature_data"
                    >

                </div>

                <div id="uploadArea"
                style="display:none;margin-top:20px;">

                    <input
                    type="file"
                    name="signature_upload"
                    accept="image/*"
                    >

                </div>

            </div>

            <button
            type="submit"
            class="submit-btn">

                Submit Authorization Form

            </button>

        </form>

    </div>

</div>

<script>

function formatUSADate(input){

    let value = input.value.replace(/\D/g,'');

    if(value.length > 2){

        value =
        value.substring(0,2) +
        '/' +
        value.substring(2);

    }

    if(value.length > 5){

        value =
        value.substring(0,5) +
        '/' +
        value.substring(5,9);

    }

    input.value = value;

}

function formatCurrency(input){

    let value =
    input.value.replace(/[^0-9.]/g,'');

    let parts = value.split('.');

    if(parts.length > 2){

        value =
        parts[0] +
        '.' +
        parts.slice(1).join('');

    }

    let numberParts = value.split('.');

    let integerPart = numberParts[0];
    let decimalPart = numberParts[1];

    if(integerPart){

        integerPart =
        parseInt(integerPart || 0,10)
        .toLocaleString('en-US');

    }

    if(decimalPart !== undefined){

        decimalPart =
        decimalPart.substring(0,2);

        input.value =
        '$' +
        integerPart +
        '.' +
        decimalPart;

    }else{

        input.value =
        '$' +
        integerPart;

    }

}

function formatCardNumber(input){

    let value =
    input.value.replace(/\D/g,'');

    value = value.substring(0,16);

    let formatted = value.match(/.{1,4}/g);

    if(formatted){

        input.value = formatted.join(' ');

    }else{

        input.value = value;

    }

}

function copyPrimaryAddress(){

    const checked =
    document.getElementById('sameAddress').checked;

    if(checked){

        document.querySelector(
        '[name="billing_address1"]'
        ).value =
        document.querySelector(
        '[name="address1"]'
        ).value;

        document.querySelector(
        '[name="billing_address2"]'
        ).value =
        document.querySelector(
        '[name="address2"]'
        ).value;

        document.querySelector(
        '[name="billing_city"]'
        ).value =
        document.querySelector(
        '[name="city"]'
        ).value;

        document.querySelector(
        '[name="billing_state"]'
        ).value =
        document.querySelector(
        '[name="state"]'
        ).value;

        document.querySelector(
        '[name="billing_zip"]'
        ).value =
        document.querySelector(
        '[name="zip"]'
        ).value;

    }else{

        document.querySelector(
        '[name="billing_address1"]'
        ).value = '';

        document.querySelector(
        '[name="billing_address2"]'
        ).value = '';

        document.querySelector(
        '[name="billing_city"]'
        ).value = '';

        document.querySelector(
        '[name="billing_state"]'
        ).value = '';

        document.querySelector(
        '[name="billing_zip"]'
        ).value = '';

    }

}

function toggleSignatureType(){

    const selected =
    document.querySelector(
    'input[name="signature_type"]:checked'
    ).value;

    if(selected === "draw"){

        document.getElementById(
        "drawArea"
        ).style.display = "block";

        document.getElementById(
        "uploadArea"
        ).style.display = "none";

    }else{

        document.getElementById(
        "drawArea"
        ).style.display = "none";

        document.getElementById(
        "uploadArea"
        ).style.display = "block";

    }

}

const canvas =
document.getElementById('signature-pad');

const ctx =
canvas.getContext('2d');

let drawing = false;

function resizeCanvas(){

    const ratio =
    Math.max(window.devicePixelRatio || 1, 1);

    canvas.width =
    canvas.offsetWidth * ratio;

    canvas.height =
    150 * ratio;

    canvas.getContext("2d").scale(ratio, ratio);

}

resizeCanvas();

window.addEventListener('resize', resizeCanvas);

ctx.strokeStyle = "#111827";
ctx.lineWidth = 2;
ctx.lineCap = "round";

function getPosition(event){

    const rect =
    canvas.getBoundingClientRect();

    let x, y;

    if(event.touches){

        x =
        event.touches[0].clientX -
        rect.left;

        y =
        event.touches[0].clientY -
        rect.top;

    }else{

        x =
        event.clientX -
        rect.left;

        y =
        event.clientY -
        rect.top;

    }

    return {x,y};

}

function startDrawing(event){

    drawing = true;

    const pos = getPosition(event);

    ctx.beginPath();

    ctx.moveTo(pos.x, pos.y);

}

function draw(event){

    if(!drawing) return;

    event.preventDefault();

    const pos = getPosition(event);

    ctx.lineTo(pos.x, pos.y);

    ctx.stroke();

}

function stopDrawing(){

    drawing = false;

    document.getElementById(
    'signature_data'
    ).value =
    canvas.toDataURL();

}

canvas.addEventListener(
'mousedown',
startDrawing
);

canvas.addEventListener(
'mousemove',
draw
);

canvas.addEventListener(
'mouseup',
stopDrawing
);

canvas.addEventListener(
'mouseleave',
stopDrawing
);

canvas.addEventListener(
'touchstart',
startDrawing
);

canvas.addEventListener(
'touchmove',
draw
);

canvas.addEventListener(
'touchend',
stopDrawing
);

document.getElementById('clearSignature')
.addEventListener('click', function(){

    ctx.clearRect(
    0,
    0,
    canvas.width,
    canvas.height
    );

    document.getElementById(
    'signature_data'
    ).value = '';

});

</script>

</body>
</html>