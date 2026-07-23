<header class="h-20 md:h-24 bg-secondary/10 flex items-center justify-between px-4 md:px-10 shrink-0">
    <div class="flex items-center gap-3 md:gap-0">
        <button type="button" onclick="toggleSidebar()" class="md:hidden text-secondary p-1.5 hover:bg-secondary/10 rounded-md transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <div>
            <h1 class="text-lg sm:text-xl md:text-2xl font-semibold text-gray-900 tracking-tight">Admin Dashboard</h1>
            <p class="text-[11px] md:text-[13px] text-gray-600 mt-0.5 md:mt-1 font-medium"><?= date('l, M d, Y') ?></p>
        </div>
    </div>
    
    <div class="flex items-center space-x-3 md:space-x-5">
        <a href="../home" target="_blank" class="hidden sm:inline-flex bg-secondary text-white px-5 md:px-6 py-2 rounded-md font-semibold text-[12px] md:text-[13px] hover:bg-[#320000] transition-colors shadow-sm">
            Visit Site
        </a>
        
        
        <div class="flex items-center ml-1 md:ml-2 border-l border-gray-300 pl-4 md:pl-6 relative cursor-pointer" onclick="toggleUserDropdown(event)">
            <?php $currentUser = getLoggedInAdmin(); ?>
            <div class="w-8 h-8 md:w-10 md:h-10 rounded bg-secondary text-white flex items-center justify-center font-bold text-xs md:text-sm shrink-0">
                <?= htmlspecialchars(getInitials($currentUser['name'] ?? 'Admin')) ?>
            </div>
            <div class="ml-2 md:ml-3 hidden md:block">
                <p class="text-sm font-semibold text-gray-900 leading-tight"><?= htmlspecialchars($currentUser['name'] ?? 'Admin') ?></p>
                <p class="text-[11px] text-gray-500 font-medium capitalize"><?= htmlspecialchars(str_replace('_', ' ', $currentUser['role'] ?? 'Admin')) ?></p>
            </div>
            
            <!-- Dropdown -->
            <div id="user-dropdown-menu" class="absolute right-0 top-full mt-2 w-52 bg-white border border-gray-100 rounded-xl shadow-xl hidden z-50 overflow-hidden transform transition-all duration-200 origin-top-right opacity-0 scale-95" style="transition: opacity 200ms ease, transform 200ms ease;">
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                    <p class="text-[13px] font-semibold text-gray-900 truncate"><?= htmlspecialchars($currentUser['name'] ?? 'Admin') ?></p>
                    <p class="text-[11px] text-gray-500 font-medium capitalize mt-0.5"><?= htmlspecialchars(str_replace('_', ' ', $currentUser['role'] ?? 'Admin')) ?></p>
                </div>
                <?php if (hasPermission('manage_settings')): ?>
                <a href="settings" class="w-full text-left px-4 py-2.5 text-[13px] text-gray-700 hover:bg-gray-50 transition-colors font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Settings
                </a>
                <?php endif; ?>
                <div class="border-t border-gray-100"></div>
                <a href="logout" class="w-full text-left px-4 py-2.5 text-[13px] text-red-600 hover:bg-red-50 transition-colors font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            </div>
        </div>
    </div>
</header>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
}

function toggleUserDropdown(e) {
    e.stopPropagation();
    const dropdown = document.getElementById('user-dropdown-menu');
    if (!dropdown) return;
    
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
        // Trigger reflow then animate in
        void dropdown.offsetWidth;
        dropdown.classList.remove('opacity-0', 'scale-95');
        dropdown.classList.add('opacity-100', 'scale-100');
    } else {
        dropdown.classList.add('opacity-0', 'scale-95');
        dropdown.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => dropdown.classList.add('hidden'), 200);
    }
}

document.addEventListener('click', function() {
    const dropdown = document.getElementById('user-dropdown-menu');
    if (dropdown && !dropdown.classList.contains('hidden')) {
        dropdown.classList.add('opacity-0', 'scale-95');
        dropdown.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => dropdown.classList.add('hidden'), 200);
    }
});
</script>
