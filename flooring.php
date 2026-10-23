<?php
$company="Just Smart Choice Flooring";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CLX99EJXW2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CLX99EJXW2');
</script>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Flooring Services Near Me | Vinyl | Tile | Hardwood | Just Smart Choice</title>

<meta name="description" content="Professional flooring services by Just Smart Choice. We install vinyl, tile, laminate, and hardwood flooring with high-quality workmanship and affordable pricing.">

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* BASE */
body{
margin:0;
font-family:'Poppins', Arial;
background:#f6f8f7;
color:#222;
line-height:1.6;
}

.container{
max-width:1150px;
margin:auto;
padding:0 20px;
}

/* SECTION TITLE */
.section-title{
text-align:center;
font-size:30px;
font-weight:700;
margin:70px 0 25px;
}

.section-title span{
color:#1fa463;
}

/* HERO */
.hero{
display:grid;
grid-template-columns:1fr 1fr;
gap:40px;
align-items:center;
padding:70px 0;
}

.hero img{
width:100%;
border-radius:12px;
box-shadow:0 10px 25px rgba(0,0,0,0.12);
}

.hero-text h1{
font-size:34px;
margin-bottom:10px;
}

.hero-text p{
color:#555;
font-size:16px;
}

/* SERVICES */
.service-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:25px;
}

.service-card{
background:#fff;
padding:25px;
border-radius:12px;
text-align:center;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
position:relative;
overflow:hidden;
}

.service-card i{
font-size:32px;
color:#1fa463;
margin-bottom:10px;
}

.service-card h3{
font-size:20px;
font-weight:600;
}

.service-hover{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:#1fa463;
color:#fff;
display:flex;
align-items:center;
justify-content:center;
text-align:center;
padding:20px;
opacity:0;
transition:.3s;
font-size:15px;
}

.service-card:hover .service-hover{
opacity:1;
}

/* VIDEOS */
.video-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
gap:20px;
}

.video-grid iframe{
width:100%;
height:220px;
border-radius:10px;
}

/* MATERIAL */
.material-grid{
text-align:center;
}

.material-grid a{
display:inline-block;
margin:8px;
padding:12px 20px;
background:#fff;
border-radius:6px;
text-decoration:none;
color:#333;
box-shadow:0 3px 8px rgba(0,0,0,0.05);
}

.material-grid a:hover{
background:#1fa463;
color:#fff;
}

/* FAQ FIXED */
.faq-item{
background:#fff;
border-radius:6px;
box-shadow:0 2px 6px rgba(0,0,0,0.05);
margin-bottom:10px;
overflow:hidden;
}

.faq-question{
padding:14px 16px;
background:#1fa463;
color:#fff;
cursor:pointer;
font-weight:600;
font-size:15px;
margin:0;
}

.faq-answer{
display:none;
padding:16px;
font-size:14px;
color:#444;
line-height:1.7;
margin:0;
}

.faq-item.active .faq-answer{
display:block;
}

/* CONTACT */
.contact-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
}

.contact-card{
background:#fff;
padding:22px;
text-align:center;
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.06);
}

.contact-card i{
font-size:24px;
color:#1fa463;
margin-bottom:8px;
}

.contact-card a{
text-decoration:none;
color:#222;
font-weight:600;
}

/* RESPONSIVE */
@media(max-width:768px){
.hero{
grid-template-columns:1fr;
}
}

</style>

</head>

<body>

<?php include __DIR__ . '/sections-library/header.php'; ?>

<div class="container">

<!-- HERO -->
<div class="hero">
<img src="/services/assets/img/flooring-1.webp" alt="Homeowners reviewing flooring samples with a project consultant" width="1350" height="900">
<div class="hero-text">
<h1>Professional Flooring Installation Services</h1>
<p><strong>Just Smart Choice</strong> provides expert flooring installation including vinyl, tile, laminate, and hardwood flooring.</p>
<p>We help homeowners and businesses upgrade their spaces with durable, stylish, and long-lasting flooring solutions.</p>
</div>
</div>

<!-- SERVICES -->
<div class="section-title">Our <span>Flooring Services</span></div>

<div class="service-grid">

<div class="service-card"><i class="fa-solid fa-border-all"></i><h3>Vinyl Flooring</h3><div class="service-hover">Just Smart Choice installs waterproof vinyl flooring that is durable, modern, and easy to maintain.</div></div>

<div class="service-card"><i class="fa-solid fa-th-large"></i><h3>Tile Flooring</h3><div class="service-hover">High-quality tile flooring installation for kitchens, bathrooms, and high-traffic areas.</div></div>

<div class="service-card"><i class="fa-solid fa-layer-group"></i><h3>Laminate Flooring</h3><div class="service-hover">Affordable laminate flooring with a stylish wood-look finish installed by Just Smart Choice.</div></div>

<div class="service-card"><i class="fa-solid fa-tree"></i><h3>Hardwood Flooring</h3><div class="service-hover">Premium hardwood flooring solutions that add elegance and value to your property.</div></div>

<div class="service-card"><i class="fa-solid fa-screwdriver-wrench"></i><h3>Floor Repair</h3><div class="service-hover">Professional repair services to fix damaged, cracked, or worn-out flooring.</div></div>

<div class="service-card"><i class="fa-solid fa-broom"></i><h3>Floor Finishing</h3><div class="service-hover">Polishing and finishing services to give your floor a clean and premium appearance.</div></div>

<div class="service-card"><i class="fa-solid fa-ruler"></i><h3>Floor Measurement</h3><div class="service-hover">Accurate measurements to ensure proper installation and reduce material waste.</div></div>

<div class="service-card"><i class="fa-solid fa-home"></i><h3>Residential & Commercial</h3><div class="service-hover">Complete flooring solutions for homes, offices, and commercial spaces.</div></div>

</div>

<!-- VIDEOS -->
<div class="section-title">Our <span>Flooring Projects</span></div>

<div class="video-grid">
<iframe src="https://www.youtube.com/embed/VIDEO1"></iframe>
<iframe src="https://www.youtube.com/embed/VIDEO2"></iframe>
<iframe src="https://www.youtube.com/embed/VIDEO3"></iframe>
</div>

<!-- MATERIAL -->
<div class="section-title">Materials & <span>Suppliers</span></div>

<div class="material-grid">
<a href="#">Home Depot</a>
<a href="#">Lowes</a>
<a href="#">Floor & Decor</a>
<a href="#">Menards</a>
</div>

<!-- FAQ -->
<div class="section-title">Flooring <span>FAQ</span></div>

<?php
$faq = [

"What is the best flooring option for my home?" =>
"At Just Smart Choice, the best flooring depends on your needs, budget, and lifestyle. Vinyl flooring is ideal for moisture areas, tile offers durability, laminate is cost-effective, and hardwood provides premium value. Our team helps you select the perfect option.",

"How long does installation take?" =>
"Just Smart Choice typically completes flooring installation within 1 to 5 days depending on project size and complexity, ensuring high-quality results.",

"Do you remove old flooring?" =>
"Yes, Just Smart Choice handles complete removal of old flooring, surface preparation, and installation of new flooring for best results.",

"Is vinyl waterproof?" =>
"Yes, vinyl flooring installed by Just Smart Choice is fully waterproof and perfect for kitchens and bathrooms."

];

foreach($faq as $q=>$a){
echo "<div class='faq-item'>
<div class='faq-question'>$q</div>
<div class='faq-answer'>$a</div>
</div>";
}
?>

<!-- CONTACT -->
<div class="section-title">Contact <span>Us</span></div>

<div class="contact-grid">

<div class="contact-card">
<i class="fa-solid fa-phone"></i>
<a href="tel:+17277553786">(727) 755-3786</a>
</div>

<div class="contact-card">
<i class="fa-solid fa-envelope"></i>
<a href="mailto:admin@justsmartchoice.com">admin@justsmartchoice.com</a>
</div>

<div class="contact-card">
<i class="fa-solid fa-globe"></i>
<a href="https://justsmartchoice.com">justsmartchoice.com</a>
</div>

</div>

</div>

<?php include __DIR__ . '/sections-library/footer.php'; ?>

<script>
document.querySelectorAll(".faq-question").forEach(q=>{
q.addEventListener("click",()=>{
q.parentElement.classList.toggle("active");
});
});
</script>

</body>
</html>
