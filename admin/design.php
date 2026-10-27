<?php
$pageTitle = 'Theme & Design Customizer';
$breadcrumb = 'Design Customizer';
require_once __DIR__ . '/header.php';

$globalData = CMS::loadPage('global');
$theme = $globalData['theme'] ?? [];
$csrfToken = AdminAuth::csrfToken();
?>

<div class="cms-content">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark);">Theme & Design Customizer</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                Customize the global green brand palette, fonts, button styling, and inject custom CSS rules.
            </p>
        </div>
        <div>
            <button type="button" id="saveDesignBtn" class="cms-btn cms-btn-primary">
                <i class="fa-solid fa-check"></i> Save Theme Changes
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">

        <!-- 1. Color Palette -->
        <div class="cms-card">
            <div class="cms-card-header">
                <div class="cms-card-title">
                    <i class="fa-solid fa-palette" style="color: var(--forest-green);"></i>
                    <span>Brand Color Palette</span>
                </div>
            </div>
            <div class="cms-card-body">
                <div class="cms-form-group">
                    <label class="cms-label">Primary Brand Color (Buttons & Highlights)</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="color" id="primaryColorPicker" value="<?php echo htmlspecialchars($theme['primary_color'] ?? '#198754'); ?>" style="width: 44px; height: 38px; border-radius: 6px; border: 1px solid var(--border-subtle); cursor: pointer;">
                        <input type="text" id="primaryColorText" class="cms-input" value="<?php echo htmlspecialchars($theme['primary_color'] ?? '#198754'); ?>" style="font-family: monospace;">
                    </div>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">Secondary Brand Color (Dark Green / Accents)</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="color" id="secondaryColorPicker" value="<?php echo htmlspecialchars($theme['secondary_color'] ?? '#0f766e'); ?>" style="width: 44px; height: 38px; border-radius: 6px; border: 1px solid var(--border-subtle); cursor: pointer;">
                        <input type="text" id="secondaryColorText" class="cms-input" value="<?php echo htmlspecialchars($theme['secondary_color'] ?? '#0f766e'); ?>" style="font-family: monospace;">
                    </div>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">Active / Vibrant Green Accent</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="color" id="accentColorPicker" value="<?php echo htmlspecialchars($theme['accent_color'] ?? '#16a34a'); ?>" style="width: 44px; height: 38px; border-radius: 6px; border: 1px solid var(--border-subtle); cursor: pointer;">
                        <input type="text" id="accentColorText" class="cms-input" value="<?php echo htmlspecialchars($theme['accent_color'] ?? '#16a34a'); ?>" style="font-family: monospace;">
                    </div>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">Dark Neutral Text Color</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="color" id="darkColorPicker" value="<?php echo htmlspecialchars($theme['dark_color'] ?? '#1e293b'); ?>" style="width: 44px; height: 38px; border-radius: 6px; border: 1px solid var(--border-subtle); cursor: pointer;">
                        <input type="text" id="darkColorText" class="cms-input" value="<?php echo htmlspecialchars($theme['dark_color'] ?? '#1e293b'); ?>" style="font-family: monospace;">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Typography & Buttons -->
        <div class="cms-card">
            <div class="cms-card-header">
                <div class="cms-card-title">
                    <i class="fa-solid fa-font" style="color: var(--forest-green);"></i>
                    <span>Typography & Buttons</span>
                </div>
            </div>
            <div class="cms-card-body">
                <div class="cms-form-group">
                    <label class="cms-label">Heading Font Family</label>
                    <select id="headingFontSelect" class="cms-select">
                        <?php 
                        $fonts = ['Raleway, sans-serif', 'Inter, sans-serif', 'Roboto, sans-serif', 'Open Sans, sans-serif', 'Montserrat, sans-serif', 'Poppins, sans-serif'];
                        $currentHFont = $theme['heading_font'] ?? 'Raleway, sans-serif';
                        foreach ($fonts as $f): 
                        ?>
                            <option value="<?php echo htmlspecialchars($f); ?>" <?php echo ($currentHFont === $f) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars(explode(',', $f)[0]); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">Body Font Family</label>
                    <select id="bodyFontSelect" class="cms-select">
                        <?php 
                        $currentBFont = $theme['body_font'] ?? 'Raleway, sans-serif';
                        foreach ($fonts as $f): 
                        ?>
                            <option value="<?php echo htmlspecialchars($f); ?>" <?php echo ($currentBFont === $f) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars(explode(',', $f)[0]); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">Button Corner Radius</label>
                    <select id="btnRadiusSelect" class="cms-select">
                        <?php 
                        $radii = ['0px' => 'Square (0px)', '4px' => 'Subtle (4px)', '8px' => 'Rounded (8px)', '25px' => 'Pill (25px)'];
                        $currentRad = $theme['btn_radius'] ?? '4px';
                        foreach ($radii as $val => $lbl): 
                        ?>
                            <option value="<?php echo htmlspecialchars($val); ?>" <?php echo ($currentRad === $val) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lbl); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. Custom CSS Injector -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-code" style="color: var(--forest-green);"></i>
                <span>Custom CSS Code Overrides</span>
            </div>
            <span style="font-size: 11.5px; color: var(--text-muted);">Injected live across the site without editing core CSS files</span>
        </div>
        <div class="cms-card-body">
            <textarea id="customCssEditor" class="cms-textarea" style="min-height: 200px; font-family: monospace; font-size: 13px; line-height: 1.4; background-color: #0f172a; color: #38bdf8; border: 1px solid #334155;" placeholder="/* Enter custom CSS rules here */&#10;.sc-hero { ... }"><?php echo htmlspecialchars($theme['custom_css'] ?? ''); ?></textarea>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Sync color pickers with text inputs
    function setupColorSync(pickerId, textId) {
        const picker = document.getElementById(pickerId);
        const text = document.getElementById(textId);
        picker.addEventListener('input', () => text.value = picker.value);
        text.addEventListener('input', () => picker.value = text.value);
    }
    setupColorSync('primaryColorPicker', 'primaryColorText');
    setupColorSync('secondaryColorPicker', 'secondaryColorText');
    setupColorSync('accentColorPicker', 'accentColorText');
    setupColorSync('darkColorPicker', 'darkColorText');

    // Save button
    document.getElementById('saveDesignBtn').addEventListener('click', () => {
        const btn = document.getElementById('saveDesignBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const themeData = {
            primary_color: document.getElementById('primaryColorText').value,
            secondary_color: document.getElementById('secondaryColorText').value,
            accent_color: document.getElementById('accentColorText').value,
            dark_color: document.getElementById('darkColorText').value,
            heading_font: document.getElementById('headingFontSelect').value,
            body_font: document.getElementById('bodyFontSelect').value,
            btn_radius: document.getElementById('btnRadiusSelect').value,
            custom_css: document.getElementById('customCssEditor').value
        };

        fetch('api.php?action=save_design', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                csrf_token: '<?php echo htmlspecialchars($csrfToken); ?>',
                theme: JSON.stringify(themeData)
            })
        })
        .then(r => r.json())
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Save Theme Changes';
            if (res.success) {
                cmsToast('Theme styling saved successfully!');
            } else {
                alert('Error saving theme: ' + (res.error || 'Unknown error'));
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
