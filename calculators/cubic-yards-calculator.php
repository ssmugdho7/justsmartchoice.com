<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cubic Yards Calculator - Smart Choice Contractors</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta name="description" content="Calculate cubic yards for any shape including square, rectangle, circle, triangle, trapezoid, or border areas. Perfect for mulch, sand, gravel, and concrete.">
    <meta property="og:title" content="Cubic Yards Calculator - Smart Choice Contractors">
    <meta property="og:description" content="Free online cubic yards calculator for square, rectangle, circle, triangle, trapezoid, and border areas. Calculates volume in cubic feet and cubic yards.">
    <meta property="og:image" content="images/logo-638x310.png">
    <meta property="og:url" content="https://www.smartchoiceusa.com/cubic-yards-calculator">
    <meta property="og:type" content="website">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700">
    <link rel="stylesheet" href="css/style.css">

    <style>
      .calculator {
        max-width: 400px;
        margin: 40px auto;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
        padding: 20px;
        text-align: center;
      }
      .calculator select, .calculator input {
        width: 100%;
        padding: 8px;
        margin: 6px 0;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1rem;
      }
      .calculator button {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        font-size: 1rem;
        border: none;
        border-radius: 6px;
        background: #007bff;
        color: #fff;
        cursor: pointer;
        transition: 0.2s;
      }
      .calculator button:hover { opacity: 0.9; }
      .results {
        margin-top: 15px;
        text-align: left;
        font-size: 0.95rem;
        background: #fff;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
      }
      .powered {
        font-size: 0.75rem;
        color: #555;
        margin-top: 10px;
      }
      .go-back-btn {
        display: block;
        width: 100%;
        margin: 20px auto 0 auto;
        padding: 12px;
        background-color: #ff5722;
        color: white;
        font-size: 1.1rem;
        font-weight: bold;
        text-align: center;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: background-color 0.3s ease;
      }
      .go-back-btn:hover {
        background-color: #e64a19;
      }
      #shapePreview img {
        max-width: 100%;
        display: none;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 5px;
        margin-top: 10px;
      }
    </style>
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
        <!-- RD Navbar -->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar" data-layout="rd-navbar-fixed">
            <div class="rd-navbar-section rd-navbar-static-collapse">
              <div class="rd-navbar-container">
                <div class="rd-navbar-panel">
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav"><span></span></button>
                  <div class="rd-navbar-logo">
                    <a href="index.php"><img class="logo-small" src="images/logo-364x52.png" alt="" width="182" height="26"/><img class="logo-default" src="images/logo-638x310.png" alt="" width="319" height="155"/></a>
                  </div>
                </div>
                <div class="rd-navbar-section">
                  <div class="rd-navbar-container">
                    <ul class="rd-navbar-nav">
                      <li class="rd-nav-item <?php echo (basename($_SERVER['PHP_SELF'])=='index.php')?'active':'';?>"><a class="rd-nav-link" href="index.php">Home</a></li>
                      <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF'])=='about.php'?'active':'';?>"><a class="rd-nav-link" href="about.php">About</a></li>
                      <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF'])=='services.php'?'active':'';?>"><a class="rd-nav-link" href="services.php">Services</a></li>
                      <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF'])=='pricing.php'?'active':'';?>"><a class="rd-nav-link" href="pricing.php">Pricing</a></li>
                      <li class="rd-nav-item <?php echo basename($_SERVER['PHP_SELF'])=='contacts.php'?'active':'';?>"><a class="rd-nav-link" href="contacts.php">Contacts</a></li>
                    </ul>
                  </div>
                </div>
              </div>
          </nav>
        </div>
      </header>

      <!-- Calculator Section -->
      <section class="section-sm">
        <div class="container">
          <h2 class="text-uppercase text-center">Cubic Yards <span class="font-weight-light">Calculator</span></h2>
          <div class="calculator">
            <label for="shape">Select Shape:</label>
            <select id="shape" onchange="updateInputs()">
              <option value="square">Square</option>
              <option value="rectangle">Rectangle</option>
              <option value="rectborder">Rectangle Border</option>
              <option value="circle">Circle</option>
              <option value="circleborder">Circle Border</option>
              <option value="triangle">Triangle</option>
              <option value="trapezoid">Trapezoid</option>
            </select>

            <div id="inputs"></div>

            <!-- Shape preview -->
            <div id="shapePreview">
              <img id="shapeImg" src="" alt="Shape Preview">
            </div>

            <button onclick="calculateCubicYards()">Calculate</button>

            <div class="results" id="results"></div>
            <div class="powered">Powered by Smart Choice Contractors</div>

            <!-- Go Back Button -->
            <button class="go-back-btn" onclick="history.back()">← Go Back</button>
          </div>
        </div>
      </section>

      <?php include 'sections-library/bottom-banner.html'; ?>
      <?php include 'sections-library/footer.html'; ?>
    </div>

    <script>
      const inputsDiv = document.getElementById("inputs");
      const shapeImg = document.getElementById("shapeImg");

      function updateInputs() {
        const shape = document.getElementById("shape").value;
        let html = "";
        switch(shape){
          case "square":
            html = `<label>Side Length (ft):</label><input type="number" id="side">
                    <label>Depth (ft):</label><input type="number" id="depth">`;
            shapeImg.src = "images/shapes/square.png";
            break;
          case "rectangle":
            html = `<label>Length (ft):</label><input type="number" id="length">
                    <label>Width (ft):</label><input type="number" id="width">
                    <label>Depth (ft):</label><input type="number" id="depth">`;
            shapeImg.src = "images/shapes/rectangle.png";
            break;
          case "rectborder":
            html = `<label>Total Length (ft):</label><input type="number" id="lengthTotal">
                    <label>Total Width (ft):</label><input type="number" id="widthTotal">
                    <label>Inner Length (ft):</label><input type="number" id="lengthInner">
                    <label>Inner Width (ft):</label><input type="number" id="widthInner">
                    <label>Depth (ft):</label><input type="number" id="depth">`;
            shapeImg.src = "images/shapes/rectborder.png";
            break;
          case "circle":
            html = `<label>Diameter (ft):</label><input type="number" id="diameter">
                    <label>Depth (ft):</label><input type="number" id="depth">`;
            shapeImg.src = "images/shapes/circle.png";
            break;
          case "circleborder":
            html = `<label>Outer Diameter (ft):</label><input type="number" id="outerDiameter">
                    <label>Inner Diameter (ft):</label><input type="number" id="innerDiameter">
                    <label>Depth (ft):</label><input type="number" id="depth">`;
            shapeImg.src = "images/shapes/circleborder.png";
            break;
          case "triangle":
            html = `<label>Side a (ft):</label><input type="number" id="a">
                    <label>Side b (ft):</label><input type="number" id="b">
                    <label>Side c (ft):</label><input type="number" id="c">
                    <label>Depth (ft):</label><input type="number" id="depth">`;
            shapeImg.src = "images/shapes/triangle.png";
            break;
          case "trapezoid":
            html = `<label>Base a (ft):</label><input type="number" id="a">
                    <label>Base b (ft):</label><input type="number" id="b">
                    <label>Height (ft):</label><input type="number" id="h">
                    <label>Depth (ft):</label><input type="number" id="depth">`;
            shapeImg.src = "images/shapes/trapezoid.png";
            break;
        }
        inputsDiv.innerHTML = html;
        shapeImg.style.display = "block";
      }

      updateInputs();

      function getVal(id){ return parseFloat(document.getElementById(id)?.value)||0; }

      function calculateCubicYards(){
        const shape = document.getElementById("shape").value;
        let ft3 = 0;
        switch(shape){
          case "square": ft3 = Math.pow(getVal("side"),2)*getVal("depth"); break;
          case "rectangle": ft3 = getVal("length")*getVal("width")*getVal("depth"); break;
          case "rectborder":
            const totalArea = getVal("lengthTotal")*getVal("widthTotal");
            const innerArea = getVal("lengthInner")*getVal("widthInner");
            ft3 = (totalArea-innerArea)*getVal("depth");
            break;
          case "circle": ft3 = Math.PI*Math.pow(getVal("diameter")/2,2)*getVal("depth"); break;
          case "circleborder":
            const outer = Math.PI*Math.pow(getVal("outerDiameter")/2,2);
            const inner = Math.PI*Math.pow(getVal("innerDiameter")/2,2);
            ft3 = (outer-inner)*getVal("depth"); break;
          case "triangle":
            const a = getVal("a"), b = getVal("b"), c = getVal("c");
            const s = (a+b+c)/2;
            const area = Math.sqrt(s*(s-a)*(s-b)*(s-c));
            ft3 = area*getVal("depth"); break;
          case "trapezoid":
            ft3 = ((getVal("a")+getVal("b"))/2)*getVal("h")*getVal("depth"); break;
        }
        const yd3 = ft3/27;
        document.getElementById("results").innerHTML = `<b>Volume:</b><br>Cubic Feet: ${ft3.toFixed(2)} ft³<br>Cubic Yards: ${yd3.toFixed(2)} yd³`;
      }
    </script>
  </body>
</html>
