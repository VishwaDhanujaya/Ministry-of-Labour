<?php
// index.php
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative h-[550px] md:h-[650px] flex items-center bg-primary overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/hero.webp');"></div>
    <div class="absolute inset-0 opacity-55 bg-home-hero-gradient">
    </div>

    <div class="relative z-10 container mx-auto px-4 md:px-16 text-white w-full">
        <div class="max-w-2xl">
            <h2 class="text-2xl md:text-3xl font-inter font-normal mb-2">Welcome to</h2>
            <h1
                class="text-4xl md:text-6xl lg:text-7.5xl font-semibold font-montserrat mb-6 leading-none tracking-tighter uppercase">
                Ministry of Labour</h1>
            <p class="text-[13px] md:text-base font-inter mb-10 leading-relaxed text-gray-300 max-w-xl">
                The Ministry of Labour is dedicated to fostering fair employment, protecting workers' rights, and
                building a dynamic workforce that drives Sri Lanka's economic development.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#citizen-services"
                    class="bg-secondary text-white font-semibold py-3.5 px-8 rounded-lg transition-colors duration-300 text-[13px] tracking-wider font-inter">Explore
                    Services</a>
                <a href="#news-section"
                    class="border border-white text-white font-semibold py-3.5 px-8 rounded-lg transition-colors duration-300 text-[13px] tracking-wider font-inter flex items-center hover:bg-white hover:text-primary">View
                    Notices</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="bg-secondary text-white py-10 relative z-20">
    <div class="container mx-auto px-4 md:px-16 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center md:divide-x divide-white/20">
            <div class="px-4 stat-box" data-target="6.2" data-suffix="M+" data-multiplier="1">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span>M+</div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    Workers Protected</div>
            </div>
            <div class="px-4 stat-box" data-target="32" data-suffix="+">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span>+</div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    Labour Acts Enforced</div>
            </div>
            <div class="px-4 stat-box" data-target="14">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span></div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    Affiliated Institutions</div>
            </div>
            <div class="px-4 stat-box" data-target="1250">
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
        <div class="w-full lg:w-[55%]">
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
                <div class="about-stat-card">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number">8</span>
                    <span class="about-stat-label">Services</span>
                </div>
                <div class="about-stat-card">
                    <div class="about-stat-card-accent"></div>
                    <span class="about-stat-number">5+</span>
                    <span class="about-stat-label">Partners</span>
                </div>
            </div>
        </div>

        <!-- Styled administrative image container -->
        <div class="w-full lg:w-[45%]">
            <div
                class="rounded-3xl overflow-hidden shadow-lg border-[0.5px] border-[#D4D4D4] h-[450px] lg:h-[530px] w-full bg-gray-50">
                <img src="assets/img/home-about.webp" alt="Ministry of Labour Head Office"
                    class="w-full h-full object-cover">
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
    <div class="container mx-auto relative z-10">
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
        </div>
</section>

<!-- Citizen Services -->
<section class="py-20 md:py-28 px-4 md:px-16" id="citizen-services">
    <div class="container mx-auto">
        <div class="text-left mb-12">
            <p class="section-subtitle">Our Services</p>
            <h2 class="section-title mb-3">Citizen Services</h2>
            <p class="text-gray-500 font-inter font-normal text-sm md:text-base mb-10">Access key services offered by the Ministry of Labour and its institutions.</p>
        </div>

        <!-- Cards Container -->
        <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
            <div class="service-card" data-title="Dangerous Occurrences"
                data-keywords="dangerous accident occurrence crash disaster chemical fire construction report">
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

<!-- Latest News & Events -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-[#FAFAFA]" id="news-section">
    <div class="container mx-auto">
        <div class="flex justify-between items-end mb-12">
            <div>
                <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">
                    Updates & Announcements</p>
                <h2 class="section-title">
                    Latest News & Events</h2>
            </div>
            <a href="#"
                class="hidden md:flex items-center space-x-2 border border-secondary text-secondary font-bold py-2.5 px-6 rounded-lg hover:bg-secondary hover:text-white transition-all text-xs uppercase tracking-wider">
                <span>View All</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- News Card 1 -->
            <div class="news-card">
                <div>
                    <div class="h-56 overflow-hidden">
                        <img src="assets/img/home/minister.jpg" alt="Ministry of Labour Introduces New Digital Services for Citizens" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-8 pb-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs text-gray-500 font-inter font-bold">May 15, 2023</span>
                            <span
                                class="text-[9px] font-bold text-secondary bg-[#FFF0F0] px-2.5 py-1 rounded uppercase tracking-wider font-inter">Press
                                Release</span>
                        </div>
                        <h3
                            class="text-lg font-semibold text-primary font-montserrat mb-4 leading-snug hover:text-secondary transition-colors line-clamp-2">
                            Ministry of Labour Introduces New Digital Services for Citizens</h3>
                        <p class="text-gray-500 text-[14px] font-inter leading-relaxed line-clamp-3">In an effort to
                            streamline services and provide better accessibility, the Ministry of Labour has launched a
                            new
                            portal for online EPF registration and tracking.</p>
                    </div>
                </div>
                <div class="p-8 pt-2">
                    <a href="#"
                        class="text-secondary font-bold text-xs flex items-center hover:text-primary transition-colors uppercase tracking-wider gap-1.5">
                        Read more <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- News Card 2 -->
            <div class="news-card">
                <div>
                    <div class="h-56 overflow-hidden">
                        <img src="assets/img/home/cabinet.jpg" alt="National Symposium on Workplace Safety & Health 2023" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-8 pb-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs text-gray-500 font-inter font-bold">May 10, 2023</span>
                            <span
                                class="text-[9px] font-bold text-secondary bg-[#FFF0F0] px-2.5 py-1 rounded uppercase tracking-wider font-inter">Events</span>
                        </div>
                        <h3
                            class="text-lg font-semibold text-primary font-montserrat mb-4 leading-snug hover:text-secondary transition-colors line-clamp-2">
                            National Symposium on Workplace Safety & Health 2023</h3>
                        <p class="text-gray-500 text-[14px] font-inter leading-relaxed line-clamp-3">Industry leaders
                            and
                            government officials gathered to discuss the future of workplace safety regulations and
                            compliance standards across sectors.</p>
                    </div>
                </div>
                <div class="p-8 pt-2">
                    <a href="#"
                        class="text-secondary font-bold text-xs flex items-center hover:text-primary transition-colors uppercase tracking-wider gap-1.5">
                        Read more <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- News Card 3 -->
            <div class="news-card">
                <div>
                    <div class="h-56 overflow-hidden">
                        <img src="assets/img/home/nlac.jpg" alt="Updates to the Minimum Wage Board Regulations" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-8 pb-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs text-gray-500 font-inter font-bold">May 02, 2023</span>
                            <span
                                class="text-[9px] font-bold text-secondary bg-[#FFF0F0] px-2.5 py-1 rounded uppercase tracking-wider font-inter">Notice</span>
                        </div>
                        <h3
                            class="text-lg font-semibold text-primary font-montserrat mb-4 leading-snug hover:text-secondary transition-colors line-clamp-2">
                            Updates to the Minimum Wage Board Regulations</h3>
                        <p class="text-gray-500 text-[14px] font-inter leading-relaxed line-clamp-3">The Ministry
                            announces
                            a revision to the minimum wage guidelines affecting several key industries. Employers are
                            requested to review the new circulars.</p>
                    </div>
                </div>
                <div class="p-8 pt-2">
                    <a href="#"
                        class="text-secondary font-bold text-xs flex items-center hover:text-primary transition-colors uppercase tracking-wider gap-1.5">
                        Read more <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center md:hidden">
            <a href="#"
                class="inline-flex items-center space-x-2 border border-secondary text-secondary font-bold py-3 px-8 rounded-lg hover:bg-secondary hover:text-white transition-all text-xs tracking-wider uppercase">
                <span>View All News</span>
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
            <a href="#"
                class="hidden md:flex items-center space-x-2 border border-secondary text-secondary font-bold py-2.5 px-6 rounded-lg hover:bg-secondary hover:text-white transition-all text-[12px] uppercase tracking-wider">
                <span>View All</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Media Item 1 -->
            <div class="gallery-item" data-caption="Key handover ceremony to top performers 2023">
                <img src="assets/img/home/appointment-letters.jpg" alt="Key handover ceremony to top performers" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 p-6 flex flex-col justify-end w-full gallery-item-overlay z-10">
                    <p class="text-white font-semibold font-montserrat text-sm line-clamp-2 leading-snug">Key handover
                        ceremony to top performers 2023</p>
                </div>
            </div>
            <!-- Media Item 2 -->
            <div class="gallery-item" data-caption="Annual Symposium on National Policy (ASNP)">
                <img src="assets/img/home/cabinet.jpg" alt="Annual Symposium on National Policy (ASNP)" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 p-6 flex flex-col justify-end w-full gallery-item-overlay z-10">
                    <p class="text-white font-semibold font-montserrat text-sm line-clamp-2 leading-snug">Annual
                        Symposium
                        on National Policy (ASNP)</p>
                </div>
            </div>
            <!-- Media Item 3 -->
            <div class="gallery-item" data-caption="Conference at National Labour Board">
                <img src="assets/img/home/nlac.jpg" alt="Conference at National Labour Board" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 p-6 flex flex-col justify-end w-full gallery-item-overlay z-10">
                    <p class="text-white font-semibold font-montserrat text-sm line-clamp-2 leading-snug">Conference at
                        National Labour Board</p>
                </div>
            </div>
            <!-- Media Item 4 -->
            <div class="gallery-item" data-caption="Public awareness campaign on worker's rights">
                <img src="assets/img/home/minister.jpg" alt="Public awareness campaign on worker's rights" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 p-6 flex flex-col justify-end w-full gallery-item-overlay z-10">
                    <p class="text-white font-semibold font-montserrat text-sm line-clamp-2 leading-snug">Public
                        awareness
                        campaign on worker's rights</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal container for Media Gallery -->
<div id="lightbox-modal"
    class="fixed inset-0 bg-[#070e17]/95 backdrop-blur-md z-[120] opacity-0 pointer-events-none transition-all duration-500 flex flex-col justify-center items-center p-4">
    <!-- Close button -->
    <button id="lightbox-close" aria-label="Close Lightbox"
        class="absolute top-6 right-6 w-11 h-11 bg-white/5 border border-white/15 rounded-full flex items-center justify-center text-white hover:bg-white/10 active:scale-95 transition-all focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <!-- Content -->
    <div class="w-full max-w-4xl flex flex-col items-center">
        <div
            class="w-full h-[50vh] md:h-[60vh] bg-premium-card-fallback rounded-2xl border border-white/10 shadow-2xl flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 bg-mesh-pattern opacity-10 animate-pulse-slow"></div>
            <img id="lightbox-img" src="" alt="" class="absolute inset-0 w-full h-full object-contain hidden z-10">
            <div id="lightbox-placeholder" class="flex flex-col items-center justify-center">
                <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" stroke-width="1.2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                    </path>
                </svg>
            </div>
        </div>
        <p id="lightbox-caption"
            class="text-white text-base md:text-lg font-semibold font-montserrat mt-6 text-center max-w-xl leading-relaxed tracking-tight text-glow">
        </p>
    </div>
</div>

<!-- Downloads & Special Notices -->
<section class="py-16 md:py-24 px-4 md:px-16 container mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
        <!-- Downloads Column -->
        <div class="bg-[#F7F7F7] rounded-[32px] border-[0.5px] border-[#D4D4D4] p-8 md:p-10 flex flex-col justify-between">
            <div>
                <p class="text-secondary/80 font-semibold text-xs md:text-sm uppercase tracking-[0.15em] mb-3 font-inter">
                    Important Documents and Resources</p>
                <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-8 tracking-tight">
                    Downloads</h2>

                <div class="space-y-3.5">
                    <a href="#"
                        class="flex justify-between items-center p-4 md:p-5 rounded-2xl border border-gray-200/60 hover:border-secondary hover:shadow-md transition-all duration-300 group bg-white">
                        <span class="font-semibold text-gray-800 font-inter group-hover:text-primary text-[15px] tracking-tight">Application Forms</span>
                        <div class="w-10 h-10 rounded-lg bg-secondary text-white flex items-center justify-center group-hover:bg-[#320000] transition-colors shrink-0 ml-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </div>
                    </a>
                    <a href="#"
                        class="flex justify-between items-center p-4 md:p-5 rounded-2xl border border-gray-200/60 hover:border-secondary hover:shadow-md transition-all duration-300 group bg-white">
                        <span class="font-semibold text-gray-800 font-inter group-hover:text-primary text-[15px] tracking-tight">Annual Reports</span>
                        <div class="w-10 h-10 rounded-lg bg-secondary text-white flex items-center justify-center group-hover:bg-[#320000] transition-colors shrink-0 ml-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </div>
                    </a>
                    <a href="#"
                        class="flex justify-between items-center p-4 md:p-5 rounded-2xl border border-gray-200/60 hover:border-secondary hover:shadow-md transition-all duration-300 group bg-white">
                        <span class="font-semibold text-gray-800 font-inter group-hover:text-primary text-[15px] tracking-tight">List of Valid Trade Unions</span>
                        <div class="w-10 h-10 rounded-lg bg-secondary text-white flex items-center justify-center group-hover:bg-[#320000] transition-colors shrink-0 ml-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </div>
                    </a>
                    <a href="#"
                        class="flex justify-between items-center p-4 md:p-5 rounded-2xl border border-gray-200/60 hover:border-secondary hover:shadow-md transition-all duration-300 group bg-white">
                        <span class="font-semibold text-gray-800 font-inter group-hover:text-primary text-[15px] tracking-tight">Authorized Persons Appointed Under Factories Ordinance</span>
                        <div class="w-10 h-10 rounded-lg bg-secondary text-white flex items-center justify-center group-hover:bg-[#320000] transition-colors shrink-0 ml-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </div>
                    </a>
                    <a href="#"
                        class="flex justify-between items-center p-4 md:p-5 rounded-2xl border border-gray-200/60 hover:border-secondary hover:shadow-md transition-all duration-300 group bg-white">
                        <span class="font-semibold text-gray-800 font-inter group-hover:text-primary text-[15px] tracking-tight">Labour Legislations</span>
                        <div class="w-10 h-10 rounded-lg bg-secondary text-white flex items-center justify-center group-hover:bg-[#320000] transition-colors shrink-0 ml-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </div>
                    </a>
                    <a href="#"
                        class="flex justify-between items-center p-4 md:p-5 rounded-2xl border border-gray-200/60 hover:border-secondary hover:shadow-md transition-all duration-300 group bg-white">
                        <span class="font-semibold text-gray-800 font-inter group-hover:text-primary text-[15px] tracking-tight">Statistics</span>
                        <div class="w-10 h-10 rounded-lg bg-secondary text-white flex items-center justify-center group-hover:bg-[#320000] transition-colors shrink-0 ml-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Special Notices Column -->
        <div class="bg-white rounded-[32px] border-[0.5px] border-[#D4D4D4] shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="bg-primary text-white py-6 px-8 relative overflow-hidden">
                    <h3 class="font-semibold text-xl md:text-2xl font-montserrat flex items-center relative z-10">Special Notices</h3>
                </div>
                <div class="divide-y divide-gray-200 bg-white">
                    <!-- Notice Item 1 -->
                    <div class="p-6 md:p-8 flex justify-between items-center gap-6 hover:bg-gray-50/50 transition-colors duration-200">
                        <div class="flex-grow">
                            <h4 class="text-gray-800 font-semibold font-montserrat mb-1.5 text-[15px] md:text-[16px] leading-snug">Advanced Procurement Notice</h4>
                            <p class="text-[13px] text-gray-400 font-inter">Mar 18, 2026</p>
                        </div>
                        <a href="#"
                            class="border border-secondary/70 text-secondary hover:bg-secondary hover:text-white text-[12px] font-bold px-5 py-2.5 rounded-lg transition-all duration-200 text-center whitespace-nowrap tracking-wide font-inter shrink-0">Read More</a>
                    </div>
                    <!-- Notice Item 2 -->
                    <div class="p-6 md:p-8 flex justify-between items-center gap-6 hover:bg-gray-50/50 transition-colors duration-200">
                        <div class="flex-grow">
                            <h4 class="text-gray-800 font-semibold font-montserrat mb-1.5 text-[15px] md:text-[16px] leading-snug">Registration of Suppliers and Contractors for the Year 2025/2026</h4>
                            <p class="text-[13px] text-gray-400 font-inter">Mar 17, 2026</p>
                        </div>
                        <a href="#"
                            class="border border-secondary/70 text-secondary hover:bg-secondary hover:text-white text-[12px] font-bold px-5 py-2.5 rounded-lg transition-all duration-200 text-center whitespace-nowrap tracking-wide font-inter shrink-0">Read More</a>
                    </div>
                    <!-- Notice Item 3 -->
                    <div class="p-6 md:p-8 flex justify-between items-center gap-6 hover:bg-gray-50/50 transition-colors duration-200">
                        <div class="flex-grow">
                            <h4 class="text-gray-800 font-semibold font-montserrat mb-1.5 text-[15px] md:text-[16px] leading-snug">Procurement of Supply & Installation of Computer Equipment for Department of Labour,Colombo 05</h4>
                            <p class="text-[13px] text-gray-400 font-inter">Mar 16, 2026</p>
                        </div>
                        <a href="#"
                            class="border border-secondary/70 text-secondary hover:bg-secondary hover:text-white text-[12px] font-bold px-5 py-2.5 rounded-lg transition-all duration-200 text-center whitespace-nowrap tracking-wide font-inter shrink-0">Read More</a>
                    </div>
                    <!-- Notice Item 4 -->
                    <div class="p-6 md:p-8 flex justify-between items-center gap-6 hover:bg-gray-50/50 transition-colors duration-200">
                        <div class="flex-grow">
                            <h4 class="text-gray-800 font-semibold font-montserrat mb-1.5 text-[15px] md:text-[16px] leading-snug">Invitation of quotation to rent a building for the operations of the Panadura Labour Office of the Department of Labour (FG/TB/66/2024)</h4>
                            <p class="text-[13px] text-gray-400 font-inter">Mar 16, 2026</p>
                        </div>
                        <a href="#"
                            class="border border-secondary/70 text-secondary hover:bg-secondary hover:text-white text-[12px] font-bold px-5 py-2.5 rounded-lg transition-all duration-200 text-center whitespace-nowrap tracking-wide font-inter shrink-0">Read More</a>
                    </div>
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