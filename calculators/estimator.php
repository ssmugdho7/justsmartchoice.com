<?php
/**
 * Construction Estimator — Florida (single-file, dark theme)
 * - PHP 8.3+ (Bluehost-ready)
 * - Scopes: Windows, Doors, Laminate Flooring, Deck with rails/substructure, House shell (WxL) + egress helper
 * - Customer info (name, phone, address, project name)
 * - Always-populated baseline material prices (edit inline)
 * - Sales tax (materials only) + Markup (your %)
 * - PRG pattern (no duplicate POST on refresh). Refresh shows blank form with sample text; last estimate persists below.
 * - Print/PDF tab (print-friendly; use browser “Save as PDF”)
 */

session_start();

// ===== DEBUG (turn off on production) =====
const DEBUG = true;
if (DEBUG) { ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL); }

// ===== Defaults / Config =====
const APP_NAME               = 'Construction Estimator';
const DEFAULT_LABOR_RATE     = 65.00; // $/hr
const DEFAULT_MARKUP_PCT     = 15.0;  // %
const DEFAULT_SALES_TAX_PCT  = 6.8;   // % materials only

// ---------- Helpers ----------
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function as_float($v,$fallback=0.0){ $n=is_numeric($v)?(float)$v:$fallback; return is_finite($n)?$n:$fallback; }
function clamp($n,$min,$max){ return max($min,min($max,$n)); }
function money($v){ return $v===null? '—' : ('$'.number_format((float)$v,2)); }
function waste_up($qty,$pct=0.10){ return ceil((float)$qty*(1.0+(float)$pct)); }
function hd_link($q){ return "https://www.homedepot.com/s/".urlencode($q); }

// ---------- Data ----------
class LineItem {
  public $category; public $name; public $unit; public $qty; public $unit_price; public $source; public $url;
  function __construct($category,$name,$unit,$qty,$unit_price,$source,$url=null){
    $this->category=$category; $this->name=$name; $this->unit=$unit; $this->qty=(float)$qty;
    $this->unit_price=$unit_price===null? null : (float)$unit_price; $this->source=$source; $this->url=$url;
  }
  function ext(){ return $this->unit_price===null? null : $this->qty*$this->unit_price; }
}

class Estimate {
  public $items=[]; public $labor_rate; public $markup_rate; public $sales_tax_rate;
  public $customer=[]; // name, phone, address, project
  public $notes=[];     // project-aware notes
  function __construct($labor_rate,$markup_rate,$sales_tax_rate,$customer=[]){
    $this->labor_rate=(float)$labor_rate;
    $this->markup_rate=clamp((float)$markup_rate,0.0,1.0);
    $this->sales_tax_rate=clamp((float)$sales_tax_rate,0.0,1.0);
    $this->customer=$customer;
  }
  function add($li){ $this->items[]=$li; }
  function add_note($txt){ if($txt && !in_array($txt,$this->notes,true)) $this->notes[]=$txt; }
  function totals(){
    $mat=0.0; $labor=0.0; $mat_unknown=false;
    foreach($this->items as $li){
      if($li->category==='material'){
        $e=$li->ext();
        if($e===null){ $mat_unknown=true; } else { $mat+=$e; }
      }elseif($li->category==='labor'){
        if($li->unit==='hr'){ $labor += ($li->qty * $this->labor_rate); }
        else { $e=$li->ext(); if($e!==null) $labor += $e; }
      }
    }
    $tax    = $mat * $this->sales_tax_rate;     // materials only
    $sub    = $mat + $labor;
    $markup = $sub * $this->markup_rate;
    $grand  = $sub + $tax + $markup;
    return ['materials_known'=>!$mat_unknown,'materials'=>$mat,'labor'=>$labor,'tax'=>$tax,'markup'=>$markup,'total'=>$grand];
  }
}

// ---------- Baseline material pricing (Florida-tuned placeholders; edit to taste) ----------
function price_baseline($key, $ctx=[]){
  switch($key){
    // Impact window — rough size-based pricing (vinyl impact)
    case 'impact_window_each': {
      $w = isset($ctx['w'])?(float)$ctx['w']:36; // inches
      $h = isset($ctx['h'])?(float)$ctx['h']:37;
      $sf = ($w*$h)/144.0;
      return round(80 + 45*$sf, 2); // $80 fixed + $45/sf glazed
    }
    // Impact prehung exterior door
    case 'impact_door_each': return 750.00;

    // Window/door accessories
    case 'flashing_tape_roll':       return 25.00;
    case 'sealant_tube':             return 8.00;
    case 'window_foam_can':          return 7.50;
    case 'stainless_screws_box':     return 12.00;
    case 'door_shims_pack':          return 6.00;
    case 'door_foam_can':            return 7.50;
    case 'door_sealant_tube':        return 8.00;
    case 'door_stainless_lb':        return 14.00;
    case 'door_casing_set':          return 45.00;
    case 'door_threshold':           return 40.00;
    case 'door_lockset':             return 65.00;
    case 'hurricane_tie_each':       return 2.50;

    // Laminate flooring kit
    case 'lam_case_20sf':            return 36.00; // ~$1.80/sf
    case 'underlayment_100sf':       return 35.00;
    case 'quarter_round_lf':         return 1.20;
    case 'transition_each':          return 25.00;
    case 'moisture_tape_each':       return 12.00;

    // Deck (pressure-treated)
    case 'deck_board_5/4x6_16ft':    return 18.00; // per board
    case 'deck_joist_2x10_12ft':     return 19.00;
    case 'deck_beam_2x10_16ft':      return 28.00;
    case 'deck_post_6x6_8ft':        return 28.00;
    case 'concrete_bag_60lb':        return 5.50;
    case 'deck_screw_box_5lb':       return 35.00;
    case 'rail_kit_6ft':             return 78.00; // simple kit per 6 ft
    case 'joist_hanger_each':        return 1.25;

    // House shell basics
    case 'slab_concrete_cy':         return 145.00; // per cubic yard ready-mix
    case 'rebar_stick_20ft':         return 12.00;
    case 'osb_7/16_4x8':             return 13.50;
    case 'stud_2x4x8':               return 4.25;
    case 'plate_2x4x8':              return 4.25;
    case 'shingle_bundle':           return 35.00;
    case 'roof_underlayment_roll':   return 95.00;
    case 'drywall_1/2_4x8':          return 10.50;
    case 'drywall_screws_5lb':       return 24.00;
    case 'insulation_r13_bag':       return 55.00;
    default: return null;
  }
}
function hd($q){ return hd_link($q); }

// ---------- Parsers ----------
function parse_all_scopes($desc){
  $d = strtolower($desc);
  $out = ['windows'=>[], 'doors'=>[], 'floor_sf'=>0, 'deck'=>null, 'house'=>null];

  // windows: "3 windows 36x37"
  if(preg_match_all('/(\d+)\s*windows?\s*(\d{2,3})\s*[xX]\s*(\d{2,3})/', $d, $ms, PREG_SET_ORDER)){
    foreach($ms as $m){ $out['windows'][]=[(int)$m[1], (int)$m[2], (int)$m[3]]; }
  }
  // doors: "2 doors 36x80" or "2 doors"
  if(preg_match_all('/(\d+)\s*doors?(?:\s*(\d{2,3})\s*[xX]\s*(\d{2,3}))?/', $d, $ms, PREG_SET_ORDER)){
    foreach($ms as $m){
      $w = isset($m[2]) && $m[2]!=='' ? (int)$m[2] : 36;
      $h = isset($m[3]) && $m[3]!=='' ? (int)$m[3] : 80;
      $out['doors'][]=[(int)$m[1], $w, $h];
    }
  }
  // laminate floor: "300 sq ft laminate" (accept ft, sqft, sf)
  if(preg_match('/(\d+(?:\.\d+)?)\s*(?:sq\.?\s*ft|sqft|sf|ft|feet)\s*(?:of)?\s*(?:laminate|laminated|lvp|vinyl|wood|floor|flooring)/', $d, $m)){
    $out['floor_sf']=(float)$m[1];
  }
  // deck WxL: "deck 12x16" or "installing a deck with rails 12 x 16"
  if(strpos($d,'deck')!==false && preg_match('/(\d+(?:\.\d+)?)\s*ft?\s*[xX]\s*(\d+(?:\.\d+)?)\s*ft?/', $d, $m)){
    $out['deck']=['w'=>(float)$m[1], 'l'=>(float)$m[2]];
  }elseif(strpos($d,'deck')!==false){
    $out['deck']=['w'=>12.0, 'l'=>16.0]; // default
  }
  // house shell WxL: "house 23ft x 50" / "building a 23ftx50 florida house"
  if(strpos($d,'house')!==false && preg_match('/(\d+(?:\.\d+)?)\s*ft?\s*[xX]\s*(\d+(?:\.\d+)?)\s*ft?/', $d, $m)){
    $out['house']=['w'=>(float)$m[1], 'l'=>(float)$m[2]];
  }
  return $out;
}

// ---------- Scope builders (adds items + notes) ----------
function add_windows_fl(Estimate $est, $count, $w, $h){
  $price = price_baseline('impact_window_each', ['w'=>$w,'h'=>$h]);
  $est->add(new LineItem('material', "Impact-rated window {$w}x{$h}", 'ea', $count, $price, 'Home Depot', hd("impact rated window {$w} in x {$h} in")));
  $est->add(new LineItem('material', 'Flashing tape roll', 'roll', max(1,ceil($count/3)), price_baseline('flashing_tape_roll'), 'Home Depot', hd('flashing tape window')));
  $est->add(new LineItem('material', 'Polyurethane exterior sealant (tube)', 'tube', $count, price_baseline('sealant_tube'), 'Home Depot', hd('polyurethane exterior sealant')));
  $est->add(new LineItem('material', 'Low-expansion window/door foam', 'can', $count, price_baseline('window_foam_can'), 'Home Depot', hd('window and door foam')));
  $est->add(new LineItem('material', 'Corrosion-resistant screws', 'box', max(1,ceil($count/4)), price_baseline('stainless_screws_box'), 'Home Depot', hd('stainless exterior screws 2-1/2 in')));
  $est->add(new LineItem('labor', "Install impact window {$w}x{$h}", 'hr', $count*2.5, null, 'Homewyse', 'https://www.homewyse.com/services/cost_to_install_window.html'));
  $est->add_note('Windows: impact-rated for Florida; verify NOA/FL approvals and inspection requirements.');
}

function add_doors_fl(Estimate $est, $count, $w, $h){
  $est->add(new LineItem('material', "Impact-rated prehung door {$w}x{$h}", 'ea', $count, price_baseline('impact_door_each'), 'Home Depot', hd("impact rated prehung door {$w} in x {$h} in")));
  $extras = [
    ['Shims (pack)',                        max(1,ceil($count/2)), price_baseline('door_shims_pack'),      'door shims pack'],
    ['Spray foam (low-expansion)',          $count,                 price_baseline('door_foam_can'),       'window and door foam'],
    ['Exterior polyurethane sealant (tube)',$count,                 price_baseline('door_sealant_tube'),   'polyurethane exterior sealant'],
    ['Stainless/galv. screws (1 lb)',       max(1,ceil($count/4)), price_baseline('door_stainless_lb'),   'stainless steel construction screws 2.5 in 1 lb'],
    ['Door casing/trim (set)',              $count,                 price_baseline('door_casing_set'),     'door casing kit'],
    ['Threshold/sill (exterior)',           $count,                 price_baseline('door_threshold'),      'door threshold'],
    ['Lockset/handle (impact-rated)',       $count,                 price_baseline('door_lockset'),        'impact rated door lockset'],
    ['Hurricane ties/straps (ea)',          max(4,$count*4),        price_baseline('hurricane_tie_each'),  'Simpson Strong-Tie hurricane ties']
  ];
  foreach($extras as $e){
    $est->add(new LineItem('material',$e[0],'ea',$e[1],$e[2],'Home Depot',hd($e[3])));
  }
  $est->add(new LineItem('labor', "Install impact prehung door {$w}x{$h}", 'hr', $count*3.0, null, 'Homewyse','https://www.homewyse.com/services/cost_to_install_door.html'));
  $est->add_note('Doors: impact-rated prehung; includes sealant/foam/shims, stainless fasteners, threshold, lockset, and hurricane ties (as needed).');
}

function add_laminate(Estimate $est, $sf){
  if($sf<=0) return;
  $sf_waste = waste_up($sf,0.10);
  $cases = ceil($sf_waste / 20.0);
  $rolls = ceil($sf_waste / 100.0);
  $qtr   = ceil($sf_waste / 2.0);
  $trans = max(1, ceil($sf / 200.0));
  $est->add(new LineItem('material','Laminate flooring (cases)','case',$cases,price_baseline('lam_case_20sf'),'Home Depot',hd('laminate flooring case')));
  $est->add(new LineItem('material','Underlayment (rolls)','roll',$rolls,price_baseline('underlayment_100sf'),'Home Depot',hd('laminate underlayment roll')));
  $est->add(new LineItem('material','Quarter-round/base shoe (LF)','lf',$qtr,price_baseline('quarter_round_lf'),'Home Depot',hd('quarter round molding')));
  $est->add(new LineItem('material','Transition strips','ea',$trans,price_baseline('transition_each'),'Home Depot',hd('transition strip laminate')));
  $est->add(new LineItem('material','Vapor barrier / moisture tape','ea',1,price_baseline('moisture_tape_each'),'Home Depot',hd('vapor barrier tape laminate')));
  $est->add(new LineItem('labor','Install laminate flooring','hr',$sf*0.06,null,'Homewyse','https://www.homewyse.com/services/cost_to_install_laminate_flooring.html'));
  $est->add_note('Laminate: includes underlayment, transitions, quarter round, and moisture tape. Adjust for layout and trim color.');
}

function add_deck(Estimate $est, $w, $l){
  // VERY rough PT deck model: attached on one long side, 16" OC joists, 6' post spacing
  $area = $w*$l;
  $perim_rails = $l + 2*$w; // attached on one long side
  // Decking boards 5/4x6x16’ coverage ~ 7.33 sqft/board
  $deck_boards = waste_up(ceil($area / 7.33), 0.07);
  // Joists along length: spacing 16" (~1.333 ft). Count across width.
  $joists = ceil(($w / (16/12))) + 1;
  $joist_len_ft = $l;
  $joist_pieces_12ft = ceil(($joists * $joist_len_ft) / 12.0); // 12 ft sticks
  // Beams (2-ply 2x10) along posts roughly every 6 ft along length, two rows
  $post_rows = 2; $posts_per_row = max(2, ceil($l / 6)+1); $posts = $post_rows * $posts_per_row;
  $beam_len_total = 2 * $l; // two beams along length; buy 16' pieces
  $beam_pieces_16ft = ceil($beam_len_total / 16.0) * 2; // 2-ply
  $bags_concrete = $posts * 2; // 2 bags 60lb per post
  $rail_kits_6ft = ceil($perim_rails / 6.0);
  $hangers = $joists * 2;

  // Materials
  $est->add(new LineItem('material',"Decking 5/4x6x16' (boards)",'ea',$deck_boards,price_baseline('deck_board_5/4x6_16ft'),'Home Depot',hd('5/4 in. x 6 in. x 16 ft pressure-treated decking')));
  $est->add(new LineItem('material',"Joists 2x10x12' (sticks)",'ea',$joist_pieces_12ft,price_baseline('deck_joist_2x10_12ft'),'Home Depot',hd('2x10x12 pressure treated')));
  $est->add(new LineItem('material',"Beams 2x10x16' (sticks, 2-ply)",'ea',$beam_pieces_16ft,price_baseline('deck_beam_2x10_16ft'),'Home Depot',hd('2x10x16 pressure treated')));
  $est->add(new LineItem('material',"Posts 6x6x8'",'ea',$posts,price_baseline('deck_post_6x6_8ft'),'Home Depot',hd('6x6x8 pressure treated')));
  $est->add(new LineItem('material','Concrete mix 60 lb (post footings)','bag',$bags_concrete,price_baseline('concrete_bag_60lb'),'Home Depot',hd('60 lb concrete mix')));
  $est->add(new LineItem('material','Joist hangers','ea',$hangers,price_baseline('joist_hanger_each'),'Home Depot',hd('joist hanger')));
  $est->add(new LineItem('material','Deck screws 5 lb','box',max(1,ceil($deck_boards/60)),price_baseline('deck_screw_box_5lb'),'Home Depot',hd('deck screws 5 lb')));
  $est->add(new LineItem('material','Rail kits (6 ft)','ea',$rail_kits_6ft,price_baseline('rail_kit_6ft'),'Home Depot',hd('deck rail kit 6 ft')));

  // Labor
  $est->add(new LineItem('labor','Deck framing & decking install','hr', max(16, $area*0.25), null, 'Homewyse','https://www.homewyse.com/'));
  $est->add_note("Deck {$w}x{$l}: includes rails and substructure; verify footing sizes, ledger detail, and local permitting.");
}

function add_house_shell(Estimate $est, $w, $l){
  $area = $w*$l;                 // floor sqft
  $perim = 2*($w+$l);
  $wall_h = 8.0;
  $wall_area = $perim * $wall_h;
  $roof_area = $area * 1.25;     // simple gable factor

  // Slab concrete: assume 4" thick; volume in cubic yards
  $slab_cy = ($area * (4.0/12.0)) / 27.0;
  $rebar_sticks = ceil($perim / 2.0); // rough; adjust to spec

  // Framing
  $studs = ceil(($perim / (16/12))) + 20; // extra for corners/headers
  $plates = ceil($perim/8)*3;             // double top + bottom

  // Sheathing & drywall
  $wall_sheets = waste_up(ceil($wall_area/32),0.10); // 4x8=32 sqft
  $roof_sheets = waste_up(ceil($roof_area/32),0.10);
  $drywall_sheets = waste_up(ceil($wall_area/32),0.10);
  $drywall_boxes = ceil($drywall_sheets/20);
  $insul_bags = ceil($wall_area/120);

  // Roofing
  $roof_squares = ceil($roof_area/100);
  $shingle_bundles = $roof_squares*3;
  $underlayment_rolls = ceil($roof_area/1000);

  // Materials
  $est->add(new LineItem('material',"Slab concrete (cubic yards)",'cy',round($slab_cy,2),price_baseline('slab_concrete_cy'),'Home Depot',hd('concrete ready mix')));
  $est->add(new LineItem('material',"Rebar 20' sticks",'ea',$rebar_sticks,price_baseline('rebar_stick_20ft'),'Home Depot',hd('rebar 20 ft')));

  $est->add(new LineItem('material','2x4x8 studs (16" O.C.)','ea',$studs,price_baseline('stud_2x4x8'),'Home Depot',hd('2x4x8 stud')));
  $est->add(new LineItem('material','2x4x8 plates (top+bottom)','ea',$plates,price_baseline('plate_2x4x8'),'Home Depot',hd('2x4x8')));
  $est->add(new LineItem('material','Wall sheathing OSB 7/16" 4x8','sheet',$wall_sheets,price_baseline('osb_7/16_4x8'),'Home Depot',hd('OSB 7/16 4x8')));

  $est->add(new LineItem('material','Roof sheathing OSB 7/16" 4x8','sheet',$roof_sheets,price_baseline('osb_7/16_4x8'),'Home Depot',hd('OSB 7/16 4x8')));
  $est->add(new LineItem('material','Shingles (architectural) bundles','bundle',$shingle_bundles,price_baseline('shingle_bundle'),'Home Depot',hd('architectural shingles')));
  $est->add(new LineItem('material','Synthetic roof underlayment','roll',$underlayment_rolls,price_baseline('roof_underlayment_roll'),'Home Depot',hd('synthetic roof underlayment')));

  $est->add(new LineItem('material','Drywall 1/2" 4x8 (walls)','sheet',$drywall_sheets,price_baseline('drywall_1/2_4x8'),'Home Depot',hd('drywall 1/2 4x8')));
  $est->add(new LineItem('material','Drywall screws 5 lb','box',$drywall_boxes,price_baseline('drywall_screws_5lb'),'Home Depot',hd('drywall screws 5 lb')));
  $est->add(new LineItem('material','Insulation R-13 (walls) bags','bag',$insul_bags,price_baseline('insulation_r13_bag'),'Home Depot',hd('R-13 insulation')));

  // Egress helper (very rough): assume 2 bedrooms -> 2 egress windows
  $egress_count = 2;
  $est->add(new LineItem('material','Egress windows (≥5.7 sq ft net clear opening)','ea',$egress_count,price_baseline('impact_window_each',['w'=>36,'h'=>60]),'Home Depot',hd('impact egress window')));
  $est->add_note("House {$w}x{$l}: shell estimate (slab, framing, sheathing, roofing, walls). Includes 2 egress windows (≥5.7 sq ft net clear opening); verify bedroom count and code specifics. Doors assumed separately.");

  // Labor — coarse hour factors
  $est->add(new LineItem('labor','Slab, framing, roofing, drywall, insulation','hr', max(80, $area*0.35), null, 'Homewyse','https://www.homewyse.com/'));
}

// ---------- Build from description ----------
function build_estimate($desc, $rate, $markup_rate, $tax_rate, $customer){
  $parsed = parse_all_scopes($desc);
  $est = new Estimate($rate,$markup_rate,$tax_rate,$customer);

  foreach($parsed['windows'] as $s){ list($cnt,$w,$h)=$s; add_windows_fl($est,$cnt,$w,$h); }
  foreach($parsed['doors'] as $s){ list($cnt,$w,$h)=$s; add_doors_fl($est,$cnt,$w,$h); }
  if($parsed['floor_sf']>0) add_laminate($est,$parsed['floor_sf']);
  if($parsed['deck']) add_deck($est,$parsed['deck']['w'],$parsed['deck']['l']);
  if($parsed['house']) add_house_shell($est,$parsed['house']['w'],$parsed['house']['l']);

  if(!$est->items){ // fallback if nothing detected
    $est->add(new LineItem('labor','General labor (placeholder)','hr',8,null,'Manual','https://www.homewyse.com/'));
    $est->add_note('No specific scope recognized — adjust your description or add sizes.');
  }
  return $est;
}

// ---------- PRG: handle actions ----------
if(isset($_GET['reset'])){ unset($_SESSION['estimate']); header("Location: ".$_SERVER['PHP_SELF']); exit; }

if($_SERVER['REQUEST_METHOD']==='POST'){
  // Read form
  $desc   = trim($_POST['description'] ?? '');
  $rate   = as_float($_POST['labor_rate'] ?? DEFAULT_LABOR_RATE, DEFAULT_LABOR_RATE);
  $markup = clamp(as_float($_POST['markup_percent'] ?? DEFAULT_MARKUP_PCT, DEFAULT_MARKUP_PCT), 0, 95)/100.0;
  $tax    = clamp(as_float($_POST['sales_tax_percent'] ?? DEFAULT_SALES_TAX_PCT, DEFAULT_SALES_TAX_PCT), 0, 12)/100.0;

  $customer = [
    'name'    => trim($_POST['customer_name'] ?? ''),
    'phone'   => trim($_POST['customer_phone'] ?? ''),
    'address' => trim($_POST['customer_address'] ?? ''),
    'project' => trim($_POST['project_name'] ?? ''),
  ];

  $est = build_estimate($desc,$rate,$markup,$tax,$customer);

  // Apply optional inline unit price edits (coming from line-items form)
  if(isset($_POST['unit_price']) && is_array($_POST['unit_price'])){
    foreach($_POST['unit_price'] as $i=>$val){
      if(isset($est->items[$i]) && $est->items[$i]->category==='material'){
        $p = trim((string)$val);
        $est->items[$i]->unit_price = ($p==='' ? $est->items[$i]->unit_price : as_float($p,$est->items[$i]->unit_price));
      }
    }
  }

  $_SESSION['estimate'] = serialize($est);
  header("Location: ".$_SERVER['PHP_SELF']."?result=1");
  exit;
}

// Load last estimate for display (GET)
$EST = isset($_SESSION['estimate']) ? @unserialize($_SESSION['estimate']) : null;
$PRINT = (isset($_GET['view']) && $_GET['view']==='print');

// ---------- View ----------
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= h(APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{ background:#0b1220; color:#ffffff; }
  .card{ background:#1c1f2b; color:#ffffff; border:1px solid rgba(255,255,255,0.08); }
  .table thead th{ position:sticky; top:0; background:#11192a; color:#cbd5e1; z-index:1; }
  .table td, .table th{ color:#ffffff; }
  a{ color:#8ecaff; }
  input.form-control, textarea.form-control{ background:#0b1220; color:#fff; border-color:#31436b; }
  .btn-primary{ background:#2f6feb; border-color:#2f6feb; }
  .badge-src{ background:#22304f; }
  .nav-tabs .nav-link{ color:#cbd5e1; }
  .nav-tabs .nav-link.active{ background:#1c1f2b; border-color:#2b395a; color:#fff; }
  @media print {
    body{ background:#fff; color:#000; }
    .card{ background:#fff; color:#000; border:0; }
    .table th, .table td{ color:#000 !important; }
    .no-print{ display:none !important; }
  }
</style>
</head>
<body>
<div class="container py-4">
  <div class="d-flex align-items-center mb-3">
    <h1 class="me-auto">🧮 <?= h(APP_NAME) ?> — Florida</h1>
    <div class="no-print">
      <a class="btn btn-outline-light me-2" href="<?= h($_SERVER['PHP_SELF']) ?>">Estimator</a>
      <a class="btn btn-outline-light me-2" href="<?= h($_SERVER['PHP_SELF'].'?view=print') ?>">PDF / Print</a>
      <a class="btn btn-outline-danger" href="<?= h($_SERVER['PHP_SELF'].'?reset=1') ?>">New Estimate</a>
    </div>
  </div>

  <?php if(!$PRINT): ?>
  <!-- Tabs -->
  <ul class="nav nav-tabs no-print mb-3">
    <li class="nav-item"><span class="nav-link active">Estimate</span></li>
    <li class="nav-item"><a class="nav-link" href="<?= h($_SERVER['PHP_SELF'].'?view=print') ?>">PDF / Print</a></li>
  </ul>

  <!-- Form (blank on GET; sample placeholder) -->
  <div class="card mb-4 no-print">
    <div class="card-body">
      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Customer name</label>
          <input name="customer_name" class="form-control" placeholder="Jane Contractor">
        </div>
        <div class="col-md-3">
          <label class="form-label">Phone</label>
          <input name="customer_phone" class="form-control" placeholder="(555) 123-4567">
        </div>
        <div class="col-md-3">
          <label class="form-label">Project name</label>
          <input name="project_name" class="form-control" placeholder="Windows & Flooring">
        </div>
        <div class="col-12">
          <label class="form-label">Address</label>
          <input name="customer_address" class="form-control" placeholder="123 Palm Ave, Miami, FL 33101">
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">Project description</label>
          <input name="description" type="text" class="form-control form-control-lg"
            placeholder="Sample: 3 windows 36x37, 2 doors 36x80, 300 sq ft laminate; or deck 12x16 with rails; or house 23ft x 50"
            required>
          <div class="form-text">Florida defaults: impact-rated windows/doors; deck is PT; house is shell (slab, framing, roof, walls) with egress helper.</div>
        </div>

        <div class="col-md-3">
          <label class="form-label">Labor rate ($/hr)</label>
          <input name="labor_rate" type="number" step="0.01" class="form-control" value="<?= h(number_format(DEFAULT_LABOR_RATE,2,'.','')) ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label">Markup (%)</label>
          <input name="markup_percent" type="number" step="0.1" min="0" max="95" class="form-control" value="<?= h(number_format(DEFAULT_MARKUP_PCT,1,'.','')) ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label">Sales tax (%)</label>
          <input name="sales_tax_percent" type="number" step="0.1" min="0" max="12" class="form-control" value="<?= h(number_format(DEFAULT_SALES_TAX_PCT,1,'.','')) ?>">
          <div class="form-text">Tax applies to <b>materials only</b>.</div>
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button class="btn btn-primary btn-lg w-100" type="submit">Generate / Recalculate</button>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <!-- Results (if exist) -->
  <?php if($EST instanceof Estimate): $T=$EST->totals(); ?>
  <div class="card <?= $PRINT?'':'mb-4' ?>">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div>
          <h4 class="mb-1"><?= h($EST->customer['project'] ?: 'Estimate') ?></h4>
          <div><?= h($EST->customer['name'] ?: '') ?></div>
          <div><?= h($EST->customer['phone'] ?: '') ?></div>
          <div><?= h($EST->customer['address'] ?: '') ?></div>
        </div>
        <?php if(!$PRINT): ?>
        <div class="text-end no-print">
          <a class="btn btn-outline-light btn-sm" href="<?= h($_SERVER['PHP_SELF'].'?view=print') ?>">Open Print/PDF</a>
        </div>
        <?php endif; ?>
      </div>

      <div class="table-responsive mt-3">
        <form method="post" class="no-print">
          <!-- keep summary inputs so recalculation preserves settings -->
          <input type="hidden" name="customer_name" value="<?= h($EST->customer['name']) ?>">
          <input type="hidden" name="customer_phone" value="<?= h($EST->customer['phone']) ?>">
          <input type="hidden" name="customer_address" value="<?= h($EST->customer['address']) ?>">
          <input type="hidden" name="project_name" value="<?= h($EST->customer['project']) ?>">
          <input type="hidden" name="description" value="(recalc)">
          <input type="hidden" name="labor_rate" value="<?= h($EST->labor_rate) ?>">
          <input type="hidden" name="markup_percent" value="<?= h(number_format($EST->markup_rate*100,1,'.','')) ?>">
          <input type="hidden" name="sales_tax_percent" value="<?= h(number_format($EST->sales_tax_rate*100,1,'.','')) ?>">

          <table class="table table-sm align-middle">
            <thead>
              <tr>
                <th>Type</th>
                <th>Item</th>
                <th class="text-end">Qty</th>
                <th>Unit</th>
                <th class="text-end">Unit Price</th>
                <th class="text-end">Ext</th>
                <th>Source</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($EST->items as $i=>$li): ?>
              <tr>
                <td><?= h(ucfirst($li->category)) ?></td>
                <td>
                  <?php if($li->url): ?><a target="_blank" href="<?= h($li->url) ?>"><?php endif; ?>
                  <?= h($li->name) ?>
                  <?php if($li->url): ?></a><?php endif; ?>
                </td>
                <td class="text-end"><?= h(number_format($li->qty,2)) ?></td>
                <td><?= h($li->unit) ?></td>
                <td class="text-end" style="width:140px;">
                  <?php if($li->category==='material' && !$PRINT): ?>
                    <input name="unit_price[<?= $i ?>]" type="number" step="0.01" class="form-control form-control-sm text-end"
                           value="<?= h(number_format($li->unit_price??0,2,'.','')) ?>">
                  <?php else: ?>
                    <?= money($li->unit_price) ?>
                  <?php endif; ?>
                </td>
                <td class="text-end"><?= money($li->ext()) ?></td>
                <td><span class="badge badge-src"><?= h($li->source) ?></span></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <?php if(!$PRINT): ?>
          <div class="d-flex justify-content-end">
            <button class="btn btn-outline-light">Recalculate with edited prices</button>
          </div>
          <?php endif; ?>
        </form>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-5">
          <div class="p-3 border border-dark rounded-3">
            <div class="d-flex justify-content-between"><span>Materials</span><strong><?= money($T['materials']) ?></strong></div>
            <div class="d-flex justify-content-between"><span>Labor</span><strong><?= money($T['labor']) ?></strong></div>
            <div class="d-flex justify-content-between"><span>Sales tax (<?= h(number_format($EST->sales_tax_rate*100,1)) ?>%)</span><strong><?= money($T['tax']) ?></strong></div>
            <div class="d-flex justify-content-between"><span>Markup (<?= h(number_format($EST->markup_rate*100,1)) ?>%)</span><strong><?= money($T['markup']) ?></strong></div>
            <hr/>
            <div class="d-flex justify-content-between fs-5"><span>Total</span><strong><?= money($T['total']) ?></strong></div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="p-3 border border-dark rounded-3">
            <h6>Project notes</h6>
            <ul class="mb-0">
              <?php foreach($EST->notes as $n): ?><li><?= h($n) ?></li><?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

      <?php if($PRINT): ?>
        <script>window.print();</script>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

  <?php if(!$EST): ?>
  <div class="card">
    <div class="card-body">
      <h5>How to type your project</h5>
      <ul class="mb-0">
        <li><code>3 windows 36x37, 2 doors 36x80, 300 sq ft laminate</code></li>
        <li><code>installing a deck with rails 12x16</code></li>
        <li><code>building a 23ft x 50 florida house</code></li>
      </ul>
      <div class="mt-2">This tool will estimate typical materials + labor for Florida, with impact-rated openings and hurricane hardware in mind. Always verify code, NOA/FL approvals, and site conditions.</div>
    </div>
  </div>
  <?php endif; ?>

  <footer class="text-center text-secondary mt-4">
    <small>&copy; <?= date('Y') ?> — <?= h(APP_NAME) ?>. Baseline prices are placeholders; confirm against chosen products.</small>
  </footer>
</div>
</body>
</html>
