<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">News & Events</h2>
            <a href="upload-news.php" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Article
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1 max-w-2xl">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Search by article..." class="js-table-search w-full pl-10 pr-4 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-800 placeholder-gray-400">
            </div>
            
            <div class="flex gap-4">
                <div class="relative w-40">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Categories</option>
                        <option value="Media">Media</option>
                        <option value="Notices">Notices</option>
                        <option value="Amendment">Amendment</option>
                        <option value="Trade Unions">Trade Unions</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <div class="relative w-36">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Status</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <button class="js-reset-filter px-4 py-2.5 bg-white border border-red-200 rounded-md text-[13px] font-medium text-red-500 flex items-center hover:bg-red-50 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="js-filterable-table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#13273F] text-white">
                        <th class="py-4 px-6 font-medium text-[15px]">Title</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Category</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Author</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Date</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Status</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-[13px]">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-6 font-medium text-gray-900 w-1/3">38 New Labour Officers Receive Appointment Letters</td>
                        <td class="py-5 px-6 text-gray-800">Media</td>
                        <td class="py-5 px-6 text-gray-800">A. Silva</td>
                        <td class="py-5 px-6 text-gray-800">Feb 24, 2026</td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 rounded bg-[#D1F1E8] text-[#0A6C5B] text-[11px] font-bold">Published</span>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center space-x-3">
                                <button class="text-gray-500 hover:text-gray-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button class="js-edit-row px-3 py-1.5 border border-gray-200 rounded text-gray-600 text-[11px] font-bold hover:bg-gray-50 transition-colors">Edit</button>
                                <button class="js-delete-row px-3 py-1.5 border border-red-200 rounded text-red-500 text-[11px] font-bold hover:bg-red-50 transition-colors">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-6 font-medium text-gray-900 w-1/3">Cabinet Committee Consults NLAC on Labour Law Reforms</td>
                        <td class="py-5 px-6 text-gray-800">Notices</td>
                        <td class="py-5 px-6 text-gray-800">A. Silva</td>
                        <td class="py-5 px-6 text-gray-800">Feb 2, 2026</td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 rounded bg-[#D1F1E8] text-[#0A6C5B] text-[11px] font-bold">Published</span>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center space-x-3">
                                <button class="text-gray-500 hover:text-gray-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button class="js-edit-row px-3 py-1.5 border border-gray-200 rounded text-gray-600 text-[11px] font-bold hover:bg-gray-50 transition-colors">Edit</button>
                                <button class="js-delete-row px-3 py-1.5 border border-red-200 rounded text-red-500 text-[11px] font-bold hover:bg-red-50 transition-colors">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-6 font-medium text-gray-900 w-1/3">Media Release on Private Sector Salary Increases</td>
                        <td class="py-5 px-6 text-gray-800">Media</td>
                        <td class="py-5 px-6 text-gray-800">S. Wickramasinghe</td>
                        <td class="py-5 px-6 text-gray-800">Jan 21, 2026</td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 rounded bg-[#D1F1E8] text-[#0A6C5B] text-[11px] font-bold">Published</span>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center space-x-3">
                                <button class="text-gray-500 hover:text-gray-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button class="js-edit-row px-3 py-1.5 border border-gray-200 rounded text-gray-600 text-[11px] font-bold hover:bg-gray-50 transition-colors">Edit</button>
                                <button class="js-delete-row px-3 py-1.5 border border-red-200 rounded text-red-500 text-[11px] font-bold hover:bg-red-50 transition-colors">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-6 font-medium text-gray-900 w-1/3">New EPF Contribution Guidelines 2026</td>
                        <td class="py-5 px-6 text-gray-800">Policy</td>
                        <td class="py-5 px-6 text-gray-800">A. Silva</td>
                        <td class="py-5 px-6 text-gray-800">Jan 10, 2026</td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 rounded bg-[#EED6D6] text-[#611A1A] text-[11px] font-bold">Draft</span>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center space-x-3">
                                <button class="text-gray-500 hover:text-gray-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 text-[11px] font-bold hover:bg-gray-50 transition-colors">Edit</button>
                                <button class="px-3 py-1.5 border border-red-200 rounded text-red-500 text-[11px] font-bold hover:bg-red-50 transition-colors">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-6 font-medium text-gray-900 w-1/3">New EPF Contribution Guidelines 2026</td>
                        <td class="py-5 px-6 text-gray-800">Policy</td>
                        <td class="py-5 px-6 text-gray-800">A. Karunaratne</td>
                        <td class="py-5 px-6 text-gray-800">Jan 09, 2026</td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 rounded bg-[#EED6D6] text-[#611A1A] text-[11px] font-bold">Draft</span>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center space-x-3">
                                <button class="text-gray-500 hover:text-gray-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 text-[11px] font-bold hover:bg-gray-50 transition-colors">Edit</button>
                                <button class="px-3 py-1.5 border border-red-200 rounded text-red-500 text-[11px] font-bold hover:bg-red-50 transition-colors">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
