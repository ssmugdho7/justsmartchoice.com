<?php
$pageTitle = 'FAQ Manager';
$breadcrumb = 'FAQ Accordions';
require_once __DIR__ . '/header.php';

$faqData = CMS::loadPage('faqs');
$items = $faqData['items'] ?? [];
$csrfToken = AdminAuth::csrfToken();
?>

<div class="cms-content">

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark);">Frequently Asked Questions Manager</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                Add, edit, reorder, or remove question and answer accordions displayed on your FAQ page.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="button" class="cms-btn cms-btn-outline" onclick="cmsAddFaqItem()">
                <i class="fa-solid fa-plus"></i> Add Question
            </button>
            <button type="button" id="saveFaqsBtn" class="cms-btn cms-btn-primary">
                <i class="fa-solid fa-check"></i> Save FAQ Changes
            </button>
        </div>
    </div>

    <!-- FAQ Accordions List -->
    <div id="faqItemsContainer">
        <?php foreach ($items as $idx => $item): ?>
            <div class="faq-item-card cms-card" style="margin-bottom: 14px;">
                <div class="cms-card-header" style="background: #fafbfc; cursor: pointer;" onclick="toggleFaqBody(this)">
                    <div style="display: flex; align-items: center; gap: 10px; flex: 1;">
                        <i class="fa-solid fa-circle-question" style="color: var(--forest-green);"></i>
                        <strong class="faq-question-label" style="font-size: 14px; color: var(--text-dark);">
                            <?php echo htmlspecialchars($item['q'] ?? 'Question #' . ($idx + 1)); ?>
                        </strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="event.stopPropagation(); this.closest('.faq-item-card').remove();" style="color: #991b1b; border-color: #fecaca;">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                        <i class="fa-solid fa-chevron-down" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                </div>
                <div class="cms-card-body faq-body-content" style="display: block;">
                    <div class="cms-form-group">
                        <label class="cms-label">Question Text</label>
                        <input type="text" class="cms-input faq-q-input" value="<?php echo htmlspecialchars($item['q'] ?? ''); ?>" placeholder="Enter question..." oninput="updateFaqLabel(this)">
                    </div>
                    <div class="cms-form-group" style="margin-bottom: 0;">
                        <label class="cms-label">Answer Text</label>
                        <textarea class="cms-textarea faq-a-input" style="min-height: 100px;" placeholder="Enter detailed answer..."><?php echo htmlspecialchars($item['a'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
function toggleFaqBody(header) {
    const body = header.nextElementSibling;
    const isHidden = body.style.display === 'none';
    body.style.display = isHidden ? 'block' : 'none';
    const chevron = header.querySelector('.fa-chevron-down');
    if (chevron) {
        chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }
}

function updateFaqLabel(input) {
    const card = input.closest('.faq-item-card');
    const label = card.querySelector('.faq-question-label');
    label.textContent = input.value.trim() || 'Untitled Question';
}

function cmsAddFaqItem() {
    const container = document.getElementById('faqItemsContainer');
    const card = document.createElement('div');
    card.className = 'faq-item-card cms-card';
    card.style.marginBottom = '14px';
    card.innerHTML = `
        <div class="cms-card-header" style="background: #fafbfc; cursor: pointer;" onclick="toggleFaqBody(this)">
            <div style="display: flex; align-items: center; gap: 10px; flex: 1;">
                <i class="fa-solid fa-circle-question" style="color: var(--forest-green);"></i>
                <strong class="faq-question-label" style="font-size: 14px; color: var(--text-dark);">New Question</strong>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="event.stopPropagation(); this.closest('.faq-item-card').remove();" style="color: #991b1b; border-color: #fecaca;">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <i class="fa-solid fa-chevron-down" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
            </div>
        </div>
        <div class="cms-card-body faq-body-content" style="display: block;">
            <div class="cms-form-group">
                <label class="cms-label">Question Text</label>
                <input type="text" class="cms-input faq-q-input" value="New Question" placeholder="Enter question..." oninput="updateFaqLabel(this)">
            </div>
            <div class="cms-form-group" style="margin-bottom: 0;">
                <label class="cms-label">Answer Text</label>
                <textarea class="cms-textarea faq-a-input" style="min-height: 100px;" placeholder="Enter detailed answer..."></textarea>
            </div>
        </div>
    `;
    container.insertBefore(card, container.firstChild);
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    card.querySelector('.faq-q-input').focus();
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('saveFaqsBtn').addEventListener('click', () => {
        const btn = document.getElementById('saveFaqsBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const items = [];
        document.querySelectorAll('.faq-item-card').forEach(card => {
            const q = card.querySelector('.faq-q-input').value.trim();
            const a = card.querySelector('.faq-a-input').value.trim();
            if (q) {
                items.push({ q, a, category: 'General' });
            }
        });

        const payload = <?php echo json_encode($faqData); ?>;
        payload.items = items;

        fetch('api.php?action=save_page', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                page: 'faqs',
                csrf_token: '<?php echo htmlspecialchars($csrfToken); ?>',
                data: JSON.stringify(payload)
            })
        })
        .then(r => r.json())
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Save FAQ Changes';
            if (res.success) {
                cmsToast('FAQ questions saved successfully!');
            } else {
                alert('Error saving FAQs: ' + (res.error || 'Unknown error'));
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
