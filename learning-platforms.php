<?php
$page_title = 'Learning Platforms';
$pageTitle = 'Learning Platforms - Ministry of Labour - Sri Lanka';
$metaDescription = 'Access local and foreign learning platforms, training programs, publications, and study resources from the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Learning Platforms, Training, Publications, Local Publications, Foreign Publications, Ministry of Labour, Sri Lanka';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Main Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-[#FAFAFA] min-h-[50vh] flex items-center">
    <div class="container mx-auto max-w-5xl">
        <!-- Section Intro -->
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <p class="text-secondary font-semibold text-xs md:text-sm tracking-[0.2em] uppercase mb-3 font-inter">Educational Resources</p>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-montserrat text-primary mb-4">Learning Platforms</h2>
            <p class="text-gray-500 text-[14px] md:text-[15px] font-inter leading-relaxed">
                Select a publication category below to browse official educational frameworks, training modules, guides, and learning resources managed by the Ministry of Labour.
            </p>
        </div>
        
        <!-- Platform Selection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <!-- Card 1: Local Publications -->
            <div class="group relative bg-white border border-gray-100 rounded-[28px] p-8 md:p-10 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_12px_30px_rgba(0,0,0,0.06)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden" data-aos="fade-right">
                <!-- Decorative background gradient on hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-secondary/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                
                <div>
                    <!-- Icon Badge -->
                    <div class="w-16 h-16 rounded-[20px] bg-red-50 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <!-- Badge and Title -->
                    <div class="flex items-center gap-3 mb-4">
                        <h3 class="text-xl md:text-2xl font-bold font-montserrat text-primary">Local Publications</h3>
                        <span class="px-2.5 py-0.5 bg-red-50 text-secondary text-[10px] font-bold rounded-full uppercase tracking-wider">Local</span>
                    </div>
                    <!-- Description -->
                    <p class="text-gray-500 text-[14px] leading-relaxed mb-8 font-inter">
                        Explore essential training materials, local publications, reports, acts, and study guides aligned with Sri Lankan labour standards, vocational development, and industrial welfare.
                    </p>
                </div>
                <!-- Action Link -->
                <a href="learning-platforms-local" class="inline-flex items-center gap-2 text-secondary hover:text-primary font-bold text-[14.5px] transition-colors group/link">
                    Access Local Platform
                    <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <!-- Card 2: Foreign Publications -->
            <div class="group relative bg-white border border-gray-100 rounded-[28px] p-8 md:p-10 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_12px_30px_rgba(0,0,0,0.06)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden" data-aos="fade-left">
                <!-- Decorative background gradient on hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                
                <div>
                    <!-- Icon Badge -->
                    <div class="w-16 h-16 rounded-[20px] bg-blue-50 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253" />
                        </svg>
                    </div>
                    <!-- Badge and Title -->
                    <div class="flex items-center gap-3 mb-4">
                        <h3 class="text-xl md:text-2xl font-bold font-montserrat text-primary">Foreign Publications</h3>
                        <span class="px-2.5 py-0.5 bg-blue-50 text-primary text-[10px] font-bold rounded-full uppercase tracking-wider">Foreign</span>
                    </div>
                    <!-- Description -->
                    <p class="text-gray-500 text-[14px] leading-relaxed mb-8 font-inter">
                        Browse international educational materials, training agreements, guidelines from organizations such as the ILO, and scholarship pathways supporting foreign employment.
                    </p>
                </div>
                <!-- Action Link -->
                <a href="learning-platforms-foreign" class="inline-flex items-center gap-2 text-primary hover:text-secondary font-bold text-[14.5px] transition-colors group/link">
                    Access Foreign Platform
                    <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
