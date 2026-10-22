<?php
// cheat-sheet.php (Updated version with Insert Extended Prompt button)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Perfex CRM Prompt Builder — Pro Version</title>
<style>
body{font-family:Inter,Arial,sans-serif;background:#f4f6fb;padding:24px;color:#111827;}
.wrap{max-width:1100px;margin:auto;}
.card{background:#fff;border-radius:10px;padding:18px;box-shadow:0 6px 22px rgba(0,0,0,0.06);}
textarea,input[type=text],select{width:100%;padding:10px;margin-top:8px;border:1px solid #ddd;border-radius:8px;font-family:monospace;}
button{background:#0b5cff;color:#fff;border:none;border-radius:8px;padding:10px 16px;cursor:pointer;margin:6px 6px 0 0;font-weight:600;}
button.secondary{background:#111827;opacity:.9}
.output{margin-top:14px;background:#0f1724;color:#e6eef8;border-radius:8px;padding:14px;white-space:pre-wrap;max-height:520px;overflow:auto}
.checkboxes{display:flex;flex-wrap:wrap;gap:10px;margin-top:8px}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <h1>Perfex CRM Prompt Builder — Pro Version</h1>
    <p>This builder combines your system profile, module development instructions, rules, and optional code/problem input into one complete ChatGPT prompt. Now includes an <b>Insert Extended Prompt</b> feature to merge more complex templates.</p>

    <label>System / Server Profile</label>
    <textarea id="systemProfile" rows="8">Hosting: Platinum Pak (Linux, Apache 2.4.65, PHP 8.3.25)
Path: /home4/scusawco/public_html/crm.justsmartchoice/
Base URL: https://crm.justsmartchoice.com/
MySQL: 5.7.44-48
CRM Version: Perfex CRM 3.4.0
Author: Smart Choice Contractors USA
</textarea>

    <label>Perfex CRM Development Prompt</label>
    <textarea id="devPrompt" rows="10">Follow official Perfex CRM v3.4.0 module conventions.
Include install, uninstall, upgrade, version control, menus, submenus, role and permission system (view_global, view_own, create, edit, delete).
Use Author: Smart Choice Contractors USA.
Always provide full code with notes in English.
</textarea>

    <div class="checkboxes">
      <label><input type="checkbox" class="comp" value="models"> Models</label>
      <label><input type="checkbox" class="comp" value="controllers"> Controllers</label>
      <label><input type="checkbox" class="comp" value="views"> Views</label>
      <label><input type="checkbox" class="comp" value="helpers"> Helpers</label>
      <label><input type="checkbox" class="comp" value="menus"> Menus & Submenus</label>
      <label><input type="checkbox" class="comp" value="installers"> Install/Uninstall Scripts</label>
    </div>

    <label>Problematic Code (optional)</label>
    <textarea id="codeProblem" rows="6" placeholder="// Paste code or problem here..."></textarea>

    <label>Your Instruction (what do you want to do?)</label>
    <textarea id="instruction" rows="3" placeholder="e.g. Create a vehicle management module with CRUD and role-based access..."></textarea>

    <label>Rules</label>
    <div class="checkboxes">
      <label><input type="checkbox" class="rule" value="Never truncate or cut code"> Never truncate or cut code</label>
      <label><input type="checkbox" class="rule" value="Always include full file contents"> Always include full file contents</label>
      <label><input type="checkbox" class="rule" value="Include English notes in each file"> Include English notes in each file</label>
    </div>
    <input type="text" id="customRules" placeholder="Add custom rules, comma separated">

    <div>
      <button id="insertExtendedBtn">Insert Extended Prompt</button>
      <button id="generateBtn">Generate Prompt</button>
      <button id="copyBtn" class="secondary">Copy</button>
      <button id="clearBtn" class="secondary">Clear</button>
    </div>

    <h3>Final Prompt Output</h3>
    <div id="output" class="output">// The generated long prompt will appear here...</div>
  </div>
</div>

<script>
function joinSelected(sel){return Array.from(document.querySelectorAll(sel+':checked')).map(i=>i.value);}
function escapeText(t){return t.trim();}

document.getElementById('insertExtendedBtn').addEventListener('click',()=>{
  const extendedPrompt = `
===== EXTENDED PERFEX INSTRUCTIONS =====
1. Always follow official Perfex module format: modules/your_module/
   - controllers/, models/, views/, helpers/, install.php, uninstall.php, module.json
2. Admin controllers extend AdminController; client ones extend ClientsController.
3. Register permissions: view_global, view_own, create, edit, delete using register_staff_capabilities().
4. Add menus/submenus in init file with icons and correct placement.
5. Include SQL for install/uninstall with db_prefix() usage.
6. Provide module.json with version and author Smart Choice Contractors USA.
7. Include developer notes in all files in English.
8. Provide compatibility summary (PHP 8.3, CI3, MySQL 5.7).
9. Never cut code. Output full files.
10. Include install, upgrade, and uninstall instructions.
===== END EXTENDED SECTION =====
`;
  const current = document.getElementById('devPrompt');
  current.value += "\n" + extendedPrompt;
});

document.getElementById('generateBtn').addEventListener('click',()=>{
  const sys = escapeText(document.getElementById('systemProfile').value);
  const dev = escapeText(document.getElementById('devPrompt').value);
  const inst = escapeText(document.getElementById('instruction').value);
  const code = document.getElementById('codeProblem').value.trim();
  const comps = joinSelected('.comp').join(', ') || 'none';
  const rules = joinSelected('.rule');
  const custom = (document.getElementById('customRules').value||'').split(',').map(x=>x.trim()).filter(x=>x.length);
  const allRules = rules.concat(custom);
  let out = "";
  out += "===== SYSTEM PROFILE =====\n"+sys+"\n\n";
  out += "===== DEV PROMPT =====\n"+dev+"\n\n";
  out += "===== TASK =====\n"+inst+"\nComponents: "+comps+"\n\n";
  out += "===== CODE PROBLEM =====\n"+(code?code:"None")+"\n\n";
  out += "===== RULES =====\n"+(allRules.length?allRules.join('\\n'):"None")+"\n\n";
  out += "Output full folder tree, complete files, install/uninstall/upgrade instructions, author header Smart Choice Contractors USA.\n";
  document.getElementById('output').textContent = out;
});

document.getElementById('copyBtn').addEventListener('click',()=>{
  const text=document.getElementById('output').textContent;
  navigator.clipboard.writeText(text).then(()=>alert('Copied!'));
});
document.getElementById('clearBtn').addEventListener('click',()=>{
  document.getElementById('output').textContent='';
});
</script>
</body>
</html>
