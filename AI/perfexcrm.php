<?php
// Perfex CRM Module Prompt Generator – Single-file PHP app (v1)
// • PIN gate (1976)
// • Builds a COMPLETE prompt for ChatGPT to generate a Perfex CRM v3.4.0 module
// • Injects your server/environment details automatically
// • Choose standard features (20+ common module capabilities)
// • Save/Load/Edit/Delete prompts (left menu)

$PIN = '1976';
session_start();
if (isset($_POST['pin'])) {
  if (trim($_POST['pin']) === $PIN) { $_SESSION['pcmg_auth'] = true; header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?')); exit; }
  else { $err = 'Invalid PIN'; }
}
$authed = !empty($_SESSION['pcmg_auth']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Perfex CRM Module Prompt Generator</title>
  <style>
    :root{ --bg:#0b0f14; --card:#111826; --ink:#e9eef5; --muted:#9fb2c7; --accent:#169179; --border:#1f2b3a; --danger:#ff6b6b; }
    *{box-sizing:border-box}
    body{margin:0;background:linear-gradient(180deg,#0b0f14 0%,#0e1420 100%);color:var(--ink);font:16px/1.45 system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial}
    header{padding:20px;text-align:center}
    header h1{margin:0 0 6px;font-weight:800;letter-spacing:.3px}
    header p{margin:0;color:var(--muted)}
    .app{max-width:1300px;margin:0 auto;padding:0 16px 60px}
    .layout{display:grid;grid-template-columns:300px 1fr;gap:16px}
    @media (max-width: 1000px){.layout{grid-template-columns:1fr}}
    .card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:14px;box-shadow:0 10px 30px rgba(0,0,0,.25)}
    .card h2{margin:0 0 10px;font-size:16px}
    label{display:block;font-weight:600;margin:10px 0 6px}
    input[type="text"], input[type="color"], input[type="password"], textarea, select{
      width:100%;background:#0c1320;border:1px solid var(--border);color:var(--ink);padding:10px 12px;border-radius:12px;outline:none
    }
    textarea{min-height:160px;resize:vertical}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .controls{display:flex;flex-wrap:wrap;gap:10px;margin-top:12px}
    button{appearance:none;border:1px solid var(--border);background:#122033;color:var(--ink);padding:10px 14px;border-radius:12px;font-weight:700;cursor:pointer}
    button.primary{background:var(--accent);border-color:#117664;color:#031b17}
    button.warn{background:transparent;border-color:var(--danger);color:var(--danger)}
    .muted{color:var(--muted);font-size:12px}
    .list{display:flex;flex-direction:column;gap:10px;max-height:70vh;overflow:auto}
    .item{border:1px solid var(--border);background:#0e1726;border-radius:12px;padding:10px;display:flex;align-items:flex-start;gap:8px}
    .item-main{flex:1;min-width:0}
    .item h4{margin:0 0 4px;font-size:14px;color:#cfe0f5;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .item .meta{color:#90a6be;font-size:12px;margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .item .actions{display:flex;gap:8px}
    footer{margin-top:28px;padding:18px;text-align:center;color:#9fc3d4}
    footer .line{opacity:.85}
    .pill{display:inline-flex;align-items:center;gap:6px;background:#0e1726;border:1px solid var(--border);padding:6px 10px;border-radius:999px;color:#9fb2c7;font-size:12px}
  </style>
</head>
<body>
<?php if(!$authed): ?>
  <header>
    <h1>Perfex CRM Module Prompt Generator — Login</h1>
    <p>Enter your PIN to access the generator.</p>
  </header>
  <div class="app">
    <section class="card" style="max-width:520px;margin:0 auto;">
      <form method="post">
        <label for="pin">PIN</label>
        <input type="password" id="pin" name="pin" placeholder="Enter PIN" autofocus>
        <?php if(isset($err)): ?><div class="muted" style="color:#ff9f9f;"><?=htmlspecialchars($err)?></div><?php endif; ?>
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
    <h1>Perfex CRM Module Prompt Generator</h1>
    <p>Build a complete, context-rich prompt for ChatGPT to output a <strong>Perfex CRM v3.4.0</strong> module with the features you select.</p>
  </header>

  <div class="app">
    <div class="layout">
      <!-- LEFT MENU -->
      <aside class="card">
        <h2>Saved Prompts</h2>
        <div class="controls">
          <button class="primary" id="newPrompt">New</button>
          <button id="saveNew">Save New</button>
          <button id="updateCurrent">Update</button>
        </div>
        <div class="muted">Click to load, Edit, or Delete.</div>
        <div id="promptList" class="list"></div>
      </aside>

      <!-- MAIN -->
      <main>
        <section class="card">
          <h2>Module Basics</h2>
          <div class="row">
            <div>
              <label for="moduleName">Module Name (StudlyCase)</label>
              <input id="moduleName" type="text" placeholder="e.g., SmartGutters" />
            </div>
            <div>
              <label for="slug">Slug (lowercase, no spaces)</label>
              <input id="slug" type="text" placeholder="e.g., smart_gutters" />
            </div>
          </div>

          <div class="row">
            <div>
              <label for="description">Short Description</label>
              <input id="description" type="text" placeholder="What the module does" />
            </div>
            <div>
              <label for="namespace">PHP Namespace (optional)</label>
              <input id="namespace" type="text" placeholder="e.g., Modules\\SmartGutters" />
            </div>
          </div>

          <label for="features">Select Features (hold Ctrl/⌘ for multi-select)</label>
          <select id="features" multiple size="10">
            <option>Add admin menu</option>
            <option>Add admin submenu</option>
            <option>Add client menu</option>
            <option>Custom permissions & roles</option>
            <option>Settings page (Options model)</option>
            <option>CRUD: database migration + models</option>
            <option>Leads integration (custom fields + pipeline)</option>
            <option>Invoices integration (line items / hooks)</option>
            <option>Estimates/Proposals integration</option>
            <option>Contacts/Customers integration</option>
            <option>Tasks & Projects integration</option>
            <option>Staff notifications (email/in-app)</option>
            <option>Client notifications (email/in-app)</option>
            <option>Webhook endpoints</option>
            <option>REST API endpoints (api\\)</option>
            <option>Widgets (dashboard)</option>
            <option>Reports page (filters + export CSV/XLSX)</option>
            <option>File uploads (GD/Imagick thumbs)</option>
            <option>Location tracker (lat/lng, maps embed)</option>
            <option>Cron job (register + handler)</option>
            <option>GDPR compatibility</option>
            <option>Language files (EN starter)</option>
            <option>Theme compatibility (perfex & smartchoice)</option>
            <option>Hooks/events usage</option>
          </select>

          <div class="row">
            <div>
              <label for="dbTables">DB Tables (comma-separated)</label>
              <input id="dbTables" type="text" placeholder="e.g., gutters_jobs, gutters_quotes" />
            </div>
            <div>
              <label for="routes">Routes (comma-separated)</label>
              <input id="routes" type="text" placeholder="e.g., admin/smart_gutters, smart_gutters/public" />
            </div>
          </div>

          <label for="extraNotes">Extra Requirements / Notes</label>
          <textarea id="extraNotes" placeholder="Anything special the module must do"></textarea>
        </section>

        <section class="card">
          <h2>Generated Prompt</h2>
          <textarea id="output" readonly placeholder="Your Perfex module prompt will appear here..."></textarea>
          <div class="controls">
            <button class="primary" id="gen">Generate Prompt</button>
            <button id="copy">Copy</button>
          </div>
          <div class="muted">This prompt includes your server details, Perfex version, and best‑practice constraints for ChatGPT to follow exactly.</div>
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
  const $ = id => document.getElementById(id);
  const LS_KEY = 'perfex_module_prompts_v1';
  let CURRENT_ID = null;

  // Fixed environment context pulled from your data
  const ENV = {
    perfex_version: '3.4.0',
    base_url: 'https://crm.justsmartchoice.com/',
    install_path: '/home4/scusawco/public_html/crm.justsmartchoice/',
    os: 'Linux',
    webserver: 'Apache (HTTP/2.0)',
    php: '8.3.6',
    php_ext: ['curl 8.7.1','openssl 269488511','mbstring','iconv','imap','gd','zip','bcmath','allow_url_fopen enabled'],
    mysql: '5.7.23-23',
    sql_mode: 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION',
    limits: { max_input_vars:1000, upload_max_filesize:'1024M', post_max_size:'516M', max_execution_time:60, memory_limit:'2048M' },
    env: 'development', csrf: true, cron_cli: true,
    themes: { customers_current:'perfex', available:['smartchoice','perfex'] },
    modules: { total:25, active:23, require_upgrade:0 },
    paths: { temp:'/tmp/', my_prefixed_view:'/home4/scusawco/public_html/crm.justsmartchoice/application/views/admin/tables/my_proposals.php' },
    server: {
      package:'Platinum Pak', cpanel:'110.0 (build 74)', apache:'2.4.59', kernel:'4.19.286-203.ELK.el7.x86_64',
      dedicated_ip:'162.144.17.232', sendmail:'/usr/sbin/sendmail', perl:'/usr/bin/perl 5.16.3',
      load:'0.00', cpu_count:16, memory_used:'40.89%', disk_home4:'62%'
    }
  };

  // Feature list (20+)
  const FEATURES = Array.from(document.querySelectorAll('#features option')).map(o=>o.textContent);

  function buildPrompt(){
    const name = $('moduleName').value.trim() || 'MyModule';
    const slug = $('slug').value.trim() || name.replace(/([a-z])([A-Z])/g,'$1_$2').toLowerCase();
    const desc = $('description').value.trim() || 'Module adds custom business functionality.';
    const namespace = $('namespace').value.trim() || `Modules\\${name}`;
    const features = Array.from($('features').selectedOptions).map(o=>o.textContent);
    const dbTables = $('dbTables').value.trim();
    const routes = $('routes').value.trim();
    const extra = $('extraNotes').value.trim();

    // Compose an authoritative, structured prompt
    const lines = [];
    lines.push(`GOAL: Build a complete Perfex CRM module for version ${ENV.perfex_version} named \"${name}\" (slug: ${slug}).`);
    lines.push(`DESCRIPTION: ${desc}`);
    lines.push('OUTPUT: Provide production-ready code files with correct Perfex module structure, CodeIgniter-compatible PHP (CI3 style), controllers, models, views, language files, migrations, hooks, routes, and install/uninstall scripts. Include file paths and full code blocks for each file.');

    // Environment section
    lines.push('\nENVIRONMENT (MANDATORY CONSTRAINTS):');
    lines.push(`- Perfex CRM: ${ENV.perfex_version} (CodeIgniter-compatible).`);
    lines.push(`- Base URL: ${ENV.base_url}`);
    lines.push(`- Install path: ${ENV.install_path}`);
    lines.push(`- OS/Webserver: ${ENV.os}, ${ENV.webserver}.`);
    lines.push(`- PHP: ${ENV.php}; extensions: ${ENV.php_ext.join(', ')}.`);
    lines.push(`- MySQL: ${ENV.mysql}; sql_mode: ${ENV.sql_mode}.`);
    lines.push(`- Limits: max_input_vars=${ENV.limits.max_input_vars}, upload_max_filesize=${ENV.limits.upload_max_filesize}, post_max_size=${ENV.limits.post_max_size}, max_execution_time=${ENV.limits.max_execution_time}, memory_limit=${ENV.limits.memory_limit}.`);
    lines.push(`- Themes: customers current= ${ENV.themes.customers_current}; available= ${ENV.themes.available.join(', ')}.`);
    lines.push(`- Modules: total=${ENV.modules.total}, active=${ENV.modules.active}, require_upgrade=${ENV.modules.require_upgrade}.`);
    lines.push(`- Security: CSRF enabled=${ENV.csrf}.`);
    lines.push(`- Cron: CLI cron=${ENV.cron_cli}.`);
    lines.push('- IMPORTANT: Ensure compatibility with Apache on shared hosting (Bluehost cPanel). Avoid requiring root OS access or services not available on shared hosting.');

    // Feature requirements
    lines.push('\nFEATURE REQUIREMENTS:');
    if(features.length){ lines.push(`- Include the following capabilities: ${features.join('; ')}.`); }
    else{ lines.push(`- Capabilities: ${FEATURES.slice(0,8).join('; ')} (default).`); }
    if(dbTables){ lines.push(`- Database tables to create (with migrations): ${dbTables}.`); }
    if(routes){ lines.push(`- Routes to register: ${routes}.`); }

    // Coding rules
    lines.push('\nCODING RULES (DO NOT IGNORE):');
    lines.push('- Use Perfex module conventions: module.php bootstrap, config/routes.php, controllers (Admin_*, Client_* as needed), models, views, language files in modules/<slug>/language/english/<slug>_lang.php, migrations in modules/<slug>/migrations/.');
    lines.push('- Use hooks where applicable (e.g., admin_init, app_init, after_cron_run, dashboard widgets).');
    lines.push('- Respect CSRF and permissions. Provide sample permissions seeds and how to add them.');
    lines.push('- Provide SQL migration files and rollback steps.');
    lines.push('- No breaking changes to core Perfex files; use hooks and module overrides.');
    lines.push('- Provide example seed data for quick testing.');
    lines.push('- Provide instructions: where to upload each file under ' + ENV.install_path + ' and how to enable the module in the admin.');

    // Quality & exactness
    lines.push('\nQUALITY & EXACTNESS:');
    lines.push('- Output must be highest possible quality, ready to paste into the file system.');
    lines.push('- Provide the scope EXACTLY as requested. DO NOT change names, slugs, routes, or database fields from the specifications.');

    if(extra){ lines.push('\nNOTES:\n' + extra); }

    return lines.join('\n');
  }

  function loadAll(){ try{ return JSON.parse(localStorage.getItem(LS_KEY)) || []; }catch(e){ return []; } }
  function saveAll(list){ localStorage.setItem(LS_KEY, JSON.stringify(list)); }
  function upsert(data){ const list = loadAll(); if(!data.id){ data.id=Date.now(); list.unshift(data);} else { const i=list.findIndex(x=>x.id===data.id); if(i>=0) list[i]=data; else list.unshift(data);} saveAll(list); renderList(); return data.id; }
  function remove(id){ const list = loadAll().filter(x=>x.id!==id); saveAll(list); renderList(); if(CURRENT_ID===id){ CURRENT_ID=null; clearForm(); } }

  function renderList(){
    const list = loadAll(); const box = document.getElementById('promptList'); box.innerHTML='';
    if(!list.length){ box.innerHTML = '<div class="muted">No saved prompts yet. Click <b>Save New</b> to store one.</div>'; return; }
    list.forEach(p=>{
      const item = document.createElement('div'); item.className='item';
      const main = document.createElement('div'); main.className='item-main';
      const h = document.createElement('h4'); h.textContent = `${p.name} — ${p.slug}`;
      const meta = document.createElement('div'); meta.className='meta'; meta.textContent = `${new Date(p.ts).toLocaleString()} • ${p.features.length} features`;
      main.append(h, meta);
      const actions = document.createElement('div'); actions.className='actions';
      const bEdit = document.createElement('button'); bEdit.textContent='Edit'; bEdit.onclick=()=>loadItem(p.id);
      const bDel = document.createElement('button'); bDel.textContent='Delete'; bDel.className='warn'; bDel.onclick=()=>remove(p.id);
      actions.append(bEdit,bDel);
      item.append(main, actions); box.appendChild(item);
    });
  }

  function collect(){
    return {
      id: CURRENT_ID,
      ts: Date.now(),
      name: $('moduleName').value.trim(),
      slug: $('slug').value.trim(),
      description: $('description').value.trim(),
      namespace: $('namespace').value.trim(),
      features: Array.from($('features').selectedOptions).map(o=>o.textContent),
      dbTables: $('dbTables').value.trim(),
      routes: $('routes').value.trim(),
      extraNotes: $('extraNotes').value.trim(),
      prompt: $('output').value
    };
  }

  function populate(d){
    CURRENT_ID = d.id || null;
    $('moduleName').value = d.name || '';
    $('slug').value = d.slug || '';
    $('description').value = d.description || '';
    $('namespace').value = d.namespace || '';
    // features
    const set = new Set(d.features||[]);
    Array.from($('features').options).forEach(o=>o.selected = set.has(o.textContent));
    $('dbTables').value = d.dbTables || '';
    $('routes').value = d.routes || '';
    $('extraNotes').value = d.extraNotes || '';
    $('output').value = d.prompt || '';
  }

  function clearForm(){ populate({}); }
  function loadItem(id){ const it = loadAll().find(x=>x.id===id); if(!it) return; populate(it); }

  // Events
  $('gen').addEventListener('click', e=>{ e.preventDefault(); $('output').value = buildPrompt(); });
  $('copy').addEventListener('click', e=>{ e.preventDefault(); const out=$('output'); out.select(); out.setSelectionRange(0,99999); document.execCommand('copy'); });
  $('saveNew').addEventListener('click', e=>{ e.preventDefault(); const d=collect(); d.id=null; if(!d.prompt) d.prompt=buildPrompt(); upsert(d); });
  $('updateCurrent').addEventListener('click', e=>{ e.preventDefault(); const d=collect(); if(!d.id){ alert('No prompt selected. Use Save New.'); return;} if(!d.prompt) d.prompt=buildPrompt(); upsert(d); });
  $('newPrompt').addEventListener('click', e=>{ e.preventDefault(); clearForm(); CURRENT_ID=null; });

  // Init
  (function init(){ renderList(); })();
</script>
<?php endif; ?>
</body>
</html>