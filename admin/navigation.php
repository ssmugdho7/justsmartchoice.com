<?php
$pageTitle = 'Header & Footer Navigation';
$breadcrumb = 'Navigation Settings';
require_once __DIR__ . '/header.php';

$globalData = CMS::loadPage('global');
$topBanner = $globalData['top_banner'] ?? [];
$branding = $globalData['branding'] ?? [];
$contact = $globalData['contact'] ?? [];
$navItems = $globalData['navigation'] ?? [];
$licenses = $globalData['licenses'] ?? [];
$reviews = $globalData['review_links'] ?? [];
$socials = $globalData['social_links'] ?? [];
$csrfToken = AdminAuth::csrfToken();
?>

<div class="cms-content">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark);">Header & Footer Navigation Builder</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                Manage logos, top promotional banners, navigation menus, contact strips, license credentials, and review badges.
            </p>
        </div>
        <div>
            <button type="button" id="saveNavBtn" class="cms-btn cms-btn-primary">
                <i class="fa-solid fa-check"></i> Save Navigation Changes
            </button>
        </div>
    </div>

    <!-- 1. Top Promo Banner -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-bullhorn" style="color: var(--forest-green);"></i>
                <span>Top Promotional Banner</span>
            </div>
            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                <input type="checkbox" id="bannerEnabled" <?php echo !empty($topBanner['enabled']) ? 'checked' : ''; ?>>
                <span>Banner Visible</span>
            </label>
        </div>
        <div class="cms-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                <div class="cms-form-group">
                    <label class="cms-label">Target Link URL</label>
                    <input type="text" id="bannerUrl" class="cms-input" value="<?php echo htmlspecialchars($topBanner['url'] ?? '/promo_flooring.php'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Foreground Image URL</label>
                    <input type="text" id="bannerFg" class="cms-input" value="<?php echo htmlspecialchars($topBanner['fg_image'] ?? '/images/banner/banner-fg-04-1600x60.png'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Background Pattern Image URL</label>
                    <input type="text" id="bannerBg" class="cms-input" value="<?php echo htmlspecialchars($topBanner['bg_image'] ?? '/images/banner/banner-bg-04-1920x60.jpg'); ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Logos & Contact Information -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-phone" style="color: var(--forest-green);"></i>
                <span>Header Contacts & Logos</span>
            </div>
        </div>
        <div class="cms-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                <div class="cms-form-group">
                    <label class="cms-label">Desktop Logo URL</label>
                    <input type="text" id="logoDesktop" class="cms-input" value="<?php echo htmlspecialchars($branding['logos']['desktop']['url'] ?? '/images/logo-638x310.png'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Mobile Logo URL</label>
                    <input type="text" id="logoMobile" class="cms-input" value="<?php echo htmlspecialchars($branding['logos']['mobile']['url'] ?? '/images/logo-364x52.png'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Primary Phone (Display)</label>
                    <input type="text" id="contactPhone" class="cms-input" value="<?php echo htmlspecialchars($contact['phone'] ?? '(727) 755-3786'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Primary Phone (Raw Tel: link)</label>
                    <input type="text" id="contactPhoneRaw" class="cms-input" value="<?php echo htmlspecialchars($contact['phone_raw'] ?? '+17277553786'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Weekday Working Hours</label>
                    <input type="text" id="hoursWeekdays" class="cms-input" value="<?php echo htmlspecialchars($contact['hours_weekdays'] ?? 'Monday–Friday: 8:00 AM–4:00 PM'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Saturday Working Hours</label>
                    <input type="text" id="hoursSaturday" class="cms-input" value="<?php echo htmlspecialchars($contact['hours_saturday'] ?? 'Saturday: 8:00 AM–3:00 PM'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Appointment CTA Button Label</label>
                    <input type="text" id="apptBtnLabel" class="cms-input" value="<?php echo htmlspecialchars($contact['appointment_btn_label'] ?? 'Appointment'); ?>">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Appointment CTA Button URL</label>
                    <input type="text" id="apptBtnUrl" class="cms-input" value="<?php echo htmlspecialchars($contact['appointment_btn_url'] ?? 'https://crm.justsmartchoice.com/appointly/appointments'); ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Main Navigation Menu Builder -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-list-check" style="color: var(--forest-green);"></i>
                <span>Main Navigation Menu Items</span>
            </div>
            <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="cmsAddNavItem()">
                <i class="fa-solid fa-plus"></i> Add Nav Link
            </button>
        </div>
        <div class="cms-card-body" id="navItemsContainer">
            <?php foreach ($navItems as $nIdx => $item): ?>
                <div class="nav-item-row" style="display: flex; gap: 12px; align-items: center; margin-bottom: 10px; background: #fafbfc; border: 1px solid var(--border-subtle); padding: 10px 14px; border-radius: var(--radius-sm);">
                    <div style="cursor: grab; color: var(--text-muted);"><i class="fa-solid fa-grip-vertical"></i></div>
                    <div style="flex: 1;">
                        <input type="text" class="cms-input nav-label" placeholder="Link Label (e.g. Home)" value="<?php echo htmlspecialchars($item['label'] ?? ''); ?>">
                    </div>
                    <div style="flex: 1.5;">
                        <input type="text" class="cms-input nav-href" placeholder="URL Target (e.g. /index.php)" value="<?php echo htmlspecialchars($item['href'] ?? ''); ?>">
                    </div>
                    <div>
                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="this.closest('.nav-item-row').remove()" style="color: #991b1b; border-color: #fecaca;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 4. Florida State License Credentials -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-award" style="color: var(--forest-green);"></i>
                <span>Florida Contractor License Numbers</span>
            </div>
        </div>
        <div class="cms-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px;">
                <?php foreach ($licenses as $lIdx => $lic): ?>
                    <div style="background: #fafbfc; padding: 12px; border-radius: 6px; border: 1px solid var(--border-subtle);">
                        <label class="cms-label"><?php echo htmlspecialchars($lic['title']); ?></label>
                        <input type="text" class="cms-input license-code-input" data-title="<?php echo htmlspecialchars($lic['title']); ?>" value="<?php echo htmlspecialchars($lic['code']); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<script>
function cmsAddNavItem() {
    const container = document.getElementById('navItemsContainer');
    const div = document.createElement('div');
    div.className = 'nav-item-row';
    div.style = 'display: flex; gap: 12px; align-items: center; margin-bottom: 10px; background: #fafbfc; border: 1px solid var(--border-subtle); padding: 10px 14px; border-radius: var(--radius-sm);';
    div.innerHTML = `
        <div style="cursor: grab; color: var(--text-muted);"><i class="fa-solid fa-grip-vertical"></i></div>
        <div style="flex: 1;"><input type="text" class="cms-input nav-label" placeholder="Link Label" value="New Page"></div>
        <div style="flex: 1.5;"><input type="text" class="cms-input nav-href" placeholder="URL Target" value="/new-page.php"></div>
        <div><button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="this.closest('.nav-item-row').remove()" style="color: #991b1b; border-color: #fecaca;"><i class="fa-solid fa-trash"></i></button></div>
    `;
    container.appendChild(div);
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('saveNavBtn').addEventListener('click', () => {
        const btn = document.getElementById('saveNavBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        // Collect nav items
        const navigation = [];
        document.querySelectorAll('.nav-item-row').forEach(row => {
            const label = row.querySelector('.nav-label').value.trim();
            const href = row.querySelector('.nav-href').value.trim();
            if (label && href) {
                navigation.push({ label, href, target: '_self' });
            }
        });

        // Collect licenses
        const licenses = [];
        document.querySelectorAll('.license-code-input').forEach(input => {
            licenses.push({
                code: input.value.trim(),
                title: input.getAttribute('data-title')
            });
        });

        const payload = {
            top_banner: {
                enabled: document.getElementById('bannerEnabled').checked,
                url: document.getElementById('bannerUrl').value.trim(),
                fg_image: document.getElementById('bannerFg').value.trim(),
                bg_image: document.getElementById('bannerBg').value.trim()
            },
            contact: {
                phone: document.getElementById('contactPhone').value.trim(),
                phone_raw: document.getElementById('contactPhoneRaw').value.trim(),
                hours_weekdays: document.getElementById('hoursWeekdays').value.trim(),
                hours_saturday: document.getElementById('hoursSaturday').value.trim(),
                appointment_btn_label: document.getElementById('apptBtnLabel').value.trim(),
                appointment_btn_url: document.getElementById('apptBtnUrl').value.trim()
            },
            branding: {
                logos: {
                    desktop: { url: document.getElementById('logoDesktop').value.trim() },
                    mobile: { url: document.getElementById('logoMobile').value.trim() }
                }
            },
            navigation: navigation,
            licenses: licenses
        };

        fetch('api.php?action=save_navigation', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                csrf_token: '<?php echo htmlspecialchars($csrfToken); ?>',
                data: JSON.stringify(payload)
            })
        })
        .then(r => r.json())
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Save Navigation Changes';
            if (res.success) {
                cmsToast('Header & navigation updated successfully!');
            } else {
                alert('Error saving navigation: ' + (res.error || 'Unknown error'));
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
