<?php
$page_service='3D Kitchen Design';$page_service_slug='kitchen-3d-design';$page_location='Wesley Chapel';$page_location_slug='wesley-chapel';$page_county='Pasco County';$page_intent='ZIP code service area';$page_zip='33543';
$sc_root = rtrim((string)($_SERVER['DOCUMENT_ROOT'] ?? ''), '/\\');
$sc_renderer = $sc_root . '/includes/kitchen-remodeling-page-renderer.php';
if (!is_file($sc_renderer)) {
    $sc_probe = __DIR__;
    for ($sc_i = 0; $sc_i < 14; $sc_i++) {
        $sc_try = $sc_probe . '/includes/kitchen-remodeling-page-renderer.php';
        if (is_file($sc_try)) { $sc_renderer = $sc_try; break; }
        $sc_parent = dirname($sc_probe);
        if ($sc_parent === $sc_probe) { break; }
        $sc_probe = $sc_parent;
    }
}
if (!is_file($sc_renderer)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    exit('Kitchen page renderer is missing. Upload the master repair package into the website root.');
}
require $sc_renderer;
