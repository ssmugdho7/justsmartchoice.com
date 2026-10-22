<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Drywall Calculator - Smart Choice Contractors</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Calculate drywall materials for your project. Estimate panels, compound, and tape.">
    <meta property="og:title" content="Drywall Calculator - Smart Choice Contractors">
    <meta property="og:description" content="Free online drywall calculator. Estimate sheets, joint compound, and tape from your area.">
    <meta property="og:image" content="images/logo-638x310.png">
    <meta property="og:url" content="https://www.smartchoiceusa.com/drywall-calculator">
    <meta property="og:type" content="website">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700">
    <link rel="stylesheet" href="css/style.css">

    <style>
      .calculator {
        max-width: 360px;
        margin: 40px auto;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
        padding: 20px;
        text-align: left;
        font-family: Raleway, Arial, sans-serif;
      }
      .calculator h3 {
        text-align: center;
        margin: 0 0 8px;
        font-weight: 700;
        letter-spacing: .3px;
      }
      .subtle {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 12px;
        line-height: 1.35rem;
      }
      .calculator label {
        display: block;
        font-weight: 600;
        margin-top: 10px;
        margin-bottom: 4px;
      }
      .calculator input, .calculator select, .calculator textarea {
        width: 100%;
        height: 44px;
        font-size: 1rem;
        margin-bottom: 8px;
        text-align: right;
        padding: 8px;
        border: 2px solid #ccc;
        border-radius: 6px;
        background: #fff;
      }
      .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
      }
      .calculator-keys {
        display: grid;
        grid-template-columns: 1fr;
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
      .link-btn {
        background: #6c757d;
      }
      details summary {
        cursor: pointer;
        padding: 8px 10px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 8px;
        font-weight: 600;
      }
      .results {
        margin-top: 15px;
        font-size: 0.95rem;
        background: #fff;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #ddd;
      }
      .results h4 {
        margin: 0 0 8px 0;
        font-size: 1.05rem;
      }
      .line {
        display: flex;
        justify-content: space-between;
        margin: 4px 0;
      }
      .muted {
        color: #777;
        font-size: 0.9rem;
      }
      .powered {
        font-size: 0.75rem;
        color: #555;
        margin-top: 8px;
        text-align: center;
      }
      .go-back-btn {
        display: block;
        width: 100%;
        margin: 16px auto 0 auto;
        padding: 12px;
        background-color: #ff5722;
        color: white;
        font-size: 1.05rem;
        font-weight: 700;
        text-align: center;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: background-color 0.3s ease;
      }
      .go-back-btn:hover { background-color: #e64a19; }
      .price {
        font-weight: 700;
      }
      .note {
        font-size: 0.8rem;
        color: #666;
        margin-top: 6px;
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

      <!-- Drywall Calculator Section -->
      <section class="section-sm">
        <div class="container">
          <h2 class="text-uppercase text-center">Drywall <span class="font-weight-light">Calculator</span></h2>

          <div class="calculator">
            <h3>Build Your Walls</h3>
            <div class="subtle">
              Enter Measurements — Let us know the area you need covered with drywall, and we’ll calculate the materials. 
              Include doors/windows in your total (you’ll cut those out of the provided panels).
            </div>

            <!-- Area entry -->
            <label>Total Area to be Covered (sq ft):</label>
            <input type="number" id="totalArea" placeholder="e.g. 38" value="38" min="0" step="0.01">

            <!-- Optional wall builder -->
            <details>
              <summary>Or build area from wall measurements</summary>
              <div class="two-col" style="margin-top:8px;">
                <div>
                  <label>Wall Length (ft):</label>
                  <input type="number" id="wallLength" placeholder="length" min="0" step="0.01">
                </div>
                <div>
                  <label>Wall Height (ft):</label>
                  <input type="number" id="wallHeight" placeholder="height" min="0" step="0.01">
                </div>
              </div>
              <div class="two-col">
                <div>
                  <label>Number of Walls:</label>
                  <input type="number" id="numWalls" placeholder="e.g. 4" min="0" step="1">
                </div>
                <div>
                  <label>Add to Total Area</label>
                  <button class="link-btn" type="button" onclick="addWallsToArea()">Add</button>
                </div>
              </div>
              <div class="muted">This adds (length × height × walls) to the Total Area field.</div>
            </details>

            <!-- Waste factor -->
            <div class="two-col">
              <div>
                <label>Waste / Overage (%):</label>
                <input type="number" id="wastePct" value="10" min="0" step="1">
              </div>
              <div>
                <label>Seam Length (ft) <span class="muted">(optional)</span></label>
                <input type="number" id="seamLength" placeholder="for tape qty" min="0" step="1">
              </div>
            </div>

            <!-- Options -->
            <label>Drywall Panel Dimensions:</label>
            <select id="panelSize">
              <option value="4x8" data-area="32">4 ft. x 8 ft.</option>
              <option value="4x12" data-area="48">4 ft. x 12 ft.</option>
            </select>

            <label>Drywall Thickness:</label>
            <select id="thickness">
              <option value='1/2"'>1/2"</option>
              <option value='5/8"'>5/8"</option>
              <option value='3/8"'>3/8"</option>
            </select>

            <label>Drywall Type:</label>
            <select id="dwType">
              <option value="none" data-price="0">None</option>
              <option value="Ultralight" data-price="17.38">Ultralight — $17.38 / each</option>
              <option value="Ultralight Mold Resistant" data-price="23.98">Ultralight Mold Resistant — $23.98 / each</option>
            </select>

            <label>Compound Type:</label>
            <select id="compound">
              <option value="none" data-price="0" data-coverage="0">None</option>
              <option value="Lightweight Pre-Mixed 500 sq. ft." data-price="21.23" data-coverage="500">Lightweight Pre-Mixed 500 sq. ft. — $21.23</option>
              <option value="All-Purpose Pre-Mixed 450 sq. ft." data-price="21.23" data-coverage="450">All-Purpose Pre-Mixed 450 sq. ft. — $21.23</option>
              <option value="20 Setting Sand 340 sq. ft." data-price="11.98" data-coverage="340">20 Setting Sand 340 sq. ft. — $11.98</option>
              <option value="45 Setting Sand 340 sq. ft." data-price="11.98" data-coverage="340">45 Setting Sand 340 sq. ft. — $11.98</option>
              <option value="All-Purpose Pre-Mixed 88 sq. ft." data-price="10.52" data-coverage="88">All-Purpose Pre-Mixed 88 sq. ft. — $10.52</option>
              <option value="5 Lightweight Setting Sand 340 sq. ft." data-price="11.98" data-coverage="340">5 Lightweight Setting Sand 340 sq. ft. — $11.98</option>
            </select>

            <label>Drywall Tape Type:</label>
            <select id="tape">
              <option value="none" data-price="0" data-length="0">None</option>
              <option value="Paper (250 ft.)" data-price="3.28" data-length="250">Paper (250 ft.) — $3.28</option>
              <option value="Paper (500 ft.)" data-price="5.98" data-length="500">Paper (500 ft.) — $5.98</option>
              <option value="Ultra Thin Self-Adhesive Mesh (180 ft.)" data-price="8.48" data-length="180">Ultra Thin Self-Adhesive Mesh (180 ft.) — $8.48</option>
              <option value="Self-Adhesive Mesh (300 ft.)" data-price="13.28" data-length="300">Self-Adhesive Mesh (300 ft.) — $13.28</option>
              <option value="Ultra Thin Self-Adhesive Mesh (300 ft.)" data-price="13.28" data-length="300">Ultra Thin Self-Adhesive Mesh (300 ft.) — $13.28</option>
              <option value="Mold Resistant Self-Adhesive Mesh (300 ft.)" data-price="13.28" data-length="300">Mold Resistant Self-Adhesive Mesh (300 ft.) — $13.28</option>
            </select>

            <div class="calculator-keys">
              <button onclick="calculateDrywall()">Calculate Materials</button>
            </div>

            <div class="results" id="results">
              <div class="muted">Enter your area and options, then click “Calculate Materials.”</div>
            </div>

            <div class="note">
              Notes: Calculations are estimates. Panel count uses your area plus waste. Seam length is required to calculate tape rolls.
            </div>

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
      function readNumber(id, fallback=0) {
        const v = parseFloat(document.getElementById(id).value);
        return isNaN(v) ? fallback : v;
      }

      function addWallsToArea() {
        const length = readNumber("wallLength");
        const height = readNumber("wallHeight");
        const walls  = Math.max(0, parseInt(document.getElementById("numWalls").value || "0", 10));
        const addArea = length * height * walls;

        const areaInput = document.getElementById("totalArea");
        const curr = parseFloat(areaInput.value) || 0;
        areaInput.value = (curr + addArea).toFixed(2);
      }

      function calculateDrywall() {
        // Inputs
        const baseArea = Math.max(0, readNumber("totalArea"));
        const wastePct = Math.max(0, readNumber("wastePct"));
        const seamLen  = Math.max(0, readNumber("seamLength"));

        const panelSel = document.getElementById("panelSize");
        const panelArea = parseFloat(panelSel.options[panelSel.selectedIndex].dataset.area); // sq ft per panel
        const panelLabel = panelSel.value;

        const thickness = document.getElementById("thickness").value;

        const typeSel = document.getElementById("dwType");
        const typeName = typeSel.value;
        const panelPrice = parseFloat(typeSel.options[typeSel.selectedIndex].dataset.price);

        const compSel = document.getElementById("compound");
        const compName = compSel.value;
        const compPrice = parseFloat(compSel.options[compSel.selectedIndex].dataset.price);
        const compCoverage = parseFloat(compSel.options[compSel.selectedIndex].dataset.coverage);

        const tapeSel = document.getElementById("tape");
        const tapeName = tapeSel.value;
        const tapePrice = parseFloat(tapeSel.options[tapeSel.selectedIndex].dataset.price);
        const tapeLenPerRoll = parseFloat(tapeSel.options[tapeSel.selectedIndex].dataset.length);

        // Adjusted area with waste/overage
        const adjustedArea = baseArea * (1 + wastePct / 100);

        // Panels
        const panelsNeeded = Math.ceil(adjustedArea / panelArea);
        const panelsCost = typeName === "none" ? 0 : (panelsNeeded * panelPrice);

        // Compound
        let compoundBuckets = 0, compoundCost = 0;
        if (compName !== "none" && compCoverage > 0) {
          compoundBuckets = Math.ceil(adjustedArea / compCoverage);
          compoundCost = compoundBuckets * compPrice;
        }

        // Tape
        let tapeRolls = 0, tapeCost = 0, tapeNote = "";
        if (tapeName !== "none" && tapeLenPerRoll > 0) {
          if (seamLen > 0) {
            tapeRolls = Math.ceil(seamLen / tapeLenPerRoll);
            tapeCost = tapeRolls * tapePrice;
          } else {
            tapeNote = "Add seam length (ft) to compute tape rolls.";
          }
        }

        // Totals
        const totalCost = panelsCost + compoundCost + tapeCost;

        // Render
        const results = document.getElementById("results");
        results.innerHTML = `
          <h4>Summary</h4>
          <div class="line"><span>Entered Area:</span><span>${baseArea.toFixed(2)} sq ft</span></div>
          <div class="line"><span>Waste / Overage:</span><span>${wastePct.toFixed(0)}%</span></div>
          <div class="line"><span>Adjusted Area:</span><span>${adjustedArea.toFixed(2)} sq ft</span></div>
          <hr>
          <h4>Materials</h4>
          <div class="line"><span>Drywall Panels (${panelLabel}, ${thickness}${thickness.endsWith('"')?'':'"'})</span><span>${panelsNeeded} pcs</span></div>
          <div class="line muted"><span>Type:</span><span>${typeName === "none" ? "—" : typeName}</span></div>
          <div class="line"><span>Panels Subtotal:</span><span class="price">${formatMoney(panelsCost)}</span></div>

          <div class="line" style="margin-top:8px;"><span>Joint Compound:</span><span>${compName === "none" ? "—" : compName}</span></div>
          ${compName === "none" ? "" : `
            <div class="line"><span>Coverage per unit:</span><span>${compCoverage} sq ft</span></div>
            <div class="line"><span>Units Needed:</span><span>${compoundBuckets}</span></div>
            <div class="line"><span>Compound Subtotal:</span><span class="price">${formatMoney(compoundCost)}</span></div>
          `}

          <div class="line" style="margin-top:8px;"><span>Tape:</span><span>${tapeName === "none" ? "—" : tapeName}</span></div>
          ${tapeName === "none" ? "" : (seamLen > 0 ? `
            <div class="line"><span>Seam Length:</span><span>${seamLen.toFixed(0)} ft</span></div>
            <div class="line"><span>Roll Length:</span><span>${tapeLenPerRoll} ft</span></div>
            <div class="line"><span>Rolls Needed:</span><span>${tapeRolls}</span></div>
            <div class="line"><span>Tape Subtotal:</span><span class="price">${formatMoney(tapeCost)}</span></div>
          ` : `<div class="muted" style="margin:4px 0 0;">${tapeNote}</div>`)}

          <hr>
          <div class="line"><span><strong>Estimated Total:</strong></span><span class="price"><strong>${formatMoney(totalCost)}</strong></span></div>
        `;
      }

      function formatMoney(n) {
        return n ? ('$' + n.toFixed(2)) : '$0.00';
      }
    </script>
  </body>
</html>
