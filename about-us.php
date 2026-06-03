<?php
// about-us.php
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative h-[300px] md:h-[400px] flex items-center bg-primary overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/sub-hero.webp');"></div>
    <div class="absolute inset-0 opacity-70 bg-sub-hero-gradient">
    </div>

    <div class="relative z-10 container mx-auto px-4 md:px-16 text-white w-full">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold font-montserrat mb-4 leading-none tracking-tighter">
            About Us</h1>
        <div class="flex items-center text-[13px] md:text-sm font-inter text-gray-300">
            <a href="index" class="hover:text-white transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">About Us</span>
        </div>
    </div>
</section>

<!-- Overview Section -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white">
    <div class="container mx-auto flex flex-col lg:flex-row gap-16 items-center">
        <!-- Collage -->
        <div class="w-full lg:w-1/2">
            <div class="grid grid-cols-2 gap-4">
                <img src="assets/img/about-us/overview-1.webp" alt="Ministry Building"
                    class="w-full h-48 md:h-64 object-cover rounded-2xl md:rounded-3xl shadow-sm">
                <img src="assets/img/about-us/overview-2.webp" alt="Official Speaker"
                    class="w-full h-48 md:h-64 object-cover rounded-2xl md:rounded-3xl shadow-sm">
                <img src="assets/img/about-us/overview-3.webp" alt="Audience"
                    class="col-span-2 w-full h-64 md:h-80 object-cover rounded-2xl md:rounded-3xl shadow-sm">
            </div>
        </div>
        <!-- Content -->
        <div class="w-full lg:w-1/2">
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
    <div class="container mx-auto">
        <h2 class="text-2xl md:text-3xl font-bold text-primary font-montserrat mb-12 text-center">Our Partners</h2>
        <div class="flex flex-wrap justify-center items-center gap-10 md:gap-20">
            <img src="assets/img/about-us/partner-1.png" alt="Partner 1"
                class="h-14 md:h-20 object-contain hover:scale-105 transition-transform duration-300">
            <img src="assets/img/about-us/partner-2.png" alt="Partner 2"
                class="h-14 md:h-20 object-contain hover:scale-105 transition-transform duration-300">
            <img src="assets/img/about-us/partner-3.png" alt="Partner 3"
                class="h-14 md:h-20 object-contain hover:scale-105 transition-transform duration-300">
            <img src="assets/img/about-us/partner-4.png" alt="Partner 4"
                class="h-14 md:h-20 object-contain hover:scale-105 transition-transform duration-300">
            <img src="assets/img/about-us/partner-5.png" alt="Partner 5"
                class="h-14 md:h-20 object-contain hover:scale-105 transition-transform duration-300">
            <img src="assets/img/about-us/partner-6.png" alt="Partner 6"
                class="h-14 md:h-20 object-contain hover:scale-105 transition-transform duration-300">
        </div>
    </div>
</section>

<!-- Vision & Mission / Organizational Chart -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row rounded-3xl overflow-hidden shadow-lg border-[0.5px] border-[#D4D4D4]">
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
                <h3
                    class="text-2xl md:text-3xl font-semibold font-montserrat text-gray-900 mb-5 text-left">
                    Organizational Chart</h3>

                <div
                    class="relative group rounded-xl border-[0.5px] border-[#D4D4D4] bg-gray-50 p-2 max-w-[380px] w-full mr-auto">
                    <img src="assets/img/about-us/organizational-chart.webp" alt="Organizational Chart"
                        class="w-full h-40 md:h-48 lg:h-56 object-contain rounded-lg cursor-pointer mix-blend-multiply"
                        onclick="document.getElementById('org-chart-modal').classList.remove('hidden'); document.getElementById('org-chart-modal').classList.add('flex');">

                    <!-- Action Buttons -->
                    <div
                        class="absolute bottom-3 right-3 flex items-center bg-white/90 backdrop-blur-sm rounded-lg overflow-hidden border border-gray-200 shadow-sm opacity-90 group-hover:opacity-100 transition-opacity">
                        <button
                            onclick="document.getElementById('org-chart-modal').classList.remove('hidden'); document.getElementById('org-chart-modal').classList.add('flex');"
                            class="p-2 text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors"
                            title="Preview">
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

    <!-- Organizational Chart Modal -->
    <div id="org-chart-modal" class="fixed inset-0 z-[100] bg-black/80 hidden items-center justify-center p-4 md:p-10">
        <!-- Close overlay background -->
        <div class="absolute inset-0 cursor-pointer"
            onclick="document.getElementById('org-chart-modal').classList.add('hidden'); document.getElementById('org-chart-modal').classList.remove('flex');">
        </div>
        <div class="relative w-full max-w-6xl max-h-full flex flex-col items-center z-10">
            <button
                onclick="document.getElementById('org-chart-modal').classList.add('hidden'); document.getElementById('org-chart-modal').classList.remove('flex');"
                class="absolute -top-12 right-0 md:-right-8 text-white/80 hover:text-white transition-colors p-2"
                title="Close">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <img src="assets/img/about-us/organizational-chart.webp" alt="Organizational Chart Full Size"
                class="w-full h-auto max-h-[85vh] object-contain bg-white rounded-lg shadow-2xl relative z-20">
        </div>
    </div>
</section>

<!-- Our Officials -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-[#FAFAFA]">
    <div class="container mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-14">Our Officials</h2>

        <!-- Top Officials -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            <!-- Minister -->
            <div
                class="bg-white rounded-3xl overflow-hidden shadow-sm border-[0.5px] border-[#D4D4D4] hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/official-minister.webp" alt="Hon. Minister of Labour"
                        class="w-full h-[380px] object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8">
                    <h3 class="text-[17px] font-bold font-montserrat text-primary mb-1">Hon. Minister of Labour</h3>
                    <p class="text-gray-500 font-inter text-sm mb-5">Mr. Nimal Siripala de Silva</p>
                    <div class="flex gap-2.5">
                        <a href="mailto:minister@labour.gov.lk"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Email"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Call"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Fax"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="LinkedIn"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>

            <!-- Deputy Minister -->
            <div
                class="bg-white rounded-3xl overflow-hidden shadow-sm border-[0.5px] border-[#D4D4D4] hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/official-deputy-minister.webp" alt="Hon. Deputy Minister of Labour"
                        class="w-full h-[380px] object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8">
                    <h3 class="text-[17px] font-bold font-montserrat text-primary mb-1">Hon. Deputy Minister of Labour
                    </h3>
                    <p class="text-gray-500 font-inter text-sm mb-5">Mr. Mahinda Samarasinghe</p>
                    <div class="flex gap-2.5">
                        <a href="mailto:deputyminister@labour.gov.lk"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Email"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Call"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Fax"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="LinkedIn"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>

            <!-- Secretary -->
            <div
                class="bg-white rounded-3xl overflow-hidden shadow-sm border-[0.5px] border-[#D4D4D4] hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/official-secretary.webp" alt="Secretary"
                        class="w-full h-[380px] object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8">
                    <h3 class="text-[17px] font-bold font-montserrat text-primary mb-1">Secretary</h3>
                    <p class="text-gray-500 font-inter text-sm mb-5">Mr. R.P.A. Wimalaweera</p>
                    <div class="flex gap-2.5">
                        <a href="mailto:secretary@labour.gov.lk"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Email"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Call"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="Fax"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-all text-xs"
                            title="LinkedIn"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Tabs -->
        <div class="flex overflow-x-auto gap-4 md:gap-8 mb-10 border-b border-gray-200 pb-1 scrollbar-none">
            <button
                class="px-2 py-3 border-b-2 border-primary text-primary font-bold font-montserrat whitespace-nowrap text-sm md:text-base cursor-pointer">Administration</button>
            <button
                class="px-2 py-3 border-b-2 border-transparent text-gray-400 hover:text-gray-700 font-semibold font-montserrat whitespace-nowrap text-sm md:text-base transition-colors cursor-pointer">Development</button>
            <button
                class="px-2 py-3 border-b-2 border-transparent text-gray-400 hover:text-gray-700 font-semibold font-montserrat whitespace-nowrap text-sm md:text-base transition-colors cursor-pointer">Planning</button>
            <button
                class="px-2 py-3 border-b-2 border-transparent text-gray-400 hover:text-gray-700 font-semibold font-montserrat whitespace-nowrap text-sm md:text-base transition-colors cursor-pointer">Finance</button>
            <button
                class="px-2 py-3 border-b-2 border-transparent text-gray-400 hover:text-gray-700 font-semibold font-montserrat whitespace-nowrap text-sm md:text-base transition-colors cursor-pointer">Internal
                Audit</button>
            <button
                class="px-2 py-3 border-b-2 border-transparent text-gray-400 hover:text-gray-700 font-semibold font-montserrat whitespace-nowrap text-sm md:text-base transition-colors cursor-pointer">Foreign
                Relations</button>
        </div>

        <!-- Administration Team Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <!-- Admin 1 -->
            <div
                class="bg-white rounded-2xl overflow-hidden border-[0.5px] border-[#D4D4D4] shadow-sm hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/admin-wijesooriya.webp" alt="Additional Secretary"
                        class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h4 class="font-bold font-montserrat text-primary text-[13px] mb-1 leading-tight">Additional
                        Secretary (Administration)</h4>
                    <p class="text-[12px] text-gray-500 font-inter mb-4">Mrs. H.M.D.N. Herath</p>
                    <div class="flex gap-2">
                        <a href="mailto:info@labour.gov.lk"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Email"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Call"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Fax"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="LinkedIn"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>

            <!-- Admin 2 -->
            <div
                class="bg-white rounded-2xl overflow-hidden border-[0.5px] border-[#D4D4D4] shadow-sm hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/admin-darshana.webp" alt="Senior Assistant Secretary"
                        class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h4 class="font-bold font-montserrat text-primary text-[13px] mb-1 leading-tight">Senior Assistant
                        Secretary (Administration)</h4>
                    <p class="text-[12px] text-gray-500 font-inter mb-4">Mr. J.A.D. Darshana</p>
                    <div class="flex gap-2">
                        <a href="mailto:info@labour.gov.lk"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Email"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Call"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Fax"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="LinkedIn"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>

            <!-- Admin 3 -->
            <div
                class="bg-white rounded-2xl overflow-hidden border-[0.5px] border-[#D4D4D4] shadow-sm hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/admin-yashoda.webp" alt="Assistant Secretary"
                        class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h4 class="font-bold font-montserrat text-primary text-[13px] mb-1 leading-tight">Assistant
                        Secretary (Administration)</h4>
                    <p class="text-[12px] text-gray-500 font-inter mb-4">Mrs. Yashoda</p>
                    <div class="flex gap-2">
                        <a href="mailto:info@labour.gov.lk"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Email"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Call"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Fax"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="LinkedIn"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>

            <!-- Admin 4 -->
            <div
                class="bg-white rounded-2xl overflow-hidden border-[0.5px] border-[#D4D4D4] shadow-sm hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/admin-muditha.webp" alt="Assistant Secretary"
                        class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h4 class="font-bold font-montserrat text-primary text-[13px] mb-1 leading-tight">Assistant
                        Secretary (Establishment)</h4>
                    <p class="text-[12px] text-gray-500 font-inter mb-4">Ms. Muditha Thushari</p>
                    <div class="flex gap-2">
                        <a href="mailto:info@labour.gov.lk"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Email"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Call"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Fax"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="LinkedIn"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>

            <!-- Admin 5 -->
            <div
                class="bg-white rounded-2xl overflow-hidden border-[0.5px] border-[#D4D4D4] shadow-sm hover:shadow-md transition-shadow group">
                <div class="overflow-hidden">
                    <img src="assets/img/about-us/admin-luxiga.webp" alt="Legal Officer"
                        class="w-full h-56 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h4 class="font-bold font-montserrat text-primary text-[13px] mb-1 leading-tight">Legal Officer</h4>
                    <p class="text-[12px] text-gray-500 font-inter mb-4">Ms. S.H.R. Dissanayake</p>
                    <div class="flex gap-2">
                        <a href="mailto:info@labour.gov.lk"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Email"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112581141"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Call"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg></a>
                        <a href="tel:+94112368165"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="Fax"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M18 8h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3" />
                                <path d="M6 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h3" />
                                <path d="M2 10h20" />
                                <path d="M5 3h14a2 2 0 0 1 2 2v3H3V5a2 2 0 0 1 2-2z" />
                                <path d="M8 12h8v8H8z" />
                            </svg></a>
                        <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer"
                            class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors"
                            title="LinkedIn"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How We Operate -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white">
    <div class="container mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-12">How We Operate</h2>

        <div class="bg-white rounded-2xl border-[0.5px] border-[#D4D4D4] shadow-lg overflow-hidden">
            <!-- Tabs Navigation -->
            <div class="flex flex-col md:flex-row border-b border-gray-100 bg-gray-50/50" id="operate-tabs">
                <button onclick="switchOperateTab('objectives')" id="tab-btn-objectives"
                    class="flex-1 px-6 py-5 text-center font-bold font-montserrat text-sm md:text-base transition-all bg-[#13273F] text-white cursor-pointer">
                    Objectives
                </button>
                <button onclick="switchOperateTab('thrust-areas')" id="tab-btn-thrust-areas"
                    class="flex-1 px-6 py-5 text-center font-semibold font-montserrat text-sm md:text-base transition-all text-gray-500 hover:text-primary hover:bg-gray-50/80 border-y md:border-y-0 md:border-x border-gray-100 cursor-pointer">
                    Major Thrust Areas
                </button>
                <button onclick="switchOperateTab('legal-framework')" id="tab-btn-legal-framework"
                    class="flex-1 px-6 py-5 text-center font-semibold font-montserrat text-sm md:text-base transition-all text-gray-500 hover:text-primary hover:bg-gray-50/80 cursor-pointer">
                    Related Institutional and Legal Framework
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="p-8 md:p-12">
                <!-- Objectives Content -->
                <div id="tab-content-objectives" class="operate-tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium">To empower and
                                strengthen the industrial relationship</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium">To ensure private
                                occupation growth and decent work</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium">To eliminate child
                                labour</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium">To protect and empower
                                employed women and promote occupational safety and health</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium">To expedite relevant
                                statutory reforms</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium">To take action to
                                develop a comprehensive social protection strategy</p>
                        </div>
                    </div>
                </div>

                <!-- Thrust Areas Content -->
                <div id="tab-content-thrust-areas" class="operate-tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Industrial Peace and Harmony:</strong> Maintaining stability and productivity in industrial relations.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Labour Standards and Enforcement:</strong> Rigorous inspections and enforcement of statutory working conditions.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Occupational Safety and Health (OSH):</strong> Developing and mandating safety measures in work environments.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Social Protection Systems:</strong> Managing robust retirement security, welfare, and trust funds (EPF/ETF).</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Education, Training, & Research:</strong> Fostering professional skills to elevate workforce competitiveness.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Vulnerable Group Safeguards:</strong> Prioritizing the complete elimination of child labour and promoting gender equity.</p>
                        </div>
                    </div>
                </div>

                <!-- Legal Framework Content -->
                <div id="tab-content-legal-framework" class="operate-tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Industrial Disputes Act No. 43 of 1950:</strong> The core legislation regulating dispute resolutions and employment terminations.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Shop and Office Employees Act No. 19 of 1954:</strong> Sets working hours, holidays, leaves, and basic workplace regulations.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Employees' Provident Fund (EPF) & ETF Acts:</strong> Mandates employer and worker contributions toward retirement trust benefits.</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1.5 w-4 h-4 rounded-full bg-[#8B1A1A] shrink-0"></div>
                            <p class="text-gray-700 font-inter text-[15px] leading-relaxed font-medium"><strong>Wages Boards Ordinance & Factories Ordinance:</strong> Enforces minimum wage standards and occupational factory safety rules.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function switchOperateTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.operate-tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Show target tab content
    document.getElementById('tab-content-' + tabId).classList.remove('hidden');
    
    // Reset all tab buttons classes
    const activeClasses = ['bg-[#13273F]', 'text-white', 'font-bold'];
    const inactiveClasses = ['text-gray-500', 'hover:text-primary', 'hover:bg-gray-50/80', 'font-semibold'];
    
    const tabs = ['objectives', 'thrust-areas', 'legal-framework'];
    
    tabs.forEach(tId => {
        const btn = document.getElementById('tab-btn-' + tId);
        if (tId === tabId) {
            btn.classList.add(...activeClasses);
            btn.classList.remove(...inactiveClasses);
        } else {
            btn.classList.remove(...activeClasses);
            btn.classList.add(...inactiveClasses);
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>