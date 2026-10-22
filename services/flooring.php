<?php
$company="Smart Choice Flooring";
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Flooring Services Near Me | Smart Choice Flooring</title>

<meta name="description" content="Professional flooring services near you. Smart Choice Flooring offers tile, vinyl, hardwood, laminate, and commercial flooring solutions.">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* GLOBAL */
body{
margin:0;
font-family:'Poppins', Arial;
background:#f6f8f7;
color:#222;
}

.container{
max-width:1150px;
margin:auto;
padding:0 20px;
}

/* TITLE */
.section-title{
text-align:center;
font-size:24px;
font-weight:600;
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
font-size:30px;
margin-bottom:10px;
}
.hero-text p{
color:#555;
line-height:1.6;
}

/* SERVICES */
.service-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
gap:20px;
}
.service-card{
background:#fff;
padding:20px;
border-radius:10px;
text-align:center;
box-shadow:0 4px 10px rgba(0,0,0,0.06);
position:relative;
overflow:hidden;
transition:.3s;
}
.service-card:hover{
transform:translateY(-5px);
}
.service-card i{
font-size:26px;
color:#1fa463;
margin-bottom:8px;
}
.service-card h3{
font-size:16px;
}

/* HOVER */
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
padding:15px;
opacity:0;
transition:.3s;
font-size:14px;
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
margin:10px;
padding:12px 20px;
background:#fff;
border-radius:6px;
text-decoration:none;
color:#333;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
transition:.3s;
}
.material-grid a:hover{
background:#1fa463;
color:#fff;
}

/* FAQ */
.faq-item{
background:#fff;
margin-bottom:10px;
border-radius:6px;
box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.faq-question{
padding:14px;
background:#1fa463;
color:#fff;
cursor:pointer;
font-weight:500;
}
.faq-answer{
display:none;
padding:14px;
font-size:14px;
color:#444;
}

/* CONTACT */
.contact-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
}
.contact-card{
background:#fff;
padding:20px;
text-align:center;
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.06);
}
.contact-card i{
font-size:22px;
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap">
<link rel="stylesheet" href="/services/assets/smart-choice-brand-font.css?v=20260716">
</head>

<body>

<!-- HEADER (UNCHANGED FROM YOUR SYSTEM) -->
<?php include __DIR__ . '/../sections-library/header.php'; ?>

<div class="container">

<!-- HERO -->
<div class="hero">
<img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c">

<div class="hero-text">
<h1>Professional Flooring Services Near You</h1>
<p><strong>Smart Choice Flooring</strong> provides high-quality flooring installation including tile, vinyl, hardwood, laminate, and custom flooring solutions.</p>
<p>We help homeowners and businesses upgrade spaces with durable, modern, and long-lasting flooring.</p>
</div>
</div>

<!-- SERVICES -->
<div class="section-title">Our <span>Flooring Services</span></div>

<div class="service-grid">

<div class="service-card"><i class="fa-solid fa-layer-group"></i><h3>Tile Flooring</h3><div class="service-hover">Professional tile installation for kitchens, bathrooms, and floors.</div></div>

<div class="service-card"><i class="fa-solid fa-border-all"></i><h3>Vinyl Flooring</h3><div class="service-hover">Durable waterproof vinyl flooring solutions.</div></div>

<div class="service-card"><i class="fa-solid fa-tree"></i><h3>Hardwood Flooring</h3><div class="service-hover">Premium hardwood flooring for a timeless look.</div></div>

<div class="service-card"><i class="fa-solid fa-grip-lines"></i><h3>Laminate Flooring</h3><div class="service-hover">Affordable and stylish laminate flooring.</div></div>

<div class="service-card"><i class="fa-solid fa-tools"></i><h3>Floor Repair</h3><div class="service-hover">Repair damaged flooring and restore quality.</div></div>

<div class="service-card"><i class="fa-solid fa-hammer"></i><h3>Floor Remodeling</h3><div class="service-hover">Upgrade your floors with modern designs.</div></div>

<div class="service-card"><i class="fa-solid fa-ruler"></i><h3>Custom Flooring</h3><div class="service-hover">Custom flooring solutions tailored to your needs.</div></div>

<div class="service-card"><i class="fa-solid fa-building"></i><h3>Commercial Flooring</h3><div class="service-hover">Professional flooring for commercial spaces.</div></div>

</div>

<!-- VIDEOS -->
<div class="section-title">Our <span>Project Videos</span></div>

<div class="video-grid">
<iframe src="https://www.youtube.com/embed/VIDEO1"></iframe>
<iframe src="https://www.youtube.com/embed/VIDEO2"></iframe>
<iframe src="https://www.youtube.com/embed/VIDEO3"></iframe>
</div>

<!-- MATERIAL -->
<div class="section-title">Materials & <span>Resources</span></div>

<div class="material-grid">
<a href="https://www.homedepot.com" target="_blank">Home Depot</a>
<a href="https://www.lowes.com" target="_blank">Lowes</a>
<a href="https://www.flooranddecor.com" target="_blank">Floor & Decor</a>
<a href="https://www.llflooring.com" target="_blank">LL Flooring</a>
</div>

<!-- FAQ -->
<div class="section-title">Flooring <span>FAQ</span></div>

<div class="faq-item"><div class="faq-question">How long does flooring installation take?</div><div class="faq-answer">Most projects are completed within 1–3 days depending on size and material.</div></div>

<div class="faq-item"><div class="faq-question">Which flooring is best?</div><div class="faq-answer">Vinyl and hardwood are popular choices depending on budget and use.</div></div>

<div class="faq-item"><div class="faq-question">Do you install tile?</div><div class="faq-answer">Yes, we install tile flooring professionally.</div></div>

<div class="faq-item"><div class="faq-question">Is vinyl waterproof?</div><div class="faq-answer">Yes, vinyl flooring is water-resistant and durable.</div></div>

<div class="faq-item"><div class="faq-question">Do you repair floors?</div><div class="faq-answer">Yes, we repair all types of flooring damage.</div></div>

<div class="faq-item"><div class="faq-question">Do you remove old flooring?</div><div class="faq-answer">Yes, we handle full replacement projects.</div></div>

<div class="faq-item"><div class="faq-question">Commercial flooring?</div><div class="faq-answer">Yes, we handle commercial flooring projects.</div></div>

<div class="faq-item"><div class="faq-question">Custom designs?</div><div class="faq-answer">Yes, we offer custom flooring solutions.</div></div>

<div class="faq-item"><div class="faq-question">How to start?</div><div class="faq-answer">Contact Smart Choice Flooring to begin.</div></div>

<div class="faq-item"><div class="faq-question">Do you help choose material?</div><div class="faq-answer">Yes, we guide you in selecting the best flooring.</div></div>

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
<a href="https://justsmartchoice.com" target="_blank">justsmartchoice.com</a>
</div>

</div>

</div>

<!-- FOOTER (UNCHANGED) -->
<?php include __DIR__ . '/../sections-library/footer.php'; ?>

<script>
document.querySelectorAll(".faq-question").forEach(q=>{
q.addEventListener("click",()=>{
let a=q.nextElementSibling;
a.style.display=a.style.display==="block"?"none":"block";
});
});
</script>

</body>
</html>