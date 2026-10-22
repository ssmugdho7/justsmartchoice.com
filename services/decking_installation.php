<?php
 $blogs = [
    ["id"=>1, "title"=>"How to Choose the Right Decking Material for Your Home", "image"=>"https://justsmartchoice.com/blog/uploads/decking/1Right Decking Material.png"],
    ["id"=>2, "title"=>"Top Things to Consider Before Installing a New Deck", "image"=>"https://justsmartchoice.com/blog/uploads/decking/2Installing a New Deck.png"],
    ["id"=>3, "title"=>"Common Decking Installation Mistakes and How to Avoid Them", "image"=>"https://justsmartchoice.com/blog/uploads/decking/3Installation Mistakes.png"],
    ["id"=>4, "title"=>"Wood vs. Composite Decking: Which Is Best for You?", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Deck Design Improves Safety.png"],
    ["id"=>5, "title"=>"How Proper Deck Design Improves Safety and Durability", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Hot and Cold Climates.png"],
    ["id"=>6, "title"=>"Best Decking Options for Different Weather Conditions", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Backyard for Deck Installation.png"],
    ["id"=>7, "title"=>"How to Prepare Your Backyard for Deck Installation", "image"=>"https://justsmartchoice.com/blog/uploads/decking/deck-paint.png"],
    ["id"=>8, "title"=>"Why Hiring a Professional Deck Installer Is Worth It", "image"=>"https://justsmartchoice.com/blog/uploads/decking/measuring wooden deck.png"],
    ["id"=>9, "title"=>"Deck Maintenance Tips to Extend the Life of Your Deck", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Just Smart Choice Deck maintenance.png"],
    ["id"=>10, "title"=>"How to Choose the Perfect Deck Size and Layout", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Just Smart Choice Planning the deck layout.png
"],
    ["id"=>11, "title"=>"Important Building Codes to Know Before Deck Installation", "image"=>"https://justsmartchoice.com/blog/uploads/decking/reviewing deck.png"],
    ["id"=>12, "title"=>"How Weather Affects Decking Installation and Longevity", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Inspecting the damp.png"],
    ["id"=>13, "title"=>"Budget-Friendly Decking Ideas Without Compromising Quality", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Deck installation with cost-saving.png"],
    ["id"=>14, "title"=>"Signs It’s Time to Replace or Upgrade Your Old Deck", "image"=>"https://justsmartchoice.com/blog/uploads/decking/staining deck in daylight.png"],
    ["id"=>15, "title"=>"How a New Deck Can Increase Your Home’s Value", "image"=>"https://justsmartchoice.com/blog/uploads/decking/Aligning deck railings.png"],
    ["id"=>16, "title"=>"Eco-Friendly Decking Materials for Sustainable Homes", "image"=>"https://justsmartchoice.com/blog/uploads/decking/removing damaged deck.png"]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Decking Tips & Resources | Just Smart Choice</title>
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
    padding-top:90px;
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap">
<link rel="stylesheet" href="/services/assets/smart-choice-brand-font.css?v=20260716">
</head>

<body>

<!-- NOTICE -->
<div class="notice-overlay" id="notice">
    <div class="notice-box">
        <div class="notice-close" onclick="closeNotice()">✖</div>
        <h2>Looking for a Professional Deck Installer??</h2>
        <p>Call us now for fast & reliable decking installation services</p>
        <a href="tel:7277553786">(727) 755-3786</a>
    </div>
</div>

<!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <img class="logo" src="https://crm.justsmartchoice.com/media/public/smartchoice%20logo.png">
            <a href="tel:7277553786" class="book">BOOK NOW</a>
        </nav>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <h1>Professional Decking Installation Tips & Outdoor Living Guides</h1>
    <p>Transform your outdoor space with expert decking advice, durable materials, and smart installation solutions</p>
</section>

<!-- BLOGS -->
<section class="container">
    <div class="grid">
        <?php foreach($blogs as $b): ?>
        <div class="card">
            <img src="<?= $b['image'] ?>">
            <div class="card-content">
                <h3><?= $b['title'] ?></h3>
                <a href="decking_blog.php?id=<?= $b['id'] ?>">Read More →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- ================= DECK INSTALLATION MATERIALS & SUPPLIERS ================= -->

<style>

.deck-material-section{
font-family: Arial, sans-serif;
padding:40px;
background:#f4f8f4;
border-radius:10px;
margin-top:40px;
}

.deck-material-section h2{
color:#1f7a3f;
font-size:30px;
margin-bottom:20px;
border-left:6px solid #ff7a18;
padding-left:15px;
}

.deck-material-section h3{
color:#333;
margin-top:25px;
font-size:22px;
}

.deck-material-section p{
line-height:1.7;
color:#555;
font-size:16px;
}

.deck-brand-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
margin-top:25px;
}

.deck-brand-box{
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
transition:0.3s;
text-align:center;
}

.deck-brand-box:hover{
transform:translateY(-5px);
box-shadow:0 8px 18px rgba(0,0,0,0.12);
}

.deck-brand-box a{
text-decoration:none;
font-weight:bold;
color:#1f7a3f;
font-size:18px;
}

.deck-brand-box p{
font-size:14px;
margin-top:8px;
}

.deck-button{
display:inline-block;
margin-top:10px;
padding:8px 14px;
background:#ff7a18;
color:white !important;
border-radius:5px;
font-size:14px;
text-decoration:none;
}

.deck-button:hover{
background:#e46710;
}

</style>


<section class="deck-material-section">

<h2>Trusted Materials for Deck Installation Near Me</h2>

<p>
When homeowners search for <strong>deck installation near me</strong>, they want a durable outdoor structure that improves their home's comfort and value. Our professional deck builders use high-quality decking materials from trusted suppliers to ensure every deck installation project delivers long-lasting durability and beautiful outdoor living spaces.
</p>

<p>
We work with some of the most trusted construction suppliers in the industry. These retailers provide premium decking boards, structural materials, fasteners, and outdoor construction products widely used by professional deck contractors.
</p>

<div class="deck-brand-grid">

<div class="deck-brand-box">
<a href="https://www.homedepot.com" target="_blank" rel="nofollow noopener">Home Depot</a>
<p>Home Depot offers high-quality decking boards, railing systems, framing lumber, and outdoor building materials.</p>
<a class="deck-button" href="https://www.homedepot.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

<div class="deck-brand-box">
<a href="https://www.lowes.com" target="_blank" rel="nofollow noopener">Lowe's</a>
<p>Lowe’s provides professional deck construction materials including pressure-treated lumber and composite decking.</p>
<a class="deck-button" href="https://www.lowes.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

<div class="deck-brand-box">
<a href="https://www.menards.com" target="_blank" rel="nofollow noopener">Menards</a>
<p>Menards supplies affordable building materials including deck boards, railing systems, and outdoor construction tools.</p>
<a class="deck-button" href="https://www.menards.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

</div>


<h3>Composite Decking and Outdoor Construction Brands</h3>

<p>
For homeowners looking for low-maintenance outdoor spaces, many modern <strong>deck installation near me</strong> projects use composite decking materials. Composite decking offers excellent durability, moisture resistance, and minimal maintenance compared to traditional wood decks.
</p>

<div class="deck-brand-grid">

<div class="deck-brand-box">
<a href="https://www.trex.com" target="_blank" rel="nofollow noopener">Trex Decking</a>
<p>Trex is one of the most popular composite decking brands offering eco-friendly and low-maintenance decking boards.</p>
<a class="deck-button" href="https://www.trex.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

<div class="deck-brand-box">
<a href="https://www.timbertech.com" target="_blank" rel="nofollow noopener">TimberTech</a>
<p>Premium composite decking products designed for durability, beauty, and long-lasting outdoor performance.</p>
<a class="deck-button" href="https://www.timbertech.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

<div class="deck-brand-box">
<a href="https://www.fiberondecking.com" target="_blank" rel="nofollow noopener">Fiberon Decking</a>
<p>High-performance composite decking systems with modern designs and superior weather resistance.</p>
<a class="deck-button" href="https://www.fiberondecking.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

</div>


<h3>Deck Design Inspiration and Outdoor Living Ideas</h3>

<p>
Before starting a <strong>deck installation near me</strong> project, many homeowners explore design ideas for outdoor living spaces. Websites dedicated to home improvement and outdoor design provide thousands of deck inspiration ideas.
</p>

<div class="deck-brand-grid">

<div class="deck-brand-box">
<a href="https://www.houzz.com" target="_blank" rel="nofollow noopener">Houzz</a>
<p>Explore deck designs, outdoor living spaces, and professional construction ideas.</p>
<a class="deck-button" href="https://www.houzz.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

<div class="deck-brand-box">
<a href="https://www.hgtv.com" target="_blank" rel="nofollow noopener">HGTV</a>
<p>Outdoor living inspiration including deck remodeling ideas and patio design trends.</p>
<a class="deck-button" href="https://www.hgtv.com" target="_blank" rel="nofollow noopener">Visit Website</a>
</div>

</div>

</section>

<!-- ================= END DECK SECTION ================= -->
</body>
</html>
