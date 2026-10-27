<?php
/**
 * Smart Choice CMS - High-Performance WebP Image Automation Engine
 * Handles real-time conversion on upload, dynamic on-demand conversion for legacy photos,
 * and bulk optimization with full PNG transparency preservation and EXIF handling.
 */

class CmsWebPConverter
{
    /**
     * Default WebP compression quality (85 provides visual parity with 75-85% size drop)
     */
    const DEFAULT_QUALITY = 85;

    /**
     * Convert any supported image (JPG, PNG, GIF, BMP) to WebP format
     *
     * @param string $sourcePath Absolute or relative disk path to original image
     * @param string $destPath   Optional destination path (defaults to same name with .webp)
     * @param int    $quality    Compression quality (0 - 100)
     * @return string|null       Returns destination path on success, null on failure
     */
    public static function convertToWebP(string $sourcePath, string $destPath = '', int $quality = self::DEFAULT_QUALITY): ?string
    {
        if (!file_exists($sourcePath)) {
            return null;
        }

        // Determine destination path if not provided
        if (empty($destPath)) {
            $info = pathinfo($sourcePath);
            $destPath = $info['dirname'] . '/' . $info['filename'] . '.webp';
        }

        // If already WebP, copy or return destination if identical
        $ext = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        if ($ext === 'webp') {
            if ($sourcePath !== $destPath) {
                @copy($sourcePath, $destPath);
            }
            return $destPath;
        }

        if (!function_exists('imagewebp')) {
            error_log('[CMS WebP Converter] GD WebP support is not available in PHP.');
            return null;
        }

        $image = null;

        // Detect mime type or image type
        $imgType = false;
        if (function_exists('exif_imagetype')) {
            $imgType = @exif_imagetype($sourcePath);
        }

        switch ($imgType) {
            case IMAGETYPE_JPEG:
                $image = @imagecreatefromjpeg($sourcePath);
                // Handle EXIF orientation if available
                if ($image && function_exists('exif_read_data')) {
                    $exif = @exif_read_data($sourcePath);
                    if (!empty($exif['Orientation'])) {
                        switch ($exif['Orientation']) {
                            case 3:
                                $image = imagerotate($image, 180, 0);
                                break;
                            case 6:
                                $image = imagerotate($image, -90, 0);
                                break;
                            case 8:
                                $image = imagerotate($image, 90, 0);
                                break;
                        }
                    }
                }
                break;

            case IMAGETYPE_PNG:
                $image = @imagecreatefrompng($sourcePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                }
                break;

            case IMAGETYPE_GIF:
                $image = @imagecreatefromgif($sourcePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                }
                break;

            case IMAGETYPE_BMP:
                if (function_exists('imagecreatefrombmp')) {
                    $image = @imagecreatefrombmp($sourcePath);
                }
                break;

            default:
                // Fallback by extension
                if (in_array($ext, ['jpg', 'jpeg'])) {
                    $image = @imagecreatefromjpeg($sourcePath);
                } elseif ($ext === 'png') {
                    $image = @imagecreatefrompng($sourcePath);
                    if ($image) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, false);
                        imagesavealpha($image, true);
                    }
                } elseif ($ext === 'gif') {
                    $image = @imagecreatefromgif($sourcePath);
                }
                break;
        }

        if (!$image) {
            return null;
        }

        // Ensure target directory exists
        $destDir = dirname($destPath);
        if (!is_dir($destDir)) {
            @mkdir($destDir, 0755, true);
        }

        // Output WebP
        $success = @imagewebp($image, $destPath, $quality);
        @imagedestroy($image);

        return $success ? $destPath : null;
    }

    /**
     * Resolves a relative or absolute image URL to its WebP counterpart.
     * If the WebP version doesn't exist on disk, converts it automatically on the fly!
     *
     * @param string $imageUrl (e.g., 'images/slides/slide-01.jpg' or '/images/img.png')
     * @return string           WebP URL (e.g., 'images/slides/slide-01.webp')
     */
    public static function ensureWebp(string $imageUrl): string
    {
        $imageUrl = trim($imageUrl);
        if ($imageUrl === '') {
            return '';
        }

        // Skip remote URLs or data URIs
        if (preg_match('#^(https?:|data:|blob:)#i', $imageUrl)) {
            return $imageUrl;
        }

        $info = pathinfo($imageUrl);
        $ext = strtolower($info['extension'] ?? '');

        // Already WebP, return as is
        if ($ext === 'webp') {
            return $imageUrl;
        }

        // Supported conversion extensions
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'bmp', 'gif'])) {
            return $imageUrl;
        }

        // Map relative URL to disk path
        $cleanPath = ltrim(parse_url($imageUrl, PHP_URL_PATH) ?? '', '/\\');
        $rootDir = dirname(__DIR__);
        $sourceDisk = $rootDir . '/' . $cleanPath;

        // Calculate destination WebP path
        $webpRelative = ($info['dirname'] === '.' || $info['dirname'] === '/' || $info['dirname'] === '')
            ? $info['filename'] . '.webp'
            : $info['dirname'] . '/' . $info['filename'] . '.webp';

        $cleanWebpPath = ltrim(parse_url($webpRelative, PHP_URL_PATH) ?? '', '/\\');
        $webpDisk = $rootDir . '/' . $cleanWebpPath;

        // If WebP version already exists on disk, return it immediately
        if (file_exists($webpDisk)) {
            return $webpRelative;
        }

        // Source exists on disk, convert on-demand
        if (file_exists($sourceDisk)) {
            $converted = self::convertToWebP($sourceDisk, $webpDisk);
            if ($converted && file_exists($webpDisk)) {
                return $webpRelative;
            }
        }

        // Fallback to original image if conversion fails or source missing
        return $imageUrl;
    }

    /**
     * Scans an image directory for non-WebP legacy images (JPG, PNG, GIF, BMP)
     */
    public static function scanLegacyImages(string $dir = ''): array
    {
        if (empty($dir)) {
            $dir = dirname(__DIR__) . '/images';
        }

        $results = [];
        if (!is_dir($dir)) {
            return $results;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        $rootDir = dirname(__DIR__);

        foreach ($iterator as $item) {
            if ($item->isFile()) {
                $ext = strtolower($item->getExtension());
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'bmp'])) {
                    $fullPath = str_replace('\\', '/', $item->getPathname());
                    $relativePath = ltrim(str_replace(str_replace('\\', '/', $rootDir), '', $fullPath), '/');

                    $webpPath = pathinfo($fullPath, PATHINFO_DIRNAME) . '/' . pathinfo($fullPath, PATHINFO_FILENAME) . '.webp';
                    $hasWebp = file_exists($webpPath);

                    $results[] = [
                        'file'          => $item->getFilename(),
                        'full_path'     => $fullPath,
                        'relative_path' => $relativePath,
                        'size'          => $item->getSize(),
                        'ext'           => $ext,
                        'has_webp'      => $hasWebp,
                        'webp_relative' => pathinfo($relativePath, PATHINFO_DIRNAME) . '/' . pathinfo($relativePath, PATHINFO_FILENAME) . '.webp'
                    ];
                }
            }
        }

        return $results;
    }
}
