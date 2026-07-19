<?php $current_page = basename($_SERVER['PHP_SELF'], ".php"); ?>
<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

<aside id="admin-sidebar" class="w-64 bg-secondary text-white flex-col h-full shrink-0 z-50 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-200 ease-in-out flex">
    <!-- Logo Area -->
    <div class="h-20 flex items-center px-6 shrink-0 pt-4">
        <?php
        $logo_path = dirname(dirname(__DIR__)) . '/assets/img/logo.png';
        $logo_version = file_exists($logo_path) ? filemtime($logo_path) : time();
        ?>
        <img loading="lazy" src="<?= $base_url ?? '../' ?>assets/img/logo.png?v=<?= $logo_version ?>" alt="Ministry of Labour" class="h-12 w-auto object-contain">
    </div>

    <!-- Navigation -->
    <div id="sidebar-nav" class="flex-1 py-6 overflow-y-auto custom-scrollbar flex flex-col opacity-0 transition-opacity duration-150">
        <!-- Group: MAIN -->
        <div class="mb-6">
            <h3 class="px-6 text-[10px] font-bold text-white/50 tracking-wider mb-2 uppercase">MAIN</h3>
            <ul class="space-y-1 px-3">
                <li>
                    <a href="dashboard" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'index' || $current_page == 'dashboard' || $current_page == '') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Group: NEWS & UPDATES -->
        <div class="mb-6">
            <h3 class="px-6 text-[10px] font-bold text-white/50 tracking-wider mb-2 uppercase">NEWS & UPDATES</h3>
            <ul class="space-y-1 px-3">
                <?php if (hasPermission("manage_news")): ?>
                <li>
                    <a href="news" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'news' || $current_page == 'news-add') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2"></path></svg>
                        <span>News</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_notices")): ?>
                <li>
                    <a href="manage-special-notices" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-special-notices' || $current_page == 'new-special-notice') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span>Special Notices</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_iau")): ?>
                <li>
                    <a href="manage-iau-updates" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-iau-updates' || $current_page == 'new-iau-update') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>IAU Updates</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Group: PUBLICATIONS -->
        <div class="mb-6">
            <h3 class="px-6 text-[10px] font-bold text-white/50 tracking-wider mb-2 uppercase">PUBLICATIONS</h3>
            <ul class="space-y-1 px-3">
                <?php if (hasPermission("manage_local_pubs")): ?>
                <li>
                    <a href="manage-learning-platforms-local" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-learning-platforms-local' || $current_page == 'new-learning-platform-local') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span>Local Publications</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_foreign_pubs")): ?>
                <li>
                    <a href="manage-learning-platforms-foreign" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-learning-platforms-foreign' || $current_page == 'new-learning-platform-foreign') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <span>Foreign Publications</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_action_plans")): ?>
                <li>
                    <a href="manage-action-plans" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-action-plans' || $current_page == 'new-action-plan') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span>Action Plans</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_rti")): ?>
                <li>
                    <a href="manage-rti-reports" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-rti-reports' || $current_page == 'new-rti-report') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>RTI Reports</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Group: MANAGEMENT -->
        <div class="mb-6">
            <h3 class="px-6 text-[10px] font-bold text-white/50 tracking-wider mb-2 uppercase">MANAGEMENT</h3>
            <ul class="space-y-1 px-3">
                <?php if (hasPermission("manage_vacancies")): ?>
                <li>
                    <a href="manage-vacancies" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-vacancies' || $current_page == 'new-vacancy') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Vacancies</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_procurements")): ?>
                <li>
                    <a href="manage-procurements" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-procurements' || $current_page == 'new-procurement') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                        <span>Procurements</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_acts")): ?>
                <li>
                    <a href="manage-acts" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-acts' || $current_page == 'new-act') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Acts & Amendments</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Group: SERVICES & DIRECTORY -->
        <div class="mb-6">
            <h3 class="px-6 text-[10px] font-bold text-white/50 tracking-wider mb-2 uppercase">SERVICES & DIRECTORY</h3>
            <ul class="space-y-1 px-3">
                <?php if (hasPermission("manage_officials")): ?>
                <li>
                    <a href="officials" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'officials') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Officials & Contacts</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (hasPermission("manage_bookings")): ?>
                <li>
                    <a href="bungalow-bookings" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'bungalow-bookings') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Bungalow Bookings</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Group: SYSTEM -->
        <div class="mb-6">
            <h3 class="px-6 text-[10px] font-bold text-white/50 tracking-wider mb-2 uppercase">SYSTEM</h3>
            <ul class="space-y-1 px-3">
                <li>
                    <a href="settings" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'settings') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Settings</span>
                    </a>
                </li>
                <?php if (hasPermission("manage_statistics")): ?>
                <li>
                    <a href="manage-statistics" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-statistics') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span>Statistics</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (isSuperAdmin()): ?>
                <li>
                    <a href="manage-admins" class="flex items-center px-4 py-2.5 rounded-lg <?= ($current_page == 'manage-admins') ? 'bg-white text-secondary shadow-sm' : 'text-white/90 hover:bg-white/5 hover:text-white' ?> font-bold text-[13px] transition-all duration-200">
                        <svg class="w-5 h-5 mr-3 shrink-0 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Manage Admins</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- User Profile Bottom -->
    <div class="p-4 shrink-0 border-t border-white/5 bg-black/10">
        <div class="flex items-center justify-between rounded-xl p-3 bg-black/25 hover:bg-black/35 transition-colors duration-200">
            <div class="flex items-center overflow-hidden mr-2">
                <?php $sidebarUser = getLoggedInAdmin(); ?>
                <div class="w-9 h-9 rounded-lg bg-[#320000] text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-inner">
                    <?= htmlspecialchars(getInitials($sidebarUser['name'] ?? 'Admin')) ?>
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate leading-tight"><?= htmlspecialchars($sidebarUser['name'] ?? 'Admin') ?></p>
                    <p class="text-[11px] text-white/50 truncate mt-0.5 capitalize font-medium"><?= htmlspecialchars(str_replace('_', ' ', $sidebarUser['role'] ?? 'Admin')) ?></p>
                </div>
            </div>
            <a href="logout" class="p-2 text-white/60 hover:text-white hover:bg-white/10 rounded-lg transition-colors duration-200 shrink-0" title="Log Out">
                <svg class="w-5 h-5 text-red-400 hover:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </a>
        </div>
    </div>
</aside>

<script>
    (function() {
        const nav = document.getElementById('sidebar-nav');
        if (!nav) return;
        
        const restoreScroll = () => {
            const pos = localStorage.getItem('sidebar-scroll');
            if (pos !== null) {
                nav.scrollTop = parseInt(pos, 10);
            }
            nav.classList.remove('opacity-0');
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', restoreScroll);
        } else {
            requestAnimationFrame(restoreScroll);
        }

        nav.addEventListener('scroll', () => {
            localStorage.setItem('sidebar-scroll', nav.scrollTop);
        }, { passive: true });

        nav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                localStorage.setItem('sidebar-scroll', nav.scrollTop);
            });
        });
    })();
</script>
