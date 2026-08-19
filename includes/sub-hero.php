<?php
/**
 * Shared Sub-Hero Header Component
 * Subhero section with responsive background gradient, page title, and breadcrumbs.
 * Wrapped in class="notranslate" with dynamic trilingual resolution via t() helper.
 */

if (!function_exists('resolve_subhero_translation')) {
    function resolve_subhero_translation(string $text): string {
        if (empty($text)) return '';
        
        // Map English Page Titles / Breadcrumbs to dictionary keys
        $title_map = [
            'Home' => 'home',
            'About Us' => 'about_us',
            'IAU' => 'iau',
            'Overview' => 'overview',
            'Current Updates' => 'current_updates',
            'IAU Updates' => 'iau_updates',
            'RTI' => 'rti',
            'Right to Information' => 'rti',
            'Learning Platforms' => 'learning_platforms',
            'Local Publications' => 'local_publications',
            'Foreign Publications' => 'foreign_publications',
            'Announcements' => 'announcements',
            'Procurements' => 'procurements',
            'Vacancies' => 'vacancies',
            'Special Notices' => 'special_notices',
            'News' => 'news',
            'News Updates' => 'ql_news_updates',
            'Latest Insights' => 'latest_insights',
            'Recent Posts' => 'recent_posts',
            'Our Blog' => 'our_blog',
            'Downloads' => 'downloads',
            'Contact Us' => 'contact_us',
            'Complaints' => 'complaints',
            'National Labour Advisory Council' => 'nlac_full',
            'Ampara Circuit Bungalow' => 'ampara_bungalow',
            'Ampara Circuit Bungalow Booking' => 'ampara_booking',
        ];
        
        $clean = trim(strip_tags($text));
        
        if (isset($title_map[$clean])) {
            $translated = t($title_map[$clean]);
            
            // Preserve HTML tags (like <span>(RTI)</span> or <span>(Internal Affairs Unit)</span>) if present
            if (strpos($text, '<span') !== false) {
                return preg_replace('/^([^<]+)/u', $translated . ' ', $text);
            }
            return $translated;
        }
        
        // Special case for IAU sub-hero title with (Internal Affairs Unit)
        if (strpos($text, 'Internal Affairs Unit') !== false) {
            $translated_sub = t('iau_sub_title');
            return preg_replace('/\(Internal Affairs Unit\)/u', $translated_sub, $text);
        }
        
        return $text;
    }
}

$display_title = isset($page_title) ? resolve_subhero_translation($page_title) : t('home');

// Determine dynamic sub-hero image path based on $current_page
$sub_hero_img = 'assets/img/sub-hero.webp'; // Default fallback
if (isset($current_page)) {
    switch ($current_page) {
        case 'about-us':
            $sub_hero_img = 'assets/img/sub-hero/about-us.webp';
            break;
        case 'iau':
        case 'iau-updates':
            $sub_hero_img = 'assets/img/sub-hero/IAU.webp';
            break;
        case 'rti':
            $sub_hero_img = 'assets/img/sub-hero/RTI.webp';
            break;
        case 'procurements':
        case 'vacancies':
        case 'special-notices':
            $sub_hero_img = 'assets/img/sub-hero/announcement.webp';
            break;
        case 'contact-us':
            $sub_hero_img = 'assets/img/sub-hero/contact-us.webp';
            break;
        case 'downloads':
            $sub_hero_img = 'assets/img/sub-hero/downloads.webp';
            break;
        case 'learning-platforms':
        case 'learning-platforms-local':
        case 'learning-platforms-foreign':
            $sub_hero_img = 'assets/img/sub-hero/learning-platform.webp';
            break;
        case 'news':
            $sub_hero_img = 'assets/img/sub-hero/news.webp';
            break;
        case 'news-single':
            $sub_hero_img = 'assets/img/sub-hero/news-single.webp';
            break;
    }
}
?>
<!-- Sub-Hero Section -->
<section class="relative h-[160px] sm:h-[190px] md:h-[220px] flex items-center bg-[#4E0000] overflow-hidden notranslate">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('<?= htmlspecialchars($sub_hero_img) ?>');"></div>
    
    <!-- Clean Minimalist Maroon Overlay Gradients -->
    <div class="hidden sm:block absolute inset-0 pointer-events-none"
         style="background: linear-gradient(90deg, rgba(78, 0, 0, 0.95) 0%, rgba(78, 0, 0, 0.78) 35%, rgba(78, 0, 0, 0.4) 65%, rgba(78, 0, 0, 0.15) 100%);">
    </div>
    <div class="block sm:hidden absolute inset-0 pointer-events-none"
         style="background: linear-gradient(180deg, rgba(78, 0, 0, 0.88) 0%, rgba(78, 0, 0, 0.55) 100%);">
    </div>

    <!-- Content & Breadcrumbs Container -->
    <div class="relative z-10 container mx-auto px-6 sm:px-10 lg:px-16 text-white w-full">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-montserrat mb-2 sm:mb-2.5 leading-tight tracking-tight uppercase text-white <?= isset($title_classes) ? $title_classes : ''; ?>">
            <?= $display_title ?>
        </h1>
        <nav aria-label="Breadcrumb" class="flex items-center text-xs sm:text-[13px] font-inter text-slate-200/90 flex-wrap gap-1.5 sm:gap-2">
            <a href="home" class="inline-flex items-center gap-1.5 hover:text-white transition-colors duration-200">
                <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span><?= t('home') ?></span>
            </a>
            <?php
            if (isset($breadcrumbs) && is_array($breadcrumbs)) {
                foreach ($breadcrumbs as $index => $crumb) {
                    $crumb_label = resolve_subhero_translation($crumb['label']);
                    echo '<span class="text-white/40 font-light">/</span>';
                    if ($index === count($breadcrumbs) - 1) {
                        echo '<span class="text-white font-semibold">' . htmlspecialchars($crumb_label) . '</span>';
                    } else {
                        $crumb_url = isset($crumb['url']) ? htmlspecialchars($crumb['url']) : '#';
                        echo '<a href="' . $crumb_url . '" class="hover:text-white transition-colors duration-200">' . htmlspecialchars($crumb_label) . '</a>';
                    }
                }
            } else if (isset($page_title)) {
                 $clean_crumb = resolve_subhero_translation(strip_tags($page_title));
                 echo '<span class="text-white/40 font-light">/</span>';
                 echo '<span class="text-white font-semibold">' . htmlspecialchars($clean_crumb) . '</span>';
            }
            ?>
        </nav>
    </div>
</section>

