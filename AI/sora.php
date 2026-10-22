<?php
// Smart Choice Prompt Generator – PHP single-file app (v4.1)
// Changes in 4.1:
// - Auto-uncheck "Add Price to prompt" whenever Español/English buttons are pressed.
// - Stronger single-language directives so Sora honors selected language only.
// - Default Scene text set to the exact line requested (painting luxury home).
// - Subject switching now normalizes/removes any old subjects and keeps a single (Subjects: …).
// - Re-entry guard on Spanish translation button to avoid glitching.
// - Layout/colors/styles preserved from v4.
//
// PIN gate
$PIN = '1976';
session_start();
if (isset($_POST['pin'])) {
  if (trim($_POST['pin']) === $PIN) {
    $_SESSION['scp_auth'] = true;
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
  } else { $err = 'Invalid PIN'; }
}
$authed = !empty($_SESSION['scp_auth']);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Choice Prompt Generator</title>
<style>
:root{
  --bg:#ffffff; --card:#ffffff; --ink:#000000; --muted:#333333;
  --accent:#169179; --border:#dddddd; --danger:#ff6b6b; --spanish:#ffa94d;
}
*{box-sizing:border-box}
body{margin:0;background:#ffffff;color:var(--ink);font:16px/1.45 system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial}
header{padding:20px;text-align:center; position:relative}
header h1{margin:0 0 6px;font-weight:800;letter-spacing:.3px;color:#000}
header p{margin:0;color:#000}
.app{max-width:1300px;margin:0 auto;padding:0 16px 60px}
.layout{display:grid;grid-template-columns:280px 1fr;gap:16px}
@media (max-width: 1000px){.layout{grid-template-columns:1fr}}
.card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:14px;box-shadow:0 10px 30px rgba(0,0,0,.05);color:#000}
.card h2{margin:0 0 10px;font-size:16px;color:#000}
label{display:block;font-weight:600;margin:10px 0 6px;color:#000}
input[type="text"], input[type="tel"], input[type="color"], input[type="password"], textarea, select{
  width:100%;background:#ffffff;border:1px solid var(--border);color:#000;padding:10px 12px;border-radius:12px;outline:none
}
textarea{min-height:120px;resize:vertical}
.row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
.controls{display:flex;flex-wrap:wrap;gap:10px;margin-top:12px}
button{appearance:none;border:1px solid var(--border);background:#f6f8fa;color:#000;padding:10px 14px;border-radius:12px;font-weight:700;cursor:pointer}
button.primary{background:var(--accent);border-color:#117664;color:#000}
button.warn{background:transparent;border-color:var(--danger);color:#000}
button.spanish{background:var(--spanish);border-color:#e68a00;color:#000}
.footer-note{color:#000;font-size:12px;margin-top:10px}
.muted{color:#000;font-size:12px}
.list{display:flex;flex-direction:column;gap:10px;max-height:70vh;overflow:auto}
.item{border:1px solid var(--border);background:#ffffff;border-radius:12px;padding:10px;display:flex;align-items:flex-start;gap:8px;color:#000}
.item-main{flex:1;min-width:0;color:#000}
.item h4{margin:0 0 4px;font-size:14px;color:#000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.item .meta{color:#000;font-size:12px;margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.item .actions{display:flex;gap:8px}
.left-col .controls{justify-content:space-between}
.pill{display:inline-flex;align-items:center;gap:6px;background:#ffffff;border:1px solid var(--border);padding:6px 8px;border-radius:999px;color:#000;font-size:12px}
.align{height:88px}
.trade-input{font-weight:800;color:#000}
.stretch{width:100%}
footer{margin-top:28px;padding:18px;text-align:center;color:#000}
footer .line{opacity:.85;color:#000}

/* dropdown multiselect */
.multidrop{position:relative;user-select:none}
.multidrop .button{display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:12px;background:#ffffff;border:1px solid var(--border);cursor:pointer;color:#000}
.multidrop .button .label{color:#000}
.multidrop .menu{position:absolute;left:0;right:0;top:calc(100% + 8px);background:#ffffff;border:1px solid var(--border);border-radius:10px;padding:8px;z-index:30;box-shadow:0 8px 20px rgba(0,0,0,.08);max-height:220px;overflow:auto;display:none}
.multidrop.open .menu{display:block}
.multidrop .menu label{display:flex;align-items:center;gap:8px;padding:6px;border-radius:8px;cursor:pointer;color:#000}

/* subjects chips */
.subjects{display:flex;flex-wrap:wrap;gap:8px}
.subjects label{display:inline-flex;align-items:center;gap:6px;background:#ffffff;border:1px solid var(--border);padding:6px 8px;border-radius:999px;color:#000;font-size:12px}

/* output */
textarea#output{min-height:220px;resize:vertical;white-space:pre-wrap;color:#000;background:#ffffff}

/* $ prefix input */
.prefix-wrap{position:relative}
.prefix-wrap .prefix{position:absolute;left:12px;top:50%;transform:translateY(-50%);pointer-events:none;color:#000}
.prefix-wrap input{padding-left:28px}

/* Language slider in header (top-right) */
.lang-toggle{position:absolute; right:16px; top:16px; display:flex; align-items:center; gap:10px;}
.switch{position:relative; display:inline-block; width:74px; height:34px;}
.switch input{display:none}
.slider{position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:#e6e6e6; border-radius:34px; border:1px solid var(--border);}
.slider:before{position:absolute; content:"ES"; height:28px; width:34px; left:3px; top:2px; background:white; border-radius:999px; display:flex; align-items:center; justify-content:center; font-weight:800; transition:transform .2s ease;}
input:checked + .slider:before{content:"EN"; transform:translateX(37px);}
</style>
</head>
<body>
<?php if(!$authed): ?>
  <header>
    <h1>Smart Choice Prompt Generator — Login</h1>
    <p>Enter your PIN to access the generator.</p>
  </header>
  <div class="app">
    <section class="card" style="max-width:520px;margin:0 auto;">
      <form method="post">
        <label for="pin">PIN</label>
        <input type="password" id="pin" name="pin" placeholder="Enter PIN" autofocus>
        <?php if(isset($err)): ?><div class="muted" style="color:#ff6b6b;"><?=htmlspecialchars($err)?></div><?php endif; ?>
        <div class="controls"><button class="primary" type="submit">Unlock</button></div>
        <div class="muted">Tip: Default PIN is <strong>1976</strong>. You can edit it at the top of this file.</div>
      </form>
    </section>
  </div>
  <footer>
    <div class="line">Design & Created &copy; Harold Cabrera 2025 • (727) 755-3786 • justsmartchoice.com</div>
    <div class="line">16663 US Hwy 41, Spring Hill, Florida 34608</div>
  </footer>
<?php else: ?>
  <header>
    <div class="lang-toggle">
      <span id="langLabel">ES</span>
      <label class="switch">
        <!-- unchecked = ES (default), checked = EN -->
        <input id="langSwitch" type="checkbox">
        <span class="slider"></span>
      </label>
    </div>
    <h1 id="hdrTitle">Smart Choice Prompt Generator</h1>
    <p id="hdrSub">Generate consistent, brand-safe prompts for video or picture. Save, edit, and delete prompts from the left menu.</p>
  </header>

  <div class="app">
    <div class="layout">
      <!-- LEFT MENU -->
      <aside class="card left-col">
        <h2 id="savedHdr">Saved Prompts</h2>
        <div class="controls">
          <button class="primary" id="newPrompt">New</button>
          <button id="saveNew">Save New</button>
          <button id="updateCurrent">Update</button>
        </div>
        <div class="muted" id="savedHelp">Click an item to load it. Use the delete button to remove.</div>
        <div id="promptList" class="list"></div>
      </aside>

      <!-- MAIN AREA -->
      <main>
        <section class="card">
          <h2 id="inputsHdr">Prompt Inputs</h2>

          <div class="row">
            <div>
              <label id="mediaLbl">Media</label>
              <div class="pill"><input type="radio" name="media" id="mediaVideo" value="video" checked> <span id="mediaVideoTxt">Video</span></div>
              <div class="pill"><input type="radio" name="media" id="mediaPicture" value="picture"> <span id="mediaPictureTxt">Picture</span></div>
              <div class="muted" id="mediaHint">Video enforces continuous installation action for the full duration.</div>
            </div>
            <div>
              <label for="preset" id="presetLbl">Preset</label>
              <select id="preset">
                <option value="">— None (custom) —</option>
                <option value="kitchen">Kitchen Installation</option>
                <option value="painting">Painting Luxury Home</option>
                <option value="fence">Vinyl Fence Installation</option>
                <option value="panel">Main Electrical Panel Replacement</option>
                <option value="tesla">Tesla Car Charger Installation</option>
                <option value="slab">Concrete Slab Pour</option>
                <option value="door">Front Door Installation</option>
                <option value="windows">Double Vinyl Window Installation</option>
                <option value="floor">Wood Floor Installation</option>
              </select>
            </div>
          </div>

          <label for="trade" id="tradeLbl">Trade / Service</label>
          <input id="trade" class="trade-input" type="text" placeholder="e.g., Gutters (auto-updates text across the prompt)">

          <!-- Custom extra description -->
          <label for="extraDesc" id="extraDescLbl">Custom Extra Description (optional)</label>
          <input id="extraDesc" type="text" placeholder="Add anything else you want to include in the scene/prompt">

          <div class="muted" id="tradeHelp">Typing here will adapt the scene/slogan to your trade across the prompt.</div>

          <label for="scene" id="sceneLbl">Scene details</label>
          <textarea id="scene" placeholder="Describe the Florida luxury setting and what the workers are doing."></textarea>

          <!-- Subjects -->
          <label id="subjHdr">Subjects / Who is in the video or picture?</label>
          <div class="subjects" id="subjectsBox">
            <label><input type="radio" name="subjectOne" class="subjectRad" value="Woman employee"> <span class="i18n" data-en="Woman employee" data-es="Empleado mujer">Woman employee</span></label>
            <label><input type="radio" name="subjectOne" class="subjectRad" value="Woman customer"> <span class="i18n" data-en="Woman customer" data-es="Cliente mujer">Woman customer</span></label>
            <label><input type="radio" name="subjectOne" class="subjectRad" value="Man customer"> <span class="i18n" data-en="Man customer" data-es="Cliente hombre">Man customer</span></label>
            <label><input type="radio" name="subjectOne" class="subjectRad" value="Couple employees"> <span class="i18n" data-en="Couple employees" data-es="Pareja de empleados">Couple employees</span></label>
            <label><input type="radio" name="subjectOne" class="subjectRad" value="Couple customers"> <span class="i18n" data-en="Couple customers" data-es="Pareja de clientes">Couple customers</span></label>
            <label><input type="radio" name="subjectOne" class="subjectRad" value="Couple woman"> <span class="i18n" data-en="Couple woman" data-es="Pareja de mujeres">Couple woman</span></label>
            <label><input type="radio" name="subjectOne" class="subjectRad" value="Workers" checked> <span class="i18n" data-en="Workers" data-es="Trabajadores">Workers</span></label>
          </div>

          <label for="slogan" id="sloganLbl">Slogan (first line)</label>
          <input id="slogan" type="text" placeholder="TRUSTED [TRADE] — [BENEFIT]">

          <div class="row-3">
            <div>
              <label for="phone" id="phoneLbl">Phone number text</label>
              <input id="phone" type="text" value="CALL NOW 727 755-3786">
              <label class="muted"><input id="lockPhone" type="checkbox" checked> <span id="lockPhoneTxt">Lock exact phone text</span></label>

              <!-- Price + Unit -->
              <label class="muted"><input id="addPrice" type="checkbox" checked> <span id="addPriceTxt">Add Price to prompt</span></label>
              <div class="row" style="gap:8px;margin-top:6px">
                <div class="prefix-wrap">
                  <span class="prefix">$</span>
                  <input id="price" type="text" inputmode="decimal" placeholder="0.00">
                </div>
                <div>
                  <select id="unit">
                    <option value="Linear ft">Linear ft</option>
                    <option value="Square ft">Square ft</option>
                    <option value="Yard">Yard</option>
                  </select>
                </div>
              </div>

              <label class="muted"><input id="addWebsite" type="checkbox" checked> <span id="addWebTxt">Add Website (default below)</span></label>
              <input id="website" type="text" value="https://justsmartchoice.com/">
            </div>

            <div>
              <label for="brandColor" id="brandColorLbl">Phone banner color</label>
              <input id="brandColor" type="text" value="#169179">

              <label class="muted" style="margin-top:10px;"><input id="cartoonMode" type="checkbox"> <span id="cartoonTxt">Cartoon/Animation (Sora)</span></label>

              <!-- extra styles -->
              <label class="muted"><input id="styleFuturistic" type="checkbox"> <span class="i18n" data-en="Futuristic / Tech" data-es="Futurista / Tech">Futuristic / Tech</span></label>
              <label class="muted"><input id="styleMinimal" type="checkbox"> <span class="i18n" data-en="Minimalist / Flat commercial" data-es="Minimalista / Comercial plano">Minimalist / Flat commercial</span></label>
              <label class="muted"><input id="styleIsometric" type="checkbox"> <span class="i18n" data-en="Isometric 3D product" data-es="Producto 3D isométrico">Isometric 3D product</span></label>
              <label class="muted"><input id="styleNeon" type="checkbox"> <span class="i18n" data-en="Neon Glow / Modern ad" data-es="Brillo neón / Anuncio moderno">Neon Glow / Modern ad</span></label>

              <label class="muted"><input id="specialOffer" type="checkbox"> <span id="specialOfferTxt">Add Special offer badge</span></label>

              <label class="muted"><input id="useBackground" type="checkbox"> <span id="bgTxt">Add Background Picture</span></label>
              <div id="bgPickerRow" class="row" style="gap:8px;margin-top:6px; display:none">
                <input id="bgFile" type="file" accept="image/*">
                <div id="bgPreview" class="muted" style="font-size:12px;">No file chosen</div>
              </div>
            </div>

            <div>
              <label for="logoPos" id="logoPosLbl">Logo position</label>
              <select id="logoPos">
                <option value="top-right" selected>Top-right</option>
                <option value="top-left">Top-left</option>
                <option value="bottom-right">Bottom-right</option>
                <option value="bottom-left">Bottom-left</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div>
              <label for="uniform" id="uniformLbl">Uniform description</label>
              <input id="uniform" type="text" value="caqui pants, black polo t-shirt with an orange stripe on the side and black hat with the same stripe; company logo on the back of the polo and on the front right top corner">
            </div>
            <div>
              <label for="textRules" id="textRulesHdr">Text positioning (multi-select)</label>
              <div id="textRulesDrop" class="multidrop">
                <div class="button" id="textRulesBtn"><span class="label">JUSTIFIED • CENTERED</span><span class="caret">▾</span></div>
                <div class="menu" id="textRulesMenu">
                  <label><input type="checkbox" value="JUSTIFIED" checked> JUSTIFIED</label>
                  <label><input type="checkbox" value="CENTERED" checked> CENTERED</label>
                  <label><input type="checkbox" value="LEFT"> LEFT</label>
                  <label><input type="checkbox" value="RIGHT"> RIGHT</label>
                  <label><input type="checkbox" value="TOP"> TOP</label>
                  <label><input type="checkbox" value="MIDDLE"> MIDDLE</label>
                  <label><input type="checkbox" value="BOTTOM"> BOTTOM</label>
                </div>
              </div>
              <select id="textRules" class="align" multiple style="display:none;">
                <option value="JUSTIFIED" selected>JUSTIFIED</option>
                <option value="CENTERED" selected>CENTERED</option>
                <option value="LEFT">LEFT</option>
                <option value="RIGHT">RIGHT</option>
                <option value="TOP">TOP</option>
                <option value="MIDDLE">MIDDLE</option>
                <option value="BOTTOM">BOTTOM</option>
              </select>
              <div class="muted" id="textRulesHint">Click the dropdown and pick multiple options with the mouse.</div>
            </div>
          </div>

          <div class="row">
            <div>
              <label for="sloganFont" id="sloganFontLbl">Slogan font</label>
              <select id="sloganFont">
                <option value="Impact" selected>Impact</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Tahoma">Tahoma</option>
              </select>
            </div>
            <div>
              <label for="phoneFont" id="phoneFontLbl">Phone line font</label>
              <select id="phoneFont">
                <option value="Impact" selected>Impact</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Tahoma">Tahoma</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div>
              <label for="brand" id="brandLbl">Brand / Logo name</label>
              <input id="brand" type="text" value="Smart Choice">
            </div>
            <div>
              <label for="duration" id="durationLbl">Duration (for video)</label>
              <input id="duration" type="text" value="30-second video suitable for META ads">
              <div class="muted" id="durationHint">Video requires continuous installation action for the full duration.</div>
            </div>
          </div>

          <div class="controls">
            <button class="primary" id="gen">Generate Prompt</button>
            <button class="spanish" id="toSpanish">Español</button>
            <button id="toEnglish" style="display:none">English</button>
            <button id="copy">Copy</button>
            <button id="saveQuick">Save</button>
          </div>
        </section>

        <section class="card">
          <h2 id="outHdr">Generated Prompt (ready for Copy)</h2>
          <textarea id="output" placeholder="Your Sora prompt will appear here..." readonly></textarea>
          <div class="footer-note" id="footerNote">Enforces: ALL CAPS, selected fonts, selected positioning, logo overlay + on-shirt, phone on #169179 banner, highest quality, exact scope with no text/number changes. Video uses full-duration installation action.</div>
        </section>
      </main>
    </div>
  </div>

  <footer>
    <div class="line">Design & Created &copy; Harold Cabrera 2025 • (727) 755-3786 • justsmartchoice.com</div>
    <div class="line">16663 US Hwy 41, Spring Hill, Florida 34608</div>
  </footer>
<?php endif; ?>

<?php if($authed): ?>
<script>
// ===== Utilities =====
const $ = id => document.getElementById(id);
const QS = (s,root=document) => root.querySelector(s);
const QSA = (s,root=document) => Array.from(root.querySelectorAll(s));

const LS_KEY = 'scp_prompts_v4_1';
let CURRENT_ID = null;
let LAST_TRADE = '';
let ORIGINAL_ENGLISH_SCENE = '';
let CURRENT_SUBJECT = 'Workers';
// Default language: ES
let CURRENT_LANG = 'ES';

// Background image state
let BG_IMAGE_NAME = '';
let BG_IMAGE_DATA = '';

// prevent re-entry on translate
let TRANSLATING = false;

// ===== Presets (unchanged) =====
const PRESETS = {
  kitchen:{trade:'Kitchen Installation', scene:'Show a magazine-quality modern kitchen with two contemporary islands in warm tones. Highlight the finishes, handleless island, and elegant details. Two men are installing a kitchen cabinet.', slogan:'TRUSTED KITCHEN INSTALLATION — AFFORDABLE PRICING'},
  painting:{trade:'Painting Luxury Home', scene:'Show a one-million-dollar Florida luxury home with tropical landscaping. Uniformed workers are painting the exterior with professional tools and precision.', slogan:'TRUSTED PAINTING FOR LUXURY HOMES'},
  fence:{trade:'Vinyl Fence Installation', scene:'Show a residential Florida backyard where two men are installing a vinyl fence section. Emphasize durability, precise alignment, and a clean, durable finish.', slogan:'TRUSTED FENCE INSTALLATION — BUILT TO LAST'},
  panel:{trade:'Main Electrical Panel Replacement', scene:'Show one licensed electrician replacing a main electrical panel inside a home. Emphasize safety, code compliance, and neat wiring.', slogan:'TRUSTED ELECTRICAL INSTALLATION — SAFE & RELIABLE'},
  tesla:{trade:'Tesla Car Charger Installation', scene:'Show a modern Florida home garage where a worker installs a Tesla wall charger. Emphasize clean routing, neat mounting, and reliable power.', slogan:'TRUSTED TESLA CHARGER INSTALLATION — FAST & RELIABLE'},
  slab:{trade:'Concrete Slab Pour', scene:'Show two men pouring and leveling cement for a backyard concrete slab. Emphasize preparation, reinforcement, and a smooth, long-lasting finish.', slogan:'TRUSTED CONCRETE SLAB INSTALLATION — BUILT TO LAST'},
  door:{trade:'Front Door Installation', scene:'Show two men installing an elegant front door at a Florida luxury home. Emphasize perfect fit, weather sealing, and enhanced security.', slogan:'TRUSTED FRONT DOOR INSTALLATION — ELEGANCE & SECURITY'},
  windows:{trade:'Double Vinyl Window Installation', scene:'Show two men installing double-pane vinyl windows on a Florida home. Emphasize energy efficiency, clean caulking, and precise alignment.', slogan:'TRUSTED WINDOW INSTALLATION — ENERGY SAVING & DURABLE'},
  floor:{trade:'Wood Floor Installation', scene:'Show two men installing wood flooring inside a stylish Florida home. Highlight seamless fitting, precision cutting, and a polished finish.', slogan:'TRUSTED WOOD FLOOR INSTALLATION — BEAUTY & DURABILITY'}
};

// ===== i18n for full UI =====
const UI = {
  EN: {
    hdrTitle: "Smart Choice Prompt Generator",
    hdrSub: "Generate consistent, brand-safe Sora prompts for video or picture. Save, edit, and delete prompts from the left menu.",
    savedHdr: "Saved Prompts",
    savedHelp: "Click an item to load it. Use the delete button to remove.",
    inputsHdr: "Prompt Inputs",
    mediaLbl: "Media",
    mediaVideoTxt: "Video",
    mediaPictureTxt: "Picture",
    mediaHint: "Video enforces continuous installation action for the full duration.",
    presetLbl: "Preset",
    tradeLbl: "Trade / Service",
    extraDescLbl: "Custom Extra Description (optional)",
    tradeHelp: "Typing here will adapt the scene/slogan to your trade across the prompt.",
    sceneLbl: "Scene details",
    subjHdr: "Subjects / Who is in the video or picture?",
    sloganLbl: "Slogan (first line)",
    phoneLbl: "Phone number text",
    lockPhoneTxt: "Lock exact phone text",
    addPriceTxt: "Add Price to prompt",
    addWebTxt: "Add Website (default below)",
    brandColorLbl: "Phone banner color",
    cartoonTxt: "Cartoon/Animation (Sora)",
    specialOfferTxt: "Add Special offer badge",
    bgTxt: "Add Background Picture",
    logoPosLbl: "Logo position",
    uniformLbl: "Uniform description",
    textRulesHdr: "Text positioning (multi-select)",
    textRulesHint: "Click the dropdown and pick multiple options with the mouse.",
    sloganFontLbl: "Slogan font",
    phoneFontLbl: "Phone line font",
    brandLbl: "Brand / Logo name",
    durationLbl: "Duration (for video)",
    durationHint: "Video requires continuous installation action for the full duration.",
    outHdr: "Generated Prompt (ready for Sora)",
    outPlaceholder: "Your Sora prompt will appear here...",
    footerNote: "Enforces: ALL CAPS, selected fonts, selected positioning, logo overlay + on-shirt, phone on #169179 banner, highest quality, exact scope with no text/number changes. Video uses full-duration installation action.",
    btnNew: "New", btnSaveNew: "Save New", btnUpdate: "Update",
    btnGen: "Generate Prompt", btnEs: "Español", btnEn: "English", btnCopy: "Copy", btnSave: "Save",
    subjects: {
      "Woman employee":"Woman employee", "Woman customer":"Woman customer", "Man customer":"Man customer",
      "Couple employees":"Couple employees", "Couple customers":"Couple customers", "Couple woman":"Couple woman", "Workers":"Workers"
    },
    placeholders: {
      trade: "e.g., Gutters (auto-updates text across the prompt)",
      extra: "Add anything else you want to include in the scene/prompt",
      scene: "Describe the Florida luxury setting and what the workers are doing."
    },
    languageNoteEN: "OUTPUT LANGUAGE: ENGLISH ONLY. No Spanish. LANGUAGE NOTE: All on-screen text, labels, and the SPECIAL OFFER badge must be in ENGLISH.",
    languageNoteES: "IDIOMA DE SALIDA: SOLO ESPAÑOL. Sin inglés. NOTA DE IDIOMA: Todo el texto en pantalla, etiquetas y el letrero de OFERTA ESPECIAL deben estar en ESPAÑOL."
  },
  ES: {
    hdrTitle: "Generador de Prompts Smart Choice",
    hdrSub: "Genera prompts coherentes y de marca para Sora (video o imagen). Guarda, edita y elimina prompts desde el menú izquierdo.",
    savedHdr: "Prompts guardados",
    savedHelp: "Haz clic en un elemento para cargarlo. Usa el botón eliminar para remover.",
    inputsHdr: "Entradas del Prompt",
    mediaLbl: "Medio",
    mediaVideoTxt: "Video",
    mediaPictureTxt: "Imagen",
    mediaHint: "El video exige acción de instalación continua durante toda la duración.",
    presetLbl: "Plantilla",
    tradeLbl: "Trade / Servicio",
    extraDescLbl: "Descripción extra personalizada (opcional)",
    tradeHelp: "Al escribir aquí se adapta la escena y el eslogan a tu trade en todo el prompt.",
    sceneLbl: "Detalles de la escena",
    subjHdr: "Sujetos / ¿Quién aparece en el video o imagen?",
    sloganLbl: "Eslogan (primera línea)",
    phoneLbl: "Texto del teléfono",
    lockPhoneTxt: "Bloquear exactamente el texto del teléfono",
    addPriceTxt: "Agregar precio al prompt",
    addWebTxt: "Agregar sitio web (por defecto abajo)",
    brandColorLbl: "Color del banner del teléfono",
    cartoonTxt: "Caricatura/Animación (Sora)",
    specialOfferTxt: "Agregar insignia de Oferta Especial",
    bgTxt: "Agregar imagen de fondo",
    logoPosLbl: "Posición del logo",
    uniformLbl: "Descripción del uniforme",
    textRulesHdr: "Posicionamiento de texto (selección múltiple)",
    textRulesHint: "Abre el menú y selecciona múltiples opciones con el mouse.",
    sloganFontLbl: "Fuente del eslogan",
    phoneFontLbl: "Fuente de la línea del teléfono",
    brandLbl: "Marca / Nombre del logo",
    durationLbl: "Duración (para video)",
    durationHint: "El video requiere acción de instalación continua durante toda la duración.",
    outHdr: "Prompt generado (listo para Sora)",
    outPlaceholder: "Tu prompt de Sora aparecerá aquí...",
    footerNote: "Obliga: MAYÚSCULAS, fuentes seleccionadas, posicionamiento elegido, logo sobreimpreso y en camiseta, teléfono en banner #169179, máxima calidad, texto/números exactos sin cambios. El video usa acción continua toda la duración.",
    btnNew: "Nuevo", btnSaveNew: "Guardar nuevo", btnUpdate: "Actualizar",
    btnGen: "Generar Prompt", btnEs: "Español", btnEn: "English", btnCopy: "Copiar", btnSave: "Guardar",
    subjects: {
      "Woman employee":"Empleado mujer", "Woman customer":"Cliente mujer", "Man customer":"Cliente hombre",
      "Couple employees":"Pareja de empleados", "Couple customers":"Pareja de clientes", "Couple woman":"Pareja de mujeres", "Workers":"Trabajadores"
    },
    placeholders: {
      trade: "p. ej., Canaletas (se adapta en todo el prompt)",
      extra: "Agrega cualquier detalle que quieras incluir en la escena/prompt",
      scene: "Describe el entorno de lujo de Florida y lo que hacen los trabajadores."
    },
    languageNoteEN: "OUTPUT LANGUAGE: ENGLISH ONLY. No Spanish. LANGUAGE NOTE: All on-screen text, labels, and the SPECIAL OFFER badge must be in ENGLISH.",
    languageNoteES: "IDIOMA DE SALIDA: SOLO ESPAÑOL. Sin inglés. NOTA DE IDIOMA: Todo el texto en pantalla, etiquetas y el letrero de OFERTA ESPECIAL deben estar en ESPAÑOL."
  }
};

// ===== storage helpers =====
function loadAll(){ try{ return JSON.parse(localStorage.getItem(LS_KEY)) || []; }catch(e){ return []; } }
function saveAll(list){ localStorage.setItem(LS_KEY, JSON.stringify(list)); }
function upsertPrompt(data){
  const list = loadAll();
  if (!data.id){ data.id = Date.now(); list.unshift(data); }
  else{
    const i = list.findIndex(x=>x.id===data.id);
    if(i>=0) list[i]=data; else list.unshift(data);
  }
  saveAll(list); renderList(); CURRENT_ID = data.id; return data.id;
}
function deletePrompt(id){
  const list = loadAll().filter(x=>x.id!==id);
  saveAll(list); renderList();
  if(CURRENT_ID===id){ CURRENT_ID=null; clearForm(); }
}
function renderList(){
  const list = loadAll();
  const box = $('promptList');
  box.innerHTML='';
  if(!list.length){
    box.innerHTML = '<div class="muted">No saved prompts yet. Click <b>Save New</b> to store one.</div>';
    return;
  }
  list.forEach(p=>{
    const item = document.createElement('div');
    item.className='item';
    const main = document.createElement('div'); main.className='item-main';
    const h = document.createElement('h4'); h.textContent = `${p.trade || '(no trade)'} — ${p.media}`;
    const meta = document.createElement('div'); meta.className='meta';
    const subj = p.subject ? `Subject: ${p.subject}` : '';
    const priceTxt = (p.addPrice && p.price) ? ` • Price: $${p.price}${p.unit? ` per ${p.unit}`:''}` : '';
    meta.textContent = `${new Date(p.ts).toLocaleString()} • ${subj}${priceTxt}`;
    main.append(h, meta);
    const actions = document.createElement('div'); actions.className='actions';
    const bEdit = document.createElement('button'); bEdit.textContent='Edit'; bEdit.onclick=()=>loadIntoForm(p.id);
    const bDel = document.createElement('button'); bDel.textContent='Delete'; bDel.className='warn'; bDel.onclick=()=>{ if(confirm('Delete this saved prompt?')) deletePrompt(p.id); };
    actions.append(bEdit,bDel); item.append(main, actions); box.appendChild(item);
  });
}

// dropdown multiselect helpers
function multiSelectValues(){
  const menu = $('textRulesMenu');
  return Array.from(menu.querySelectorAll('input[type="checkbox"]:checked')).map(i=>i.value);
}
function setTextRulesButtonLabel(){
  const menu = $('textRulesMenu');
  const vals = Array.from(menu.querySelectorAll('input[type="checkbox"]:checked')).map(i=>i.value);
  $('textRulesBtn').querySelector('.label').textContent = vals.length ? vals.join(' • ') : 'SELECT POSITIONING';
}

// subject helpers
function getSelectedSubject(){ const r = QS('.subjectRad:checked'); return r ? r.value : 'Workers'; }
function applySubjectToScene(newSubj){
  const sEl = $('scene');
  let txt = sEl.value || '';

  // Remove any existing (Subjects: …) or Spanish variants
  txt = txt.replace(/\(Subjects:[^)]+\)/ig, '')
           .replace(/\(Sujetos:[^)]+\)/ig, '')
           .replace(/\(Sujetos?:[^)]+\)/ig, '');

  // Replace any known subject words with the new one
  const allSubjects = [ 'Woman employee','Woman customer','Man customer','Couple employees','Couple customers','Couple woman','Workers',
                        'Trabajadores','Empleado mujer','Cliente mujer','Cliente hombre','Pareja de empleados','Pareja de clientes','Pareja de mujeres',
                        'workers','worker','clientes','empleados' ];
  allSubjects.forEach(sub=>{
    const re = new RegExp(sub.replace(/[.*+?^${}()|[\]\\]/g,'\\$&'),'ig');
    txt = txt.replace(re, newSubj);
  });

  txt = txt.trim();
  if (txt) txt += ` (Subjects: ${newSubj})`;
  else txt = `(Subjects: ${newSubj})`;

  sEl.value = txt;
  CURRENT_SUBJECT = newSubj;
}

// price formatting
function normalizePriceInput(){
  const el = $('price');
  let v = (el.value || '').replace(/[^\d.]/g,'');
  if(v){
    const parts = v.split('.');
    let whole = parts[0];
    let frac = (parts[1]||'').slice(0,2);
    v = whole + (frac !== '' ? ('.' + frac) : '');
    const num = parseFloat(v);
    if(!isNaN(num)) v = num.toFixed(2);
  }
  el.value = v || '';
}

// language directive
function getLanguageDirective(){
  return (CURRENT_LANG === 'ES')
    ? UI.ES.languageNoteES
    : UI.EN.languageNoteEN;
}

// ===== Background Picture UI =====
function toggleBgPicker(show){
  const row = $('bgPickerRow');
  if(row) row.style.display = show ? 'grid' : 'none';
  $('bgPreview').innerHTML = (BG_IMAGE_NAME ? `Selected: <b>${BG_IMAGE_NAME}</b>` : 'No file chosen');
}

// ===== prompt building =====
function buildPrompt(){
  const media = $('mediaVideo').checked ? 'Video' : 'Picture';
  const duration = $('duration').value.trim() || '15-second video suitable for META ads';
  const mediaHeader = (media==='Video') ? `Create a ${duration}.` : 'Create a single high-resolution PICTURE suitable for META ads.';

  const brand = $('brand').value.trim() || 'Smart Choice';
  const trade = $('trade').value.trim();
  const extra = $('extraDesc').value.trim();
  let slogan = $('slogan').value.trim();
  let scene = $('scene').value.trim();
  const subject = getSelectedSubject();
  const uniform = $('uniform').value.trim() || 'caqui pants, black polo t-shirt with an orange stripe on the side and black hat with the same stripe; company logo on the back of the polo and on the front right top corner';

  // Default scene EXACTLY as requested if empty
  if(!scene){
    scene = 'Show a one-million-dollar Florida luxury home with tropical landscaping. Uniformed workers are painting the exterior with professional tools and precision.';
  } else {
    // Keep scene but normalize subject tagging; remove existing tags and re-add with current subject
    scene = scene.replace(/\(Subjects:[^)]+\)/ig,'').trim();
  }
  // Replace generic 'workers/trabajadores' with selected subject
  scene = scene.replace(/workers/ig, subject).replace(/trabajadores/ig, subject);
  // Ensure only one Subjects tag
  scene = `${scene} (Subjects: ${subject})`;

  if(extra){ scene += ` Extra details: ${extra}.`; }

  const phone = $('phone').value.trim() || 'CALL NOW 727 755-3786';
  const lockPhone = $('lockPhone').checked;
  const brandColor = $('brandColor').value.trim() || '#169179';
  const logoPos = $('logoPos').value;
  const setting = 'Florida luxury home or high-quality residential property';
  const sloganFont = $('sloganFont').value;
  const phoneFont = $('phoneFont').value;
  const pos = multiSelectValues();
  const positioningText = pos.length ? pos.join(' & ') : 'CENTERED';
  const website = ($('addWebsite').checked ? ($('website').value.trim() || 'https://justsmartchoice.com/') : null);

  // price + unit
  const addPrice = $('addPrice').checked;
  const priceVal = ($('price').value || '').trim();
  const unitVal = $('unit').value;
  const priceLine = (addPrice && priceVal) ? `\n- Target price: $${priceVal} per ${unitVal}.` : '';

  const sceneBlock =
`SCENE DETAILS:
- Always show a ${setting}.
- Trade: ${trade || '(unspecified)'}.
- Subjects: ${subject}.
- ${subject} wear ${uniform}.${priceLine}
- ${scene}`;

  let visualBlock =
`VISUAL ELEMENTS:
- Place the ${brand} logo in the ${logoPos} as an overlay.
- Print the company logo on the back of the polo and on the front right top corner of the polo. Also print the logo on the left chest as appropriate for uniform branding.
- TEXT RULES: ALL CAPS, ${positioningText}.
- Slogan font: ${sloganFont}. Phone font: ${phoneFont}.
- First line (slogan): WHITE with subtle shadow — exactly: ${slogan}.
- Second line (phone): WHITE letters on background color ${brandColor} — exactly: ${phone}.` + (website ? `\n- Third line (website): WHITE text — exactly: ${website}` : '');

  if($('specialOffer').checked){
    visualBlock += `\n- Add a "SPECIAL OFFER" badge in the TOP-LEFT corner: RED letters, IMPACT font, small padding, WHITE background (clean rectangle), crisp and readable.`;
  }

  if ($('useBackground') && $('useBackground').checked){
    visualBlock +=
`\n\nBACKGROUND IMAGE:
- Use the ATTACHED BACKGROUND PICTURE (in addition to the company logo). Treat it as the main scene plate.
- Match camera angle, perspective, focal length, horizon line, and scale so the ${subject.toLowerCase()} integrate naturally.
- Composite the ${subject.toLowerCase()} performing ${trade || 'the work'} into this photo with realistic lighting, color temperature, contact shadows, and occlusion.
- Do not replace or distort the background; keep architecture and lines straight. Align shadows and reflections to the plate.`;
  }

  const pictureDimNote = ($('mediaPicture').checked)
    ? `- For PICTURES: use the SAME dimensions/resolution as Sora video output so images match video framing.`
    : ``;

  const isCartoon = $('cartoonMode').checked;
  const styleExtras = [];
  if ($('styleFuturistic').checked) styleExtras.push('- Apply a FUTURISTIC / TECH commercial aesthetic (clean geometry, sleek UI accents).');
  if ($('styleMinimal').checked) styleExtras.push('- MINIMALIST / FLAT commercial look (ample white space, product-first composition).');
  if ($('styleIsometric').checked) styleExtras.push('- ISOMETRIC 3D product angle suitable for ads and explainers.');
  if ($('styleNeon').checked) styleExtras.push('- NEON GLOW / MODERN AD vibe with contemporary lighting accents (tasteful, brand-appropriate).');

  let styleBlock;
  if(isCartoon){
    styleBlock = (media==='Video') ?
`STYLE:
- CARTOON/ANIMATION (Sora-compatible). Use cel-shaded or simple 3D animation with clean outlines and simplified textures. Consistent frame rate. Avoid photorealism.
- The installation action must be CONTINUOUS for the ENTIRE clip (e.g., if ${ (trade||'the trade').toLowerCase() } is shown, the ${subject.toLowerCase()} are actively performing it for the whole ${duration}).
- Florida homes should look bright, modern, and high-value in an animated style.` :
`STYLE:
- CARTOON/ANIMATION (Sora-compatible). Use a clean cel-shaded or simple 3D animated look with bold outlines and simplified textures. Avoid photorealism.
- Florida luxury home aesthetics; bright, modern, high-value look.`;
  } else {
    styleBlock = (media==='Video') ?
`STYLE:
- Cinematic, professional ad-quality visuals.
- The installation action must be CONTINUOUS for the ENTIRE clip (e.g., if ${ (trade||'the trade').toLowerCase() } is shown, the ${subject.toLowerCase()} are actively performing it for the whole ${duration}).
- Florida homes should look bright, modern, and high-value.` :
`STYLE:
- Photorealistic, commercial-quality composition.
- Florida luxury home aesthetics; bright, modern, high-value look.`;
  }
  if (styleExtras.length){ styleBlock += `\n${styleExtras.join('\n')}`; }

  const consistency =
`${lockPhone ? `CONSISTENCY REQUIREMENTS:
- DO NOT alter the phone number text. It must remain EXACTLY: ${phone}.\n` : ''}- Render at the HIGHEST POSSIBLE QUALITY for the selected media (video/picture).
- Provide the scope EXACTLY as requested. Do NOT change or improvise the text, numbers, or on-screen copy.
- Keep fonts, casing, alignment, logo position, and uniforms consistent.
- Make sure do not cut works and show al text inside the picture.
${pictureDimNote}`.trim();

  const languageNote = getLanguageDirective();

  return `${mediaHeader}

${sceneBlock}

${visualBlock}

${consistency}

${styleBlock}

${languageNote}`.trim();
}

// ===== Translation =====
const TRANSLATE_URL = 'https://libretranslate.com/translate';
async function translate(text, source, target){
  try{
    const payload = { q: text, source, target, format: "text" };
    const resp = await fetch(TRANSLATE_URL, {
      method: 'POST', headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    if(!resp.ok) throw new Error('Translation failed: ' + resp.status);
    const data = await resp.json();
    return data.translatedText || '';
  }catch(err){
    console.error('Translation error', err);
    // Fallback: quick section header swaps
    return text
      .replace(/SCENE DETAILS:/g,'DETALLES DE LA ESCENA:')
      .replace(/VISUAL ELEMENTS:/g,'ELEMENTOS VISUALES:')
      .replace(/STYLE:/g,'ESTILO:')
      .replace(/CONSISTENCY REQUIREMENTS:/g,'REQUISITOS DE CONSISTENCIA:')
      .replace(/BACKGROUND IMAGE:/g,'IMAGEN DE FONDO:')
      .replace(/LANGUAGE NOTE:/g,'NOTA DE IDIOMA:');
  }
}

// ===== collect & persist =====
function collect(){
  return {
    id: CURRENT_ID, ts: Date.now(),
    media: $('mediaVideo').checked ? 'Video' : 'Picture',
    brand: $('brand').value.trim(),
    trade: $('trade').value.trim(),
    extra: $('extraDesc').value.trim(),
    slogan: $('slogan').value.trim(),
    scene: $('scene').value.trim(),
    phone: $('phone').value.trim(),
    lockPhone: $('lockPhone').checked,
    addWebsite: $('addWebsite').checked,
    website: $('website').value.trim(),
    brandColor: $('brandColor').value.trim(),
    logoPos: $('logoPos').value,
    uniform: $('uniform').value.trim(),
    sloganFont: $('sloganFont').value,
    phoneFont: $('phoneFont').value,
    duration: $('duration').value.trim(),
    textRules: multiSelectValues(),
    subject: getSelectedSubject(),
    addPrice: $('addPrice').checked,
    price: ($('price').value || '').trim(),
    unit: $('unit').value,
    cartoonMode: $('cartoonMode').checked,
    specialOffer: $('specialOffer').checked,
    styleFuturistic: $('styleFuturistic').checked,
    styleMinimal: $('styleMinimal').checked,
    styleIsometric: $('styleIsometric').checked,
    styleNeon: $('styleNeon').checked,
    useBackground: $('useBackground') ? $('useBackground').checked : false,
    bgImageName: BG_IMAGE_NAME,
    bgImageData: BG_IMAGE_DATA,
    prompt: buildPrompt(),
    lang: CURRENT_LANG
  };
}
function populate(d){
  CURRENT_ID = d.id || null;
  $('mediaVideo').checked = (d.media||'Video')==='Video';
  $('mediaPicture').checked = (d.media||'Video')==='Picture';
  $('brand').value = d.brand || 'Smart Choice';
  $('trade').value = d.trade || '';
  $('extraDesc').value = d.extra || '';
  $('slogan').value = d.slogan || '';
  $('scene').value = d.scene || '';
  $('phone').value = d.phone || 'CALL NOW 727 755-3786';
  $('brandColor').value = d.brandColor || '#169179';
  $('logoPos').value = d.logoPos || 'top-right';
  $('uniform').value = d.uniform || 'caqui pants, black polo t-shirt with an orange stripe on the side and black hat with the same stripe; company logo on the back of the polo and on the front right top corner';
  $('sloganFont').value = d.sloganFont || 'Impact';
  $('phoneFont').value = d.phoneFont || 'Impact';
  $('duration').value = d.duration || '15-second video suitable for META ads';
  QSA('#textRulesMenu input[type="checkbox"]').forEach(o=>o.checked = (d.textRules||['JUSTIFIED','CENTERED']).includes(o.value));
  setTextRulesButtonLabel();
  const subj = d.subject || 'Workers';
  QSA('.subjectRad').forEach(r=>{ r.checked = (r.value===subj); });
  CURRENT_SUBJECT = subj;
  $('addWebsite').checked = d.addWebsite === undefined ? true : !!d.addWebsite;
  $('website').value = d.website || 'https://justsmartchoice.com/';
  $('addPrice').checked = d.addPrice === undefined ? true : !!d.addPrice;
  $('price').value = d.price || '';
  $('unit').value = d.unit || 'Linear ft';
  $('cartoonMode').checked = !!d.cartoonMode;
  $('specialOffer').checked = !!d.specialOffer;
  $('styleFuturistic').checked = !!d.styleFuturistic;
  $('styleMinimal').checked = !!d.styleMinimal;
  $('styleIsometric').checked = !!d.styleIsometric;
  $('styleNeon').checked = !!d.styleNeon;
  if ($('useBackground')) $('useBackground').checked = !!d.useBackground;
  BG_IMAGE_NAME = d.bgImageName || '';
  BG_IMAGE_DATA = d.bgImageData || '';
  if ($('bgPickerRow')) toggleBgPicker( $('useBackground') ? $('useBackground').checked : false );
  CURRENT_LANG = d.lang || 'ES';
  $('output').value = d.prompt || '';
  LAST_TRADE = $('trade').value.trim();
}
function clearForm(){ populate({}); }
function loadIntoForm(id){ const item = loadAll().find(x=>x.id===id); if(!item) return; populate(item); }

// Auto-adapt scene/slogan when Trade changes
function adaptForTrade(newTrade){
  const trade = (newTrade||'').trim();
  if(!trade) return;
  const prev = LAST_TRADE;
  let slog = $('slogan').value;
  if (!slog || /\[TRADE\]/i.test(slog) || (prev && new RegExp(prev,'i').test(slog))) {
    $('slogan').value = `TRUSTED ${trade.toUpperCase()} — QUALITY & RELIABILITY`;
  }
  let sc = $('scene').value;
  // Remove any subject tag; regenerate short line for the trade if scene was auto
  sc = sc.replace(/\(Subjects:[^)]+\)/ig,'').trim();
  if (!sc || (prev && new RegExp(prev,'i').test(sc))){
    $('scene').value = `Show a Florida luxury home where uniformed ${getSelectedSubject().toLowerCase()} are actively performing ${trade.toLowerCase()}. Emphasize precision, professional tools, and a clean, high-quality result. (Subjects: ${getSelectedSubject()})`;
  } else {
    const nouns = ['kitchen','painting','paint','fence','window','windows','panel','door','floor','charger','concrete','slab'];
    nouns.forEach(n=>{ sc = sc.replace(new RegExp(n,'ig'), trade); });
    $('scene').value = `${sc} (Subjects: ${getSelectedSubject()})`;
  }
  LAST_TRADE = trade;
  $('output').value = buildPrompt();
}

// ===== i18n: switch full UI =====
function applyLanguage(lang){
  CURRENT_LANG = lang;
  const dict = UI[lang];
  $('hdrTitle').textContent = dict.hdrTitle;
  $('hdrSub').textContent = dict.hdrSub;
  $('savedHdr').textContent = dict.savedHdr;
  $('savedHelp').textContent = dict.savedHelp;
  $('inputsHdr').textContent = dict.inputsHdr;
  $('mediaLbl').textContent = dict.mediaLbl;
  $('mediaVideoTxt').textContent = dict.mediaVideoTxt;
  $('mediaPictureTxt').textContent = dict.mediaPictureTxt;
  $('mediaHint').textContent = dict.mediaHint;
  $('presetLbl').textContent = dict.presetLbl;
  $('tradeLbl').textContent = dict.tradeLbl;
  $('extraDescLbl').textContent = dict.extraDescLbl;
  $('tradeHelp').textContent = dict.tradeHelp;
  $('sceneLbl').textContent = dict.sceneLbl;
  $('subjHdr').textContent = dict.subjHdr;
  $('sloganLbl').textContent = dict.sloganLbl;
  $('phoneLbl').textContent = dict.phoneLbl;
  $('lockPhoneTxt').textContent = dict.lockPhoneTxt;
  $('addPriceTxt').textContent = dict.addPriceTxt;
  $('addWebTxt').textContent = dict.addWebTxt;
  $('brandColorLbl').textContent = dict.brandColorLbl;
  $('cartoonTxt').textContent = dict.cartoonTxt;
  $('specialOfferTxt').textContent = dict.specialOfferTxt;
  $('bgTxt').textContent = dict.bgTxt;
  $('logoPosLbl').textContent = dict.logoPosLbl;
  $('uniformLbl').textContent = dict.uniformLbl;
  $('textRulesHdr').textContent = dict.textRulesHdr;
  $('textRulesHint').textContent = dict.textRulesHint;
  $('sloganFontLbl').textContent = dict.sloganFontLbl;
  $('phoneFontLbl').textContent = dict.phoneFontLbl;
  $('brandLbl').textContent = dict.brandLbl;
  $('durationLbl').textContent = dict.durationLbl;
  $('durationHint').textContent = dict.durationHint;
  $('outHdr').textContent = dict.outHdr;
  $('output').placeholder = dict.outPlaceholder;
  $('footerNote').textContent = dict.footerNote;

  $('newPrompt').textContent = dict.btnNew;
  $('saveNew').textContent = dict.btnSaveNew;
  $('updateCurrent').textContent = dict.btnUpdate;
  $('gen').textContent = dict.btnGen;
  $('toSpanish').textContent = dict.btnEs;
  $('toEnglish').textContent = dict.btnEn;
  $('copy').textContent = dict.btnCopy;
  $('saveQuick').textContent = dict.btnSave;

  // subjects chips labels (visual only)
  QSA('#subjectsBox label .i18n').forEach(span=>{
    span.textContent = span.dataset[lang.toLowerCase()];
  });

  // placeholders
  $('trade').placeholder = dict.placeholders.trade;
  $('extraDesc').placeholder = dict.placeholders.extra;
  $('scene').placeholder = dict.placeholders.scene;

  // header lang label
  $('langLabel').textContent = (lang === 'ES') ? 'ES' : 'EN';

  // Rebuild prompt in the chosen language (single-language)
  $('output').value = buildPrompt();
}

// ===== events & UI wiring =====
$('price').addEventListener('blur', normalizePriceInput);
$('price').addEventListener('input', e=>{
  let v = e.target.value.replace(/[^\d.]/g,'');
  const parts = v.split('.');
  if(parts.length > 2){ v = parts[0] + '.' + parts.slice(1).join(''); }
  if(parts[1]) parts[1] = parts[1].slice(0,2);
  e.target.value = parts.join('.');
});

// Generate prompt
$('gen').addEventListener('click', e=>{
  e.preventDefault();
  const p = buildPrompt();
  $('output').value = p;
  if (CURRENT_LANG === 'EN') {
    $('toEnglish').style.display = 'none';
    $('toSpanish').style.display = 'inline-block';
  } else {
    $('toEnglish').style.display = 'inline-block';
    $('toSpanish').style.display = 'none';
  }
});

// Copy
$('copy').addEventListener('click', e=>{
  e.preventDefault();
  const out = $('output');
  out.select(); out.setSelectionRange(0, 99999);
  document.execCommand('copy');
});

// Save / Update
$('saveNew').addEventListener('click', e=>{
  e.preventDefault();
  const d = collect(); d.id=null;
  upsertPrompt(d); alert('Saved new prompt.');
});
$('updateCurrent').addEventListener('click', e=>{
  e.preventDefault();
  const d = collect();
  if(!d.id) {alert('No prompt selected. Use Save New.'); return;}
  upsertPrompt(d); alert('Updated prompt.');
});
$('newPrompt').addEventListener('click', e=>{
  e.preventDefault();
  clearForm(); CURRENT_ID=null;
});

// Preset change
$('preset').addEventListener('change', e=>{
  const k = e.target.value;
  if(!k || !PRESETS[k]) return;
  const p = PRESETS[k];
  populate({
    media:'Video', brand:'Smart Choice',
    trade:p.trade, slogan:p.slogan, scene:p.scene, extra:'',
    phone:'CALL NOW 727 755-3786',
    brandColor:'#169179', logoPos:'top-right',
    uniform:'caqui pants, black polo t-shirt with an orange stripe on the side and black hat with the same stripe; company logo on the back of the polo and on the front right top corner',
    sloganFont:'Impact', phoneFont:'Impact',
    duration:'15-second video suitable for META ads',
    textRules:['JUSTIFIED','CENTERED'], subject:'Workers',
    addPrice:true, price:'', unit:'Linear ft',
    cartoonMode:false, specialOffer:false,
    styleFuturistic:false, styleMinimal:false, styleIsometric:false, styleNeon:false,
    useBackground:false, bgImageName:'', bgImageData:'',
    lang: CURRENT_LANG
  });
  $('output').value = buildPrompt();
});

// Trade auto-adapt
$('trade').addEventListener('input', e=>{ adaptForTrade(e.target.value); });
// Subject change reflect
QSA('.subjectRad').forEach(r=>{
  r.addEventListener('change', ()=>{
    const newSub = getSelectedSubject();
    applySubjectToScene(newSub);
    $('output').value = buildPrompt();
  });
});

// textRules dropdown
(function setupTextRulesDropdown(){
  const dd = $('textRulesDrop'), btn = $('textRulesBtn'), menu = $('textRulesMenu');
  btn.addEventListener('click', ()=>{ dd.classList.toggle('open'); });
  document.addEventListener('click', (ev)=>{ if(!dd.contains(ev.target)) dd.classList.remove('open'); });
  menu.querySelectorAll('input[type="checkbox"]').forEach(ch=> ch.addEventListener('change', ()=> setTextRulesButtonLabel() ));
  setTextRulesButtonLabel();
})();

// Español button: translate Output + Scene fully to Spanish (single-language) and uncheck Add Price
$('toSpanish').addEventListener('click', async (e)=>{
  e.preventDefault();
  if (TRANSLATING) return;
  TRANSLATING = true;

  // Auto-uncheck Add Price
  $('addPrice').checked = false;

  // Start from clean EN build, then translate to ES
  const prevLang = CURRENT_LANG;
  CURRENT_LANG = 'EN';
  const englishPrompt = buildPrompt();
  const engScene = $('scene').value;

  CURRENT_LANG = 'ES';
  $('output').value = 'Traduciendo...';
  try{
    const [tPrompt, tScene] = await Promise.all([
      translate(englishPrompt, 'en', 'es'),
      translate(engScene, 'en', 'es')
    ]);
    $('output').value = tPrompt || englishPrompt;
    $('scene').value = (tScene || engScene).replace(/\(Subjects:[^)]+\)/ig, `(Subjects: ${getSelectedSubject()})`);
    $('toEnglish').style.display = 'inline-block';
    $('toSpanish').style.display = 'none';
    // sync header slider to ES
    $('langSwitch').checked = false;
    applyLanguage('ES');
  }catch(err){
    console.error(err);
    $('output').value = buildPrompt();
    $('scene').value = engScene;
    $('toEnglish').style.display = 'inline-block';
    $('toSpanish').style.display = 'none';
    $('langSwitch').checked = false;
    applyLanguage('ES');
    alert('Translation failed — check console for details.');
  } finally { TRANSLATING = false; }
});

// English button: rebuild as English (single-language) and uncheck Add Price
$('toEnglish').addEventListener('click', (e)=>{
  e.preventDefault();
  $('addPrice').checked = false;
  CURRENT_LANG = 'EN';
  $('output').value = buildPrompt();
  if(ORIGINAL_ENGLISH_SCENE){ $('scene').value = ORIGINAL_ENGLISH_SCENE; }
  $('toEnglish').style.display='none';
  $('toSpanish').style.display='inline-block';
  $('langSwitch').checked = true; // sync header slider to EN
  applyLanguage('EN');
});

// Save Quick
$('saveQuick').addEventListener('click', (e)=>{
  e.preventDefault(); const data = collect(); upsertPrompt(data); alert('Saved prompt.');
});

// Background UI
if ($('useBackground')) {
  $('useBackground').addEventListener('change', (e)=>{ toggleBgPicker(e.target.checked); $('output').value = buildPrompt(); });
}
if ($('bgFile')) {
  $('bgFile').addEventListener('change', (e)=>{
    const f = e.target.files && e.target.files[0];
    if(!f){ BG_IMAGE_NAME=''; BG_IMAGE_DATA=''; $('bgPreview').textContent='No file chosen'; $('output').value = buildPrompt(); return; }
    BG_IMAGE_NAME = f.name;
    const rdr = new FileReader();
    rdr.onload = () => {
      BG_IMAGE_DATA = rdr.result || '';
      $('bgPreview').innerHTML = `Selected: <b>${BG_IMAGE_NAME}</b>`;
      $('output').value = buildPrompt();
    };
    rdr.readAsDataURL(f);
  });
}

// Header language slider (EN default)
$('langSwitch').addEventListener('change', (e)=>{
  if (e.target.checked){
    CURRENT_LANG = 'EN';
    $('toEnglish').style.display='none';
    $('toSpanish').style.display='inline-block';
    applyLanguage('EN');
  } else {
    CURRENT_LANG = 'ES';
    $('toEnglish').style.display='inline-block';
    $('toSpanish').style.display='none';
    applyLanguage('ES');
  }
});

// initial load
(function init(){
  renderList();
  applyLanguage('EN'); // default UI EN
  // Seed presets if none
  const list = loadAll();
  if(!list.length){
    const keys = Object.keys(PRESETS);
    const imported = keys.map((k,idx)=> {
      const p = PRESETS[k];
      return {
        id: Date.now() + idx, ts: Date.now(),
        media: 'Video', brand: 'Smart Choice',
        trade: p.trade, slogan: p.slogan, scene: p.scene, extra:'',
        phone: 'CALL NOW 727 755-3786',
        brandColor: '#169179', logoPos: 'top-right',
        uniform: 'caqui pants, black polo t-shirt with an orange stripe on the side and black hat with the same stripe; company logo on the back of the polo and on the front right top corner',
        sloganFont: 'Impact', phoneFont: 'Impact',
        duration: '15-second video suitable for META ads',
        textRules: ['JUSTIFIED','CENTERED'],
        subject: 'Workers',
        addWebsite: true, website: 'https://justsmartchoice.com/',
        addPrice: true, price: '', unit: 'Linear ft',
        cartoonMode: false, specialOffer: false,
        styleFuturistic: false, styleMinimal: false, styleIsometric: false, styleNeon: false,
        useBackground: false, bgImageName: '', bgImageData: '',
        prompt: '', lang: 'EN'
      };
    });
    saveAll(imported); renderList();
    const first = imported[0]; if(first) populate(first);
    $('output').value = buildPrompt();
  } else {
    renderList();
    if(list[0]) { populate(list[0]); $('output').value = list[0].prompt || buildPrompt(); }
  }
})();

// prevent accidental submit on Enter
document.addEventListener('keydown', function(e){
  if(e.key === 'Enter' && e.target && (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT')) {
    e.preventDefault();
  }
});
</script>
<?php endif; ?>
</body>
</html>

