<?php
/**
 * Smart Choice CMS - Transparent On-the-Fly WebP Delivery Gateway
 * Intercepts requests for JPG/PNG images from WebP-capable browsers, converts them once,
 * caches the .webp file on disk, and streams the WebP response.
 */

require_once __DIR__ . '/includes/cms-webp-converter.php';

$relPath = ltrim(str_replace('\\', '/', $_GET['img'] ?? ''), '/');

if ($relPath === '' || strpos($relPath, "\0") !== false) {
    http_response_code(400);
    exit('Invalid image path.');
}

// Security: the resolved file must live inside /images and be a real JPG/PNG
$imagesRoot = realpath(__DIR__ . '/images');
$sourceDisk = realpath(__DIR__ . '/' . $relPath);
if (!$imagesRoot || !$sourceDisk || !is_file($sourceDisk) || strpos($sourceDisk, $imagesRoot . DIRECTORY_SEPARATOR) !== 0) {
    http_response_code(404);
    exit('Image not found.');
}

$ext = strtolower(pathinfo($sourceDisk, PATHINFO_EXTENSION));
$allowedMimes = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];
if (!isset($allowedMimes[$ext])) {
    http_response_code(400);
    exit('Unsupported image type.');
}

$imgInfo = @getimagesize($sourceDisk);
if (!$imgInfo || ($imgInfo['mime'] ?? '') !== $allowedMimes[$ext]) {
    http_response_code(400);
    exit('Invalid image file.');
}

// WebP sits beside the source, so it stays inside /images
$webpDisk = dirname($sourceDisk) . DIRECTORY_SEPARATOR . pathinfo($sourceDisk, PATHINFO_FILENAME) . '.webp';

// If WebP exists or can be created
if (!file_exists($webpDisk)) {
    CmsWebPConverter::convertToWebP($sourceDisk, $webpDisk);
}

if (is_file($webpDisk)) {
    header('Content-Type: image/webp');
    header('Content-Length: ' . filesize($webpDisk));
    header('Cache-Control: public, max-age=31536000, immutable');
    header('Vary: Accept');
    header('X-Content-Type-Options: nosniff');
    header('X-WebP-Delivered: converted');
    readfile($webpDisk);
    exit;
}

// Fallback to the validated original if conversion failed
header('Content-Type: ' . $allowedMimes[$ext]);
header('Content-Length: ' . filesize($sourceDisk));
header('Vary: Accept');
header('X-Content-Type-Options: nosniff');
readfile($sourceDisk);
exit;
