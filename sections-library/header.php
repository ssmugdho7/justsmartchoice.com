<?php
require_once __DIR__ . '/../includes/cms-engine.php';

$current_uri = strtolower(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'
);

$current_page = strtolower(basename($current_uri));

if (!function_exists('sc_nav_active')) {
    function sc_nav_active($targets)
    {
        global $current_uri, $current_page;

        foreach ((array) $targets as $target) {
            $target = strtolower((string) $target);

            if (
                $target === 'home'
                && ($current_uri === '/' || $current_page === 'index.php')
            ) {
                return 'active';
            }

            if (
                $current_page === $target
                || strpos($current_uri, '/' . $target) !== false
            ) {
                return 'active';
            }
        }

        return '';
    }
}

$nav_items = [
    [
        'href'    => '/index.php',
        'label'   => 'Home',
        'targets' => ['home', 'index.php'],
    ],
    [
        'href'    => '/about.php',
        'label'   => 'About',
        'targets' => ['about.php'],
    ],
    [
        'href'    => '/services.php',
        'label'   => 'Services',
        'targets' => ['services.php', 'services'],
    ],
    [
        'href'    => '/pricing.php',
        'label'   => 'Pricing',
        'targets' => ['pricing.php'],
    ],
    [
        'href'    => '/financing.php',
        'label'   => 'Financing',
        'targets' => ['financing.php'],
    ],
    [
        'href'    => '/contacts.php',
        'label'   => 'Contact Us',
        'targets' => ['contacts.php'],
    ],
    [
        'href'    => '/blog.php',
        'label'   => 'Blog',
        'targets' => ['blog.php', 'blog'],
    ],
    [
        'href'    => '/login.php',
        'label'   => 'Login',
        'targets' => ['login.php'],
    ],
];

// Load CMS navigation overrides if present
$cms_nav = cms_global('navigation');
if (!empty($cms_nav) && is_array($cms_nav)) {
    $nav_items = [];
    foreach ($cms_nav as $item) {
        $href = $item['href'] ?? '/';
        $t = strtolower(basename(parse_url($href, PHP_URL_PATH) ?? ''));
        $targets = array_unique(array_filter([$t, ($t === 'index.php' || $href === '/') ? 'home' : $t]));
        $nav_items[] = [
            'href'    => $href,
            'label'   => $item['label'] ?? '',
            'targets' => $targets
        ];
    }
}

$top_banner_enabled = cms_global('top_banner.enabled', true);
$top_banner_url = cms_global('top_banner.url', '/promo_flooring.php');
$top_banner_fg = cms_global('top_banner.fg_image', '/images/banner/banner-fg-04-1600x60.png');
$top_banner_bg = cms_global('top_banner.bg_image', '/images/banner/banner-bg-04-1920x60.jpg');
$top_banner_alt = cms_global('top_banner.alt', 'Smart Choice Contractors USA Tampa Bay construction and remodeling services');
?>

<?php echo cms_head_scripts(); ?>

<!-- START: GLOBAL SITE HEADER -->
<section
    class="banner site-header-wrapper"
    itemscope
    itemtype="https://schema.org/WPHeader"
>
    <?php if ($top_banner_enabled): ?>
    <a
        class="section section-banner d-none d-lg-block"
        href="<?php echo htmlspecialchars($top_banner_url); ?>"
        aria-label="View the Smart Choice flooring promotion"
        style="background-image: url('<?php echo htmlspecialchars($top_banner_bg); ?>');"
        <?php echo cms_bind('global', 'top_banner.bg_image'); ?>
    >
        <img
            src="<?php echo htmlspecialchars($top_banner_fg); ?>"
            alt="<?php echo htmlspecialchars($top_banner_alt); ?>"
            width="1600"
            height="60"
            loading="eager"
            decoding="async"
            <?php echo cms_bind('global', 'top_banner.fg_image'); ?>
        >
    </a>
    <?php endif; ?>

    <header class="section page-header" role="banner">
        <div class="rd-navbar-wrap">
            <nav
                class="rd-navbar"
                role="navigation"
                aria-label="Main navigation"
                data-layout="rd-navbar-fixed"
                data-sm-layout="rd-navbar-fixed"
                data-md-layout="rd-navbar-static"
                data-md-device-layout="rd-navbar-fixed"
                data-lg-layout="rd-navbar-static"
                data-lg-device-layout="rd-navbar-fixed"
                data-xl-layout="rd-navbar-static"
                data-xl-device-layout="rd-navbar-static"
                data-md-stick-up-offset="185px"
                data-lg-stick-up-offset="185px"
                data-xl-stick-up-offset="185px"
                data-xxl-stick-up-offset="185px"
                data-md-stick-up="true"
                data-lg-stick-up="true"
                data-xl-stick-up="true"
                data-xxl-stick-up="true"
            >
                <div class="rd-navbar-section rd-navbar-static-collapse">
                    <div class="rd-navbar-container">
                        <div class="rd-navbar-panel">
                            <button
                                class="rd-navbar-toggle"
                                type="button"
                                data-rd-navbar-toggle=".rd-navbar-nav"
                                aria-label="Open main menu"
                            >
                                <span></span>
                            </button>

                            <div
                                class="rd-navbar-logo"
                                itemscope
                                itemtype="https://schema.org/Organization"
                            >
                                <meta itemprop="name" content="Smart Choice Contractors USA">
                                <a
                                    href="/index.php"
                                    itemprop="url"
                                    aria-label="Smart Choice Contractors USA home"
                                >
                                    <img
                                        class="logo-small"
                                        src="<?php echo htmlspecialchars(cms_global('branding.logos.mobile.url', '/images/logo-364x52.png')); ?>"
                                        alt="Smart Choice Contractors USA"
                                        width="182"
                                        height="26"
                                        itemprop="logo"
                                        <?php echo cms_bind('global', 'branding.logos.mobile.url'); ?>
                                    >

                                    <img
                                        class="logo-default"
                                        src="<?php echo htmlspecialchars(cms_global('branding.logos.desktop.url', '/images/logo-638x310.png')); ?>"
                                        alt="Smart Choice Contractors USA logo"
                                        width="319"
                                        height="155"
                                        <?php echo cms_bind('global', 'branding.logos.desktop.url'); ?>
                                    >
                                </a>
                            </div>

                            <button
                                class="rd-navbar-info-toggle"
                                type="button"
                                data-rd-navbar-toggle=".rd-navbar-info"
                                aria-label="Open contact information"
                            >
                                <span></span>
                            </button>
                        </div>

                        <div class="rd-navbar-info">
                            <div
                                class="info"
                                itemscope
                                itemtype="https://schema.org/LocalBusiness"
                            >
                                <meta itemprop="image" content="https://justsmartchoice.com/images/logo-638x310.png">
                                <div hidden itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                                    <meta itemprop="streetAddress" content="1663 US Highway 41">
                                    <meta itemprop="addressLocality" content="Spring Hill">
                                    <meta itemprop="addressRegion" content="FL">
                                    <meta itemprop="postalCode" content="34610">
                                    <meta itemprop="addressCountry" content="US">
                                </div>
                                <meta
                                    itemprop="name"
                                    content="Smart Choice Contractors USA"
                                >

                                <meta
                                    itemprop="url"
                                    content="https://justsmartchoice.com/"
                                >

                                <div class="sc-header-phone">
                                    <span
                                        class="sc-header-phone-icon fa-mobile"
                                        aria-hidden="true"
                                    ></span>

                                    <div class="sc-header-phone-content">
                                        <span class="sc-header-help-title">
                                            Need Help?
                                        </span>

                                        <a
                                            class="sc-header-phone-number"
                                            href="tel:<?php echo htmlspecialchars(cms_global('contact.phone_raw', '+17277553786')); ?>"
                                            itemprop="telephone"
                                            aria-label="Call Smart Choice Contractors USA"
                                            <?php echo cms_bind('global', 'contact.phone'); ?>
                                        >
                                            <?php echo htmlspecialchars(cms_global('contact.phone', '(727) 755-3786')); ?>
                                        </a>
                                    </div>
                                </div>

                                <div class="sc-header-hours">
                                    <strong class="sc-header-hours-title">
                                        Working Hours
                                    </strong>

                                    <span class="sc-header-hours-line" <?php echo cms_bind('global', 'contact.hours_weekdays'); ?>>
                                        <?php echo htmlspecialchars(cms_global('contact.hours_weekdays', 'Monday–Friday: 8:00 AM–4:00 PM')); ?>
                                    </span>

                                    <span class="sc-header-hours-line" <?php echo cms_bind('global', 'contact.hours_saturday'); ?>>
                                        <?php echo htmlspecialchars(cms_global('contact.hours_saturday', 'Saturday: 8:00 AM–3:00 PM')); ?>
                                    </span>
                                </div>

                                <a
                                    class="appointment-button"
                                    href="<?php echo htmlspecialchars(cms_global('contact.appointment_btn_url', 'https://crm.justsmartchoice.com/appointly/appointments')); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    <?php echo cms_bind('global', 'contact.appointment_btn_label'); ?>
                                >
                                    <?php echo htmlspecialchars(cms_global('contact.appointment_btn_label', 'Appointment')); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rd-navbar-section sc-main-nav-section">
                    <div class="rd-navbar-container">
                        <ul
                            class="rd-navbar-nav"
                            itemscope
                            itemtype="https://schema.org/SiteNavigationElement"
                        >
                            <?php foreach ($nav_items as $item): ?>
                                <?php $active = sc_nav_active($item['targets']); ?>

                                <li class="rd-nav-item <?php echo $active; ?>">
                                    <a
                                        class="rd-nav-link"
                                        href="<?php
                                            echo htmlspecialchars(
                                                $item['href'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                        ?>"
                                        itemprop="url"
                                        <?php
                                        echo $active
                                            ? 'aria-current="page"'
                                            : '';
                                        ?>
                                    >
                                        <span itemprop="name">
                                            <?php
                                            echo htmlspecialchars(
                                                $item['label'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                            ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</section>
<!-- END: GLOBAL SITE HEADER -->
