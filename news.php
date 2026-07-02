<?php
// news.php
require_once 'admin/includes/db.php';

// Fetch all published news
$allArticlesRaw = $pdo->query("SELECT * FROM news WHERE status = 'Published' ORDER BY created_at DESC")->fetchAll();
$allArticles = [];
foreach ($allArticlesRaw as $article) {
    if ($current_lang === 'si') {
        if (!empty($article['title_si'])) $article['title'] = $article['title_si'];
        if (!empty($article['content_si'])) $article['content'] = $article['content_si'];
    } elseif ($current_lang === 'ta') {
        if (!empty($article['title_ta'])) $article['title'] = $article['title_ta'];
        if (!empty($article['content_ta'])) $article['content'] = $article['content_ta'];
    }
    $allArticles[] = $article;
}

// Fetch recent posts for sidebar (limit 10)
$recentPosts = array_slice($allArticles, 0, 10);

$page_title = 'News';
$pageTitle = 'News - Ministry of Labour - Sri Lanka';
$metaDescription = 'Read the latest news, updates, notices, and insights from the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Ministry of Labour, Sri Lanka, News, Updates, Media, Notices';
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
            <!-- Articles Content -->
            <div class="w-full lg:w-2/3">
                
                <!-- Filters removed -->

                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12" id="articles-grid">
                    <?php if (empty($allArticles)): ?>
                        <div class="col-span-2 text-gray-500 py-4">No news found.</div>
                    <?php else: ?>
                        <?php foreach ($allArticles as $article): ?>
                        <div class="article-card bg-white rounded-[20px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                            <div class="h-56 overflow-hidden bg-gray-100 flex items-center justify-center">
                                <?php if (!empty($article['cover_image']) && file_exists('admin/' . $article['cover_image'])): ?>
                                    <img loading="lazy" src="admin/<?= htmlspecialchars($article['cover_image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <?php endif; ?>
                            </div>
                            <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                                <div class="flex justify-between items-center mb-4 text-xs text-gray-500 font-inter font-medium">
                                    <span><?= date('F j, Y', strtotime($article['created_at'])) ?></span>
                                </div>
                                <h3 class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors notranslate">
                                    <a href="news/<?= $article['id'] ?>" class="hover:text-secondary transition-colors"><?= htmlspecialchars($article['title']) ?></a>
                                </h3>
                                <div class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">
                                    <span class="notranslate"><?= htmlspecialchars(mb_substr(strip_tags($article['content']), 0, 150)) ?>...</span>
                                    <a href="news/<?= $article['id'] ?>" class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1">Read More</a>
                                </div>
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
                            <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400" placeholder="Search news...">
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="mb-10">
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6">Recent Posts</h3>
                        <ul class="space-y-4">
                            <?php foreach ($recentPosts as $post): ?>
                            <li>
                                <a href="news/<?= $post['id'] ?>" class="flex text-[14px] text-[#4A4A4A] font-inter hover:text-secondary transition-colors leading-relaxed group">
                                    <span class="mr-2 text-gray-400 group-hover:text-secondary transition-colors mt-0.5">&gt;</span>
                                    <span class="notranslate"><?= htmlspecialchars($post['title']) ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn, .sidebar-filter-btn');
    const articles = document.querySelectorAll('.article-card');
    const searchInput = document.getElementById('searchInput');

    let currentFilter = 'all';

    function filterArticles() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        
        articles.forEach(article => {
            const titleElement = article.querySelector('h3 a');
            const title = titleElement ? titleElement.innerText.toLowerCase() : '';
            const matchesSearch = title.includes(searchTerm);
            
            if (matchesSearch) {
                article.style.display = 'flex';
            } else {
                article.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterArticles);
    }

});
</script>

<?php include 'includes/footer.php'; ?>