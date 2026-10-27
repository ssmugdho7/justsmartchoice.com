<?php
$pageTitle = 'Leads & Form Inquiries';
$breadcrumb = 'Leads & Inquiries';
require_once __DIR__ . '/header.php';

$leadsFile = CMS_DATA_DIR . '/leads.json';
$leads = file_exists($leadsFile) ? json_decode(@file_get_contents($leadsFile), true) : [];
if (!is_array($leads)) $leads = [];

// Reverse order (newest first)
$leads = array_reverse($leads);

$contactsData = CMS::loadPage('contacts');
$emailConfig = $contactsData['email_config'] ?? [];
$csrfToken = AdminAuth::csrfToken();
?>

<div class="cms-content">

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark);">Leads & Contact Form Submissions</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                Review incoming project requests, customer messages, and manage notification email destinations.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="button" id="saveEmailConfigBtn" class="cms-btn cms-btn-primary">
                <i class="fa-solid fa-check"></i> Save Email Settings
            </button>
        </div>
    </div>

    <!-- Email Routing Settings -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-envelope-circle-check" style="color: var(--forest-green);"></i>
                <span>Lead Notification Email Settings</span>
            </div>
        </div>
        <div class="cms-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px;">
                <div class="cms-form-group">
                    <label class="cms-label">Recipient Email Addresses (comma-separated)</label>
                    <input type="text" id="recipientEmails" class="cms-input" value="<?php echo htmlspecialchars($emailConfig['recipients'] ?? 'lead@justsmartchoice.com,sales@justsmartchoice.com,admin@justsmartchoice.com'); ?>">
                    <span style="font-size: 11px; color: var(--text-muted); margin-top: 4px; display: block;">Notifications will be delivered to all addresses listed here.</span>
                </div>

                <div class="cms-form-group">
                    <label class="cms-label">Email Subject Prefix</label>
                    <input type="text" id="emailSubject" class="cms-input" value="<?php echo htmlspecialchars($emailConfig['subject_prefix'] ?? 'New Lead from the website: '); ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Leads Inbox Table -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-inbox" style="color: var(--forest-green);"></i>
                <span>Customer Inquiries (<?php echo count($leads); ?>)</span>
            </div>
        </div>
        <div class="cms-card-body" style="padding: 0;">
            <?php if (empty($leads)): ?>
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fa-regular fa-folder-open" style="font-size: 36px; margin-bottom: 12px; opacity: 0.5;"></i>
                    <p style="font-size: 14px; font-weight: 600;">No contact submissions logged yet.</p>
                    <span style="font-size: 12px;">New submissions submitted from the contact page will automatically show up here.</span>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                        <thead>
                            <tr style="background-color: #fafbfc; border-bottom: 1px solid var(--border-subtle); color: var(--text-muted); font-size: 11.5px; text-transform: uppercase;">
                                <th style="padding: 12px 20px;">Date & Time</th>
                                <th style="padding: 12px 16px;">Customer Name</th>
                                <th style="padding: 12px 16px;">Contact Info</th>
                                <th style="padding: 12px 16px;">Service</th>
                                <th style="padding: 12px 20px;">Message Excerpt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $l): ?>
                                <tr style="border-bottom: 1px solid var(--border-subtle);">
                                    <td style="padding: 12px 20px; font-size: 12px; color: var(--text-muted); white-space: nowrap;">
                                        <?php echo htmlspecialchars($l['date'] ?? ''); ?>
                                    </td>
                                    <td style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">
                                        <?php echo htmlspecialchars($l['name'] ?? 'N/A'); ?>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <div><a href="tel:<?php echo htmlspecialchars($l['phone'] ?? ''); ?>"><?php echo htmlspecialchars($l['phone'] ?? ''); ?></a></div>
                                        <div style="font-size: 11.5px; color: var(--text-muted);"><a href="mailto:<?php echo htmlspecialchars($l['email'] ?? ''); ?>"><?php echo htmlspecialchars($l['email'] ?? ''); ?></a></div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <span class="cms-badge cms-badge-green">
                                            <?php echo htmlspecialchars($l['service'] ?? 'Inquiry'); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 12px 20px; color: var(--text-body); max-width: 320px;">
                                        <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($l['message'] ?? ''); ?>">
                                            <?php echo htmlspecialchars($l['message'] ?? ''); ?>
                                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('saveEmailConfigBtn').addEventListener('click', () => {
        const btn = document.getElementById('saveEmailConfigBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const contactsData = <?php echo json_encode($contactsData); ?>;
        contactsData.email_config = {
            recipients: document.getElementById('recipientEmails').value.trim(),
            subject_prefix: document.getElementById('emailSubject').value.trim()
        };

        fetch('api.php?action=save_page', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                page: 'contacts',
                csrf_token: '<?php echo htmlspecialchars($csrfToken); ?>',
                data: JSON.stringify(contactsData)
            })
        })
        .then(r => r.json())
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Save Email Settings';
            if (res.success) {
                cmsToast('Email notification settings saved successfully!');
            } else {
                alert('Error saving settings: ' + (res.error || 'Unknown error'));
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
