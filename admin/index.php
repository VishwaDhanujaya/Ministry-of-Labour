<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <h2 class="text-3xl font-bold font-montserrat text-gray-900 mb-8">Overview</h2>

        <!-- 4 Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card 1 -->
            <div class="bg-[#F8F9FA] p-6 rounded-lg border border-gray-100 shadow-sm">
                <p class="text-[13px] font-medium text-gray-700 mb-3">Total News Articles</p>
                <p class="text-3xl font-bold text-gray-900 font-montserrat mb-4">47</p>
                <div class="flex items-center text-[11px] font-medium text-teal-600">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span>3 this month</span>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-[#F8F9FA] p-6 rounded-lg border border-gray-100 shadow-sm">
                <p class="text-[13px] font-medium text-gray-700 mb-3">Bungalow Bookings</p>
                <p class="text-3xl font-bold text-gray-900 font-montserrat mb-4">12</p>
                <div class="flex items-center text-[11px] font-medium text-[#6b1e1e]">
                    <span>3 pending review</span>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-[#F8F9FA] p-6 rounded-lg border border-gray-100 shadow-sm">
                <p class="text-[13px] font-medium text-gray-700 mb-3">Complaints Received</p>
                <p class="text-3xl font-bold text-gray-900 font-montserrat mb-4">28</p>
                <div class="flex items-center text-[11px] font-medium text-teal-600">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    <span>5 from last month</span>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="bg-[#F8F9FA] p-6 rounded-lg border border-gray-100 shadow-sm">
                <p class="text-[13px] font-medium text-gray-700 mb-3">Published Notices</p>
                <p class="text-3xl font-bold text-gray-900 font-montserrat mb-4">9</p>
                <div class="flex items-center text-[11px] font-medium text-teal-600">
                    <span>2 active this week</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent News Articles (Col 2) -->
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-bold font-montserrat text-gray-900">Recent News Articles</h3>
                    <a href="news.php" class="px-5 py-2 border border-[#4E0000] rounded-md text-[13px] font-bold text-[#4E0000] hover:bg-[#4E0000] hover:text-white transition-colors">View All</a>
                </div>
                
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#13273F] text-white">
                                <th class="py-4 px-6 font-medium text-[15px]">Title</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Category</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Date</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Status</th>
                                <th class="py-4 px-6 font-medium text-[15px]"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-[13px]">
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-5 px-6 font-medium text-gray-900">38 New Labour Officers Receive Appointment Letters</td>
                                <td class="py-5 px-6 text-gray-800">Media</td>
                                <td class="py-5 px-6 text-gray-800">Feb 24, 2026</td>
                                <td class="py-5 px-6">
                                    <span class="px-3 py-1 rounded bg-[#D1F1E8] text-[#0A6C5B] text-[11px] font-bold">Published</span>
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <button class="text-gray-500 hover:text-[#13273F] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-5 px-6 font-medium text-gray-900">Cabinet Committee Consults NLAC on Labour Law Reforms</td>
                                <td class="py-5 px-6 text-gray-800">Notices</td>
                                <td class="py-5 px-6 text-gray-800">Feb 2, 2026</td>
                                <td class="py-5 px-6">
                                    <span class="px-3 py-1 rounded bg-[#D1F1E8] text-[#0A6C5B] text-[11px] font-bold">Published</span>
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <button class="text-gray-500 hover:text-[#13273F] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-5 px-6 font-medium text-gray-900">Media Release on Private Sector Salary Increases</td>
                                <td class="py-5 px-6 text-gray-800">Media</td>
                                <td class="py-5 px-6 text-gray-800">Jan 21, 2026</td>
                                <td class="py-5 px-6">
                                    <span class="px-3 py-1 rounded bg-[#D1F1E8] text-[#0A6C5B] text-[11px] font-bold">Published</span>
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <button class="text-gray-500 hover:text-[#13273F] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-5 px-6 font-medium text-gray-900">New EPF Contribution Guidelines 2026</td>
                                <td class="py-5 px-6 text-gray-800">Policy</td>
                                <td class="py-5 px-6 text-gray-800">Jan 10, 2026</td>
                                <td class="py-5 px-6">
                                    <span class="px-3 py-1 rounded bg-[#EED6D6] text-[#611A1A] text-[11px] font-bold">Draft</span>
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <button class="text-gray-500 hover:text-[#13273F] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-5 px-6 font-medium text-gray-900">New EPF Contribution Guidelines 2026</td>
                                <td class="py-5 px-6 text-gray-800">Policy</td>
                                <td class="py-5 px-6 text-gray-800">Jan 09, 2026</td>
                                <td class="py-5 px-6">
                                    <span class="px-3 py-1 rounded bg-[#EED6D6] text-[#611A1A] text-[11px] font-bold">Draft</span>
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <button class="text-gray-500 hover:text-[#13273F] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pending Bookings (Col 1) -->
            <div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Pending Bookings</h3>
                    </div>
                    <div class="divide-y divide-gray-100 flex-1 px-5 pt-3">
                        <!-- Booking Item 1 -->
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-10 h-10 rounded bg-[#4E0000]/10 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-[#4E0000]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l9 6.75v11.25a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 21V9.75L12 3zm-3 15h6v-6H9v6z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-[13px]">Ampara Bungalow</h4>
                                <p class="text-[11px] text-gray-500 mt-0.5">Mr. S. Perera · Apr 5–8, 2026</p>
                                <div class="mt-2">
                                    <span class="px-3 py-1 rounded bg-[#FDECB1] text-[#A67C00] text-[10px] font-bold">Pending</span>
                                </div>
                            </div>
                        </div>
                        <!-- Booking Item 2 -->
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-10 h-10 rounded bg-[#4E0000]/10 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-[#4E0000]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l9 6.75v11.25a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 21V9.75L12 3zm-3 15h6v-6H9v6z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-[13px]">Ampara Bungalow</h4>
                                <p class="text-[11px] text-gray-500 mt-0.5">Ms. R. Fernando · Apr 12–14, 2026</p>
                                <div class="mt-2">
                                    <span class="px-3 py-1 rounded bg-[#FDECB1] text-[#A67C00] text-[10px] font-bold">Pending</span>
                                </div>
                            </div>
                        </div>
                        <!-- Booking Item 3 -->
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-10 h-10 rounded bg-[#4E0000]/10 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-[#4E0000]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l9 6.75v11.25a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 21V9.75L12 3zm-3 15h6v-6H9v6z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-[13px]">Ampara Bungalow</h4>
                                <p class="text-[11px] text-gray-500 mt-0.5">Dr. A. Jayasinghe · May 1–3, 2026</p>
                                <div class="mt-2">
                                    <span class="px-3 py-1 rounded bg-gray-200 text-gray-600 text-[10px] font-bold">Confirmed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 mt-2">
                        <a href="bungalow-bookings.php" class="block text-center w-full py-2.5 bg-transparent border border-[#4E0000] text-[#4E0000] rounded-md text-[13px] font-bold hover:bg-[#4E0000] hover:text-white transition-colors">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
