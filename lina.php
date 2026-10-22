<?php
// calculadora_ml_auto.php
// Página única PHP + JS que:
// 1) Obtiene TRM automática (Socrata/Datos Abiertos). Fallbacks incluidos.
// 2) Consulta Listing Prices API de Mercado Libre (site_id=MCO) para comisión y tarifa fija.
// 3) Calcula break-even, precio con margen y sugerido, con slider de markup.
// 4) Deja ganchos para integrar costos de envío por API con token (opcional).

?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Calculadora automática • Mercado Libre Colombia</title>
<style>
  :root{--bg:#0f172a;--panel:#111827;--muted:#94a3b8;--text:#e5e7eb;--accent:#22c55e;--border:#1f2937;--card:#0b1220;--input:#0b1220}
  *{box-sizing:border-box} body{margin:0;background:radial-gradient(1200px 600px at 10% -10%,#1b2a4b 0,rgba(0,0,0,0) 60%),var(--bg);color:var(--text);font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Arial}
  .container{max-width:1100px;margin:28px auto;padding:0 16px}
  .title{font-size:28px;font-weight:700;margin-bottom:6px}
  .subtitle{color:var(--muted);margin-bottom:24px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:18px} @media(max-width:980px){.grid{grid-template-columns:1fr}}
  .card{background:linear-gradient(180deg,rgba(255,255,255,.03),rgba(255,255,255,0));border:1px solid var(--border);border-radius:16px;padding:16px 16px 8px;box-shadow:0 6px 18px rgba(0,0,0,.35),inset 0 1px 0 rgba(255,255,255,.05)}
  .card h3{margin:0 0 10px;font-size:16px;color:#c7d2fe;letter-spacing:.3px}
  .row{display:grid;grid-template-columns:1.3fr 1fr .9fr;gap:10px;align-items:center;margin:8px 0}
  .row label{font-size:13px}.row input,.row select{width:100%;padding:10px 12px;background:var(--input);color:var(--text);border:1px solid var(--border);border-radius:10px;outline:none}
  .row small{color:var(--muted);font-size:12px}.muted{color:var(--muted);font-size:12px}.hint{font-size:12px;color:var(--muted);margin-top:2px}
  .results{display:grid;grid-template-columns:repeat(2,1fr);gap:16px} @media(max-width:980px){.results{grid-template-columns:1fr}}
  .kpi{background:linear-gradient(180deg,rgba(34,197,94,.08),rgba(34,197,94,.02));border:1px solid var(--border);border-radius:14px;padding:14px}
  .kpi .label{font-size:12px;color:var(--muted)} .kpi .value{font-size:24px;font-weight:700;margin-top:6px}
  .sep{height:1px;background:var(--border);margin:12px 0}
  .flex{display:flex;gap:10px;align-items:center}
  .badge{display:inline-block;padding:2px 8px;border:1px solid var(--border);border-radius:999px;font-size:12px;color:var(--muted)}
  .btn{background:var(--accent);color:#062e12;border:0;border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer}
  table{width:100%;border-collapse:collapse} th,td{padding:8px 10px;border-bottom:1px solid var(--border);font-size:13px} th{text-align:left;color:#c7d2fe}
  .right{text-align:right}
</style>
</head>
<body>
<div class="container">
  <div class="title">Calculadora automática • Mercado Libre Colombia</div>
  <div class="subtitle">TRM y comisiones por API. Ajusta el <strong>markup</strong> y obtén el <strong>precio de venta</strong> sin perder dinero.</div>

  <div class="grid">
    <div class="card">
      <h3>Entradas</h3>

      <div class="row">
        <label for="price_usd">Costo del producto (USD)</label>
        <input id="price_usd" type="number" step="0.01" value="50">
        <small>Precio proveedor</small>
      </div>
      <div class="row">
        <label for="us_ship">Envío doméstico en EE.UU. (USD)</label>
        <input id="us_ship" type="number" step="0.01" value="5">
        <small>De tienda a courier</small>
      </div>
      <div class="row">
        <label for="ins">Seguro/otros (USD)</label>
        <input id="ins" type="number" step="0.01" value="0">
        <small>Opcional</small>
      </div>
      <div class="row">
        <label for="intl_ship">Flete internacional (USD)</label>
        <input id="intl_ship" type="number" step="0.01" value="10">
        <small>A Colombia</small>
      </div>

      <div class="row">
        <label for="trm">TRM (COP/USD)</label>
        <input id="trm" type="number" step="1" value="0">
        <small id="trm_note">Se actualiza automático</small>
      </div>

      <div class="sep"></div>

      <div class="row">
        <label for="duty">Arancel importación (%)</label>
        <input id="duty" type="number" step="0.01" value="10">
        <small>Base tráfico postal</small>
      </div>
      <div class="row">
        <label for="iva_imp">IVA importación (%)</label>
        <input id="iva_imp" type="number" step="0.01" value="19">
        <small>General 19%</small>
      </div>
      <div class="row">
        <label for="nac">Nacionalización (COP)</label>
        <input id="nac" type="number" step="1" value="20000">
        <small>Courier/gestor</small>
      </div>

      <div class="sep"></div>

      <div class="row">
        <label for="category">Categoría ML (category_id)</label>
        <input id="category" type="text" value="">
        <small>Opcional pero recomendado</small>
      </div>
      <div class="row">
        <label for="listing_type">Tipo de publicación</label>
        <select id="listing_type">
          <option value="gold_special">Clásica (gold_special)</option>
          <option value="gold_pro">Premium (gold_pro)</option>
        </select>
        <small>Clásica / Premium</small>
      </div>

      <div class="row">
        <label for="local_ship">Envío dentro de Colombia (COP)</label>
        <input id="local_ship" type="number" step="1" value="10000">
        <small>Mercado Envíos</small>
      </div>

      <div class="sep"></div>

      <div class="row">
        <label for="mp_ret">Retenciones/pasarela (%)</label>
        <input id="mp_ret" type="number" step="0.01" value="2">
        <small>Mercado Pago/ICA</small>
      </div>
      <div class="row">
        <label for="ica_pct">ICA municipal (%)</label>
        <input id="ica_pct" type="number" step="0.01" value="0.7">
        <small>Según ciudad/CIIU</small>
      </div>

      <div class="row">
        <label for="margin">Markup/Margen objetivo (%)</label>
        <input id="margin" type="number" step="0.5" value="20">
        <div class="flex">
          <input id="margin_slider" type="range" min="0" max="60" step="0.5" value="20" style="width:100%">
          <span class="badge" id="margin_badge">20%</span>
        </div>
      </div>

      <div class="sep"></div>

      <div class="row">
        <label for="meli_token">Token Mercado Libre (opcional)</label>
        <input id="meli_token" type="text" placeholder="Bearer eyJ...">
        <small>Requerido si conectas APIs protegidas</small>
      </div>
      <div class="hint">Con token podrás más adelante estimar <b>envío por API</b> y otras funciones avanzadas.</div>

      <div class="flex" style="margin-top:10px">
        <button class="btn" id="recalc">Calcular</button>
        <span class="muted">TRM y comisión se actualizan solas; puedes recalcular manualmente.</span>
      </div>
    </div>

    <div class="card">
      <h3>Resultados</h3>
      <div class="results">
        <div class="kpi">
          <div class="label">Costo puesto en CO (Landed)</div>
          <div class="value" id="landed">—</div>
          <div class="hint">CIF + arancel + IVA imp. + nacionalización</div>
        </div>
        <div class="kpi">
          <div class="label">Precio de equilibrio</div>
          <div class="value" id="breakeven">—</div>
          <div class="hint">Incluye ML, envío local, retenciones</div>
        </div>
        <div class="kpi">
          <div class="label">Precio con margen</div>
          <div class="value" id="target">—</div>
          <div class="hint">Aplica tu % de markup</div>
        </div>
        <div class="kpi">
          <div class="label">Precio sugerido (≈$100)</div>
          <div class="value" id="suggested">—</div>
          <div class="hint">Para publicar en ML</div>
        </div>
      </div>

      <div class="sep"></div>
      <table>
        <thead><tr><th>Detalle</th><th class="right">Valor</th></tr></thead>
        <tbody>
          <tr><td>Costo en USD (prod+dom+seg)</td><td class="right" id="usd_cost">—</td></tr>
          <tr><td>CIF (USD)</td><td class="right" id="cif_usd">—</td></tr>
          <tr><td>CIF (COP)</td><td class="right" id="cif_cop">—</td></tr>
          <tr><td>Arancel (COP)</td><td class="right" id="arancel">—</td></tr>
          <tr><td>IVA importación (COP)</td><td class="right" id="iva_imp_val">—</td></tr>
          <tr><td>Comisión ML (%)</td><td class="right" id="ml_pct">—</td></tr>
          <tr><td>Tarifa fija ML (COP)</td><td class="right" id="ml_fixed">—</td></tr>
          <tr><td>% cargos dependientes del precio (ML+MP+ICA)</td><td class="right" id="pct_total">—</td></tr>
        </tbody>
      </table>
      <div class="hint">Las comisiones se consultan con <b>Listing Prices API</b> (site MCO). Si no hay categoría, usa reglas por precio.</div>
    </div>
  </div>
</div>

<script>
  // ===== Utilidades de formato =====
  const fmtCOP = v => isFinite(v) ? v.toLocaleString('es-CO',{style:'currency',currency:'COP',maximumFractionDigits:0}) : '—';
  const fmtUSD = v => isFinite(v) ? v.toLocaleString('es-US',{style:'currency',currency:'USD'}) : '—';
  const fmtP  = v => isFinite(v) ? (v*100).toFixed(2)+'%' : '—';
  const $ = id => document.getElementById(id);
  const num = id => parseFloat($(id).value || '0');

  // ===== TRM automática (Socrata/Datos Abiertos) =====
  async function fetchTRM() {
    // Intento 1: Dataset 32sa-8pi3 (último registro por fecha)
    const urls = [
      'https://www.datos.gov.co/resource/32sa-8pi3.json?$limit=1&$order=vigenciadesc%20DESC',
      'https://www.datos.gov.co/resource/ceyp-9c7c.json?$limit=1&$order=vigenciadesc%20DESC',
      // Fallback libre (no-TRM oficial, pero evita quedarnos sin tasa):
      'https://api.exchangerate.host/latest?base=USD&symbols=COP'
    ];
    for (const u of urls) {
      try {
        const r = await fetch(u);
        if (!r.ok) continue;
        const data = await r.json();
        // Socrata: arreglo con objetos {valor: "xxxx.xx", vigenciadesc: "YYYY-MM-DD"}
        if (Array.isArray(data) && data.length && (data[0].valor || data[0].Value || data[0].valor_trm)) {
          const raw = data[0].valor || data[0].Value || data[0].valor_trm;
          const trm = Number(String(raw).replace(',', '.'));
          if (trm > 0) { $('trm').value = Math.round(trm); $('trm_note').textContent = 'TRM auto (Datos Abiertos)'; return; }
        }
        // exchangerate.host: {rates:{COP:xxxx}}
        if (!Array.isArray(data) && data?.rates?.COP) {
          $('trm').value = Math.round(Number(data.rates.COP));
          $('trm_note').textContent = 'Tasa auto (exchangerate.host)';
          return;
        }
      } catch(e) { /* intenta siguiente */ }
    }
    // Si todo falla, deja valor manual
    if (!Number($('trm').value)) {
      $('trm').value = 4200;
      $('trm_note').textContent = 'TRM manual (no se pudo obtener automática)';
    }
  }

  // ===== Comisión y tarifa fija ML (Listing Prices API) =====
  // Docs: /sites/$SITE_ID/listing_prices?price=$PRICE[&category_id=...&listing_type_id=...]
  // site_id para Colombia: MCO
  async function fetchListingFeesCOP(priceCOP) {
    const site = 'MCO';
    const category = $('category').value.trim();
    const listingType = $('listing_type').value;
    const params = new URLSearchParams({ price: String(Math.max(1, Math.round(priceCOP))) });
    if (category) params.set('category_id', category);
    if (listingType) params.set('listing_type_id', listingType);

    const url = `https://api.mercadolibre.com/sites/${site}/listing_prices?${params.toString()}`;
    try {
      const r = await fetch(url);
      if (!r.ok) throw new Error('HTTP '+r.status);
      const data = await r.json();
      // La respuesta incluye fee_percent y fixed_fee (nombres pueden variar por doc);
      // intentamos mapear claves comunes:
      const fee = data?.sale_fee || data?.fees || data?.listing_prices || data;
      // Normalizamos:
      let percent = null, fixed = null;
      // casos típicos: {sale_fee: {percent: 0.15, fixed_fee: 4000}} o arreglo
      const pick = Array.isArray(fee) ? fee[0] : fee;
      if (pick) {
        percent = Number(pick.percent ?? pick.sale_fee?.percent ?? pick.fee_percent ?? pick.variable_fee);
        fixed   = Number(pick.fixed_fee ?? pick.sale_fee?.fixed_fee ?? pick.additional_fee ?? pick.fixed);
      }
      if (isFinite(percent) && percent > 0) $('ml_pct').textContent = (percent*100).toFixed(2)+'%';
      if (isFinite(fixed) && fixed >= 0) $('ml_fixed').textContent = fmtCOP(fixed);
      return { percent: isFinite(percent)?percent:NaN, fixed: isFinite(fixed)?fixed:0 };
    } catch(e) {
      // Fallback conservador si el API no responde:
      const fallbackPct = 0.15;  // 15% aprox (varía por categoría/plan)
      const fallbackFix = 4000;  // fijo típico por rango bajo
      $('ml_pct').textContent = (fallbackPct*100).toFixed(2)+'% (aprox)';
      $('ml_fixed').textContent = fmtCOP(fallbackFix)+' (aprox)';
      return { percent: fallbackPct, fixed: fallbackFix };
    }
  }

  // ===== Cálculo principal =====
  function computeWith(feepct, fixedFee) {
    const costo_usd = num('price_usd'), us_ship = num('us_ship'), ins = num('ins');
    const intl = num('intl_ship'), trm = num('trm');

    const duty = num('duty')/100, iva_imp = num('iva_imp')/100, nac = num('nac');
    const local_ship = num('local_ship');

    const mp_ret = num('mp_ret')/100, ica = num('ica_pct')/100;
    const margin = num('margin')/100;

    const usd_cost = costo_usd + us_ship + ins;
    const cif_usd = usd_cost + intl;
    const cif_cop = cif_usd * trm;
    const arancel = cif_cop * duty;
    const iva_i   = (cif_cop + arancel) * iva_imp;
    const landed  = cif_cop + arancel + iva_i + nac;

    const total_pct = (feepct||0) + mp_ret + ica;

    let P_eq = NaN, P_goal = NaN, suggested = NaN;
    if ((1 - total_pct) > 0) {
      P_eq   = (landed + (fixedFee||0) + local_ship) / (1 - total_pct);
      P_goal = (landed * (1 + margin) + (fixedFee||0) + local_ship) / (1 - total_pct);
      suggested = Math.round(P_goal/100)*100;
    }

    // Pintar UI
    $('usd_cost').textContent = fmtUSD(usd_cost);
    $('cif_usd').textContent  = fmtUSD(cif_usd);
    $('cif_cop').textContent  = fmtCOP(cif_cop);
    $('arancel').textContent  = fmtCOP(arancel);
    $('iva_imp_val').textContent = fmtCOP(iva_i);
    $('pct_total').textContent = fmtP(total_pct);

    $('landed').textContent   = fmtCOP(landed);
    $('breakeven').textContent= isFinite(P_eq)?fmtCOP(P_eq):'—';
    $('target').textContent   = isFinite(P_goal)?fmtCOP(P_goal):'—';
    $('suggested').textContent= isFinite(suggested)?fmtCOP(suggested):'—';
  }

  // ===== Orquestación: TRM -> ML Fees -> Cálculo =====
  async function recomputeAll() {
    // 1) TRM (si está en 0 o vacío, intenta fetch)
    if (!Number($('trm').value)) await fetchTRM();

    // 2) Estimar precio base en COP (para consultar fees que dependen de precio de venta)
    //    Tomamos como primera aproximación el landed + envío local, sin comisión ni margen.
    const costo_usd = num('price_usd') + num('us_ship') + num('ins');
    const cif_usd = costo_usd + num('intl_ship');
    const trm = num('trm');
    const cif_cop = cif_usd * trm;
    const arancel = cif_cop * (num('duty')/100);
    const iva_i   = (cif_cop + arancel) * (num('iva_imp')/100);
    const landed  = cif_cop + arancel + iva_i + num('nac');
    const pre_price = Math.max(1000, landed + num('local_ship')); // seed

    // 3) Fees desde Listing Prices API (por precio, categoría y tipo)
    const fees = await fetchListingFeesCOP(pre_price);

    // 4) Calcula con los fees obtenidos
    computeWith(fees.percent, fees.fixed);
  }

  // ===== Eventos UI =====
  const inputs = ['price_usd','us_ship','ins','intl_ship','trm','duty','iva_imp','nac','local_ship','mp_ret','ica_pct','margin','category','listing_type'];
  inputs.forEach(id => document.getElementById(id).addEventListener('input', recomputeAll));
  $('margin_slider').addEventListener('input', () => { $('margin').value=$('margin_slider').value; $('margin_badge').textContent=Number($('margin').value).toFixed(1)+'%'; recomputeAll(); });
  $('margin').addEventListener('input', () => { $('margin_slider').value=$('margin').value; $('margin_badge').textContent=Number($('margin').value).toFixed(1)+'%'; recomputeAll(); });
  $('listing_type').addEventListener('change', recomputeAll);
  document.getElementById('recalc').addEventListener('click', (e)=>{ e.preventDefault(); recomputeAll(); });

  // ===== Inicio =====
  (async () => {
    await fetchTRM();
    $('margin_badge').textContent=Number($('margin').value).toFixed(1)+'%';
    await recomputeAll();
  })();

  // ===== Hook opcional: estimar envío por API de ML (requiere token y seller context) =====
  // Ejemplo de esqueleto (deberás ajustar endpoint/params y montar un proxy en tu servidor para evitar CORS):
  // async function estimateShippingCost() {
  //   const token = $('meli_token').value.trim();
  //   if (!token) return null;
  //   // TODO: llama al recurso de costos de envío con dimensiones/peso/CP
  //   // Doc de costos/envíos: developers.mercadolibre.* (requiere OAuth)
  //   // fetch('https://api.mercadolibre.com/...', { headers: { Authorization: 'Bearer '+token } })
  // }
</script>
</body>
</html>
