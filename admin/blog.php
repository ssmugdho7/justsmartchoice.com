<?php
$pageTitle = 'Blog & Articles Manager';
$breadcrumb = 'Blog Articles';
require_once __DIR__ . '/header.php';

$blogData = CMS::loadPage('blog');
$posts = $blogData['posts'] ?? [];
$csrfToken = AdminAuth::csrfToken();
?>

<div class="cms-content">

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-dark);">Blog & Article Publishing Manager</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                Create, edit, and publish construction articles, remodeling tips, and permitting guides.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="button" class="cms-btn cms-btn-outline" onclick="cmsOpenNewPostModal()">
                <i class="fa-solid fa-plus"></i> New Article
            </button>
            <button type="button" id="saveBlogBtn" class="cms-btn cms-btn-primary">
                <i class="fa-solid fa-check"></i> Save Blog Changes
            </button>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="cms-card">
        <div class="cms-card-header">
            <div class="cms-card-title">
                <i class="fa-solid fa-newspaper" style="color: var(--forest-green);"></i>
                <span>Published & Draft Articles (<?php echo count($posts); ?>)</span>
            </div>
        </div>
        <div class="cms-card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                    <thead>
                        <tr style="background-color: #fafbfc; border-bottom: 1px solid var(--border-subtle); color: var(--text-muted); font-size: 11.5px; text-transform: uppercase;">
                            <th style="padding: 12px 20px;">Article Title</th>
                            <th style="padding: 12px 16px;">Category</th>
                            <th style="padding: 12px 16px;">Author & Date</th>
                            <th style="padding: 12px 16px;">Status</th>
                            <th style="padding: 12px 20px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="postsTableBody">
                        <?php foreach ($posts as $idx => $post): ?>
                            <tr class="blog-row-item" data-index="<?php echo $idx; ?>" style="border-bottom: 1px solid var(--border-subtle);">
                                <td style="padding: 14px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if (!empty($post['image'])): ?>
                                            <img src="/<?php echo htmlspecialchars(ltrim($post['image'], '/')); ?>" style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px;">
                                        <?php endif; ?>
                                        <div>
                                            <strong style="color: var(--text-dark); display: block; font-size: 13.5px;"><?php echo htmlspecialchars($post['title'] ?? ''); ?></strong>
                                            <span style="font-size: 11.5px; color: var(--text-muted); font-family: monospace;">/blog/<?php echo htmlspecialchars($post['slug'] ?? ''); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <span class="cms-badge cms-badge-green">
                                        <?php echo htmlspecialchars($post['category'] ?? 'General'); ?>
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; font-size: 12.5px; color: var(--text-muted);">
                                    <div><?php echo htmlspecialchars($post['author'] ?? 'Smart Choice Team'); ?></div>
                                    <div style="font-size: 11px;"><?php echo htmlspecialchars($post['date'] ?? ''); ?></div>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <span class="cms-badge <?php echo ($post['status'] === 'published') ? 'cms-badge-green' : 'cms-badge-gray'; ?>">
                                        <?php echo ucfirst($post['status'] ?? 'draft'); ?>
                                    </span>
                                </td>
                                <td style="padding: 14px 20px; text-align: right;">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="cmsEditPost(<?php echo $idx; ?>)">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </button>
                                        <button type="button" class="cms-btn cms-btn-outline cms-btn-sm" onclick="cmsDeletePost(<?php echo $idx; ?>)" style="color: #991b1b; border-color: #fecaca;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
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

<!-- Post Editor Modal -->
<div id="cmsPostEditorModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 999999; align-items: center; justify-content: center;">
    <div style="background: var(--white); border-radius: var(--radius-lg); width: 90%; max-width: 720px; max-height: 85vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: var(--shadow-lg);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: space-between;">
            <strong id="postModalTitle" style="font-size: 15px; color: var(--text-dark);">Create New Article</strong>
            <button type="button" onclick="cmsClosePostModal()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>
        <div style="padding: 20px; overflow-y: auto; flex: 1;">
            <input type="hidden" id="editPostIndex" value="-1">

            <div class="cms-form-group">
                <label class="cms-label">Article Title</label>
                <input type="text" id="postTitleInput" class="cms-input" placeholder="e.g. Florida Building Permit Guide" oninput="cmsAutoSlug(this.value)">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="cms-form-group">
                    <label class="cms-label">URL Slug</label>
                    <input type="text" id="postSlugInput" class="cms-input" placeholder="florida-building-permit-guide">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Category</label>
                    <input type="text" id="postCategoryInput" class="cms-input" placeholder="Remodeling / Permits">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="cms-form-group">
                    <label class="cms-label">Author</label>
                    <input type="text" id="postAuthorInput" class="cms-input" value="Smart Choice Team">
                </div>
                <div class="cms-form-group">
                    <label class="cms-label">Publish Date</label>
                    <input type="date" id="postDateInput" class="cms-input" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="cms-form-group">
                <label class="cms-label">Featured Image URL</label>
                <input type="text" id="postImageInput" class="cms-input" placeholder="images/service-cards/kitchen-remodeling.webp">
            </div>

            <div class="cms-form-group">
                <label class="cms-label">Short Excerpt (Summary)</label>
                <textarea id="postExcerptInput" class="cms-textarea" style="min-height: 70px;" placeholder="Brief summary of the article..."></textarea>
            </div>

            <div class="cms-form-group">
                <label class="cms-label">Full Article Content</label>
                <textarea id="postContentInput" class="cms-textarea" style="min-height: 160px;" placeholder="Write full article paragraphs here..."></textarea>
            </div>

            <div class="cms-form-group" style="margin-bottom: 0;">
                <label class="cms-label">Publish Status</label>
                <select id="postStatusSelect" class="cms-select">
                    <option value="published">Published</option>
                    <option value="draft">Draft (Unpublished)</option>
                </select>
            </div>
        </div>
        <div style="padding: 14px 20px; border-top: 1px solid var(--border-subtle); display: flex; justify-content: flex-end; gap: 10px; background: #fafbfc;">
            <button type="button" class="cms-btn cms-btn-outline" onclick="cmsClosePostModal()">Cancel</button>
            <button type="button" class="cms-btn cms-btn-primary" onclick="cmsSavePostModal()">
                <i class="fa-solid fa-check"></i> Save Article
            </button>
        </div>
    </div>
</div>

<script>
let blogPosts = <?php echo json_encode($posts); ?>;

function cmsAutoSlug(text) {
    if (document.getElementById('editPostIndex').value === '-1') {
        const slug = text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        document.getElementById('postSlugInput').value = slug;
    }
}

function cmsOpenNewPostModal() {
    document.getElementById('editPostIndex').value = '-1';
    document.getElementById('postModalTitle').textContent = 'Create New Article';
    document.getElementById('postTitleInput').value = '';
    document.getElementById('postSlugInput').value = '';
    document.getElementById('postCategoryInput').value = 'General';
    document.getElementById('postAuthorInput').value = 'Smart Choice Team';
    document.getElementById('postDateInput').value = '<?php echo date('Y-m-d'); ?>';
    document.getElementById('postImageInput').value = 'images/service-cards/new-construction.webp';
    document.getElementById('postExcerptInput').value = '';
    document.getElementById('postContentInput').value = '';
    document.getElementById('postStatusSelect').value = 'published';
    document.getElementById('cmsPostEditorModal').style.display = 'flex';
}

function cmsEditPost(idx) {
    const p = blogPosts[idx];
    if (!p) return;
    document.getElementById('editPostIndex').value = idx;
    document.getElementById('postModalTitle').textContent = 'Edit Article';
    document.getElementById('postTitleInput').value = p.title || '';
    document.getElementById('postSlugInput').value = p.slug || '';
    document.getElementById('postCategoryInput').value = p.category || '';
    document.getElementById('postAuthorInput').value = p.author || '';
    document.getElementById('postDateInput').value = p.date || '';
    document.getElementById('postImageInput').value = p.image || '';
    document.getElementById('postExcerptInput').value = p.excerpt || '';
    document.getElementById('postContentInput').value = p.content || '';
    document.getElementById('postStatusSelect').value = p.status || 'published';
    document.getElementById('cmsPostEditorModal').style.display = 'flex';
}

function cmsClosePostModal() {
    document.getElementById('cmsPostEditorModal').style.display = 'none';
}

function cmsSavePostModal() {
    const idx = parseInt(document.getElementById('editPostIndex').value, 10);
    const postData = {
        id: idx >= 0 ? blogPosts[idx].id : 'post_' + Date.now(),
        title: document.getElementById('postTitleInput').value.trim(),
        slug: document.getElementById('postSlugInput').value.trim(),
        category: document.getElementById('postCategoryInput').value.trim() || 'General',
        author: document.getElementById('postAuthorInput').value.trim() || 'Smart Choice Team',
        date: document.getElementById('postDateInput').value,
        image: document.getElementById('postImageInput').value.trim(),
        excerpt: document.getElementById('postExcerptInput').value.trim(),
        content: document.getElementById('postContentInput').value.trim(),
        status: document.getElementById('postStatusSelect').value
    };

    if (!postData.title) {
        alert('Please enter an article title.');
        return;
    }

    if (idx >= 0) {
        blogPosts[idx] = postData;
    } else {
        blogPosts.unshift(postData);
    }

    cmsClosePostModal();
    saveAllBlogPosts();
}

function cmsDeletePost(idx) {
    if (!confirm('Are you sure you want to delete this article?')) return;
    blogPosts.splice(idx, 1);
    saveAllBlogPosts();
}

function saveAllBlogPosts() {
    const payload = <?php echo json_encode($blogData); ?>;
    payload.posts = blogPosts;

    fetch('api.php?action=save_page', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            page: 'blog',
            csrf_token: '<?php echo htmlspecialchars($csrfToken); ?>',
            data: JSON.stringify(payload)
        })
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            cmsToast('Blog updated successfully!');
            setTimeout(() => location.reload(), 600);
        } else {
            alert('Error saving blog: ' + (res.error || 'Unknown error'));
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('saveBlogBtn').addEventListener('click', () => {
        saveAllBlogPosts();
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
