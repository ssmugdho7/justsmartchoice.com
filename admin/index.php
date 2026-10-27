<?php
$pageTitle = 'Dashboard';
$breadcrumb = 'Dashboard Overview';
require_once __DIR__ . '/header.php';

$pages = CMS::getPageList();

// Count categories
$categories = [];
foreach ($pages as $p) {
    $cat = $p['category'] ?? 'General';
    $categories[$cat] = ($categories[$cat] ?? 0) + 1;
}

// Count images
$imageDir = dirname(__DIR__) . '/images';
$imageCount = 0;
if (is_dir($imageDir)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($imageDir));
    foreach ($iterator as $file) {
        if ($file->isFile() && in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'])) {
            $imageCount++;
        }
    }
}
?>

<div class="cms-content">

    <!-- Top Greeting Banner -->
    <div style="background: linear-gradient(135deg, var(--forest-green), var(--leaf-green)); color: var(--white); border-radius: var(--radius-lg); padding: 28px; margin-bottom: 24px; box-shadow: var(--shadow-green); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; opacity: 0.85;">Welcome Back</span>
            <h2 style="font-size: 22px; font-weight: 800; margin-top: 4px;">Smart Choice Construction CMS</h2>
            <p style="font-size: 13.5px; opacity: 0.9; margin-top: 4px; max-width: 600px;">
                Manage and customize every page, element, image, and style across the entire website with instant real-time live preview.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="pages.php?page=home" class="cms-btn" style="background: var(--white); color: var(--forest-green); font-weight: 700;">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Live Preview Editor
            </a>
            <a href="media.php" class="cms-btn" style="background: rgba(255,255,255,0.2); color: var(--white); border: 1px solid rgba(255,255,255,0.4);">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload Media
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="cms-stats-grid">
        <div class="cms-stat-box">
            <div class="cms-stat-icon">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div>
                <div class="cms-stat-number"><?php echo count($pages); ?></div>
                <div class="cms-stat-label">Tracked Website Pages</div>
            </div>
        </div>

        <div class="cms-stat-box">
            <div class="cms-stat-icon" style="background-color: #f0fdf4; color: #16a34a;">
                <i class="fa-regular fa-images"></i>
            </div>
            <div>
                <div class="cms-stat-number"><?php echo $imageCount; ?></div>
                <div class="cms-stat-label">Media & Image Assets</div>
            </div>
        </div>

        <div class="cms-stat-box">
            <div class="cms-stat-icon" style="background-color: #eff6ff; color: #2563eb;">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
            <div>
                <div class="cms-stat-number"><?php echo $categories['Specialty Services'] ?? 9; ?></div>
                <div class="cms-stat-label">Specialty Services</div>
            </div>
        </div>

        <div class="cms-stat-box">
            <div class="cms-stat-icon" style="background-color: #fefce8; color: #ca8a04;">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <div>
                <div class="cms-stat-number"><?php echo $categories['Calculators & Tools'] ?? 8; ?></div>
                <div class="cms-stat-label">Calculators & Tools</div>
            </div>
        </div>
    </div>

    <!-- Quick Action Launchpad -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-bolt" style="color: var(--forest-green);"></i>
                <span>Quick Actions Launchpad</span>
            </div>
        </div>
        <div class="cms-card-body" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;">
            <a href="pages.php?page=home" style="display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--white); text-decoration: none; color: var(--text-dark); transition: all 0.15s ease;" onmouseover="this.style.borderColor='var(--forest-green)'; this.style.backgroundColor='var(--green-50)'" onmouseout="this.style.borderColor='var(--border-subtle)'; this.style.backgroundColor='var(--white)'">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: var(--green-100); color: var(--forest-green); display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-house"></i>
                </div>
                <div>
                    <strong style="display: block; font-size: 13.5px;">Edit Homepage</strong>
                    <span style="font-size: 11.5px; color: var(--text-muted);">Sliders, Cards, Banners</span>
                </div>
            </a>

            <a href="navigation.php" style="display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--white); text-decoration: none; color: var(--text-dark); transition: all 0.15s ease;" onmouseover="this.style.borderColor='var(--forest-green)'; this.style.backgroundColor='var(--green-50)'" onmouseout="this.style.borderColor='var(--border-subtle)'; this.style.backgroundColor='var(--white)'">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: var(--green-100); color: var(--forest-green); display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div>
                    <strong style="display: block; font-size: 13.5px;">Header & Navigation</strong>
                    <span style="font-size: 11.5px; color: var(--text-muted);">Logos, Menus, Top Banner</span>
                </div>
            </a>

            <a href="design.php" style="display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--white); text-decoration: none; color: var(--text-dark); transition: all 0.15s ease;" onmouseover="this.style.borderColor='var(--forest-green)'; this.style.backgroundColor='var(--green-50)'" onmouseout="this.style.borderColor='var(--border-subtle)'; this.style.backgroundColor='var(--white)'">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: var(--green-100); color: var(--forest-green); display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <div>
                    <strong style="display: block; font-size: 13.5px;">Theme & Colors</strong>
                    <span style="font-size: 11.5px; color: var(--text-muted);">Green Palette, Fonts, CSS</span>
                </div>
            </a>

            <a href="media.php" style="display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--white); text-decoration: none; color: var(--text-dark); transition: all 0.15s ease;" onmouseover="this.style.borderColor='var(--forest-green)'; this.style.backgroundColor='var(--green-50)'" onmouseout="this.style.borderColor='var(--border-subtle)'; this.style.backgroundColor='var(--white)'">
                <div style="width: 36px; height: 36px; border-radius: 6px; background: var(--green-100); color: var(--forest-green); display: flex; align-items: center; justify-content: center;">
                    <i class="fa-regular fa-images"></i>
                </div>
                <div>
                    <strong style="display: block; font-size: 13.5px;">Media Library</strong>
                    <span style="font-size: 11.5px; color: var(--text-muted);">Browse & Upload Images</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Complete Page Directory -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-regular fa-folder-open" style="color: var(--forest-green);"></i>
                <span>Complete Page Directory (53 Pages)</span>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <div style="position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 10px; color: var(--text-muted); font-size: 12px;"></i>
                    <input 
                        type="text" 
                        id="pageSearch" 
                        class="cms-input" 
                        placeholder="Search page..." 
                        style="padding-left: 30px; font-size: 12.5px; width: 220px; height: 34px;"
                    >
                </div>
            </div>
        </div>

        <div class="cms-card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                    <thead>
                        <tr style="background-color: #fafbfc; border-bottom: 1px solid var(--border-subtle); color: var(--text-muted); font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th style="padding: 12px 20px;">Page Name & Title</th>
                            <th style="padding: 12px 16px;">Category</th>
                            <th style="padding: 12px 16px;">Route / File</th>
                            <th style="padding: 12px 20px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pageTableBody">
                        <?php foreach ($pages as $p): ?>
                            <?php 
                                $slug = $p['slug'];
                                $category = $p['category'];
                                $badgeClass = 'cms-badge-gray';
                                if ($category === 'Primary Pages') $badgeClass = 'cms-badge-green';
                                if ($category === 'Specialty Services') $badgeClass = 'cms-badge-green';
                                if ($category === 'Calculators & Tools') $badgeClass = 'cms-badge-amber';
                            ?>
                            <tr class="page-row" data-search="<?php echo htmlspecialchars(strtolower($p['title'] . ' ' . $p['file'] . ' ' . $category)); ?>" style="border-bottom: 1px solid var(--border-subtle); transition: background-color 0.15s ease;">
                                <td style="padding: 12px 20px;">
                                    <div style="font-weight: 600; color: var(--text-dark);">
                                        <?php echo htmlspecialchars($p['title']); ?>
                                    </div>
                                    <span style="font-size: 11.5px; color: var(--text-muted);">
                                        <?php echo htmlspecialchars($p['file']); ?>
                                    </span>
                                </td>
                                <td style="padding: 12px 16px;">
                                    <span class="cms-badge <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($category); ?>
                                    </span>
                                </td>
                                <td style="padding: 12px 16px; font-family: monospace; font-size: 12px; color: var(--text-muted);">
                                    <?php echo htmlspecialchars($p['route']); ?>
                                </td>
                                <td style="padding: 12px 20px; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <a href="<?php echo htmlspecialchars($p['route']); ?>" target="_blank" class="cms-btn cms-btn-outline cms-btn-sm" title="View live page">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <a href="pages.php?page=<?php echo urlencode($slug); ?>" class="cms-btn cms-btn-primary cms-btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Live Edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('pageSearch');
    const rows = document.querySelectorAll('.page-row');

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        rows.forEach(row => {
            const text = row.getAttribute('data-search') || '';
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
