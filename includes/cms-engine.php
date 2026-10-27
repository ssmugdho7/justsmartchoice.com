<?php
/**
 * Smart Choice CMS Engine
 * High-performance, non-destructive JSON data layer with in-memory caching,
 * live preview postMessage bridge support, and zero-downtime automated fallbacks.
 */

if (!defined('CMS_DATA_DIR')) {
    define('CMS_DATA_DIR', dirname(__DIR__) . '/cms-data');
}

require_once __DIR__ . '/cms-webp-converter.php';

class CMS
{
    private static $cache = [];
    private static $drafts = [];
    private static $isPreview = null;

    /**
     * Determine if current request is in CMS live preview mode
     */
    public static function isPreview(): bool
    {
        if (self::$isPreview !== null) {
            return self::$isPreview;
        }

        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }

        $sessionPreview = !empty($_SESSION['cms_admin_preview']);
        $queryPreview = isset($_GET['cms_preview']) && $_GET['cms_preview'] === '1';

        self::$isPreview = $sessionPreview || $queryPreview;
        return self::$isPreview;
    }

    /**
     * Load raw page data from JSON with in-memory caching
     */
    public static function loadPage(string $page): array
    {
        $page = preg_replace('/[^a-zA-Z0-9_\-]/', '', strtolower($page));
        if ($page === '') {
            return [];
        }

        if (isset(self::$cache[$page])) {
            return self::$cache[$page];
        }

        // Check if preview mode has session/draft data
        if (self::isPreview()) {
            $draftFile = CMS_DATA_DIR . '/drafts/' . $page . '.json';
            if (file_exists($draftFile)) {
                $draftContent = @file_get_contents($draftFile);
                if ($draftContent !== false) {
                    $json = json_decode($draftContent, true);
                    if (is_array($json)) {
                        self::$cache[$page] = $json;
                        return $json;
                    }
                }
            }
        }

        // Try root json (e.g., home.json, global.json, about.json)
        $file = CMS_DATA_DIR . '/' . $page . '.json';
        if (!file_exists($file)) {
            // Try pages/ subfolder (e.g., pages/career.json)
            $file = CMS_DATA_DIR . '/pages/' . $page . '.json';
        }

        if (file_exists($file)) {
            $content = @file_get_contents($file);
            if ($content !== false) {
                $json = json_decode($content, true);
                if (is_array($json)) {
                    self::$cache[$page] = $json;
                    return $json;
                }
            }
        }

        self::$cache[$page] = [];
        return [];
    }

    /**
     * Get a nested field using dot-notation (e.g. "hero.heading" or "slides.0.title")
     */
    public static function getField(string $page, string $key, $default = '')
    {
        $data = self::loadPage($page);
        if (empty($data)) {
            return $default;
        }

        if ($key === '' || $key === null) {
            return $data;
        }

        $keys = explode('.', $key);
        $current = $data;

        foreach ($keys as $k) {
            if (is_array($current) && array_key_exists($k, $current)) {
                $current = $current[$k];
            } else {
                return $default;
            }
        }

        return $current !== null && $current !== '' ? $current : $default;
    }

    /**
     * Get an image URL or object with fallback
     */
    public static function getImage(string $page, string $key, string $default = ''): string
    {
        $val = self::getField($page, $key, $default);
        $url = is_array($val) ? (string)($val['url'] ?? $default) : (string)($val ?: $default);

        if (class_exists('CmsWebPConverter') && !empty($url)) {
            return CmsWebPConverter::ensureWebp($url);
        }

        return $url;
    }

    /**
     * Get an image alt text with fallback
     */
    public static function getImageAlt(string $page, string $key, string $default = ''): string
    {
        $val = self::getField($page, $key, null);
        if (is_array($val) && !empty($val['alt'])) {
            return (string)$val['alt'];
        }
        return $default;
    }

    /**
     * Get a global setting (from global.json)
     */
    public static function getGlobal(string $key, $default = '')
    {
        return self::getField('global', $key, $default);
    }

    /**
     * Check if a section is enabled (boolean toggle)
     */
    public static function isSectionActive(string $page, string $sectionKey, bool $default = true): bool
    {
        $val = self::getField($page, $sectionKey . '._enabled', null);
        if ($val === null) {
            $val = self::getField($page, $sectionKey . '.enabled', null);
        }
        if ($val === null) {
            return $default;
        }
        return filter_var($val, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Save page data to production JSON
     */
    public static function savePage(string $page, array $data): bool
    {
        $page = preg_replace('/[^a-zA-Z0-9_\-]/', '', strtolower($page));
        if ($page === '') {
            return false;
        }

        $dir = CMS_DATA_DIR;
        if (!in_array($page, ['global', 'home', 'about', 'services', 'pricing', 'financing', 'contacts', 'blog', 'login'])) {
            $dir .= '/pages';
        }

        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $file = $dir . '/' . $page . '.json';
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        if ($json === false) {
            return false;
        }

        $res = @file_put_contents($file, $json, LOCK_EX);
        if ($res !== false) {
            self::$cache[$page] = $data;

            // Clear any draft file for this page upon publish
            $draftFile = CMS_DATA_DIR . '/drafts/' . $page . '.json';
            if (file_exists($draftFile)) {
                @unlink($draftFile);
            }
            return true;
        }
        return false;
    }

    /**
     * Save draft data for live preview
     */
    public static function saveDraft(string $page, array $data): bool
    {
        $page = preg_replace('/[^a-zA-Z0-9_\-]/', '', strtolower($page));
        if ($page === '') {
            return false;
        }

        $dir = CMS_DATA_DIR . '/drafts';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $file = $dir . '/' . $page . '.json';
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        if ($json === false) {
            return false;
        }

        $res = @file_put_contents($file, $json, LOCK_EX);
        if ($res !== false) {
            self::$cache[$page] = $data;
            return true;
        }
        return false;
    }

    /**
     * Discard draft data
     */
    public static function discardDraft(string $page): bool
    {
        $page = preg_replace('/[^a-zA-Z0-9_\-]/', '', strtolower($page));
        $draftFile = CMS_DATA_DIR . '/drafts/' . $page . '.json';
        if (file_exists($draftFile)) {
            @unlink($draftFile);
        }
        unset(self::$cache[$page]);
        return true;
    }

    /**
     * List all editable pages tracked by CMS
     */
    public static function getPageList(): array
    {
        $listFile = CMS_DATA_DIR . '/pages_manifest.json';
        if (file_exists($listFile)) {
            $data = json_decode(@file_get_contents($listFile), true);
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }
}

/**
 * Procedural helper functions for clean template usage
 */

if (!function_exists('cms_field')) {
    function cms_field(string $page, string $key, $default = '')
    {
        return CMS::getField($page, $key, $default);
    }
}

if (!function_exists('cms_image')) {
    function cms_image(string $page, string $key, string $default = ''): string
    {
        return CMS::getImage($page, $key, $default);
    }
}

if (!function_exists('cms_image_alt')) {
    function cms_image_alt(string $page, string $key, string $default = ''): string
    {
        return CMS::getImageAlt($page, $key, $default);
    }
}

if (!function_exists('cms_global')) {
    function cms_global(string $key, $default = '')
    {
        return CMS::getGlobal($key, $default);
    }
}

if (!function_exists('cms_section_active')) {
    function cms_section_active(string $page, string $sectionKey, bool $default = true): bool
    {
        return CMS::isSectionActive($page, $sectionKey, $default);
    }
}

if (!function_exists('cms_bind')) {
    /**
     * Outputs data-cms-bind="page:field" HTML attribute for instant preview postMessage synchronization
     */
    function cms_bind(string $page, string $field): string
    {
        if (CMS::isPreview()) {
            return ' data-cms-page="' . htmlspecialchars($page, ENT_QUOTES, 'UTF-8') . '" data-cms-bind="' . htmlspecialchars($field, ENT_QUOTES, 'UTF-8') . '"';
        }
        return '';
    }
}

if (!function_exists('cms_head_scripts')) {
    /**
     * Injects live preview scripts and global theme tokens into <head>
     */
    function cms_head_scripts(): string
    {
        $html = '';
        $primaryColor = cms_global('theme.primary_color', '#198754');
        $secondaryColor = cms_global('theme.secondary_color', '#0f766e');
        $customCss = cms_global('theme.custom_css', '');

        $html .= '<style id="cms-theme-styles">';
        $html .= ':root { --cms-primary: ' . htmlspecialchars($primaryColor) . '; --cms-secondary: ' . htmlspecialchars($secondaryColor) . '; }';
        if (!empty($customCss)) {
            $html .= "\n" . $customCss;
        }
        $html .= '</style>';

        if (CMS::isPreview()) {
            $html .= '<link rel="stylesheet" href="/admin/css/preview-bridge.css?v=' . time() . '">';
            $html .= '<script src="/admin/js/preview-bridge.js?v=' . time() . '" defer></script>';
        }

        return $html;
    }
}
