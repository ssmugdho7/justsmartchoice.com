<?php
$pageTitle = 'Backup & Snapshots';
$breadcrumb = 'System Backup';
require_once __DIR__ . '/header.php';

$backupDir = CMS_DATA_DIR . '/backups';
if (!is_dir($backupDir)) {
    @mkdir($backupDir, 0755, true);
}

$message = '';
$error = '';

// Handle Create Backup
if (isset($_POST['action']) && $_POST['action'] === 'create_backup') {
    if (!AdminAuth::verifyCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Session security token expired.';
    } else {
        $zipName = 'smartchoice_cms_backup_' . date('Y-m-d_His') . '.zip';
        $zipPath = $backupDir . '/' . $zipName;

        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator(CMS_DATA_DIR),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        // Exclude backup directory itself from recursive zipping
                        if (strpos($filePath, $backupDir) === 0) continue;
                        $relativePath = substr($filePath, strlen(CMS_DATA_DIR) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();
                $message = 'Backup successfully created: ' . $zipName;
            } else {
                $error = 'Could not create ZIP archive.';
            }
        } else {
            $error = 'PHP ZipArchive extension is not enabled on this server.';
        }
    }
}

// Handle Download
if (isset($_GET['download'])) {
    $dlName = basename($_GET['download']);
    $dlPath = $backupDir . '/' . $dlName;
    if (file_exists($dlPath)) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $dlName . '"');
        header('Content-Length: ' . filesize($dlPath));
        readfile($dlPath);
        exit;
    }
}

// Scan backups
$backupFiles = [];
if (is_dir($backupDir)) {
    foreach (scandir($backupDir) as $f) {
        if (substr($f, -4) === '.zip') {
            $backupFiles[] = [
                'name' => $f,
                'path' => $backupDir . '/' . $f,
                'size_kb' => round(filesize($backupDir . '/' . $f) / 1024, 1),
                'time' => filemtime($backupDir . '/' . $f)
            ];
        }
    }
}
usort($backupFiles, fn($a, $b) => $b['time'] <=> $a['time']);
$csrfToken = AdminAuth::csrfToken();
?>

<div class="cms-content">

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark);">System Backups & Snapshots</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                Create one-click downloadable archives of all website content, media assignments, and configuration.
            </p>
        </div>
        <form method="POST">
            <input type="hidden" name="action" value="create_backup">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <button type="submit" class="cms-btn cms-btn-primary">
                <i class="fa-solid fa-cloud-arrow-down"></i> Create Snapshot Now
            </button>
        </form>
    </div>

    <?php if (!empty($message)): ?>
        <div class="cms-alert cms-alert-success">
            <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="cms-alert cms-alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-box-archive" style="color: var(--forest-green);"></i>
                <span>Available Snapshots (<?php echo count($backupFiles); ?>)</span>
            </div>
        </div>
        <div class="cms-card-body" style="padding: 0;">
            <?php if (empty($backupFiles)): ?>
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fa-solid fa-cloud" style="font-size: 36px; margin-bottom: 12px; opacity: 0.5;"></i>
                    <p style="font-size: 14px; font-weight: 600;">No backups created yet.</p>
                    <span style="font-size: 12px;">Click "Create Snapshot Now" above to generate your first complete backup.</span>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                        <thead>
                            <tr style="background-color: #fafbfc; border-bottom: 1px solid var(--border-subtle); color: var(--text-muted); font-size: 11.5px; text-transform: uppercase;">
                                <th style="padding: 12px 20px;">Snapshot File</th>
                                <th style="padding: 12px 16px;">Created At</th>
                                <th style="padding: 12px 16px;">Size</th>
                                <th style="padding: 12px 20px; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backupFiles as $bf): ?>
                                <tr style="border-bottom: 1px solid var(--border-subtle);">
                                    <td style="padding: 12px 20px; font-weight: 600; color: var(--text-dark);">
                                        <i class="fa-regular fa-file-zipper" style="color: var(--forest-green); margin-right: 8px;"></i>
                                        <?php echo htmlspecialchars($bf['name']); ?>
                                    </td>
                                    <td style="padding: 12px 16px; color: var(--text-muted); font-size: 12.5px;">
                                        <?php echo date('M d, Y h:i A', $bf['time']); ?>
                                    </td>
                                    <td style="padding: 12px 16px; color: var(--text-muted); font-size: 12.5px;">
                                        <?php echo $bf['size_kb']; ?> KB
                                    </td>
                                    <td style="padding: 12px 20px; text-align: right;">
                                        <a href="backup.php?download=<?php echo urlencode($bf['name']); ?>" class="cms-btn cms-btn-outline cms-btn-sm" style="color: var(--forest-green); border-color: var(--forest-green);">
                                            <i class="fa-solid fa-download"></i> Download ZIP
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
