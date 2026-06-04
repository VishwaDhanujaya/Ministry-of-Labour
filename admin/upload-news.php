<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Upload News</h2>
            <button class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Article
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Form (Col 2) -->
            <div class="lg:col-span-2">
                <form action="#" method="POST" class="js-validate-form js-reset-on-success space-y-6">
                    
                    <!-- Article Title -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Article Title <span class="text-red-500">*</span></label>
                        <input type="text" required placeholder="Enter article headline" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                    </div>

                    <!-- Category & Publish Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Category <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select required class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="">All Categories</option>
                                    <option value="media">Media</option>
                                    <option value="notices">Notices</option>
                                    <option value="policy">Policy</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Publish Date</label>
                            <div class="relative">
                                <input type="text" placeholder="MM/DD/YYYY" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 placeholder-gray-400">
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Summary / Excerpt -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Summary / Excerpt <span class="text-red-500">*</span></label>
                        <textarea required placeholder="Brief description (shown on homepage)" rows="3" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400 resize-none"></textarea>
                    </div>

                    <!-- Full Article Body -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Full Article Body <span class="text-red-500">*</span></label>
                        <textarea required placeholder="Full article content" rows="8" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400 resize-none"></textarea>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Cover Image <span class="text-red-500">*</span></label>
                        <div class="js-dropzone w-full border-2 border-dashed border-[#E5D5D5] bg-[#F9FAFB]/50 rounded-lg p-10 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-[#F9FAFB] transition-colors">
                            <p class="text-[13px] text-gray-500 font-medium mb-1">Click to upload or drag & drop</p>
                            <p class="text-[11px] text-gray-400">PNG, JPG, JPEG, WEBP</p>
                            <p class="text-[11px] text-gray-400">Max 5MB</p>
                        </div>
                    </div>

                    <!-- Tags & Language -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Tags (comma separated) <span class="text-red-500">*</span></label>
                            <input type="text" required placeholder="Labour, EPF,..." class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Language <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select required class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="english">English</option>
                                    <option value="sinhala">Sinhala</option>
                                    <option value="tamil">Tamil</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <button type="button" class="js-save-draft px-6 py-2.5 border border-[#4E0000] text-[#4E0000] rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors bg-white">
                            Save as Draft
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors">
                            Publish Article
                        </button>
                    </div>

                </form>
            </div>

            <!-- Right Column: Sidebar Widgets (Col 1) -->
            <div class="space-y-8">
                <!-- Publish Options Widget -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Publish Options</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Visibility -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Visibility <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                    <option value="hidden">Hidden</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Featured Article -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Featured Article?</label>
                            <div class="relative">
                                <select class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Special Notice -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Special Notice?</label>
                            <div class="relative">
                                <select class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Drafts Widget -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Recent Drafts</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col gap-1.5 cursor-pointer group">
                            <h4 class="font-semibold text-gray-900 text-[13px] group-hover:text-[#4E0000] transition-colors leading-snug">New EPF Contribution Guidelines 2026</h4>
                            <p class="text-[11px] text-gray-500">Last edited Jan 10, 2026</p>
                            <div class="mt-1">
                                <span class="px-3 py-1 rounded bg-[#EED6D6] text-[#611A1A] text-[11px] font-bold">Draft</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
