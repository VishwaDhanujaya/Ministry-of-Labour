<?php 
$current_page = "manage-admins";
include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Manage Admins</h2>
            <button onclick="document.getElementById('new-admin').scrollIntoView({behavior: 'smooth'})" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Admin
            </button>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative max-w-md w-full">
                <input type="text" placeholder="Search by name, role, or email..." class="js-table-search w-full pl-10 pr-4 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <div class="flex gap-4">
                <div class="relative w-40">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Roles</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <button class="js-reset-filter px-4 py-2.5 bg-white border border-red-200 rounded-md text-[13px] font-medium text-red-500 flex items-center hover:bg-red-50 transition-colors">
                    Reset
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="js-filterable-table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F9FAFB] border-b border-gray-100">
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Full Name</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Access Level</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Date Added</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-[#320000] text-white flex items-center justify-center font-bold text-xs mr-3">AS</div>
                                    <p class="text-[13px] font-medium text-gray-900">A. Silva</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#13273F] text-white">Super Admin</span>
                            </td>
                            <td class="py-4 px-6 text-[13px] text-gray-600">a.silva@labourmin.gov.lk</td>
                            <td class="py-4 px-6 text-[13px] text-gray-600">Full Access</td>
                            <td class="py-4 px-6 text-[13px] text-gray-600">Mar 01, 2026</td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-800 text-white flex items-center justify-center font-bold text-xs mr-3">NP</div>
                                    <p class="text-[13px] font-medium text-gray-900">N. Perera</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-gray-200 text-gray-800">Admin</span>
                            </td>
                            <td class="py-4 px-6 text-[13px] text-gray-600">n.perera@labourmin.gov.lk</td>
                            <td class="py-4 px-6 text-[13px] text-gray-600">Edit News Page</td>
                            <td class="py-4 px-6 text-[13px] text-gray-600">Mar 03, 2026</td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button class="js-delete-row p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-[13px] text-gray-500">Showing 1 to 2 of 2 entries</p>
                <div class="flex gap-1">
                    <button class="px-3 py-1.5 border border-gray-200 rounded text-[13px] text-gray-500 hover:bg-gray-50" disabled>Prev</button>
                    <button class="px-3 py-1.5 bg-[#4E0000] text-white rounded text-[13px]">1</button>
                    <button class="px-3 py-1.5 border border-gray-200 rounded text-[13px] text-gray-500 hover:bg-gray-50" disabled>Next</button>
                </div>
            </div>
        </div>

        <!-- Add New Admin Section -->
        <div id="new-admin" class="bg-white p-6 md:p-8 rounded-xl shadow-sm border border-gray-100 max-w-5xl">
            <h3 class="text-2xl font-bold font-montserrat text-gray-900 mb-6">Add New Admin</h3>
            
            <form action="#" method="POST" class="js-validate-form js-reset-on-success space-y-6">
                <!-- Row 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-800 mb-2">Full Name</label>
                        <input type="text" required placeholder="Namal Perera" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-800 mb-2">Role</label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                            <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-800 mb-2">Email</label>
                        <input type="email" required placeholder="admin@labourmin.gov.lk" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-800 mb-2">Password</label>
                        <input type="password" required placeholder="Minimum 06 characters" class="js-pwd w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-800 mb-2">Confirm Password</label>
                        <input type="password" required placeholder="Add password for confirm" class="js-pwd-confirm w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-800 mb-2">Website Access</label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                <option value="edit_news">Edit News Page</option>
                                <option value="full_access">Full Access</option>
                                <option value="view_only">View Only</option>
                            </select>
                            <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors">
                        Save Admin
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
