<?php
// Initialize current_lang from cookie or URL parameter for frontend display and UI states
$current_lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'si', 'ta'])) {
    $current_lang = $_GET['lang'];
    if (!headers_sent()) {
        setcookie('lang', $current_lang, time() + 86400 * 30, '/');
        setcookie('googtrans', '/en/' . $current_lang, time() + 86400 * 30, '/');
    }
} elseif (isset($_COOKIE['googtrans']) && !empty($_COOKIE['googtrans'])) {
    $gt_raw = trim(urldecode($_COOKIE['googtrans']), '"');
    if (preg_match('#/(si|ta|en)$#i', $gt_raw, $m)) {
        $current_lang = strtolower($m[1]);
    }
}
if ($current_lang === 'en' && isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['en', 'si', 'ta'])) {
    $current_lang = $_COOKIE['lang'];
}

// Load Central Hybrid Translation Architecture Dictionary & Helper
require_once __DIR__ . '/translations.php';
global $lang_dict;
$nav_trans = $lang_dict ?? [];


// Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Compute dynamic base URL first for absolute SEO URLs
$base_dir = dirname($_SERVER['SCRIPT_NAME']);
if ($base_dir === '\\' || $base_dir === '/') {
    $base_dir = '';
}
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $base_dir . '/';

$seoTitle = isset($pageTitle) ? $pageTitle : (isset($page_title) ? strip_tags($page_title) : 'Ministry of Labour - Government of Sri Lanka');
$seoDesc = isset($metaDescription) ? $metaDescription : 'Official portal of the Ministry of Labour, Sri Lanka. Committed to protecting workforce rights, maintaining industrial peace, social security (EPF), and workplace occupational safety.';
$seoKw = isset($metaKeywords) ? $metaKeywords : 'Ministry of Labour, Sri Lanka Labour, EPF, ETF, Labour Laws Sri Lanka, Employees Provident Fund, Mehewara Piyasa, Industrial Relations, Occupational Safety';

// Enforce absolute URLs for social scrapers
$rawOgImage = isset($ogImage) ? $ogImage : 'assets/img/og-preview.jpg';
$seoOgImage = (strpos($rawOgImage, 'http') === 0) ? $rawOgImage : $base_url . ltrim($rawOgImage, '/');

$rawOgUrl = isset($ogUrl) ? $ogUrl : 'home';
$seoOgUrl = (strpos($rawOgUrl, 'http') === 0) ? $rawOgUrl : $base_url . ltrim($rawOgUrl, '/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <base href="<?= htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8') ?>">

    <!-- SEO Best Practices -->
    <title><?= htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description"
        content="<?= htmlspecialchars($seoDesc, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($seoKw, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($seoOgUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($seoOgImage, ENT_QUOTES, 'UTF-8') ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= htmlspecialchars($seoOgUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($seoOgImage, ENT_QUOTES, 'UTF-8') ?>">

    <!-- Google Fonts: Inter, Montserrat, Noto Serif Sinhala, Noto Serif Tamil -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&family=Noto+Serif+Sinhala:wght@400;500;600;700&family=Noto+Serif+Tamil:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon / Tab Emblem -->
    <?php
    $emblem_path = dirname(__DIR__) . '/assets/img/emblem.png';
    $emblem_version = file_exists($emblem_path) ? filemtime($emblem_path) : time();
    ?>
    <link rel="icon" href="assets/img/emblem.png?v=<?= $emblem_version ?>" type="image/png">

    <!-- Tailwind Play CDN for instant dynamic styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '#13273F',
              secondary: '#4E0911',
            },
            fontFamily: {
              montserrat: ['Montserrat', 'sans-serif'],
              inter: ['Inter', 'sans-serif'],
              noto: ['Noto Serif Sinhala', 'Noto Serif Tamil', 'serif']
            }
          }
        }
      }
    </script>

    <!-- Compiled Tailwind and Custom CSS -->
    <?php
    $css_path = dirname(__DIR__) . '/assets/css/style.css';
    $css_version = file_exists($css_path) ? filemtime($css_path) : time();
    ?>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= $css_version ?>">

    <!-- AOS CSS for smooth scroll animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Language specific font overrides -->
    <?php if ($current_lang === 'si'): ?>
    <style>
        body, h1, h2, h3, h4, h5, h6, p, a, span, div, button, input, select, textarea, .font-inter, .font-montserrat {
            font-family: 'Noto Serif Sinhala', serif !important;
        }
    </style>
    <?php elseif ($current_lang === 'ta'): ?>
    <style>
        body, h1, h2, h3, h4, h5, h6, p, a, span, div, button, input, select, textarea, .font-inter, .font-montserrat {
            font-family: 'Noto Serif Tamil', serif !important;
        }
    </style>
    <?php endif; ?>

    <style>
        html, body {
            overflow-x: clip !important;
        }
        /* Hide Google Translate top frame, tooltips, and hover popups completely */
        iframe.goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate,
        #goog-gt-tt,
        #goog-gt-tt *,
        .goog-te-balloon-frame,
        .goog-te-balloon-frame *,
        .goog-tooltip,
        .goog-tooltip *,
        .VIpgJd-ZVi9od-ORHb-OEVmcd,
        .VIpgJd-ZVi9od-aZ2wEe-wOHMyf,
        .VIpgJd-yA02fl-b9fd4c-dgl2Hf,
        .VIpgJd-yA02fl-b9fd4c-SmR85d,
        div[id*="goog"],
        iframe[id*="goog"],
        div.skiptranslate { 
            display: none !important; 
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
        
        font, 
        font:hover, 
        font:focus, 
        font:active, 
        font *, 
        .goog-text-highlight,
        .goog-text-highlight:hover,
        .goog-text-highlight:focus,
        .goog-text-highlight:active,
        [class*="goog-text-highlight"],
        [aria-describedby],
        [aria-describedby]:hover,
        font[style*="background-color"],
        span[style*="background-color"],
        font[style*="background"],
        span[style*="background"] { 
            background-color: transparent !important; 
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            outline: none !important;
            text-shadow: none !important;
        }
        body { top: 0px !important; position: relative !important; }
        #google_translate_element { display: none !important; }
    </style>
    <script>
        // Intercept mouse events on Google Translate elements to block hover timers & popups
        ['mouseover', 'mouseenter', 'mousemove'].forEach(function(eventType) {
            document.addEventListener(eventType, function(e) {
                if (e.target && (
                    e.target.tagName === 'FONT' || 
                    (e.target.closest && e.target.closest('font')) ||
                    (e.target.classList && e.target.classList.contains('goog-text-highlight')) ||
                    (e.target.hasAttribute && (e.target.hasAttribute('goog-tab-index') || e.target.hasAttribute('aria-describedby')))
                )) {
                    e.stopPropagation();
                }
            }, true);
        });

        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
            return "";
        }

        function getActiveLanguage() {
            var gt = getCookie('googtrans');
            if (gt) {
                var decoded = decodeURIComponent(gt);
                if (decoded.endsWith('/si') || decoded.indexOf('/si') !== -1) return 'si';
                if (decoded.endsWith('/ta') || decoded.indexOf('/ta') !== -1) return 'ta';
                if (decoded.endsWith('/en') || decoded.indexOf('/en/en') !== -1) return 'en';
            }
            var lang = getCookie('lang');
            if (lang && ['en', 'si', 'ta'].includes(lang)) {
                return lang;
            }
            return 'en';
        }

        function syncTopbarLanguageUI(targetLang) {
            var currentLang = targetLang || getActiveLanguage();
            
            // Desktop topbar buttons
            var desktopBtns = document.querySelectorAll('#lang-selector-desktop button[data-lang]');
            desktopBtns.forEach(function(btn) {
                var lang = btn.getAttribute('data-lang');
                if (lang === currentLang) {
                    btn.className = "lang-btn bg-yellow-400 text-primary shadow-md font-bold px-3 py-1 rounded-full transition-all duration-300 text-[11px]";
                } else {
                    btn.className = "lang-btn text-white/70 hover:text-white hover:bg-white/10 font-medium px-3 py-1 rounded-full transition-all duration-300 text-[11px]";
                }
            });

            // Mobile drawer buttons
            var mobileBtns = document.querySelectorAll('#lang-selector-mobile button[data-lang]');
            mobileBtns.forEach(function(btn) {
                var lang = btn.getAttribute('data-lang');
                if (lang === currentLang) {
                    btn.className = "lang-btn-mobile bg-primary text-white shadow-sm font-bold py-2 text-center rounded-lg transition-all duration-200 text-xs";
                } else {
                    btn.className = "lang-btn-mobile text-gray-600 hover:text-gray-900 font-medium py-2 text-center rounded-lg transition-all duration-200 text-xs";
                }
            });
        }

        function changeLanguage(langCode) {
            document.cookie = "lang=" + langCode + "; path=/; max-age=" + (86400 * 30);
            if (langCode === 'en') {
                document.cookie = "googtrans=/en/en; path=/";
                document.cookie = "googtrans=/en/en; domain=." + document.domain + "; path=/";
                var host = window.location.hostname;
                var parts = host.split('.');
                while (parts.length >= 2) {
                    var domain = parts.join('.');
                    document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + domain;
                    document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + domain;
                    parts.shift();
                }
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            } else {
                document.cookie = "googtrans=/en/" + langCode + "; path=/";
                document.cookie = "googtrans=/en/" + langCode + "; domain=." + document.domain + "; path=/";
            }
            syncTopbarLanguageUI(langCode);
            var url = new URL(window.location.href);
            if (langCode === 'en') {
                url.searchParams.delete('lang');
            } else {
                url.searchParams.set('lang', langCode);
            }
            window.location.href = url.toString();
        }
        
        function applyAutoTranslation() {
            var activeLang = getActiveLanguage();
            if (activeLang && activeLang !== 'en') {
                var combo = document.querySelector('.goog-te-combo');
                if (combo && combo.value !== activeLang) {
                    combo.value = activeLang;
                    combo.dispatchEvent(new Event('change'));
                }
            }
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,si,ta', autoDisplay: false}, 'google_translate_element');
            syncTopbarLanguageUI();
            
            // Fallback retry checks to guarantee translation fires without requiring page refresh
            setTimeout(applyAutoTranslation, 150);
            setTimeout(applyAutoTranslation, 600);
            setTimeout(applyAutoTranslation, 1200);
        }

        document.addEventListener('DOMContentLoaded', function() {
            syncTopbarLanguageUI();
            var activeLang = getActiveLanguage();
            if (activeLang && activeLang !== 'en') {
                document.cookie = "googtrans=/en/" + activeLang + "; path=/";
            }
        });
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>

<body class="bg-white text-gray-800 antialiased scroll-smooth flex flex-col min-h-screen">
    <div id="google_translate_element"></div>

    <!-- Top Bar -->
    <div class="hidden md:flex bg-gradient-to-r from-primary via-[#2D2D43] to-primary text-white/90 text-[11px] md:text-xs h-10 px-4 md:px-8 flex-row justify-between items-center font-inter border-b border-white/10 relative z-40 shadow-inner">
        <div class="flex flex-wrap gap-x-2 gap-y-2 items-center mb-2 md:mb-0 justify-center md:justify-start notranslate">
            <a href="mailto:info@labourmin.gov.lk" class="flex items-center space-x-2 hover:bg-white/10 hover:text-white px-2.5 py-1.5 rounded-md transition-all duration-200 group">
                <svg class="w-3.5 h-3.5 text-yellow-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium tracking-wide">info@labourmin.gov.lk</span>
            </a>
            <span class="text-white/20">|</span>
            <a href="tel:0112581991" class="flex items-center space-x-2 hover:bg-white/10 hover:text-white px-2.5 py-1.5 rounded-md transition-all duration-200 group">
                <svg class="w-3.5 h-3.5 text-yellow-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <span class="font-medium tracking-wide"><?= htmlspecialchars(t('topbar_tel')) ?></span>
            </a>
            <span class="text-white/20">|</span>
            <span class="flex items-center space-x-2 px-2.5 py-1.5 text-white/70">
                <svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span class="font-medium tracking-wide"><?= htmlspecialchars(t('topbar_fax')) ?></span>
            </span>
        </div>
        
        <div class="flex space-x-6 items-center">
            <!-- Social Icons -->
            <div class="flex space-x-2 text-white/90">
                <a href="https://www.facebook.com/labourmin" aria-label="Facebook Link" target="_blank" class="bg-white/5 hover:bg-[#1877F2] hover:text-white p-1.5 rounded-full transition-all duration-300 shadow-sm"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" /></svg></a>
                <a href="https://web.whatsapp.com/send?phone=94777123456&amp;text=" aria-label="WhatsApp Link" target="_blank" class="bg-white/5 hover:bg-[#25D366] hover:text-white p-1.5 rounded-full transition-all duration-300 shadow-sm"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                <a href="https://youtube.com/@ministryoflabourandforeign191?si=9CZRGi72hNk2wGIz" aria-label="YouTube Link" target="_blank" class="bg-white/5 hover:bg-[#FF0000] hover:text-white p-1.5 rounded-full transition-all duration-300 shadow-sm"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" /></svg></a>
            </div>
            
            <!-- Language Selector -->
            <div id="lang-selector-desktop" class="flex items-center bg-black/20 rounded-full p-1 border border-white/5 shadow-inner backdrop-blur-sm notranslate">
                <button onclick="changeLanguage('si')" data-lang="si" class="<?= $current_lang === 'si' ? 'bg-yellow-400 text-primary shadow-md font-bold' : 'text-white/70 hover:text-white hover:bg-white/10 font-medium' ?> px-3 py-1 rounded-full transition-all duration-300 text-[11px]" style="font-family: 'Noto Serif Sinhala', serif;">සිංහල</button>
                <button onclick="changeLanguage('ta')" data-lang="ta" class="<?= $current_lang === 'ta' ? 'bg-yellow-400 text-primary shadow-md font-bold' : 'text-white/70 hover:text-white hover:bg-white/10 font-medium' ?> px-3 py-1 rounded-full transition-all duration-300 text-[11px]" style="font-family: 'Noto Serif Tamil', serif;">தமிழ்</button>
                <button onclick="changeLanguage('en')" data-lang="en" class="<?= $current_lang === 'en' ? 'bg-yellow-400 text-primary shadow-md font-bold' : 'text-white/70 hover:text-white hover:bg-white/10 font-medium' ?> px-3 py-1 rounded-full transition-all duration-300 font-inter text-[11px] tracking-wide">English</button>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header
        class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm transition-all duration-300"
        id="main-header">
        <div class="container mx-auto px-4 md:px-8 py-3.5 flex justify-between items-center">
            <!-- Logo Area -->
            <div class="flex items-center">
                <a href="home" class="block">
                    <?php
                    $logo_black_path = dirname(__DIR__) . '/assets/img/logo-black.png';
                    $logo_black_version = file_exists($logo_black_path) ? filemtime($logo_black_path) : time();
                    ?>
                    <img src="assets/img/logo-black.png?v=<?= $logo_black_version ?>" alt="Ministry of Labour - Government of Sri Lanka"
                        class="h-12 md:h-14 w-auto object-contain">
                </a>
            </div>

            <?php
            $nav_spacing_class = ($current_lang === 'ta') ? 'space-x-2 xl:space-x-3 2xl:space-x-4 text-[12.5px]' : 'space-x-3 xl:space-x-4 2xl:space-x-6 text-[13px]';
            $contact_btn_class = 'px-4 h-9 text-xs';
            ?>
            <!-- Desktop Navigation with Interactive Dropdowns -->
            <nav class="hidden xl:flex items-center <?= $nav_spacing_class ?> font-bold text-gray-700 notranslate whitespace-nowrap">
                <a href="home" class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'index' || $current_page == '') ? 'text-primary border-primary' : 'hover:text-secondary border-transparent hover:border-secondary/60' ?> whitespace-nowrap"><?= htmlspecialchars($nav_trans['home'][$current_lang] ?? 'Home') ?></a>

                <a href="about-us"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'about-us') ? 'text-primary border-primary' : 'hover:text-secondary border-transparent hover:border-secondary/60' ?> whitespace-nowrap"><?= htmlspecialchars($nav_trans['about_us'][$current_lang] ?? 'About Us') ?></a>

                <div class="relative group">
                    <a href="iau" class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'iau' || $current_page == 'iau-updates') ? 'text-primary border-primary' : 'border-transparent hover:text-secondary hover:border-secondary/60' ?> flex items-center gap-1 focus:outline-none cursor-pointer whitespace-nowrap">
                        <?= htmlspecialchars($nav_trans['iau'][$current_lang] ?? 'IAU') ?>
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <!-- Dropdown -->
                    <div class="absolute left-0 mt-0 w-48 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                        <div class="py-1">
                            <a href="iau" class="block px-4 py-2.5 text-[13px] hover:bg-secondary/5 hover:text-secondary <?= ($current_page == 'iau') ? 'bg-gray-50 text-primary font-bold' : 'text-gray-700' ?>"><?= htmlspecialchars($nav_trans['overview'][$current_lang] ?? 'Overview') ?></a>
                            <a href="iau-updates" class="block px-4 py-2.5 text-[13px] hover:bg-secondary/5 hover:text-secondary <?= ($current_page == 'iau-updates') ? 'bg-gray-50 text-primary font-bold' : 'text-gray-700' ?>"><?= htmlspecialchars($nav_trans['current_updates'][$current_lang] ?? 'Current Updates') ?></a>
                        </div>
                    </div>
                </div>

                <a href="rti"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'rti') ? 'text-primary border-primary' : 'hover:text-secondary border-transparent hover:border-secondary/60' ?> whitespace-nowrap"><?= htmlspecialchars($nav_trans['rti'][$current_lang] ?? 'RTI') ?></a>

                <div class="relative group">
                    <a href="learning-platforms" class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'learning-platforms' || $current_page == 'learning-platforms-local' || $current_page == 'learning-platforms-foreign') ? 'text-primary border-primary' : 'border-transparent hover:text-secondary hover:border-secondary/60' ?> flex items-center gap-1 focus:outline-none cursor-pointer whitespace-nowrap">
                        <?= htmlspecialchars($nav_trans['learning_platforms'][$current_lang] ?? 'Learning Platforms') ?>
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <!-- Dropdown -->
                    <div class="absolute left-0 mt-0 w-48 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                        <div class="py-1">
                            <a href="learning-platforms-local" class="block px-4 py-2.5 text-[13px] hover:bg-secondary/5 hover:text-secondary <?= ($current_page == 'learning-platforms-local') ? 'bg-gray-50 text-primary font-bold' : 'text-gray-700' ?>"><?= htmlspecialchars($nav_trans['local_publications'][$current_lang] ?? 'Local Publications') ?></a>
                            <a href="learning-platforms-foreign" class="block px-4 py-2.5 text-[13px] hover:bg-secondary/5 hover:text-secondary <?= ($current_page == 'learning-platforms-foreign') ? 'bg-gray-50 text-primary font-bold' : 'text-gray-700' ?>"><?= htmlspecialchars($nav_trans['foreign_publications'][$current_lang] ?? 'Foreign Publications') ?></a>
                        </div>
                    </div>
                </div>

                <div class="relative group">
                    <button class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'procurements' || $current_page == 'vacancies' || $current_page == 'special-notices') ? 'text-primary border-primary' : 'border-transparent hover:text-secondary hover:border-secondary/60' ?> flex items-center gap-1 focus:outline-none cursor-pointer whitespace-nowrap">
                        <?= htmlspecialchars($nav_trans['announcements'][$current_lang] ?? 'Announcements') ?>
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute left-0 mt-0 w-48 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform translate-y-2 group-hover:translate-y-0 overflow-hidden">
                        <div class="py-1">
                            <a href="procurements" class="block px-4 py-2.5 text-[13px] hover:bg-secondary/5 hover:text-secondary <?= ($current_page == 'procurements') ? 'bg-gray-50 text-primary font-bold' : 'text-gray-700' ?>"><?= htmlspecialchars($nav_trans['procurements'][$current_lang] ?? 'Procurements') ?></a>
                            <a href="vacancies" class="block px-4 py-2.5 text-[13px] hover:bg-secondary/5 hover:text-secondary <?= ($current_page == 'vacancies') ? 'bg-gray-50 text-primary font-bold' : 'text-gray-700' ?>"><?= htmlspecialchars($nav_trans['vacancies'][$current_lang] ?? 'Vacancies') ?></a>
                            <a href="special-notices" class="block px-4 py-2.5 text-[13px] hover:bg-secondary/5 hover:text-secondary <?= ($current_page == 'special-notices') ? 'bg-gray-50 text-primary font-bold' : 'text-gray-700' ?>"><?= htmlspecialchars($nav_trans['special_notices'][$current_lang] ?? 'Special Notices') ?></a>
                        </div>
                    </div>
                </div>

                <a href="news"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'news') ? 'text-primary border-primary' : 'hover:text-secondary border-transparent hover:border-secondary/60' ?> whitespace-nowrap"><?= htmlspecialchars($nav_trans['news'][$current_lang] ?? 'News') ?></a>

                <a href="downloads"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'downloads') ? 'text-primary border-primary' : 'hover:text-secondary border-transparent hover:border-secondary/60' ?> whitespace-nowrap"><?= htmlspecialchars($nav_trans['downloads'][$current_lang] ?? 'Downloads') ?></a>

                <a href="contact-us"
                    class="bg-secondary text-white <?= $contact_btn_class ?> flex items-center justify-center rounded-lg hover:bg-[#320000] transition-all duration-300 hover:shadow-md font-medium tracking-wider uppercase active:scale-95 whitespace-nowrap shrink-0"><?= htmlspecialchars($nav_trans['contact_us'][$current_lang] ?? 'Contact Us') ?></a>

                <div class="h-5 w-px bg-gray-200 mx-2 shrink-0"></div>

                <!-- Search Button -->
                <div class="relative flex items-center">
                    <button id="search-btn" aria-label="Search"
                        class="text-gray-400 hover:text-primary p-1.5 hover:bg-gray-50 rounded-lg transition-all duration-200 flex items-center justify-center shrink-0 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </nav>

            <!-- Mobile Menu Trigger Buttons -->
            <div class="flex items-center space-x-2 xl:hidden">
                <!-- Mobile Search Button -->
                <button id="mobile-search-btn" aria-label="Search"
                    class="text-gray-400 hover:text-primary p-1.5 hover:bg-gray-50 rounded-lg transition-all duration-200 flex items-center justify-center shrink-0 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Mobile Menu Hamburger Trigger -->
                <button id="mobile-menu-trigger" aria-label="Open Mobile Menu"
                    class="text-primary hover:bg-gray-50 p-1.5 rounded-lg focus:outline-none transition-colors duration-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Expanding Search Panel (Pops under search icon and header, flush with bottom border) -->
        <div id="search-bar-container"
            class="absolute right-4 md:right-8 top-full bg-white border-l border-r border-b border-gray-200 rounded-b-2xl shadow-[0_15px_30px_rgba(19,39,63,0.1)] z-55 w-0 overflow-hidden opacity-0 pointer-events-none transition-all duration-300">
            <div class="p-3 w-[calc(100vw-2rem)] sm:w-80 md:w-96">
                <div class="relative flex items-center bg-gray-50 border border-gray-200 rounded-xl px-2.5 py-1.5 focus-within:border-secondary focus-within:ring-2 focus-within:ring-secondary/15 transition-all">
                    <svg class="w-3.5 h-3.5 text-gray-450 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="header-search-input" placeholder="<?= htmlspecialchars(t('search_placeholder')) ?>"
                        class="w-full bg-transparent text-xs font-inter focus:outline-none pr-6 pl-0.5 placeholder-gray-400 text-gray-900">
                    <button id="search-close-btn"
                        class="absolute right-2.5 text-gray-400 hover:text-gray-655 focus:outline-none cursor-pointer p-0.5 rounded-full hover:bg-gray-200/50 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Search Suggestions Container inside the popover panel -->
                <div id="search-suggestions-container" class="mt-2.5 max-h-64 overflow-y-auto custom-scrollbar hidden border-t border-gray-100 pt-2">
                    <!-- Dynamic suggestions list -->
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Slide-out Menu Drawer -->
    <div id="mobile-menu"
        class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-[100] opacity-0 pointer-events-none invisible transition-all duration-300">
        <div id="mobile-menu-drawer"
            class="absolute right-0 top-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-2xl p-6 flex flex-col transform translate-x-full transition-transform duration-300 ease-out overflow-y-auto">
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                <div class="flex items-center">
                    <a href="home" class="block">
                        <img src="assets/img/logo-black.png?v=<?= $logo_black_version ?>" alt="Ministry of Labour - Government of Sri Lanka" class="h-10 w-auto object-contain">
                    </a>
                </div>
                <button id="mobile-menu-close" aria-label="Close Mobile Menu"
                    class="p-1 rounded-lg text-gray-400 hover:text-primary hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <nav class="flex-grow flex flex-col space-y-4 font-inter text-[13px] font-bold text-gray-700 notranslate">
                <a href="home"
                    class="pl-3 py-1 <?= ($current_page == 'index' || $current_page == '') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['home'][$current_lang] ?? 'Home') ?></a>
                <a href="about-us" class="pl-3 py-1 <?= ($current_page == 'about-us') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['about_us'][$current_lang] ?? 'About Us') ?></a>
                <div class="flex flex-col space-y-2 py-1">
                    <a href="iau" class="pl-3 text-gray-700 hover:text-secondary font-bold uppercase tracking-wider text-[11px] flex items-center gap-1 transition-colors">
                        <?= htmlspecialchars($nav_trans['iau'][$current_lang] ?? 'IAU') ?>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="iau" class="pl-6 py-1 <?= ($current_page == 'iau') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'text-gray-500 hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['overview'][$current_lang] ?? 'Overview') ?></a>
                    <a href="iau-updates" class="pl-6 py-1 <?= ($current_page == 'iau-updates') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'text-gray-500 hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['current_updates'][$current_lang] ?? 'Current Updates') ?></a>
                </div>
                <a href="rti" class="pl-3 py-1 <?= ($current_page == 'rti') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['rti'][$current_lang] ?? 'RTI') ?></a>

                <div class="flex flex-col space-y-2 py-1">
                    <a href="learning-platforms" class="pl-3 text-gray-700 hover:text-secondary font-bold uppercase tracking-wider text-[11px] flex items-center gap-1 transition-colors">
                        <?= htmlspecialchars($nav_trans['learning_platforms'][$current_lang] ?? 'Learning Platforms') ?>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="learning-platforms-local" class="pl-6 py-1 <?= ($current_page == 'learning-platforms-local') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'text-gray-500 hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['local_publications'][$current_lang] ?? 'Local Publications') ?></a>
                    <a href="learning-platforms-foreign" class="pl-6 py-1 <?= ($current_page == 'learning-platforms-foreign') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'text-gray-500 hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['foreign_publications'][$current_lang] ?? 'Foreign Publications') ?></a>
                </div>

                <div class="flex flex-col space-y-2 py-1">
                    <div class="pl-3 text-gray-700 font-bold uppercase tracking-wider text-[11px]"><?= htmlspecialchars($nav_trans['announcements'][$current_lang] ?? 'Announcements') ?></div>
                    <a href="procurements" class="pl-6 py-1 <?= ($current_page == 'procurements') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'text-gray-500 hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['procurements'][$current_lang] ?? 'Procurements') ?></a>
                    <a href="vacancies" class="pl-6 py-1 <?= ($current_page == 'vacancies') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'text-gray-500 hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['vacancies'][$current_lang] ?? 'Vacancies') ?></a>
                    <a href="special-notices" class="pl-6 py-1 <?= ($current_page == 'special-notices') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'text-gray-500 hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['special_notices'][$current_lang] ?? 'Special Notices') ?></a>
                </div>
                <a href="news" class="pl-3 py-1 <?= ($current_page == 'news') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['news'][$current_lang] ?? 'News') ?></a>
                <a href="downloads" class="pl-3 py-1 <?= ($current_page == 'downloads') ? 'text-primary bg-gray-50 border-l-4 border-primary rounded-r-md' : 'hover:text-secondary rounded transition-colors' ?>"><?= htmlspecialchars($nav_trans['downloads'][$current_lang] ?? 'Downloads') ?></a>
            </nav>

            <div class="border-t border-gray-100 pt-6 mt-6 flex flex-col space-y-4 notranslate">
                <!-- Mobile Language Selector -->
                <div class="pb-2">
                    <div class="text-[11px] uppercase tracking-wider text-gray-400 font-bold mb-2.5 pl-1">Select Language</div>
                    <div id="lang-selector-mobile" class="grid grid-cols-3 gap-2 bg-gray-50 rounded-xl p-1 border border-gray-200/50 notranslate">
                        <button onclick="changeLanguage('si')" data-lang="si" class="<?= $current_lang === 'si' ? 'bg-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-medium' ?> py-2 text-center rounded-lg transition-all duration-200 text-xs" style="font-family: 'Noto Serif Sinhala', serif;">සිංහල</button>
                        <button onclick="changeLanguage('ta')" data-lang="ta" class="<?= $current_lang === 'ta' ? 'bg-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-medium' ?> py-2 text-center rounded-lg transition-all duration-200 text-xs" style="font-family: 'Noto Serif Tamil', serif;">தமிழ்</button>
                        <button onclick="changeLanguage('en')" data-lang="en" class="<?= $current_lang === 'en' ? 'bg-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900 font-medium' ?> py-2 text-center rounded-lg transition-all duration-200 font-inter text-xs tracking-wide">English</button>
                    </div>
                </div>

                <a href="contact-us"
                    class="bg-secondary text-white text-center py-2.5 rounded-lg hover:bg-[#320000] transition-colors shadow-sm font-semibold text-xs tracking-wider uppercase"><?= htmlspecialchars($nav_trans['contact_us'][$current_lang] ?? 'Contact Us') ?></a>
                <div class="flex justify-center space-x-5 text-gray-400 py-2">
                    <a href="https://www.facebook.com/labourmin" aria-label="Facebook Link" target="_blank" class="hover:text-[#1877F2] transition-colors duration-200"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg></a>
                    <a href="https://web.whatsapp.com/send?phone=94777123456&amp;text=" aria-label="WhatsApp Link" target="_blank" class="hover:text-[#25D366] transition-colors duration-200"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg></a>
                    <a href="https://youtube.com/@ministryoflabourandforeign191?si=9CZRGi72hNk2wGIz" aria-label="YouTube Link" target="_blank" class="hover:text-[#FF0000] transition-colors duration-200"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Language Selector Popup Modal -->
    <?php if (!isset($_COOKIE['lang'])): ?>
        <div id="mobile-lang-popup" class="md:hidden fixed inset-0 bg-primary/60 backdrop-blur-sm z-[200] flex items-end justify-center transition-opacity duration-300 ease-out opacity-0 pointer-events-none">
            <div class="bg-white w-full rounded-t-[2rem] p-6 pb-8 transform translate-y-full transition-transform duration-300 ease-out max-w-md mx-auto shadow-2xl relative border-t border-gray-100 flex flex-col items-center">
                <!-- Drag Handle indicator -->
                <div class="w-12 h-1 bg-gray-200 rounded-full mb-6"></div>
                
                <h3 class="text-sm font-bold text-gray-900 font-montserrat mb-2 text-center">Select Language / භාෂාව තෝරන්න / மொழியைத் தேர்ந்தெடுக்கவும்</h3>
                <p class="text-[11px] text-gray-500 font-inter mb-6 text-center">Choose your preferred language to continue</p>
                
                <div class="w-full flex flex-col gap-3 notranslate">
                    <button onclick="changeLanguage('si')" class="w-full bg-gray-50 hover:bg-primary/5 hover:text-primary border border-gray-200/60 rounded-2xl py-3.5 px-4 font-bold text-primary text-sm flex items-center justify-between transition-all active:scale-98" style="font-family: 'Noto Serif Sinhala', serif;">
                        <span>සිංහල</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    <button onclick="changeLanguage('ta')" class="w-full bg-gray-50 hover:bg-primary/5 hover:text-primary border border-gray-200/60 rounded-2xl py-3.5 px-4 font-bold text-primary text-sm flex items-center justify-between transition-all active:scale-98" style="font-family: 'Noto Serif Tamil', serif;">
                        <span>தமிழ்</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    <button onclick="changeLanguage('en')" class="w-full bg-gray-50 hover:bg-primary/5 hover:text-primary border border-gray-200/60 rounded-2xl py-3.5 px-4 font-bold text-primary text-sm font-inter flex items-center justify-between transition-all active:scale-98">
                        <span>English</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
                
                <button onclick="closeMobileLangPopup()" class="mt-5 text-[11px] text-gray-400 font-semibold hover:text-gray-600 transition-colors uppercase tracking-wider py-2 cursor-pointer">
                    Dismiss
                </button>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Show the popup on mobile if no language cookie is set and not prompted this session
                if (window.innerWidth < 768 && !sessionStorage.getItem('lang_prompted')) {
                    const popup = document.getElementById('mobile-lang-popup');
                    const drawer = popup.querySelector('div');
                    popup.classList.remove('pointer-events-none');
                    setTimeout(() => {
                        popup.classList.remove('opacity-0');
                        drawer.classList.remove('translate-y-full');
                    }, 300);
                }
            });
            
            function closeMobileLangPopup() {
                sessionStorage.setItem('lang_prompted', 'true');
                const popup = document.getElementById('mobile-lang-popup');
                const drawer = popup.querySelector('div');
                drawer.classList.add('translate-y-full');
                popup.classList.add('opacity-0');
                setTimeout(() => {
                    popup.classList.add('pointer-events-none');
                }, 300);
            }
        </script>
    <?php endif; ?>

    <main id="main-content" class="flex-grow animate-fade-in">