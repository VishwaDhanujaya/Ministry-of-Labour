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
?>
<!-- Sub-Hero Section -->
<section class="relative h-[180px] sm:h-[220px] md:h-[260px] flex items-center bg-primary overflow-hidden notranslate">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/sub-hero.webp');"></div>
    <div class="absolute inset-0 opacity-70 bg-sub-hero-gradient">
    </div>

    <div class="relative z-10 container mx-auto px-4 md:px-16 text-white w-full">
        <h1 class="text-xl sm:text-3xl md:text-4xl lg:text-5xl font-semibold font-montserrat mb-2.5 leading-tight tracking-tight <?= isset($title_classes) ? $title_classes : ''; ?>">
            <?= $display_title ?>
        </h1>
        <div class="flex items-center text-[12px] md:text-[13px] font-inter text-gray-300 flex-wrap gap-y-1">
            <a href="home" class="hover:text-white transition-colors"><?= t('home') ?></a>
            <?php
            if (isset($breadcrumbs) && is_array($breadcrumbs)) {
                foreach ($breadcrumbs as $index => $crumb) {
                    $crumb_label = resolve_subhero_translation($crumb['label']);
                    echo '<span class="mx-2 text-gray-400">/</span>';
                    if ($index === count($breadcrumbs) - 1) {
                        // Last item is plain white text
                        echo '<span class="text-white font-medium">' . htmlspecialchars($crumb_label) . '</span>';
                    } else {
                        // Intermediate items
                        $crumb_url = isset($crumb['url']) ? htmlspecialchars($crumb['url']) : '#';
                        echo '<a href="' . $crumb_url . '" class="hover:text-white transition-colors">' . htmlspecialchars($crumb_label) . '</a>';
                    }
                }
            } else if (isset($page_title)) {
                 $clean_crumb = resolve_subhero_translation(strip_tags($page_title));
                 echo '<span class="mx-2 text-gray-400">/</span>';
                 echo '<span class="text-white font-medium">' . htmlspecialchars($clean_crumb) . '</span>';
            }
            ?>
        </div>
    </div>
</section>

