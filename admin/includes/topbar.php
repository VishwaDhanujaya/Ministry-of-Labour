<header class="h-24 bg-[#4E0000]/10 flex items-center justify-between px-10 shrink-0">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Admin Dashboard</h1>
        <p class="text-[13px] text-gray-600 mt-1 font-medium">Monday, Mar 09, 2026</p>
    </div>
    
    <div class="flex items-center space-x-5">
        <a href="../index.php" target="_blank" class="bg-[#4E0000] text-white px-6 py-2 rounded-md font-semibold text-[13px] hover:bg-[#320000] transition-colors shadow-sm">
            Visit Site
        </a>
        
        <div class="relative">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" placeholder="Search" class="pl-9 pr-4 py-2 border border-[#4E0000] rounded-md bg-white focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] w-56 text-[#4E0000] placeholder-[#4E0000] font-medium">
        </div>
        
        <a href="settings.php" class="w-10 h-10 rounded-md border border-[#4E0000] flex items-center justify-center text-[#4E0000] hover:bg-gray-50 hover:shadow-sm transition-all bg-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </a>

        <div class="flex items-center ml-2 border-l border-gray-300 pl-6 relative group cursor-pointer">
            <?php $currentUser = getLoggedInAdmin(); ?>
            <div class="w-10 h-10 rounded bg-[#4E0000] text-white flex items-center justify-center font-bold text-sm shrink-0">
                <?= htmlspecialchars(getInitials($currentUser['name'] ?? 'Admin')) ?>
            </div>
            <div class="ml-3 hidden md:block">
                <p class="text-sm font-semibold text-gray-900 leading-tight"><?= htmlspecialchars($currentUser['name'] ?? 'Admin') ?></p>
                <p class="text-[11px] text-gray-500 font-medium capitalize"><?= htmlspecialchars(str_replace('_', ' ', $currentUser['role'] ?? 'Admin')) ?></p>
            </div>
            
            <!-- Dropdown -->
            <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <a href="logout.php" class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50 transition-colors font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            </div>
        </div>
    </div>
</header>
