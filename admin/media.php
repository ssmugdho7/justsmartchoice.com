<?php
require_once __DIR__ . '/auth.php';
AdminAuth::requireLogin();

$rootImageDir = dirname(__DIR__) . '/images';

// Helper to scan CMS JSON files and find where media is referenced
function getMediaUsageMap(): array
{
    $usage = [];
    $dataDir = dirname(__DIR__) . '/cms-data';
    $files = glob($dataDir . '/*.json') ?: [];
    $pageFiles = glob($dataDir . '/pages/*.json') ?: [];
    $allFiles = array_merge($files, $pageFiles);

    foreach ($allFiles as $f) {
        $slug = basename($f, '.json');
        if (in_array($slug, ['users', 'pages_manifest'], true)) continue;
        $pageName = ucfirst(str_replace(['-', '_'], ' ', $slug));

        $content = @file_get_contents($f);
        if (!$content) continue;

        // Find all strings pointing to image files
        if (preg_match_all('#(?:/?images/)?([a-zA-Z0-9_\-\./]+\.(?:jpg|jpeg|png|webp|svg|gif|ico))#i', $content, $matches)) {
            foreach ($matches[1] as $ref) {
                $refName = basename($ref);
                $cleanRef = ltrim(str_replace('images/', '', $ref), '/');
                $usage[$refName][$slug] = $pageName;
                $usage[$cleanRef][$slug] = $pageName;
            }
        }
    }
    return $usage;
}

$usageMap = getMediaUsageMap();

// Helper to scan directory for images recursively
function scanMedia(string $dir, string $baseWeb = '/images', string $relBase = '', array $usageMap = []): array
{
    $results = [];
    if (!is_dir($dir)) return $results;

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $fullPath = $dir . '/' . $item;

        if (is_dir($fullPath)) {
            $subResults = scanMedia(
                $fullPath,
                $baseWeb . '/' . $item,
                ($relBase === '' ? $item : $relBase . '/' . $item),
                $usageMap
            );
            $results = array_merge($results, $subResults);
        } else {
            $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif', 'ico'])) {
                $size = @filesize($fullPath) ?: 0;
                $dim = @getimagesize($fullPath);
                $folder = basename($dir);
                if ($folder === 'images') $folder = 'root';

                $relPath = ($relBase === '') ? $item : ($relBase . '/' . $item);

                // Check usage across CMS
                $usedPages = [];
                if (!empty($usageMap[$item])) {
                    $usedPages = array_merge($usedPages, array_values($usageMap[$item]));
                }
                if ($relBase !== '' && !empty($usageMap[$relPath])) {
                    $usedPages = array_merge($usedPages, array_values($usageMap[$relPath]));
                }
                $usedPages = array_values(array_unique($usedPages));

                $results[] = [
                    'name' => $item,
                    'folder' => $folder,
                    'rel_path' => $relPath,
                    'url' => $baseWeb . '/' . $item,
                    'size_bytes' => $size,
                    'size_kb' => round($size / 1024, 1),
                    'width' => $dim[0] ?? null,
                    'height' => $dim[1] ?? null,
                    'ext' => $ext,
                    'time' => filemtime($fullPath),
                    'date' => date('M j, Y g:i A', filemtime($fullPath)),
                    'used_pages' => $usedPages,
                    'in_use' => count($usedPages) > 0
                ];
            }
        }
    }
    return $results;
}

$allMedia = scanMedia($rootImageDir, '/images', '', $usageMap);

// Sort newest first by default
usort($allMedia, fn($a, $b) => $b['time'] <=> $a['time']);

// Handle AJAX JSON request for media picker modal
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($allMedia);
    exit;
}

$pageTitle = 'Media Manager';
$breadcrumb = 'Media & Image Assets';
require_once __DIR__ . '/header.php';
$csrfToken = AdminAuth::csrfToken();

// Compute statistics and folders
$totalBytes = 0;
$inUseCount = 0;
$folders = ['all' => ['label' => 'All Images', 'count' => count($allMedia)]];
$folders['root'] = ['label' => 'Root (/images)', 'count' => 0];

foreach ($allMedia as $m) {
    $totalBytes += $m['size_bytes'];
    if ($m['in_use']) $inUseCount++;
    $f = $m['folder'];
    if (!isset($folders[$f])) {
        $folders[$f] = ['label' => ucfirst($f), 'count' => 0];
    }
    $folders[$f]['count']++;
}
$totalSizeMB = round($totalBytes / (1024 * 1024), 2);
?>

<div class="cms-content">

    <!-- Top Header & Metrics -->
    <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 700; color: var(--text-dark); display: flex; align-items: center; gap: 10px;">
                <i class="fa-regular fa-images" style="color: var(--forest-green);"></i> Media & Image Assets
            </h2>
            <p style="font-size: 13.5px; color: var(--text-muted); margin-top: 4px;">
                Full CRUD control: upload, replace, rename, move, inspect, and delete website photos and graphics.
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <button type="button" id="btnBulkDelete" class="cms-btn cms-btn-danger" style="display: none;" onclick="cmsOpenBulkDeleteModal()">
                <i class="fa-regular fa-trash-can"></i> Delete Selected (<span id="bulkDeleteCount">0</span>)
            </button>
            <button type="button" class="cms-btn cms-btn-outline" onclick="cmsOpenCreateFolderModal()">
                <i class="fa-solid fa-folder-plus"></i> New Folder
            </button>
            <button type="button" class="cms-btn cms-btn-primary" onclick="cmsScrollToUpload()">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload Media
            </button>
        </div>
    </div>

    <!-- Stats Bar -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="cms-card" style="margin-bottom: 0; padding: 16px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Total Assets</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--text-dark); margin-top: 4px;"><?php echo count($allMedia); ?></div>
            <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;">WebP, PNG, JPG & SVG</div>
        </div>
        <div class="cms-card" style="margin-bottom: 0; padding: 16px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Storage Used</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--forest-green); margin-top: 4px;"><?php echo $totalSizeMB; ?> MB</div>
            <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;">Total disk usage</div>
        </div>
        <div class="cms-card" style="margin-bottom: 0; padding: 16px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Referenced in CMS</div>
            <div style="font-size: 24px; font-weight: 700; color: #0284c7; margin-top: 4px;"><?php echo $inUseCount; ?></div>
            <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;"><?php echo count($allMedia) - $inUseCount; ?> unused / standalone</div>
        </div>
        <div class="cms-card" style="margin-bottom: 0; padding: 16px 20px;">
            <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Folders</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--text-dark); margin-top: 4px;"><?php echo max(1, count($folders) - 1); ?></div>
            <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;">Organized categories</div>
        </div>
    </div>

    <!-- Drag & Drop Upload Zone -->
    <div class="cms-card" id="mediaUploadSection" style="margin-bottom: 24px;">
        <div class="cms-card-body" style="padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--text-dark);"><i class="fa-solid fa-folder-open" style="color: var(--forest-green);"></i> Upload to:</span>
                    <select id="mediaUploadFolderSelect" class="cms-input" style="width: 190px; height: 36px; font-size: 13px;">
                        <option value="root">Root (/images)</option>
                        <?php foreach ($folders as $fKey => $fData): ?>
                            <?php if ($fKey !== 'all' && $fKey !== 'root'): ?>
                                <option value="<?php echo htmlspecialchars($fKey); ?>"><?php echo htmlspecialchars($fData['label']); ?> (<?php echo $fData['count']; ?>)</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--text-dark); cursor: pointer;">
                        <input type="checkbox" id="mediaAutoWebPCheckbox" checked style="accent-color: var(--forest-green);">
                        <span>Auto-convert PNG/JPG to WebP for fast page loads</span>
                    </label>
                </div>
            </div>

            <div id="mediaDropZone" style="border: 2px dashed var(--forest-green); background-color: var(--green-50); border-radius: var(--radius-md); padding: 32px 20px; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                <input type="file" id="mediaUploadFileInput" multiple style="display: none;" onchange="cmsUploadMultipleFiles(this)">
                <i class="fa-regular fa-image" style="font-size: 38px; color: var(--forest-green); margin-bottom: 10px; display: block;"></i>
                <div style="font-size: 15px; font-weight: 600; color: var(--forest-green);">Drag & drop image files here, or click to browse</div>
                <div style="font-size: 12.5px; color: var(--text-muted); margin-top: 6px;">
                    Supports WebP, PNG, JPG, JPEG, SVG, and GIF up to 15MB each
                </div>
            </div>

            <div id="mediaUploadProgressArea" style="display: none; margin-top: 16px;">
                <div style="display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 600; margin-bottom: 6px;">
                    <span id="uploadStatusText">Uploading files...</span>
                    <span id="uploadPercentText">0%</span>
                </div>
                <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                    <div id="uploadProgressBar" style="width: 0%; height: 100%; background: var(--forest-green); transition: width 0.2s ease;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter, Search & View Controls -->
    <div class="cms-card" style="margin-bottom: 20px;">
        <div class="cms-card-body" style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
            
            <!-- Folder filter pills -->
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Folder:</span>
                <?php foreach ($folders as $fKey => $fData): ?>
                    <button type="button" class="cms-btn cms-btn-outline cms-btn-sm media-folder-filter <?php echo ($fKey === 'all') ? 'active' : ''; ?>" data-folder="<?php echo htmlspecialchars($fKey); ?>" style="<?php echo ($fKey === 'all') ? 'background: var(--green-100); color: var(--forest-green); border-color: var(--forest-green); font-weight: 700;' : ''; ?>">
                        <?php echo htmlspecialchars($fData['label']); ?>
                        <span style="opacity: 0.75; font-size: 10.5px; margin-left: 2px;">(<?php echo $fData['count']; ?>)</span>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Search, Status, Sort & View Mode Switcher -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                
                <!-- Status Filter -->
                <select id="mediaStatusFilter" class="cms-input" style="width: 130px; height: 34px; font-size: 12.5px;">
                    <option value="all">All Status</option>
                    <option value="in_use">In Use Only</option>
                    <option value="unused">Unused Only</option>
                </select>

                <!-- Sort Filter -->
                <select id="mediaSortSelect" class="cms-input" style="width: 140px; height: 34px; font-size: 12.5px;">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="name_asc">Name (A-Z)</option>
                    <option value="name_desc">Name (Z-A)</option>
                    <option value="size_desc">Largest Size</option>
                    <option value="size_asc">Smallest Size</option>
                </select>

                <!-- Search -->
                <div style="position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: var(--text-muted); font-size: 12px;"></i>
                    <input type="text" id="mediaSearchInput" class="cms-input" placeholder="Search filename..." style="padding-left: 30px; font-size: 12.5px; width: 180px; height: 34px;">
                </div>

                <!-- View Mode Toggle -->
                <div style="display: inline-flex; border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); overflow: hidden;">
                    <button type="button" id="btnViewGrid" class="cms-btn cms-btn-outline cms-btn-sm" style="border: none; border-radius: 0; background: var(--green-100); color: var(--forest-green); padding: 7px 11px;" title="Grid View">
                        <i class="fa-solid fa-table-cells-large"></i>
                    </button>
                    <button type="button" id="btnViewTable" class="cms-btn cms-btn-outline cms-btn-sm" style="border: none; border-radius: 0; padding: 7px 11px;" title="List / Table View">
                        <i class="fa-solid fa-list"></i>
                    </button>
                </div>

            </div>

        </div>

        <!-- Bulk selection bar -->
        <div id="mediaBulkBar" style="padding: 10px 20px; background-color: #f1f5f9; border-top: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between; font-size: 12.5px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; font-weight: 600; color: var(--text-dark);">
                    <input type="checkbox" id="selectAllCheckbox" style="accent-color: var(--forest-green);">
                    <span>Select All (<span id="visibleItemsCount"><?php echo count($allMedia); ?></span> visible)</span>
                </label>
                <span id="selectedCountIndicator" style="color: var(--text-muted); font-weight: 500;">0 selected</span>
            </div>
            <div>
                <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="cmsDeselectAll()" style="font-size: 11.5px; padding: 3px 8px;">
                    Deselect All
                </button>
            </div>
        </div>
    </div>

    <!-- Images Grid View -->
    <div id="mediaGridContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
        <?php foreach ($allMedia as $item): ?>
            <div class="media-card-item"
                 data-folder="<?php echo htmlspecialchars($item['folder']); ?>"
                 data-name="<?php echo htmlspecialchars(strtolower($item['name'])); ?>"
                 data-rel-path="<?php echo htmlspecialchars($item['rel_path']); ?>"
                 data-url="<?php echo htmlspecialchars($item['url']); ?>"
                 data-size-bytes="<?php echo $item['size_bytes']; ?>"
                 data-time="<?php echo $item['time']; ?>"
                 data-in-use="<?php echo $item['in_use'] ? '1' : '0'; ?>"
                 data-used-pages="<?php echo htmlspecialchars(implode(', ', $item['used_pages'])); ?>"
                 data-width="<?php echo $item['width'] ?: ''; ?>"
                 data-height="<?php echo $item['height'] ?: ''; ?>"
                 data-ext="<?php echo htmlspecialchars($item['ext']); ?>"
                 style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; transition: transform 0.15s ease, box-shadow 0.15s ease; position: relative;">
                
                <!-- Card Image Box -->
                <div style="width: 100%; height: 140px; background-color: #0f172a10; background-image: linear-gradient(45deg, #f1f5f9 25%, transparent 25%), linear-gradient(-45deg, #f1f5f9 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #f1f5f9 75%), linear-gradient(-45deg, transparent 75%, #f1f5f9 75%); background-size: 16px 16px; background-position: 0 0, 0 8px, 8px -8px, -8px 0px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                    
                    <!-- Selection Checkbox -->
                    <div style="position: absolute; top: 8px; left: 8px; z-index: 2;">
                        <input type="checkbox" class="media-select-box" value="<?php echo htmlspecialchars($item['rel_path']); ?>" style="width: 16px; height: 16px; accent-color: var(--forest-green); cursor: pointer;" onchange="cmsUpdateBulkSelectionState()">
                    </div>

                    <!-- Extension Badge -->
                    <span class="cms-badge" style="position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.7); color: #fff; font-size: 10px; z-index: 2; padding: 2px 6px;">
                        <?php echo strtoupper($item['ext']); ?>
                    </span>

                    <img src="<?php echo htmlspecialchars($item['url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain; cursor: pointer; transition: transform 0.2s ease;" loading="lazy" onclick="cmsOpenInspectModal(this.closest('.media-card-item'))" onmouseover="this.style.transform='scale(1.04)';" onmouseout="this.style.transform='scale(1)';">
                </div>

                <!-- Card Body -->
                <div style="padding: 10px 12px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="font-weight: 600; font-size: 12.5px; color: var(--text-dark); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($item['name']); ?>">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: var(--text-muted); margin-top: 4px;">
                            <span><?php echo ($item['width'] && $item['height']) ? "{$item['width']}×{$item['height']}" : "Vector"; ?></span>
                            <span><?php echo $item['size_kb']; ?> KB</span>
                        </div>

                        <!-- Usage status -->
                        <div style="margin-top: 6px;">
                            <?php if ($item['in_use']): ?>
                                <span class="cms-badge cms-badge-green" style="font-size: 10.5px; padding: 2px 6px;" title="Used on: <?php echo htmlspecialchars(implode(', ', $item['used_pages'])); ?>">
                                    <i class="fa-solid fa-link" style="font-size: 9px;"></i> In Use (<?php echo count($item['used_pages']); ?>)
                                </span>
                            <?php else: ?>
                                <span class="cms-badge cms-badge-gray" style="font-size: 10.5px; padding: 2px 6px;">
                                    Unused
                                </span>
                            <?php endif; ?>
                            <span class="cms-badge cms-badge-gray" style="font-size: 10px; padding: 2px 5px; margin-left: 2px;">
                                <?php echo htmlspecialchars($item['folder']); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr; gap: 4px;">
                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 5px 0; font-size: 11px;" title="Inspect & Details" onclick="cmsOpenInspectModal(this.closest('.media-card-item'))">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 5px 0; font-size: 11px;" title="Replace Image" onclick="cmsOpenReplaceModal('<?php echo htmlspecialchars($item['rel_path'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['url'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>')">
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        </button>
                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 5px 0; font-size: 11px;" title="Rename File" onclick="cmsOpenRenameModal('<?php echo htmlspecialchars($item['rel_path'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 5px 0; font-size: 11px;" title="Copy URL" onclick="cmsCopyUrl('<?php echo htmlspecialchars($item['url'], ENT_QUOTES); ?>')">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                        <button type="button" class="cms-btn cms-btn-danger-outline cms-btn-sm" style="padding: 5px 0; font-size: 11px;" title="Delete Image" onclick="cmsOpenDeleteModal('<?php echo htmlspecialchars($item['rel_path'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['url'], ENT_QUOTES); ?>', <?php echo $item['in_use'] ? 'true' : 'false'; ?>, '<?php echo htmlspecialchars(implode(', ', $item['used_pages']), ENT_QUOTES); ?>')">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Images Table / List View (Hidden by default) -->
    <div id="mediaTableContainer" class="cms-card" style="display: none; margin-bottom: 24px;">
        <div class="cms-table-wrapper">
            <table class="cms-table">
                <thead>
                    <tr>
                        <th style="width: 36px; text-align: center;"></th>
                        <th style="width: 56px;">Preview</th>
                        <th>File Name & Path</th>
                        <th>Folder</th>
                        <th>Resolution</th>
                        <th>Size</th>
                        <th>Usage in CMS</th>
                        <th>Modified</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="mediaTableBody">
                    <?php foreach ($allMedia as $item): ?>
                        <tr class="media-table-row"
                            data-folder="<?php echo htmlspecialchars($item['folder']); ?>"
                            data-name="<?php echo htmlspecialchars(strtolower($item['name'])); ?>"
                            data-rel-path="<?php echo htmlspecialchars($item['rel_path']); ?>"
                            data-url="<?php echo htmlspecialchars($item['url']); ?>"
                            data-size-bytes="<?php echo $item['size_bytes']; ?>"
                            data-time="<?php echo $item['time']; ?>"
                            data-in-use="<?php echo $item['in_use'] ? '1' : '0'; ?>"
                            data-used-pages="<?php echo htmlspecialchars(implode(', ', $item['used_pages'])); ?>"
                            data-width="<?php echo $item['width'] ?: ''; ?>"
                            data-height="<?php echo $item['height'] ?: ''; ?>"
                            data-ext="<?php echo htmlspecialchars($item['ext']); ?>">
                            
                            <td style="text-align: center;">
                                <input type="checkbox" class="media-select-box" value="<?php echo htmlspecialchars($item['rel_path']); ?>" style="width: 16px; height: 16px; accent-color: var(--forest-green); cursor: pointer;" onchange="cmsUpdateBulkSelectionState()">
                            </td>
                            <td>
                                <div style="width: 44px; height: 44px; border-radius: 4px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="cmsOpenInspectModal(this.closest('.media-table-row'))">
                                    <img src="<?php echo htmlspecialchars($item['url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="max-width: 100%; max-height: 100%; object-fit: cover;" loading="lazy">
                                </div>
                            </td>
                            <td>
                                <strong style="color: var(--text-dark); cursor: pointer;" onclick="cmsOpenInspectModal(this.closest('.media-table-row'))">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </strong>
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                                    <?php echo htmlspecialchars($item['url']); ?>
                                </div>
                            </td>
                            <td>
                                <span class="cms-badge cms-badge-gray"><?php echo htmlspecialchars($item['folder']); ?></span>
                            </td>
                            <td>
                                <?php echo ($item['width'] && $item['height']) ? "{$item['width']}×{$item['height']} px" : "Vector (SVG)"; ?>
                            </td>
                            <td>
                                <?php echo $item['size_kb']; ?> KB
                            </td>
                            <td>
                                <?php if ($item['in_use']): ?>
                                    <span class="cms-badge cms-badge-green" title="<?php echo htmlspecialchars(implode(', ', $item['used_pages'])); ?>">
                                        <i class="fa-solid fa-link" style="font-size: 9px;"></i> <?php echo htmlspecialchars(implode(', ', $item['used_pages'])); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="cms-badge cms-badge-gray">Unused</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 11.5px; color: var(--text-muted);">
                                <?php echo $item['date']; ?>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 4px 8px;" title="Inspect" onclick="cmsOpenInspectModal(this.closest('.media-table-row'))">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 4px 8px;" title="Replace File" onclick="cmsOpenReplaceModal('<?php echo htmlspecialchars($item['rel_path'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['url'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>')">
                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                </button>
                                <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 4px 8px;" title="Rename" onclick="cmsOpenRenameModal('<?php echo htmlspecialchars($item['rel_path'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" style="padding: 4px 8px;" title="Copy URL" onclick="cmsCopyUrl('<?php echo htmlspecialchars($item['url'], ENT_QUOTES); ?>')">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                                <button type="button" class="cms-btn cms-btn-danger-outline cms-btn-sm" style="padding: 4px 8px;" title="Delete" onclick="cmsOpenDeleteModal('<?php echo htmlspecialchars($item['rel_path'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($item['url'], ENT_QUOTES); ?>', <?php echo $item['in_use'] ? 'true' : 'false'; ?>, '<?php echo htmlspecialchars(implode(', ', $item['used_pages']), ENT_QUOTES); ?>')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ========================================================
     MODALS: Inspect, Replace, Rename, Delete, Bulk Delete, New Folder
======================================================== -->

<!-- 1. INSPECT & DETAILS MODAL -->
<div id="modalInspect" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 92%; max-width: 820px; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 22px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong style="font-size: 16px; color: var(--text-dark); display: flex; align-items: center; gap: 8px;">
                <i class="fa-regular fa-image" style="color: var(--forest-green);"></i> <span id="inspectModalTitle">Image Details</span>
            </strong>
            <button type="button" onclick="cmsCloseModal('modalInspect')" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 22px; overflow-y: auto; flex: 1;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">
                <!-- Preview area -->
                <div style="background-color: #0f172a; border-radius: var(--radius-md); padding: 14px; display: flex; align-items: center; justify-content: center; min-height: 260px; max-height: 380px; overflow: hidden;">
                    <img id="inspectPreviewImg" src="" alt="" style="max-width: 100%; max-height: 350px; object-fit: contain; border-radius: 4px;">
                </div>
                <!-- Details list -->
                <div>
                    <h3 id="inspectFileName" style="font-size: 15px; font-weight: 700; color: var(--text-dark); word-break: break-all; margin-bottom: 14px;"></h3>
                    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px;">
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-subtle); padding-bottom: 6px;">
                            <span style="color: var(--text-muted);">Folder:</span>
                            <strong id="inspectFolder" style="color: var(--text-dark);"></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-subtle); padding-bottom: 6px;">
                            <span style="color: var(--text-muted);">Dimensions:</span>
                            <strong id="inspectDimensions" style="color: var(--text-dark);"></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-subtle); padding-bottom: 6px;">
                            <span style="color: var(--text-muted);">File Size:</span>
                            <strong id="inspectFileSize" style="color: var(--text-dark);"></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-subtle); padding-bottom: 6px;">
                            <span style="color: var(--text-muted);">Format:</span>
                            <strong id="inspectFormat" style="color: var(--text-dark); text-transform: uppercase;"></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-subtle); padding-bottom: 6px;">
                            <span style="color: var(--text-muted);">Usage:</span>
                            <span id="inspectUsageBadge"></span>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px; margin-top: 4px;">
                            <span style="color: var(--text-muted); font-size: 12px;">Web Path:</span>
                            <div style="display: flex; gap: 6px;">
                                <input type="text" id="inspectUrlInput" class="cms-input" readonly style="font-size: 12px; height: 32px; background: #f8fafc;">
                                <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="cmsCopyUrl(document.getElementById('inspectUrlInput').value)">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding: 14px 22px; border-top: 1px solid var(--border-subtle); background: #fafbfc; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; gap: 8px;">
                <button type="button" id="inspectBtnReplace" class="cms-btn cms-btn-primary cms-btn-sm">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i> Replace Image
                </button>
                <button type="button" id="inspectBtnRename" class="cms-btn cms-btn-outline cms-btn-sm">
                    <i class="fa-solid fa-pen-to-square"></i> Rename
                </button>
                <a id="inspectBtnDownload" href="" download class="cms-btn cms-btn-outline cms-btn-sm">
                    <i class="fa-solid fa-download"></i> Download
                </a>
            </div>
            <div>
                <button type="button" id="inspectBtnDelete" class="cms-btn cms-btn-danger cms-btn-sm">
                    <i class="fa-regular fa-trash-can"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. REPLACE IMAGE MODAL -->
<div id="modalReplace" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 90%; max-width: 540px; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong style="font-size: 15px; color: var(--text-dark); display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-right-arrow-left" style="color: var(--forest-green);"></i> Replace Image File
            </strong>
            <button type="button" onclick="cmsCloseModal('modalReplace')" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <form id="formReplaceMedia" onsubmit="cmsSubmitReplaceImage(event)" style="padding: 20px;">
            <input type="hidden" id="replaceTargetPath" name="path" value="">

            <div style="margin-bottom: 16px; padding: 12px; background: #f8fafc; border-radius: 6px; font-size: 13px;">
                <div style="color: var(--text-muted); font-size: 11px; text-transform: uppercase; font-weight: 700;">Target to Replace</div>
                <div id="replaceTargetName" style="font-weight: 600; color: var(--text-dark); word-break: break-all; margin-top: 2px;"></div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                    Select New Image File
                </label>
                <input type="file" id="replaceFileInput" accept="image/*" class="cms-input" style="padding: 6px 10px; font-size: 12.5px; width: 100%;" required onchange="cmsPreviewReplacementFile(this)">
            </div>

            <!-- New Image Live Preview -->
            <div id="replaceNewPreviewWrap" style="display: none; margin-bottom: 16px; text-align: center; background: #0f172a15; padding: 12px; border-radius: 6px;">
                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 6px;">New Replacement Preview</div>
                <img id="replaceNewPreviewImg" src="" style="max-height: 120px; max-width: 100%; object-fit: contain; border-radius: 4px;">
            </div>

            <div style="background: var(--green-50); border: 1px solid var(--green-200); border-radius: 6px; padding: 10px 14px; font-size: 12px; color: var(--green-900); margin-bottom: 18px;">
                <i class="fa-solid fa-circle-info"></i> <strong>In-Place Update:</strong> This directly updates the file on disk. Any web page or CMS section linking to this image will display the new version without broken links.
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="cms-btn cms-btn-outline" onclick="cmsCloseModal('modalReplace')">Cancel</button>
                <button type="submit" id="replaceSubmitBtn" class="cms-btn cms-btn-primary">
                    <i class="fa-solid fa-check"></i> Upload & Replace
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. RENAME IMAGE MODAL -->
<div id="modalRename" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 90%; max-width: 480px; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong style="font-size: 15px; color: var(--text-dark); display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: var(--forest-green);"></i> Rename Image File
            </strong>
            <button type="button" onclick="cmsCloseModal('modalRename')" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <form id="formRenameMedia" onsubmit="cmsSubmitRenameImage(event)" style="padding: 20px;">
            <input type="hidden" id="renameOldPath" name="old_path" value="">

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Current Name:</label>
                <div id="renameCurrentName" style="font-weight: 600; font-size: 13px; color: var(--text-dark); word-break: break-all;"></div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">New File Name:</label>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <input type="text" id="renameNewNameInput" class="cms-input" required style="font-size: 13px; flex: 1;">
                    <span id="renameExtBadge" class="cms-badge cms-badge-gray" style="font-size: 12px; height: 36px; display: inline-flex; align-items: center;"></span>
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--text-dark); cursor: pointer;">
                    <input type="checkbox" id="renameUpdateRefsCheckbox" checked style="accent-color: var(--forest-green);">
                    <span>Automatically update image references across CMS pages</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="cms-btn cms-btn-outline" onclick="cmsCloseModal('modalRename')">Cancel</button>
                <button type="submit" id="renameSubmitBtn" class="cms-btn cms-btn-primary">
                    <i class="fa-solid fa-check"></i> Rename File
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 4. DELETE SINGLE IMAGE MODAL -->
<div id="modalDelete" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 90%; max-width: 480px; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong style="font-size: 15px; color: #dc2626; display: flex; align-items: center; gap: 8px;">
                <i class="fa-regular fa-trash-can"></i> Delete Image Permanently
            </strong>
            <button type="button" onclick="cmsCloseModal('modalDelete')" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 20px;">
            <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 16px; background: #f8fafc; padding: 12px; border-radius: 6px;">
                <img id="deletePreviewImg" src="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-subtle);">
                <div style="flex: 1; overflow: hidden;">
                    <strong id="deleteFileName" style="font-size: 13.5px; color: var(--text-dark); display: block; word-break: break-all;"></strong>
                    <span style="font-size: 12px; color: var(--text-muted);">This action removes the file from disk permanently.</span>
                </div>
            </div>

            <!-- In-use warning alert -->
            <div id="deleteInUseWarning" style="display: none; background-color: #fef2f2; border: 1px solid #fee2e2; border-radius: 6px; padding: 12px 14px; margin-bottom: 16px; font-size: 12.5px; color: #991b1b;">
                <div style="font-weight: 700; margin-bottom: 4px;"><i class="fa-solid fa-triangle-exclamation"></i> Warning: Image In Active Use!</div>
                <div>This image is currently referenced on: <strong id="deleteUsedPagesList"></strong>. Deleting it may cause broken images on your live website.</div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="cms-btn cms-btn-outline" onclick="cmsCloseModal('modalDelete')">Cancel</button>
                <button type="button" id="deleteConfirmBtn" class="cms-btn cms-btn-danger" onclick="cmsConfirmSingleDelete()">
                    <i class="fa-regular fa-trash-can"></i> Yes, Delete Permanently
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 5. BULK DELETE MODAL -->
<div id="modalBulkDelete" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 90%; max-width: 500px; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong style="font-size: 15px; color: #dc2626; display: flex; align-items: center; gap: 8px;">
                <i class="fa-regular fa-trash-can"></i> Bulk Delete Images
            </strong>
            <button type="button" onclick="cmsCloseModal('modalBulkDelete')" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 20px;">
            <p style="font-size: 13.5px; color: var(--text-dark); margin-bottom: 14px;">
                Are you sure you want to permanently delete <strong id="bulkModalCount" style="color: #dc2626;">0</strong> selected image(s)?
            </p>
            <div id="bulkWarningList" style="max-height: 140px; overflow-y: auto; background: #f8fafc; border: 1px solid var(--border-subtle); border-radius: 6px; padding: 10px; font-size: 12px; margin-bottom: 18px;">
                <!-- Filled dynamically -->
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="cms-btn cms-btn-outline" onclick="cmsCloseModal('modalBulkDelete')">Cancel</button>
                <button type="button" id="bulkConfirmBtn" class="cms-btn cms-btn-danger" onclick="cmsConfirmBulkDelete()">
                    <i class="fa-regular fa-trash-can"></i> Delete Selected Images
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 6. NEW FOLDER MODAL -->
<div id="modalCreateFolder" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(2px);">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 90%; max-width: 440px; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong style="font-size: 15px; color: var(--text-dark); display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-folder-plus" style="color: var(--forest-green);"></i> Create New Folder
            </strong>
            <button type="button" onclick="cmsCloseModal('modalCreateFolder')" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <form id="formCreateFolder" onsubmit="cmsSubmitCreateFolder(event)" style="padding: 20px;">
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Folder Name:</label>
                <input type="text" id="createFolderNameInput" class="cms-input" placeholder="e.g. portfolio, reviews, certificates" required pattern="[a-zA-Z0-9_\-]+" style="font-size: 13px; width: 100%;">
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Use letters, numbers, hyphens or underscores only.</div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="cms-btn cms-btn-outline" onclick="cmsCloseModal('modalCreateFolder')">Cancel</button>
                <button type="submit" id="createFolderSubmitBtn" class="cms-btn cms-btn-primary">
                    <i class="fa-solid fa-folder-plus"></i> Create Folder
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const CSRF_TOKEN = '<?php echo htmlspecialchars($csrfToken); ?>';

// Active state variables
let activeDeletePath = null;
let activeFolder = 'all';
let activeStatus = 'all';
let searchQuery = '';
let currentSort = 'newest';
let currentView = 'grid';

// Copy URL helper
function cmsCopyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        cmsToast('Image URL copied to clipboard: ' + url);
    });
}

// Modal open/close helpers
function cmsOpenModal(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'flex';
}

function cmsCloseModal(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
}

function cmsScrollToUpload() {
    document.getElementById('mediaUploadSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// -----------------------------------------------------------------
// 1. INSPECT / DETAILS MODAL
// -----------------------------------------------------------------
function cmsOpenInspectModal(targetEl) {
    const relPath = targetEl.getAttribute('data-rel-path');
    const url = targetEl.getAttribute('data-url');
    const name = targetEl.getAttribute('data-name');
    const folder = targetEl.getAttribute('data-folder');
    const width = targetEl.getAttribute('data-width');
    const height = targetEl.getAttribute('data-height');
    const sizeBytes = parseInt(targetEl.getAttribute('data-size-bytes'), 10) || 0;
    const sizeKb = (sizeBytes / 1024).toFixed(1);
    const ext = targetEl.getAttribute('data-ext') || '';
    const inUse = targetEl.getAttribute('data-in-use') === '1';
    const usedPages = targetEl.getAttribute('data-used-pages') || '';

    document.getElementById('inspectModalTitle').innerText = name;
    document.getElementById('inspectFileName').innerText = name;
    document.getElementById('inspectPreviewImg').src = url;
    document.getElementById('inspectFolder').innerText = folder === 'root' ? 'Root (/images)' : folder;
    document.getElementById('inspectDimensions').innerText = (width && height) ? `${width} × ${height} px` : 'Vector (SVG)';
    document.getElementById('inspectFileSize').innerText = `${sizeKb} KB (${sizeBytes.toLocaleString()} bytes)`;
    document.getElementById('inspectFormat').innerText = ext;
    document.getElementById('inspectUrlInput').value = url;
    document.getElementById('inspectBtnDownload').href = url;
    document.getElementById('inspectBtnDownload').setAttribute('download', name);

    const usageEl = document.getElementById('inspectUsageBadge');
    if (inUse) {
        usageEl.innerHTML = `<span class="cms-badge cms-badge-green"><i class="fa-solid fa-link"></i> Used on: ${usedPages}</span>`;
    } else {
        usageEl.innerHTML = `<span class="cms-badge cms-badge-gray">Unused (Standalone)</span>`;
    }

    // Attach inspect action buttons
    document.getElementById('inspectBtnReplace').onclick = () => {
        cmsCloseModal('modalInspect');
        cmsOpenReplaceModal(relPath, url, name);
    };
    document.getElementById('inspectBtnRename').onclick = () => {
        cmsCloseModal('modalInspect');
        cmsOpenRenameModal(relPath, name);
    };
    document.getElementById('inspectBtnDelete').onclick = () => {
        cmsCloseModal('modalInspect');
        cmsOpenDeleteModal(relPath, name, url, inUse, usedPages);
    };

    cmsOpenModal('modalInspect');
}

// -----------------------------------------------------------------
// 2. REPLACE IMAGE
// -----------------------------------------------------------------
function cmsOpenReplaceModal(relPath, url, name) {
    document.getElementById('replaceTargetPath').value = relPath;
    document.getElementById('replaceTargetName').innerText = `${name} (${relPath})`;
    document.getElementById('replaceFileInput').value = '';
    document.getElementById('replaceNewPreviewWrap').style.display = 'none';
    cmsOpenModal('modalReplace');
}

function cmsPreviewReplacementFile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('replaceNewPreviewImg').src = e.target.result;
            document.getElementById('replaceNewPreviewWrap').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function cmsSubmitReplaceImage(e) {
    e.preventDefault();
    const input = document.getElementById('replaceFileInput');
    if (!input.files || !input.files[0]) {
        alert('Please choose a replacement file.');
        return;
    }

    const btn = document.getElementById('replaceSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Replacing...';

    const formData = new FormData();
    formData.append('path', document.getElementById('replaceTargetPath').value);
    formData.append('file', input.files[0]);
    formData.append('csrf_token', CSRF_TOKEN);

    fetch('api.php?action=replace_media', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Upload & Replace';
        if (res.success) {
            cmsToast(res.message || 'Image replaced successfully!');
            cmsCloseModal('modalReplace');
            setTimeout(() => location.reload(), 600);
        } else {
            alert('Replace Error: ' + (res.error || 'Unknown error'));
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Upload & Replace';
        alert('Network error while replacing image.');
    });
}

// -----------------------------------------------------------------
// 3. RENAME IMAGE
// -----------------------------------------------------------------
function cmsOpenRenameModal(relPath, currentName) {
    document.getElementById('renameOldPath').value = relPath;
    document.getElementById('renameCurrentName').innerText = currentName;

    const parts = currentName.split('.');
    const ext = parts.length > 1 ? parts.pop() : '';
    const base = parts.join('.');

    document.getElementById('renameNewNameInput').value = base;
    document.getElementById('renameExtBadge').innerText = '.' + ext;
    cmsOpenModal('modalRename');
    setTimeout(() => {
        document.getElementById('renameNewNameInput').focus();
        document.getElementById('renameNewNameInput').select();
    }, 100);
}

function cmsSubmitRenameImage(e) {
    e.preventDefault();
    const oldPath = document.getElementById('renameOldPath').value;
    const newName = document.getElementById('renameNewNameInput').value.trim();
    const updateRefs = document.getElementById('renameUpdateRefsCheckbox').checked ? '1' : '0';

    if (!newName) {
        alert('Please enter a new name.');
        return;
    }

    const btn = document.getElementById('renameSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Renaming...';

    const formData = new FormData();
    formData.append('old_path', oldPath);
    formData.append('new_name', newName);
    formData.append('update_references', updateRefs);
    formData.append('csrf_token', CSRF_TOKEN);

    fetch('api.php?action=rename_media', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Rename File';
        if (res.success) {
            cmsToast(res.message || 'Image renamed successfully!');
            cmsCloseModal('modalRename');
            setTimeout(() => location.reload(), 600);
        } else {
            alert('Rename Error: ' + (res.error || 'Unknown error'));
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Rename File';
        alert('Network error while renaming.');
    });
}

// -----------------------------------------------------------------
// 4. DELETE SINGLE IMAGE
// -----------------------------------------------------------------
function cmsOpenDeleteModal(relPath, name, url, inUse, usedPages) {
    activeDeletePath = relPath;
    document.getElementById('deleteFileName').innerText = name;
    document.getElementById('deletePreviewImg').src = url;

    const warningBox = document.getElementById('deleteInUseWarning');
    if (inUse) {
        document.getElementById('deleteUsedPagesList').innerText = usedPages || 'Unknown pages';
        warningBox.style.display = 'block';
    } else {
        warningBox.style.display = 'none';
    }

    cmsOpenModal('modalDelete');
}

function cmsConfirmSingleDelete() {
    if (!activeDeletePath) return;

    const btn = document.getElementById('deleteConfirmBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Deleting...';

    const formData = new FormData();
    formData.append('path', activeDeletePath);
    formData.append('csrf_token', CSRF_TOKEN);

    fetch('api.php?action=delete_media', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-regular fa-trash-can"></i> Yes, Delete Permanently';
        if (res.success) {
            cmsToast(res.message || 'Image deleted successfully!');
            cmsCloseModal('modalDelete');
            setTimeout(() => location.reload(), 500);
        } else {
            alert('Delete Error: ' + (res.error || 'Unknown error'));
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-regular fa-trash-can"></i> Yes, Delete Permanently';
        alert('Network error while deleting image.');
    });
}

// -----------------------------------------------------------------
// 5. BULK SELECTION & BULK DELETE
// -----------------------------------------------------------------
function cmsGetSelectedPaths() {
    const checkedBoxes = document.querySelectorAll('.media-select-box:checked');
    const paths = new Set();
    checkedBoxes.forEach(box => {
        if (box.value) paths.add(box.value);
    });
    return Array.from(paths);
}

function cmsUpdateBulkSelectionState() {
    const selected = cmsGetSelectedPaths();
    const count = selected.length;

    const bulkBtn = document.getElementById('btnBulkDelete');
    const countSpan = document.getElementById('bulkDeleteCount');
    const indicator = document.getElementById('selectedCountIndicator');

    if (count > 0) {
        bulkBtn.style.display = 'inline-flex';
        countSpan.innerText = count;
        indicator.innerText = `${count} selected`;
        indicator.style.color = 'var(--forest-green)';
        indicator.style.fontWeight = '700';
    } else {
        bulkBtn.style.display = 'none';
        countSpan.innerText = '0';
        indicator.innerText = '0 selected';
        indicator.style.color = 'var(--text-muted)';
        indicator.style.fontWeight = '500';
    }
}

function cmsDeselectAll() {
    document.querySelectorAll('.media-select-box').forEach(b => b.checked = false);
    document.getElementById('selectAllCheckbox').checked = false;
    cmsUpdateBulkSelectionState();
}

function cmsOpenBulkDeleteModal() {
    const selected = cmsGetSelectedPaths();
    if (selected.length === 0) {
        alert('No images selected.');
        return;
    }

    document.getElementById('bulkModalCount').innerText = selected.length;
    const warningList = document.getElementById('bulkWarningList');
    warningList.innerHTML = '';

    // Check if any selected items are in use
    selected.forEach(path => {
        const card = document.querySelector(`.media-card-item[data-rel-path="${CSS.escape(path)}"]`);
        const itemDiv = document.createElement('div');
        itemDiv.style.padding = '3px 0';
        itemDiv.style.borderBottom = '1px solid #e2e8f0';

        if (card && card.getAttribute('data-in-use') === '1') {
            const pages = card.getAttribute('data-used-pages');
            itemDiv.innerHTML = `⚠️ <strong style="color: #991b1b;">${path}</strong> <span style="color: #b91c1c;">(Used on: ${pages})</span>`;
        } else {
            itemDiv.innerHTML = `<span style="color: var(--text-dark);">${path}</span>`;
        }
        warningList.appendChild(itemDiv);
    });

    cmsOpenModal('modalBulkDelete');
}

function cmsConfirmBulkDelete() {
    const selected = cmsGetSelectedPaths();
    if (selected.length === 0) return;

    const btn = document.getElementById('bulkConfirmBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Deleting...';

    const formData = new FormData();
    formData.append('paths', JSON.stringify(selected));
    formData.append('csrf_token', CSRF_TOKEN);

    fetch('api.php?action=bulk_delete_media', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-regular fa-trash-can"></i> Delete Selected Images';
        if (res.success) {
            cmsToast(res.message || `Deleted ${res.deleted_count} image(s)!`);
            cmsCloseModal('modalBulkDelete');
            setTimeout(() => location.reload(), 600);
        } else {
            alert('Bulk Delete Error: ' + (res.error || 'Unknown error'));
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-regular fa-trash-can"></i> Delete Selected Images';
        alert('Network error during bulk delete.');
    });
}

// -----------------------------------------------------------------
// 6. CREATE NEW FOLDER
// -----------------------------------------------------------------
function cmsOpenCreateFolderModal() {
    document.getElementById('createFolderNameInput').value = '';
    cmsOpenModal('modalCreateFolder');
    setTimeout(() => document.getElementById('createFolderNameInput').focus(), 100);
}

function cmsSubmitCreateFolder(e) {
    e.preventDefault();
    const folderName = document.getElementById('createFolderNameInput').value.trim();
    if (!folderName) return;

    const btn = document.getElementById('createFolderSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating...';

    const formData = new FormData();
    formData.append('folder_name', folderName);
    formData.append('csrf_token', CSRF_TOKEN);

    fetch('api.php?action=create_media_folder', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-folder-plus"></i> Create Folder';
        if (res.success) {
            cmsToast(res.message || 'Folder created successfully!');
            cmsCloseModal('modalCreateFolder');
            setTimeout(() => location.reload(), 600);
        } else {
            alert('Error: ' + (res.error || 'Could not create folder'));
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-folder-plus"></i> Create Folder';
        alert('Network error creating folder.');
    });
}

// -----------------------------------------------------------------
// 7. MULTI-FILE UPLOAD ENGINE
// -----------------------------------------------------------------
function cmsUploadMultipleFiles(input) {
    if (!input.files || input.files.length === 0) return;
    const files = Array.from(input.files);
    const targetFolder = document.getElementById('mediaUploadFolderSelect').value;
    const autoConvert = document.getElementById('mediaAutoWebPCheckbox').checked ? '1' : '0';

    const progressArea = document.getElementById('mediaUploadProgressArea');
    const progressBar = document.getElementById('uploadProgressBar');
    const statusText = document.getElementById('uploadStatusText');
    const percentText = document.getElementById('uploadPercentText');

    progressArea.style.display = 'block';
    let completed = 0;

    function uploadNext(index) {
        if (index >= files.length) {
            statusText.innerText = `All ${files.length} file(s) uploaded successfully!`;
            percentText.innerText = '100%';
            progressBar.style.width = '100%';
            cmsToast(`Uploaded ${files.length} file(s) successfully!`);
            setTimeout(() => location.reload(), 800);
            return;
        }

        const file = files[index];
        const pct = Math.round((index / files.length) * 100);
        progressBar.style.width = pct + '%';
        percentText.innerText = pct + '%';
        statusText.innerText = `Uploading ${index + 1} of ${files.length}: ${file.name}...`;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('folder', targetFolder);
        formData.append('convert_webp', autoConvert);
        formData.append('csrf_token', CSRF_TOKEN);

        fetch('api.php?action=upload_media', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(res => {
            completed++;
            uploadNext(index + 1);
        })
        .catch(() => {
            uploadNext(index + 1);
        });
    }

    uploadNext(0);
}

// -----------------------------------------------------------------
// 8. FILTERS, SEARCH, SORT, AND VIEW SWITCHER
// -----------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    // Drop Zone Setup
    const dropZone = document.getElementById('mediaDropZone');
    dropZone.addEventListener('click', () => {
        document.getElementById('mediaUploadFileInput').click();
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--leaf-green)';
            dropZone.style.backgroundColor = 'var(--green-100)';
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--forest-green)';
            dropZone.style.backgroundColor = 'var(--green-50)';
        });
    });

    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length > 0) {
            const input = document.getElementById('mediaUploadFileInput');
            input.files = dt.files;
            cmsUploadMultipleFiles(input);
        }
    });

    // View Switching (Grid vs Table)
    const btnViewGrid = document.getElementById('btnViewGrid');
    const btnViewTable = document.getElementById('btnViewTable');
    const gridContainer = document.getElementById('mediaGridContainer');
    const tableContainer = document.getElementById('mediaTableContainer');

    btnViewGrid.addEventListener('click', () => {
        currentView = 'grid';
        gridContainer.style.display = 'grid';
        tableContainer.style.display = 'none';
        btnViewGrid.style.background = 'var(--green-100)';
        btnViewGrid.style.color = 'var(--forest-green)';
        btnViewTable.style.background = 'var(--white)';
        btnViewTable.style.color = 'var(--text-dark)';
    });

    btnViewTable.addEventListener('click', () => {
        currentView = 'table';
        gridContainer.style.display = 'none';
        tableContainer.style.display = 'block';
        btnViewTable.style.background = 'var(--green-100)';
        btnViewTable.style.color = 'var(--forest-green)';
        btnViewGrid.style.background = 'var(--white)';
        btnViewGrid.style.color = 'var(--text-dark)';
    });

    // Select All Checkbox
    const selectAllBox = document.getElementById('selectAllCheckbox');
    selectAllBox.addEventListener('change', (e) => {
        const checked = e.target.checked;
        const selector = (currentView === 'grid')
            ? '.media-card-item:not([style*="display: none"]) .media-select-box'
            : '.media-table-row:not([style*="display: none"]) .media-select-box';
        document.querySelectorAll(selector).forEach(box => {
            box.checked = checked;
        });
        cmsUpdateBulkSelectionState();
    });

    // Filtering & Sorting function
    function applyFiltersAndSort() {
        const cards = Array.from(document.querySelectorAll('.media-card-item'));
        const rows = Array.from(document.querySelectorAll('.media-table-row'));
        let visibleCount = 0;

        function matches(el) {
            const folder = el.getAttribute('data-folder');
            const name = el.getAttribute('data-name');
            const inUse = el.getAttribute('data-in-use') === '1';

            const matchesFolder = (activeFolder === 'all') || (folder === activeFolder);
            const matchesStatus = (activeStatus === 'all')
                || (activeStatus === 'in_use' && inUse)
                || (activeStatus === 'unused' && !inUse);
            const matchesSearch = (searchQuery === '') || (name.includes(searchQuery));

            return matchesFolder && matchesStatus && matchesSearch;
        }

        cards.forEach(card => {
            const ok = matches(card);
            card.style.display = ok ? 'flex' : 'none';
            if (ok) visibleCount++;
        });

        rows.forEach(row => {
            const ok = matches(row);
            row.style.display = ok ? '' : 'none';
        });

        document.getElementById('visibleItemsCount').innerText = visibleCount;

        // Sorting
        function sortElements(list, container) {
            list.sort((a, b) => {
                if (currentSort === 'newest') {
                    return parseInt(b.getAttribute('data-time'), 10) - parseInt(a.getAttribute('data-time'), 10);
                } else if (currentSort === 'oldest') {
                    return parseInt(a.getAttribute('data-time'), 10) - parseInt(b.getAttribute('data-time'), 10);
                } else if (currentSort === 'name_asc') {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                } else if (currentSort === 'name_desc') {
                    return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                } else if (currentSort === 'size_desc') {
                    return parseInt(b.getAttribute('data-size-bytes'), 10) - parseInt(a.getAttribute('data-size-bytes'), 10);
                } else if (currentSort === 'size_asc') {
                    return parseInt(a.getAttribute('data-size-bytes'), 10) - parseInt(b.getAttribute('data-size-bytes'), 10);
                }
                return 0;
            });
            list.forEach(el => container.appendChild(el));
        }

        sortElements(cards, gridContainer);
        sortElements(rows, document.getElementById('mediaTableBody'));

        cmsUpdateBulkSelectionState();
    }

    // Folder Filter Buttons
    document.querySelectorAll('.media-folder-filter').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.media-folder-filter').forEach(b => {
                b.style.background = 'var(--white)';
                b.style.color = 'var(--text-dark)';
                b.style.borderColor = 'var(--border-subtle)';
                b.style.fontWeight = '500';
            });
            btn.style.background = 'var(--green-100)';
            btn.style.color = 'var(--forest-green)';
            btn.style.borderColor = 'var(--forest-green)';
            btn.style.fontWeight = '700';
            activeFolder = btn.getAttribute('data-folder');
            applyFiltersAndSort();
        });
    });

    // Search Input
    document.getElementById('mediaSearchInput').addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase().trim();
        applyFiltersAndSort();
    });

    // Status Filter Select
    document.getElementById('mediaStatusFilter').addEventListener('change', (e) => {
        activeStatus = e.target.value;
        applyFiltersAndSort();
    });

    // Sort Select
    document.getElementById('mediaSortSelect').addEventListener('change', (e) => {
        currentSort = e.target.value;
        applyFiltersAndSort();
    });

});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
