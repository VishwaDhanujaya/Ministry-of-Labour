<?php
// about-us.php
require_once 'admin/includes/db.php';
require_once 'includes/officials-service.php';

$top_officials = getTopOfficials($pdo);
$departments   = getDivisions($pdo);

$page_title = 'About Us';
$pageTitle = 'About Us - Ministry of Labour - Sri Lanka';
$metaDescription = 'Learn about the Ministry of Labour, Sri Lanka, our vision, mission, key officials, and the Citizen Charter outlining our commitment to public service excellence.';
$metaKeywords = 'Ministry of Labour, Sri Lanka, About Us, Vision, Mission, Officials, Departments, Citizen Charter, Public Service';
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
                    class="w-full h-48 md:h-64 object-cover rounded-2xl md:rounded-3xl shadow-sm">
                <img loading="lazy" src="assets/img/about-us/overview-2.webp" alt="Official Speaker"
                    class="w-full h-48 md:h-64 object-cover rounded-2xl md:rounded-3xl shadow-sm">
                <img loading="lazy" src="assets/img/about-us/overview-3.webp" alt="Audience"
                    class="col-span-2 w-full h-64 md:h-80 object-cover rounded-2xl md:rounded-3xl shadow-sm">
            </div>
        </div>
        <!-- Content -->
        <div class="w-full lg:w-1/2" data-aos="fade-left">
            <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-6">Overview</h2>
            <div class="space-y-4 text-gray-600 font-inter text-[15px] leading-relaxed mb-10">
                <p>Improving the standards of living and service conditions of workers in Sri Lanka's semi-government
                    and private sectors, and the formulation and implementation of pertinent policies to establish
                    industrial peace and employer-employee relationships required for enhancing production and labour
                    productivity, are the prime objectives of the Ministry of Labour.</p>
                <p>The Ministry of Labour plays a vital role in safeguarding the rights and welfare of employees while
                    fostering harmonious industrial relations across the country. The ministry oversees labour laws,
                    social security programs, employment policies, and occupational safety standards to ensure a fair
                    and productive labour environment.</p>
                <p>Through its institutions and departments, the ministry serves millions of employees in the private
                    and semi-government sectors while contributing to national economic development.</p>
            </div>

            <div class="about-stats-container">
                <div class="about-stat-card">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number">97</span>
                    <span class="about-stat-label">Years of Experience</span>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number">95K</span>
                    <span class="about-stat-label">Happy Customers</span>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number">100%</span>
                    <span class="about-stat-label">Satisfaction</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Partners -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-[#FAFAFA] border-t border-b border-gray-100">
    <div class="container mx-auto" data-aos="fade-up">
        <h2 class="text-2xl md:text-3xl font-bold text-primary font-montserrat mb-12 text-center">Our Partners</h2>
        <div id="partners-track"
            class="flex gap-6 overflow-x-auto scrollbar-none snap-x snap-mandatory py-4 scroll-smooth items-center">
            <div
                class="snap-start shrink-0 min-w-[calc(50%-12px)] md:min-w-[calc(33.333%-16px)] lg:min-w-[calc(16.666%-20px)] flex justify-center">
                <img loading="lazy" src="assets/img/about-us/partner-1.png" alt="Partner 1"
                    class="h-12 md:h-16 lg:h-20 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
            <div
                class="snap-start shrink-0 min-w-[calc(50%-12px)] md:min-w-[calc(33.333%-16px)] lg:min-w-[calc(16.666%-20px)] flex justify-center">
                <img loading="lazy" src="assets/img/about-us/partner-2.png" alt="Partner 2"
                    class="h-12 md:h-16 lg:h-20 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
            <div
                class="snap-start shrink-0 min-w-[calc(50%-12px)] md:min-w-[calc(33.333%-16px)] lg:min-w-[calc(16.666%-20px)] flex justify-center">
                <img loading="lazy" src="assets/img/about-us/partner-3.png" alt="Partner 3"
                    class="h-12 md:h-16 lg:h-20 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
            <div
                class="snap-start shrink-0 min-w-[calc(50%-12px)] md:min-w-[calc(33.333%-16px)] lg:min-w-[calc(16.666%-20px)] flex justify-center">
                <img loading="lazy" src="assets/img/about-us/partner-4.png" alt="Partner 4"
                    class="h-12 md:h-16 lg:h-20 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
            <div
                class="snap-start shrink-0 min-w-[calc(50%-12px)] md:min-w-[calc(33.333%-16px)] lg:min-w-[calc(16.666%-20px)] flex justify-center">
                <img loading="lazy" src="assets/img/about-us/partner-5.png" alt="Partner 5"
                    class="h-12 md:h-16 lg:h-20 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
            <div
                class="snap-start shrink-0 min-w-[calc(50%-12px)] md:min-w-[calc(33.333%-16px)] lg:min-w-[calc(16.666%-20px)] flex justify-center">
                <img loading="lazy" src="assets/img/about-us/partner-6.png" alt="Partner 6"
                    class="h-12 md:h-16 lg:h-20 w-auto object-contain hover:scale-105 transition-transform duration-300">
            </div>
        </div>

        <!-- Sticky Slide Dots -->
        <div class="flex justify-center mt-8 gap-2.5 pb-2" id="partners-dots-container">
            <button class="w-8 h-2.5 rounded-full bg-secondary transition-all duration-300 partner-dot active shadow-sm"
                aria-label="Go to slide 1"></button>
            <button
                class="w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300 partner-dot"
                aria-label="Go to slide 2"></button>
            <button
                class="w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300 partner-dot"
                aria-label="Go to slide 3"></button>
            <button
                class="w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300 partner-dot"
                aria-label="Go to slide 4"></button>
            <button
                class="w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300 partner-dot"
                aria-label="Go to slide 5"></button>
            <button
                class="w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300 partner-dot"
                aria-label="Go to slide 6"></button>
        </div>
    </div>
</section>

<!-- Vision & Mission / Organizational Chart -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row rounded-3xl overflow-hidden shadow-lg border-[0.5px] border-[#D4D4D4]" data-aos="fade-up">
            <!-- Vision & Mission -->
            <div
                class="w-full lg:w-[65%] bg-primary text-white p-8 md:p-10 lg:p-12 flex flex-col justify-center relative">
                <div class="relative z-10 mb-8">
                    <h3 class="text-2xl md:text-3xl font-semibold font-montserrat mb-3 text-white">Our Vision</h3>
                    <p class="text-base md:text-lg text-[#FAFAFA] font-inter">"A satisfied productive labour force"</p>
                </div>
                <div class="relative z-10">
                    <h3 class="text-2xl md:text-3xl font-semibold font-montserrat mb-3 text-white">Our Mission</h3>
                    <p class="text-[#FAFAFA] font-inter text-[14px] md:text-[15px] leading-relaxed">
                        "Contribute towards the socio-economic development through the promotion of industrial peace and
                        harmony, social protection, rights at work, and productivity"
                    </p>
                </div>
            </div>

            <!-- Organizational Chart -->
            <div class="w-full lg:w-[35%] bg-white p-6 md:p-8 lg:p-10 flex flex-col justify-center">
                <h3 class="text-2xl md:text-3xl font-semibold font-montserrat text-gray-900 mb-5 text-left">
                    Organizational Chart</h3>

                <div
                    class="relative group rounded-xl border-[0.5px] border-[#D4D4D4] bg-gray-50 p-2 max-w-[380px] w-full mr-auto">
                    <a href="javascript:void(0)" onclick="openOrgChart()" class="block">
                        <img loading="lazy" src="assets/img/about-us/organizational-chart.webp" alt="Organizational Chart"
                            class="w-full h-40 md:h-48 lg:h-56 object-contain rounded-lg cursor-pointer mix-blend-multiply transition-transform hover:scale-[1.02]">
                    </a>

                    <!-- Action Buttons -->
                    <div
                        class="absolute bottom-3 right-3 flex items-center bg-white/90 backdrop-blur-sm rounded-lg overflow-hidden border border-gray-200 shadow-sm opacity-90 group-hover:opacity-100 transition-opacity">
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

<!-- Our Officials -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-[#FAFAFA]">
    <div class="container mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-14" data-aos="fade-up">Our Officials</h2>

        <!-- Top Officials -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20" data-aos="zoom-in" data-aos-delay="100">
            <?php foreach ($top_officials as $official): ?>
                <div
                    class="bg-white rounded-3xl overflow-hidden shadow-sm border-[0.5px] border-[#D4D4D4] hover:shadow-md transition-shadow group">
                    <div class="overflow-hidden bg-gray-100 flex items-center justify-center h-[380px]">
                        <?php if ($official['image']): ?>
                            <img loading="lazy" src="<?php echo $official['image']; ?>" alt="<?php echo $official['name']; ?>"
                                class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <svg class="w-24 h-24 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="p-8">
                        <h3 class="text-[17px] font-bold font-montserrat text-primary mb-1">
                            <?php echo $official['title']; ?></h3>
                        <p class="text-gray-500 font-inter text-sm mb-5"><?php echo $official['name']; ?></p>
                        <div class="flex gap-2.5 relative z-10">
                            <?php if ($official['email']): ?>
                                <button
                                    onclick="copyToClipboard('<?php echo trim($official['email']); ?>', 'Email address copied!')"
                                    class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs cursor-pointer"
                                    title="Copy Email: <?php echo trim($official['email']); ?>">
                                    <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </button>
                            <?php endif; ?>
                            <?php if ($official['phone']): ?>
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $official['phone']); ?>"
                                    class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs cursor-pointer"
                                    title="<?php echo trim($official['phone']); ?>">
                                    <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($official['fax']): ?>
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $official['fax']); ?>"
                                    class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs cursor-pointer"
                                    title="Fax: <?php echo trim($official['fax']); ?>">
                                    <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor"
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

        <!-- Department Tabs -->
        <div class="flex overflow-x-auto gap-4 md:gap-8 mb-10 border-b border-gray-200 pb-1 scrollbar-none"
            id="officials-tabs">
            <?php foreach ($departments as $index => $dept): ?>
                <?php 
                    $tabStateClass = $index === 0 ? 'border-primary text-primary font-bold' : 'border-transparent text-gray-400 hover:text-gray-700 font-semibold';
                ?>
                <button onclick="switchDepartmentTab('<?php echo $dept['id']; ?>')" id="tab-btn-<?php echo $dept['id']; ?>"
                    class="px-2 py-3 border-b-2 <?php echo $tabStateClass; ?> font-montserrat whitespace-nowrap text-sm md:text-base cursor-pointer transition-colors">
                    <?php echo $dept['title']; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Department Teams -->
        <div id="officials-tab-contents">
            <?php foreach ($departments as $index => $dept): ?>
                <div id="tab-content-<?php echo $dept['id']; ?>"
                    class="dept-tab-content <?php echo $index === 0 ? '' : 'hidden'; ?>">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-6">
                        <?php foreach ($dept['people'] as $person): ?>
                            <div
                                class="bg-white rounded-2xl overflow-hidden border-[0.5px] border-[#D4D4D4] shadow-sm hover:shadow-md transition-shadow group">
                                <div class="overflow-hidden bg-gray-100 flex items-center justify-center aspect-square">
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
                                        <?php echo $person['designation']; ?></h4>
                                    <p class="text-[11px] sm:text-[12px] text-gray-500 font-inter mb-4">
                                        <?php echo $person['name']; ?></p>
                                    <div class="flex gap-1.5 sm:gap-2 relative z-10">
                                        <?php if ($person['email']): ?>
                                            <button
                                                onclick="copyToClipboard('<?php echo trim($person['email']); ?>', 'Email address copied!')"
                                                class="w-6 h-6 sm:w-7 sm:h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors cursor-pointer"
                                                title="Copy Email: <?php echo trim($person['email']); ?>">
                                                <svg class="w-3 h-3 pointer-events-none" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($person['phone']): ?>
                                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $person['phone']); ?>"
                                                class="w-6 h-6 sm:w-7 sm:h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors cursor-pointer"
                                                title="<?php echo trim($person['phone']); ?>">
                                                <svg class="w-3 h-3 pointer-events-none" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($person['fax']): ?>
                                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $person['fax']); ?>"
                                                class="w-6 h-6 sm:w-7 sm:h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors cursor-pointer"
                                                title="Fax: <?php echo trim($person['fax']); ?>">
                                                <svg class="w-3 h-3 pointer-events-none" fill="none" stroke="currentColor"
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
        <div class="mb-14">
            <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">
                Organizational Structure</p>
            <h2 class="section-title">
                Divisions & Functions</h2>
        </div>

        <div class="flex flex-col md:flex-row gap-8 lg:gap-12">
            <!-- Vertical Tabs -->
            <div class="w-full md:w-[32%] flex flex-col space-y-2.5 relative z-10">
                <button
                    class="group relative text-left px-6 py-4 bg-primary text-white font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 shadow-lg cursor-pointer focus:outline-none div-tab-btn active overflow-hidden"
                    data-target="div-admin">
                    <span class="relative z-10 flex items-center justify-between">Administration Division <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none div-tab-btn"
                    data-target="div-dev">
                    <span class="relative z-10 flex items-center justify-between">Development Division <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none div-tab-btn"
                    data-target="div-finance">
                    <span class="relative z-10 flex items-center justify-between">Finance Division <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none div-tab-btn"
                    data-target="div-audit">
                    <span class="relative z-10 flex items-center justify-between">Internal Audit Division <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none div-tab-btn"
                    data-target="div-planning">
                    <span class="relative z-10 flex items-center justify-between">Planning & Monitoring Division <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
            </div>

            <!-- Content Area -->
            <div class="w-full md:w-[68%]">
                <div class="bg-white rounded-[2rem] p-8 md:p-12 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] min-h-[550px] flex flex-col justify-start relative overflow-hidden transition-all duration-500">
                    <!-- Top accent line -->
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-secondary to-primary"></div>

                    <!-- Administration Division -->
                    <div id="div-panel-div-admin" class="div-panel transition-all duration-500 block animate-[fadeIn_0.4s_ease-out]">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Division Profile</div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Administration Division</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed">
                            <p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">There are two sections under this Division: <strong>Administration</strong> and <strong>Establishments Division</strong>.</p>
                            
                            <h4 class="font-bold text-gray-900 text-lg mt-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                Key Functions
                            </h4>
                            <ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5">
                                <li class="pl-1">Overseeing the overall administration, management, maintenance, training and coordination of the Ministry and its affiliated institutions.</li>
                                <li class="pl-1">Responsible for human resources management and related functions.</li>
                                <li class="pl-1">Maintaining personal files of all public officers attached to the Ministry and updating information on the staff.</li>
                                <li class="pl-1">Preparation of cabinet memoranda and taking action in respect of cabinet decisions.</li>
                                <li class="pl-1">Providing answers to referrals made by the Consultative Committee and Public Petitions Committee as well as parliamentary questions.</li>
                                <li class="pl-1">Administration of vehicles, provision of infrastructure facilities, training activities, and management of capital goods.</li>
                                <li class="pl-1">Submission of annual reports and performance reports of the Ministry to Parliament.</li>
                                <li class="pl-1">Collection and submission of declarations of assets and liabilities of relevant officers.</li>
                                <li class="pl-1">Handling reservations, maintenance, and administrative activities of the Ministry's circuit bungalow in Ampara.</li>
                                <li class="pl-1">Managing matters related to lands and buildings owned by the Ministry.</li>
                            </ul>
                            
                            <div class="mt-10 p-6 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-all duration-300">
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-secondary"></div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-primary/5 p-3 rounded-xl text-primary shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 text-[16px]">Contact Information</h4>
                                        <p class="text-primary font-semibold mt-2 text-[15px]">Ms. T.P Muditha Pathmajay</p>
                                        <p class="text-[13px] text-gray-500 mb-3">Additional Secretary (Administration)</p>
                                        <div class="flex flex-col gap-2 text-[13.5px] text-gray-600 mt-3">
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +94 (0)112 368938</div>
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg> +94 (0)112 368165</div>
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> <a href="mailto:adsec.admin@labourmin.gov.lk" class="text-secondary hover:underline font-medium">adsec.admin@labourmin.gov.lk</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Development Division -->
                    <div id="div-panel-div-dev" class="div-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Division Profile</div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Development Division</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed">
                            <p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">There are two sections under this Division: <strong>Development Division</strong> and <strong>Foreign Relations Division</strong>.</p>
                            
                            <h4 class="font-bold text-gray-900 text-[17px] mt-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                Development Division Functions
                            </h4>
                            <ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5">
                                <li class="pl-1"><strong class="text-gray-800">Public Grievance Management:</strong> Direct the Ministry's response to high-priority public grievances and ensuring resolution efficiency.</li>
                                <li class="pl-1"><strong class="text-gray-800">ILO Engagement & Labor Reforms:</strong> Engage within the ILO framework, representing the state in strategic forums.</li>
                                <li class="pl-1"><strong class="text-gray-800">National Social Protection Strategy:</strong> Lead the coordination of the Social Care, Social Insurance, and Labor Market inclusion.</li>
                                <li class="pl-1"><strong class="text-gray-800">Statutory Compliance:</strong> Perform institutional duties mandated under the Right to Information Act, No. 12 of 2016.</li>
                                <li class="pl-1"><strong class="text-gray-800">Events & Community Outreach:</strong> Spearhead official events and community-based mobile service programs.</li>
                            </ul>
                            
                            <h4 class="font-bold text-gray-900 text-[17px] mt-8 flex items-center gap-2">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Foreign Relations Division Functions
                            </h4>
                            <ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5">
                                <li class="pl-1">Act as the focal centre for the discharge of Sri Lanka's international obligations in the field of labour relations.</li>
                                <li class="pl-1">Facilitate the selection of members to the National Labour Advisory Council (NLAC).</li>
                                <li class="pl-1">Convene meetings of the National Steering Committee on the Elimination of Child Labour.</li>
                                <li class="pl-1">Coordinate reports to the ILO and participation of Sri Lanka's delegation at the International Labour Conference.</li>
                                <li class="pl-1">Promote policy dialogue on emerging developments in global and national labour markets.</li>
                            </ul>

                            <div class="mt-10 p-6 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-all duration-300">
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-secondary"></div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-primary/5 p-3 rounded-xl text-primary shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 text-[16px]">Contact Information</h4>
                                        <p class="text-primary font-semibold mt-2 text-[15px]">Mr. Lal Samarasekara</p>
                                        <p class="text-[13px] text-gray-500 mb-3">Additional Secretary (Development)</p>
                                        <div class="flex flex-col gap-2 text-[13.5px] text-gray-600 mt-3">
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +94 (0)112 586337</div>
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg> +94 (0)112 589267</div>
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> <a href="mailto:adsec.dev@labourmin.gov.lk" class="text-secondary hover:underline font-medium">adsec.dev@labourmin.gov.lk</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Finance Division -->
                    <div id="div-panel-div-finance" class="div-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Division Profile</div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Finance Division</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed">
                            <p class="text-lg text-gray-700 leading-relaxed"><strong class="text-primary font-semibold">Mission:</strong> To ensure effective financial management, prudent utilization of public funds, compliance with financial regulations and the provision of sound financial planning and budgeting and reporting services to support the ministry's objectives efficiently and transparently.</p>
                            
                            <h4 class="font-bold text-gray-900 text-lg mt-8 flex items-center gap-2">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                Key Functions
                            </h4>
                            <ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5">
                                <li class="pl-1">Preparation of budget estimates.</li>
                                <li class="pl-1">Maintaining accounts and submitting all statements of account to the General Treasury.</li>
                                <li class="pl-1">Implementation of financial policies in accordance with the laws, rules, and financial regulations.</li>
                                <li class="pl-1">Maintain records of ministry assets and liabilities.</li>
                                <li class="pl-1">Ensure compliance with financial regulations, treasury instructions, and audit requirements.</li>
                            </ul>

                            <div class="mt-10 p-6 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-all duration-300">
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-secondary"></div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-primary/5 p-3 rounded-xl text-primary shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 text-[16px]">Contact Information</h4>
                                        <p class="text-primary font-semibold mt-2 text-[15px]">Ms. S. S. Shiroma Nandani</p>
                                        <p class="text-[13px] text-gray-500 mb-3">Chief Accountant</p>
                                        <div class="flex flex-col gap-2 text-[13.5px] text-gray-600 mt-3">
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +94 11 2505161</div>
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> <a href="mailto:ca@labourmin.gov.lk" class="text-secondary hover:underline font-medium">ca@labourmin.gov.lk</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Internal Audit Division -->
                    <div id="div-panel-div-audit" class="div-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Division Profile</div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Internal Audit Division</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed">
                            <h4 class="font-bold text-gray-900 text-lg mt-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                Functions For the Ministry and affiliated institutions
                            </h4>
                            <ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5">
                                <li class="pl-1">Conducting AMC of the Ministry and participating in the AMC of other Institutions.</li>
                                <li class="pl-1">Ensure timely presenting of the Preliminary Report, Quarter reports, Annual Internal Audit plan, and annual action plan.</li>
                                <li class="pl-1">Conducting continuous surveys and evaluations for internal control system operations and suggestions for improvements.</li>
                                <li class="pl-1">Investigation of financial transactions to ensure they accord with rules and provide views on financial statements.</li>
                                <li class="pl-1">Look into protections established to safeguard government assets and properties and assess effective usage.</li>
                                <li class="pl-1">Conducting Special investigations and internal audit functions and submit reports to the Secretary.</li>
                                <li class="pl-1">Reporting of Financial & Physical progress of capital/development projects.</li>
                            </ul>

                            <div class="mt-10 p-6 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-all duration-300">
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-secondary"></div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-primary/5 p-3 rounded-xl text-primary shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 text-[16px]">Contact Information</h4>
                                        <p class="text-primary font-semibold mt-2 text-[15px]">A M M K Abeysinghe</p>
                                        <p class="text-[13px] text-gray-500 mb-3">Chief Internal Auditor</p>
                                        <div class="flex flex-col gap-2 text-[13.5px] text-gray-600 mt-3">
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> 011 236 9422</div>
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> <a href="mailto:cia.mol@labourmin.gov.lk" class="text-secondary hover:underline font-medium">cia.mol@labourmin.gov.lk</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Planning & Monitoring Division -->
                    <div id="div-panel-div-planning" class="div-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Division Profile</div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Planning & Monitoring Division</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed">
                            <p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">Devising plans of the Ministry and all institutions under its purview required for navigating the development plans towards the set targets, and the implementation of them, progress review and follow up thereof are the key functions of this division.</p>
                            
                            <h4 class="font-bold text-gray-900 text-lg mt-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                Key Functions
                            </h4>
                            <ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5">
                                <li class="pl-1">Preparing, implementing, and reporting on strategic plans and annual action plans in alignment with the national policy framework.</li>
                                <li class="pl-1">Preparing the annual action plan, outlining the development goals, monitoring and encouraging the achievement of targets.</li>
                                <li class="pl-1">Coordinating with the Presidential Secretariat, Ministry of Finance, Department of Project Management and Monitoring, and Department of National Planning.</li>
                                <li class="pl-1">Identifying and submitting project proposals for preparation of annual budget estimates.</li>
                                <li class="pl-1">Preparing the annual performance report detailing the progress achieved by the Ministry.</li>
                                <li class="pl-1">Appraising development project proposals related to the curriculum and referring to the Department of National Planning.</li>
                                <li class="pl-1">Contributing as relevant to action plans implemented by various Ministries.</li>
                            </ul>

                            <div class="mt-10 p-6 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden group hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-all duration-300">
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-secondary"></div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-primary/5 p-3 rounded-xl text-primary shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1 text-[16px]">Contact Information</h4>
                                        <p class="text-primary font-semibold mt-2 text-[15px]">Ms. I V N Preethika Kumuduni</p>
                                        <p class="text-[13px] text-gray-500 mb-3">Director General (Planning)</p>
                                        <div class="flex flex-col gap-2 text-[13.5px] text-gray-600 mt-3">
                                            <div class="flex items-center gap-2.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +94 11-236 9422</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Citizen Charter Section -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-[#FAFAFA] border-t border-gray-100" id="citizen-charter">
    <div class="container mx-auto flex flex-col lg:flex-row gap-16" data-aos="fade-up">
        
        <!-- Left Side: Main Text -->
        <div class="w-full lg:w-[45%]">
            <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">Public Commitment</p>
            <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-8 leading-tight">
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
        const divTabBtns = document.querySelectorAll('.div-tab-btn');
        divTabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Hide all panels
                document.querySelectorAll('.div-panel').forEach(panel => {
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

                // Reset all button styles
                divTabBtns.forEach(b => {
                    b.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'active');
                    b.classList.add('text-gray-600', 'bg-white', 'hover:bg-gray-50', 'hover:border-gray-300', 'hover:shadow-md');
                    
                    const svg = b.querySelector('svg');
                    if(svg) {
                        svg.classList.remove('transform', 'group-hover:translate-x-1');
                        svg.classList.add('opacity-0', 'group-hover:opacity-100', 'transform', '-translate-x-2', 'group-hover:translate-x-0', 'text-primary');
                    }
                });

                // Set active styles
                this.classList.add('bg-primary', 'text-white', 'shadow-lg', 'active');
                this.classList.remove('text-gray-600', 'bg-white', 'hover:bg-gray-50', 'hover:border-gray-300', 'hover:shadow-md');
                
                const activeSvg = this.querySelector('svg');
                if(activeSvg) {
                    activeSvg.classList.remove('opacity-0', 'group-hover:opacity-100', 'transform', '-translate-x-2', 'group-hover:translate-x-0', 'text-primary');
                    activeSvg.classList.add('transform', 'group-hover:translate-x-1');
                }
            });
        });
    });

    function switchDepartmentTab(tabId) {
        document.querySelectorAll('.dept-tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');

        const activeClasses = ['border-primary', 'text-primary', 'font-bold'];
        const inactiveClasses = ['border-transparent', 'text-gray-400', 'hover:text-gray-700', 'font-semibold'];

        <?php foreach ($departments as $dept): ?>
            {
                const btn = document.getElementById('tab-btn-<?php echo $dept['id']; ?>');
                if ('<?php echo $dept['id']; ?>' === tabId) {
                    btn.classList.add(...activeClasses);
                    btn.classList.remove(...inactiveClasses);
                } else {
                    btn.classList.remove(...activeClasses);
                    btn.classList.add(...inactiveClasses);
                }
            }
        <?php endforeach; ?>
    }



    function copyToClipboard(text, message) {
        navigator.clipboard.writeText(text).then(() => {
            if (window.showToast) {
                window.showToast(message, 'success');
            } else {
                alert(message + ' : ' + text);
            }
        }).catch(err => {
            console.error('Failed to copy: ', err);
            if (window.showToast) {
                window.showToast('Failed to copy email. Your browser may not support this feature.', 'error');
            } else {
                alert('Failed to copy email. Your browser may not support this feature.');
            }
        });
    }
</script>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
