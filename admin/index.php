<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

// Fetch stats
$newsCount = 0;
$newsThisMonth = 0;
try {
    $newsCount = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
    $newsThisMonth = $pdo->query("SELECT COUNT(*) FROM news WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())")->fetchColumn();
} catch (PDOException $e) {}

// Fetch learning platforms (publications) stats
$totalPublications = 0;
try {
    $localPubs = $pdo->query("SELECT COUNT(*) FROM learning_platforms_local")->fetchColumn();
    $foreignPubs = $pdo->query("SELECT COUNT(*) FROM learning_platforms_foreign")->fetchColumn();
    $totalPublications = $localPubs + $foreignPubs;
} catch (PDOException $e) {}

// Fetch tenders & careers stats
$procurementCount = 0;
$vacancyCount = 0;
try {
    $procurementCount = $pdo->query("SELECT COUNT(*) FROM procurements")->fetchColumn();
    $vacancyCount = $pdo->query("SELECT COUNT(*) FROM vacancies")->fetchColumn();
} catch (PDOException $e) {}

// Fetch bungalow booking stats
$pendingBookings = 0;
$totalBookings = 0;
try {
    $pendingBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'")->fetchColumn();
    $totalBookings   = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
} catch (PDOException $e) {}

// Fetch recent news
$recentNews = [];
try {
    $recentNews = $pdo->query("SELECT n.*, a.name as author_name FROM news n LEFT JOIN admins a ON n.author_id = a.id ORDER BY n.created_at DESC LIMIT 5")->fetchAll();
} catch (PDOException $e) {}

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 bg-[#F8F9FA]">
        
        <!-- Welcome Banner -->
        <div class="relative bg-gradient-to-r from-primary via-[#1E3E62] to-[#2D5C8F] rounded-2xl p-6 md:p-8 text-white mb-8 overflow-hidden shadow-[0_4px_20px_rgba(19,39,63,0.08)] border border-slate-100/10">
            <!-- Glass Decorative Rings -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/5 border border-white/10 blur-[1px] pointer-events-none"></div>
            <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full bg-white/5 border border-white/10 blur-[1px] pointer-events-none"></div>
            
            <div class="relative z-10 max-w-xl">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 border border-white/10 rounded-full text-[11px] font-bold uppercase tracking-wider mb-4 font-mono select-none text-slate-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>System Active &bull; <?= date('M j, Y') ?></span>
                </div>
                <?php 
                $adminUser = getLoggedInAdmin(); 
                $hour = date('H');
                $greeting = 'Welcome back';
                if ($hour < 12) {
                    $greeting = 'Good morning';
                } elseif ($hour < 17) {
                    $greeting = 'Good afternoon';
                } else {
                    $greeting = 'Good evening';
                }
                ?>
                <h2 class="text-2xl md:text-3xl font-extrabold font-montserrat tracking-tight mb-2">
                    <?= $greeting ?>, <?= htmlspecialchars($adminUser['name'] ?? 'Admin') ?>!
                </h2>
                <p class="text-[13px] md:text-sm text-slate-100/90 leading-relaxed font-inter">
                    Here is an overview of the Ministry of Labour portal status and active booking requests. Use the quick action shortcuts below to publish new updates.
                </p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- News Count -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100/80 shadow-[0_4px_16px_rgba(0,0,0,0.015)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.035)] hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between relative group overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-secondary opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">News & Updates</span>
                        <p class="text-3xl font-extrabold text-slate-800 font-montserrat mt-2"><?= $newsCount ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-secondary flex items-center justify-center shrink-0 shadow-sm border border-red-100/50 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2"></path></svg>
                    </div>
                </div>
                <div class="mt-5 pt-3.5 border-t border-slate-50 flex items-center justify-between text-[11.5px] text-slate-500 font-semibold font-inter">
                    <span class="text-slate-400"><?= $newsThisMonth ?> new this month</span>
                    <a href="news" class="text-secondary hover:text-[#721c1c] transition-colors flex items-center gap-1">
                        Manage
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Publications -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100/80 shadow-[0_4px_16px_rgba(0,0,0,0.015)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.035)] hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between relative group overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Publications</span>
                        <p class="text-3xl font-extrabold text-slate-800 font-montserrat mt-2"><?= $totalPublications ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 shadow-sm border border-blue-100/50 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <div class="mt-5 pt-3.5 border-t border-slate-50 flex items-center justify-between text-[11.5px] text-slate-500 font-semibold font-inter">
                    <span class="text-slate-400">Local & Foreign docs</span>
                    <a href="manage-learning-platforms-local" class="text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1">
                        Manage
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Bookings -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100/80 shadow-[0_4px_16px_rgba(0,0,0,0.015)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.035)] hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between relative group overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block">Pending Bookings</span>
                        <p class="text-3xl font-extrabold text-slate-800 font-montserrat mt-2"><?= sprintf('%02d', $pendingBookings) ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 shadow-sm border border-amber-100/50 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-5 pt-3.5 border-t border-slate-50 flex items-center justify-between text-[11.5px] text-slate-500 font-semibold font-inter">
                    <span class="text-slate-400"><?= $totalBookings ?> total bookings</span>
                    <a href="bungalow-bookings" class="text-amber-600 hover:text-amber-700 transition-colors flex items-center gap-1">
                        Review
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Tenders & Careers -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100/80 shadow-[0_4px_16px_rgba(0,0,0,0.015)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.035)] hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between relative group overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-teal-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-teal-600 uppercase tracking-wider block">Tenders & Careers</span>
                        <p class="text-3xl font-extrabold text-slate-800 font-montserrat mt-2"><?= $procurementCount + $vacancyCount ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 shadow-sm border border-teal-100/50 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-5 pt-3.5 border-t border-slate-50 flex items-center justify-between text-[11.5px] text-slate-500 font-semibold font-inter">
                    <span class="text-slate-400"><?= $procurementCount ?> tenders / <?= $vacancyCount ?> jobs</span>
                    <a href="manage-procurements" class="text-teal-600 hover:text-teal-700 transition-colors flex items-center gap-1">
                        Manage
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Shortcuts -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] p-6 mb-8">
            <h3 class="text-sm font-bold text-slate-800 font-montserrat mb-4 flex items-center gap-2 select-none">
                <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span>Quick Action Shortcuts</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <a href="news-add" class="flex items-start p-3.5 bg-slate-50/50 hover:bg-red-50/20 hover:text-secondary border border-slate-100/80 hover:border-red-200/60 rounded-xl transition-all duration-150 group">
                    <div class="w-8.5 h-8.5 rounded-lg bg-white flex items-center justify-center border border-slate-100 shadow-sm mr-3.5 group-hover:scale-105 transition-transform duration-200 shrink-0">
                        <svg class="w-4.5 h-4.5 text-slate-500 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <span class="text-[12.5px] font-bold text-slate-700 group-hover:text-secondary transition-colors block">Add News Update</span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">Publish alerts & press releases</span>
                    </div>
                </a>
                <a href="manage-special-notices" class="flex items-start p-3.5 bg-slate-50/50 hover:bg-red-50/20 hover:text-secondary border border-slate-100/80 hover:border-red-200/60 rounded-xl transition-all duration-150 group">
                    <div class="w-8.5 h-8.5 rounded-lg bg-white flex items-center justify-center border border-slate-100 shadow-sm mr-3.5 group-hover:scale-105 transition-transform duration-200 shrink-0">
                        <svg class="w-4.5 h-4.5 text-slate-500 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div>
                        <span class="text-[12.5px] font-bold text-slate-700 group-hover:text-secondary transition-colors block">Create Special Notice</span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">Announce urgent updates</span>
                    </div>
                </a>
                <a href="officials" class="flex items-start p-3.5 bg-slate-50/50 hover:bg-red-50/20 hover:text-secondary border border-slate-100/80 hover:border-red-200/60 rounded-xl transition-all duration-150 group">
                    <div class="w-8.5 h-8.5 rounded-lg bg-white flex items-center justify-center border border-slate-100 shadow-sm mr-3.5 group-hover:scale-105 transition-transform duration-200 shrink-0">
                        <svg class="w-4.5 h-4.5 text-slate-500 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[12.5px] font-bold text-slate-700 group-hover:text-secondary transition-colors block">Add Directory Official</span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">Update contacts & staff lists</span>
                    </div>
                </a>
                <a href="bungalow-bookings" class="flex items-start p-3.5 bg-slate-50/50 hover:bg-red-50/20 hover:text-secondary border border-slate-100/80 hover:border-red-200/60 rounded-xl transition-all duration-150 group">
                    <div class="w-8.5 h-8.5 rounded-lg bg-white flex items-center justify-center border border-slate-100 shadow-sm mr-3.5 group-hover:scale-105 transition-transform duration-200 shrink-0">
                        <svg class="w-4.5 h-4.5 text-slate-500 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[12.5px] font-bold text-slate-700 group-hover:text-secondary transition-colors block">View Bungalow Bookings</span>
                        <span class="text-[11px] text-slate-400 font-medium block mt-0.5">Review pending room requests</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent News (Left 2/3) -->
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-bold font-montserrat text-slate-800">Recent News Updates</h3>
                    <a href="news" class="text-xs font-bold text-secondary hover:text-[#721c1c] transition-colors flex items-center gap-1 select-none">
                        View All
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <?php
                $headers = [
                    ['label' => 'Title', 'class' => ''],
                    ['label' => 'Category', 'class' => 'w-32'],
                    ['label' => 'Date Added', 'class' => 'w-32'],
                    ['label' => 'Status', 'class' => 'w-28'],
                    ['label' => 'Actions', 'class' => 'text-right w-20']
                ];
                
                renderAdminTable($headers, $recentNews, function($news) {
                    ?>
                    <tr class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group">
                        <td class="py-4 px-6 font-bold text-slate-800 max-w-xs truncate group-hover:text-secondary transition-colors"><?= htmlspecialchars($news['title']) ?></td>
                        <td class="py-4 px-6 text-slate-500 font-semibold text-[12px]"><?= htmlspecialchars($news['category']) ?></td>
                        <td class="py-4 px-6 text-slate-400 font-mono"><?= date('M j, Y', strtotime($news['created_at'])) ?></td>
                        <td class="py-4 px-6">
                            <?php if ($news['status'] === 'Published'): ?>
                            <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold shadow-sm">Published</span>
                            <?php else: ?>
                            <span class="px-2.5 py-1 rounded-md bg-orange-50 text-orange-700 border border-orange-200 text-[11px] font-bold shadow-sm">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="news-add?id=<?= $news['id'] ?>" class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 inline-flex items-center justify-center transition-all shadow-sm" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                            </a>
                        </td>
                    </tr>
                    <?php
                }, [
                    'minWidth' => '600px',
                    'emptyTitle' => 'No news updates published yet.',
                    'emptySubtitle' => 'Click "Add News Update" to publish your first content.',
                    'emptyIcon' => 'news',
                    'containerClass' => 'bg-white rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] overflow-hidden'
                ]);
                ?>
            </div>

            <!-- Booking Requests (Right 1/3) -->
            <div class="lg:col-span-1">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-bold font-montserrat text-slate-800">Active Bookings</h3>
                    <a href="bungalow-bookings" class="text-xs font-bold text-secondary hover:text-[#721c1c] transition-colors flex items-center gap-1 select-none">
                        View All
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-[0_4px_16px_rgba(0,0,0,0.015)] space-y-4">
                    <?php
                    $pendingList = [];
                    try {
                        $pendingList = $pdo->query("SELECT * FROM bookings WHERE status = 'Pending' ORDER BY start_date ASC LIMIT 3")->fetchAll();
                    } catch (PDOException $e) {}
                    
                    if ($pendingBookings > 0):
                    ?>
                        <div class="px-3.5 py-2.5 rounded-xl bg-amber-50/50 border border-amber-100/60 text-amber-800 text-xs font-bold flex items-center gap-2 mb-2 select-none">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse shrink-0"></span>
                            <span><?= $pendingBookings ?> pending request<?= $pendingBookings > 1 ? 's' : '' ?> awaits review</span>
                        </div>
                    <?php
                    endif;

                    if (empty($pendingList)):
                    ?>
                        <div class="py-12 text-center">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-3 border border-emerald-100">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-[13px] font-bold text-slate-700 mb-0.5">All caught up!</p>
                            <p class="text-[11.5px] text-slate-400">No pending bungalow requests require attention.</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-3.5">
                            <?php foreach ($pendingList as $bk): 
                                $nights = (strtotime($bk['end_date']) - strtotime($bk['start_date'])) / 86400;
                            ?>
                            <div class="p-4 rounded-xl bg-slate-50/50 hover:bg-slate-50 border border-slate-100 hover:border-slate-200 transition-all duration-150 group flex flex-col justify-between cursor-pointer" onclick="window.location.href='bungalow-bookings'">
                                <div class="flex justify-between items-start mb-2.5">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-[13.5px] group-hover:text-secondary transition-colors leading-tight"><?= htmlspecialchars($bk['applicant_name']) ?></h4>
                                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mt-1 flex items-center gap-1 select-none">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>
                                            <span><?= htmlspecialchars($bk['bungalow_name']) ?></span>
                                        </p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md bg-yellow-50 text-yellow-700 border border-yellow-200 text-[10px] font-bold shadow-sm select-none">Pending</span>
                                </div>
                                <div class="flex justify-between items-center mt-2.5 pt-3 border-t border-slate-100/70">
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500 font-mono">
                                        <span class="font-bold text-slate-700"><?= date('M j', strtotime($bk['start_date'])) ?></span>
                                        <span class="text-slate-300 font-sans">&rarr;</span>
                                        <span class="font-bold text-slate-700"><?= date('M j', strtotime($bk['end_date'])) ?></span>
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-sans font-bold text-[9.5px] ml-1 shrink-0"><?= $nights ?>N</span>
                                    </div>
                                    <a href="bungalow-bookings" class="px-3.5 py-1.5 bg-secondary hover:bg-[#320000] text-white rounded-lg text-[11px] font-bold shadow-sm transition-colors select-none">Review</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
