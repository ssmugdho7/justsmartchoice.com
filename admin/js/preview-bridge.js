/**
 * Smart Choice CMS - Preview Bridge Client Script
 * Executes inside the preview iframe to enable sub-millisecond DOM updates and click-to-edit
 */

(function() {
    'use strict';

    console.log('[CMS Preview Bridge] Initialized.');

    // 1. Click-to-edit inspector
    document.addEventListener('click', (e) => {
        const bindElem = e.target.closest('[data-cms-bind]');
        if (bindElem) {
            e.preventDefault();
            e.stopPropagation();

            const bindPath = bindElem.getAttribute('data-cms-bind');
            const pageSlug = bindElem.getAttribute('data-cms-page') || '';

            // Post message to parent admin editor
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({
                    type: 'cms:element_clicked',
                    page: pageSlug,
                    field: bindPath
                }, '*');
            }

            // Highlight temporarily
            bindElem.classList.add('cms-preview-target-focused');
            setTimeout(() => bindElem.classList.remove('cms-preview-target-focused'), 1800);
        }
    }, true);

    // 2. Listen for messages from parent editor window
    window.addEventListener('message', (event) => {
        const data = event.data;
        if (!data || !data.type) return;

        // A. Dynamic text or media update
        if (data.type === 'cms:update_field') {
            const { field, value, valueType } = data;
            const elements = document.querySelectorAll(`[data-cms-bind="${field}"]`);

            elements.forEach(el => {
                if (valueType === 'image') {
                    if (el.tagName === 'IMG') {
                        el.src = value;
                    } else {
                        // Background image
                        el.style.backgroundImage = `url("${value}")`;
                    }
                } else if (valueType === 'link') {
                    if (el.tagName === 'A') {
                        el.href = value;
                    }
                } else {
                    // Text / HTML
                    el.textContent = value;
                }
            });
        }

        // B. Dynamic CSS theme injection
        if (data.type === 'cms:inject_css') {
            let styleTag = document.getElementById('cms-live-preview-styles');
            if (!styleTag) {
                styleTag = document.createElement('style');
                styleTag.id = 'cms-live-preview-styles';
                document.head.appendChild(styleTag);
            }
            styleTag.textContent = data.css || '';
        }

        // C. Dynamic theme color update
        if (data.type === 'cms:update_colors') {
            const root = document.documentElement;
            if (data.primary) root.style.setProperty('--cms-primary', data.primary);
            if (data.secondary) root.style.setProperty('--cms-secondary', data.secondary);
        }

        // D. Focus element request from parent
        if (data.type === 'cms:focus_element') {
            const el = document.querySelector(`[data-cms-bind="${data.field}"]`);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                el.classList.add('cms-preview-target-focused');
                setTimeout(() => el.classList.remove('cms-preview-target-focused'), 1800);
            }
        }
    });

    // Notify parent window that preview bridge is ready
    if (window.parent && window.parent !== window) {
        window.parent.postMessage({ type: 'cms:bridge_ready' }, '*');
    }
})();
