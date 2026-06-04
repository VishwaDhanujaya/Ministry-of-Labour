<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Settings</h2>
        </div>

        <div class="max-w-5xl">
            <!-- Account Settings Section -->
            <div class="mb-14">
                <h3 class="text-2xl font-bold font-montserrat text-gray-900 mb-6">Account Settings</h3>
                
                <form action="#" method="POST" class="js-validate-form space-y-6">
                    <!-- Row 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">Full Name</label>
                            <input type="text" required value="Ayesh Silva" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">Role</label>
                            <input type="text" value="Super Admin" readonly class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none text-[13px] text-gray-600">
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">Email</label>
                            <input type="email" required value="admin@labourmin.gov.lk" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">New Password</label>
                            <input type="password" placeholder="Leave blank to keep current" class="js-pwd w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">Confirm Password</label>
                            <input type="password" placeholder="Leave blank to keep current" class="js-pwd-confirm w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
