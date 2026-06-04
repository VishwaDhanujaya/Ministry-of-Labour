<?php
// gallery-single.php
$page_title = 'Gallery';
$breadcrumbs = [
    ['label' => 'Gallery', 'url' => 'gallery']
];
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-[1400px]">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                <h2 class="text-3xl md:text-[38px] font-semibold font-montserrat text-[#2D2D43] mb-6 leading-tight">
                    38 New Labour Officers Receive Appointment Letters
                </h2>
                
                <div class="flex items-center gap-6 text-[13px] font-inter text-gray-500 font-medium mb-8 pb-4 border-b border-gray-200">
                    <span>Media</span>
                    <span>February 17, 2026</span>
                </div>

                <!-- Gallery Masonry Grid -->
                <div class="columns-1 md:columns-2 lg:columns-3 gap-4 space-y-4 mb-16">
                    <div class="break-inside-avoid">
                        <img src="assets/img/home/appointment-letters.jpg" class="w-full rounded-[20px] shadow-sm hover:shadow-md transition-shadow" alt="Gallery Image">
                    </div>
                    <div class="break-inside-avoid">
                        <img src="assets/img/gallery/gallery-2.webp" class="w-full rounded-[20px] shadow-sm hover:shadow-md transition-shadow" alt="Gallery Image">
                    </div>
                    <div class="break-inside-avoid">
                        <img src="assets/img/gallery/gallery-1.webp" class="w-full rounded-[20px] shadow-sm hover:shadow-md transition-shadow" alt="Gallery Image">
                    </div>
                    <div class="break-inside-avoid">
                        <img src="assets/img/home/nlac.jpg" class="w-full rounded-[20px] shadow-sm hover:shadow-md transition-shadow" alt="Gallery Image">
                    </div>
                    <div class="break-inside-avoid">
                        <img src="assets/img/gallery/gallery-4.webp" class="w-full rounded-[20px] shadow-sm hover:shadow-md transition-shadow" alt="Gallery Image">
                    </div>
                    <div class="break-inside-avoid">
                        <img src="assets/img/gallery/gallery-3.webp" class="w-full rounded-[20px] shadow-sm hover:shadow-md transition-shadow" alt="Gallery Image">
                    </div>
                </div>

                <!-- Pagination Links -->
                <div class="flex flex-col md:flex-row justify-between border-t border-gray-200 pt-8 gap-8">
                    <a href="#" class="group max-w-xs">
                        <div class="text-[15px] font-montserrat text-gray-800 font-semibold mb-2 group-hover:text-secondary transition-colors">&lt; Previous</div>
                        <p class="text-[13px] text-gray-500 font-inter line-clamp-2 leading-relaxed">The committee approved by the Cabinet to amend the labour laws is consulting the...</p>
                    </a>
                    <a href="#" class="group max-w-xs text-left md:text-right">
                        <div class="text-[15px] font-montserrat text-gray-800 font-semibold mb-2 group-hover:text-secondary transition-colors">Next &gt;</div>
                        <p class="text-[13px] text-gray-500 font-inter line-clamp-2 leading-relaxed">Press release on private sector salary increase...</p>
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="border border-gray-100 rounded-3xl p-8 sticky top-32 bg-white shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                    <!-- Search -->
                    <div class="mb-10">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-[13px] placeholder-gray-400 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors font-inter" placeholder="Search">
                        </div>
                    </div>
                    
                    <!-- Recent Gallery -->
                    <div class="mb-10">
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6">Recent Gallery</h3>
                        <ul class="space-y-4">
                            <li>
                                <a href="gallery-single" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span>38 New Labour Officers Receive Appointment Letters.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span>The committee approved by the Cabinet to amend the labour laws is consulting the National Labour Advisory Council (NLAC).</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span>Press release on private sector salary increase.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span>The Ministry of Labor also begins work in the new year.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span>Scholarships are awarded by the Shrama Vasana Fund</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span>The Ministry of Labor also begins work in the new year.</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
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
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
                                    <span>Media</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span> 
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
