<!DOCTYPE html>
<html lang="en">
<head>
  <title>Deck Calculator - Smart Choice Contractors</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Plan and estimate deck materials: surface, railing, stairs, and substructure.">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700">
  <link rel="stylesheet" href="css/style.css">
  <style>
    .calculator {
      max-width: 420px;
      margin: 40px auto;
      background: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      padding: 20px;
      text-align: left;
      font-family: Raleway, Arial, sans-serif;
    }
    .calculator h3 { text-align:center; margin:0 0 8px; font-weight:700; letter-spacing:.3px; }
    .subtle { color:#666; font-size:.9rem; margin-bottom:12px; line-height:1.35rem; }
    label { display:block; font-weight:600; margin-top:10px; margin-bottom:4px; }
    input, select {
      width:100%; height:44px; font-size:1rem; margin-bottom:8px; text-align:right;
      padding:8px; border:2px solid #ccc; border-radius:6px; background:#fff;
    }
    .two-col, .three-col { display:grid; gap:8px; }
    .two-col { grid-template-columns: 1fr 1fr; }
    .three-col { grid-template-columns: 1fr 1fr 1fr; }
    .calculator-keys { display:grid; grid-template-columns:1fr; gap:10px; margin-top:10px; }
    button {
      padding:12px; font-size:1rem; border:none; border-radius:6px;
      background:#007bff; color:#fff; cursor:pointer; transition:.2s;
    }
    button:hover { opacity:.9; }
    .results {
      margin-top:15px; font-size:.95rem; background:#fff; padding:12px;
      border-radius:6px; border:1px solid #ddd;
    }
    .results h4 { margin:0 0 8px 0; font-size:1.05rem; }
    .line { display:flex; justify-content:space-between; margin:4px 0; }
    .muted { color:#777; font-size:.9rem; }
    .note { font-size:.8rem; color:#666; margin-top:6px; }
    details summary {
      cursor:pointer; padding:8px 10px; background:#fff; border:1px solid #ddd;
      border-radius:6px; margin-bottom:8px; font-weight:600;
    }
    .price { font-weight:700; }
    .go-back-btn {
      display:block; width:100%; margin:16px auto 0; padding:12px;
      background:#ff5722; color:#fff; font-size:1.05rem; font-weight:700;
      text-align:center; border:none; border-radius:8px; cursor:pointer;
      box-shadow:0 4px 8px rgba(0,0,0,0.2); transition:background-color .3s ease;
    }
    .go-back-btn:hover { background:#e64a19; }
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
  <div class="page">
    <!-- Keep your existing header/nav includes if desired -->

    <section class="section-sm">
      <div class="container">
        <h2 class="text-uppercase text-center">Deck <span class="font-weight-light">Calculator</span></h2>

        <div class="calculator">
          <h3>Build Your Deck</h3>
          <div class="subtle">
            This tool will help you plan, estimate, and purchase materials to resurface or build a deck.
            Include openings (doors, stairs) in total dimensions as appropriate; waste/overage will be added.
          </div>

          <!-- SCOPE -->
          <label>What Do You Need?</label>
          <div class="two-col">
            <select id="needSurface">
              <option value="yes">Surface</option>
              <option value="no">Skip Surface</option>
            </select>
            <select id="needRailing">
              <option value="yes">Railing</option>
              <option value="no">Skip Railing</option>
            </select>
          </div>
          <div class="two-col">
            <select id="needStairs">
              <option value="yes">Stairs</option>
              <option value="no">Skip Stairs</option>
            </select>
            <select id="needSubstructure">
              <option value="yes">Substructure</option>
              <option value="no">Skip Substructure</option>
            </select>
          </div>

          <!-- MEASUREMENTS -->
          <label>Board Direction</label>
          <select id="boardDir">
            <option value="away">Away from House</option>
            <option value="along">Along the House</option>
          </select>

          <div class="three-col">
            <div>
              <label>Length (ft.) <span class="muted">(along the house)</span></label>
              <input type="number" id="lenFt" value="10" min="0" step="0.01">
            </div>
            <div>
              <label>Width (ft.) <span class="muted">(projects out)</span></label>
              <input type="number" id="widFt" value="6" min="0" step="0.01">
            </div>
            <div>
              <label>Height (ft.)</label>
              <input type="number" id="htFt" value="2" min="0" step="0.01">
            </div>
          </div>

          <div class="two-col">
            <div>
              <label>Number of Stair Sets</label>
              <input type="number" id="stairSets" value="0" min="0" step="1">
            </div>
            <div>
              <label>Waste / Overage (%)</label>
              <input type="number" id="wastePct" value="10" min="0" step="1">
            </div>
          </div>

          <!-- SURFACE OPTIONS -->
          <details open>
            <summary>Surface Options</summary>
            <div class="two-col">
              <div>
                <label>Deck Material</label>
                <select id="surfaceMaterial">
                  <option value="pt_54x6" data-priceLF="1.75" data-cap="no">Wood / PT 5/4×6 (no cap)</option>
                  <option value="cedar_54x6" data-priceLF="2.75" data-cap="no">Cedar 5/4×6 (no cap)</option>
                  <option value="comp_capped" data-priceLF="3.80" data-cap="yes">Composite (capped)</option>
                  <option value="comp_uncapped" data-priceLF="2.90" data-cap="no">Composite (uncapped)</option>
                  <option value="pvc_capped" data-priceLF="4.20" data-cap="yes">PVC (capped)</option>
                </select>
              </div>
              <div>
                <label>Board Length</label>
                <select id="boardLen">
                  <option value="12">12 ft</option>
                  <option value="16">16 ft</option>
                </select>
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Effective Board Width (in.)</label>
                <input type="number" id="boardWidthIn" value="5.5" step="0.01" min="1">
              </div>
              <div>
                <label>Gap (in.)</label>
                <input type="number" id="gapIn" value="0.125" step="0.01" min="0">
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Deck Screws per Joist Crossing</label>
                <input type="number" id="screwsPerCross" value="2" min="1" step="1">
              </div>
              <div>
                <label>Price per 1,000 Screws ($)</label>
                <input type="number" id="pricePer1000Screws" value="65" min="0" step="0.01">
              </div>
            </div>
          </details>

          <!-- SUBSTRUCTURE OPTIONS -->
          <details>
            <summary>Substructure Options</summary>
            <div class="two-col">
              <div>
                <label>Joist Spacing (in.)</label>
                <input type="number" id="joistOCin" value="16" min="8" step="1">
              </div>
              <div>
                <label>Max Joist Span (ft) <span class="muted">(for beam count)</span></label>
                <input type="number" id="joistSpanFt" value="10" min="4" step="0.5">
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Post Spacing (ft) <span class="muted">(along beams)</span></label>
                <input type="number" id="postSpacingFt" value="6" min="4" step="0.5">
              </div>
              <div>
                <label>Ledger at House</label>
                <select id="useLedger">
                  <option value="yes">Yes (attached)</option>
                  <option value="no">No (freestanding)</option>
                </select>
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Concrete Bags per Footing</label>
                <input type="number" id="bagsPerFooting" value="2" min="0" step="0.5">
              </div>
              <div>
                <label>Price per Bag ($)</label>
                <input type="number" id="pricePerBag" value="6.25" min="0" step="0.01">
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Joist Hanger Price ($)</label>
                <input type="number" id="priceHanger" value="2.15" min="0" step="0.01">
              </div>
              <div>
                <label>Joist-to-Beam Clip Price ($)</label>
                <input type="number" id="priceClip" value="1.35" min="0" step="0.01">
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Post Base Price ($)</label>
                <input type="number" id="pricePostBase" value="14.98" min="0" step="0.01">
              </div>
              <div>
                <label>Post Cap Price ($)</label>
                <input type="number" id="pricePostCap" value="12.48" min="0" step="0.01">
              </div>
            </div>
          </details>

          <!-- RAILING OPTIONS -->
          <details>
            <summary>Railing Options</summary>
            <div class="two-col">
              <div>
                <label>Railing Needed Perimeter (ft)</label>
                <input type="number" id="railPerimFt" value="0" min="0" step="0.1">
              </div>
              <div>
                <label>Exclude House Side?</label>
                <select id="excludeHouseSide">
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Railing Price per ft ($)</label>
                <input type="number" id="priceRailLF" value="45" min="0" step="0.01">
              </div>
              <div>
                <label>Railing Post Spacing (ft)</label>
                <input type="number" id="railPostOCft" value="6" min="4" step="0.5">
              </div>
            </div>
          </details>

          <!-- STAIR OPTIONS -->
          <details>
            <summary>Stair Options</summary>
            <div class="two-col">
              <div>
                <label>Stair Width (in.)</label>
                <input type="number" id="stairWidthIn" value="36" min="30" step="1">
              </div>
              <div>
                <label>Riser Height (in.)</label>
                <input type="number" id="riserIn" value="7.5" min="6.5" step="0.1">
              </div>
            </div>
            <div class="two-col">
              <div>
                <label>Boards per Tread</label>
                <input type="number" id="boardsPerTread" value="3" min="2" step="1">
              </div>
              <div>
                <label>Extra Stair Hardware ($/set)</label>
                <input type="number" id="priceStairHardware" value="45" min="0" step="0.01">
              </div>
            </div>
          </details>

          <div class="calculator-keys">
            <button onclick="calculateDeck()">Calculate Materials</button>
          </div>

          <div class="results" id="results">
            <div class="muted">Enter your measurements & options, then click “Calculate Materials.”</div>
          </div>

          <div class="note">
            <strong>Assumptions:</strong> House runs along “Length”. “Away from House” means boards run lengthwise (joists span Width).
            Joist hangers are at the ledger; joist-to-beam clips used at beams. Posts under each beam at the chosen spacing.
            Quantities are estimates—verify to local code and Simpson specs before purchase.
          </div>

          <button class="go-back-btn" onclick="history.back()">← Go Back</button>
        </div>
      </div>
    </section>
  </div>

  <script>
    function n(id, def=0){ const v=parseFloat(document.getElementById(id).value); return isNaN(v)?def:v; }
    function val(id){ return document.getElementById(id).value; }
    function money(x){ return '$' + (x||0).toFixed(2); }

    function calculateDeck(){
      // Scope
      const needSurface = val('needSurface')==='yes';
      const needRailing = val('needRailing')==='yes';
      const needStairs  = val('needStairs')==='yes';
      const needSub     = val('needSubstructure')==='yes';

      // Geometry
      const L = n('lenFt');     // along house
      const W = n('widFt');     // projects out
      const H = n('htFt');      // height for stairs
      const wastePct = Math.max(0,n('wastePct'))/100;
      const dir = val('boardDir'); // 'away' or 'along'

      // Surface parameters
      const matSel  = document.getElementById('surfaceMaterial');
      const priceLF = parseFloat(matSel.options[matSel.selectedIndex].dataset.pricelf || '0');
      const boardLen = n('boardLen'); // feet
      const boardWidthIn = n('boardWidthIn');
      const gapIn = n('gapIn');
      const screwsPerCross = Math.max(1, n('screwsPerCross'));
      const pricePer1000Screws = n('pricePer1000Screws');

      // Substructure parameters
      const joistOCin = n('joistOCin');
      const joistSpanFt = n('joistSpanFt'); // projection per beam
      const postSpacingFt = n('postSpacingFt');
      const useLedger = val('useLedger')==='yes';
      const bagsPerFooting = n('bagsPerFooting');
      const pricePerBag = n('pricePerBag');
      const priceHanger = n('priceHanger');
      const priceClip = n('priceClip');
      const pricePostBase = n('pricePostBase');
      const pricePostCap = n('pricePostCap');

      // Railing
      let railPerimFt = n('railPerimFt');
      if (!railPerimFt){
        // auto-calc if not provided: exclude house length by default, minus stairs (3 ft opening each)
        const stairSets = Math.max(0, parseInt(document.getElementById('stairSets').value||'0',10));
        const stairOpeningFt = 3 * stairSets;
        const excludeHouse = val('excludeHouseSide')==='yes';
        railPerimFt = (L*2 + W*2) - (excludeHouse ? L : 0) - stairOpeningFt;
        railPerimFt = Math.max(0, railPerimFt);
      }
      const priceRailLF = n('priceRailLF');
      const railPostOCft = n('railPostOCft');

      // Stairs
      const stairSets = Math.max(0, parseInt(document.getElementById('stairSets').value||'0',10));
      const stairWidthIn = n('stairWidthIn');
      const riserIn = n('riserIn');
      const boardsPerTread = Math.max(2, n('boardsPerTread'));
      const priceStairHardware = n('priceStairHardware');

      // --- SURFACE MATH ---
      let surface = { boards:0, boardPieces:0, screws:0, costBoards:0, costScrews:0 };
      if (needSurface){
        const effIn = boardWidthIn + gapIn; // effective course width
        // Boards run:
        // 'away' => boards run along L (parallel to house), joists span W.
        // 'along' => boards run along W, joists span L.
        const span = (dir==='away') ? L : W;          // board span length for each piece (ft)
        const runAcross = (dir==='away') ? W : L;     // total run perpendicular (ft)
        const rows = Math.ceil( (runAcross*12) / effIn ); // number of board rows
        const piecesPerRow = Math.ceil(span / boardLen);  // boards per row given stock length
        const boardPiecesRaw = rows * piecesPerRow;
        const boardPieces = Math.ceil(boardPiecesRaw * (1 + wastePct));
        const lfPerPiece = boardLen; // linear feet per stock piece
        const totalLF = boardPieces * lfPerPiece;
        const costBoards = totalLF * priceLF;

        // Screws: each board crosses joists; joist count depends on joist spacing
        const joistSpan = (dir==='away') ? W : L; // joists span perpendicular to board direction
        const joistsAlong = Math.floor(((dir==='away') ? L : W) * 12 / joistOCin) + 1; // joist lines
        const crossesPerPiece = Math.floor((joistSpan*12)/joistOCin) + 1;
        const screws = boardPieces * crossesPerPiece * screwsPerCross;
        const boxes = screws/1000;
        const costScrews = boxes * pricePer1000Screws;

        surface = { rows, piecesPerRow, boardPieces, totalLF, screws: Math.ceil(screws), costBoards, costScrews };
      }

      // --- SUBSTRUCTURE MATH ---
      let sub = { beams:0, posts:0, footings:0, hangers:0, clips:0, bags:0, costConcrete:0, costHanger:0, costClip:0, costBase:0, costCap:0, joists:0 };
      if (needSub){
        // Joists run perpendicular to deck boards
        const joistRunLen = (dir==='away') ? W : L;            // joist span length (ft)
        const joistsCount = Math.floor(((dir==='away') ? L : W) * 12 / joistOCin) + 1;

        // Beams: number required across projection (W is projection from house)
        const projection = W;                      // assume house along Length L
        const beamsNeeded = Math.ceil(projection / joistSpanFt); // 1 outer beam if projection <= span
        // If using ledger, first support is the ledger; else add one more beam at house side
        const actualBeams = useLedger ? beamsNeeded : Math.max(1, beamsNeeded + 1);

        // Posts per beam
        const postsPerBeam = Math.max(2, Math.ceil(L / postSpacingFt) + 1); // endpoints included
        const posts = actualBeams * postsPerBeam;

        // Footings = posts
        const footings = posts;
        const bags = Math.ceil(footings * bagsPerFooting);
        const costConcrete = bags * pricePerBag;

        // Hardware (approx):
        // - Hangers: 1 per joist at ledger (if attached) + 0 at beam (assuming joists sit on beam). If freestanding, hangers both ends -> 2/joist.
        const hangers = useLedger ? joistsCount : (joistsCount * 2);
        const costHanger = hangers * priceHanger;

        // - Joist-to-beam clips: each joist meets each non-ledger beam
        const beamInterfaces = useLedger ? (actualBeams - 1) : actualBeams; // beams under joists
        const clips = Math.max(0, joistsCount * beamInterfaces);
        const costClip = clips * priceClip;

        // - Post bases & caps: one each per post
        const costBase = posts * pricePostBase;
        const costCap = posts * pricePostCap;

        sub = {
          beams: actualBeams, posts, footings, bags, costConcrete,
          hangers, costHanger, clips, costClip, costBase, costCap,
          joists: joistsCount, joistRunLen
        };
      }

      // --- RAILING MATH ---
      let rail = { lf:0, posts:0, cost:0 };
      if (needRailing){
        const lf = Math.max(0, n('railPerimFt') || 0);
        const posts = lf>0 ? Math.ceil(lf / n('railPostOCft')) + 1 : 0;
        const cost = lf * n('priceRailLF');
        rail = { lf, posts, cost };
      }

      // --- STAIRS MATH ---
      let stairs = { sets: stairSets, risers:0, treads:0, stringers:0, treadPieces:0, costBoards:0, costHardware:0 };
      if (needStairs && stairSets>0){
        const totalRiseIn = H*12;
        const risersPerSet = Math.ceil(totalRiseIn / riserIn);
        const treadsPerSet = Math.max(0, risersPerSet - 1);
        const stringersPerSet = Math.max(2, Math.ceil(stairWidthIn / 16) ); // ~16" o.c.
        // Tread boards: boardsPerTread courses, each course uses a piece equal to stair width (we'll count by linear feet)
        // Convert 36" piece to linear feet: 3 ft per board per tread row
        const treadLFPerSet = treadsPerSet * boardsPerTread * (stairWidthIn/12);
        const treadPiecesPerSet = treadsPerSet * boardsPerTread; // count of cut pieces
        const totalTreadLF = treadLFPerSet * stairSets;
        const costBoards = totalTreadLF * priceLF; // same surface material pricing
        const costHardware = stairSets * n('priceStairHardware');

        stairs = {
          sets: stairSets,
          risers: risersPerSet * stairSets,
          treads: treadsPerSet * stairSets,
          stringers: stringersPerSet * stairSets,
          treadPieces: treadPiecesPerSet * stairSets,
          costBoards, costHardware
        };
      }

      // Totals
      const surfaceSubtotal = needSurface ? (surface.costBoards + surface.costScrews) : 0;
      const subSubtotal = needSub ? (sub.costConcrete + sub.costHanger + sub.costClip + sub.costBase + sub.costCap) : 0;
      const railSubtotal = needRailing ? rail.cost : 0;
      const stairSubtotal = (needStairs && stairSets>0) ? (stairs.costBoards + stairs.costHardware) : 0;
      const grandTotal = surfaceSubtotal + subSubtotal + railSubtotal + stairSubtotal;

      // Render
      const el = document.getElementById('results');
      el.innerHTML = `
        <h4>Summary</h4>
        <div class="line"><span>Deck Size (L×W):</span><span>${L.toFixed(2)} ft × ${W.toFixed(2)} ft</span></div>
        <div class="line"><span>Board Direction:</span><span>${dir==='away'?'Away from House':'Along the House'}</span></div>
        <div class="line"><span>Waste / Overage:</span><span>${(wastePct*100).toFixed(0)}%</span></div>

        ${needSurface ? `
        <hr>
        <h4>Surface</h4>
        <div class="line"><span>Deck Boards:</span><span>${surface.boardPieces} pcs (${surface.totalLF.toFixed(1)} LF)</span></div>
        <div class="line"><span>Deck Screws:</span><span>${surface.screws.toLocaleString()} pcs</span></div>
        <div class="line"><span>Boards Subtotal:</span><span class="price">${money(surface.costBoards)}</span></div>
        <div class="line"><span>Screws Subtotal:</span><span class="price">${money(surface.costScrews)}</span></div>
        ` : ''}

        ${needSub ? `
        <hr>
        <h4>Substructure</h4>
        <div class="line"><span>Joists:</span><span>${sub.joists} pcs (span ~ ${sub.joistRunLen.toFixed(1)} ft)</span></div>
        <div class="line"><span>Beams:</span><span>${sub.beams} run(s)</span></div>
        <div class="line"><span>Posts / Footings:</span><span>${sub.posts} / ${sub.footings}</span></div>
        <div class="line"><span>Joist Hangers:</span><span>${sub.hangers} pcs</span></div>
        <div class="line"><span>Joist-to-Beam Clips:</span><span>${sub.clips} pcs</span></div>
        <div class="line"><span>Concrete Bags:</span><span>${sub.bags} bag(s)</span></div>
        <div class="line"><span>Concrete Subtotal:</span><span class="price">${money(sub.costConcrete)}</span></div>
        <div class="line"><span>Hangers Subtotal:</span><span class="price">${money(sub.costHanger)}</span></div>
        <div class="line"><span>Clips Subtotal:</span><span class="price">${money(sub.costClip)}</span></div>
        <div class="line"><span>Post Bases Subtotal:</span><span class="price">${money(sub.costBase)}</span></div>
        <div class="line"><span>Post Caps Subtotal:</span><span class="price">${money(sub.costCap)}</span></div>
        ` : ''}

        ${needRailing ? `
        <hr>
        <h4>Railing</h4>
        <div class="line"><span>Railing Length:</span><span>${rail.lf.toFixed(1)} ft</span></div>
        <div class="line"><span>Railing Posts (est):</span><span>${rail.posts} pcs</span></div>
        <div class="line"><span>Railing Subtotal:</span><span class="price">${money(rail.cost)}</span></div>
        ` : ''}

        ${(needStairs && stairSets>0) ? `
        <hr>
        <h4>Stairs</h4>
        <div class="line"><span>Sets:</span><span>${stairs.sets}</span></div>
        <div class="line"><span>Risers / Treads:</span><span>${stairs.risers} / ${stairs.treads}</span></div>
        <div class="line"><span>Stringers (est):</span><span>${stairs.stringers}</span></div>
        <div class="line"><span>Tread Pieces (cut):</span><span>${stairs.treadPieces}</span></div>
        <div class="line"><span>Tread Boards Subtotal:</span><span class="price">${money(stairs.costBoards)}</span></div>
        <div class="line"><span>Stair Hardware Subtotal:</span><span class="price">${money(stairs.costHardware)}</span></div>
        ` : ''}

        <hr>
        <div class="line"><span><strong>Estimated Total:</strong></span><span class="price"><strong>${money(grandTotal)}</strong></span></div>
      `;
    }
  </script>
</body>
</html>
