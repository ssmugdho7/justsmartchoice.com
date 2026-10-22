<?php
/**
 * SKETCHUP LAYOUT TAG DATA INTAKE (SINGLE FILE)
 * - DISPLAYS TAG-LIKE SECTIONS WITH QUESTIONS
 * - EMPLOYEES FILL IN DATA + NOTES
 * - SUBMITS VIA EMAIL TO ADMIN@JUSTSMARTCHOICE.COM
 *
 * FINAL CHANGES (PER REQUEST):
 * 1) DRAWING ADMINISTRATION INFO: ADD "SCOPE OF WORK" + "CONTRACT OR INVOICE NUMBER"
 * 2) AFTER SUCCESSFUL SUBMIT: CLEAR ALL FIELDS + PROGRESS BAR RETURNS TO 0% (POST/REDIRECT/GET)
 * 3) FILE UPLOADS: ATTACH FILES TO EMAIL (NOT ONLY NAMES)
 *
 * DEPLOY:
 * - SAVE AS: layout_tag_intake.php
 * - ENSURE PHP FILE UPLOADS + mail() ARE ENABLED ON HOST
 */

declare(strict_types=1);

$TO_EMAIL = 'admin@justsmartchoice.com';
$FROM_EMAIL = 'no-reply@justsmartchoice.com'; // CHANGE IF YOUR HOST REQUIRES A VALID SENDER ON YOUR DOMAIN
$SUBJECT_PREFIX = 'DRAWING INFO INTAKE (SKETCHUP LAYOUT TAGS)';

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$MAX_FILES     = 10;
$ALLOWED_EXTS  = ['pdf','jpg','jpeg','png','doc','docx'];

/**
 * MIME TYPES FOR ATTACHMENTS
 */
function mime_for_ext(string $ext): string {
  $ext = strtolower($ext);
  return match ($ext) {
    'pdf'  => 'application/pdf',
    'jpg', 'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'doc'  => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    default => 'application/octet-stream',
  };
}

$SECTIONS = [
  [
    'title' => 'DRAWING ADMINISTRATION INFO',
    'help'  => 'THIS SECTION MATCHES COMMON TITLE BLOCK / SHEET METADATA USED IN PERMIT SETS.',
    'fields'=> [
      ['key'=>'atm', 'label'=>'ATM / ATTENTION TO', 'type'=>'text', 'placeholder'=>'E.G., PERMIT TECH / PLAN REVIEWER NAME'],
      ['key'=>'creator', 'label'=>'CREATOR (DRAFTER / DESIGNER)', 'type'=>'text', 'placeholder'=>'NAME'],
      ['key'=>'authority', 'label'=>'AUTHORITY HAVING JURISDICTION (AHJ)', 'type'=>'text', 'placeholder'=>'CITY / COUNTY / BUILDING DEPT'],
      ['key'=>'permit_no', 'label'=>'PERMIT NUMBER', 'type'=>'text', 'placeholder'=>'IF KNOWN'],
      ['key'=>'project_no', 'label'=>'PROJECT NUMBER', 'type'=>'text', 'placeholder'=>'INTERNAL TRACKING ID'],
      ['key'=>'issue_date', 'label'=>'ISSUE DATE', 'type'=>'text', 'placeholder'=>'YYYY-MM-DD'],
      ['key'=>'revision', 'label'=>'REVISION / ADDENDUM', 'type'=>'text', 'placeholder'=>'REV-01, REV-02, ETC.'],
      ['key'=>'scope_of_work', 'label'=>'SCOPE OF WORK', 'type'=>'textarea', 'placeholder'=>'BRIEF SCOPE SUMMARY (WHAT IS BEING PERMITTED)'],
      ['key'=>'contract_invoice_no', 'label'=>'CONTRACT OR INVOICE NUMBER', 'type'=>'text', 'placeholder'=>'ENTER CONTRACT # OR INVOICE #'],
    ],
  ],
  [
    'title' => 'PROJECT / PROPERTY INFORMATION',
    'help'  => 'CORE PROPERTY DATA THAT SHOWS ON PLANS AND SUPPORTS PERMIT REVIEW.',
    'fields'=> [
      ['key'=>'project_name', 'label'=>'PROJECT NAME', 'type'=>'text', 'placeholder'=>'E.G., 14704 CARNATION RENOVATION'],
      ['key'=>'property_address', 'label'=>'PROPERTY ADDRESS', 'type'=>'text', 'placeholder'=>'STREET, CITY, STATE, ZIP'],
      ['key'=>'google_maps_link', 'label'=>'GOOGLE MAP LINK (PASTE URL)', 'type'=>'text', 'placeholder'=>'PASTE GOOGLE MAPS URL HERE'],
      ['key'=>'parcel_id', 'label'=>'PARCEL ID / FOLIO', 'type'=>'text', 'placeholder'=>'IF AVAILABLE'],
      ['key'=>'jurisdiction', 'label'=>'JURISDICTION / COUNTY', 'type'=>'text', 'placeholder'=>'E.G., HILLSBOROUGH COUNTY'],
      ['key'=>'property_use', 'label'=>'PROPERTY USE / OCCUPANCY', 'type'=>'text', 'placeholder'=>'E.G., SINGLE FAMILY RESIDENTIAL (R-3)'],
      ['key'=>'construction_type', 'label'=>'CONSTRUCTION TYPE', 'type'=>'text', 'placeholder'=>'E.G., TYPE V-B (IF REQUIRED)'],
      ['key'=>'year_built', 'label'=>'YEAR BUILT', 'type'=>'text', 'placeholder'=>'E.G., 1955'],
      ['key'=>'stories', 'label'=>'NUMBER OF STORIES', 'type'=>'text', 'placeholder'=>'E.G., 1'],
      ['key'=>'bed_bath', 'label'=>'BEDROOMS / BATHROOMS', 'type'=>'text', 'placeholder'=>'E.G., 3 BED / 2 BATH'],
      ['key'=>'find_elevation', 'label'=>'FIND ELEVATION', 'type'=>'text', 'placeholder'=>'ENTER ELEVATION RESULT (FT) + SOURCE'],
      ['key'=>'lot_size', 'label'=>'LOT SIZE', 'type'=>'text', 'placeholder'=>'E.G., 0.18 AC / 7,841 SF'],
      ['key'=>'geo_location', 'label'=>'GEO LOCATION (LAT / LONG)', 'type'=>'text', 'placeholder'=>'E.G., 27.9506, -82.4572'],
      ['key'=>'property_full_area', 'label'=>'PROPERTY FULL AREA (TOTAL SF)', 'type'=>'text', 'placeholder'=>'TOTAL AREA IF AVAILABLE (LOT / BUILDING AS APPLICABLE)'],
      ['key'=>'property_market_value', 'label'=>'PROPERTY MARKET VALUE', 'type'=>'text', 'placeholder'=>'ENTER VALUE + YEAR FROM APPRAISER'],
      ['key'=>'property_appraiser_link', 'label'=>'PROPERTY APPRAISER LINK (PASTE URL ONLY)', 'type'=>'text', 'placeholder'=>'PASTE PROPERTY APPRAISER PAGE LINK HERE'],
    ],
  ],
  [
    'title' => 'SQUARE FOOTAGE / AREA DATA',
    'help'  => 'AREA NUMBERS USED FOR ENERGY, HVAC, AND PLAN SUMMARY TABLES.',
    'fields'=> [
      ['key'=>'sqft_total', 'label'=>'TOTAL CONDITIONED / LIVING AREA (SF)', 'type'=>'text', 'placeholder'=>'NUMERIC VALUE'],
      ['key'=>'sqft_heated', 'label'=>'HEATED AREA (SF)', 'type'=>'text', 'placeholder'=>'NUMERIC VALUE'],
      ['key'=>'sqft_cooled', 'label'=>'COOLED AREA (SF)', 'type'=>'text', 'placeholder'=>'NUMERIC VALUE'],
      ['key'=>'sqft_unconditioned', 'label'=>'UNCONDITIONED AREA (SF)', 'type'=>'text', 'placeholder'=>'GARAGE / PORCH / ATTIC, ETC.'],
      ['key'=>'garage_sqft', 'label'=>'GARAGE AREA (SF)', 'type'=>'text', 'placeholder'=>'NUMERIC VALUE'],
      ['key'=>'porch_sqft', 'label'=>'PORCH / PATIO AREA (SF)', 'type'=>'text', 'placeholder'=>'NUMERIC VALUE'],
    ],
  ],
  [
    'title' => 'CONTRACTOR INFORMATION (LICENSE + CONTACT)',
    'help'  => 'CONTRACTOR DATA REQUIRED ON ALL PERMIT SETS AND APPLICATIONS. IF CONTRACTOR IS DIFFERENT THAN SMART CHOICE CONTRACTORS USA, INDICATE BELOW. UPLOAD LICENSE/INSURANCE IN THE UPLOAD FIELD.',
    'fields'=> [
      ['key'=>'contractor_name', 'label'=>'CONTRACTOR NAME', 'type'=>'text', 'placeholder'=>'LEGAL NAME / DBA'],
      ['key'=>'contractor_license', 'label'=>'CONTRACTOR LICENSE #', 'type'=>'text', 'placeholder'=>'STATE LICENSE NUMBER'],
      ['key'=>'contractor_company', 'label'=>'COMPANY / DBA', 'type'=>'text', 'placeholder'=>'E.G., SMART CHOICE CONTRACTORS USA'],
      ['key'=>'contractor_address', 'label'=>'CONTRACTOR ADDRESS', 'type'=>'text', 'placeholder'=>'STREET, CITY, STATE, ZIP'],
      ['key'=>'contractor_phone', 'label'=>'CONTRACTOR PHONE', 'type'=>'text', 'placeholder'=>'MAIN LINE'],
      ['key'=>'contractor_mobile', 'label'=>'CONTRACTOR MOBILE', 'type'=>'text', 'placeholder'=>'CELL / FIELD'],
      ['key'=>'contractor_email', 'label'=>'CONTRACTOR EMAIL', 'type'=>'text', 'placeholder'=>'EMAIL'],
      ['key'=>'license_insurance_upload', 'label'=>'LICENSE AND INSURANCE LOADING (UPLOAD MULTIPLE DOCUMENTS)', 'type'=>'file', 'placeholder'=>''],
    ],
  ],
  [
    'title' => 'OWNER / CLIENT INFORMATION',
    'help'  => 'OWNER DATA IS REQUIRED FOR ALL PERMITS AS SHOWN ON PERMIT APPLICATIONS / PLAN COVER SHEETS.',
    'fields'=> [
      ['key'=>'owner_name', 'label'=>'OWNER NAME', 'type'=>'text', 'placeholder'=>'FULL NAME / ENTITY'],
      ['key'=>'owner_phone', 'label'=>'OWNER PHONE', 'type'=>'text', 'placeholder'=>'OPTIONAL'],
      ['key'=>'owner_email', 'label'=>'OWNER EMAIL', 'type'=>'text', 'placeholder'=>'OPTIONAL'],
      ['key'=>'customer_mailing_address', 'label'=>'CUSTOMER MAILING ADDRESS', 'type'=>'text', 'placeholder'=>'MAILING ADDRESS (IF DIFFERENT FROM PROPERTY ADDRESS)'],
    ],
  ],
  [
    'title' => 'BUILDING CHARACTERISTICS (AS-BUILT / PROPERTY APPRAISER)',
    'help'  => 'COPY FROM PROPERTY APPRAISER OR FIELD VERIFIED CONDITIONS.',
    'fields'=> [
      ['key'=>'bldg_type', 'label'=>'BUILDING TYPE', 'type'=>'text', 'placeholder'=>'E.G., 01 | SINGLE FAMILY'],
      ['key'=>'construction_class', 'label'=>'CONSTRUCTION CLASS', 'type'=>'text', 'placeholder'=>'E.G., CONCRETE BLOCK'],
      ['key'=>'ext_walls', 'label'=>'EXTERIOR WALLS', 'type'=>'text', 'placeholder'=>'E.G., CONCRETE BLOCK / BRICK'],
      ['key'=>'roof_struct', 'label'=>'ROOF STRUCTURE', 'type'=>'text', 'placeholder'=>'E.G., GABLE OR HIP'],
      ['key'=>'roof_cover', 'label'=>'ROOF COVER', 'type'=>'text', 'placeholder'=>'E.G., ASPHALT SHINGLE'],
      ['key'=>'interior_walls', 'label'=>'INTERIOR WALLS', 'type'=>'text', 'placeholder'=>'E.G., PLASTER / DRYWALL'],
      ['key'=>'flooring', 'label'=>'FLOORING', 'type'=>'text', 'placeholder'=>'E.G., VINYL / CARPET'],
      ['key'=>'heat_ac', 'label'=>'HEAT / AC TYPE', 'type'=>'text', 'placeholder'=>'E.G., CENTRAL'],
      ['key'=>'condition', 'label'=>'CONDITION', 'type'=>'text', 'placeholder'=>'E.G., AVERAGE'],
      ['key'=>'main_panel_amps', 'label'=>'ELECTRICAL MAIN PANEL AMPS', 'type'=>'text', 'placeholder'=>'E.G., 150A / 200A'],
    ],
  ],
  [
    'title' => 'CODE / PERMIT SUMMARY (RESEARCH REQUIRED)',
    'help'  => 'EMPLOYEES MUST RESEARCH THE AHJ REQUIREMENTS AND LIST THE APPLICABLE CODES / REFERENCES.',
    'fields'=> [
      ['key'=>'code_editions', 'label'=>'APPLICABLE CODE EDITIONS (FBC 2023, NEC, ETC.)', 'type'=>'textarea', 'placeholder'=>'LIST APPLICABLE CODE BOOKS AND EDITIONS USED BY AHJ'],
      ['key'=>'wind', 'label'=>'DESIGN WIND SPEED / EXPOSURE / RISK CATEGORY', 'type'=>'textarea', 'placeholder'=>'ENTER VALUES + SOURCE (AHJ / FBC MAPS / ENGINEER)'],
      ['key'=>'flood', 'label'=>'FEMA FLOOD ZONE / BFE / REQUIREMENTS', 'type'=>'textarea', 'placeholder'=>'ENTER FLOOD ZONE, BFE, FREEBOARD, AND ANY REQUIRED FORMS'],
      ['key'=>'energy', 'label'=>'ENERGY / INSULATION REQUIREMENTS', 'type'=>'textarea', 'placeholder'=>'ENTER REQUIRED R-VALUES, U-FACTORS, OR ENERGY METHOD USED'],
      ['key'=>'inspectors', 'label'=>'LIST OF NAMES AND PHONE NUMBER OF INSPECTORS', 'type'=>'textarea', 'placeholder'=>'FOR VERIFICATION OF INFORMATION AND ANY EXTRA REQUIREMENTS.'],
      ['key'=>'final_project_notes', 'label'=>'FINAL PROJECT NOTES', 'type'=>'textarea', 'placeholder'=>'FINAL NOTES, RISKS, OPEN ITEMS, AND CONFIRMATIONS BEFORE ISSUANCE.'],
    ],
  ],
];

/**
 * COMPLETION KEYS (EXCLUDES FILE UPLOAD FROM PROGRESS COUNT)
 */
function completion_keys(array $sections): array {
  $keys = [];
  foreach ($sections as $section) {
    foreach ($section['fields'] as $field) {
      $type = (string)($field['type'] ?? 'text');
      $key  = (string)($field['key'] ?? '');
      if ($key === '') continue;
      if ($type === 'file') continue;
      $keys[] = $key;
    }
  }
  return $keys;
}

function compute_progress(array $keys, array $answers): array {
  $total = count($keys);
  $filled = 0;
  foreach ($keys as $k) {
    $val = isset($answers[$k]) ? trim((string)$answers[$k]) : '';
    if ($val !== '') $filled++;
  }
  $pct = ($total > 0) ? (int)round(($filled / $total) * 100) : 0;
  if ($pct < 0) $pct = 0;
  if ($pct > 100) $pct = 100;
  return ['total'=>$total, 'filled'=>$filled, 'pct'=>$pct];
}

/**
 * READ FILE UPLOADS INTO MEMORY FOR EMAIL ATTACHMENTS
 * RETURNS: [ ['original'=>..., 'tmp'=>..., 'type'=>..., 'size'=>...], ... ]
 */
function collect_uploads(string $inputName, int $maxFiles, array $allowedExts, array &$errors): array {
  if (!isset($_FILES[$inputName])) return [];
  $f = $_FILES[$inputName];

  if (!is_array($f['name'] ?? null)) return [];

  $out = [];
  $count = count($f['name']);
  $limit = min($count, $maxFiles);

  for ($i = 0; $i < $limit; $i++) {
    $name = (string)($f['name'][$i] ?? '');
    $tmp  = (string)($f['tmp_name'][$i] ?? '');
    $err  = (int)($f['error'][$i] ?? UPLOAD_ERR_NO_FILE);
    $size = (int)($f['size'][$i] ?? 0);

    if ($err === UPLOAD_ERR_NO_FILE || $name === '') continue;
    if ($err !== UPLOAD_ERR_OK) {
      $errors[] = 'UPLOAD ERROR ON FILE: ' . $name;
      continue;
    }

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if ($ext === '' || !in_array($ext, $allowedExts, true)) {
      $errors[] = 'FILE TYPE NOT ALLOWED: ' . $name;
      continue;
    }

    if (!is_uploaded_file($tmp)) {
      $errors[] = 'INVALID UPLOAD SOURCE: ' . $name;
      continue;
    }

    $out[] = [
      'original' => $name,
      'tmp'      => $tmp,
      'ext'      => $ext,
      'type'     => mime_for_ext($ext),
      'size'     => $size,
    ];
  }

  return $out;
}

/**
 * SEND EMAIL WITH ATTACHMENTS (MULTIPART/MIXED)
 */
function send_mail_with_attachments(
  string $to,
  string $subject,
  string $bodyText,
  string $from,
  ?string $replyTo,
  array $attachments
): bool {
  $eol = "\r\n";
  $boundary = '=_MIXED_' . bin2hex(random_bytes(12));

  $headers = [];
  $headers[] = "MIME-Version: 1.0";
  $headers[] = "From: {$from}";
  if ($replyTo) $headers[] = "Reply-To: {$replyTo}";
  $headers[] = "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";

  $message = '';
  $message .= "--{$boundary}{$eol}";
  $message .= "Content-Type: text/plain; charset=UTF-8{$eol}";
  $message .= "Content-Transfer-Encoding: 8bit{$eol}{$eol}";
  $message .= $bodyText . "{$eol}{$eol}";

  foreach ($attachments as $a) {
    $filename = (string)$a['original'];
    $tmp      = (string)$a['tmp'];
    $type     = (string)$a['type'];

    $content = @file_get_contents($tmp);
    if ($content === false) {
      // SKIP IF CANNOT READ
      continue;
    }

    $b64 = chunk_split(base64_encode($content));

    $safeFilename = preg_replace('/[^a-zA-Z0-9_\-\. ]+/', '_', $filename);
    if ($safeFilename === '' || $safeFilename === null) $safeFilename = 'attachment';

    $message .= "--{$boundary}{$eol}";
    $message .= "Content-Type: {$type}; name=\"{$safeFilename}\"{$eol}";
    $message .= "Content-Transfer-Encoding: base64{$eol}";
    $message .= "Content-Disposition: attachment; filename=\"{$safeFilename}\"{$eol}{$eol}";
    $message .= $b64 . "{$eol}";
  }

  $message .= "--{$boundary}--{$eol}";

  return @mail($to, $subject, $message, implode($eol, $headers));
}

/**
 * STATE
 */
$errors = [];
$success = false;

$posted = (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST');

$employee_name  = $posted ? trim((string)($_POST['employee_name'] ?? '')) : '';
$employee_email = $posted ? trim((string)($_POST['employee_email'] ?? '')) : '';
$sheet_set      = $posted ? trim((string)($_POST['sheet_set'] ?? '')) : '';
$honeypot       = $posted ? trim((string)($_POST['website'] ?? '')) : '';

$answers = ($posted && is_array($_POST['a'] ?? null)) ? $_POST['a'] : [];

$completionKeys = completion_keys($SECTIONS);

// PROGRESS BAR UPDATES ONLY ON SUBMIT
$progress = ['pct'=>0, 'filled'=>0, 'total'=>count($completionKeys)];
if ($posted) {
  $progress = compute_progress($completionKeys, $answers);
}

// SUCCESS FLAG (AFTER REDIRECT)
if (!$posted && isset($_GET['sent']) && $_GET['sent'] === '1') {
  $success = true;
}

if ($posted) {
  if ($honeypot !== '') $errors[] = 'SUBMISSION BLOCKED.';

  if ($employee_name === '') $errors[] = 'EMPLOYEE NAME IS REQUIRED.';
  if ($sheet_set === '')     $errors[] = 'FILE TO BE NAMED IS REQUIRED.';

  if ($employee_email !== '' && !filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'EMPLOYEE EMAIL IS INVALID.';
  }

  if ($progress['filled'] === 0) $errors[] = 'PLEASE FILL AT LEAST ONE FIELD BEFORE SENDING.';

  // COLLECT FILES FOR ATTACHMENT
  $uploads = collect_uploads('license_insurance_upload', $MAX_FILES, $ALLOWED_EXTS, $errors);

  if (!$errors) {
    $lines = [];
    $lines[] = "EMPLOYEE NAME: {$employee_name}";
    $lines[] = "EMPLOYEE EMAIL: " . ($employee_email !== '' ? $employee_email : 'N/A');
    $lines[] = "FILE TO BE NAMED: {$sheet_set}";
    $lines[] = "FORM COMPLETION: {$progress['pct']}% ({$progress['filled']} / {$progress['total']} FIELDS)";
    $lines[] = "SUBMITTED AT: " . date('Y-m-d H:i:s');
    $lines[] = str_repeat('-', 72);

    foreach ($SECTIONS as $section) {
      $lines[] = strtoupper((string)$section['title']);
      $lines[] = str_repeat('-', 72);

      foreach ($section['fields'] as $field) {
        $type = (string)($field['type'] ?? 'text');
        $key  = (string)($field['key'] ?? '');
        if ($key === '') continue;

        if ($type === 'file') {
          $lines[] = "{$field['label']}:";
          if (!empty($uploads)) {
            foreach ($uploads as $u) {
              $lines[] = "- " . $u['original'];
            }
          } else {
            $lines[] = "[NO FILES UPLOADED]";
          }
          $lines[] = str_repeat('-', 72);
          continue;
        }

        $val = isset($answers[$key]) ? trim((string)$answers[$key]) : '';
        $lines[] = "{$field['label']}:";
        $lines[] = ($val !== '') ? $val : '[NO RESPONSE]';
        $lines[] = str_repeat('-', 72);
      }
      $lines[] = "";
    }

    $body = implode("\n", $lines);
    $subject = $SUBJECT_PREFIX . " | " . $sheet_set;

    $replyTo = ($employee_email !== '' && filter_var($employee_email, FILTER_VALIDATE_EMAIL)) ? $employee_email : null;

    $ok = send_mail_with_attachments($TO_EMAIL, $subject, $body, $FROM_EMAIL, $replyTo, $uploads);

    if ($ok) {
      // POST/REDIRECT/GET TO CLEAR FIELDS + RESET PROGRESS TO 0
      $url = strtok((string)($_SERVER['REQUEST_URI'] ?? ''), '?');
      header('Location: ' . $url . '?sent=1');
      exit;
    } else {
      $errors[] = 'EMAIL FAILED TO SEND. PLEASE CONTACT ADMIN.';
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DRAWING INFO INTAKE (SKETCHUP LAYOUT TAGS)</title>
  <style>
    :root{
      --bg:#ffffff;
      --card:#ffffff;
      --text:#000000;
      --muted:#333333;
      --line:#cccccc;
      --danger:#b00020;
      --ok:#0a7a2f;
      --brand:#4f8b34;
    }
    body{ margin:0; font-family:Tahoma, Arial, sans-serif; background:var(--bg); color:var(--text); }
    .wrap{ max-width:1100px; margin:24px auto; padding:0 14px; }
    .card{ background:var(--card); border:1px solid var(--line); border-radius:10px; padding:18px; }
    h1{ margin:0 0 6px; font-size:18px; letter-spacing:.4px; }
    p{ margin:0 0 14px; color:var(--muted); font-size:13px; line-height:1.45; }
    .grid{ display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
    @media (max-width:980px){ .grid{ grid-template-columns:1fr; } }
    label{ display:block; font-size:12px; color:var(--muted); margin:10px 0 6px; letter-spacing:.3px; }
    input, textarea{
      width:100%; box-sizing:border-box; border:1px solid var(--line);
      background:#fff; color:var(--text); border-radius:8px;
      padding:10px 12px; font-size:13px; outline:none;
    }
    textarea{ min-height:86px; resize:vertical; }
    input:focus, textarea:focus{ border-color:#000; }
    .section{ margin-top:14px; border:1px solid var(--line); border-radius:10px; padding:14px; }
    .section h2{ margin:0 0 4px; font-size:14px; letter-spacing:.4px; }
    .section .help{ margin:0 0 10px; font-size:12px; color:var(--muted); }
    .fields{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    @media (max-width:980px){ .fields{ grid-template-columns:1fr; } }
    .btnrow{ display:flex; gap:10px; align-items:center; margin-top:16px; flex-wrap:wrap; }
    button{
      background:var(--brand); color:#fff; font-weight:800; border:0;
      border-radius:10px; padding:12px 16px; cursor:pointer; letter-spacing:.5px;
    }
    button:hover{ opacity:.92; }
    .alert{ border-radius:10px; padding:10px 12px; margin:12px 0; font-size:13px; border:1px solid var(--line); }
    .alert.err{ border-color:rgba(176,0,32,.45); background:rgba(176,0,32,.08); color:#000; }
    .alert.ok{ border-color:rgba(10,122,47,.45); background:rgba(10,122,47,.08); color:#000; }
    .hp{ display:none !important; }
    a{ color:#000; text-decoration:underline; }
    .progressWrap{ margin:10px 0 14px; }
    .progressTop{ display:flex; justify-content:space-between; align-items:center; gap:10px; }
    .progressLabel{ font-size:12px; color:var(--muted); }
    .barOuter{ width:100%; height:12px; border:1px solid var(--line); border-radius:999px; overflow:hidden; background:#f3f3f3; margin-top:6px; }
    .barInner{ height:100%; width:0%; background:var(--brand); }
    .fileHelp{ font-size:12px; color:var(--muted); margin-top:6px; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <h1>DRAWING INFO INTAKE (SKETCHUP LAYOUT TAGS)</h1>
      <p>EMPLOYEES: USE THIS PAGE TO COLLECT DRAWING INFORMATION FROM SKETCHUP LAYOUT TAGS, AHJ PORTALS, PROPERTY APPRAISER RECORDS, AND PERMIT REQUIREMENTS. COMPLETE AS MANY FIELDS AS POSSIBLE, THEN SUBMIT.</p>

      <?php if ($success): ?>
        <div class="alert ok">SUBMISSION SENT SUCCESSFULLY.</div>
      <?php endif; ?>

      <?php if ($errors): ?>
        <div class="alert err">
          <b>REQUIRED CORRECTIONS:</b>
          <ul style="margin:8px 0 0 18px;">
            <?php foreach ($errors as $e): ?>
              <li><?php echo h($e); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data" autocomplete="off">
        <!-- HONEYPOT (LEAVE EMPTY) -->
        <div class="hp">
          <label>WEBSITE</label>
          <input type="text" name="website" value="">
        </div>

        <!-- PROGRESS BAR (UPDATES ONLY ON SUBMIT) -->
        <div class="progressWrap" aria-label="FORM COMPLETION">
          <div class="progressTop">
            <div class="progressLabel">FORM COMPLETION</div>
            <div class="progressLabel"><b><?php echo (int)$progress['pct']; ?>%</b> (<?php echo (int)$progress['filled']; ?> / <?php echo (int)$progress['total']; ?> FIELDS)</div>
          </div>
          <div class="barOuter">
            <div class="barInner" style="width:<?php echo (int)$progress['pct']; ?>%"></div>
          </div>
        </div>

        <div class="grid">
          <div>
            <label>EMPLOYEE NAME (REQUIRED)</label>
            <input type="text" name="employee_name" value="<?php echo h($employee_name); ?>" required>
          </div>
          <div>
            <label>EMPLOYEE EMAIL (OPTIONAL - REPLY-TO)</label>
            <input type="email" name="employee_email" value="<?php echo h($employee_email); ?>">
          </div>
          <div>
            <label>FILE TO BE NAMED: (REQUIRED)</label>
            <input type="text" name="sheet_set" value="<?php echo h($sheet_set); ?>" placeholder="E.G., 14704_CARNATION_PERMIT_SET.layout" required>
          </div>
        </div>

        <?php foreach ($SECTIONS as $section): ?>
          <div class="section">
            <h2><?php echo h((string)$section['title']); ?></h2>
            <div class="help"><?php echo h((string)$section['help']); ?></div>

            <div class="fields">
              <?php foreach ($section['fields'] as $field): ?>
                <div>
                  <?php
                    $key  = (string)$field['key'];
                    $type = (string)$field['type'];
                    $val  = isset($answers[$key]) ? (string)$answers[$key] : '';
                    $ph   = (string)($field['placeholder'] ?? '');

                    // FIELD LABEL SPECIAL CASE: FIND ELEVATION HAS LINK ON FIELD NAME ONLY
                    $labelHtml = h((string)$field['label']);
                    if ($key === 'find_elevation') {
                      $labelHtml = '<a href="https://whatismyelevation.com/" target="_blank" rel="noopener">' . h((string)$field['label']) . '</a>';
                    }
                  ?>
                  <label><?php echo $labelHtml; ?></label>

                  <?php if ($type === 'textarea'): ?>
                    <textarea name="a[<?php echo h($key); ?>]" placeholder="<?php echo h($ph); ?>"><?php echo h($val); ?></textarea>

                  <?php elseif ($type === 'file'): ?>
                    <input type="file" name="license_insurance_upload[]" multiple>
                    <div class="fileHelp">ALLOWED: PDF, JPG, JPEG, PNG, DOC, DOCX | MAX FILES: 10</div>

                  <?php else: ?>
                    <input type="text" name="a[<?php echo h($key); ?>]" value="<?php echo h($val); ?>" placeholder="<?php echo h($ph); ?>">
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- SUBMIT BUTTON AT END OF PAGE -->
        <div class="btnrow">
          <button type="submit">SEND TO SMART CHOICE</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
