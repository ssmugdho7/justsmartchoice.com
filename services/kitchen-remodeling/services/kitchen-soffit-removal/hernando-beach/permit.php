<?php
$page_service='Kitchen Soffit Removal';$page_service_slug='kitchen-soffit-removal';$page_location='Hernando Beach';$page_location_slug='hernando-beach';$page_county='Hernando County';$page_intent='permit guidance';$page_zip='';
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
