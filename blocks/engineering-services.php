<?php
$blogs = [
["id"=>1, "title"=>"Essential Engineering Tips Every Homeowner Should Know Before Construction", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/1.png"],
["id"=>2, "title"=>"Why Professional Engineering Drawings Are Critical for Safe Construction", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/2.png"],
["id"=>3, "title"=>"Common Engineering Mistakes in Residential Projects and How to Avoid Them", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/3.png"],
["id"=>4, "title"=>"How Structural Engineering Improves Building Safety and Longevity", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/4.png"],
["id"=>5, "title"=>"When Do You Need Engineering Drawings for Permits?", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/5.png"],
["id"=>6, "title"=>"Benefits of Hiring a Licensed Engineer for Home Renovations", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/6.png"],
["id"=>7, "title"=>"Understanding Load-Bearing Walls: Engineering Insights for Homeowners", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/7.png"],
["id"=>8, "title"=>"How Engineering Inspections Help Prevent Costly Construction Failures", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/8.png"],
["id"=>9, "title"=>"Private Provider Engineering Inspections: What Homeowners Should Know", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/9.png"],
["id"=>10, "title"=>"Why Sealed Engineering Drawings Matter for Code Compliance", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/10.png"],
["id"=>11, "title"=>"Engineering Tips for Safe Structural Modifications and Additions", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/11.png"],
["id"=>12, "title"=>"How Engineering Services Reduce Risk During Remodeling Projects", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/12.png"],
["id"=>13, "title"=>"Engineering Design Tips for Stronger and More Durable Structures", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/13.png"],
["id"=>14, "title"=>"Common Reasons Engineering Plans Get Rejected and How to Fix Them", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/14.png"],
["id"=>15, "title"=>"How Engineering Inspections Speed Up Permit Approvals", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/15.png"],
["id"=>16, "title"=>"Choosing the Right Engineering Services for Residential and Commercial Projects", "image"=>"https://justsmartchoice.com/blog/uploads/engineer/16.png"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Expert Engineering Insights & Construction Guidance</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --green:#1fa463;
    --blue:#0b5ea8;
    --dark:#1e293b;
    --light:#f4f9f7;
    --text:#334155;
}

*{margin:0;padding:0;box-sizing:border-box}

body{
    font-family:Segoe UI, Arial, sans-serif;
    background:var(--light);
    color:var(--text);
    padding-top:0;
}

/* ===== POPUP NOTICE ===== */
.notice-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:9999;
}
.notice-box{
    background:#fff;
    padding:28px 35px;
    border-radius:14px;
    max-width:420px;
    text-align:center;
    position:relative;
    box-shadow:0 20px 40px rgba(0,0,0,.3);
}
.notice-box h2{color:var(--green)}
.notice-box a{
    margin-top:15px;
    display:inline-block;
    background:linear-gradient(90deg,var(--green),var(--blue));
    color:#fff;
    padding:12px 30px;
    border-radius:30px;
    font-weight:bold;
    text-decoration:none;
}
.notice-close{
    position:absolute;
    top:12px;
    right:15px;
    cursor:pointer;
    font-size:18px;
    color:#777;
}

/* ===== HEADER ===== */
.header{
    background:#fff;
    border-bottom:2px solid #e5e7eb;
    position:fixed;
    top:0;
    width:100%;
    z-index:1000;
}
.header-inner{
    max-width:1300px;
    margin:auto;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.logo{height:48px}
.nav{
    display:flex;
    gap:18px;
    align-items:center;
    flex-wrap:wrap;
}
.nav a{
    text-decoration:none;
    color:#334155;
    font-weight:600;
    padding:8px 14px;
    border-radius:20px;
}
.nav a:hover{
    background:rgba(31,164,99,.12);
    color:var(--green);
}
.book{
    background:linear-gradient(90deg,var(--green),var(--blue));
    color:#fff;
    padding:10px 22px;
    border-radius:30px;
    font-weight:bold;
}

/* ===== HERO ===== */
.hero{
    background:linear-gradient(120deg,var(--green),var(--blue));
    color:#fff;
    padding:45px 20px;
    text-align:center;
}
.hero h1{
    font-size:34px;
    text-shadow:0 4px 12px rgba(0,0,0,.35);
}
.hero p{
    font-size:16px;
    margin-top:10px;
    text-shadow:0 3px 10px rgba(0,0,0,.3);
}

/* ===== BLOG GRID ===== */
.container{
    max-width:1200px;
    margin:auto;
    padding:60px 20px;
}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:28px;
}
.card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
    transition:.3s;
}
.card:hover{transform:translateY(-6px)}
.card img{
    width:100%;
    height:200px;
    object-fit:cover;
}
.card-content{
    padding:22px;
}
.card-content h3{
    font-size:18px;
    color:var(--dark);
}
.card-content a{
    margin-top:12px;
    display:inline-block;
    color:var(--green);
    font-weight:bold;
    text-decoration:none;
}

/* ===== FOOTER (BORDER ONLY) ===== */
.footer{
    margin:40px auto 20px;
    max-width:1200px;
    border:3px solid var(--green);
    border-radius:18px;
    padding:40px 25px;
}
.footer-inner{
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
    gap:16px;
}
.footer-logo{height:46px}
.footer-text{
    max-width:520px;
    font-size:15px;
}
.footer-cta{
    background:linear-gradient(90deg,var(--green),var(--blue));
    color:#fff;
    padding:14px 36px;
    border-radius:40px;
    font-weight:bold;
    text-decoration:none;
    box-shadow:0 10px 25px rgba(0,0,0,.25);
}
.footer-phone{
    font-size:22px;
    font-weight:bold;
    color:var(--green);
}
.footer-bottom{
    margin-top:10px;
    font-size:14px;
    color:#64748b;
}

/* MOBILE */
@media(max-width:768px){
    .hero h1{font-size:26px}
}
</style>

<script>
function closeNotice(){
    document.getElementById("notice").style.display="none";
}
</script>
</head>

<body>
<?php include __DIR__ . "/../sections-library/header.php"; ?>

</div>

<!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <img class="logo" src="https://crm.justsmartchoice.com/media/public/smartchoice%20logo.png">
            <a href="https://crm.justsmartchoice.com/appointly/appointments_public/book?col=col-md-8+col-md-offset-2" target="_blank" rel="noopener" class="book">BOOK NOW</a>
        </nav>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <h1>Expert Engineering Insights & Construction Resources</h1>
    <p>Ensure safe designs, avoid costly mistakes, and keep your projects compliant with professional engineering standards</p>
</section>

<!-- BLOGS -->
<section class="container">
    <div class="grid">
        <?php foreach($blogs as $b): ?>
        <div class="card">
            <img src="<?= $b['image'] ?>">
            <div class="card-content">
                <h3><?= $b['title'] ?></h3>
                <a href="engineering-services-blog.php?id=<?= $b['id'] ?>">Read More →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- ================= ENGINEERING SERVICES SEO SECTION ================= -->

<style>

.engineering-section{
font-family: Arial, sans-serif;
padding:40px;
background:#f4f7fb;
border-radius:10px;
margin-top:40px;
}

.engineering-section h2{
color:#003f88;
font-size:30px;
margin-bottom:15px;
border-left:6px solid #ff7b00;
padding-left:15px;
}

.engineering-section h3{
font-size:22px;
color:#222;
margin-top:30px;
}

.engineering-section p{
font-size:16px;
line-height:1.7;
color:#555;
}

.engineering-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
margin-top:25px;
}

.engineering-card{
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 5px 12px rgba(0,0,0,0.1);
transition:0.3s;
text-align:center;
}

.engineering-card:hover{
transform:translateY(-6px);
box-shadow:0 10px 20px rgba(0,0,0,0.15);
}

.engineering-card a{
font-weight:bold;
font-size:18px;
text-decoration:none;
color:#003f88;
}

.engineering-btn{
display:inline-block;
margin-top:10px;
padding:8px 14px;
background:#ff7b00;
color:white !important;
border-radius:5px;
text-decoration:none;
font-size:14px;
}

.engineering-btn:hover{
background:#e66d00;
}

.hashtags{
margin-top:20px;
background:#eef3ff;
padding:15px;
border-radius:6px;
font-size:14px;
color:#333;
}

.video-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
gap:20px;
margin-top:25px;
}

.video-grid iframe{
width:100%;
height:220px;
border-radius:8px;
}

</style>


<section class="engineering-section">

<h2>Professional Engineering Services & Structural Consulting</h2>

<p>
If you are searching for reliable <strong>engineering services near me</strong>, our experienced engineering consultants provide structural engineering, construction analysis, building design support, and technical consulting services for residential and commercial projects.
</p>

<p>
Our engineering professionals specialize in <strong>structural engineering services</strong>, load calculations, building inspections, and engineering reports required for permits, construction approvals, and safe building design.
</p>


<h3>Trending Engineering & Construction Hashtags</h3>

<div class="hashtags">

#EngineeringServices  
#StructuralEngineering  
#CivilEngineering  
#ConstructionEngineering  
#EngineeringConsultant  
#BuildingDesign  
#StructuralInspection  
#ConstructionExperts  
#EngineeringSolutions  
#EngineeringConsulting  

</div>



<h3>Trusted Engineering Organizations & Resources</h3>

<p>
Professional engineering projects rely on industry standards, guidelines, and research provided by leading engineering organizations. Our engineering services follow best practices established by internationally recognized engineering institutions.
</p>

<div class="engineering-grid">

<div class="engineering-card">
<a href="https://www.asce.org" target="_blank" rel="nofollow noopener">ASCE</a>
<p>The American Society of Civil Engineers provides engineering standards and research for construction projects.</p>
<a class="engineering-btn" href="https://www.asce.org" target="_blank">Visit Website</a>
</div>

<div class="engineering-card">
<a href="https://www.nspe.org" target="_blank" rel="nofollow noopener">NSPE</a>
<p>The National Society of Professional Engineers promotes engineering excellence and professional standards.</p>
<a class="engineering-btn" href="https://www.nspe.org" target="_blank">Visit Website</a>
</div>

<div class="engineering-card">
<a href="https://www.aisc.org" target="_blank" rel="nofollow noopener">AISC</a>
<p>American Institute of Steel Construction providing engineering standards for steel structures.</p>
<a class="engineering-btn" href="https://www.aisc.org" target="_blank">Visit Website</a>
</div>

</div>



<h3>Engineering Design & Structural Analysis Videos</h3>

<p>
Understanding engineering principles can help homeowners and developers make better construction decisions. These videos explain structural engineering, building design concepts, and engineering analysis techniques used in modern construction projects.
</p>

<div class="video-grid">

<iframe src="https://www.youtube.com/embed/3Kq1MIfTWCE"
title="Structural Engineering Basics"
allowfullscreen></iframe>

<iframe src="https://www.youtube.com/embed/WsE2v3Vw9p8"
title="Engineering Design Process Explained"
allowfullscreen></iframe>

<iframe src="https://www.youtube.com/embed/1F0uF0v3qvE"
title="Civil Engineering and Construction Projects"
allowfullscreen></iframe>

</div>



<h3>Why Engineering Services Are Important for Construction Projects</h3>

<p>
Professional <strong>engineering services</strong> ensure that buildings are safe, structurally sound, and compliant with construction regulations. Engineers analyze load-bearing structures, foundation stability, materials, and environmental conditions to ensure every project meets safety standards.
</p>

<p>
Common engineering services include:
</p>

<ul>

<li>Structural engineering analysis</li>
<li>Building inspection reports</li>
<li>Load calculation and design verification</li>
<li>Construction engineering consulting</li>
<li>Permit drawings and engineering documentation</li>
<li>Foundation and structural evaluations</li>

</ul>


<h3>Request Professional Engineering Consultation</h3>

<p>
If you need reliable <strong>engineering consulting services</strong>, our engineering professionals are ready to assist with structural evaluations, construction planning, and technical engineering reports. Contact our team today to schedule a consultation and receive expert engineering guidance for your project.
</p>

</section>

<!-- ================= END ENGINEERING SECTION ================= -->
<?php include __DIR__ . "/../sections-library/footer.php"; ?>
</body>
</html>
