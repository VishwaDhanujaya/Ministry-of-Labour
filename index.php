<?php
// index.php
require_once 'admin/includes/db.php';

// Fetch recent news (limit 3)
$recentNewsRaw = $pdo->query("SELECT * FROM articles WHERE status = 'Published' AND category = 'Media' ORDER BY created_at DESC LIMIT 3")->fetchAll();
$recentNews = [];
foreach ($recentNewsRaw as $news) {
    if ($current_lang === 'si') {
        if (!empty($news['title_si'])) $news['title'] = $news['title_si'];
        if (!empty($news['content_si'])) $news['content'] = $news['content_si'];
    } elseif ($current_lang === 'ta') {
        if (!empty($news['title_ta'])) $news['title'] = $news['title_ta'];
        if (!empty($news['content_ta'])) $news['content'] = $news['content_ta'];
    }
    $recentNews[] = $news;
}

// Fetch special notices (limit 4) - Note: Special Notices are removed, this can be safely removed or kept for legacy news
$specialNoticesRaw = $pdo->query("SELECT * FROM articles WHERE status = 'Published' AND category = 'Notices' AND is_featured = 1 ORDER BY created_at DESC LIMIT 4")->fetchAll();
$specialNotices = [];
foreach ($specialNoticesRaw as $notice) {
    if ($current_lang === 'si') {
        if (!empty($notice['title_si'])) $notice['title'] = $notice['title_si'];
        if (!empty($notice['content_si'])) $notice['content'] = $notice['content_si'];
    } elseif ($current_lang === 'ta') {
        if (!empty($notice['title_ta'])) $notice['title'] = $notice['title_ta'];
        if (!empty($notice['content_ta'])) $notice['content'] = $notice['content_ta'];
    }
    $specialNotices[] = $notice;
}

// Fetch gallery items
$galleryItems = $pdo->query("SELECT * FROM gallery WHERE status = 'Public' ORDER BY created_at DESC LIMIT 4")->fetchAll();

$pageTitle = 'Home - Ministry of Labour - Sri Lanka';
$metaDescription = 'Official portal of the Ministry of Labour, Sri Lanka. Committed to protecting workforce rights, maintaining industrial peace, social security (EPF), and workplace occupational safety.';
$metaKeywords = 'Ministry of Labour, Sri Lanka Labour, EPF, ETF, Labour Laws Sri Lanka, Employees Provident Fund, Mehewara Piyasa, Industrial Relations, Occupational Safety';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative h-[550px] md:h-[650px] flex items-center bg-primary overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/hero.webp');"></div>
    <div class="absolute inset-0 opacity-55 bg-home-hero-gradient">
    </div>

    <div class="relative z-10 container mx-auto px-4 md:px-16 text-white w-full" data-aos="fade-up" data-aos-duration="1000">
        <div class="max-w-2xl">
            <h2 class="text-2xl md:text-3xl font-inter font-normal mb-2">Welcome to</h2>
            <h1
                class="text-4xl md:text-6xl lg:text-7.5xl font-semibold font-montserrat mb-6 leading-none tracking-tighter uppercase">
                Ministry of Labour</h1>
            <p class="text-[13px] md:text-base font-inter mb-10 leading-relaxed text-gray-300 max-w-xl">
                The Ministry of Labour is dedicated to fostering fair employment, protecting workers' rights, and
                building a dynamic workforce that drives Sri Lanka's economic development.
            </p>
            <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="300">
                <a href="#citizen-services"
                    class="bg-secondary text-white font-semibold py-3.5 px-8 rounded-lg transition-colors duration-300 text-[13px] tracking-wider font-inter hover:shadow-lg hover:-translate-y-1 transform">Explore
                    Services</a>
                <a href="#news-section"
                    class="border border-white text-white font-semibold py-3.5 px-8 rounded-lg transition-colors duration-300 text-[13px] tracking-wider font-inter flex items-center hover:bg-white hover:text-primary hover:shadow-lg hover:-translate-y-1 transform">View
                    Notices</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="bg-secondary text-white py-10 relative z-20">
    <div class="container mx-auto px-4 md:px-16 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center md:divide-x divide-white/20">
            <div class="px-4 stat-box notranslate" data-target="6.2" data-suffix="M+" data-multiplier="1">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span>M+</div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    Workers Protected</div>
            </div>
            <div class="px-4 stat-box notranslate" data-target="32" data-suffix="+">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span>+</div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    Labour Acts Enforced</div>
            </div>
            <div class="px-4 stat-box notranslate" data-target="14">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span></div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    Affiliated Institutions</div>
            </div>
            <div class="px-4 stat-box notranslate" data-target="1250">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span></div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    Total Visitors</div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="py-20 md:py-28 px-4 md:px-16" id="about-us">
    <div class="container mx-auto flex flex-col lg:flex-row items-center gap-16">
        <div class="w-full lg:w-[55%]" data-aos="fade-right">
            <p class="section-subtitle">About
                Us</p>
            <h2 class="section-title">
                About the Ministry of Labour</h2>
            <div class="space-y-5 text-gray-600 font-inter text-[14px] md:text-[15px] leading-relaxed">
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
            
            <!-- Statistics Cards -->
            <div class="about-stats-container">
                <div class="about-stat-card hover:-translate-y-1 transition-transform duration-300">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number">8</span>
                    <span class="about-stat-label">Services</span>
                </div>
                <div class="about-stat-card hover:-translate-y-1 transition-transform duration-300">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number">5+</span>
                    <span class="about-stat-label">Partners</span>
                </div>
            </div>
        </div>

        <!-- Styled administrative image container -->
        <div class="w-full lg:w-[45%]" data-aos="fade-left">
            <div
                class="rounded-3xl overflow-hidden shadow-lg border-[0.5px] border-[#D4D4D4] h-[450px] lg:h-[530px] w-full bg-gray-50 hover:shadow-2xl transition-shadow duration-500">
                <img loading="lazy" src="assets/img/home-about.webp" alt="Ministry of Labour Head Office"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
            </div>
        </div>
    </div>
</section>

<!-- Key Focus Areas -->
<section class="relative py-20 md:py-28 px-4 md:px-16 text-white overflow-hidden bg-primary">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/keyfocus.webp');"></div>
    <div class="absolute inset-0 bg-primary/90"></div>
    <div class="container mx-auto relative z-10" data-aos="fade-up">
        <div class="mb-12">
            <div>
                <p class="text-gray-300 text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">Our Progress</p>
                <h2 class="section-title text-white mb-0">Key Focus Areas</h2>
                <p class="text-gray-300 font-inter font-normal text-sm md:text-base mt-3">Strategic priorities driving Sri Lanka's labour development.</p>
            </div>
        </div>

        <div class="relative">
            <div id="carousel-track"
                class="flex gap-6 overflow-x-auto scrollbar-none snap-x snap-mandatory py-4 scroll-smooth">
                <!-- Card 1 -->
                <div class="focus-card">
                    <div>
                        <div class="focus-card-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="focus-card-title">Acts Amendment</h3>
                        <p class="focus-card-desc">Updating and reforming labour
                            legislation for a modern economy.</p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="focus-card">
                    <div>
                        <div class="focus-card-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.263 15.518a9.008 9.008 0 013.714-6.32l.332-.215a12.448 12.448 0 006.377-6.326m-10.423 12.86l.332-.215a9.009 9.009 0 018.794-.21l.33.167m-10.423 12.9a9.008 9.008 0 014.2-12.87m10.423 12.86l.332-.215a9.009 9.009 0 00-8.794-.21l-.33.167m10.423 12.9a9.008 9.008 0 00-4.2-12.87m0 0a9.008 9.008 0 014.2 12.87m-4.2-12.87l-.33-.167a9.009 9.009 0 00-8.794.21M18 14.5c0-2-3-4-3-4s-3 2-3 4h6z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="focus-card-title">Training for
                            employees</h3>
                        <p class="focus-card-desc">National Institute of Labour
                            Studies programmes and certification.</p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="focus-card">
                    <div>
                        <div class="focus-card-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="focus-card-title">Industrial
                            Relations</h3>
                        <p class="focus-card-desc">Promoting harmonious
                            employer-employee relationships nationwide.</p>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="focus-card">
                    <div>
                        <div class="focus-card-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="focus-card-title">NLAC
                        </h3>
                        <p class="focus-card-desc">National Labour Advisory Council
                            — consultative labour governance.</p>
                    </div>
                </div>
            </div>
            
            <!-- Interactive Dots -->
            <div class="flex justify-center mt-12 gap-3" id="carousel-dots-container">
                <button class="w-8 h-2.5 rounded-full bg-secondary transition-all duration-300 carousel-dot dark-bg-dot active shadow-sm" aria-label="Go to slide 1"></button>
                <button class="w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300 carousel-dot dark-bg-dot" aria-label="Go to slide 2"></button>
                <button class="w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300 carousel-dot dark-bg-dot" aria-label="Go to slide 3"></button>
                <button class="w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300 carousel-dot dark-bg-dot" aria-label="Go to slide 4"></button>
            </div>
        </div>
</section>

<!-- Citizen Services -->
<section class="py-20 md:py-28 px-4 md:px-16" id="citizen-services">
    <div class="container mx-auto">
        <div class="text-left mb-12" data-aos="fade-up">
            <p class="section-subtitle">Our Services</p>
            <h2 class="section-title mb-3">Citizen Services</h2>
            <p class="text-gray-500 font-inter font-normal text-sm md:text-base mb-10">Access key services offered by the Ministry of Labour and its institutions.</p>
        </div>

        <!-- Cards Container -->
        <div id="services-grid" class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <!-- Service Card 1 -->
            <div class="service-card" data-title="Apply EPF"
                data-keywords="epf apply provident fund social security retirement balance registry">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">01</span>
                    </div>
                    <h3 class="service-card-title">
                        Apply EPF</h3>
                    <p class="service-card-desc">Employees' Provident Fund applications and member services.</p>
                </div>

            </div>
            <!-- Service Card 2 -->
            <div class="service-card" data-title="Apply Compensation"
                data-keywords="compensation claim accident injury workplace death file factories">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">02</span>
                    </div>
                    <h3 class="service-card-title">
                        Apply Compensation</h3>
                    <p class="service-card-desc">Workmen's compensation claims and dispute resolution.</p>
                </div>

            </div>
            <!-- Service Card 3 -->
            <div class="service-card" data-title="Industrial Safety"
                data-keywords="safety hazard inspections factories building check compliance ordinance">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">03</span>
                    </div>
                    <h3 class="service-card-title">
                        Industrial Safety</h3>
                    <p class="service-card-desc">Workplace safety standards, inspections and compliance.</p>
                </div>

            </div>
            <!-- Service Card 4 -->
            <div class="service-card" data-title="Labour Circulars"
                data-keywords="circulars news acts gazette bulletin rules minimum wage official">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">04</span>
                    </div>
                    <h3 class="service-card-title">
                        Labour Disputes</h3>
                    <p class="service-card-desc">File and track other labour-related disputes.</p>
                </div>

            </div>
            <!-- Service Card 5 -->
            <div class="service-card" data-title="Apply Labour ID"
                data-keywords="id card register labour identity formal informal workforce verification">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">05</span>
                    </div>
                    <h3 class="service-card-title">
                        Apply under RTI</h3>
                    <p class="service-card-desc">Request information under the Right to Information Act.</p>
                </div>

            </div>
            <!-- Service Card 6 -->
            <div class="service-card" data-title="Complaint to termination"
                data-keywords="complaint dispute termination firing salary pay grievance legal mediation">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">06</span>
                    </div>
                    <h3 class="service-card-title">
                        Complaint: Termination</h3>
                    <p class="service-card-desc">Complaints management for wrongful termination cases.</p>
                </div>

            </div>

            <!-- Service Card 7 -->
            <div class="service-card" data-title="Bungalow Booking"
                data-keywords="bungalow booking reservation circuit book official stay lodge room travel reserve">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">07</span>
                    </div>
                    <h3 class="service-card-title">
                        Bungalow Booking</h3>
                    <p class="service-card-desc">Book Ministry circuit bungalows for official use.</p>
                </div>

            </div>

            <!-- Service Card 8 -->
            <div class="service-card" data-title="Complaint Board"
                data-keywords="complaint board portal query tracking case status check">
                <div>
                    <div class="service-card-icon">
                        <span class="font-semibold font-montserrat text-sm">08</span>
                    </div>
                    <h3 class="service-card-title">
                        Complaints Portal</h3>
                    <p class="service-card-desc">Online complaints management system for all workers.</p>
                </div>

            </div>
        </div>

        <!-- Dynamic No Results block hidden by default -->
        <div id="search-no-results" class="hidden text-center py-16 text-gray-500 font-inter">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h4 class="text-lg font-semibold text-primary font-montserrat">No Services Found</h4>
            <p class="text-sm mt-1">Try searching for keywords like "EPF", "Safety", or "Claims".</p>
        </div>
    </div>
</section>

<!-- Latest Articles -->
<section class="py-20 md:py-32 px-4 md:px-16 relative overflow-hidden bg-[#F9FAFB]" id="news-section">
    <div class="container mx-auto">
        <div class="flex justify-between items-end mb-12" data-aos="fade-up">
            <div>
                <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">
                    Updates & Announcements</p>
                <h2 class="section-title">
                    Latest Articles</h2>
            </div>
            <a href="articles" class="hidden md:flex items-center space-x-2 border border-secondary text-secondary font-bold py-2.5 px-6 rounded-lg hover:bg-secondary hover:text-white transition-all text-xs uppercase tracking-wider">
                <span>View All</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if(empty($recentNews)): ?>
                <div class="col-span-3 text-center text-gray-500 py-10">No recent articles available.</div>
            <?php else: ?>
                <?php foreach($recentNews as $news): ?>
                <div class="news-card">
                    <div>
                        <div class="h-56 overflow-hidden bg-gray-100 flex items-center justify-center">
                            <?php if(!empty($news['cover_image']) && file_exists('admin/' . $news['cover_image'])): ?>
                                <img loading="lazy" src="admin/<?= htmlspecialchars($news['cover_image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <?php endif; ?>
                        </div>
                        <div class="p-8 pb-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs text-gray-500 font-inter font-bold"><?= date('M d, Y', strtotime($news['created_at'])) ?></span>
                                <span class="text-[9px] font-bold text-secondary bg-[#FFF0F0] px-2.5 py-1 rounded uppercase tracking-wider font-inter"><?= htmlspecialchars($news['category']) ?></span>
                            </div>
                            <h3 class="text-lg font-semibold text-primary font-montserrat mb-4 leading-snug hover:text-secondary transition-colors line-clamp-2 notranslate">
                                <?= htmlspecialchars($news['title']) ?>
                            </h3>
                            <p class="text-gray-500 text-[14px] font-inter leading-relaxed line-clamp-3 notranslate">
                                <?= htmlspecialchars(mb_substr(strip_tags($news['content']), 0, 150)) ?>...
                            </p>
                        </div>
                    </div>
                    <div class="p-8 pt-2">
                        <a href="article/<?= $news['id'] ?>" class="text-secondary font-bold text-xs flex items-center hover:text-primary transition-colors uppercase tracking-wider gap-1.5">
                            Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="mt-10 text-center md:hidden">
            <a href="#"
                class="inline-flex items-center space-x-2 border border-secondary text-secondary font-bold py-3 px-8 rounded-lg hover:bg-secondary hover:text-white transition-all text-xs tracking-wider uppercase">
                <span>View All Articles</span>
            </a>
        </div>
    </div>
</section>

<!-- Media Gallery -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white border-t border-gray-100" id="media-gallery">
    <div class="container mx-auto">
        <div class="flex justify-between items-end mb-12">
            <div>
                <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">
                    Recent Events & Activities</p>
                <h2 class="section-title">
                    Media Gallery</h2>
            </div>
            <a href="gallery"
                class="hidden md:flex items-center space-x-2 border border-secondary text-secondary font-bold py-2.5 px-6 rounded-lg hover:bg-secondary hover:text-white transition-all text-[12px] uppercase tracking-wider">
                <span>View All</span>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
            <?php if(empty($galleryItems)): ?>
                <div class="col-span-2 lg:col-span-4 text-center text-gray-500 py-10">No gallery items available.</div>
            <?php else: ?>
                <?php foreach($galleryItems as $item): ?>
                <!-- Media Item -->
                <a href="gallery-album/<?= $item['id'] ?>" class="group relative bg-gray-100 rounded-[20px] overflow-hidden aspect-[4/5] sm:aspect-[3/4] md:aspect-[4/5] lg:aspect-auto lg:h-[280px] shadow-sm cursor-pointer block">
                    <img loading="lazy" src="admin/<?= htmlspecialchars($item['cover_image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(102,102,102,0)_0%,rgba(10,10,10,0.8)_100%)] opacity-90 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 p-4 sm:p-6 flex flex-col justify-end w-full z-10">
                        <p class="text-white font-semibold font-montserrat text-xs sm:text-sm line-clamp-2 leading-snug"><?= htmlspecialchars($item['title']) ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>



        <!-- Special Notices Column -->
        <div class="bg-white rounded-[32px] border-[0.5px] border-[#D4D4D4] shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="bg-primary text-white py-6 px-8 relative overflow-hidden">
                    <h3 class="font-semibold text-xl md:text-2xl font-montserrat flex items-center relative z-10">Special Notices</h3>
                </div>
                <div class="divide-y divide-gray-200 bg-white">
                    <?php if(empty($specialNotices)): ?>
                        <div class="p-8 text-center text-gray-500 font-inter">No special notices available at the moment.</div>
                    <?php else: ?>
                        <?php foreach($specialNotices as $notice): ?>
                        <div class="p-6 md:p-8 flex justify-between items-center gap-6 hover:bg-gray-50/50 transition-colors duration-200">
                            <div class="flex-grow">
                                <h4 class="text-gray-800 font-semibold font-montserrat mb-1.5 text-[15px] md:text-[16px] leading-snug notranslate"><?= htmlspecialchars($notice['title']) ?></h4>
                                <p class="text-[13px] text-gray-400 font-inter"><?= date('M d, Y', strtotime($notice['created_at'])) ?></p>
                            </div>
                            <a href="article/<?= $notice['id'] ?>"
                                class="border border-secondary/70 text-secondary hover:bg-secondary hover:text-white text-[12px] font-bold px-5 py-2.5 rounded-lg transition-all duration-200 text-center whitespace-nowrap tracking-wide font-inter shrink-0">Read More</a>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Institutions -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white border-t border-gray-100" id="affiliated-institutions">
    <div class="container mx-auto">
        <div class="mb-14">
            <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">
                Affiliated
                Bodies</p>
            <h2 class="section-title">
                Institutions</h2>
        </div>

        <div class="flex flex-col md:flex-row gap-8 lg:gap-12 bg-white rounded-2xl">
            <!-- Vertical Tabs -->
            <div class="w-full md:w-[35%] flex flex-col space-y-2">
                <button
                    class="text-left px-5 py-4 bg-primary text-white font-semibold text-[14px] rounded-xl font-montserrat transition-all duration-300 shadow-md cursor-pointer focus:outline-none inst-tab-btn active"
                    data-target="inst-dol">
                    Department of Labour
                </button>
                <button
                    class="text-left px-5 py-4 text-gray-600 hover:bg-gray-50 font-semibold text-[14px] rounded-xl font-montserrat transition-all duration-300 border border-transparent hover:border-gray-200 cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-niosh">
                    NIOSH Sri Lanka
                </button>
                <button
                    class="text-left px-5 py-4 text-gray-600 hover:bg-gray-50 font-semibold text-[14px] rounded-xl font-montserrat transition-all duration-300 border border-transparent hover:border-gray-200 cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-svfb">
                    Shrama Vasana Fund Board
                </button>
                <button
                    class="text-left px-5 py-4 text-gray-600 hover:bg-gray-50 font-semibold text-[14px] rounded-xl font-montserrat transition-all duration-300 border border-transparent hover:border-gray-200 cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-wc">
                    Workmen's Compensation Office
                </button>
                <button
                    class="text-left px-5 py-4 text-gray-600 hover:bg-gray-50 font-semibold text-[14px] rounded-xl font-montserrat transition-all duration-300 border border-transparent hover:border-gray-200 cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-epf">
                    Employees' Provident Fund Dept
                </button>
                <button
                    class="text-left px-5 py-4 text-gray-600 hover:bg-gray-50 font-semibold text-[14px] rounded-xl font-montserrat transition-all duration-300 border border-transparent hover:border-gray-200 cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-etf">
                    Employees' Trust Fund Board
                </button>
            </div>

            <!-- Content Area -->
            <div class="w-full md:w-[65%]">
                <div
                    class="bg-gray-50 rounded-3xl p-8 md:p-10 border-[0.5px] border-[#D4D4D4] shadow-inner min-h-[380px] flex flex-col justify-between">

                    <!-- Panel: Department of Labour (Active by default) -->
                    <div id="inst-panel-inst-dol" class="inst-panel transition-all duration-300 active-panel-block">
                        <h3 class="text-2xl font-semibold text-primary mb-6 font-montserrat tracking-tight">Department
                            of Labour</h3>
                        <div class="space-y-5 text-gray-600 text-[14.5px] font-inter leading-relaxed mb-10">
                            <p>The Department of Labour was initially established to look into the welfare of Indian
                                Immigrant Labour and was called the Department of Indian Immigrant Labour. Enactment of
                                Indian Immigrant Labour Ordinance No. 1 of 1923 provided for the establishment of the
                                Department of Indian Immigrant Labour.</p>
                            <p>However, with the gradual expansion of the indigenous segment of the labour force, labour
                                perse became a force to be reckoned with. In these circumstances the colonial rulers
                                were compelled to look beyond their limited scope of looking into the welfare of Indian
                                Immigrant Labour and had to take measures for the welfare and well-being of all the
                                workers alike, Accordingly, in 1931 the Department of Indian Immigrant Labour was
                                transformed into the General Department of Labour- the state agency responsible for
                                ensuring the welfare of both Indian Migrant Labour as well as indigenous labour,
                                Initially the Head of the Department was designated as Controller of Labour, but in 1944
                                the Head was re-designated as Commissioner of Labour and year 2000 as Commissioner
                                General of Labour.</p>
                        </div>
                        <a href="#"
                            class="inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-extrabold text-xs tracking-wider px-8 py-3 rounded-lg uppercase transition-all shadow-sm active:scale-95">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: NIOSH -->
                    <div id="inst-panel-inst-niosh" class="inst-panel hidden transition-all duration-300">
                        <h3 class="text-2xl font-semibold text-primary mb-6 font-montserrat tracking-tight">National
                            Institute of Occupational Safety and Health (NIOSH)</h3>
                        <div class="space-y-5 text-gray-600 text-[14.5px] font-inter leading-relaxed mb-10">
                            <p>NIOSH Sri Lanka is tasked with executing research, generating safety reports, and
                                formulating policies concerning occupational health and physical safety in commercial
                                and manufacturing workspace environments.</p>
                            <p>By organizing vocational safety drills and safety compliance auditing programs, the
                                institute helps domestic industries minimize hazard risks and comply with national
                                factories ordinance mandates.</p>
                        </div>
                        <a href="#"
                            class="inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-extrabold text-xs tracking-wider px-8 py-3 rounded-lg uppercase transition-all shadow-sm active:scale-95">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: Shrama Vasana Fund Board -->
                    <div id="inst-panel-inst-svfb" class="inst-panel hidden transition-all duration-300">
                        <h3 class="text-2xl font-semibold text-primary mb-6 font-montserrat tracking-tight">Shrama
                            Vasana Fund Board</h3>
                        <div class="space-y-5 text-gray-600 text-[14.5px] font-inter leading-relaxed mb-10">
                            <p>The Shrama Vasana Fund Board serves to manage medical aid distributions, child vocational
                                scholarships, and emergency distress grants for formal industrial workers in Sri Lanka.
                            </p>
                            <p>The board regularly runs employee welfare lotteries to secure operational funds,
                                facilitating safety and health security programs for workers under difficult financial
                                brackets.</p>
                        </div>
                        <a href="#"
                            class="inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-extrabold text-xs tracking-wider px-8 py-3 rounded-lg uppercase transition-all shadow-sm active:scale-95">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: Workmen's Compensation Office -->
                    <div id="inst-panel-inst-wc" class="inst-panel hidden transition-all duration-300">
                        <h3 class="text-2xl font-semibold text-primary mb-6 font-montserrat tracking-tight">Office of
                            the Commissioner for Workmen's Compensation</h3>
                        <div class="space-y-5 text-gray-600 text-[14.5px] font-inter leading-relaxed mb-10">
                            <p>This regulatory judicial body is tasked with arbitrating, registering, and distributing
                                formal compensation claims arising from workplace physical injuries or accidental death
                                in Sri Lanka.</p>
                            <p>The commissioner enforces compliance under the Workmen's Compensation Ordinance, ensuring
                                employers distribute prompt and legal payouts to affected families.</p>
                        </div>
                        <a href="#"
                            class="inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-extrabold text-xs tracking-wider px-8 py-3 rounded-lg uppercase transition-all shadow-sm active:scale-95">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: EPF -->
                    <div id="inst-panel-inst-epf" class="inst-panel hidden transition-all duration-300">
                        <h3 class="text-2xl font-semibold text-primary mb-6 font-montserrat tracking-tight">Employees'
                            Provident Fund Department</h3>
                        <div class="space-y-5 text-gray-600 text-[14.5px] font-inter leading-relaxed mb-10">
                            <p>The largest social security financial fund in Sri Lanka, the EPF Department registers and
                                maintains savings and compound dividend interest profiles for millions of formal
                                employees.</p>
                            <p>Operating jointly with the Central Bank of Sri Lanka, the fund administers payout
                                registrations, housing loan releases, and employer payment compliance auditing.</p>
                        </div>
                        <a href="#"
                            class="inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-extrabold text-xs tracking-wider px-8 py-3 rounded-lg uppercase transition-all shadow-sm active:scale-95">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: ETF -->
                    <div id="inst-panel-inst-etf" class="inst-panel hidden transition-all duration-300">
                        <h3 class="text-2xl font-semibold text-primary mb-6 font-montserrat tracking-tight">Employees'
                            Trust Fund Board (ETF)</h3>
                        <div class="space-y-5 text-gray-600 text-[14.5px] font-inter leading-relaxed mb-10">
                            <p>The ETF Board secures and administers member contributions to provide workers with
                                medical benefits, retirement insurance, and housing loans separately from basic EPF
                                allocations.</p>
                            <p>The fund invests aggressively in stable domestic securities to maximize bonus dividends
                                and welfare opportunities for registered private sector workforces.</p>
                        </div>
                        <a href="#"
                            class="inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-extrabold text-xs tracking-wider px-8 py-3 rounded-lg uppercase transition-all shadow-sm active:scale-95">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
