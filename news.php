<?php
// news.php
$page_title = 'News';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-[1400px]">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <p class="text-secondary text-sm font-medium tracking-[0.15em] mb-3 font-inter uppercase">Our Blog</p>
            <h2 class="text-3xl md:text-[36px] font-semibold font-montserrat text-gray-900">Latest Insights</h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
            <!-- News Grid -->
            <div class="w-full lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <!-- Card 1 -->
                    <div
                        class="bg-white rounded-[20px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <div class="h-56 overflow-hidden">
                            <img src="assets/img/home/appointment-letters.jpg"
                                alt="38 New Labour Officers Receive Appointment Letters."
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                            <div
                                class="flex justify-between items-center mb-4 text-xs text-gray-500 font-inter font-medium">
                                <span>February 17, 2026</span>
                                <span>Media</span>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors">
                                <a href="news-single" class="hover:text-secondary transition-colors">38 New Labour
                                    Officers Receive Appointment Letters.</a>
                            </h3>
                            <p class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">Appointment
                                letters were presented to 38 newly recruited Labour Officers at a ceremony held on the
                                morning of 16 February at the Labour Ministry Auditorium,...<a href="news-single"
                                    class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1">Read
                                    More</a></p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="bg-white rounded-[20px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <div class="h-56 overflow-hidden">
                            <img src="assets/img/home/cabinet.jpg"
                                alt="The committee approved by the Cabinet to amend the labour laws is consulting the National Labour Advisory Council (NLAC)."
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                            <div
                                class="flex justify-between items-center mb-4 text-xs text-gray-500 font-inter font-medium">
                                <span>February 15, 2026</span>
                                <span>Notices</span>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors">
                                The committee approved by the Cabinet to amend the labour laws is consulting the
                                National Labour Advisory Council (NLAC).
                            </h3>
                            <p class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">A special meeting
                                was organized in Narahenpita...<a href="#"
                                    class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1">Read
                                    More</a></p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="bg-white rounded-[20px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <div class="h-56 overflow-hidden">
                            <img src="assets/img/home/nlac.jpg" alt="Press release on private sector salary increase."
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                            <div
                                class="flex justify-between items-center mb-4 text-xs text-gray-500 font-inter font-medium">
                                <span>February 17, 2026</span>
                                <span>Media</span>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors">
                                Press release on private sector salary increase.
                            </h3>
                            <p class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">In accordance with
                                the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025,
                                the National Minimum Wage in the private sector,...<a href="#"
                                    class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1">Read
                                    More</a></p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div
                        class="bg-white rounded-[20px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <div class="h-56 overflow-hidden">
                            <img src="assets/img/home/minister.jpg"
                                alt="The Ministry of Labor also begins work in the new year."
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                            <div
                                class="flex justify-between items-center mb-4 text-xs text-gray-500 font-inter font-medium">
                                <span>February 15, 2026</span>
                                <span>Media</span>
                            </div>
                            <h3
                                class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors">
                                The Ministry of Labor also begins work in the new year.
                            </h3>
                            <p class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">The ceremony
                                organized to mark the commencement of the Ministry of Labor and its subordinate
                                institutions for the year 2026 was held this morning (01) at the Narahenpita...<a
                                    href="#"
                                    class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1">Read
                                    More</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div
                    class="border border-gray-100 rounded-3xl p-8 sticky top-32 bg-white shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                    <!-- Search -->
                    <div class="mb-10">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text"
                                class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-[13px] placeholder-gray-400 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors font-inter"
                                placeholder="Search">
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="mb-10">
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6">Recent Posts</h3>
                        <ul class="space-y-4">
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>38 New Labour Officers Receive Appointment Letters.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>The committee approved by the Cabinet to amend the labour laws is consulting
                                        the National Labour Advisory Council (NLAC).</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Press release on private sector salary increase.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>The Ministry of Labor also begins work in the new year.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Scholarships are awarded by the Shrama Vasana Fund</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>The Ministry of Labor also begins work in the new year.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Scholarships are awarded by the Shrama Vasana Fund</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>The Ministry of Labor also begins work in the new year.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Scholarships are awarded by the Shrama Vasana Fund</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6">Categories</h3>
                        <ul class="space-y-4">
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Media</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Notices</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>