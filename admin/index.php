<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

// Fetch stats
$newsCount = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$newsThisMonth = $pdo->query("SELECT COUNT(*) FROM articles WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())")->fetchColumn();

$bookingsCount = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pendingBookingsCount = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'")->fetchColumn();

$galleryCount = $pdo->query("SELECT COUNT(*) FROM gallery WHERE status = 'Published'")->fetchColumn();

// Fetch recent articles
$recentNews = $pdo->query("SELECT n.*, a.name as author_name FROM articles n LEFT JOIN admins a ON n.author_id = a.id ORDER BY n.created_at DESC LIMIT 5")->fetchAll();

// Fetch pending bookings
$pendingBookings = $pdo->query("SELECT * FROM bookings WHERE status = 'Pending' ORDER BY created_at DESC LIMIT 3")->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <h2 class="text-3xl font-bold font-montserrat text-gray-900 mb-8">Overview</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-[13px] font-medium text-gray-500 uppercase tracking-wide">Total Articles</p>
                        <p class="text-4xl font-bold text-gray-900 font-montserrat mt-2"><?= $newsCount ?></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-[#4E0000]/10 text-[#4E0000] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-[12px] font-medium text-teal-600 bg-teal-50 px-2.5 py-1 rounded-md">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span><?= $newsThisMonth ?> new this month</span>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-[13px] font-medium text-gray-500 uppercase tracking-wide">Bungalow Bookings</p>
                        <p class="text-4xl font-bold text-gray-900 font-montserrat mt-2"><?= $bookingsCount ?></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-[#B08920]/10 text-[#B08920] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-[12px] font-medium text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span><?= $pendingBookingsCount ?> pending review</span>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-[13px] font-medium text-gray-500 uppercase tracking-wide">Published Gallery</p>
                        <p class="text-4xl font-bold text-gray-900 font-montserrat mt-2"><?= $galleryCount ?></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-[12px] font-medium text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Active items</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent News Articles (Col 2) -->
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-bold font-montserrat text-gray-900">Recent Articles</h3>
                    <a href="articles" class="px-5 py-2 border border-[#4E0000] rounded-md text-[13px] font-bold text-[#4E0000] hover:bg-[#4E0000] hover:text-white transition-colors">View All</a>
                </div>
                
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#13273F] text-white">
                                <th class="py-4 px-6 font-medium text-[15px]">Title</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Category</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Date</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Status</th>
                                <th class="py-4 px-6 font-medium text-[15px]"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-[13px]">
                            <?php if (empty($recentNews)): ?>
                            <tr>
                                <td colspan="5" class="py-12 px-6">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2"></path></svg>
                                        </div>
                                        <p class="text-[14px] font-semibold text-gray-900 mb-1">No articles found</p>
                                        <p class="text-[13px] text-gray-500">Get started by creating your first article.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($recentNews as $article): ?>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-5 px-6 font-medium text-gray-900"><?= htmlspecialchars($article['title']) ?></td>
                                <td class="py-5 px-6 text-gray-800"><?= htmlspecialchars($article['category']) ?></td>
                                <td class="py-5 px-6 text-gray-800"><?= date('M j, Y', strtotime($article['created_at'])) ?></td>
                                <td class="py-5 px-6">
                                    <?php if ($article['status'] === 'Published'): ?>
                                    <span class="px-3 py-1 rounded bg-[#EDF7F4] text-[#166952] text-[11px] font-bold">Published</span>
                                    <?php else: ?>
                                    <span class="px-3 py-1 rounded bg-[#FCF1F2] text-[#9E212D] text-[11px] font-bold">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-5 px-6 text-right">
                                    <a href="new-article?id=<?= $article['id'] ?>" class="text-gray-500 hover:text-[#13273F] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pending Bookings (Col 1) -->
            <div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Pending Bookings</h3>
                    </div>
                    <div class="divide-y divide-gray-100 flex-1 px-5 pt-3">
                        <?php if (empty($pendingBookings)): ?>
                        <div class="py-12 flex flex-col items-center justify-center text-center h-full">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-[14px] font-semibold text-gray-900 mb-1">All caught up!</p>
                            <p class="text-[13px] text-gray-500">There are no pending bookings.</p>
                        </div>
                        <?php else: ?>
                        <?php foreach ($pendingBookings as $booking): ?>
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-10 h-10 rounded bg-[#4E0000]/10 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-[#4E0000]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l9 6.75v11.25a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 21V9.75L12 3zm-3 15h6v-6H9v6z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-[13px]"><?= htmlspecialchars($booking['bungalow_name']) ?> Bungalow</h4>
                                <p class="text-[11px] text-gray-500 mt-0.5"><?= htmlspecialchars($booking['applicant_name']) ?> · <?= date('M j, Y', strtotime($booking['start_date'])) ?></p>
                                <div class="mt-2">
                                    <span class="px-3 py-1 rounded bg-[#FDF9ED] text-[#966708] border border-[#F5DE9B] text-[10px] font-bold">Pending</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="p-5 mt-2">
                        <a href="bungalow-bookings" class="block text-center w-full py-2.5 bg-transparent border border-[#4E0000] text-[#4E0000] rounded-md text-[13px] font-bold hover:bg-[#4E0000] hover:text-white transition-colors">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
