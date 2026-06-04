<?php $current_page = basename($_SERVER['PHP_SELF'], ".php"); ?>
<aside class="w-64 bg-[#4E0000] text-white flex flex-col h-full shrink-0 z-20">
    <!-- Logo Area -->
    <div class="h-20 flex items-center px-6 shrink-0 pt-4">
        <img src="../assets/img/logo.png" alt="Ministry of Labour" class="h-12 w-auto object-contain">
    </div>

    <!-- Navigation -->
    <div class="flex-1 py-8 custom-scrollbar">
        <!-- Group: MAIN -->
        <div class="mb-8">
            <h3 class="px-8 text-[11px] font-medium text-white/60 tracking-wider mb-3">MAIN</h3>
            <ul>
                <li>
                    <a href="index.php" class="flex items-center px-8 py-3 <?= ($current_page == 'index' || $current_page == '') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
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
                    <a href="news.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'news') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <span>News & Events</span>
                    </a>
                </li>
                <li>
                    <a href="upload-news.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'upload-news') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <span>Upload News</span>
                    </a>
                </li>
                <li>
                    <a href="manage-gallery.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'manage-gallery') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <span>Manage Gallery</span>
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
                        <span>Settings</span>
                    </a>
                </li>
                <?php if (isSuperAdmin()): ?>
                <li>
                    <a href="manage-admins.php" class="flex items-center px-8 py-2.5 <?= ($current_page == 'manage-admins') ? 'bg-white text-[#4E0000]' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-colors">
                        <span>Manage Admins</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="mt-auto px-6 py-4 border-t border-white/10 space-y-2">
            <a href="../index.php" class="flex items-center px-4 py-2.5 text-white/90 hover:bg-white/5 hover:text-white rounded-md text-[13px] font-medium transition-colors">
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
            <div class="w-10 h-10 rounded-lg bg-[#320000] text-white flex items-center justify-center font-bold text-sm shrink-0">
                AS
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-semibold text-white truncate">A. Silva</p>
                <p class="text-[11px] text-white/60 truncate mt-0.5">Super Admin</p>
            </div>
        </div>
    </div>
</aside>
