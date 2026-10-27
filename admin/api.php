<?php
/**
 * Smart Choice CMS - Admin AJAX API
 */

require_once __DIR__ . '/auth.php';
require_once dirname(__DIR__) . '/includes/cms-webp-converter.php';
AdminAuth::requireLogin();

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Verify CSRF token for mutating actions
$mutatingActions = [
    'save_page', 'save_draft', 'discard_draft',
    'upload_media', 'delete_media', 'bulk_delete_media',
    'replace_media', 'rename_media', 'move_media', 'create_media_folder',
    'save_design', 'save_navigation', 'batch_convert_webp'
];

if (in_array($action, $mutatingActions, true)) {
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? '';
    if (!AdminAuth::verifyCsrf($token)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Security token invalid or expired. Please refresh the page.']);
        exit;
    }
}

/**
 * Safely validate and resolve an image file path inside /images directory.
 * Prevents directory traversal attacks.
 */
function getSafeMediaPath(string $relPath): ?string
{
    $imagesRoot = realpath(dirname(__DIR__) . '/images');
    if (!$imagesRoot) {
        return null;
    }

    $cleanRel = str_replace(['\\', '..'], ['/', ''], $relPath);
    $cleanRel = ltrim($cleanRel, '/');

    // Strip redundant leading "images/"
    if (strpos($cleanRel, 'images/') === 0) {
        $cleanRel = substr($cleanRel, 7);
    }

    $target = $imagesRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanRel);
    $real = realpath($target);

    if ($real && is_file($real) && strpos($real, $imagesRoot) === 0) {
        return $real;
    }

    return null;
}

/**
 * Scan all CMS JSON files and update references from old relative image path to new path
 */
function updateMediaReferencesInCms(string $oldRel, string $newRel): int
{
    $dataDir = dirname(__DIR__) . '/cms-data';
    $files = glob($dataDir . '/*.json') ?: [];
    $pageFiles = glob($dataDir . '/pages/*.json') ?: [];
    $draftFiles = glob($dataDir . '/drafts/*.json') ?: [];
    $allFiles = array_merge($files, $pageFiles, $draftFiles);

    $oldClean = ltrim(str_replace(['\\', 'images/'], ['/', ''], $oldRel), '/');
    $newClean = ltrim(str_replace(['\\', 'images/'], ['/', ''], $newRel), '/');

    $replacements = [
        '/images/' . $oldClean => '/images/' . $newClean,
        'images/' . $oldClean => 'images/' . $newClean,
        $oldClean => $newClean,
        basename($oldClean) => basename($newClean)
    ];

    $updatedCount = 0;
    foreach ($allFiles as $f) {
        $pageSlug = basename($f, '.json');
        if (in_array($pageSlug, ['users', 'pages_manifest'], true)) {
            continue;
        }

        $content = @file_get_contents($f);
        if ($content === false) continue;

        $modified = false;
        foreach ($replacements as $from => $to) {
            if ($from !== '' && $from !== $to && strpos($content, $from) !== false) {
                $content = str_replace($from, $to, $content);
                $modified = true;
            }
        }

        if ($modified) {
            @file_put_contents($f, $content);
            $updatedCount++;
        }
    }

    return $updatedCount;
}

/**
 * Find all CMS pages referencing a given media item
 */
function findMediaUsage(string $relPath): array
{
    $dataDir = dirname(__DIR__) . '/cms-data';
    $files = glob($dataDir . '/*.json') ?: [];
    $pageFiles = glob($dataDir . '/pages/*.json') ?: [];
    $allFiles = array_merge($files, $pageFiles);

    $filename = basename($relPath);
    $cleanRel = ltrim(str_replace(['\\', 'images/'], ['/', ''], $relPath), '/');

    $pages = [];
    foreach ($allFiles as $f) {
        $slug = basename($f, '.json');
        if (in_array($slug, ['users', 'pages_manifest'], true)) {
            continue;
        }

        $content = @file_get_contents($f);
        if (!$content) continue;

        if (strpos($content, $filename) !== false || strpos($content, $cleanRel) !== false) {
            $pages[] = ucfirst(str_replace(['-', '_'], ' ', $slug));
        }
    }

    return array_values(array_unique($pages));
}

switch ($action) {

    // 1. Save Page Data (Production Publish)
    case 'save_page':
        $page = trim($_POST['page'] ?? '');
        $dataJson = $_POST['data'] ?? '';
        $data = json_decode($dataJson, true);

        if ($page === '' || !is_array($data)) {
            echo json_encode(['success' => false, 'error' => 'Invalid page or payload.']);
            exit;
        }

        $saved = CMS::savePage($page, $data);
        if ($saved) {
            echo json_encode(['success' => true, 'message' => 'Page successfully published!']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to write page data to storage.']);
        }
        exit;

    // 2. Save Draft for Live Preview
    case 'save_draft':
        $page = trim($_POST['page'] ?? '');
        $dataJson = $_POST['data'] ?? '';
        $data = json_decode($dataJson, true);

        if ($page === '' || !is_array($data)) {
            echo json_encode(['success' => false, 'error' => 'Invalid draft payload.']);
            exit;
        }

        $saved = CMS::saveDraft($page, $data);
        echo json_encode(['success' => $saved]);
        exit;

    // 3. Discard Draft
    case 'discard_draft':
        $page = trim($_POST['page'] ?? '');
        CMS::discardDraft($page);
        echo json_encode(['success' => true, 'message' => 'Draft changes discarded.']);
        exit;

    // 4. Upload Media Asset
    case 'upload_media':
        if (empty($_FILES['file'])) {
            echo json_encode(['success' => false, 'error' => 'No file received.']);
            exit;
        }

        $file = $_FILES['file'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Upload failed with error code: ' . $file['error']]);
            exit;
        }

        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'ico', 'pdf', 'bmp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExts, true)) {
            echo json_encode(['success' => false, 'error' => 'File extension .' . $ext . ' is not allowed.']);
            exit;
        }

        // Folder selection
        $folder = trim($_POST['folder'] ?? '');
        $imagesRoot = realpath(dirname(__DIR__) . '/images');
        if ($folder === 'root' || $folder === '' || $folder === 'all') {
            $targetDir = $imagesRoot;
            $webPrefix = 'images/';
            $folderName = 'root';
        } else {
            $subfolder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $folder);
            $targetDir = $imagesRoot . DIRECTORY_SEPARATOR . $subfolder;
            $webPrefix = 'images/' . $subfolder . '/';
            $folderName = $subfolder;
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
        }

        $safeBase = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $autoConvert = isset($_POST['convert_webp']) ? ($_POST['convert_webp'] === '1' || $_POST['convert_webp'] === 'true') : true;

        // Automatic WebP Conversion for non-WebP image formats if enabled
        $convertible = in_array($ext, ['jpg', 'jpeg', 'png', 'bmp', 'gif'], true);
        if ($convertible && $autoConvert) {
            $webpFilename = $safeBase . '-' . time() . '.webp';
            $webpDestination = $targetDir . DIRECTORY_SEPARATOR . $webpFilename;

            $tempDestination = $targetDir . DIRECTORY_SEPARATOR . 'temp_' . time() . '_' . $file['name'];
            if (move_uploaded_file($file['tmp_name'], $tempDestination)) {
                $converted = CmsWebPConverter::convertToWebP($tempDestination, $webpDestination);
                @unlink($tempDestination);

                if ($converted && file_exists($webpDestination)) {
                    $dim = @getimagesize($webpDestination);
                    $webPath = $webPrefix . $webpFilename;
                    $relPath = ($folderName === 'root' ? '' : $folderName . '/') . $webpFilename;
                    echo json_encode([
                        'success' => true,
                        'url' => '/' . $webPath,
                        'rel_path' => $relPath,
                        'filename' => $webpFilename,
                        'format' => 'webp',
                        'size' => filesize($webpDestination),
                        'size_kb' => round(filesize($webpDestination) / 1024, 1),
                        'width' => $dim[0] ?? null,
                        'height' => $dim[1] ?? null,
                        'converted' => true,
                        'original_format' => $ext
                    ]);
                    exit;
                }
            }
        }

        // Native save (WebP, SVG, ICO, or if conversion was disabled/failed)
        $filename = $safeBase . '-' . time() . '.' . $ext;
        $destination = $targetDir . DIRECTORY_SEPARATOR . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $dim = @getimagesize($destination);
            $webPath = $webPrefix . $filename;
            $relPath = ($folderName === 'root' ? '' : $folderName . '/') . $filename;
            echo json_encode([
                'success' => true,
                'url' => '/' . $webPath,
                'rel_path' => $relPath,
                'filename' => $filename,
                'format' => $ext,
                'size' => filesize($destination),
                'size_kb' => round(filesize($destination) / 1024, 1),
                'width' => $dim[0] ?? null,
                'height' => $dim[1] ?? null,
                'converted' => ($ext === 'webp')
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Could not move uploaded file. Check directory permissions.']);
        }
        exit;

    // 5. Delete Single Media File
    case 'delete_media':
        $relPath = trim($_POST['path'] ?? '');
        if ($relPath === '') {
            echo json_encode(['success' => false, 'error' => 'No file path specified.']);
            exit;
        }

        $fullPath = getSafeMediaPath($relPath);
        if (!$fullPath || !is_file($fullPath)) {
            echo json_encode(['success' => false, 'error' => 'File not found or access denied.']);
            exit;
        }

        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'ico', 'pdf', 'bmp'];
        if (!in_array($ext, $allowedExts, true)) {
            echo json_encode(['success' => false, 'error' => 'Cannot delete non-media file.']);
            exit;
        }

        $filename = basename($fullPath);
        if (@unlink($fullPath)) {
            echo json_encode(['success' => true, 'message' => "Deleted \"{$filename}\" successfully."]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete file from disk. Check file permissions.']);
        }
        exit;

    // 6. Bulk Delete Media Files
    case 'bulk_delete_media':
        $paths = $_POST['paths'] ?? [];
        if (is_string($paths)) {
            $paths = json_decode($paths, true);
        }
        if (!is_array($paths) || empty($paths)) {
            echo json_encode(['success' => false, 'error' => 'No files selected for deletion.']);
            exit;
        }

        $deleted = 0;
        $failed = [];
        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'ico', 'pdf', 'bmp'];

        foreach ($paths as $rel) {
            $full = getSafeMediaPath($rel);
            if (!$full || !is_file($full)) {
                $failed[] = ['path' => $rel, 'error' => 'Not found'];
                continue;
            }
            $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExts, true)) {
                $failed[] = ['path' => $rel, 'error' => 'Invalid file extension'];
                continue;
            }
            if (@unlink($full)) {
                $deleted++;
            } else {
                $failed[] = ['path' => $rel, 'error' => 'Unlink failed'];
            }
        }

        echo json_encode([
            'success' => true,
            'deleted_count' => $deleted,
            'failed' => $failed,
            'message' => "Successfully deleted {$deleted} image(s)."
        ]);
        exit;

    // 7. Replace Media File (Update file content in-place)
    case 'replace_media':
        $relPath = trim($_POST['path'] ?? '');
        if ($relPath === '') {
            echo json_encode(['success' => false, 'error' => 'Target image path is required.']);
            exit;
        }

        $targetPath = getSafeMediaPath($relPath);
        if (!$targetPath || !is_file($targetPath)) {
            echo json_encode(['success' => false, 'error' => 'Target file to replace was not found.']);
            exit;
        }

        if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Upload failed or no replacement file uploaded.']);
            exit;
        }

        $uploadedFile = $_FILES['file'];
        $uploadExt = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
        $targetExt = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'ico', 'bmp'];

        if (!in_array($uploadExt, $allowedExts, true)) {
            echo json_encode(['success' => false, 'error' => "File extension .{$uploadExt} is not allowed."]);
            exit;
        }

        // If target is WebP and uploaded is convertible JPG/PNG, convert to WebP and overwrite targetPath
        $convertible = in_array($uploadExt, ['jpg', 'jpeg', 'png', 'bmp', 'gif'], true);
        if ($targetExt === 'webp' && $convertible && $uploadExt !== 'webp') {
            $converted = CmsWebPConverter::convertToWebP($uploadedFile['tmp_name'], $targetPath);
            if ($converted && file_exists($targetPath)) {
                touch($targetPath);
                $dim = @getimagesize($targetPath);
                echo json_encode([
                    'success' => true,
                    'message' => 'Image successfully replaced and converted to WebP!',
                    'size_kb' => round(filesize($targetPath) / 1024, 1),
                    'width' => $dim[0] ?? null,
                    'height' => $dim[1] ?? null,
                    'cache_bust' => time()
                ]);
                exit;
            }
        }

        // Overwrite in-place
        if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
            touch($targetPath);
            $dim = @getimagesize($targetPath);
            echo json_encode([
                'success' => true,
                'message' => 'Image replaced successfully!',
                'size_kb' => round(filesize($targetPath) / 1024, 1),
                'width' => $dim[0] ?? null,
                'height' => $dim[1] ?? null,
                'cache_bust' => time()
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Could not replace file. Check file permissions.']);
        }
        exit;

    // 8. Rename Media File
    case 'rename_media':
        $oldRel = trim($_POST['old_path'] ?? '');
        $newName = trim($_POST['new_name'] ?? '');
        $updateRefs = !empty($_POST['update_references']);

        if ($oldRel === '' || $newName === '') {
            echo json_encode(['success' => false, 'error' => 'Old path and new name are required.']);
            exit;
        }

        $oldFullPath = getSafeMediaPath($oldRel);
        if (!$oldFullPath || !is_file($oldFullPath)) {
            echo json_encode(['success' => false, 'error' => 'Source file not found.']);
            exit;
        }

        $oldExt = strtolower(pathinfo($oldFullPath, PATHINFO_EXTENSION));
        $newExt = strtolower(pathinfo($newName, PATHINFO_EXTENSION));

        // Sanitize clean base name and ensure original extension is retained
        $cleanBase = preg_replace('/[^a-zA-Z0-9_\-]/', '-', pathinfo($newName, PATHINFO_FILENAME));
        $cleanBase = trim(preg_replace('/-+/', '-', $cleanBase), '-');
        $newFilename = $cleanBase . '.' . $oldExt;

        if ($cleanBase === '') {
            echo json_encode(['success' => false, 'error' => 'New filename is invalid.']);
            exit;
        }

        $dir = dirname($oldFullPath);
        $newFullPath = $dir . DIRECTORY_SEPARATOR . $newFilename;

        if (file_exists($newFullPath)) {
            echo json_encode(['success' => false, 'error' => "A file named \"{$newFilename}\" already exists in this folder."]);
            exit;
        }

        if (rename($oldFullPath, $newFullPath)) {
            $imagesRoot = realpath(dirname(__DIR__) . '/images');
            $oldRelClean = ltrim(str_replace(['\\', $imagesRoot], ['/', ''], $oldFullPath), '/');
            $newRelClean = ltrim(str_replace(['\\', $imagesRoot], ['/', ''], $newFullPath), '/');

            $updatedRefs = 0;
            if ($updateRefs) {
                $updatedRefs = updateMediaReferencesInCms($oldRelClean, $newRelClean);
            }

            echo json_encode([
                'success' => true,
                'message' => "Renamed to \"{$newFilename}\"" . ($updatedRefs > 0 ? " and updated {$updatedRefs} reference(s) across CMS pages." : "."),
                'new_name' => $newFilename,
                'new_rel_path' => $newRelClean,
                'new_url' => '/images/' . $newRelClean,
                'updated_references' => $updatedRefs
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to rename file on disk.']);
        }
        exit;

    // 9. Move Media File to Another Folder
    case 'move_media':
        $relPath = trim($_POST['path'] ?? '');
        $targetFolder = trim($_POST['target_folder'] ?? 'root');
        $updateRefs = !empty($_POST['update_references']);

        $srcPath = getSafeMediaPath($relPath);
        if (!$srcPath || !is_file($srcPath)) {
            echo json_encode(['success' => false, 'error' => 'Source file not found.']);
            exit;
        }

        $imagesRoot = realpath(dirname(__DIR__) . '/images');
        if ($targetFolder === 'root' || $targetFolder === '') {
            $destDir = $imagesRoot;
        } else {
            $safeFolder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $targetFolder);
            $destDir = $imagesRoot . DIRECTORY_SEPARATOR . $safeFolder;
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0755, true);
            }
        }

        $filename = basename($srcPath);
        $destPath = $destDir . DIRECTORY_SEPARATOR . $filename;

        if (file_exists($destPath)) {
            echo json_encode(['success' => false, 'error' => "A file named \"{$filename}\" already exists in folder \"{$targetFolder}\"."]);
            exit;
        }

        if (rename($srcPath, $destPath)) {
            $oldRelClean = ltrim(str_replace(['\\', $imagesRoot], ['/', ''], $srcPath), '/');
            $newRelClean = ltrim(str_replace(['\\', $imagesRoot], ['/', ''], $destPath), '/');

            $updatedRefs = 0;
            if ($updateRefs) {
                $updatedRefs = updateMediaReferencesInCms($oldRelClean, $newRelClean);
            }

            echo json_encode([
                'success' => true,
                'message' => "Moved \"{$filename}\" to {$targetFolder}" . ($updatedRefs > 0 ? " and updated {$updatedRefs} reference(s)." : "."),
                'new_rel_path' => $newRelClean,
                'new_url' => '/images/' . $newRelClean,
                'updated_references' => $updatedRefs
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to move file.']);
        }
        exit;

    // 10. Create New Media Folder
    case 'create_media_folder':
        $folderName = trim($_POST['folder_name'] ?? '');
        $clean = preg_replace('/[^a-zA-Z0-9_\-]/', '', strtolower($folderName));
        if ($clean === '') {
            echo json_encode(['success' => false, 'error' => 'Invalid folder name. Use letters, numbers, and hyphens.']);
            exit;
        }

        $imagesRoot = realpath(dirname(__DIR__) . '/images');
        $targetDir = $imagesRoot . DIRECTORY_SEPARATOR . $clean;

        if (is_dir($targetDir)) {
            echo json_encode(['success' => false, 'error' => "Folder \"{$clean}\" already exists."]);
            exit;
        }

        if (@mkdir($targetDir, 0755, true)) {
            echo json_encode(['success' => true, 'folder' => $clean, 'message' => "Folder \"{$clean}\" created successfully!"]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to create folder. Check permissions.']);
        }
        exit;

    // 11. Check Media Usage
    case 'check_media_usage':
        $relPath = trim($_GET['path'] ?? $_POST['path'] ?? '');
        if ($relPath === '') {
            echo json_encode(['success' => false, 'error' => 'No path provided.']);
            exit;
        }

        $pages = findMediaUsage($relPath);
        echo json_encode([
            'success' => true,
            'pages' => $pages,
            'count' => count($pages),
            'in_use' => count($pages) > 0
        ]);
        exit;

    // 5. Scan Legacy Images for WebP Migration
    case 'scan_legacy_images':
        $images = CmsWebPConverter::scanLegacyImages();
        $unconverted = array_values(array_filter($images, function($item) {
            return !$item['has_webp'];
        }));

        echo json_encode([
            'success' => true,
            'total_legacy' => count($images),
            'needs_conversion' => count($unconverted),
            'already_webp' => count($images) - count($unconverted),
            'items' => $unconverted
        ]);
        exit;

    // 6. Batch Convert Legacy Images to WebP
    case 'batch_convert_webp':
        $fileList = $_POST['files'] ?? [];
        if (is_string($fileList)) {
            $fileList = json_decode($fileList, true);
        }
        if (!is_array($fileList) || empty($fileList)) {
            echo json_encode(['success' => false, 'error' => 'No files specified for batch conversion.']);
            exit;
        }

        $rootDir = dirname(__DIR__);
        $converted = [];
        $errors = [];
        $bytesSaved = 0;

        foreach ($fileList as $relPath) {
            $cleanRel = ltrim(str_replace('\\', '/', $relPath), '/');
            $sourceDisk = $rootDir . '/' . $cleanRel;

            if (!file_exists($sourceDisk)) {
                $errors[] = ['file' => $cleanRel, 'error' => 'File not found on disk'];
                continue;
            }

            $info = pathinfo($cleanRel);
            $webpRel = ($info['dirname'] === '.' || $info['dirname'] === '')
                ? $info['filename'] . '.webp'
                : $info['dirname'] . '/' . $info['filename'] . '.webp';
            $webpDisk = $rootDir . '/' . $webpRel;

            $origSize = filesize($sourceDisk);
            $res = CmsWebPConverter::convertToWebP($sourceDisk, $webpDisk);

            if ($res && file_exists($webpDisk)) {
                $newSize = filesize($webpDisk);
                $saved = max(0, $origSize - $newSize);
                $bytesSaved += $saved;
                $converted[] = [
                    'source' => $cleanRel,
                    'webp' => $webpRel,
                    'orig_size' => $origSize,
                    'new_size' => $newSize,
                    'saved' => $saved
                ];
            } else {
                $errors[] = ['file' => $cleanRel, 'error' => 'Failed to convert to WebP'];
            }
        }

        echo json_encode([
            'success' => true,
            'converted_count' => count($converted),
            'error_count' => count($errors),
            'bytes_saved' => $bytesSaved,
            'converted' => $converted,
            'errors' => $errors
        ]);
        exit;

    // 5. Save Global Design Customizer
    case 'save_design':
        $designJson = $_POST['theme'] ?? '';
        $design = json_decode($designJson, true);

        if (!is_array($design)) {
            echo json_encode(['success' => false, 'error' => 'Invalid design payload.']);
            exit;
        }

        $currentGlobal = CMS::loadPage('global');
        $currentGlobal['theme'] = array_merge($currentGlobal['theme'] ?? [], $design);
        $saved = CMS::savePage('global', $currentGlobal);

        echo json_encode(['success' => $saved, 'message' => 'Design & styling saved successfully!']);
        exit;

    // 6. Save Navigation & Header/Footer
    case 'save_navigation':
        $navJson = $_POST['data'] ?? '';
        $navData = json_decode($navJson, true);

        if (!is_array($navData)) {
            echo json_encode(['success' => false, 'error' => 'Invalid navigation payload.']);
            exit;
        }

        $currentGlobal = CMS::loadPage('global');
        foreach ($navData as $k => $v) {
            $currentGlobal[$k] = $v;
        }
        $saved = CMS::savePage('global', $currentGlobal);

        echo json_encode(['success' => $saved, 'message' => 'Navigation & footer updated successfully!']);
        exit;

    default:
        echo json_encode(['success' => false, 'error' => 'Unknown API action.']);
        exit;
}
