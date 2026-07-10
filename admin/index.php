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
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10 bg-[#FAFAFA]">
        
        <!-- Welcome Banner -->
        <div class="relative bg-gradient-to-r from-[#4E0000] to-[#800000] rounded-2xl p-6 md:p-8 text-white mb-8 overflow-hidden shadow-lg border border-red-950">
            <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-10 pointer-events-none">
                <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="50,0 100,0 100,100 100,100"/></svg>
            </div>
            <div class="relative z-10 max-w-xl">
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
                <p class="text-[13px] md:text-sm text-red-100/90 leading-relaxed font-inter">
                    Here is an overview of the Ministry of Labour portal status and active booking requests. Use the quick action shortcuts below to publish new updates.
                </p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- News Count -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">News & Updates</span>
                        <p class="text-3xl font-extrabold text-gray-900 font-montserrat mt-1"><?= $newsCount ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-[#4E0000] flex items-center justify-center shrink-0 shadow-sm border border-red-100/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-gray-500 font-medium">
                    <span><?= $newsThisMonth ?> new this month</span>
                    <a href="news" class="text-[#4E0000] hover:underline">Manage &rarr;</a>
                </div>
            </div>

            <!-- Publications -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Publications</span>
                        <p class="text-3xl font-extrabold text-gray-900 font-montserrat mt-1"><?= $totalPublications ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 shadow-sm border border-blue-100/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-gray-500 font-medium">
                    <span>Local & Foreign docs</span>
                    <a href="manage-learning-platforms-local" class="text-blue-600 hover:underline">Manage &rarr;</a>
                </div>
            </div>

            <!-- Bookings -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Pending Bookings</span>
                        <p class="text-3xl font-extrabold text-gray-900 font-montserrat mt-1"><?= sprintf('%02d', $pendingBookings) ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 shadow-sm border border-amber-100/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-gray-500 font-medium">
                    <span><?= $totalBookings ?> total bookings</span>
                    <a href="bungalow-bookings" class="text-amber-600 hover:underline">Review &rarr;</a>
                </div>
            </div>

            <!-- Tenders & Careers -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-200 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-[11px] font-bold text-teal-600 uppercase tracking-wider">Tenders & Careers</span>
                        <p class="text-3xl font-extrabold text-gray-900 font-montserrat mt-1"><?= $procurementCount + $vacancyCount ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 shadow-sm border border-teal-100/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-gray-500 font-medium">
                    <span><?= $procurementCount ?> tenders / <?= $vacancyCount ?> jobs</span>
                    <a href="manage-procurements" class="text-teal-600 hover:underline">Manage &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Quick Shortcuts -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-8">
            <h3 class="text-base font-bold text-gray-900 font-montserrat mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Quick Action Shortcuts
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="news-add" class="flex items-center p-3 bg-gray-50 hover:bg-red-50 hover:text-[#4E0000] border border-gray-100 hover:border-red-100 rounded-xl transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center border border-gray-100 shadow-sm mr-3 group-hover:border-red-200 shrink-0">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="text-xs font-bold">Add News Update</span>
                </a>
                <a href="manage-special-notices" class="flex items-center p-3 bg-gray-50 hover:bg-red-50 hover:text-[#4E0000] border border-gray-100 hover:border-red-100 rounded-xl transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center border border-gray-100 shadow-sm mr-3 group-hover:border-red-200 shrink-0">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <span class="text-xs font-bold">Create Special Notice</span>
                </a>
                <a href="officials" class="flex items-center p-3 bg-gray-50 hover:bg-red-50 hover:text-[#4E0000] border border-gray-100 hover:border-red-100 rounded-xl transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center border border-gray-100 shadow-sm mr-3 group-hover:border-red-200 shrink-0">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <span class="text-xs font-bold">Add Directory Official</span>
                </a>
                <a href="bungalow-bookings" class="flex items-center p-3 bg-gray-50 hover:bg-red-50 hover:text-[#4E0000] border border-gray-100 hover:border-red-100 rounded-xl transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center border border-gray-100 shadow-sm mr-3 group-hover:border-red-200 shrink-0">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold">View Bungalow Bookings</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent News (Left 2/3) -->
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900">Recent News Updates</h3>
                    <a href="news" class="text-xs font-bold text-[#4E0000] hover:underline flex items-center">
                        View All
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-[11px] font-bold uppercase tracking-wider">
                                <th class="py-4 px-6">Title</th>
                                <th class="py-4 px-6">Category</th>
                                <th class="py-4 px-6">Date Added</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-[13px]">
                            <?php if (empty($recentNews)): ?>
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-gray-400">
                                    No news updates published yet.
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($recentNews as $news): ?>
                            <tr class="hover:bg-gray-50/40 transition-colors group">
                                <td class="py-4 px-6 font-semibold text-gray-900 max-w-xs truncate"><?= htmlspecialchars($news['title']) ?></td>
                                <td class="py-4 px-6 text-gray-600 font-medium"><?= htmlspecialchars($news['category']) ?></td>
                                <td class="py-4 px-6 text-gray-500"><?= date('M j, Y', strtotime($news['created_at'])) ?></td>
                                <td class="py-4 px-6">
                                    <?php if ($news['status'] === 'Published'): ?>
                                    <span class="px-2.5 py-0.5 rounded bg-green-50 text-green-700 text-[11px] font-bold border border-green-200 shadow-sm">Published</span>
                                    <?php else: ?>
                                    <span class="px-2.5 py-0.5 rounded bg-orange-50 text-orange-700 text-[11px] font-bold border border-orange-200 shadow-sm">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="news-add?id=<?= $news['id'] ?>" class="inline-flex items-center justify-center p-1.5 bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-[#4E0000] border border-gray-100 rounded-lg transition-all shadow-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Booking Requests (Right 1/3) -->
            <div class="lg:col-span-1">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900">Active Bookings</h3>
                    <a href="bungalow-bookings" class="text-xs font-bold text-[#4E0000] hover:underline flex items-center">
                        View All
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                    <?php
                    $pendingList = [];
                    try {
                        $pendingList = $pdo->query("SELECT * FROM bookings WHERE status = 'Pending' ORDER BY start_date ASC LIMIT 3")->fetchAll();
                    } catch (PDOException $e) {}
                    
                    if (empty($pendingList)):
                    ?>
                        <div class="py-12 text-center">
                            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-3 border border-green-100">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-[13px] font-bold text-gray-900 mb-0.5">All caught up!</p>
                            <p class="text-[11px] text-gray-500">No pending bungalow requests require attention.</p>
                        </div>
                    <?php else: ?>
                        <div class="divide-y divide-gray-100">
                            <?php foreach ($pendingList as $bk): ?>
                            <div class="py-3.5 first:pt-0 last:pb-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($bk['applicant_name']) ?></h4>
                                        <p class="text-[11px] text-gray-500 font-medium mt-0.5"><?= htmlspecialchars($bk['bungalow_name']) ?> Bungalow</p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md bg-amber-50 text-[#966708] text-[10px] font-bold border border-[#F5DE9B] shadow-sm">Pending</span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs text-[#4E0000] font-bold">
                                        <?= date('M j', strtotime($bk['start_date'])) ?> – <?= date('M j', strtotime($bk['end_date'])) ?>
                                    </span>
                                    <a href="bungalow-bookings" class="px-3 py-1 bg-[#4E0000] hover:bg-[#320000] text-white rounded-md text-[11px] font-bold shadow-sm transition-all">Review</a>
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
