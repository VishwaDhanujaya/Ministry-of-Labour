<?php
// news.php
require_once 'admin/includes/db.php';

// Fetch all news
$newsItems = $pdo->query("SELECT * FROM news WHERE status = 'Published' ORDER BY publish_date DESC, created_at DESC")->fetchAll();

// Fetch recent posts for sidebar (limit 10)
$recentPosts = array_slice($newsItems, 0, 10);

// news.php
$page_title = 'News';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-[1400px]">
        <!-- Section Title -->
        <div class="text-center mb-12">
            <p class="text-secondary text-sm font-medium tracking-[0.15em] mb-3 font-inter uppercase">Our Blog</p>
            <h2 class="text-3xl md:text-[36px] font-semibold font-montserrat text-gray-900">Latest Insights</h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
            <!-- News Grid -->
            <div class="w-full lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <?php if (empty($newsItems)): ?>
                        <div class="col-span-2 text-center text-gray-500 py-10">No news articles found.</div>
                    <?php else: ?>
                        <?php foreach ($newsItems as $news): ?>
                        <div class="bg-white rounded-[20px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                            <div class="h-56 overflow-hidden bg-gray-100 flex items-center justify-center">
                                <?php if (!empty($news['cover_image']) && file_exists('admin/' . $news['cover_image'])): ?>
                                    <img src="admin/<?= htmlspecialchars($news['cover_image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <?php endif; ?>
                            </div>
                            <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                                <div class="flex justify-between items-center mb-4 text-xs text-gray-500 font-inter font-medium">
                                    <span><?= date('F j, Y', strtotime($news['publish_date'] ?? $news['created_at'])) ?></span>
                                    <span><?= htmlspecialchars($news['category']) ?></span>
                                </div>
                                <h3 class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors">
                                    <a href="news-single.php?id=<?= $news['id'] ?>" class="hover:text-secondary transition-colors"><?= htmlspecialchars($news['title']) ?></a>
                                </h3>
                                <p class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">
                                    <?= htmlspecialchars($news['summary']) ?>...
                                    <a href="news-single.php?id=<?= $news['id'] ?>" class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1">Read More</a>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div
                    class="border border-gray-100 rounded-3xl p-8 sticky top-32 bg-white shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                    <!-- Search -->
                    <div class="mb-10">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text"
                                class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-[13px] placeholder-gray-400 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors font-inter"
                                placeholder="Search">
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="mb-10">
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6">Recent Posts</h3>
                        <ul class="space-y-4">
                            <?php foreach ($recentPosts as $post): ?>
                            <li>
                                <a href="news-single.php?id=<?= $post['id'] ?>" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span><?= htmlspecialchars($post['title']) ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6">Categories</h3>
                        <ul class="space-y-4">
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Media</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span
                                        class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span>Notices</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>