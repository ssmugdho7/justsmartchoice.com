<?php
/**
 * Smart Choice CMS - Transparent On-the-Fly WebP Delivery Gateway
 * Intercepts requests for JPG/PNG images from WebP-capable browsers, converts them once,
 * caches the .webp file on disk, and streams the WebP response.
 */

require_once __DIR__ . '/includes/cms-webp-converter.php';

$relPath = ltrim(str_replace('\\', '/', $_GET['img'] ?? ''), '/');

// Security: Prevent directory traversal
if (empty($relPath) || strpos($relPath, '..') !== false) {
    http_response_code(400);
    exit('Invalid image path.');
}

$sourceDisk = __DIR__ . '/' . $relPath;
if (!file_exists($sourceDisk)) {
    http_response_code(404);
    exit('Image not found.');
}

$info = pathinfo($sourceDisk);
$webpDisk = $info['dirname'] . '/' . $info['filename'] . '.webp';

// If WebP exists or can be created
if (!file_exists($webpDisk)) {
    CmsWebPConverter::convertToWebP($sourceDisk, $webpDisk);
}

if (file_exists($webpDisk)) {
    header('Content-Type: image/webp');
    header('Content-Length: ' . filesize($webpDisk));
    header('Cache-Control: public, max-age=31536000, immutable');
    header('X-WebP-Delivered: converted');
    readfile($webpDisk);
    exit;
}

// Fallback to original if conversion failed
$ext = strtolower($info['extension'] ?? 'jpg');
$mime = ($ext === 'png') ? 'image/png' : 'image/jpeg';
header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($sourceDisk));
readfile($sourceDisk);
exit;
