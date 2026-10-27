<?php
$pageSlug = strtolower(preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['page'] ?? 'home'));
if ($pageSlug === '') $pageSlug = 'home';

$pageTitle = 'Live Page Editor: ' . ucfirst($pageSlug);
$breadcrumb = 'Page Editor / ' . ucfirst($pageSlug);
require_once __DIR__ . '/header.php';

$pagesList = CMS::getPageList();
$pageData = CMS::loadPage($pageSlug);
$csrfToken = AdminAuth::csrfToken();

/**
 * Helper to render an interactive 1-click image upload control with visual thumbnail preview
 */
function renderCmsImageControl($field, $label, $currentValue, $default = '') {
    $val = !empty($currentValue) ? $currentValue : $default;
    $id = preg_replace('/[^a-zA-Z0-9_]/', '_', $field);
    $hasImg = !empty($val);
    $isWebp = $hasImg && (substr(strtolower($val), -5) === '.webp');
    $basename = $hasImg ? basename($val) : 'No image selected';
    $displaySrc = $val;
    if ($displaySrc !== '' && !preg_match('#^(/|https?://)#', $displaySrc)) {
        $displaySrc = '/' . $displaySrc;
    }

    ob_start();
    ?>
    <div class="cms-form-group">
        <label class="cms-label"><?php echo htmlspecialchars($label); ?></label>
        <div class="cms-img-control-box" style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; display: flex; gap: 12px; align-items: center;">
            <div style="width: 76px; height: 56px; border-radius: 6px; overflow: hidden; background: #f1f5f9; border: 1px solid var(--border-subtle); flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                <img id="thumb_<?php echo $id; ?>" src="<?php echo htmlspecialchars($displaySrc); ?>" style="width: 100%; height: 100%; object-fit: cover; <?php echo $hasImg ? '' : 'display:none;'; ?>" alt="Preview">
                <i id="ph_<?php echo $id; ?>" class="fa-regular fa-image" style="font-size: 20px; color: #94a3b8; <?php echo $hasImg ? 'display:none;' : ''; ?>"></i>
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; gap: 6px; align-items: center; margin-bottom: 6px; flex-wrap: wrap;">
                    <input type="file" id="file_<?php echo $id; ?>" accept="image/*" style="display: none;" onchange="cmsDirectUpload(this, 'input_<?php echo $id; ?>', 'thumb_<?php echo $id; ?>', 'ph_<?php echo $id; ?>', 'badge_<?php echo $id; ?>', 'name_<?php echo $id; ?>')">
                    <button type="button" class="cms-btn cms-btn-primary cms-btn-sm" onclick="document.getElementById('file_<?php echo $id; ?>').click()" style="padding: 4px 10px; font-size: 11.5px;">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload New
                    </button>
                    <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="cmsOpenImagePicker('input_<?php echo $id; ?>', 'thumb_<?php echo $id; ?>', 'ph_<?php echo $id; ?>', 'badge_<?php echo $id; ?>', 'name_<?php echo $id; ?>')" style="padding: 4px 10px; font-size: 11.5px;">
                        <i class="fa-regular fa-images"></i> Media Library
                    </button>
                    <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="cmsClearImage('input_<?php echo $id; ?>', 'thumb_<?php echo $id; ?>', 'ph_<?php echo $id; ?>', 'badge_<?php echo $id; ?>', 'name_<?php echo $id; ?>')" style="padding: 4px 8px; font-size: 11.5px; color: #dc2626;" title="Remove image">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 11px; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <span id="badge_<?php echo $id; ?>" class="cms-badge cms-badge-green" style="font-size: 9.5px; padding: 1px 6px; <?php echo $isWebp ? '' : 'display:none;'; ?>">
                        <i class="fa-solid fa-bolt"></i> WebP
                    </span>
                    <span id="name_<?php echo $id; ?>" style="overflow: hidden; text-overflow: ellipsis; max-width: 220px;"><?php echo htmlspecialchars($basename); ?></span>
                </div>
                <input type="hidden" id="input_<?php echo $id; ?>" class="cms-bindable" data-value-type="image" data-field="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($val); ?>">
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>

<!-- Split-Screen Live Preview Workspace -->
<div class="cms-split-workspace">

    <!-- LEFT PANE: Editor Forms -->
    <div class="cms-editor-pane">
        
        <!-- Editor Header Bar -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; background: var(--white); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm);">
            <div>
                <label style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Editing Page</label>
                <select id="pageSelectDropdown" class="cms-select" style="font-weight: 700; color: var(--forest-green); min-width: 220px;" onchange="location.href='pages.php?page=' + this.value;">
                    <?php foreach ($pagesList as $p): ?>
                        <option value="<?php echo htmlspecialchars($p['slug']); ?>" <?php echo ($p['slug'] === $pageSlug) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($p['title']); ?> (<?php echo htmlspecialchars($p['file']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" id="toggleAllSectionsBtn" class="cms-btn cms-btn-outline cms-btn-sm" title="Expand or collapse all panels">
                    <i class="fa-solid fa-up-down"></i> Toggle All
                </button>
                <button type="button" id="discardDraftBtn" class="cms-btn cms-btn-outline cms-btn-sm" title="Revert to last published version">
                    <i class="fa-solid fa-rotate-left"></i> Discard
                </button>
                <button type="button" id="savePublishBtn" class="cms-btn cms-btn-primary cms-btn-sm" style="padding: 8px 18px;">
                    <i class="fa-solid fa-check"></i> Save & Publish
                </button>
            </div>
        </div>

        <form id="cmsPageEditorForm">
            <input type="hidden" id="currentPageSlug" value="<?php echo htmlspecialchars($pageSlug); ?>">
            <input type="hidden" id="csrfToken" value="<?php echo htmlspecialchars($csrfToken); ?>">

            <!-- 1. SEO & Social Meta Section (Common to all 8 pages) -->
            <div class="cms-section-panel">
                <div class="cms-section-head">
                    <h3><i class="fa-solid fa-globe" style="color: var(--forest-green);"></i> SEO & Social Metadata</h3>
                    <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                </div>
                <div class="cms-section-body">
                    <div class="cms-form-group">
                        <label class="cms-label">Page Title</label>
                        <input type="text" class="cms-input cms-bindable" data-field="seo.title" value="<?php echo htmlspecialchars($pageData['seo']['title'] ?? ''); ?>" placeholder="Enter browser page title">
                    </div>
                    <div class="cms-form-group">
                        <label class="cms-label">Meta Description</label>
                        <textarea class="cms-textarea cms-bindable" data-field="seo.description" placeholder="Brief summary for Google search results"><?php echo htmlspecialchars($pageData['seo']['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="cms-form-group">
                        <label class="cms-label">Keywords</label>
                        <input type="text" class="cms-input cms-bindable" data-field="seo.keywords" value="<?php echo htmlspecialchars($pageData['seo']['keywords'] ?? ''); ?>" placeholder="Comma separated keywords">
                    </div>
                </div>
            </div>

            <?php if ($pageSlug === 'home'): ?>
                <!-- ========================================================
                     1. HOMEPAGE SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- Hero Swiper Slider -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-images" style="color: var(--forest-green);"></i> Hero Swiper Slider (3 Slides)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $slides = $pageData['hero_slider']['slides'] ?? [];
                        foreach ($slides as $idx => $slide): 
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 10px;">
                                    Slide #<?php echo ($idx + 1); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Heading</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="hero_slider.slides.<?php echo $idx; ?>.heading" value="<?php echo htmlspecialchars($slide['heading'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Description / Subtitle</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="hero_slider.slides.<?php echo $idx; ?>.description"><?php echo htmlspecialchars($slide['description'] ?? ''); ?></textarea>
                                </div>
                                <?php echo renderCmsImageControl("hero_slider.slides.{$idx}.bg_image", "Background Image", $slide['bg_image'] ?? ''); ?>
                                <div style="display: flex; gap: 10px;">
                                    <div style="flex: 1;">
                                        <label class="cms-label">Button Label</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="hero_slider.slides.<?php echo $idx; ?>.link_text" value="<?php echo htmlspecialchars($slide['link_text'] ?? ''); ?>">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">CTA Button Link</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="hero_slider.slides.<?php echo $idx; ?>.link" value="<?php echo htmlspecialchars($slide['link'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 5 Feature Offer Cards -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-layer-group" style="color: var(--forest-green);"></i> Feature Offer Cards (5 Cards)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $cards = $pageData['feature_offers'] ?? [];
                        foreach ($cards as $cIdx => $card): 
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 10px;">
                                    Card #<?php echo ($cIdx + 1); ?>: <?php echo htmlspecialchars($card['heading'] ?? ''); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Card Heading</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="feature_offers.<?php echo $cIdx; ?>.heading" value="<?php echo htmlspecialchars($card['heading'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Card Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="feature_offers.<?php echo $cIdx; ?>.description"><?php echo htmlspecialchars($card['description'] ?? ''); ?></textarea>
                                </div>
                                <?php echo renderCmsImageControl("feature_offers.{$cIdx}.image", "Card Thumbnail Image", $card['image'] ?? ''); ?>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Target Link URL</label>
                                    <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="feature_offers.<?php echo $cIdx; ?>.link" value="<?php echo htmlspecialchars($card['link'] ?? ''); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Welcome Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-handshake" style="color: var(--forest-green);"></i> Welcome Section</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="welcome_section.heading" value="<?php echo htmlspecialchars($pageData['welcome_section']['heading'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Body Left Paragraph</label>
                            <textarea class="cms-textarea cms-bindable" data-field="welcome_section.body_left"><?php echo htmlspecialchars($pageData['welcome_section']['body_left'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Body Right Paragraph</label>
                            <textarea class="cms-textarea cms-bindable" data-field="welcome_section.body_right"><?php echo htmlspecialchars($pageData['welcome_section']['body_right'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Button Link URL</label>
                            <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="welcome_section.btn_url" value="<?php echo htmlspecialchars($pageData['welcome_section']['btn_url'] ?? 'services.php'); ?>">
                        </div>
                    </div>
                </div>

                <!-- Our Services Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-screwdriver-wrench" style="color: var(--forest-green);"></i> Our Services Highlights</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="services_section.title" value="<?php echo htmlspecialchars($pageData['services_section']['title'] ?? 'Our Services'); ?>">
                        </div>
                        <?php echo renderCmsImageControl("services_section.side_image", "Services Showcase Side Image", $pageData['services_section']['side_image'] ?? 'images/img-06-570x350.png'); ?>
                        <?php 
                        $hItems = $pageData['services_section']['items'] ?? [];
                        foreach ($hItems as $hIdx => $hItm):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div class="cms-form-group" style="margin-bottom: 6px;">
                                    <label class="cms-label">Service Item #<?php echo ($hIdx + 1); ?> Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="services_section.items.<?php echo $hIdx; ?>.title" value="<?php echo htmlspecialchars($hItm['title'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Link</label>
                                    <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="services_section.items.<?php echo $hIdx; ?>.link" value="<?php echo htmlspecialchars($hItm['link'] ?? 'services.php'); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Ready to Start CTA Banner -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-bullhorn" style="color: var(--forest-green);"></i> Ready to Start CTA Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Banner Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="cta_banner.heading" value="<?php echo htmlspecialchars($pageData['cta_banner']['heading'] ?? 'Ready to Start Your Construction or Remodeling Project?'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Banner Subtitle / Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="cta_banner.subtitle" rows="3"><?php echo htmlspecialchars($pageData['cta_banner']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Button Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="cta_banner.btn_label" value="<?php echo htmlspecialchars($pageData['cta_banner']['btn_label'] ?? 'Request an Estimate'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Button Target URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="cta_banner.btn_url" value="<?php echo htmlspecialchars($pageData['cta_banner']['btn_url'] ?? 'contacts.php'); ?>">
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'about'): ?>
                <!-- ========================================================
                     2. ABOUT US SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- 1. Hero & Company Story Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-book-open" style="color: var(--forest-green);"></i> Hero & Company Story</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Page Main Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'About Us'); ?>">
                        </div>
                        <?php echo renderCmsImageControl("hero.image", "Hero Photo / Experience Image", $pageData['hero']['image'] ?? 'images/aboutus.webp'); ?>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Image Alt Text</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.image_alt" value="<?php echo htmlspecialchars($pageData['hero']['image_alt'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Lead Subheading / Purpose</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.lead_paragraph"><?php echo htmlspecialchars($pageData['hero']['lead_paragraph'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Story Paragraph 1 (Mission & Purpose)</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p1"><?php echo htmlspecialchars($pageData['hero']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Story Paragraph 2 (Planning & Organization)</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p2"><?php echo htmlspecialchars($pageData['hero']['p2'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Story Paragraph 3 (Customer Experience & Trust)</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p3"><?php echo htmlspecialchars($pageData['hero']['p3'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Story Paragraph 4 (Mission Statement)</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p4"><?php echo htmlspecialchars($pageData['hero']['p4'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Company History Timeline (5 Milestones) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-timeline" style="color: var(--forest-green);"></i> Company History Timeline</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="history_heading" value="<?php echo htmlspecialchars($pageData['history_heading'] ?? 'Our History'); ?>">
                        </div>
                        <?php 
                        $history = $pageData['history'] ?? [];
                        foreach ($history as $hIdx => $h):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                                    <div style="width: 140px;">
                                        <label class="cms-label">Milestone Year</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="history.<?php echo $hIdx; ?>.year" value="<?php echo htmlspecialchars($h['year'] ?? ''); ?>" placeholder="e.g. 2001">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">Milestone Description</label>
                                        <textarea class="cms-textarea cms-bindable" data-field="history.<?php echo $hIdx; ?>.description" style="min-height: 60px;"><?php echo htmlspecialchars($h['description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. Jobs & Career Opportunities Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-briefcase" style="color: var(--forest-green);"></i> Jobs & Careers Section</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="jobs.heading" value="<?php echo htmlspecialchars($pageData['jobs']['heading'] ?? 'Jobs'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Subtitle</label>
                            <input type="text" class="cms-input cms-bindable" data-field="jobs.subtitle" value="<?php echo htmlspecialchars($pageData['jobs']['subtitle'] ?? 'Join Our Construction Team'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Overview Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="jobs.description"><?php echo htmlspecialchars($pageData['jobs']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <label class="cms-label" style="margin-top: 10px; font-weight: 700; color: var(--forest-green);">Open Positions (5 Listed)</label>
                        <?php 
                        $positions = $pageData['jobs']['positions'] ?? [];
                        foreach ($positions as $jIdx => $jobPos):
                        ?>
                            <div class="cms-form-group" style="margin-bottom: 8px;">
                                <label class="cms-label" style="font-size: 11px;">Position #<?php echo ($jIdx + 1); ?></label>
                                <input type="text" class="cms-input cms-bindable" data-field="jobs.positions.<?php echo $jIdx; ?>" value="<?php echo htmlspecialchars($jobPos); ?>">
                            </div>
                        <?php endforeach; ?>

                        <div class="cms-form-group" style="margin-top: 12px; margin-bottom: 0;">
                            <label class="cms-label">Jobs Footer Note</label>
                            <textarea class="cms-textarea cms-bindable" data-field="jobs.footer_text"><?php echo htmlspecialchars($pageData['jobs']['footer_text'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 4. Team Members (All 8 Key Leaders & Craftsmen with Photos) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-users" style="color: var(--forest-green);"></i> Team Members (8 Key Leaders & Craftsmen)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="team_heading" value="<?php echo htmlspecialchars($pageData['team_heading'] ?? 'Meet Our Team'); ?>">
                        </div>
                        <?php 
                        $team = $pageData['team'] ?? [];
                        foreach ($team as $tIdx => $m):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 10px;">
                                    Member #<?php echo ($tIdx + 1); ?>: <?php echo htmlspecialchars($m['name'] ?? ''); ?> (<?php echo htmlspecialchars($m['role'] ?? ''); ?>)
                                </div>
                                <div style="display: flex; gap: 12px;">
                                    <div style="flex: 1;">
                                        <div class="cms-form-group">
                                            <label class="cms-label">Full Name</label>
                                            <input type="text" class="cms-input cms-bindable" data-field="team.<?php echo $tIdx; ?>.name" value="<?php echo htmlspecialchars($m['name'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="cms-form-group">
                                            <label class="cms-label">Position / Role</label>
                                            <input type="text" class="cms-input cms-bindable" data-field="team.<?php echo $tIdx; ?>.role" value="<?php echo htmlspecialchars($m['role'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php echo renderCmsImageControl("team.{$tIdx}.image", "Member Photo", $m['image'] ?? ''); ?>
                                <div class="cms-form-group">
                                    <label class="cms-label">Direct Phone / Ext</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="team.<?php echo $tIdx; ?>.phone" value="<?php echo htmlspecialchars($m['phone'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Biography / Background Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="team.<?php echo $tIdx; ?>.description"><?php echo htmlspecialchars($m['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 5. Advantages (5 Key Value Points) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-award" style="color: var(--forest-green);"></i> Company Advantages (5 Points)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="advantages_heading" value="<?php echo htmlspecialchars($pageData['advantages_heading'] ?? 'Advantages'); ?>">
                        </div>
                        <?php 
                        $advantages = $pageData['advantages'] ?? [];
                        foreach ($advantages as $aIdx => $adv):
                        ?>
                            <div class="cms-form-group" style="margin-bottom: 10px;">
                                <label class="cms-label">Advantage #<?php echo ($aIdx + 1); ?></label>
                                <textarea class="cms-textarea cms-bindable" data-field="advantages.<?php echo $aIdx; ?>" style="min-height: 55px;"><?php echo htmlspecialchars($adv); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 6. Why Us (8 Reasons to Choose Us) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-thumbs-up" style="color: var(--forest-green);"></i> Why Choose Us (8 Reasons)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="why_us.heading" value="<?php echo htmlspecialchars($pageData['why_us']['heading'] ?? 'Why Us'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Subtitle</label>
                            <input type="text" class="cms-input cms-bindable" data-field="why_us.subtitle" value="<?php echo htmlspecialchars($pageData['why_us']['subtitle'] ?? '8 Reasons to Choose Smart Choice Contractors USA'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Overview Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="why_us.description"><?php echo htmlspecialchars($pageData['why_us']['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <label class="cms-label" style="margin-top: 10px; font-weight: 700; color: var(--forest-green);">Reasons List (8 Reasons)</label>
                        <?php 
                        $reasons = $pageData['why_us']['reasons'] ?? [];
                        foreach ($reasons as $rIdx => $reason):
                        ?>
                            <div class="cms-form-group" style="margin-bottom: 8px;">
                                <label class="cms-label" style="font-size: 11px;">Reason #<?php echo ($rIdx + 1); ?></label>
                                <input type="text" class="cms-input cms-bindable" data-field="why_us.reasons.<?php echo $rIdx; ?>" value="<?php echo htmlspecialchars($reason); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 7. Featured Client Testimonial -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-quote-left" style="color: var(--forest-green);"></i> Featured Client Testimonial</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="testimonial.heading" value="<?php echo htmlspecialchars($pageData['testimonial']['heading'] ?? 'Testimonials'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Testimonial Quote</label>
                            <textarea class="cms-textarea cms-bindable" data-field="testimonial.quote"><?php echo htmlspecialchars($pageData['testimonial']['quote'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Client Author Name</label>
                            <input type="text" class="cms-input cms-bindable" data-field="testimonial.author" value="<?php echo htmlspecialchars($pageData['testimonial']['author'] ?? ''); ?>">
                        </div>
                        <?php echo renderCmsImageControl("testimonial.image", "Client Photo", $pageData['testimonial']['image'] ?? 'images/persons/person-05-170x168.webp'); ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'services'): ?>
                <!-- ========================================================
                     3. SERVICES PAGE SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- 1. Services Hero Banner Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-bullhorn" style="color: var(--forest-green);"></i> Services Hero Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Page Main Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Our Construction Services'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Introductory Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.intro_p2"><?php echo htmlspecialchars($pageData['hero']['intro_p2'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. 13 Services Overview Cards -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-grip" style="color: var(--forest-green);"></i> Overview Quick Cards (13 Cards)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $ovCards = $pageData['overview_cards'] ?? [];
                        foreach ($ovCards as $ocIdx => $oc):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                <div style="font-weight: 700; font-size: 12.5px; color: var(--forest-green); margin-bottom: 8px;">
                                    Card #<?php echo ($ocIdx + 1); ?>: <?php echo htmlspecialchars($oc['title'] ?? ''); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Card Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview_cards.<?php echo $ocIdx; ?>.title" value="<?php echo htmlspecialchars($oc['title'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Card Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="overview_cards.<?php echo $ocIdx; ?>.description"><?php echo htmlspecialchars($oc['description'] ?? ''); ?></textarea>
                                </div>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Card Target Link (Optional)</label>
                                    <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="overview_cards.<?php echo $ocIdx; ?>.link" value="<?php echo htmlspecialchars($oc['link'] ?? ''); ?>" placeholder="e.g. /services/plumbing-services.php">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. Material Takeoff Services Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-calculator" style="color: var(--forest-green);"></i> Material Takeoff Services</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="material_takeoff.heading" value="<?php echo htmlspecialchars($pageData['material_takeoff']['heading'] ?? 'Material Takeoff Services'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Takeoff Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="material_takeoff.p1"><?php echo htmlspecialchars($pageData['material_takeoff']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Takeoff Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="material_takeoff.p2"><?php echo htmlspecialchars($pageData['material_takeoff']['p2'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Call To Action Prefix Text</label>
                                <input type="text" class="cms-input cms-bindable" data-field="material_takeoff.cta_text" value="<?php echo htmlspecialchars($pageData['material_takeoff']['cta_text'] ?? 'Request your material takeoff estimate:'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Email Link Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="material_takeoff.email_label" value="<?php echo htmlspecialchars($pageData['material_takeoff']['email_label'] ?? 'Email Our Estimating Department'); ?>">
                            </div>
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Estimating Department Email</label>
                            <input type="email" class="cms-input cms-bindable" data-field="material_takeoff.email" value="<?php echo htmlspecialchars($pageData['material_takeoff']['email'] ?? 'sales@justsmartchoice.com'); ?>">
                        </div>
                    </div>
                </div>

                <!-- 4. Full Service Catalog Cards (All 28 Services With Interactive Photo Controls) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-list-check" style="color: var(--forest-green);"></i> Full Service Catalog Cards (All 28 Services & Photos)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Catalog Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="catalog_section.heading" value="<?php echo htmlspecialchars($pageData['catalog_section']['heading'] ?? 'Construction Services Near Me In Tampa Bay And Central Florida'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Catalog Section Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="catalog_section.description"><?php echo htmlspecialchars($pageData['catalog_section']['description'] ?? ''); ?></textarea>
                        </div>

                        <?php 
                        $catalogCards = $pageData['catalog_cards'] ?? [];
                        foreach ($catalogCards as $catIdx => $cat):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 10px;">
                                    Service #<?php echo ($catIdx + 1); ?>: <?php echo htmlspecialchars($cat['title'] ?? ''); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Service Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="catalog_cards.<?php echo $catIdx; ?>.title" value="<?php echo htmlspecialchars($cat['title'] ?? ''); ?>">
                                </div>
                                <?php echo renderCmsImageControl("catalog_cards.{$catIdx}.image", "Service Photo (Auto-WebP)", $cat['image'] ?? ''); ?>
                                <div class="cms-form-group">
                                    <label class="cms-label">Photo Alt Text</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="catalog_cards.<?php echo $catIdx; ?>.alt" value="<?php echo htmlspecialchars($cat['alt'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Service Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="catalog_cards.<?php echo $catIdx; ?>.description"><?php echo htmlspecialchars($cat['description'] ?? ''); ?></textarea>
                                </div>
                                <div style="display: flex; gap: 10px;">
                                    <div style="flex: 1;">
                                        <label class="cms-label">View Service URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="catalog_cards.<?php echo $catIdx; ?>.view_link" value="<?php echo htmlspecialchars($cat['view_link'] ?? ''); ?>">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">Book Consultation URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="catalog_cards.<?php echo $catIdx; ?>.book_link" value="<?php echo htmlspecialchars($cat['book_link'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 5. Client Testimonials (4 Reviews) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-star" style="color: var(--forest-green);"></i> Client Reviews (4 Testimonials)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="testimonials_heading" value="<?php echo htmlspecialchars($pageData['testimonials_heading'] ?? 'Client Testimonials'); ?>">
                        </div>
                        <?php 
                        $tList = $pageData['testimonials'] ?? [];
                        foreach ($tList as $tlIdx => $tl):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                <div class="cms-form-group">
                                    <label class="cms-label">Review #<?php echo ($tlIdx + 1); ?> Quote</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="testimonials.<?php echo $tlIdx; ?>.quote"><?php echo htmlspecialchars($tl['quote'] ?? ''); ?></textarea>
                                </div>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Client Name & Location</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="testimonials.<?php echo $tlIdx; ?>.author" value="<?php echo htmlspecialchars($tl['author'] ?? ''); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 6. Solar Solutions Showcase -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-solar-panel" style="color: var(--forest-green);"></i> Solar Energy & Outdoor Living</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="solar_section.heading" value="<?php echo htmlspecialchars($pageData['solar_section']['heading'] ?? 'Luxury Outdoor Solutions With Solar Integration'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="solar_section.description"><?php echo htmlspecialchars($pageData['solar_section']['description'] ?? ''); ?></textarea>
                        </div>
                        <?php echo renderCmsImageControl("solar_section.image", "Solar Showcase Photo", $pageData['solar_section']['image'] ?? 'images/img-09-570x351.webp'); ?>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Photo Caption</label>
                            <input type="text" class="cms-input cms-bindable" data-field="solar_section.caption" value="<?php echo htmlspecialchars($pageData['solar_section']['caption'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <!-- 7. Electrical Services Showcase -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-bolt" style="color: var(--forest-green);"></i> Electrical Services Showcase</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="electrical_section.heading" value="<?php echo htmlspecialchars($pageData['electrical_section']['heading'] ?? 'Electrical Services'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="electrical_section.p1"><?php echo htmlspecialchars($pageData['electrical_section']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="electrical_section.p2"><?php echo htmlspecialchars($pageData['electrical_section']['p2'] ?? ''); ?></textarea>
                        </div>
                        <?php echo renderCmsImageControl("electrical_section.image", "Electrical Feature Photo", $pageData['electrical_section']['image'] ?? 'images/img-06-570x350.png'); ?>
                    </div>
                </div>

                <!-- 8. Plumbing Services Showcase -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-faucet-drip" style="color: var(--forest-green);"></i> Plumbing Services Showcase</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Section Heading</label>
                                <input type="text" class="cms-input cms-bindable" data-field="plumbing_section.heading" value="<?php echo htmlspecialchars($pageData['plumbing_section']['heading'] ?? 'Plumbing Services'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Heading Link URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="plumbing_section.heading_link" value="<?php echo htmlspecialchars($pageData['plumbing_section']['heading_link'] ?? '/services/plumbing-services.php'); ?>">
                            </div>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="plumbing_section.p1"><?php echo htmlspecialchars($pageData['plumbing_section']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="plumbing_section.p2"><?php echo htmlspecialchars($pageData['plumbing_section']['p2'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 3</label>
                            <textarea class="cms-textarea cms-bindable" data-field="plumbing_section.p3"><?php echo htmlspecialchars($pageData['plumbing_section']['p3'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 12px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Button Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="plumbing_section.btn_label" value="<?php echo htmlspecialchars($pageData['plumbing_section']['btn_label'] ?? 'Schedule Plumbing Appointment'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Button Target URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="plumbing_section.btn_link" value="<?php echo htmlspecialchars($pageData['plumbing_section']['btn_link'] ?? ''); ?>">
                            </div>
                        </div>
                        <?php echo renderCmsImageControl("plumbing_section.image", "Plumbing Feature Photo", $pageData['plumbing_section']['image'] ?? 'images/plumbing-570x350.jpg'); ?>
                    </div>
                </div>

                <!-- 9. Final Call To Action Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-phone-volume" style="color: var(--forest-green);"></i> Final Call To Action Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">CTA Main Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="final_cta.heading" value="<?php echo htmlspecialchars($pageData['final_cta']['heading'] ?? 'Need Professional Plumbing Services in Tampa Bay?'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="final_cta.p1"><?php echo htmlspecialchars($pageData['final_cta']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="final_cta.p2"><?php echo htmlspecialchars($pageData['final_cta']['p2'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 3</label>
                            <textarea class="cms-textarea cms-bindable" data-field="final_cta.p3"><?php echo htmlspecialchars($pageData['final_cta']['p3'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Primary Button Text</label>
                                <input type="text" class="cms-input cms-bindable" data-field="final_cta.btn_primary_label" value="<?php echo htmlspecialchars($pageData['final_cta']['btn_primary_label'] ?? 'Schedule Your Plumbing Appointment'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Primary Button Link</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="final_cta.btn_primary_link" value="<?php echo htmlspecialchars($pageData['final_cta']['btn_primary_link'] ?? ''); ?>">
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 0;">
                            <div style="flex: 1;">
                                <label class="cms-label">Secondary Button Text</label>
                                <input type="text" class="cms-input cms-bindable" data-field="final_cta.btn_default_label" value="<?php echo htmlspecialchars($pageData['final_cta']['btn_default_label'] ?? 'Learn More About Plumbing Services'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Secondary Button Link</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="final_cta.btn_default_link" value="<?php echo htmlspecialchars($pageData['final_cta']['btn_default_link'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'pricing'): ?>
                <!-- ========================================================
                     4. PRICING PAGE SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- 1. Pricing Page Hero Header -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-bullhorn" style="color: var(--forest-green);"></i> Pricing Hero Header</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Eyebrow Badge</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.eyebrow" value="<?php echo htmlspecialchars($pageData['hero']['eyebrow'] ?? 'Tampa Bay Construction Pricing'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Page Main Heading (H1)</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Smart Choice Contractors USA Service Price Guide'); ?>">
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Subtitle / Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. 5 Special Pricing Offer Cards -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-tags" style="color: var(--forest-green);"></i> Feature Offer Cards (5 Cards)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $pOffers = $pageData['offer_cards'] ?? [];
                        foreach ($pOffers as $poIdx => $po):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 10px;">
                                    Card #<?php echo ($poIdx + 1); ?>: <?php echo htmlspecialchars($po['heading'] ?? ''); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Card Heading</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="offer_cards.<?php echo $poIdx; ?>.heading" value="<?php echo htmlspecialchars($po['heading'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="offer_cards.<?php echo $poIdx; ?>.description"><?php echo htmlspecialchars($po['description'] ?? ''); ?></textarea>
                                </div>
                                <?php echo renderCmsImageControl("offer_cards.{$poIdx}.image", "Card Background Photo", $po['image'] ?? ''); ?>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Link URL</label>
                                    <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="offer_cards.<?php echo $poIdx; ?>.link" value="<?php echo htmlspecialchars($po['link'] ?? ''); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. 8 Detailed Pricing Tables -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-table-list" style="color: var(--forest-green);"></i> Detailed Pricing Tables (All 8 Categories)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $tables = $pageData['tables'] ?? [];
                        foreach ($tables as $tIdx => $t):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 8px;">
                                    Table #<?php echo ($tIdx + 1); ?>: <?php echo htmlspecialchars($t['category'] ?? ''); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Category Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="tables.<?php echo $tIdx; ?>.category" value="<?php echo htmlspecialchars($t['category'] ?? ''); ?>">
                                </div>
                                <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase;">Table Rows (4 Rows per Table):</div>
                                <?php 
                                $rows = $t['rows'] ?? [];
                                foreach ($rows as $rIdx => $row):
                                ?>
                                    <div style="background: #f8fafc; border: 1px solid var(--border-subtle); border-radius: 6px; padding: 10px; margin-bottom: 8px;">
                                        <div style="font-size: 11px; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">Row #<?php echo ($rIdx + 1); ?></div>
                                        <div style="display: flex; gap: 8px; margin-bottom: 6px;">
                                            <div style="flex: 2;">
                                                <input type="text" class="cms-input cms-bindable" data-field="tables.<?php echo $tIdx; ?>.rows.<?php echo $rIdx; ?>.s1" value="<?php echo htmlspecialchars($row['s1'] ?? ''); ?>" placeholder="Service 1">
                                            </div>
                                            <div style="flex: 2;">
                                                <input type="text" class="cms-input cms-bindable" data-field="tables.<?php echo $tIdx; ?>.rows.<?php echo $rIdx; ?>.p1" value="<?php echo htmlspecialchars($row['p1'] ?? ''); ?>" placeholder="Price 1">
                                            </div>
                                        </div>
                                        <div style="display: flex; gap: 8px;">
                                            <div style="flex: 2;">
                                                <input type="text" class="cms-input cms-bindable" data-field="tables.<?php echo $tIdx; ?>.rows.<?php echo $rIdx; ?>.s2" value="<?php echo htmlspecialchars($row['s2'] ?? ''); ?>" placeholder="Service 2">
                                            </div>
                                            <div style="flex: 2;">
                                                <input type="text" class="cms-input cms-bindable" data-field="tables.<?php echo $tIdx; ?>.rows.<?php echo $rIdx; ?>.p2" value="<?php echo htmlspecialchars($row['p2'] ?? ''); ?>" placeholder="Price 2">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 4. Buy Services Online & Disclaimer Note -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-cart-shopping" style="color: var(--forest-green);"></i> Buy Online CTA & Disclaimer</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">CTA Button Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="buy_services.btn_label" value="<?php echo htmlspecialchars($pageData['buy_services']['btn_label'] ?? 'Buy Services Online'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">CTA Button Link URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="buy_services.btn_url" value="<?php echo htmlspecialchars($pageData['buy_services']['btn_url'] ?? 'https://crm.justsmartchoice.com/products/clientes'); ?>">
                            </div>
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Pricing Note / Market Disclaimer</label>
                            <textarea class="cms-textarea cms-bindable" data-field="buy_services.disclaimer"><?php echo htmlspecialchars($pageData['buy_services']['disclaimer'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. Specialized Service Pages (3 Cards) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-shapes" style="color: var(--forest-green);"></i> Specialized Service Cards (3 Cards)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="specialized_section.eyebrow" value="<?php echo htmlspecialchars($pageData['specialized_section']['eyebrow'] ?? 'More Construction Services'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="specialized_section.heading" value="<?php echo htmlspecialchars($pageData['specialized_section']['heading'] ?? 'Specialized Service Pages'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="specialized_section.intro"><?php echo htmlspecialchars($pageData['specialized_section']['intro'] ?? ''); ?></textarea>
                        </div>

                        <?php 
                        $sCards = $pageData['specialized_cards'] ?? [];
                        foreach ($sCards as $scIdx => $sc):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 10px;">
                                    Specialized Card #<?php echo ($scIdx + 1); ?>: <?php echo htmlspecialchars($sc['title'] ?? ''); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Card Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="specialized_cards.<?php echo $scIdx; ?>.title" value="<?php echo htmlspecialchars($sc['title'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="specialized_cards.<?php echo $scIdx; ?>.description"><?php echo htmlspecialchars($sc['description'] ?? ''); ?></textarea>
                                </div>
                                <?php echo renderCmsImageControl("specialized_cards.{$scIdx}.image", "Card Photo", $sc['image'] ?? ''); ?>
                                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                                    <div style="flex: 1;">
                                        <label class="cms-label">Link Text</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="specialized_cards.<?php echo $scIdx; ?>.link_text" value="<?php echo htmlspecialchars($sc['link_text'] ?? 'Open Service Page'); ?>">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">Link URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="specialized_cards.<?php echo $scIdx; ?>.link" value="<?php echo htmlspecialchars($sc['link'] ?? ''); ?>">
                                    </div>
                                </div>
                                
                                <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Bullet Points (4 Points):</div>
                                <?php 
                                $items = $sc['items'] ?? [];
                                foreach ($items as $itemIdx => $item):
                                ?>
                                    <div class="cms-form-group" style="margin-bottom: 6px;">
                                        <input type="text" class="cms-input cms-bindable" data-field="specialized_cards.<?php echo $scIdx; ?>.items.<?php echo $itemIdx; ?>" value="<?php echo htmlspecialchars($item); ?>" placeholder="Bullet item">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 6. Preferred Suppliers & Logos (8 Logos) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-handshake-simple" style="color: var(--forest-green);"></i> Preferred Suppliers & Brands (8 Logos)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="suppliers_heading" value="<?php echo htmlspecialchars($pageData['suppliers_heading'] ?? 'Our Suppliers'); ?>">
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 12px;">
                            <?php 
                            $suppliers = $pageData['suppliers'] ?? [];
                            foreach ($suppliers as $spIdx => $sp):
                            ?>
                                <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px;">
                                    <div style="font-weight: 700; font-size: 12px; color: var(--forest-green); margin-bottom: 8px;">
                                        Supplier #<?php echo ($spIdx + 1); ?>
                                    </div>
                                    <?php echo renderCmsImageControl("suppliers.{$spIdx}.image", "Supplier Logo", $sp['image'] ?? ''); ?>
                                    <div class="cms-form-group" style="margin-bottom: 0;">
                                        <label class="cms-label" style="font-size: 11px;">Website URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="suppliers.<?php echo $spIdx; ?>.link" value="<?php echo htmlspecialchars($sp['link'] ?? '#'); ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'financing'): ?>
                <!-- ========================================================
                     5. FINANCING PAGE SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- Financing Welcome & Intro -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-money-check-dollar" style="color: var(--forest-green);"></i> Financing Welcome & Intro</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Welcome Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="welcome.heading" value="<?php echo htmlspecialchars($pageData['welcome']['heading'] ?? "Customer's Financing services!"); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Intro Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="welcome.p1" rows="5"><?php echo htmlspecialchars($pageData['welcome']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Intro Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="welcome.p2" rows="5"><?php echo htmlspecialchars($pageData['welcome']['p2'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Lenders Section Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Financing Online Application'); ?>">
                        </div>
                    </div>
                </div>

                <!-- 11 Approved Lenders -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-building-columns" style="color: var(--forest-green);"></i> Approved Lenders (11 Banks & Lenders)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $lenders = $pageData['lenders'] ?? [];
                        foreach ($lenders as $lIdx => $len):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <strong style="color: var(--forest-green); font-size: 13px;">
                                        #<?php echo ($lIdx + 1); ?>: <?php echo htmlspecialchars($len['name'] ?? 'Lender'); ?>
                                    </strong>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Lender Name</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="lenders.<?php echo $lIdx; ?>.name" value="<?php echo htmlspecialchars($len['name'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Special Note / Requirement (optional)</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="lenders.<?php echo $lIdx; ?>.note" value="<?php echo htmlspecialchars($len['note'] ?? ''); ?>" placeholder="e.g. May accept credit scores starting around 500">
                                </div>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Application / Partner Website URL</label>
                                    <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="lenders.<?php echo $lIdx; ?>.url" value="<?php echo htmlspecialchars($len['url'] ?? ''); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 2 Right-Side Promo Banners -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-rectangle-ad" style="color: var(--forest-green);"></i> Right Side Promo Banners (2 Banners)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $promos = $pageData['promo_images'] ?? [];
                        foreach ($promos as $pIdx => $p):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <strong style="color: var(--forest-green); display: block; margin-bottom: 10px; font-size: 13px;">
                                    Promo Banner #<?php echo ($pIdx + 1); ?>
                                </strong>
                                <div class="cms-form-group">
                                    <label class="cms-label">Overlay Main Text (Large Heading)</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="promo_images.<?php echo $pIdx; ?>.overlay_text" value="<?php echo htmlspecialchars($p['overlay_text'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Overlay Subtext (Button Badge)</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="promo_images.<?php echo $pIdx; ?>.overlay_subtext" value="<?php echo htmlspecialchars($p['overlay_subtext'] ?? ''); ?>">
                                </div>
                                <?php echo renderCmsImageControl("promo_images.{$pIdx}.image", "Banner Photo (WebP)", $p['image'] ?? ''); ?>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Appointment / Click URL</label>
                                    <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="promo_images.<?php echo $pIdx; ?>.url" value="<?php echo htmlspecialchars($p['url'] ?? ''); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'contacts'): ?>
                <!-- ========================================================
                     6. CONTACTS PAGE SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- 1. Overview Cards (Goal, Contacts & CRM) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-address-card" style="color: var(--forest-green);"></i> Overview Cards (Goal, Contacts & CRM)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <!-- Card 1: Our Goal -->
                        <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                            <strong style="color: var(--forest-green); display: block; margin-bottom: 10px;">Card #1: Our Goal</strong>
                            <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 80px;">
                                    <label class="cms-label">Icon</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_1.icon" value="<?php echo htmlspecialchars($pageData['overview']['card_1']['icon'] ?? '🏗️'); ?>">
                                </div>
                                <div style="flex: 1;">
                                    <label class="cms-label">Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_1.title" value="<?php echo htmlspecialchars($pageData['overview']['card_1']['title'] ?? 'Our Goal'); ?>">
                                </div>
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Lead Text</label>
                                <textarea class="cms-textarea cms-bindable" data-field="overview.card_1.lead" rows="2"><?php echo htmlspecialchars($pageData['overview']['card_1']['lead'] ?? ''); ?></textarea>
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Item 1</label>
                                <input type="text" class="cms-input cms-bindable" data-field="overview.card_1.item_1" value="<?php echo htmlspecialchars($pageData['overview']['card_1']['item_1'] ?? ''); ?>">
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Item 2</label>
                                <input type="text" class="cms-input cms-bindable" data-field="overview.card_1.item_2" value="<?php echo htmlspecialchars($pageData['overview']['card_1']['item_2'] ?? ''); ?>">
                            </div>
                            <div class="cms-form-group" style="margin-bottom: 0;">
                                <label class="cms-label">Item 3</label>
                                <input type="text" class="cms-input cms-bindable" data-field="overview.card_1.item_3" value="<?php echo htmlspecialchars($pageData['overview']['card_1']['item_3'] ?? ''); ?>">
                            </div>
                        </div>

                        <!-- Card 2: Who to Contact? -->
                        <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                            <strong style="color: var(--forest-green); display: block; margin-bottom: 10px;">Card #2: Who to Contact?</strong>
                            <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 80px;">
                                    <label class="cms-label">Icon</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_2.icon" value="<?php echo htmlspecialchars($pageData['overview']['card_2']['icon'] ?? '📞'); ?>">
                                </div>
                                <div style="flex: 1;">
                                    <label class="cms-label">Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_2.title" value="<?php echo htmlspecialchars($pageData['overview']['card_2']['title'] ?? 'Who to Contact?'); ?>">
                                </div>
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Lead Text</label>
                                <input type="text" class="cms-input cms-bindable" data-field="overview.card_2.lead" value="<?php echo htmlspecialchars($pageData['overview']['card_2']['lead'] ?? ''); ?>">
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Description</label>
                                <textarea class="cms-textarea cms-bindable" data-field="overview.card_2.description" rows="2"><?php echo htmlspecialchars($pageData['overview']['card_2']['description'] ?? ''); ?></textarea>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div>
                                    <label class="cms-label">Department 1</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_2.dept_1" value="<?php echo htmlspecialchars($pageData['overview']['card_2']['dept_1'] ?? ''); ?>">
                                </div>
                                <div>
                                    <label class="cms-label">Department 2</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_2.dept_2" value="<?php echo htmlspecialchars($pageData['overview']['card_2']['dept_2'] ?? ''); ?>">
                                </div>
                                <div>
                                    <label class="cms-label">Department 3</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_2.dept_3" value="<?php echo htmlspecialchars($pageData['overview']['card_2']['dept_3'] ?? ''); ?>">
                                </div>
                                <div>
                                    <label class="cms-label">Department 4</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_2.dept_4" value="<?php echo htmlspecialchars($pageData['overview']['card_2']['dept_4'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Client Resources -->
                        <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px;">
                            <strong style="color: var(--forest-green); display: block; margin-bottom: 10px;">Card #3: Client Resources & CRM</strong>
                            <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 80px;">
                                    <label class="cms-label">Card Icon</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_3.icon" value="<?php echo htmlspecialchars($pageData['overview']['card_3']['icon'] ?? '🗂️'); ?>">
                                </div>
                                <div style="flex: 1;">
                                    <label class="cms-label">Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_3.title" value="<?php echo htmlspecialchars($pageData['overview']['card_3']['title'] ?? 'Client Resources'); ?>">
                                </div>
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Lead Text</label>
                                <input type="text" class="cms-input cms-bindable" data-field="overview.card_3.lead" value="<?php echo htmlspecialchars($pageData['overview']['card_3']['lead'] ?? ''); ?>">
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Description</label>
                                <textarea class="cms-textarea cms-bindable" data-field="overview.card_3.description" rows="2"><?php echo htmlspecialchars($pageData['overview']['card_3']['description'] ?? ''); ?></textarea>
                            </div>
                            <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 80px;">
                                    <label class="cms-label">CRM Icon</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_3.crm_icon" value="<?php echo htmlspecialchars($pageData['overview']['card_3']['crm_icon'] ?? '🔐'); ?>">
                                </div>
                                <div style="flex: 1;">
                                    <label class="cms-label">CRM Link Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="overview.card_3.crm_title" value="<?php echo htmlspecialchars($pageData['overview']['card_3']['crm_title'] ?? 'Client CRM Access'); ?>">
                                </div>
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">CRM Subtitle</label>
                                <input type="text" class="cms-input cms-bindable" data-field="overview.card_3.crm_subtitle" value="<?php echo htmlspecialchars($pageData['overview']['card_3']['crm_subtitle'] ?? ''); ?>">
                            </div>
                            <div class="cms-form-group" style="margin-bottom: 0;">
                                <label class="cms-label">CRM Portal URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="overview.card_3.crm_url" value="<?php echo htmlspecialchars($pageData['overview']['card_3']['crm_url'] ?? 'https://crm.justsmartchoice.com/authentication/login'); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Office Location & Map Card -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-map-location-dot" style="color: var(--forest-green);"></i> Office Location & Map Card</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="office_map.eyebrow" value="<?php echo htmlspecialchars($pageData['office_map']['eyebrow'] ?? 'Visit Smart Choice Contractors USA'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Card Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="office_map.title" value="<?php echo htmlspecialchars($pageData['office_map']['title'] ?? 'Find Our Location'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Company Name</label>
                            <input type="text" class="cms-input cms-bindable" data-field="office_map.company_name" value="<?php echo htmlspecialchars($pageData['office_map']['company_name'] ?? 'Smart Choice Contractors USA'); ?>">
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Address Line 1</label>
                                <input type="text" class="cms-input cms-bindable" data-field="office_map.address_line1" value="<?php echo htmlspecialchars($pageData['office_map']['address_line1'] ?? '1663 US Highway 41'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Address Line 2</label>
                                <input type="text" class="cms-input cms-bindable" data-field="office_map.address_line2" value="<?php echo htmlspecialchars($pageData['office_map']['address_line2'] ?? 'Spring Hill, FL 34610'); ?>">
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Display Phone</label>
                                <input type="text" class="cms-input cms-bindable" data-field="office_map.phone" value="<?php echo htmlspecialchars($pageData['office_map']['phone'] ?? '(727) 755-3786'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Phone Tel Link</label>
                                <input type="text" class="cms-input cms-bindable" data-field="office_map.phone_tel" value="<?php echo htmlspecialchars($pageData['office_map']['phone_tel'] ?? '+17277553786'); ?>">
                            </div>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Directions Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="office_map.description" rows="2"><?php echo htmlspecialchars($pageData['office_map']['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Google Maps Directions URL</label>
                            <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="office_map.directions_url" value="<?php echo htmlspecialchars($pageData['office_map']['directions_url'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Google Maps Search URL</label>
                            <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="office_map.maps_search_url" value="<?php echo htmlspecialchars($pageData['office_map']['maps_search_url'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Google Maps Embed URL (Iframe)</label>
                            <input type="text" class="cms-input cms-bindable" data-field="office_map.embed_url" value="<?php echo htmlspecialchars($pageData['office_map']['embed_url'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <!-- 3. Contact & Estimate Form Note -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-file-pen" style="color: var(--forest-green);"></i> Contact Form &amp; Document Note</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Form Section Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="contact_form.title" value="<?php echo htmlspecialchars($pageData['contact_form']['title'] ?? 'Get in Touch'); ?>">
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <div style="width: 80px;">
                                <label class="cms-label">Note Icon</label>
                                <input type="text" class="cms-input cms-bindable" data-field="contact_form.note_icon" value="<?php echo htmlspecialchars($pageData['contact_form']['note_icon'] ?? '📐'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Note Title</label>
                                <input type="text" class="cms-input cms-bindable" data-field="contact_form.note_title" value="<?php echo htmlspecialchars($pageData['contact_form']['note_title'] ?? 'Project Documents, Drawings or Estimate Information'); ?>">
                            </div>
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Note Text / Instructions (HTML supported)</label>
                            <textarea class="cms-textarea cms-bindable" data-field="contact_form.note_text" rows="3"><?php echo htmlspecialchars($pageData['contact_form']['note_text'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 4. Lead Notification Delivery Settings -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-envelope-circle-check" style="color: var(--forest-green);"></i> Lead Notification Delivery</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Recipient Emails (Comma separated)</label>
                            <input type="text" class="cms-input cms-bindable" data-field="email_config.recipients" value="<?php echo htmlspecialchars($pageData['email_config']['recipients'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Lead Email Subject Prefix</label>
                            <input type="text" class="cms-input cms-bindable" data-field="email_config.subject_prefix" value="<?php echo htmlspecialchars($pageData['email_config']['subject_prefix'] ?? 'New Lead from the Website: '); ?>">
                        </div>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'blog'): ?>
                <!-- ========================================================
                     7. BLOG PAGE SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- 1. Floating Appointment Notice -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-bell" style="color: var(--forest-green);"></i> Floating Help Notice</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Notice Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="notice.title" value="<?php echo htmlspecialchars($pageData['notice']['title'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Notice Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="notice.description"><?php echo htmlspecialchars($pageData['notice']['description'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Button Text</label>
                                <input type="text" class="cms-input cms-bindable" data-field="notice.button_text" value="<?php echo htmlspecialchars($pageData['notice']['button_text'] ?? ''); ?>">
                            </div>
                            <div style="flex: 2;">
                                <label class="cms-label">Button URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="notice.button_url" value="<?php echo htmlspecialchars($pageData['notice']['button_url'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Hero Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-graduation-cap" style="color: var(--forest-green);"></i> Blog Hero & Mission Center</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.eyebrow" value="<?php echo htmlspecialchars($pageData['hero']['eyebrow'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Mission Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p1" rows="3"><?php echo htmlspecialchars($pageData['hero']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Mission Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p2" rows="3"><?php echo htmlspecialchars($pageData['hero']['p2'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Mission Paragraph 3</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p3" rows="3"><?php echo htmlspecialchars($pageData['hero']['p3'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 3. Articles Section Header -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-heading" style="color: var(--forest-green);"></i> Articles Section Heading</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Articles Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="articles_header.title" value="<?php echo htmlspecialchars($pageData['articles_header']['title'] ?? 'Latest Construction Articles'); ?>">
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Articles Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="articles_header.subtitle" rows="3"><?php echo htmlspecialchars($pageData['articles_header']['subtitle'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 4. Why News & Education Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-lightbulb" style="color: var(--forest-green);"></i> Why News & Education</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="why_news.title" value="<?php echo htmlspecialchars($pageData['why_news']['title'] ?? 'Why We Show Construction News, Licensing Warnings And Project Education'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="why_news.p1" rows="4"><?php echo htmlspecialchars($pageData['why_news']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group" style="margin-bottom: 0;">
                            <label class="cms-label">Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="why_news.p2" rows="4"><?php echo htmlspecialchars($pageData['why_news']['p2'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 5. Featured Service Guides (6 Guides with Images) -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-newspaper" style="color: var(--forest-green);"></i> Featured Service Guides (6 Guides with Images)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $guides = $pageData['featured_guides'] ?? [];
                        foreach ($guides as $gIdx => $g):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 14px; margin-bottom: 14px;">
                                <div style="font-weight: 700; font-size: 13px; color: var(--forest-green); margin-bottom: 10px;">
                                    Guide #<?php echo ($gIdx + 1); ?>: <?php echo htmlspecialchars($g['title'] ?? ''); ?>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Guide Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="featured_guides.<?php echo $gIdx; ?>.title" value="<?php echo htmlspecialchars($g['title'] ?? ''); ?>">
                                </div>
                                <?php echo renderCmsImageControl("featured_guides.{$gIdx}.image", "Guide Feature Image (WebP)", $g['image'] ?? ''); ?>
                                <div class="cms-form-group">
                                    <label class="cms-label">Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="featured_guides.<?php echo $gIdx; ?>.description" rows="3"><?php echo htmlspecialchars($g['description'] ?? ''); ?></textarea>
                                </div>
                                <div style="display: flex; gap: 10px;">
                                    <div style="flex: 1;">
                                        <label class="cms-label">Guide URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="featured_guides.<?php echo $gIdx; ?>.guide_url" value="<?php echo htmlspecialchars($g['guide_url'] ?? ''); ?>">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">Booking URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="featured_guides.<?php echo $gIdx; ?>.book_url" value="<?php echo htmlspecialchars($g['book_url'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 6. Video Resources -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-brands fa-youtube" style="color: var(--forest-green);"></i> Video Resources (4 YouTube Videos)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="video_resources.title" value="<?php echo htmlspecialchars($pageData['video_resources']['title'] ?? ''); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="video_resources.subtitle"><?php echo htmlspecialchars($pageData['video_resources']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <?php 
                        $vids = $pageData['video_resources']['videos'] ?? [];
                        foreach ($vids as $vdIdx => $vd):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 10px;">
                                <div class="cms-form-group">
                                    <label class="cms-label">Video #<?php echo ($vdIdx + 1); ?> Title</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="video_resources.videos.<?php echo $vdIdx; ?>.title" value="<?php echo htmlspecialchars($vd['title'] ?? ''); ?>">
                                </div>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">YouTube Embed URL</label>
                                    <input type="text" class="cms-input cms-bindable" data-field="video_resources.videos.<?php echo $vdIdx; ?>.url" value="<?php echo htmlspecialchars($vd['url'] ?? ''); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'login'): ?>
                <!-- ========================================================
                     8. LOGIN PAGE SPECIFIC SECTIONS
                     ======================================================== -->

                <!-- 1. Hero Banner -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-image" style="color: var(--forest-green);"></i> Login Hero Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.eyebrow" value="<?php echo htmlspecialchars($pageData['hero']['eyebrow'] ?? 'Smart Choice Online Portal'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Main Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Customer & Client Portal'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle" rows="3"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <?php echo renderCmsImageControl("hero.bg_image", "Hero Background Image (auto-WebP)", $pageData['hero']['bg_image'] ?? 'images/banner/banner-bg-03-1920x310.jpg'); ?>
                    </div>
                </div>

                <!-- 2. Client Portal Access Card -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-lock" style="color: var(--forest-green);"></i> Client Portal Sign-In Card</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Card Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="login_card.eyebrow" value="<?php echo htmlspecialchars($pageData['login_card']['eyebrow'] ?? 'Secure Account Sign In'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Card Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="login_card.heading" value="<?php echo htmlspecialchars($pageData['login_card']['heading'] ?? 'Client Portal Login'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Card Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="login_card.description" rows="3"><?php echo htmlspecialchars($pageData['login_card']['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Client Portal Login URL</label>
                            <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="login_card.crm_url" value="<?php echo htmlspecialchars($pageData['login_card']['crm_url'] ?? 'https://crm.justsmartchoice.com/authentication/login'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Client Login Button Text</label>
                            <input type="text" class="cms-input cms-bindable" data-field="login_card.btn_label" value="<?php echo htmlspecialchars($pageData['login_card']['btn_label'] ?? 'Sign In to Client Portal'); ?>">
                        </div>
                        <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-top: 14px;">
                            <strong style="color: var(--forest-green); font-size: 12.5px; display: block; margin-bottom: 8px;">Trade Partner & Contractor Secondary Sign In</strong>
                            <div class="cms-form-group">
                                <label class="cms-label">Button Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="login_card.contractor_btn_label" value="<?php echo htmlspecialchars($pageData['login_card']['contractor_btn_label'] ?? 'Trade Partner & Contractor Sign In'); ?>">
                            </div>
                            <div class="cms-form-group" style="margin-bottom: 0;">
                                <label class="cms-label">Contractor Portal URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="login_card.contractor_portal_url" value="<?php echo htmlspecialchars($pageData['login_card']['contractor_portal_url'] ?? 'https://crm.justsmartchoice.com/authentication/admin_login'); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Portal Features -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-shield-halved" style="color: var(--forest-green);"></i> Portal Features (3 Items)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php 
                        $pFeats = $pageData['features'] ?? [];
                        foreach ($pFeats as $pfIdx => $pf):
                        ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 6px;">
                                    <div style="width: 130px;">
                                        <label class="cms-label">FontAwesome Icon</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="features.<?php echo $pfIdx; ?>.icon" value="<?php echo htmlspecialchars($pf['icon'] ?? ''); ?>" placeholder="fa-solid fa-check">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">Feature Title</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="features.<?php echo $pfIdx; ?>.title" value="<?php echo htmlspecialchars($pf['title'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="cms-form-group" style="margin-bottom: 0;">
                                    <label class="cms-label">Description</label>
                                    <textarea class="cms-textarea cms-bindable" data-field="features.<?php echo $pfIdx; ?>.description" rows="2"><?php echo htmlspecialchars($pf['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 4. Support Desk & Contact Info -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-headset" style="color: var(--forest-green);"></i> Support Desk & Help Info</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="support.heading" value="<?php echo htmlspecialchars($pageData['support']['heading'] ?? 'Need Assistance Accessing Your Project?'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Help Description Text</label>
                            <textarea class="cms-textarea cms-bindable" data-field="support.text" rows="2"><?php echo htmlspecialchars($pageData['support']['text'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 12px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Display Phone</label>
                                <input type="text" class="cms-input cms-bindable" data-field="support.phone" value="<?php echo htmlspecialchars($pageData['support']['phone'] ?? '(727) 755-3786'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Raw Phone (tel: link)</label>
                                <input type="text" class="cms-input cms-bindable" data-field="support.phone_raw" value="<?php echo htmlspecialchars($pageData['support']['phone_raw'] ?? '+17277553786'); ?>">
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Support Email Address</label>
                                <input type="text" class="cms-input cms-bindable" data-field="support.email" value="<?php echo htmlspecialchars($pageData['support']['email'] ?? 'support@justsmartchoice.com'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Business Hours</label>
                                <input type="text" class="cms-input cms-bindable" data-field="support.hours" value="<?php echo htmlspecialchars($pageData['support']['hours'] ?? 'Monday - Friday: 8:00 AM - 5:00 PM EST'); ?>">
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'career'): ?>
                <!-- ========================================================
                     CAREER PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero & Mission -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-briefcase" style="color: var(--forest-green);"></i> Career Hero & Mission</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.eyebrow" value="<?php echo htmlspecialchars($pageData['hero']['eyebrow'] ?? 'Careers at Just Smart Choice'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Join Our Team & Build With Pride'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Mission Paragraph 1</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p1" rows="3"><?php echo htmlspecialchars($pageData['hero']['p1'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Mission Paragraph 2</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p2" rows="3"><?php echo htmlspecialchars($pageData['hero']['p2'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Mission Paragraph 3</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.p3" rows="3"><?php echo htmlspecialchars($pageData['hero']['p3'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Apply Button Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="hero.apply_btn_label" value="<?php echo htmlspecialchars($pageData['hero']['apply_btn_label'] ?? 'Apply Now / Submit Resume'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Apply Button URL</label>
                                <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="hero.apply_btn_url" value="<?php echo htmlspecialchars($pageData['hero']['apply_btn_url'] ?? '#positions'); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Open Positions List -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-user-plus" style="color: var(--forest-green);"></i> Open Positions (<?php echo count($pageData['positions_section']['positions'] ?? []); ?> Roles)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Badge</label>
                            <input type="text" class="cms-input cms-bindable" data-field="positions_section.badge" value="<?php echo htmlspecialchars($pageData['positions_section']['badge'] ?? 'Current Opportunities'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="positions_section.title" value="<?php echo htmlspecialchars($pageData['positions_section']['title'] ?? 'Open Positions in Tampa Bay'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="positions_section.description" rows="2"><?php echo htmlspecialchars($pageData['positions_section']['description'] ?? ''); ?></textarea>
                        </div>
                        <?php foreach (($pageData['positions_section']['positions'] ?? []) as $posIdx => $pos): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 6px;">
                                    <div style="flex: 2;">
                                        <label class="cms-label">Role #<?php echo ($posIdx + 1); ?> Title</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="positions_section.positions.<?php echo $posIdx; ?>.title" value="<?php echo htmlspecialchars($pos['title'] ?? ''); ?>">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">Department / Trade</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="positions_section.positions.<?php echo $posIdx; ?>.dept" value="<?php echo htmlspecialchars($pos['dept'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="cms-form-group">
                                    <label class="cms-label">Application URL</label>
                                    <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="positions_section.positions.<?php echo $posIdx; ?>.apply_url" value="<?php echo htmlspecialchars($pos['apply_url'] ?? 'contacts.php'); ?>">
                                </div>
                                <div>
                                    <label class="cms-label">Bullet Requirements</label>
                                    <?php foreach (($pos['bullets'] ?? []) as $bIdx => $bullet): ?>
                                        <div style="margin-bottom: 4px;">
                                            <input type="text" class="cms-input cms-bindable" data-field="positions_section.positions.<?php echo $posIdx; ?>.bullets.<?php echo $bIdx; ?>" value="<?php echo htmlspecialchars($bullet); ?>" style="font-size: 12px; padding: 5px 8px;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. Locations & Culture Pillars -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-map-pin" style="color: var(--forest-green);"></i> Hiring Locations & Culture</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Locations Section Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="locations_section.title" value="<?php echo htmlspecialchars($pageData['locations_section']['title'] ?? 'Where We Hire & Work'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Locations Lead Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="locations_section.lead" rows="2"><?php echo htmlspecialchars($pageData['locations_section']['lead'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Why Work Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="why_work.title" value="<?php echo htmlspecialchars($pageData['why_work']['title'] ?? 'Why Build Your Career With Us?'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Why Work Lead</label>
                            <textarea class="cms-textarea cms-bindable" data-field="why_work.lead" rows="2"><?php echo htmlspecialchars($pageData['why_work']['lead'] ?? ''); ?></textarea>
                        </div>
                        <label class="cms-label" style="margin-top: 10px;">Culture Pillars (4 Cards)</label>
                        <?php foreach (($pageData['why_work']['cards'] ?? []) as $wwIdx => $wwCard): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <div style="width: 120px;">
                                        <input type="text" class="cms-input cms-bindable" data-field="why_work.cards.<?php echo $wwIdx; ?>.icon" value="<?php echo htmlspecialchars($wwCard['icon'] ?? ''); ?>" placeholder="fa-solid fa-trophy">
                                    </div>
                                    <div style="flex: 1;">
                                        <input type="text" class="cms-input cms-bindable" data-field="why_work.cards.<?php echo $wwIdx; ?>.title" value="<?php echo htmlspecialchars($wwCard['title'] ?? ''); ?>" style="font-weight: 700;">
                                    </div>
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="why_work.cards.<?php echo $wwIdx; ?>.description" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($wwCard['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'partners'): ?>
                <!-- ========================================================
                     PARTNERS PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero & Notice -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-handshake" style="color: var(--forest-green);"></i> Partners Hero & Notice</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Page Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Partners & Network'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Lead Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.lead" rows="2"><?php echo htmlspecialchars($pageData['hero']['lead'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Notice Box Paragraph</label>
                            <textarea class="cms-textarea cms-bindable" data-field="content_paragraphs.lead_notice" rows="3"><?php echo htmlspecialchars($pageData['content_paragraphs']['lead_notice'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Content & Compliance Standards -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-file-contract" style="color: var(--forest-green);"></i> Detailed Partnership Standards (10 Sections)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php for ($p = 1; $p <= 10; $p++): $pkey = "p{$p}"; ?>
                            <div class="cms-form-group">
                                <label class="cms-label">Standard Section #<?php echo $p; ?></label>
                                <textarea class="cms-textarea cms-bindable" data-field="content_paragraphs.<?php echo $pkey; ?>" rows="3"><?php echo htmlspecialchars($pageData['content_paragraphs'][$pkey] ?? ''); ?></textarea>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- 3. Counties & Municipalities Served -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-map-location-dot" style="color: var(--forest-green);"></i> Service Area & Municipalities (<?php echo count($pageData['counties_cities']['items'] ?? []); ?> Chips)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Sidebar Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="counties_cities.title" value="<?php echo htmlspecialchars($pageData['counties_cities']['title'] ?? 'Counties & Municipalities Served'); ?>">
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px;">
                            <?php foreach (($pageData['counties_cities']['items'] ?? []) as $cIdx => $cItem): ?>
                                <div>
                                    <input type="text" class="cms-input cms-bindable" data-field="counties_cities.items.<?php echo $cIdx; ?>" value="<?php echo htmlspecialchars($cItem); ?>" style="font-size: 12px; padding: 5px 8px;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 4. Suppliers & Material Partners -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-boxes-stacked" style="color: var(--forest-green);"></i> Material Brands & Suppliers (<?php echo count($pageData['suppliers_vendors']['brands'] ?? []); ?> Brands)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Suppliers Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="suppliers_vendors.title" value="<?php echo htmlspecialchars($pageData['suppliers_vendors']['title'] ?? 'Material & Equipment Brands We Install'); ?>">
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                            <?php foreach (($pageData['suppliers_vendors']['brands'] ?? []) as $bIdx => $brand): ?>
                                <div style="display: flex; gap: 6px; background: #f8fafc; padding: 6px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                    <input type="text" class="cms-input cms-bindable" data-field="suppliers_vendors.brands.<?php echo $bIdx; ?>.name" value="<?php echo htmlspecialchars($brand['name'] ?? ''); ?>" style="flex: 2; font-size: 12px; padding: 4px 6px;">
                                    <input type="color" class="cms-bindable" data-field="suppliers_vendors.brands.<?php echo $bIdx; ?>.color" value="<?php echo htmlspecialchars($brand['color'] ?? '#1fa463'); ?>" style="width: 38px; height: 32px; border: none; padding: 0; cursor: pointer; border-radius: 4px;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'investors'): ?>
                <!-- ========================================================
                     INVESTORS PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero & Opportunity -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-chart-line" style="color: var(--forest-green);"></i> Investors Hero & Opportunity</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Page Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Investor Relations'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Lead Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.lead" rows="2"><?php echo htmlspecialchars($pageData['hero']['lead'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Opportunity Callout</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.callout" rows="2"><?php echo htmlspecialchars($pageData['hero']['callout'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. How to Invest Steps -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-stairs" style="color: var(--forest-green);"></i> How to Invest Process (3 Steps)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="how_to_invest.title" value="<?php echo htmlspecialchars($pageData['how_to_invest']['title'] ?? 'How to Invest with Just Smart Choice'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Section Lead</label>
                            <textarea class="cms-textarea cms-bindable" data-field="how_to_invest.lead" rows="2"><?php echo htmlspecialchars($pageData['how_to_invest']['lead'] ?? ''); ?></textarea>
                        </div>
                        <?php foreach (($pageData['how_to_invest']['steps'] ?? []) as $sIdx => $st): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 10px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 6px;">
                                    <div style="width: 70px;">
                                        <input type="text" class="cms-input cms-bindable" data-field="how_to_invest.steps.<?php echo $sIdx; ?>.step_num" value="<?php echo htmlspecialchars($st['step_num'] ?? 'Step ' . ($sIdx + 1)); ?>" style="font-weight: 700;">
                                    </div>
                                    <div style="flex: 1;">
                                        <input type="text" class="cms-input cms-bindable" data-field="how_to_invest.steps.<?php echo $sIdx; ?>.title" value="<?php echo htmlspecialchars($st['title'] ?? ''); ?>" style="font-weight: 700;">
                                    </div>
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="how_to_invest.steps.<?php echo $sIdx; ?>.description" rows="2"><?php echo htmlspecialchars($st['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. Investor Benefits & Financial Transparency -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-gem" style="color: var(--forest-green);"></i> Benefits & Transparency Highlights</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Benefits Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="investor_benefits.title" value="<?php echo htmlspecialchars($pageData['investor_benefits']['title'] ?? 'Investor Benefits'); ?>">
                        </div>
                        <?php foreach (($pageData['investor_benefits']['cards'] ?? []) as $ibIdx => $ib): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="investor_benefits.cards.<?php echo $ibIdx; ?>.icon" value="<?php echo htmlspecialchars($ib['icon'] ?? ''); ?>" style="width: 120px;" placeholder="fa-solid fa-shield-halved">
                                    <input type="text" class="cms-input cms-bindable" data-field="investor_benefits.cards.<?php echo $ibIdx; ?>.title" value="<?php echo htmlspecialchars($ib['title'] ?? ''); ?>" style="flex: 1; font-weight: 700;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="investor_benefits.cards.<?php echo $ibIdx; ?>.description" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($ib['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'faqs'): ?>
                <!-- ========================================================
                     FAQS PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero Banner -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-circle-question" style="color: var(--forest-green);"></i> FAQ Hero Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Badge</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.badge" value="<?php echo htmlspecialchars($pageData['hero']['badge'] ?? 'Frequently Asked Questions'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Main Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Answers to Common Questions'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle" rows="2"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Accordion Groups & Questions -->
                <?php foreach (($pageData['groups'] ?? []) as $gIdx => $grp): ?>
                    <div class="cms-section-panel">
                        <div class="cms-section-head">
                            <h3><i class="fa-solid fa-folder-open" style="color: var(--forest-green);"></i> FAQ Group: <?php echo htmlspecialchars($grp['title'] ?? 'Group ' . ($gIdx + 1)); ?> (<?php echo count($grp['items'] ?? []); ?> Q&A)</h3>
                            <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                        </div>
                        <div class="cms-section-body">
                            <div class="cms-form-group">
                                <label class="cms-label">Group Title</label>
                                <input type="text" class="cms-input cms-bindable" data-field="groups.<?php echo $gIdx; ?>.title" value="<?php echo htmlspecialchars($grp['title'] ?? ''); ?>">
                            </div>
                            <div class="cms-form-group">
                                <label class="cms-label">Group Subtitle</label>
                                <input type="text" class="cms-input cms-bindable" data-field="groups.<?php echo $gIdx; ?>.subtitle" value="<?php echo htmlspecialchars($grp['subtitle'] ?? ''); ?>">
                            </div>
                            <?php foreach (($grp['items'] ?? []) as $iIdx => $item): ?>
                                <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                    <div class="cms-form-group">
                                        <label class="cms-label">Question #<?php echo ($iIdx + 1); ?></label>
                                        <input type="text" class="cms-input cms-bindable" data-field="groups.<?php echo $gIdx; ?>.items.<?php echo $iIdx; ?>.question" value="<?php echo htmlspecialchars($item['question'] ?? ''); ?>" style="font-weight: 700;">
                                    </div>
                                    <div class="cms-form-group" style="margin-bottom: 0;">
                                        <label class="cms-label">Answer</label>
                                        <textarea class="cms-textarea cms-bindable" data-field="groups.<?php echo $gIdx; ?>.items.<?php echo $iIdx; ?>.answer" rows="3"><?php echo htmlspecialchars($item['answer'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php elseif ($pageSlug === 'forms'): ?>
                <!-- ========================================================
                     FORMS PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero Banner -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-file-pdf" style="color: var(--forest-green);"></i> Forms Hero Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Badge</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.badge" value="<?php echo htmlspecialchars($pageData['hero']['badge'] ?? 'Official Documents'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Main Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Forms & Permitting Library'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle" rows="2"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Notice of Commencement Section -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-stamp" style="color: var(--forest-green);"></i> County NOC Packets (4 Counties)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">NOC Section Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="noc_section.title" value="<?php echo htmlspecialchars($pageData['noc_section']['title'] ?? 'Notice of Commencement by County'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">NOC Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="noc_section.description" rows="2"><?php echo htmlspecialchars($pageData['noc_section']['description'] ?? ''); ?></textarea>
                        </div>
                        <?php foreach (($pageData['noc_section']['counties'] ?? []) as $ncIdx => $nc): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 12px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 6px;">
                                    <div style="flex: 1;">
                                        <label class="cms-label">County Name</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="noc_section.counties.<?php echo $ncIdx; ?>.county" value="<?php echo htmlspecialchars($nc['county'] ?? ''); ?>">
                                    </div>
                                    <div style="flex: 2;">
                                        <label class="cms-label">Recording Instructions</label>
                                        <input type="text" class="cms-input cms-bindable" data-field="noc_section.counties.<?php echo $ncIdx; ?>.instructions" value="<?php echo htmlspecialchars($nc['instructions'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div style="display: flex; gap: 10px;">
                                    <div style="flex: 1;">
                                        <label class="cms-label">Official Recording URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="noc_section.counties.<?php echo $ncIdx; ?>.record_url" value="<?php echo htmlspecialchars($nc['record_url'] ?? ''); ?>">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="cms-label">PDF / Form URL</label>
                                        <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="noc_section.counties.<?php echo $ncIdx; ?>.pdf_url" value="<?php echo htmlspecialchars($nc['pdf_url'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. Smart Choice Standard Checklist Forms -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-list-check" style="color: var(--forest-green);"></i> Smart Choice Checklists (<?php echo count($pageData['smart_choice_forms']['checklist'] ?? []); ?> Forms)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Checklist Section Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="smart_choice_forms.title" value="<?php echo htmlspecialchars($pageData['smart_choice_forms']['title'] ?? 'Smart Choice Project Checklists'); ?>">
                        </div>
                        <?php foreach (($pageData['smart_choice_forms']['checklist'] ?? []) as $scIdx => $sc): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="smart_choice_forms.checklist.<?php echo $scIdx; ?>.name" value="<?php echo htmlspecialchars($sc['name'] ?? ''); ?>" style="flex: 2; font-weight: 700;">
                                    <input type="text" class="cms-input cms-bindable" data-field="smart_choice_forms.checklist.<?php echo $scIdx; ?>.tag" value="<?php echo htmlspecialchars($sc['tag'] ?? 'PDF'); ?>" style="width: 80px;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="smart_choice_forms.checklist.<?php echo $scIdx; ?>.desc" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($sc['desc'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'appointment'): ?>
                <!-- ========================================================
                     APPOINTMENT PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero Banner with WebP Control -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-calendar-days" style="color: var(--forest-green);"></i> Appointment Hero Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.eyebrow" value="<?php echo htmlspecialchars($pageData['hero']['eyebrow'] ?? 'Schedule Consultation'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Main Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Book Your Construction Consultation'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle" rows="2"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <?php echo renderCmsImageControl("hero.bg_image", "Hero Background Image (auto-WebP)", $pageData['hero']['bg_image'] ?? 'images/slides/slide-03-2050x610.jpg'); ?>
                    </div>
                </div>

                <!-- 2. Booking Card & Actions -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-clock" style="color: var(--forest-green);"></i> Booking Card & Direct Scheduling</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Card Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="appointment_card.title" value="<?php echo htmlspecialchars($pageData['appointment_card']['title'] ?? 'Online Appointment Booking'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Card Description</label>
                            <textarea class="cms-textarea cms-bindable" data-field="appointment_card.description" rows="3"><?php echo htmlspecialchars($pageData['appointment_card']['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">CRM Online Booking URL</label>
                            <input type="text" class="cms-input cms-bindable" data-value-type="link" data-field="appointment_card.booking_url" value="<?php echo htmlspecialchars($pageData['appointment_card']['booking_url'] ?? 'https://crm.justsmartchoice.com/products/clientes'); ?>">
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">Button Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="appointment_card.button_label" value="<?php echo htmlspecialchars($pageData['appointment_card']['button_label'] ?? 'Launch Online Appointment Calendar'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">Phone Label</label>
                                <input type="text" class="cms-input cms-bindable" data-field="appointment_card.phone_label" value="<?php echo htmlspecialchars($pageData['appointment_card']['phone_label'] ?? 'Call To Book: (727) 755-3786'); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Consultation Preparation Steps -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-list-ol" style="color: var(--forest-green);"></i> Preparation Steps (4 Steps)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php foreach (($pageData['steps'] ?? []) as $stIdx => $st): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="steps.<?php echo $stIdx; ?>.icon" value="<?php echo htmlspecialchars($st['icon'] ?? ''); ?>" style="width: 120px;" placeholder="fa-solid fa-calendar">
                                    <input type="text" class="cms-input cms-bindable" data-field="steps.<?php echo $stIdx; ?>.title" value="<?php echo htmlspecialchars($st['title'] ?? ''); ?>" style="flex: 1; font-weight: 700;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="steps.<?php echo $stIdx; ?>.description" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($st['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'new-project-process'): ?>
                <!-- ========================================================
                     NEW PROJECT PROCESS PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Header Banner -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-diagram-project" style="color: var(--forest-green);"></i> Project Process Header</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Process Badge</label>
                            <input type="text" class="cms-input cms-bindable" data-field="header.badge" value="<?php echo htmlspecialchars($pageData['header']['badge'] ?? 'Standard Operating Procedure'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Process Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="header.title" value="<?php echo htmlspecialchars($pageData['header']['title'] ?? 'New Project Intake & Permitting Workflow'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Process Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="header.subtitle" rows="2"><?php echo htmlspecialchars($pageData['header']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Notice Email Recipients</label>
                            <input type="text" class="cms-input cms-bindable" data-field="header.notice_recipients" value="<?php echo htmlspecialchars($pageData['header']['notice_recipients'] ?? 'support@justsmartchoice.com, permits@justsmartchoice.com'); ?>">
                        </div>
                    </div>
                </div>

                <!-- 2. Telegram Initiation Steps -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-brands fa-telegram" style="color: var(--forest-green);"></i> Telegram Initiation (3 Steps)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php foreach (($pageData['telegram_steps'] ?? []) as $tgIdx => $tg): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="telegram_steps.<?php echo $tgIdx; ?>.number" value="<?php echo htmlspecialchars($tg['number'] ?? '0' . ($tgIdx + 1)); ?>" style="width: 60px; font-weight: 700;">
                                    <input type="text" class="cms-input cms-bindable" data-field="telegram_steps.<?php echo $tgIdx; ?>.title" value="<?php echo htmlspecialchars($tg['title'] ?? ''); ?>" style="flex: 1; font-weight: 700;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="telegram_steps.<?php echo $tgIdx; ?>.description" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($tg['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. CRM & Permitting Execution Steps -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-tasks" style="color: var(--forest-green);"></i> CRM & Permitting Execution (12 Steps)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php foreach (($pageData['crm_steps'] ?? []) as $crIdx => $cr): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="crm_steps.<?php echo $crIdx; ?>.number" value="<?php echo htmlspecialchars($cr['number'] ?? '0' . ($crIdx + 1)); ?>" style="width: 60px; font-weight: 700;">
                                    <input type="text" class="cms-input cms-bindable" data-field="crm_steps.<?php echo $crIdx; ?>.title" value="<?php echo htmlspecialchars($cr['title'] ?? ''); ?>" style="flex: 1; font-weight: 700;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="crm_steps.<?php echo $crIdx; ?>.description" rows="2" style="font-size: 12px; margin-bottom: 4px;"><?php echo htmlspecialchars($cr['description'] ?? ''); ?></textarea>
                                <input type="text" class="cms-input cms-bindable" data-field="crm_steps.<?php echo $crIdx; ?>.detail" value="<?php echo htmlspecialchars($cr['detail'] ?? ''); ?>" style="font-size: 11.5px; color: #475569;" placeholder="Responsible role / compliance detail">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'permitstatus'): ?>
                <!-- ========================================================
                     PERMIT STATUS & LOOKUP PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero Banner with WebP Control -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-map-location-dot" style="color: var(--forest-green);"></i> Permit Lookup Hero Banner</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.eyebrow" value="<?php echo htmlspecialchars($pageData['hero']['eyebrow'] ?? 'Florida Building Department Directory'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Florida Permit & Inspection Lookup Portal'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle" rows="2"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <?php echo renderCmsImageControl("hero.bg_image", "Hero Background Image (auto-WebP)", $pageData['hero']['bg_image'] ?? 'images/slides/slide-01-2050x610.jpg'); ?>
                    </div>
                </div>

                <!-- 2. Portal Card Labels -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-sliders" style="color: var(--forest-green);"></i> Portal Lookup Card Settings</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Card Heading</label>
                            <input type="text" class="cms-input cms-bindable" data-field="portal_card.heading" value="<?php echo htmlspecialchars($pageData['portal_card']['heading'] ?? 'Permit / Inspection Lookup'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Instructions Text</label>
                            <textarea class="cms-textarea cms-bindable" data-field="portal_card.instruction" rows="2"><?php echo htmlspecialchars($pageData['portal_card']['instruction'] ?? ''); ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <label class="cms-label">County Placeholder</label>
                                <input type="text" class="cms-input cms-bindable" data-field="portal_card.county_placeholder" value="<?php echo htmlspecialchars($pageData['portal_card']['county_placeholder'] ?? 'Select County (All 67 Florida Counties)'); ?>">
                            </div>
                            <div style="flex: 1;">
                                <label class="cms-label">City Placeholder</label>
                                <input type="text" class="cms-input cms-bindable" data-field="portal_card.city_placeholder" value="<?php echo htmlspecialchars($pageData['portal_card']['city_placeholder'] ?? 'Select City / Municipality (Optional)'); ?>">
                            </div>
                        </div>
                        <div class="cms-form-group" style="margin-top: 10px;">
                            <label class="cms-label">Lookup Button Label</label>
                            <input type="text" class="cms-input cms-bindable" data-field="portal_card.button_label" value="<?php echo htmlspecialchars($pageData['portal_card']['button_label'] ?? 'Open Official Building Department Portal'); ?>">
                        </div>
                    </div>
                </div>

                <!-- 3. Guidance Cards -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-info-circle" style="color: var(--forest-green);"></i> Inspection Guidance (3 Cards)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php foreach (($pageData['guidance_cards'] ?? []) as $gcIdx => $gc): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="guidance_cards.<?php echo $gcIdx; ?>.icon" value="<?php echo htmlspecialchars($gc['icon'] ?? ''); ?>" style="width: 120px;" placeholder="fa-solid fa-file">
                                    <input type="text" class="cms-input cms-bindable" data-field="guidance_cards.<?php echo $gcIdx; ?>.title" value="<?php echo htmlspecialchars($gc['title'] ?? ''); ?>" style="flex: 1; font-weight: 700;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="guidance_cards.<?php echo $gcIdx; ?>.description" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($gc['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($pageSlug === 'notice-of-commencement'): ?>
                <!-- ========================================================
                     NOTICE OF COMMENCEMENT PAGE SPECIFIC SECTIONS
                     ======================================================== -->
                <!-- 1. Hero Banner with WebP Control -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-landmark" style="color: var(--forest-green);"></i> Notice of Commencement Hero</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Eyebrow</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.eyebrow" value="<?php echo htmlspecialchars($pageData['hero']['eyebrow'] ?? 'Florida Statute § 713.13 Compliance Guide'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Title</label>
                            <input type="text" class="cms-input cms-bindable" data-field="hero.title" value="<?php echo htmlspecialchars($pageData['hero']['title'] ?? 'Florida Notice of Commencement (NOC) Resource Center'); ?>">
                        </div>
                        <div class="cms-form-group">
                            <label class="cms-label">Hero Subtitle</label>
                            <textarea class="cms-textarea cms-bindable" data-field="hero.subtitle" rows="2"><?php echo htmlspecialchars($pageData['hero']['subtitle'] ?? ''); ?></textarea>
                        </div>
                        <?php echo renderCmsImageControl("hero.bg_image", "Hero Background Image (auto-WebP)", $pageData['hero']['bg_image'] ?? 'images/slides/slide-02-2050x610.jpg'); ?>
                    </div>
                </div>

                <!-- 2. Florida Statute Threshold Cards -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-scale-balanced" style="color: var(--forest-green);"></i> Statutory Thresholds (3 Cards)</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <?php foreach (($pageData['statute_cards'] ?? []) as $stIdx => $st): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 10px; margin-bottom: 8px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="statute_cards.<?php echo $stIdx; ?>.badge" value="<?php echo htmlspecialchars($st['badge'] ?? ''); ?>" style="width: 100px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="statute_cards.<?php echo $stIdx; ?>.threshold" value="<?php echo htmlspecialchars($st['threshold'] ?? ''); ?>" style="width: 100px; font-weight: 700;">
                                    <input type="text" class="cms-input cms-bindable" data-field="statute_cards.<?php echo $stIdx; ?>.title" value="<?php echo htmlspecialchars($st['title'] ?? ''); ?>" style="flex: 1; font-weight: 700;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="statute_cards.<?php echo $stIdx; ?>.description" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($st['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. NOC Process Steps & FAQs -->
                <div class="cms-section-panel">
                    <div class="cms-section-head">
                        <h3><i class="fa-solid fa-list-check" style="color: var(--forest-green);"></i> 4-Step Process & FAQs</h3>
                        <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="cms-section-body">
                        <label class="cms-label">4-Step Recording Process</label>
                        <?php foreach (($pageData['steps'] ?? []) as $sIdx => $st): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 8px; margin-bottom: 6px;">
                                <div style="display: flex; gap: 8px; margin-bottom: 4px;">
                                    <input type="text" class="cms-input cms-bindable" data-field="steps.<?php echo $sIdx; ?>.number" value="<?php echo htmlspecialchars($st['number'] ?? '0' . ($sIdx + 1)); ?>" style="width: 50px; font-weight: 700;">
                                    <input type="text" class="cms-input cms-bindable" data-field="steps.<?php echo $sIdx; ?>.title" value="<?php echo htmlspecialchars($st['title'] ?? ''); ?>" style="flex: 1; font-weight: 700;">
                                </div>
                                <textarea class="cms-textarea cms-bindable" data-field="steps.<?php echo $sIdx; ?>.description" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($st['description'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>

                        <label class="cms-label" style="margin-top: 14px;">Frequently Asked Questions</label>
                        <?php foreach (($pageData['faqs'] ?? []) as $fIdx => $faq): ?>
                            <div style="background: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 8px; margin-bottom: 6px;">
                                <input type="text" class="cms-input cms-bindable" data-field="faqs.<?php echo $fIdx; ?>.question" value="<?php echo htmlspecialchars($faq['question'] ?? ''); ?>" style="font-weight: 700; margin-bottom: 4px;">
                                <textarea class="cms-textarea cms-bindable" data-field="faqs.<?php echo $fIdx; ?>.answer" rows="2" style="font-size: 12px;"><?php echo htmlspecialchars($faq['answer'] ?? ''); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php else: ?>
                <!-- GENERIC FALLBACK FOR ANY OTHER CUSTOM SECTION -->
                <?php foreach ($pageData as $secKey => $secVal): 
                    if ($secKey === 'seo') continue;
                ?>
                    <div class="cms-section-panel">
                        <div class="cms-section-head">
                            <h3><i class="fa-solid fa-pen" style="color: var(--forest-green);"></i> <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $secKey))); ?></h3>
                            <i class="fa-solid fa-chevron-down cms-section-toggle-icon" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                        </div>
                        <div class="cms-section-body">
                            <?php if (is_array($secVal)): ?>
                                <?php foreach ($secVal as $subKey => $subVal): ?>
                                    <?php if (is_string($subVal)): ?>
                                        <?php if (preg_match('/(image|photo|logo|img|bg_image)/i', $subKey)): ?>
                                            <?php echo renderCmsImageControl("{$secKey}.{$subKey}", ucwords(str_replace('_', ' ', $subKey)), $subVal); ?>
                                        <?php elseif (strlen($subVal) > 60 || strpos($subKey, 'body') !== false || strpos($subKey, 'desc') !== false): ?>
                                            <div class="cms-form-group">
                                                <label class="cms-label"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $subKey))); ?></label>
                                                <textarea class="cms-textarea cms-bindable" data-field="<?php echo "{$secKey}.{$subKey}"; ?>"><?php echo htmlspecialchars($subVal); ?></textarea>
                                            </div>
                                        <?php else: ?>
                                            <div class="cms-form-group">
                                                <label class="cms-label"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $subKey))); ?></label>
                                                <input type="text" class="cms-input cms-bindable" data-field="<?php echo "{$secKey}.{$subKey}"; ?>" value="<?php echo htmlspecialchars($subVal); ?>">
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php elseif (is_string($secVal)): ?>
                                <div class="cms-form-group">
                                    <label class="cms-label"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $secKey))); ?></label>
                                    <textarea class="cms-textarea cms-bindable" data-field="<?php echo $secKey; ?>"><?php echo htmlspecialchars($secVal); ?></textarea>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </form>
    </div>

    <!-- RIGHT PANE: Interactive Real-Time Live Preview -->
    <div class="cms-preview-pane">
        <!-- Preview Toolbar -->
        <div class="cms-preview-toolbar">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span class="cms-badge cms-badge-green" style="font-size: 11px;">
                    <i class="fa-solid fa-circle" style="font-size: 7px;"></i> Live Preview
                </span>
                <span style="color: #94a3b8; font-size: 11.5px;">Updates instantly as you edit</span>
            </div>

            <!-- Viewport Switcher -->
            <div class="cms-preview-viewport-toggle">
                <button type="button" class="cms-viewport-btn active" data-viewport="desktop" title="Desktop view (100%)">
                    <i class="fa-solid fa-desktop"></i> Desktop
                </button>
                <button type="button" class="cms-viewport-btn" data-viewport="laptop" title="Laptop view (1024px)">
                    <i class="fa-solid fa-laptop"></i> Laptop
                </button>
                <button type="button" class="cms-viewport-btn" data-viewport="tablet" title="Tablet view (768px)">
                    <i class="fa-solid fa-tablet-screen-button"></i> Tablet
                </button>
                <button type="button" class="cms-viewport-btn" data-viewport="mobile" title="Mobile view (375px)">
                    <i class="fa-solid fa-mobile-screen"></i> Mobile
                </button>
            </div>

            <div style="display: flex; gap: 6px;">
                <button type="button" id="refreshPreviewBtn" class="cms-btn cms-btn-outline cms-btn-sm" style="background: #334155; border-color: #475569; color: #fff; padding: 3px 8px;" title="Reload preview frame">
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                </button>
                <a href="preview.php?page=<?php echo urlencode($pageSlug); ?>" target="_blank" class="cms-btn cms-btn-outline cms-btn-sm" style="background: #334155; border-color: #475569; color: #fff; padding: 3px 8px;" title="Open preview in full window">
                    <i class="fa-solid fa-up-right-from-square"></i>
                </a>
            </div>
        </div>

        <!-- Preview Stage -->
        <div class="cms-preview-stage">
            <div class="cms-preview-frame-wrap" id="previewFrameWrap" data-viewport="desktop">
                <iframe id="cmsPreviewIframe" class="cms-preview-frame" src="preview.php?page=<?php echo urlencode($pageSlug); ?>"></iframe>
            </div>
        </div>
    </div>

</div>

<!-- Media Picker Modal -->
<div id="cmsMediaPickerModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 999999; align-items: center; justify-content: center;">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 90%; max-width: 780px; max-height: 80vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong style="font-size: 15px; color: var(--text-dark);"><i class="fa-regular fa-images" style="color: var(--forest-green);"></i> Select Image Asset</strong>
            <button type="button" onclick="cmsCloseImagePicker()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); background: #fafbfc; display: flex; justify-content: space-between; align-items: center;">
            <input type="file" id="modalImageUploadInput" style="display: none;" onchange="cmsUploadImageFromModal(this)">
            <button type="button" class="cms-btn cms-btn-primary cms-btn-sm" onclick="document.getElementById('modalImageUploadInput').click()">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload New File
            </button>
            <span style="font-size: 12px; color: var(--text-muted);">Auto-converts to WebP</span>
        </div>
        <div id="modalImageList" style="padding: 20px; overflow-y: auto; flex: 1; display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 12px;">
            <!-- Loaded dynamically -->
        </div>
    </div>
</div>

<script>
let activePickerContext = {
    targetInputId: null,
    thumbId: null,
    placeholderId: null,
    badgeId: null,
    nameId: null
};

// 1. Direct File Upload with Instant WebP Conversion & Live Sync
function cmsDirectUpload(input, targetInputId, thumbId, placeholderId, badgeId, nameId) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const formData = new FormData();
    formData.append('file', file);
    formData.append('csrf_token', document.getElementById('csrfToken').value);

    const thumb = document.getElementById(thumbId);
    if (thumb) thumb.style.opacity = '0.3';

    fetch('api.php?action=upload_media', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if (thumb) thumb.style.opacity = '1';
        if (res.success) {
            const target = document.getElementById(targetInputId);
            if (target) {
                target.value = res.url;
                target.dispatchEvent(new Event('input', { bubbles: true }));
            }
            if (thumb) {
                thumb.src = res.url.startsWith('/') ? res.url : ('/' + res.url);
                thumb.style.display = 'block';
            }
            const ph = document.getElementById(placeholderId);
            if (ph) ph.style.display = 'none';
            const badge = document.getElementById(badgeId);
            if (badge) badge.style.display = 'inline-flex';
            const nameEl = document.getElementById(nameId);
            if (nameEl) nameEl.textContent = res.url.split('/').pop();

            cmsToast('Image uploaded & optimized to WebP!');
        } else {
            alert('Upload error: ' + (res.error || 'Failed to upload image'));
        }
        input.value = '';
    })
    .catch(() => {
        if (thumb) thumb.style.opacity = '1';
        input.value = '';
        alert('Network error while uploading image.');
    });
}

// 2. Clear / Remove Image
function cmsClearImage(targetInputId, thumbId, placeholderId, badgeId, nameId) {
    const target = document.getElementById(targetInputId);
    if (target) {
        target.value = '';
        target.dispatchEvent(new Event('input', { bubbles: true }));
    }
    const thumb = document.getElementById(thumbId);
    if (thumb) {
        thumb.src = '';
        thumb.style.display = 'none';
    }
    const ph = document.getElementById(placeholderId);
    if (ph) ph.style.display = 'block';
    const badge = document.getElementById(badgeId);
    if (badge) badge.style.display = 'none';
    const nameEl = document.getElementById(nameId);
    if (nameEl) nameEl.textContent = 'No image selected';
}

// 3. Media Picker Modal
function cmsOpenImagePicker(targetInputId, thumbId, placeholderId, badgeId, nameId) {
    activePickerContext = { targetInputId, thumbId, placeholderId, badgeId, nameId };
    const modal = document.getElementById('cmsMediaPickerModal');
    modal.style.display = 'flex';
    cmsLoadModalImages();
}

function cmsCloseImagePicker() {
    document.getElementById('cmsMediaPickerModal').style.display = 'none';
    activePickerContext = { targetInputId: null, thumbId: null, placeholderId: null, badgeId: null, nameId: null };
}

function cmsLoadModalImages() {
    const list = document.getElementById('modalImageList');
    list.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: var(--text-muted); padding: 20px;">Loading library assets...</div>';

    fetch('media.php?format=json')
        .then(r => r.json())
        .then(images => {
            list.innerHTML = '';
            if (!images || images.length === 0) {
                list.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: var(--text-muted);">No images found.</div>';
                return;
            }
            images.forEach(img => {
                const item = document.createElement('div');
                item.style.border = '1px solid var(--border-subtle)';
                item.style.borderRadius = '6px';
                item.style.padding = '4px';
                item.style.cursor = 'pointer';
                item.style.transition = 'all 0.15s ease';
                item.style.textAlign = 'center';
                item.innerHTML = `<img src="${img.url}" style="width: 100%; height: 75px; object-fit: cover; border-radius: 4px;"><div style="font-size: 10px; color: var(--text-muted); margin-top: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${img.name}</div>`;
                item.onclick = () => {
                    if (activePickerContext.targetInputId) {
                        const input = document.getElementById(activePickerContext.targetInputId);
                        if (input) {
                            input.value = img.url;
                            input.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                        const thumb = document.getElementById(activePickerContext.thumbId);
                        if (thumb) {
                            thumb.src = img.url.startsWith('/') ? img.url : ('/' + img.url);
                            thumb.style.display = 'block';
                        }
                        const ph = document.getElementById(activePickerContext.placeholderId);
                        if (ph) ph.style.display = 'none';
                        const badge = document.getElementById(activePickerContext.badgeId);
                        if (badge) badge.style.display = img.url.endsWith('.webp') ? 'inline-flex' : 'none';
                        const nameEl = document.getElementById(activePickerContext.nameId);
                        if (nameEl) nameEl.textContent = img.name;
                    }
                    cmsCloseImagePicker();
                };
                list.appendChild(item);
            });
        })
        .catch(() => {
            list.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: #991b1b;">Error loading media library.</div>';
        });
}

function cmsUploadImageFromModal(input) {
    if (!input.files || !input.files[0]) return;
    const formData = new FormData();
    formData.append('file', input.files[0]);
    formData.append('csrf_token', document.getElementById('csrfToken').value);

    fetch('api.php?action=upload_media', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            if (activePickerContext.targetInputId) {
                const target = document.getElementById(activePickerContext.targetInputId);
                if (target) {
                    target.value = res.url;
                    target.dispatchEvent(new Event('input', { bubbles: true }));
                }
                const thumb = document.getElementById(activePickerContext.thumbId);
                if (thumb) {
                    thumb.src = res.url.startsWith('/') ? res.url : ('/' + res.url);
                    thumb.style.display = 'block';
                }
                const ph = document.getElementById(activePickerContext.placeholderId);
                if (ph) ph.style.display = 'none';
                const badge = document.getElementById(activePickerContext.badgeId);
                if (badge) badge.style.display = 'inline-flex';
                const nameEl = document.getElementById(activePickerContext.nameId);
                if (nameEl) nameEl.textContent = res.url.split('/').pop();
            }
            cmsToast('Image uploaded and optimized to WebP!');
            cmsCloseImagePicker();
        } else {
            alert('Upload error: ' + (res.error || 'Unknown error'));
        }
        input.value = '';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const iframe = document.getElementById('cmsPreviewIframe');
    const wrap = document.getElementById('previewFrameWrap');
    const form = document.getElementById('cmsPageEditorForm');
    const pageSlug = document.getElementById('currentPageSlug').value;
    const csrfToken = document.getElementById('csrfToken').value;

    // 1. Accordion Toggling
    document.querySelectorAll('.cms-section-head').forEach(head => {
        head.addEventListener('click', () => {
            const body = head.nextElementSibling;
            const icon = head.querySelector('.cms-section-toggle-icon');
            if (!body) return;
            const isClosed = body.style.display === 'none';
            body.style.display = isClosed ? 'block' : 'none';
            if (icon) {
                icon.style.transform = isClosed ? 'rotate(0deg)' : 'rotate(-90deg)';
            }
        });
    });

    // Toggle All Sections Button
    let allExpanded = true;
    const toggleAllBtn = document.getElementById('toggleAllSectionsBtn');
    if (toggleAllBtn) {
        toggleAllBtn.addEventListener('click', () => {
            allExpanded = !allExpanded;
            document.querySelectorAll('.cms-section-body').forEach(b => {
                b.style.display = allExpanded ? 'block' : 'none';
            });
            document.querySelectorAll('.cms-section-toggle-icon').forEach(icon => {
                icon.style.transform = allExpanded ? 'rotate(0deg)' : 'rotate(-90deg)';
            });
        });
    }

    // 2. Viewport Switcher
    document.querySelectorAll('.cms-viewport-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.cms-viewport-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            wrap.setAttribute('data-viewport', btn.getAttribute('data-viewport'));
        });
    });

    // Refresh Preview Frame
    document.getElementById('refreshPreviewBtn').addEventListener('click', () => {
        iframe.src = iframe.src;
    });

    // 3. Real-time Keystroke & Input Synchronization to Preview Iframe
    form.addEventListener('input', (e) => {
        const input = e.target.closest('.cms-bindable');
        if (!input) return;

        const fieldPath = input.getAttribute('data-field');
        const valueType = input.getAttribute('data-value-type') || 'text';
        const value = input.value;

        // Post message to preview iframe for instant DOM update
        if (iframe && iframe.contentWindow) {
            iframe.contentWindow.postMessage({
                type: 'cms:update_field',
                field: fieldPath,
                value: value,
                valueType: valueType
            }, '*');
        }

        // Auto-save draft in background (debounced 600ms)
        triggerAutoDraftSave();
    });

    let draftTimeout = null;
    function triggerAutoDraftSave() {
        clearTimeout(draftTimeout);
        draftTimeout = setTimeout(() => {
            const currentData = collectFormData();
            fetch('api.php?action=save_draft', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    page: pageSlug,
                    csrf_token: csrfToken,
                    data: JSON.stringify(currentData)
                })
            });
        }, 600);
    }

    // 4. Listen for clicks from preview iframe (Click-to-Edit)
    window.addEventListener('message', (event) => {
        const data = event.data;
        if (!data || data.type !== 'cms:element_clicked') return;

        const fieldPath = data.field;
        const matchingInput = form.querySelector(`[data-field="${fieldPath}"]`);
        if (matchingInput) {
            const panelBody = matchingInput.closest('.cms-section-body');
            if (panelBody && panelBody.style.display === 'none') {
                panelBody.style.display = 'block';
                const icon = panelBody.previousElementSibling ? panelBody.previousElementSibling.querySelector('.cms-section-toggle-icon') : null;
                if (icon) icon.style.transform = 'rotate(0deg)';
            }

            matchingInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            matchingInput.focus();
            matchingInput.classList.add('cms-field-highlight');
            setTimeout(() => matchingInput.classList.remove('cms-field-highlight'), 1600);
        }
    });

    // 5. Save & Publish
    document.getElementById('savePublishBtn').addEventListener('click', () => {
        const payload = collectFormData();
        const btn = document.getElementById('savePublishBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Publishing...';

        fetch('api.php?action=save_page', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                page: pageSlug,
                csrf_token: csrfToken,
                data: JSON.stringify(payload)
            })
        })
        .then(r => r.json())
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Save & Publish';
            if (res.success) {
                cmsToast('Page published live successfully!');
            } else {
                alert('Error publishing page: ' + (res.error || 'Unknown error'));
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Save & Publish';
            alert('Network error while publishing.');
        });
    });

    // 6. Discard Draft
    document.getElementById('discardDraftBtn').addEventListener('click', () => {
        if (!confirm('Are you sure you want to discard your unpublished preview changes?')) return;
        fetch('api.php?action=discard_draft', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                page: pageSlug,
                csrf_token: csrfToken
            })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                location.reload();
            }
        });
    });

    // Helper: collect form inputs into hierarchical JSON
    function collectFormData() {
        const result = JSON.parse(JSON.stringify(<?php echo json_encode($pageData); ?>));
        form.querySelectorAll('.cms-bindable').forEach(input => {
            const path = input.getAttribute('data-field');
            if (!path) return;
            const parts = path.split('.');
            let curr = result;
            for (let i = 0; i < parts.length - 1; i++) {
                const part = parts[i];
                if (!curr[part] || typeof curr[part] !== 'object') {
                    curr[part] = isNaN(parts[i+1]) ? {} : [];
                }
                curr = curr[part];
            }
            curr[parts[parts.length - 1]] = input.value;
        });
        return result;
    }
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
