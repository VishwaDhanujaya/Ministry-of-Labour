<?php
// news.php
require_once 'admin/includes/db.php';

// Fetch all published news (Category = 'News')
$stmt = $pdo->prepare("SELECT * FROM news WHERE status = 'Published' AND visibility = 'public' AND (category = 'News' OR category IS NULL OR category = '') ORDER BY created_at DESC");
$stmt->execute();
$allArticlesRaw = $stmt->fetchAll();
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
$metaDescription = 'Read the latest news, press releases, media updates, and insights from the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Ministry of Labour, Sri Lanka, News, Press Releases, Media, Updates, Notices';
$pageMeta = [
    'si' => [
        'title' => 'පුවත් - කම්කරු අමාත්‍යාංශය - ශ්‍රී ලංකාව',
        'desc'  => 'කම්කරු අමාත්‍යාංශයේ නවතම පුවත්, මාධ්‍ය නිවේදන සහ යාවත්කාලීන කිරීම් කියවන්න.',
        'kw'    => 'කම්කරු අමාත්‍යාංශය, පුවත්, මාධ්‍ය නිවේදන, යාවත්කාලීන කිරීම්'
    ],
    'ta' => [
        'title' => 'செய்திகள் - தொழில் அமைச்சு - இலங்கை',
        'desc'  => 'தொழில் அமைச்சின் அண்மைய செய்திகள், ஊடக அறிக்கைகள் மற்றும் புதுப்பிப்புகளை வாசியுங்கள்.',
        'kw'    => 'தொழில் அமைச்சு, செய்திகள், ஊடக வெளியீடுகள், புதுப்பிப்புகள்'
    ]
];
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->

<section class="py-16 md:py-24 px-4 md:px-16 bg-white">

    <div class="container mx-auto max-w-[1400px]">
        <!-- Section Title -->
        <div class="text-center mb-10 md:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-montserrat text-primary uppercase tracking-tight notranslate"><?= t('latest_news', 'Latest News') ?></h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
            <!-- Articles Content -->
            <div class="w-full lg:w-2/3">
                
                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12" id="articles-grid">
                    <?php if (empty($allArticles)): ?>
                        <div class="col-span-2 text-gray-500 py-4 notranslate"><?= t('no_news_found', 'No news found.') ?></div>
                    <?php else: ?>
                        <?php foreach ($allArticles as $index => $article): ?>
                        <div class="article-card bg-white rounded-[20px] overflow-hidden shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col" data-index="<?= $index ?>">
                            <div class="h-56 overflow-hidden bg-gray-100 flex items-center justify-center">
                                <?php if (!empty($article['cover_image']) && file_exists('admin/' . $article['cover_image'])): ?>
                                    <img loading="lazy" src="admin/<?= htmlspecialchars($article['cover_image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <?php endif; ?>
                            </div>
                            <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                                <div class="flex justify-between items-center mb-4 text-xs font-inter">
                                    <span class="text-gray-500 font-medium notranslate"><?= format_date_trilingual($article['created_at']) ?></span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#13273F]/10 text-[#13273F] border border-[#13273F]/20 uppercase tracking-wider inline-flex items-center gap-1.5 notranslate">
                                        <svg class="w-3 h-3 text-[#13273F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2m-2 4h6"></path></svg>
                                        <?= t('cat_news', 'News') ?>
                                    </span>
                                </div>
                                <h3 class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors notranslate">
                                    <a href="<?= navUrl('news/' . $article['id']) ?>" class="hover:text-secondary transition-colors"><?= htmlspecialchars($article['title']) ?></a>
                                </h3>
                                <?php 
                                $trunc = truncate_to_word_boundary($article['content'] ?? '', 120);
                                ?>
                                <?php if (!empty($trunc['text'])): ?>
                                <div class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">
                                    <span class="notranslate"><?= htmlspecialchars($trunc['text']) ?></span>
                                    <?php if ($trunc['truncated']): ?>
                                    <a href="<?= navUrl('news/' . $article['id']) ?>" class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1 notranslate"><?= t('read_more', 'Read More') ?></a>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <div class="flex-grow"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- No Results State -->
                <div id="noResultsMsg" class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm text-center text-gray-500 mb-12" style="display: none;">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-[17px] font-bold text-gray-800 mb-1 notranslate"><?= t('no_news_found', 'No news found.') ?></p>
                    <p class="text-sm text-gray-400 notranslate"><?= t('try_different_search', 'Try adjusting your search terms.') ?></p>
                </div>

                <!-- Dynamic Clean Pagination Controls -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-100" id="paginationControls">
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400 font-inter uppercase tracking-wider font-semibold notranslate"><?= t('show', 'Show') ?>:</span>
                        <div class="relative">
                            <select id="itemsPerPage" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-700 text-xs rounded-xl focus:ring-secondary focus:border-secondary block px-3 py-2 font-inter transition-colors outline-none shadow-sm appearance-none cursor-pointer pr-8">
                                <option value="6">6</option>
                                <option value="12">12</option>
                                <option value="24">24</option>
                                <option value="all"><?= t('all', 'All') ?></option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 font-inter" id="paginationSummary">
                        <!-- Dynamic user-friendly pagination summary -->
                    </div>
                    <div class="flex items-center gap-1.5" id="paginationButtons">
                        <!-- Pagination buttons will be injected here -->
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div
                    class="border border-gray-100 rounded-3xl p-8 sticky top-32 bg-white shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                    <!-- Search -->
                    <div class="mb-8">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-xl focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400 notranslate" placeholder="<?= htmlspecialchars(t('search_news', 'Search news...')) ?>">
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="mb-10">
                        <h3 class="text-[20px] font-semibold font-montserrat text-[#2D2D43] mb-6 notranslate"><?= t('recent_posts') ?></h3>
                        <ul class="space-y-5">
                            <?php foreach ($recentPosts as $post): ?>
                            <li>
                                <a href="<?= navUrl('news/' . $post['id']) ?>" class="flex items-start gap-4 group">
                                    <div class="w-14 h-14 rounded-xl border border-slate-100 bg-slate-50 overflow-hidden shrink-0 shadow-sm relative group-hover:shadow-md transition-all duration-300">
                                        <?php if (!empty($post['cover_image']) && file_exists('admin/' . $post['cover_image'])): ?>
                                            <img loading="lazy" src="<?= $base_url ?>admin/<?= htmlspecialchars($post['cover_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-[13.5px] font-bold text-slate-700 group-hover:text-secondary transition-colors line-clamp-2 leading-snug notranslate" title="<?= htmlspecialchars($post['title']) ?>">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[11px] text-slate-400 font-inter font-medium tracking-wide notranslate"><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded uppercase bg-[#13273F]/10 text-[#13273F] border border-[#13273F]/20 inline-flex items-center gap-1 notranslate">
                                                <svg class="w-2.5 h-2.5 text-[#13273F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2m-2 4h6"></path></svg>
                                                <?= t('cat_news', 'News') ?>
                                            </span>
                                        </div>
                                    </div>
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
let newsPaginator;

document.addEventListener("DOMContentLoaded", () => {
    const articles = <?php echo json_encode(array_map(function($article, $i) {
        return [
            'index' => $i,
            'title' => strtolower($article['title']),
            'content' => strtolower(strip_tags($article['content']))
        ];
    }, $allArticles, array_keys($allArticles))); ?>;

    newsPaginator = new ContentPaginator({
        items: articles,
        entityType: 'news',
        itemSelectors: ['.article-card'],
        gridContainerId: 'articles-grid',
        defaultItemsPerPage: 6
    });

    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const filtered = articles.filter(article => 
                searchTerm === "" || 
                article.title.includes(searchTerm) || 
                article.content.includes(searchTerm)
            ).map(a => a.index);
            newsPaginator.setFilteredIndexes(filtered);
        });
    }

    newsPaginator.updateUI();
});
</script>

<?php include 'includes/footer.php'; ?>