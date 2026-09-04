<?php
// events.php
require_once 'admin/includes/db.php';

// Fetch all published events (Category = 'Events')
$stmt = $pdo->prepare("SELECT * FROM news WHERE status = 'Published' AND visibility = 'public' AND category = 'Events' ORDER BY created_at DESC");
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

// Fetch recent event posts for sidebar (limit 10)
$recentPosts = array_slice($allArticles, 0, 10);

$page_title = 'Events';
$pageTitle = 'Events - Ministry of Labour - Sri Lanka';
$metaDescription = 'Explore upcoming and past events, ceremonies, workshops, and official programmes of the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Ministry of Labour, Sri Lanka, Events, Workshops, Programmes, Ceremonies';
$pageMeta = [
    'si' => [
        'title' => 'සිදුවීම් - කම්කරු අමාත්‍යාංශය - ශ්‍රී ලංකාව',
        'desc'  => 'කම්කරු අමාත්‍යාංශයේ ඉදිරි සහ පසුගිය සිදුවීම්, වැඩමුළු සහ නිල වැඩසටහන් ගවේෂණය කරන්න.',
        'kw'    => 'කම්කරු අමාත්‍යාංශය, සිදුවීම්, වැඩමුළු, වැඩසටහන්, උත්සව'
    ],
    'ta' => [
        'title' => 'நிகழ்வுகள் - தொழில் அமைச்சு - இலங்கை',
        'desc'  => 'தொழில் அமைச்சின் எதிர்வரும் மற்றும் கடந்தகால நிகழ்வுகள், பட்டறைகள் மற்றும் உத்தியோகபூர்வ நிகழ்வுகளைப் பார்வையிடுங்கள்.',
        'kw'    => 'தொழில் அமைச்சு, நிகழ்வுகள், பட்டறைகள், உத்தியோகபூர்வ நிகழ்வுகள்'
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
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-montserrat text-primary uppercase tracking-tight notranslate"><?= t('latest_events', 'Latest Events') ?></h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
            <!-- Articles Content -->
            <div class="w-full lg:w-2/3">
                
                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12" id="articles-grid">
                    <?php if (empty($allArticles)): ?>
                        <div class="col-span-2 text-gray-500 py-4 notranslate"><?= t('no_events_found', 'No events found.') ?></div>
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
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#4E0911]/10 text-[#4E0911] border border-[#4E0911]/20 uppercase tracking-wider inline-flex items-center gap-1.5 notranslate">
                                        <svg class="w-3 h-3 text-[#4E0911]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <?= t('cat_events', 'Events') ?>
                                    </span>
                                </div>
                                <h3 class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors notranslate">
                                    <a href="<?= navUrl('events/' . $article['id']) ?>" class="hover:text-secondary transition-colors"><?= htmlspecialchars($article['title']) ?></a>
                                </h3>
                                <?php 
                                $plainContent = trim(strip_tags($article['content'] ?? ''));
                                $isTruncated = mb_strlen($plainContent) > 150;
                                ?>
                                <?php if (!empty($plainContent)): ?>
                                <div class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">
                                    <span class="notranslate"><?= htmlspecialchars($isTruncated ? mb_substr($plainContent, 0, 150) . '...' : $plainContent) ?></span>
                                    <?php if ($isTruncated): ?>
                                    <a href="<?= navUrl('events/' . $article['id']) ?>" class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1 notranslate"><?= t('read_more', 'Read More') ?></a>
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
                    <p class="text-[17px] font-bold text-gray-800 mb-1 notranslate"><?= t('no_events_found', 'No events found.') ?></p>
                    <p class="text-sm text-gray-400 notranslate"><?= t('try_different_search', 'Try adjusting your search terms.') ?></p>
                </div>

                <!-- Pagination Container -->
                <div id="paginationControls" class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-100">
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
                    <div class="text-sm text-gray-500 font-inter" id="paginationSummary"></div>
                    <div class="flex items-center gap-1.5" id="paginationButtons"></div>
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
                            <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-xl focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400 notranslate" placeholder="<?= htmlspecialchars(t('search_events', 'Search events...')) ?>">
                        </div>
                    </div>

                    <!-- Recent News / Highlights Sidebar -->
                    <div>
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900 font-montserrat flex items-center gap-2 notranslate">
                                <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                <?= t('recent_events', 'Recent Events') ?>
                            </h3>
                            <a href="<?= navUrl('events') ?>" class="text-xs font-semibold text-secondary hover:underline notranslate"><?= t('view_all', 'View All') ?></a>
                        </div>
                        <ul class="space-y-4">
                            <?php foreach ($recentPosts as $post): ?>
                            <li>
                                <a href="<?= navUrl('events/' . $post['id']) ?>" class="group flex gap-4 items-center">
                                    <div class="w-16 h-16 rounded-xl bg-gray-100 flex-shrink-0 overflow-hidden relative">
                                        <?php if (!empty($post['cover_image']) && file_exists('admin/' . $post['cover_image'])): ?>
                                            <img src="admin/<?= htmlspecialchars($post['cover_image']) ?>" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <h4 class="text-[13px] font-semibold text-gray-800 font-montserrat group-hover:text-secondary transition-colors line-clamp-2 leading-snug notranslate">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[11px] text-gray-400 font-inter notranslate"><?= format_date_trilingual($post['created_at']) ?></span>
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
let eventsPaginator;

document.addEventListener("DOMContentLoaded", () => {
    const articles = <?php echo json_encode(array_map(function($article, $i) {
        return [
            'index' => $i,
            'title' => strtolower($article['title']),
            'content' => strtolower(strip_tags($article['content']))
        ];
    }, $allArticles, array_keys($allArticles))); ?>;

    eventsPaginator = new ContentPaginator({
        items: articles,
        entityType: 'events',
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
            eventsPaginator.setFilteredIndexes(filtered);
        });
    }

    eventsPaginator.updateUI();
});
</script>

<?php include 'includes/footer.php'; ?>
