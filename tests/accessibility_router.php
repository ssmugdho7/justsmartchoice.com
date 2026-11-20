<?php
// Local-only browser audit: A11Y_AXE_PATH points to a temporary axe-core download.
if (PHP_SAPI !== 'cli-server') { http_response_code(404); exit; }
$root=dirname(__DIR__);$path=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
if($path==='/__axe.js'){
 $file=getenv('A11Y_AXE_PATH');if(!$file||!is_file($file)){http_response_code(404);exit;}
 header('Content-Type: text/javascript');readfile($file);return true;
}
if($path==='/__audit.js'){
 header('Content-Type: text/javascript');
 echo <<<'JS'
window.addEventListener('load',function(){
 var tools=document.createElement('aside');tools.id='a11y-test-tools';tools.setAttribute('aria-label','Accessibility test tools');tools.style.cssText='padding:16px;background:white;color:black;';
 var button=document.createElement('button');button.type='button';button.textContent='Run accessibility audit';button.id='run-accessibility-audit';button.style.cssText='background:#123d32;color:white;padding:12px;font-size:16px;';
 var output=document.createElement('pre');output.id='a11y-results';output.style.cssText='white-space:pre-wrap;overflow-wrap:anywhere;';
 tools.append(button,output);document.body.appendChild(tools);
 button.addEventListener('click',async function(){
  output.textContent='Running accessibility audit...';
  var result=await axe.run({exclude:[['#a11y-test-tools']]},{runOnly:{type:'tag',values:['wcag2a','wcag2aa','wcag21a','wcag21aa','wcag22aa','best-practice']}});
  output.textContent=JSON.stringify({violations:result.violations.map(function(v){return {id:v.id,impact:v.impact,description:v.description,nodes:v.nodes.map(function(n){return {target:n.target,summary:n.failureSummary};})};}),passes:result.passes.length,incomplete:result.incomplete.map(function(v){return v.id;})},null,2);
 });
});
JS;
 return true;
}
if($path==='/'||$path==='/index.php'){
 ob_start();$source=getenv('A11Y_INDEX_PATH');
 if($source&&is_file($source)){
  $php=str_replace('__DIR__',var_export($root,true),file_get_contents($source));
  $gallery=getenv('A11Y_GALLERY_PATH');
  if($gallery)$php=str_replace("'sections-library/our-clients-finished-projects.html'",var_export($gallery,true),$php);
  eval('?>'.$php);
 }else{require $root.'/index.php';}
 $html=ob_get_clean();
 $html=str_replace('</body>','<script src="/__axe.js" defer></script><script src="/__audit.js" defer></script></body>',$html);
 header('Content-Type: text/html; charset=utf-8');header('Cache-Control: no-store');echo $html;return true;
}
return false;
