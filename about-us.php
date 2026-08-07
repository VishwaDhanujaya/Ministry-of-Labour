<?php
// about-us.php
require_once 'admin/includes/db.php';
require_once 'includes/officials-service.php';

$top_officials = getTopOfficials($pdo);
$departments   = array_values(array_filter(getDivisions($pdo), function($div) {
    return $div['slug'] !== 'rti-officers';
}));

$page_title = 'About Us';
$pageTitle = 'About Us - Ministry of Labour - Sri Lanka';
$metaDescription = 'Learn about the Ministry of Labour, Sri Lanka, our vision, mission, key officials, and the Citizen Charter outlining our commitment to public service excellence.';
$metaKeywords = 'Ministry of Labour, Sri Lanka, About Us, Vision, Mission, Officials, Departments, Citizen Charter, Public Service';
$pageMeta = [
    'si' => [
        'title' => 'අප ගැන - කම්කරු අමාත්‍යාංශය - ශ්‍රී ලංකාව',
        'desc'  => 'කම්කරු අමාත්‍යාංශය, අපගේ දර්ශනය, මෙහෙවර, ප්‍රධාන නිලධාරීන් සහ පුරවැසි ප්‍රඥප්තිය පිළිබඳ තොරතුරු ලබා ගන්න.',
        'kw'    => 'කම්කරු අමාත්‍යාංශය, ශ්‍රී ලංකාව, අප ගැන, දර්ශනය, මෙහෙවර, නිලධාරීන්'
    ],
    'ta' => [
        'title' => 'எங்களைப் பற்றி - தொழில் அமைச்சு - இலங்கை',
        'desc'  => 'தொழில் அமைச்சு, எமது தொலைநோக்கு, பணி லட்சியம், முக்கிய அதிகாரிகள் பற்றிய தகவல்களை அறிந்துகொள்ளுங்கள்.',
        'kw'    => 'தொழில் அமைச்சு, இலங்கை, எங்களைப் பற்றி, தொலைநோக்கு, அதிகாரிகள்'
    ]
];
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Overview Section -->


<section class="py-20 md:py-28 px-4 md:px-16 bg-white">
    <div class="container mx-auto flex flex-col lg:flex-row gap-16 items-center">
        <!-- Collage -->
        <div class="w-full lg:w-1/2" data-aos="fade-right">
            <div class="grid grid-cols-2 gap-4">
                <img loading="lazy" src="assets/img/about-us/overview-1.webp" alt="Ministry Building"
                    class="w-full h-48 md:h-64 object-cover rounded-2xl md:rounded-3xl shadow-sm hover:scale-[1.02] transition-all duration-500 hover:shadow-md">
                <img loading="lazy" src="assets/img/about-us/overview-2.webp" alt="Official Speaker"
                    class="w-full h-48 md:h-64 object-cover rounded-2xl md:rounded-3xl shadow-sm hover:scale-[1.02] transition-all duration-500 hover:shadow-md">
                <img loading="lazy" src="assets/img/about-us/overview-3.webp" alt="Audience"
                    class="col-span-2 w-full h-64 md:h-80 object-cover rounded-2xl md:rounded-3xl shadow-sm hover:scale-[1.02] transition-all duration-500 hover:shadow-md">
            </div>
        </div>
        <!-- Content -->
        <div class="w-full lg:w-1/2" data-aos="fade-left">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-6 notranslate"><?= t('overview', 'Overview') ?></h2>
            <div class="space-y-4 text-gray-600 font-inter text-[15px] leading-relaxed mb-10 notranslate">
                <p><?= t('overview_p1') ?></p>
                <p><?= t('overview_p2') ?></p>
            </div>

            <div class="about-stats-container">
                <div class="about-stat-card">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number notranslate" translate="no">95</span>
                    <span class="about-stat-label"><?= t('years_of_experience', 'Years of Experience') ?></span>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number notranslate" translate="no">95K</span>
                    <span class="about-stat-label"><?= t('happy_customers', 'Happy Customers') ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Organizations -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-[#F1F5F9] border-t border-b border-slate-200/80 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
    <div class="container mx-auto" data-aos="fade-up">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-8 text-center"><?= t('related_organizations', 'Related Organizations') ?></h2>
        <div id="partners-track"
            class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-10 py-8 justify-items-center items-center">
            <a href="https://www.presidentsoffice.gov.lk/" target="_blank" rel="noopener noreferrer" aria-label="Presidential Secretariat Official Website"
                class="flex justify-center items-center h-20 md:h-28 lg:h-32 w-full group cursor-pointer">
                <img loading="lazy" src="assets/img/about-us/presidential-secretariat.png" alt="Presidential Secretariat"
                    class="max-h-16 md:max-h-24 lg:max-h-28 max-w-[170px] md:max-w-[220px] lg:max-w-[260px] object-contain group-hover:scale-105 transition-transform duration-300">
            </a>
            <a href="https://labourdept.gov.lk/" target="_blank" rel="noopener noreferrer" aria-label="Department of Labour Official Website"
                class="flex justify-center items-center h-20 md:h-28 lg:h-32 w-full group cursor-pointer">
                <img loading="lazy" src="assets/img/about-us/department-of-labour.png" alt="Department of Labour"
                    class="max-h-16 md:max-h-24 lg:max-h-28 max-w-[170px] md:max-w-[220px] lg:max-w-[260px] object-contain group-hover:scale-105 transition-transform duration-300">
            </a>
            <a href="https://www.ilo.org/" target="_blank" rel="noopener noreferrer" aria-label="International Labour Organization Official Website"
                class="flex justify-center items-center h-20 md:h-28 lg:h-32 w-full group cursor-pointer">
                <img loading="lazy" src="assets/img/about-us/ilo.png" alt="International Labour Organization (ILO)"
                    class="max-h-14 md:max-h-20 lg:max-h-22 max-w-[140px] md:max-w-[180px] lg:max-w-[220px] object-contain group-hover:scale-105 transition-transform duration-300">
            </a>
            <a href="https://etfb.lk/" target="_blank" rel="noopener noreferrer" aria-label="Employees' Trust Fund Board Official Website"
                class="flex justify-center items-center h-20 md:h-28 lg:h-32 w-full group cursor-pointer">
                <?php if (file_exists('assets/img/about-us/etf.png')): ?>
                    <img loading="lazy" src="assets/img/about-us/etf.png" alt="Employees' Trust Fund (ETF)"
                        class="max-h-16 md:max-h-24 lg:max-h-28 max-w-[200px] md:max-w-[260px] lg:max-w-[315px] object-contain group-hover:scale-105 transition-transform duration-300">
                <?php else: ?>
                    <div class="h-full w-full max-w-[220px] bg-gray-100 border border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center text-gray-400 font-semibold group-hover:scale-105 transition-transform duration-300 group-hover:border-primary/30">
                        <span class="text-xs text-[#888888] group-hover:text-primary transition-colors text-center px-2 font-inter">Employees' Trust Fund (ETF)</span>
                        <span class="text-[9px] text-[#AAAAAA] uppercase tracking-widest mt-1">Logo Placeholder</span>
                    </div>
                <?php endif; ?>
            </a>
        </div>

        <!-- Sticky Slide Dots -->
        <div class="flex justify-center mt-8 gap-2.5 pb-2" id="partners-dots-container"></div>
    </div>
</section>

<!-- Vision & Mission / Organizational Chart -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row rounded-3xl overflow-hidden shadow-[0_12px_40px_rgba(19,39,63,0.04)] hover:shadow-[0_20px_50px_rgba(19,39,63,0.08)] border border-gray-200/60 transition-all duration-500" data-aos="fade-up">
            <!-- Vision & Mission -->
            <div
                class="w-full lg:w-[63%] bg-gradient-to-br from-primary via-primary to-[#0f1f33] text-white p-8 md:p-12 lg:p-14 flex flex-col justify-center relative overflow-hidden">
                <!-- Ambient Glow Orbs -->
                <div class="absolute -left-12 -top-12 w-64 h-64 bg-secondary/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-secondary/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <!-- Vision Card -->
                <div class="relative z-10 mb-8 flex flex-col sm:flex-row gap-5 items-start group">
                    <div class="w-10 h-10 rounded-full border border-white/20 bg-white/5 flex items-center justify-center shrink-0 transition-transform duration-300 group-hover:scale-105">
                        <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xs font-semibold tracking-widest text-[#B0C4DE] uppercase mb-2 font-inter notranslate">
                            <?= t('about_vision_title', 'Our Vision') ?>
                        </h3>
                        <p class="text-lg md:text-xl font-medium font-montserrat tracking-tight leading-relaxed text-white notranslate">
                            "<?= t('about_vision_text', 'A satisfied, productive labour force') ?>"
                        </p>
                    </div>
                </div>

                <!-- Divider line -->
                <div class="w-full h-px bg-white/10 relative z-10 mb-8"></div>

                <!-- Mission Card -->
                <div class="relative z-10 flex flex-col sm:flex-row gap-5 items-start group">
                    <div class="w-10 h-10 rounded-full border border-white/20 bg-white/5 flex items-center justify-center shrink-0 transition-transform duration-300 group-hover:scale-105">
                        <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xs font-semibold tracking-widest text-[#B0C4DE] uppercase mb-2 font-inter notranslate">
                            <?= t('about_mission_title', 'Our Mission') ?>
                        </h3>
                        <p class="text-[#E2E8F0] font-inter text-[14px] md:text-[15px] leading-relaxed notranslate">
                            "<?= t('about_mission_text') ?>"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Organizational Chart -->
            <div class="w-full lg:w-[37%] bg-white p-8 md:p-10 lg:p-12 flex flex-col justify-center">
                <h3 class="text-2xl md:text-3xl font-bold font-montserrat text-gray-900 mb-6 text-left tracking-tight">
                    Organizational Chart</h3>

                <div
                    class="relative group rounded-2xl border border-gray-200/60 bg-gray-50/50 p-3 max-w-[380px] w-full mr-auto hover:shadow-md hover:border-gray-300 hover:bg-white transition-all duration-300">
                    <a href="javascript:void(0)" onclick="openOrgChart()" class="block">
                        <div class="relative overflow-hidden rounded-xl bg-white border border-gray-100 flex items-center justify-center h-40 md:h-48 lg:h-56">
                            <img loading="lazy" src="assets/img/about-us/organizational-chart.webp" alt="Organizational Chart"
                                class="w-full h-full object-contain cursor-pointer transition-all duration-500 group-hover:scale-105 mix-blend-multiply">
                            
                            <!-- Hover zoom icon overlay -->
                            <div class="absolute inset-0 bg-primary/20 backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center pointer-events-none">
                                <span class="bg-white/95 text-primary text-xs font-bold px-4 py-2 rounded-full shadow-md flex items-center gap-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                                    View Diagram
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Action Buttons -->
                    <div
                        class="absolute bottom-5 right-5 flex items-center bg-white/95 backdrop-blur-sm rounded-lg overflow-hidden border border-gray-200 shadow-sm opacity-90 group-hover:opacity-100 transition-opacity z-20">
                        <button onclick="openOrgChart()"
                            class="p-2 text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors focus:outline-none cursor-pointer"
                            title="Preview (Zoom & Pan)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7" />
                            </svg>
                        </button>
                        <div class="w-px h-5 bg-gray-200"></div>
                        <a href="assets/img/about-us/organizational-chart.webp"
                            download="Ministry_of_Labour_Organizational_Chart.webp"
                            class="p-2 text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors"
                            title="Download">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Zoomable Organizational Chart Modal -->
    <div id="org-chart-modal" class="fixed inset-0 z-[150] hidden flex-col transition-opacity duration-300 opacity-0 bg-black/90 backdrop-blur-sm">
        <button onclick="closeOrgChart()" class="absolute top-4 right-4 md:top-6 md:right-6 z-50 w-11 h-11 bg-black/60 hover:bg-black/80 border border-white/20 text-white rounded-full flex items-center justify-center transition-all cursor-pointer shadow-lg active:scale-95" title="Close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <!-- The flex and m-auto trick ensures smooth centering when small, and correct top-left scrolling when large without instantly swapping classes! -->
        <div class="w-full h-full overflow-auto flex p-4 md:p-8" onclick="if(event.target === this) closeOrgChart()">
            <img id="org-chart-image" loading="lazy" src="assets/img/about-us/organizational-chart.webp" alt="Organizational Chart Full Size" 
                class="bg-white p-2 rounded-lg shadow-2xl cursor-zoom-in transition-all duration-300 ease-out m-auto" 
                style="width: 70%; max-width: 70%; max-height: 75vh; object-fit: contain;"
                onclick="toggleZoom(this)" title="Click to zoom in/out">
        </div>
    </div>
    
    <script>
    let isZoomed = false;
    
    function toggleZoom(img) {
        isZoomed = !isZoomed;
        
        if (isZoomed) {
            // Zoom in: Smoothly animate width and max-dimensions
            const targetWidth = window.innerWidth < 768 ? "300vw" : "150vw";
            img.style.width = targetWidth;
            img.style.maxWidth = targetWidth;
            img.style.maxHeight = targetWidth; // Allow vertical expansion too
            
            img.classList.remove("cursor-zoom-in");
            img.classList.add("cursor-zoom-out");
        } else {
            // Zoom out: Smoothly restore to fit screen
            const initialWidth = window.innerWidth < 768 ? "90%" : "70%";
            const initialMaxHeight = window.innerWidth < 768 ? "85vh" : "75vh";
            img.style.width = initialWidth;
            img.style.maxWidth = initialWidth;
            img.style.maxHeight = initialMaxHeight;
            
            img.classList.remove("cursor-zoom-out");
            img.classList.add("cursor-zoom-in");
        }
    }
    
    function openOrgChart() {
        const m = document.getElementById('org-chart-modal');
        if (m.parentNode !== document.body) {
            document.body.appendChild(m);
        }
        const img = document.getElementById('org-chart-image');
        
        // Reset zoom state on open
        isZoomed = false;
        const initialWidth = window.innerWidth < 768 ? '90%' : '70%';
        const initialMaxHeight = window.innerWidth < 768 ? '85vh' : '75vh';
        img.style.width = initialWidth;
        img.style.maxWidth = initialWidth;
        img.style.maxHeight = initialMaxHeight;
        
        img.classList.remove('cursor-zoom-out');
        img.classList.add('cursor-zoom-in');
        
        m.classList.remove('hidden');
        m.classList.add('flex');
        setTimeout(() => m.classList.remove('opacity-0'), 10);
        document.body.style.overflow = 'hidden';
    }
    
    function closeOrgChart() {
        const m = document.getElementById('org-chart-modal');
        m.classList.add('opacity-0');
        setTimeout(() => {
            m.classList.add('hidden');
            m.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }
    </script>
</section>

<!-- Ministry Leadership & Officials -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-[#F1F5F9] border-t border-b border-slate-200/80 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-10 text-center" data-aos="fade-up">Ministry Leadership</h2>

        <!-- Top Officials -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            <?php foreach ($top_officials as $index => $official): ?>
                <div
                    class="bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-200/60 hover:shadow-[0_15px_45px_rgba(19,39,63,0.05)] hover:-translate-y-1.5 transition-all duration-500 group"
                    data-aos="fade-up"
                    data-aos-delay="<?php echo ($index + 1) * 150; ?>"
                    data-aos-duration="1000">
                    <div class="overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100/60 flex items-center justify-center h-[380px] border-b border-gray-100">
                        <?php if ($official['image']): ?>
                            <img loading="lazy" src="<?php echo $official['image']; ?>" alt="<?php echo $official['name']; ?>"
                                class="w-full h-full object-cover object-top group-hover:scale-[1.03] transition-transform duration-500">
                        <?php else: ?>
                            <svg class="w-24 h-24 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="p-8">
                        <h3 class="text-[17px] font-bold font-montserrat text-primary mb-1">
                            <?php echo !empty($official['title_'.$current_lang]) ? $official['title_'.$current_lang] : $official['title']; ?></h3>
                        <p class="text-gray-500 font-inter text-sm mb-5"><?php echo !empty($official['name_'.$current_lang]) ? $official['name_'.$current_lang] : $official['name']; ?></p>
                        <div class="flex gap-2.5 relative z-10">
                            <?php if ($official['email']): ?>
                                <button
                                    onclick="copyToClipboard('<?php echo trim($official['email']); ?>', 'Email address copied!')"
                                    class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs cursor-pointer"
                                    title="Copy Email: <?php echo trim($official['email']); ?>">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </button>
                            <?php endif; ?>
                            <?php if ($official['phone']): ?>
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $official['phone']); ?>"
                                    class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs cursor-pointer"
                                    title="<?php echo trim($official['phone']); ?>">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($official['fax']): ?>
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $official['fax']); ?>"
                                    class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs cursor-pointer"
                                    title="Fax: <?php echo trim($official['fax']); ?>">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                        <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                        <path d="M2 10h20" />
                                        <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                        <path d="M8 12h8v8H8z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Our Officials Division Heads -->
        <div class="mt-20 pt-14 border-t border-slate-200/60" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-8">Our Officials</h2>
        </div>

        <!-- Department Tabs -->
        <div class="bg-gray-100/60 p-2 rounded-2xl border border-gray-200/50 mb-12 flex flex-row overflow-x-auto scrollbar-none snap-x snap-mandatory scroll-smooth relative"
            id="officials-tabs">
            <?php foreach ($departments as $index => $dept): ?>
                <?php 
                    $tabStateClass = $index === 0 ? 'bg-white text-primary shadow-sm font-bold border-gray-200/20' : 'text-gray-500 hover:text-gray-800 hover:bg-white/40 font-semibold border-transparent';
                ?>
                <button onclick="switchDepartmentTab('<?php echo $dept['id']; ?>')" id="tab-btn-<?php echo $dept['id']; ?>"
                    class="px-5 py-2.5 rounded-xl border <?php echo $tabStateClass; ?> font-montserrat whitespace-nowrap text-[13.5px] md:text-sm cursor-pointer transition-all duration-300 snap-center flex-shrink-0 active:scale-98">
                    <?php echo $dept['title']; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Department Teams -->
        <div id="officials-tab-contents">
            <?php foreach ($departments as $index => $dept): ?>
                <div id="tab-content-<?php echo $dept['id']; ?>"
                    class="dept-tab-content <?php echo $index === 0 ? 'block' : 'hidden'; ?> transition-all duration-300">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-6">
                        <?php foreach ($dept['people'] as $person_index => $person): ?>
                            <div
                                class="dept-person-card bg-white rounded-2xl overflow-hidden border border-gray-200/60 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_10px_30px_rgba(19,39,63,0.04)] hover:-translate-y-1 transition-all duration-500 group opacity-0 animate-[fadeIn_0.5s_cubic-bezier(0.16,1,0.3,1)_forwards]"
                                style="animation-delay: <?php echo ($person_index * 50); ?>ms;">
                                <div class="overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100 flex items-center justify-center aspect-square border-b border-gray-100">
                                    <?php if ($person['image']): ?>
                                        <img loading="lazy" src="<?php echo $person['image']; ?>" alt="<?php echo $person['name']; ?>"
                                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                                    <?php else: ?>
                                        <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4 sm:p-5">
                                    <h4
                                        class="font-bold font-montserrat text-primary text-[12px] sm:text-[13px] mb-1 leading-tight">
                                        <?php echo !empty($person['title_'.$current_lang]) ? $person['title_'.$current_lang] : (!empty($person['designation_'.$current_lang]) ? $person['designation_'.$current_lang] : (!empty($person['title']) ? $person['title'] : $person['designation'])); ?></h4>
                                    <p class="text-[11px] sm:text-[12px] text-gray-500 font-inter mb-4">
                                        <?php echo !empty($person['name_'.$current_lang]) ? $person['name_'.$current_lang] : $person['name']; ?></p>
                                    <div class="flex gap-1.5 sm:gap-2 relative z-10">
                                        <?php if ($person['email']): ?>
                                            <button
                                                onclick="copyToClipboard('<?php echo trim($person['email']); ?>', 'Email address copied!')"
                                                class="w-9 h-9 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors cursor-pointer"
                                                title="Copy Email: <?php echo trim($person['email']); ?>">
                                                <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($person['phone']): ?>
                                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $person['phone']); ?>"
                                                class="w-9 h-9 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors cursor-pointer"
                                                title="<?php echo trim($person['phone']); ?>">
                                                <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($person['fax']): ?>
                                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $person['fax']); ?>"
                                                class="w-9 h-9 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors cursor-pointer"
                                                title="Fax: <?php echo trim($person['fax']); ?>">
                                                <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    viewBox="0 0 24 24">
                                                    <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                                    <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                                    <path d="M2 10h20" />
                                                    <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                                    <path d="M8 12h8v8H8z" />
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<!-- Divisions & Functions -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white" id="divisions-functions">
    <div class="container mx-auto" data-aos="fade-up">
        <div class="mb-10">
            <h2 class="section-title notranslate">
                <?= t('div_section_title', 'Divisions under the Ministry') ?></h2>
        </div>

        <!-- Unified Card Container Split Layout -->
        <div class="w-full rounded-[2rem] border border-gray-200/60 bg-white shadow-[0_12px_40px_rgba(19,39,63,0.04)] hover:shadow-[0_20px_50px_rgba(19,39,63,0.08)] transition-all duration-500 overflow-hidden flex flex-col md:flex-row min-h-[550px] relative z-10">
            <!-- Left Sidebar (Tabs Selectors) -->
            <div class="w-full md:w-[38%] bg-gray-50/70 border-b md:border-b-0 md:border-r border-gray-200/80 flex flex-row md:flex-col overflow-x-auto md:overflow-x-visible p-3 md:p-6 gap-2 scrollbar-none snap-x snap-mandatory scroll-smooth relative">
                <!-- Card 1 -->
                <button class="group div-split-tab active snap-center" data-target="div-admin">
                    <span class="flex items-center">
                        <span class="notranslate"><?= t('div_admin_title', 'Administration and Establishments Division') ?></span>
                    </span>
                    <svg class="chevron-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
                
                <!-- Card 2 -->
                <button class="group div-split-tab snap-center" data-target="div-dev">
                    <span class="flex items-center">
                        <span class="notranslate"><?= t('div_dev_title', 'Policy Formulation & Foreign Relations Division') ?></span>
                    </span>
                    <svg class="chevron-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- Card 3 -->
                <button class="group div-split-tab snap-center" data-target="div-planning">
                    <span class="flex items-center">
                        <span class="notranslate"><?= t('div_planning_title', 'Planning and Monitoring Division') ?></span>
                    </span>
                    <svg class="chevron-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
                
                <!-- Card 4 -->
                <button class="group div-split-tab snap-center" data-target="div-finance">
                    <span class="flex items-center">
                        <span class="notranslate"><?= t('div_finance_title', 'Finance Division') ?></span>
                    </span>
                    <svg class="chevron-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
                
                <!-- Card 5 -->
                <button class="group div-split-tab snap-center" data-target="div-audit">
                    <span class="flex items-center">
                        <span class="notranslate"><?= t('div_audit_title', 'Internal Audit Division') ?></span>
                    </span>
                    <svg class="chevron-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <!-- Right Content Area (Details) -->
            <div class="w-full md:w-[62%] p-8 md:p-12 relative flex flex-col justify-start overflow-hidden bg-white">
                <!-- Top accent line -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-secondary to-primary"></div>
                
                <!-- Decorative glowing orb -->
                <div class="absolute -right-24 -bottom-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

                <!-- 1. Administration and Establishments Division -->
                <div id="div-panel-div-admin" class="div-panel transition-all duration-500 block animate-[fadeIn_0.4s_ease-out]">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight leading-tight notranslate">
                        <?= t('div_admin_title', 'Administration and Establishments Division') ?></h3>
                    <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed notranslate">
                        <?= t('div_admin_content') ?>
                    </div>
                </div>

                <!-- 2. Policy Formulation & Foreign Relations Division -->
                <div id="div-panel-div-dev" class="div-panel hidden">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight leading-tight notranslate">
                        <?= t('div_dev_title', 'Policy Formulation & Foreign Relations Division') ?></h3>
                    <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed notranslate">
                        <?= t('div_dev_content') ?>
                    </div>
                </div>

                <!-- 3. Planning and Monitoring Division -->
                <div id="div-panel-div-planning" class="div-panel hidden">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight leading-tight notranslate">
                        <?= t('div_planning_title', 'Planning and Monitoring Division') ?></h3>
                    <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed notranslate">
                        <?= t('div_planning_content') ?>
                    </div>
                </div>

                <!-- 4. Finance Division -->
                <div id="div-panel-div-finance" class="div-panel hidden">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight leading-tight notranslate">
                        <?= t('div_finance_title', 'Finance Division') ?></h3>
                    <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed notranslate">
                        <?= t('div_finance_content') ?>
                    </div>
                </div>

                <!-- 5. Internal Audit Division -->
                <div id="div-panel-div-audit" class="div-panel hidden">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight leading-tight notranslate">
                        <?= t('div_audit_title', 'Internal Audit Division') ?></h3>
                    <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed notranslate">
                        <?= t('div_audit_content') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Citizen Charter Section -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-[#F1F5F9] border-t border-b border-slate-200/80 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]" id="citizen-charter">
    <div class="container mx-auto flex flex-col lg:flex-row gap-16" data-aos="fade-up">
        
        <!-- Left Side: Main Text -->
        <div class="w-full lg:w-[45%]">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-6 leading-tight">
                Our Commitment to Public<br>Service Excellence
            </h2>
            <div class="space-y-6 text-gray-600 font-inter text-[15px] leading-relaxed pr-0 md:pr-4">
                <p>
                    The Citizen Charter reflects the Ministry's dedication to delivering reliable, timely, and high-quality services to all citizens. It clearly defines our service standards, responsibilities, and the rights of the public, ensuring transparency and accountability in every interaction.
                </p>
                <p>
                    Through this charter, we aim to build trust, improve service delivery, and create a responsive system that prioritizes the needs and expectations of the people we serve.
                </p>
            </div>
        </div>

        <!-- Right Side: PDF Viewer -->
        <div class="w-full lg:w-[55%] flex justify-center items-start">
            <?php 
                $pdfId = 'citizen-charter-doc';
                $pdfUrl = 'assets/img/citizen-charter/citizen-charter.pdf';
                $pdfTitle = 'Citizen Charter';
                include 'includes/pdf-viewer.php'; 
            ?>
        </div>

    </div>
</section>

<style>
    /* Custom simple fade-in animation to keep JS clean */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const divTabBtns = document.querySelectorAll('.div-split-tab');
        const divPanels = document.querySelectorAll('.div-panel');

        divTabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Hide all panels
                divPanels.forEach(panel => {
                    panel.classList.remove('block', 'animate-[fadeIn_0.4s_ease-out]');
                    panel.classList.add('hidden');
                });
                
                // Show target panel
                const targetId = this.getAttribute('data-target');
                const targetPanel = document.getElementById('div-panel-' + targetId);
                if (targetPanel) {
                    targetPanel.classList.remove('hidden');
                    // Small delay to ensure browser paints before applying animation class again
                    setTimeout(() => {
                        targetPanel.classList.add('block', 'animate-[fadeIn_0.4s_ease-out]');
                    }, 10);
                }

                // Toggle active tab state
                divTabBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Smoothly center the active tab on mobile horizontal scrolling list
                if (window.innerWidth < 768) {
                    this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
            });
        });
    });

    function switchDepartmentTab(tabId) {
        document.querySelectorAll('.dept-tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        const targetTab = document.getElementById('tab-content-' + tabId);
        targetTab.classList.remove('hidden');

        // Trigger staggered fade-up-in cascade animation for tab content cards
        const cards = targetTab.querySelectorAll('.dept-person-card');
        cards.forEach(card => {
            card.classList.remove('animate-[fadeIn_0.5s_cubic-bezier(0.16,1,0.3,1)_forwards]');
            void card.offsetWidth; // Force element reflow to restart CSS keyframe animation
            card.classList.add('animate-[fadeIn_0.5s_cubic-bezier(0.16,1,0.3,1)_forwards]');
        });

        const activeClasses = ['bg-white', 'text-primary', 'shadow-sm', 'font-bold', 'border-gray-200/20'];
        const inactiveClasses = ['text-gray-500', 'hover:text-gray-800', 'hover:bg-white/40', 'font-semibold', 'border-transparent'];

        <?php foreach ($departments as $dept): ?>
            {
                const btn = document.getElementById('tab-btn-<?php echo $dept['id']; ?>');
                if ('<?php echo $dept['id']; ?>' === tabId) {
                    btn.classList.add(...activeClasses);
                    btn.classList.remove(...inactiveClasses);
                    
                    // Smoothly center the active tab button on mobile viewports
                    if (window.innerWidth < 768) {
                        btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    }
                } else {
                    btn.classList.remove(...activeClasses);
                    btn.classList.add(...inactiveClasses);
                }
            }
        <?php endforeach; ?>
    }



    function copyToClipboard(text, message) {
        navigator.clipboard.writeText(text).then(() => {
            showToast(message, 'success');
        }).catch(err => {
            console.error('Failed to copy: ', err);
            showToast('Failed to copy email. Your browser may not support this feature.', 'error');
        });
    }
</script>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
