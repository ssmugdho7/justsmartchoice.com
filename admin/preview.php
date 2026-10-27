<?php
/**
 * Smart Choice CMS - Draft Live Preview Host
 * Renders target landing page with draft overrides and injects the live preview bridge
 */

require_once __DIR__ . '/auth.php';
AdminAuth::requireLogin();

// Force preview mode for session
$_SESSION['cms_admin_preview'] = true;

$pageSlug = strtolower(preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['page'] ?? 'home'));
if ($pageSlug === 'home' || $pageSlug === '') {
    $targetFile = dirname(__DIR__) . '/index.php';
} else {
    // Check root file
    $targetFile = dirname(__DIR__) . '/' . $pageSlug . '.php';
    if (!file_exists($targetFile)) {
        // Check services/
        $targetFile = dirname(__DIR__) . '/services/' . $pageSlug . '.php';
    }
}

if (!file_exists($targetFile)) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><body style="font-family:sans-serif;padding:40px;text-align:center;">';
    echo '<h2>Preview page not found</h2><p>File ' . htmlspecialchars($pageSlug) . '.php does not exist.</p>';
    echo '</body></html>';
    exit;
}

// Intercept output buffer
ob_start();

// Change working directory to root so relative includes work seamlessly
$originalCwd = getcwd();
chdir(dirname(__DIR__));

try {
    include $targetFile;
} catch (Throwable $e) {
    echo '<div style="background:#fef2f2;color:#991b1b;padding:20px;border-radius:8px;margin:20px;font-family:monospace;">';
    echo '<strong>Preview Render Error:</strong> ' . htmlspecialchars($e->getMessage());
    echo '</div>';
}

chdir($originalCwd);
$html = ob_get_clean();

// 1. Calculate site root base URL so all relative links (css/..., images/..., js/...) resolve correctly
$adminBase = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/admin')), '/');
$siteDir = dirname($adminBase);
$siteBase = ($siteDir === '/' || $siteDir === '\\' || $siteDir === '.') ? '/' : rtrim(str_replace('\\', '/', $siteDir), '/') . '/';

$baseTag = '<base href="' . htmlspecialchars($siteBase) . '">';

// Inject <base> as the first tag inside <head> so browser resolves all stylesheets, fonts, and scripts
if (preg_match('/<head\b[^>]*>/i', $html, $matches, PREG_OFFSET_CAPTURE)) {
    $insertPos = $matches[0][1] + strlen($matches[0][0]);
    $html = substr($html, 0, $insertPos) . "\n    " . $baseTag . substr($html, $insertPos);
} else {
    $html = $baseTag . "\n" . $html;
}

// 2. If running under a subfolder (e.g. /sc-landing-page/), rewrite any leading-slash asset paths
if ($siteBase !== '/') {
    $html = preg_replace('#(href|src)=(["\'])/(images|css|js|services|sections-library)/#i', '$1=$2' . $siteBase . '$3/', $html);
}

// 3. Inject preview bridge styles and script
$bridgeHead = '<link rel="stylesheet" href="' . $adminBase . '/css/preview-bridge.css?v=' . time() . '">';
$bridgeBody = '<script src="' . $adminBase . '/js/preview-bridge.js?v=' . time() . '"></script>';

if (stripos($html, '</head>') !== false) {
    $html = str_ireplace('</head>', '    ' . $bridgeHead . "\n</head>", $html);
} else {
    $html = $bridgeHead . "\n" . $html;
}

if (stripos($html, '</body>') !== false) {
    $html = str_ireplace('</body>', '    ' . $bridgeBody . "\n</body>", $html);
} else {
    $html .= "\n" . $bridgeBody;
}

header('Content-Type: text/html; charset=utf-8');
echo $html;
