<?php
// FILE NAME: thank-you.php
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Thank You | Smart Choice Contractor LLC</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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

    display:flex;
    align-items:center;
    justify-content:center;

    padding:20px;
}

.thankyou-card{

    width:100%;
    max-width:750px;

    background:#fff;

    border-radius:35px;

    padding:70px 50px;

    text-align:center;

    box-shadow:
    0 25px 60px rgba(0,0,0,0.12),
    0 10px 25px rgba(37,99,235,0.12);

    position:relative;

    overflow:hidden;
}

.thankyou-card::before{

    content:'';

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:8px;

    background:linear-gradient(90deg,#2563eb,#0ea5e9,#1d4ed8);

}

.logo{

    width:280px;

    background:#fff;

    padding:18px 30px;

    border-radius:22px;

    box-shadow:0 10px 30px rgba(0,0,0,0.08);

    margin-bottom:35px;
}

.checkmark{

    width:120px;
    height:120px;

    margin:0 auto 30px;

    border-radius:50%;

    background:linear-gradient(135deg,#22c55e,#16a34a);

    display:flex;
    align-items:center;
    justify-content:center;

    color:#fff;

    font-size:60px;

    box-shadow:0 15px 35px rgba(34,197,94,0.35);

    animation:pop 0.8s ease;
}

@keyframes pop{

    0%{
        transform:scale(0.5);
        opacity:0;
    }

    100%{
        transform:scale(1);
        opacity:1;
    }

}

h1{

    font-size:52px;

    color:#16a34a;

    margin-bottom:20px;

    font-weight:800;
}

p{

    font-size:19px;

    color:#475569;

    line-height:1.9;

    margin-bottom:18px;
}

.home-btn{

    display:inline-block;

    margin-top:25px;

    padding:18px 35px;

    border-radius:16px;

    background:linear-gradient(135deg,#2563eb,#1d4ed8,#0ea5e9);

    color:#fff;

    text-decoration:none;

    font-weight:700;

    font-size:17px;

    transition:0.35s;
}

.home-btn:hover{

    transform:translateY(-4px);

    box-shadow:0 18px 35px rgba(37,99,235,0.35);
}

.footer-text{

    margin-top:35px;

    font-size:14px;

    color:#64748b;
}

@media(max-width:768px){

    .thankyou-card{

        padding:50px 25px;

    }

    h1{

        font-size:40px;

    }

    p{

        font-size:17px;

    }

    .logo{

        width:220px;

    }

}

</style>

</head>

<body>

<div class="thankyou-card">

    <img
        src="https://crm.justsmartchoice.com/media/public/smartchoice%20logo.png"
        class="logo"
    >

    <div class="checkmark">
        ✓
    </div>

    <h1>Thank You!</h1>

    <p>

        Your Credit Card Authorization Form has been submitted successfully.

    </p>

    <p>

        Our Smart Choice Contractor LLC team will review your information and contact you shortly.

    </p>

    <a href="smartchoice-credit-card-authorization.php" class="home-btn">

        Back to Form

    </a>

    <div class="footer-text">

        © <?php echo date('Y'); ?> Smart Choice Contractor LLC — Secure Payment Portal

    </div>

</div>

</body>
</html>