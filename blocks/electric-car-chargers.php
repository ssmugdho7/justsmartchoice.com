<?php
$blogs = [
["id"=>1, "title"=>"Essential Electric Car Charger Installation Tips Every Homeowner Should Know", "image"=>"https://justsmartchoice.com/blog/uploads/car/1.png"],
["id"=>2, "title"=>"Level 1 vs Level 2 EV Chargers: Which One Is Right for Your Home?", "image"=>"https://justsmartchoice.com/blog/uploads/car/2.png"],
["id"=>3, "title"=>"Common Electric Vehicle Charger Installation Mistakes to Avoid", "image"=>"https://justsmartchoice.com/blog/uploads/car/3.png"],
["id"=>4, "title"=>"How to Choose the Right Location for Your EV Charger Installation", "image"=>"https://justsmartchoice.com/blog/uploads/car/4.png"],
["id"=>5, "title"=>"Electrical Panel Upgrade Tips for Installing an EV Charger at Home", "image"=>"https://justsmartchoice.com/blog/uploads/car/5.png"],
["id"=>6, "title"=>"Cost-Saving Tips When Installing a Home Electric Car Charger", "image"=>"https://justsmartchoice.com/blog/uploads/car/6.png"],
["id"=>7, "title"=>"Safety Advice for Using and Maintaining Your EV Charging Station", "image"=>"https://justsmartchoice.com/blog/uploads/car/7.png"],
["id"=>8, "title"=>"How Professional EV Charger Installation Increases Home Value", "image"=>"https://justsmartchoice.com/blog/uploads/car/8.png"],
["id"=>9, "title"=>"Best EV Chargers for Residential Use: Features and Benefits Explained", "image"=>"https://justsmartchoice.com/blog/uploads/car/9.png"],
["id"=>10, "title"=>"Weatherproof EV Charger Installation Tips for Outdoor Setups", "image"=>"https://justsmartchoice.com/blog/uploads/car/10.png"],
["id"=>11, "title"=>"How to Prepare Your Garage for an Electric Car Charging Station", "image"=>"https://justsmartchoice.com/blog/uploads/car/11.png"],
["id"=>12, "title"=>"Understanding EV Charger Permits and Electrical Code Requirements", "image"=>"https://justsmartchoice.com/blog/uploads/car/12.png"],
["id"=>13, "title"=>"Energy-Efficient EV Charging Tips to Reduce Electricity Bills", "image"=>"https://justsmartchoice.com/blog/uploads/car/13.png"],
["id"=>14, "title"=>"Signs You Need to Upgrade Your Home Wiring for an EV Charger", "image"=>"https://justsmartchoice.com/blog/uploads/car/14.png"],
["id"=>15, "title"=>"Smart EV Charger Technology: Tips for Modern and Connected Homes", "image"=>"https://justsmartchoice.com/blog/uploads/car/15.png"],
["id"=>16, "title"=>"EV Charger Maintenance Tips for Long-Term Performance and Safety", "image"=>"https://justsmartchoice.com/blog/uploads/car/16.png"]

];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Power Your Drive with Professional EV Installation</title>
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

<!-- HERO -->
<section class="hero">
    <h1>Professional Electric Car Charger Solutions & Installation Guides</h1>
    <p>Charge smarter at home with safe, reliable, and energy-efficient EV charging systems</p>
</section>

<!-- BLOGS -->
<section class="container">
    <div class="grid">
        <?php foreach($blogs as $b): ?>
        <div class="card">
            <img src="<?= $b['image'] ?>">
            <div class="card-content">
                <h3><?= $b['title'] ?></h3>
                <a href="blog-electric-car-chargers.php?id=<?= $b['id'] ?>">Read More →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include __DIR__ . "/../sections-library/footer.php"; ?>
</body>
</html>
