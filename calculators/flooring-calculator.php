<!DOCTYPE html>
<html lang="en">
  <head>
      
      <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZDN6L6KPP7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZDN6L6KPP7');
</script>

    <title>Flooring Calculator - Smart Choice Contractors</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Calculate the number of flooring planks required for your area. Add optional waste percentage. Smart Choice Contractors Flooring Calculator.">
    <meta property="og:title" content="Flooring Calculator - Smart Choice Contractors">
    <meta property="og:description" content="Free online flooring calculator. Enter room size, plank dimensions, and optional waste percentage to get the total number of planks required.">
    <meta property="og:image" content="images/logo-638x310.png">
    <meta property="og:url" content="https://www.smartchoiceusa.com/flooring-calculator">
    <meta property="og:type" content="website">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700">
    <link rel="stylesheet" href="css/style.css">

    <style>
      .calculator {
        max-width: 320px;
        margin: 40px auto;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
        padding: 20px;
        text-align: center;
      }
      .calculator input, .calculator select {
        width: 100%;
        height: 45px;
        font-size: 1.2rem;
        margin-bottom: 10px;
        text-align: right;
        padding: 8px;
        border: 2px solid #ccc;
        border-radius: 6px;
        background: #fff;
      }
      .calculator-keys {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 10px;
      }
      button {
        padding: 12px;
        font-size: 1rem;
        border: none;
        border-radius: 6px;
        background: #007bff;
        color: #fff;
        cursor: pointer;
        transition: 0.2s;
      }
      button:hover { opacity: 0.9; }
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
        margin-top: 8px;
      }
      /* Go Back Button Style */
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
    </style>
  </head>
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
          <nav class="rd-navbar" data-layout="rd-navbar-fixed">
            <div class="rd-navbar-section rd-navbar-static-collapse">
              <div class="rd-navbar-container">
                <div class="rd-navbar-panel">
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav"><span></span></button>
                  <div class="rd-navbar-logo">
                    <a href="index.php"><img class="logo-small" src="images/logo-364x52.png" alt="" width="182" height="26"/><img class="logo-default" src="images/logo-638x310.png" alt="" width="319" height="155"/></a>
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

      <!-- Flooring Calculator Section -->
      <section class="section-sm">
        <div class="container">
          <h2 class="text-uppercase text-center">Flooring <span class="font-weight-light">Calculator</span></h2>
          <div class="calculator">
            <label>Room Area (sq ft):</label>
            <input type="number" id="area" placeholder="Enter room area">

            <label>Plank Length (ft):</label>
            <input type="number" id="plankLength" placeholder="Plank length">

            <label>Plank Width (ft):</label>
            <input type="number" id="plankWidth" placeholder="Plank width">

            <label>Waste Percentage:</label>
            <select id="waste">
              <option value="0">0%</option>
              <option value="3">3%</option>
              <option value="5">5%</option>
              <option value="10">10%</option>
            </select>

            <div class="calculator-keys">
              <button onclick="calculateFlooring()">Calculate</button>
            </div>

            <div class="results" id="results"></div>
            <div class="powered">Powered by Smart Choice Contractors</div>
            <button class="go-back-btn" onclick="history.back()">← Go Back</button>
          </div>
        </div>
      </section>

      <?php include 'sections-library/bottom-banner.html'; ?>
      <?php include 'sections-library/footer.html'; ?>
    </div>

    <script>
      function calculateFlooring(){
        let area = parseFloat(document.getElementById('area').value) || 0;
        let plankL = parseFloat(document.getElementById('plankLength').value) || 0;
        let plankW = parseFloat(document.getElementById('plankWidth').value) || 0;
        let waste = parseFloat(document.getElementById('waste').value) || 0;

        if(area <=0 || plankL <=0 || plankW <=0){
          document.getElementById('results').innerHTML = "Please enter valid values.";
          return;
        }

        let plankArea = plankL * plankW;
        let numPlanks = area / plankArea;
        numPlanks += numPlanks * (waste / 100);
        numPlanks = Math.ceil(numPlanks);

        document.getElementById('results').innerHTML = `<b>Total Planks Needed:</b> ${numPlanks} planks (including ${waste}% waste)`;
      }
    </script>
  </body>
</html>
