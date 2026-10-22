<!DOCTYPE html>
<html lang="en">
<head>
  <title>Concrete Volume Calculator - Smart Choice Contractors</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Calculate concrete volume for slabs, walls, footers, columns, steps, and curbs. Get cubic yards, cubic feet, and cubic meters plus material cost.">
  <meta property="og:title" content="Concrete Volume Calculator - Smart Choice Contractors">
  <meta property="og:description" content="Free online concrete calculator for slabs, walls, columns, steps, footers, and curbs. Calculates cubic yards, cubic feet, cubic meters, and cost.">
  <meta property="og:image" content="images/logo-638x310.png">
  <meta property="og:url" content="https://www.smartchoiceusa.com/concrete-calculator">
  <meta property="og:type" content="website">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700">
  <link rel="stylesheet" href="css/style.css">
</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZDN6L6KPP7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZDN6L6KPP7');
</script>

<body>
  <div class="preloader">
    <div class="preloader-body">
      <div class="cssload-container">
        <div class="cssload-speeding-wheel"></div>
      </div>
      <p>Loading...</p>
    </div>
  </div>
  <div class="page">

    <?php include 'sections-library/upper_banner.html'; ?>

    <!--Header-->
    <header class="section page-header">
      <div class="rd-navbar-wrap">
        <nav class="rd-navbar" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-static" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-md-stick-up-offset="185px" data-lg-stick-up-offset="185px" data-xl-stick-up-offset="185px" data-xxl-stick-up-offset="185px" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
          <div class="rd-navbar-section rd-navbar-static-collapse">
            <div class="rd-navbar-container">
              <div class="rd-navbar-panel">
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav"><span></span></button>
                <div class="rd-navbar-logo">
                  <a href="index.php">
                    <img class="logo-small" src="images/logo-364x52.png" alt="" width="182" height="26"/>
                    <img class="logo-default" src="images/logo-638x310.png" alt="" width="319" height="155"/>
                  </a>
                </div>
                <button class="rd-navbar-info-toggle" data-rd-navbar-toggle=".rd-navbar-info"><span></span></button>
              </div>
              <div class="rd-navbar-info">
                <div class="info">
                  <div class="info-heading">Need Help?</div>
                  <a class="info-link" href="tel:‪(727) 755-3786‬"><span class="info-icon fa-mobile"></span> ‪(727) 755-3786‬</a>
                  <div class="info-small"><strong>Opening Hours:</strong> 8am-6pm PST M-Fr; 8am-3pm PST Sat</div>
                </div>
              </div>
            </div>

            <!--Navbar-->
            <div class="rd-navbar-section">
              <div class="rd-navbar-container">
                <ul class="rd-navbar-nav">
                  <li class="rd-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"><a class="rd-nav-link" href="index.php">Home</a></li>
                  <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"><a class="rd-nav-link" href="about.php">About</a></li>
                  <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>"><a class="rd-nav-link" href="services.php">Services</a></li>
                  <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'pricing.php' ? 'active' : ''; ?>"><a class="rd-nav-link" href="pricing.php">Pricing</a></li>
                  <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'financing.php' ? 'active' : ''; ?>"><a class="rd-nav-link" href="financing.php">Financing</a></li>
                  <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'contacts.php' ? 'active' : ''; ?>"><a class="rd-nav-link" href="contacts.php">Contacts</a></li>
                  <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>"><a class="rd-nav-link" href="login.php">Login</a></li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>

    <!-- Concrete Calculator Section -->
    <section class="section-sm">
      <div class="container">
        <h2 class="text-uppercase text-center">Concrete <span class="font-weight-light">Volume Calculator</span></h2>
        <div class="calculator">
          <label for="shape">Choose Concrete Shape:</label>
          <select id="shape" onchange="updateFields()">
            <option value="slab">Square Slab</option>
            <option value="roundslab">Round Slab</option>
            <option value="wall">Wall</option>
            <option value="footer">Footer</option>
            <option value="squarecolumn">Square Column</option>
            <option value="roundcolumn">Round Column</option>
            <option value="steps">Steps</option>
            <option value="curb">Curbs & Gutters</option>
          </select>

          <div id="inputs"></div>

          <label>Quantity:</label>
          <input type="number" id="quantity" value="1" min="1">

          <label>Price per Unit (optional):</label>
          <input type="number" id="price" placeholder="Enter price">
          <select id="priceUnit">
            <option value="ft3">per ft³</option>
            <option value="yd3">per yd³</option>
            <option value="m3">per m³</option>
          </select>

          <button onclick="calculateConcrete()">Calculate</button>
          <div class="results" id="results"></div>

          <!-- Go Back Button -->
          <button class="go-back-btn" onclick="history.back()">← Go Back</button>

          <div class="powered">Powered by Smart Choice Contractors</div>
        </div>
      </div>
    </section>

    <!--bottom-banner-->
    <?php include 'sections-library/bottom-banner.html'; ?>

    <!--Footer-->
    <?php include 'sections-library/footer.html'; ?>
  </div>

  <script>
    const inputsDiv = document.getElementById("inputs");
    function updateFields() {
      const shape = document.getElementById("shape").value;
      let html = "";
      switch(shape) {
        case "slab":
        case "footer":
          html = `
            <label>Width (ft):</label><input type="number" id="width">
            <label>Length (ft):</label><input type="number" id="length">
            <label>Depth (ft):</label><input type="number" id="depth">`;
          break;
        case "roundslab":
          html = `
            <label>Diameter (ft):</label><input type="number" id="diameter">
            <label>Depth (ft):</label><input type="number" id="depth">`;
          break;
        case "wall":
          html = `
            <label>Thickness (ft):</label><input type="number" id="thickness">
            <label>Length (ft):</label><input type="number" id="length">
            <label>Height (ft):</label><input type="number" id="height">`;
          break;
        case "squarecolumn":
          html = `
            <label>Width (ft):</label><input type="number" id="width">
            <label>Length (ft):</label><input type="number" id="length">
            <label>Height (ft):</label><input type="number" id="height">`;
          break;
        case "roundcolumn":
          html = `
            <label>Diameter (ft):</label><input type="number" id="diameter">
            <label>Height (ft):</label><input type="number" id="height">`;
          break;
        case "steps":
          html = `
            <label>Platform Depth (ft):</label><input type="number" id="platform">
            <label>Rise Height (ft):</label><input type="number" id="rise">
            <label>Run Depth (ft):</label><input type="number" id="run">
            <label>Width (ft):</label><input type="number" id="width">
            <label>Number of Steps:</label><input type="number" id="numsteps">`;
          break;
        case "curb":
          html = `
            <label>Curb Depth (ft):</label><input type="number" id="curbdepth">
            <label>Curb Height (ft):</label><input type="number" id="curbheight">
            <label>Flag Thickness (ft):</label><input type="number" id="flagthick">
            <label>Length (ft):</label><input type="number" id="length">
            <label>Gutter Width (ft):</label><input type="number" id="gutter">`;
          break;
      }
      inputsDiv.innerHTML = html;
    }
    updateFields();

    function calculateConcrete() {
      const shape = document.getElementById("shape").value;
      const qty = parseFloat(document.getElementById("quantity").value) || 1;
      let ft3 = 0;

      if(shape === "slab" || shape === "footer") {
        ft3 = (get("width")*get("length")*get("depth"));
      }
      else if(shape === "roundslab") {
        ft3 = (Math.PI * Math.pow(get("diameter")/2,2) * get("depth"));
      }
      else if(shape === "wall") {
        ft3 = (get("thickness")*get("length")*get("height"));
      }
      else if(shape === "squarecolumn") {
        ft3 = (get("width")*get("length")*get("height"));
      }
      else if(shape === "roundcolumn") {
        ft3 = (Math.PI * Math.pow(get("diameter")/2,2) * get("height"));
      }
      else if(shape === "steps") {
        const platform = get("platform"), rise = get("rise"), run = get("run"), width = get("width"), n = get("numsteps");
        let platformVol = platform * (rise * n) * width;
        let stepVol = 0;
        for(let i=1;i<n;i++) {
          stepVol += run * (rise * i) * width;
        }
        ft3 = platformVol + stepVol;
      }
      else if(shape === "curb") {
        let curbVol = get("curbdepth") * (get("curbheight")+get("flagthick")) * get("length");
        let gutterVol = get("gutter") * get("flagthick") * get("length");
        ft3 = curbVol + gutterVol;
      }

      ft3 *= qty;
      const yd3 = ft3/27;
      const m3 = ft3*0.0283;

      let price = parseFloat(document.getElementById("price").value) || 0;
      let unit = document.getElementById("priceUnit").value;
      let cost = 0;
      if(price>0) {
        if(unit==="ft3") cost = price*ft3;
        if(unit==="yd3") cost = price*yd3;
        if(unit==="m3") cost = price*m3;
      }

      let result = `
        <b>Volume:</b><br>
        Cubic Feet: ${ft3.toFixed(2)} ft³<br>
        Cubic Yards: ${yd3.toFixed(2)} yd³<br>
        Cubic Meters: ${m3.toFixed(2)} m³<br>`;
      if(cost>0) result += `<br><b>Total Cost:</b> $${cost.toFixed(2)}`;
      document.getElementById("results").innerHTML = result;
    }
    function get(id){ return parseFloat(document.getElementById(id).value) || 0; }
  </script>
</body>
</html>
