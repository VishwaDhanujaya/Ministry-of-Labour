<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Bungalow Bookings</h2>
            <button class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Booking
            </button>
        </div>

        <!-- Filter Bar -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="relative flex-1 max-w-2xl">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Search by name or bungalow..." class="w-full pl-10 pr-4 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-800 placeholder-gray-400">
            </div>
            
            <div class="flex gap-4">
                <div class="relative w-40">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Bungalow</option>
                        <option value="Ampara">Ampara Bungalow</option>
                        <option value="Kandy">Kandy Bungalow</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <div class="relative w-36">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <button class="js-reset-filter px-4 py-2.5 bg-white border border-red-200 rounded-md text-[13px] font-medium text-red-500 flex items-center hover:bg-red-50 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Date Scroller -->
        <div class="flex items-center gap-3 mb-8 overflow-x-auto pb-2 custom-scrollbar">
            <!-- Active Date -->
            <div class="js-date-block flex flex-col items-center justify-center w-16 h-20 bg-[#13273F] text-white rounded-lg border border-[#13273F] shrink-0 cursor-pointer shadow-md">
                <span class="text-[11px] font-medium mb-1">Fri</span>
                <span class="text-xl font-bold font-montserrat leading-none mb-1.5">20</span>
                <div class="w-1.5 h-1.5 rounded-full bg-[#FDECB1]"></div>
            </div>
            
            <!-- Inactive Dates -->
            <?php
            $dates = [
                ['day' => 'Sat', 'num' => '21'],
                ['day' => 'Sun', 'num' => '22'],
                ['day' => 'Mon', 'num' => '23'],
                ['day' => 'Tue', 'num' => '24'],
                ['day' => 'Wed', 'num' => '25'],
                ['day' => 'Thu', 'num' => '26'],
                ['day' => 'Fri', 'num' => '27'],
                ['day' => 'Sat', 'num' => '28'],
                ['day' => 'Sun', 'num' => '29'],
                ['day' => 'Mon', 'num' => '30'],
                ['day' => 'Tue', 'num' => '31'],
                ['day' => 'Wed', 'num' => '01'],
                ['day' => 'Thu', 'num' => '02'],
                ['day' => 'Fri', 'num' => '03'],
            ];
            foreach ($dates as $date): ?>
            <div class="js-date-block flex flex-col items-center justify-center w-16 h-20 bg-[#F9FAFB] text-gray-800 rounded-lg border border-gray-200 shrink-0 cursor-pointer hover:bg-gray-50 transition-colors">
                <span class="text-[11px] font-medium text-gray-500 mb-1"><?= $date['day'] ?></span>
                <span class="text-xl font-bold font-montserrat leading-none mb-1.5"><?= $date['num'] ?></span>
                <div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                <p class="text-[12px] font-medium text-gray-600">Total Bookings</p>
                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2">12</p>
            </div>
            <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                <p class="text-[12px] font-medium text-[#A67C00]">Pending Review</p>
                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2">03</p>
            </div>
            <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                <p class="text-[12px] font-medium text-[#0A6C5B]">Confirmed</p>
                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2">07</p>
            </div>
            <div class="bg-[#F9FAFB] rounded-xl border border-gray-100 p-6 shadow-sm">
                <p class="text-[12px] font-medium text-red-600">Cancelled</p>
                <p class="text-3xl font-bold font-montserrat text-gray-900 mt-2">02</p>
            </div>
        </div>

        <!-- Bookings Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Booking Card 1 (Pending) -->
            <div class="js-booking-card rounded-xl border border-gray-100 overflow-hidden shadow-sm bg-white flex flex-col">
                <div class="bg-[#13273F] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold text-[14px]">Ampara Bungalow</h3>
                    <span class="js-status-pill px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#A67C00]/20 text-[#FDECB1]">Pending</span>
                </div>
                <div class="p-6 space-y-3.5 flex-1">
                    <div class="flex items-start text-[12px] text-gray-700">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="font-bold text-gray-900">Mr. S. Perera</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>s.perera@gov.lk</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>+94 77 123 4567</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Apr 5 – Apr 8, 2026 (3 nights)</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>4 guests</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Official visit — district labour inspectio</span>
                    </div>
                </div>
                <div class="bg-[#E5E7EB] p-4 flex gap-2">
                    <button class="flex-1 py-2 border border-gray-400 rounded text-gray-800 font-bold text-[12px] hover:bg-gray-200 transition-colors bg-transparent">View</button>
                    <button class="js-booking-reject flex-1 py-2 bg-[#D10000] text-white rounded font-bold text-[12px] hover:bg-[#a30000] transition-colors">Reject</button>
                    <button class="js-booking-approve flex-1 py-2 bg-[#0A6C5B] text-white rounded font-bold text-[12px] hover:bg-[#075043] transition-colors">Approve</button>
                </div>
            </div>

            <!-- Booking Card 2 (Confirmed) -->
            <div class="js-booking-card rounded-xl border border-gray-100 overflow-hidden shadow-sm bg-white flex flex-col">
                <div class="bg-[#13273F] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold text-[14px]">Ampara Bungalow</h3>
                    <span class="js-status-pill px-2.5 py-0.5 rounded text-[10px] font-bold bg-[#0A6C5B]/30 text-[#D1F1E8]">Confirmed</span>
                </div>
                <div class="p-6 space-y-3.5 flex-1">
                    <div class="flex items-start text-[12px] text-gray-700">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="font-bold text-gray-900">Ms. R. Fernando</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>r.fernando@gov.lk</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>+94 71 987 6543</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Apr 12 – Apr 14, 2026 (2 nights)</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>2 guests</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>NLAC regional meeting attendance</span>
                    </div>
                </div>
                <div class="bg-[#E5E7EB] p-4 flex gap-2">
                    <button class="flex-1 py-2 border border-gray-400 rounded text-gray-800 font-bold text-[12px] hover:bg-gray-200 transition-colors bg-transparent">View</button>
                    <button class="js-booking-reject flex-1 py-2 bg-[#D10000] text-white rounded font-bold text-[12px] hover:bg-[#a30000] transition-colors">Reject</button>
                    <button class="js-booking-approve flex-1 py-2 bg-[#0A6C5B] text-white rounded font-bold text-[12px] hover:bg-[#075043] transition-colors">Approve</button>
                </div>
            </div>

            <!-- Booking Card 3 (Cancelled) -->
            <div class="js-booking-card rounded-xl border border-gray-100 overflow-hidden shadow-sm bg-white flex flex-col">
                <div class="bg-[#13273F] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold text-[14px]">Ampara Bungalow</h3>
                    <span class="js-status-pill px-2.5 py-0.5 rounded text-[10px] font-bold bg-red-900/40 text-red-300">Cancelled</span>
                </div>
                <div class="p-6 space-y-3.5 flex-1">
                    <div class="flex items-start text-[12px] text-gray-700">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="font-bold text-gray-900">Mr. K. Rajapaksa</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>k.rajapaksa@labourdept.gov.lk</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>+94 76 555 0011</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Apr 20 – Apr 21, 2026 (1 night)</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>1 guest</span>
                    </div>
                    <div class="flex items-start text-[12px] text-gray-500">
                        <svg class="w-4 h-4 text-[#4E0000] shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Field inspection — eastern province</span>
                    </div>
                </div>
                <div class="bg-[#E5E7EB] p-4 flex gap-2">
                    <button class="flex-1 py-2 border border-gray-400 rounded text-gray-800 font-bold text-[12px] hover:bg-gray-200 transition-colors bg-transparent">View</button>
                    <button class="flex-1 py-2 bg-[#D10000] text-white rounded font-bold text-[12px] hover:bg-[#a30000] transition-colors">Reject</button>
                    <button class="flex-1 py-2 bg-[#0A6C5B] text-white rounded font-bold text-[12px] hover:bg-[#075043] transition-colors">Approve</button>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
