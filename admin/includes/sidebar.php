<?php $current_page = basename($_SERVER['PHP_SELF'], ".php"); ?>
<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

<aside id="admin-sidebar" class="w-64 bg-[#4E0000] text-white flex-col h-full shrink-0 z-50 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-200 ease-in-out flex">
    <!-- Logo Area -->
    <div class="h-20 flex items-center px-6 shrink-0 pt-4">
        <img loading="lazy" src="../assets/img/logo.png" alt="Ministry of Labour" class="h-12 w-auto object-contain">
    </div>

    <!-- Navigation -->
    <div class="flex-1 py-6 overflow-y-auto custom-scrollbar flex flex-col">
        <!-- Group: MAIN -->
        <div class="mb-8">
            <h3 class="px-8 text-[11px] font-medium text-white/60 tracking-wider mb-3">MAIN</h3>
            <ul>
                <li>
                    <a href="dashboard" class="flex items-center px-8 py-3 <?= ($current_page == 'index' || $current_page == 'dashboard' || $current_page == '') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Group: CONTENT -->
        <div class="mb-8">
            <h3 class="px-8 text-[11px] font-medium text-white/60 tracking-wider mb-3">CONTENT</h3>
            <ul>
                <li>
                    <a href="articles.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'articles' || $current_page == 'new-article') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2"></path></svg>
                        <span>Articles</span>
                    </a>
                </li>
                <li>
                    <a href="gallery.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'gallery' || $current_page == 'new-gallery') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Gallery Albums</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Group: BOOKINGS -->
        <div class="mb-8">
            <h3 class="px-8 text-[11px] font-medium text-white/60 tracking-wider mb-3">BOOKINGS</h3>
            <ul>
                <li>
                    <a href="bungalow-bookings.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'bungalow-bookings') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Bungalow Bookings</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Group: SYSTEM -->
        <div class="mb-8">
            <h3 class="px-8 text-[11px] font-medium text-white/60 tracking-wider mb-3">SYSTEM</h3>
            <ul>
                <li>
                    <a href="settings.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'settings') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Settings</span>
                    </a>
                </li>
                <?php if (isSuperAdmin()): ?>
                <li>
                    <a href="manage-admins.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'manage-admins') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Manage Admins</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="mt-auto px-6 py-4 border-t border-white/10 space-y-2">
            <a href="../home" class="flex items-center px-4 py-2.5 text-white/90 hover:bg-white/5 hover:text-white rounded-md text-[13px] font-medium transition-colors">
                <svg class="w-5 h-5 mr-3 text-[#B08920]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Visit Site
            </a>
            <a href="logout.php" class="flex items-center px-4 py-2.5 text-white/90 hover:bg-white/5 hover:text-white rounded-md text-[13px] font-medium transition-colors">
                <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Log Out
            </a>
        </div>
    </div>

    <!-- User Profile Bottom -->
    <div class="p-6 shrink-0 border-t border-white/5">
        <div class="flex items-center bg-black/20 rounded-xl p-3 cursor-pointer hover:bg-black/30 transition-colors">
            <?php $sidebarUser = getLoggedInAdmin(); ?>
            <div class="w-10 h-10 rounded-lg bg-[#320000] text-white flex items-center justify-center font-bold text-sm shrink-0">
                <?= htmlspecialchars(getInitials($sidebarUser['name'] ?? 'Admin')) ?>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-semibold text-white truncate"><?= htmlspecialchars($sidebarUser['name'] ?? 'Admin') ?></p>
                <p class="text-[11px] text-white/60 truncate mt-0.5 capitalize"><?= htmlspecialchars(str_replace('_', ' ', $sidebarUser['role'] ?? 'Admin')) ?></p>
            </div>
        </div>
    </div>
</aside>
