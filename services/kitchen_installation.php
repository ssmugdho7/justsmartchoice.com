<?php
$blogs = [
    ["id"=>1, "title"=>"Expert Kitchen Installation Tips Every Homeowner Should Know", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/1.png"],
    ["id"=>2, "title"=>"Essential Kitchen Planning Tips to Avoid Costly Mistakes", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/2.png"],
    ["id"=>3, "title"=>"Expert Advice for a Smooth and Stress-Free Kitchen Installation", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/3.png"],
    ["id"=>4, "title"=>"Common Kitchen Installation Errors and How to Prevent Them", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/4.png"],
    ["id"=>5, "title"=>"Expert Tips to Design a Functional and Stylish Kitchen", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/5.png"],
    ["id"=>6, "title"=>"How Proper Kitchen Installation Improves Home Value", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/6.png"],
    ["id"=>7, "title"=>"Expert Tips for Choosing the Right Kitchen Layout", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/7.png"],
    ["id"=>8, "title"=>"Kitchen Cabinet Installation Tips for Long-Lasting Results", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/8.png"],
    ["id"=>9, "title"=>"Expert Advice on Countertop Selection and Installation", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/9.png"],
    ["id"=>10, "title"=>"Kitchen Plumbing and Electrical Installation Tips from Experts", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/10.png"],
    ["id"=>11, "title"=>"Expert Tips to Maximize Storage During Kitchen Installation", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/11.png"],
    ["id"=>12, "title"=>"How Poor Installation Can Ruin Your Kitchen – Expert Insights", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/12.png"],
    ["id"=>13, "title"=>"Expert Advice on Budget-Friendly Kitchen Installation", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/13.png"],
    ["id"=>14, "title"=>"Kitchen Installation Tips to Improve Safety and Efficiency", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/14.png"],
    ["id"=>15, "title"=>"Expert Tips for Installing Durable Kitchen Flooring", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/15.png"],
    ["id"=>16, "title"=>"How to Prepare Your Home for Kitchen Installation", "image"=>"https://justsmartchoice.com/blog/uploads/kitchen/16.png"]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Expert Kitchen Installation Tips & Home Improvement Solutions</title>
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
    <h1>Expert Kitchen Installation Tips & Home Improvement Resources</h1>
    <p>Enhance your home, avoid costly mistakes, and ensure your kitchen installation is functional, durable, and beautifully finished</p>
</section>

<!-- BLOGS -->
<section class="container">
    <div class="grid">
        <?php foreach($blogs as $b): ?>
        <div class="card">
            <img src="<?= $b['image'] ?>">
            <div class="card-content">
                <h3><?= $b['title'] ?></h3>
                <a href="kitchen_blog.php?id=<?= $b['id'] ?>">Read More →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

</body>
</html>
