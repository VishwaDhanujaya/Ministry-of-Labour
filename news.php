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
$pageMeta = [
    'si' => [
        'title' => 'පුවත් - කම්කරු අමාත්‍යාංශය - ශ්‍රී ලංකාව',
        'desc'  => 'කම්කරු අමාත්‍යාංශයේ නවතම පුවත්, යාවත්කාලීන කිරීම් සහ නිවේදන කියවන්න.',
        'kw'    => 'කම්කරු අමාත්‍යාංශය, පුවත්, යාවත්කාලීන කිරීම්, මාධ්‍ය'
    ],
    'ta' => [
        'title' => 'செய்திகள் - தொழில் அமைச்சு - இலங்கை',
        'desc'  => 'தொழில் அமைச்சின் அண்மைய செய்திகள், புதுப்பிப்புகள் மற்றும் அறிவித்தப்புகளை வாசியுங்கள்.',
        'kw'    => 'தொழில் அமைச்சு, செய்திகள், புதுப்பிப்புகள், ஊடகம்'
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
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-montserrat text-primary uppercase tracking-tight notranslate"><?= t('latest_insights') ?></h2>
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
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <?php endif; ?>
                            </div>
                            <div class="p-8 pt-6 pb-8 flex flex-col flex-grow">
                                <div class="flex justify-between items-center mb-4 text-xs text-gray-500 font-inter font-medium">
                                    <span><?= format_date_trilingual($article['created_at']) ?></span>
                                </div>
                                <h3 class="text-[17px] md:text-lg font-semibold text-[#2D2D43] font-montserrat mb-3 leading-snug hover:text-secondary transition-colors notranslate">
                                    <a href="<?= navUrl('news/' . $article['id']) ?>" class="hover:text-secondary transition-colors"><?= htmlspecialchars($article['title']) ?></a>
                                </h3>
                                <div class="text-gray-500 text-[14px] font-inter leading-relaxed flex-grow">
                                    <span class="notranslate"><?= htmlspecialchars(mb_substr(strip_tags($article['content']), 0, 150)) ?>...</span>
                                    <a href="<?= navUrl('news/' . $article['id']) ?>" class="text-secondary font-bold hover:text-[#320000] transition-colors ml-1 notranslate"><?= t('read_more', 'Read More') ?></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- No Results State -->
                <div id="noResultsMsg" class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm text-center text-gray-500 mb-12" style="display: none;">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-[17px] font-bold text-gray-800 mb-1"><?= t('no_news_found', 'No news found.') ?></p>
                </div>

                <!-- Pagination Controls -->
                <div id="paginationControls" class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <label for="itemsPerPage" class="text-xs font-bold text-gray-400 whitespace-nowrap font-inter uppercase tracking-wider hidden sm:inline-block"><?= t('items_per_page', 'Items per page') ?></label>
                        <div class="relative w-full sm:w-40">
                            <select id="itemsPerPage" class="bg-white border border-gray-200 text-gray-900 text-[13px] rounded-xl focus:ring-secondary focus:border-secondary block w-full px-3.5 py-2 font-inter transition-all outline-none appearance-none cursor-pointer shadow-sm notranslate" onchange="resetPaginationAndFilter()">
                                <option value="4">4 <?= t('per_page_label', 'per page') ?></option>
                                <option value="6" selected>6 <?= t('per_page_label', 'per page') ?></option>
                                <option value="12">12 <?= t('per_page_label', 'per page') ?></option>
                                <option value="24">24 <?= t('per_page_label', 'per page') ?></option>
                                <option value="all"><?= t('show_all', 'Show All') ?></option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
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
                            <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400 notranslate" placeholder="<?= htmlspecialchars(t('search_news', 'Search news...')) ?>">
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
                                        <span class="text-[11px] text-slate-400 font-inter font-medium tracking-wide mt-1 block"><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
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
let currentPage = 1;
let filteredIndexes = [];

const articles = <?php echo json_encode(array_map(function($article, $i) {
    return [
        'index' => $i,
        'title' => strtolower($article['title']),
        'content' => strtolower(strip_tags($article['content']))
    ];
}, $allArticles, array_keys($allArticles))); ?>;

function resetPaginationAndFilter() {
    currentPage = 1;
    filterArticles();
}

function filterArticles() {
    const searchInput = document.getElementById("searchInput");
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const itemsPerPageSelect = document.getElementById("itemsPerPage");
    const itemsPerPage = itemsPerPageSelect ? itemsPerPageSelect.value : '6';

    filteredIndexes = [];
    articles.forEach(article => {
        const matchesSearch = searchTerm === "" || 
                              article.title.includes(searchTerm) || 
                              article.content.includes(searchTerm);
        if (matchesSearch) {
            filteredIndexes.push(article.index);
        }
    });

    document.querySelectorAll('.article-card').forEach(card => card.classList.add('hidden'));

    updatePaginationUI(itemsPerPage);
}

function updatePaginationUI(itemsPerPage) {
    const noResultsMsg = document.getElementById('noResultsMsg');
    const articlesGrid = document.getElementById('articles-grid');
    const paginationControls = document.getElementById('paginationControls');

    const totalItems = filteredIndexes.length;

    if (totalItems === 0) {
        if (noResultsMsg) noResultsMsg.style.display = 'flex';
        if (articlesGrid) articlesGrid.style.display = 'none';
        if (paginationControls) paginationControls.style.display = 'none';
        return;
    }

    if (noResultsMsg) noResultsMsg.style.display = 'none';
    if (articlesGrid) articlesGrid.style.display = 'grid';

    let startIdx = 0;
    let endIdx = totalItems;

    if (itemsPerPage !== 'all') {
        itemsPerPage = parseInt(itemsPerPage);
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        startIdx = (currentPage - 1) * itemsPerPage;
        endIdx = Math.min(startIdx + itemsPerPage, totalItems);

        renderPaginationButtons(totalPages);
    } else {
        renderPaginationButtons(1);
    }

    if (paginationControls) paginationControls.style.display = 'flex';

    const cards = document.querySelectorAll('.article-card');
    for (let i = startIdx; i < endIdx; i++) {
        const itemIdx = filteredIndexes[i];
        const el = Array.from(cards).find(card => parseInt(card.getAttribute('data-index')) === itemIdx);
        if (el) {
            el.classList.remove('hidden');
        }
    }

    updatePaginationSummary(startIdx, endIdx, totalItems, 'news');
}

function updatePaginationSummary(startIdx, endIdx, totalItems, entityType = 'news') {
    const summaryEl = document.getElementById('paginationSummary');
    if (!summaryEl) return;

    const start = startIdx + 1;
    const end = endIdx;
    const lang = document.documentElement.lang || 'en';

    const entityNames = {
        documents: { en: 'documents', singular: 'document', si: 'ලේඛන', ta: 'ஆவணங்கள்' },
        news: { en: 'news articles', singular: 'news article', si: 'පුවත් ලිපි', ta: 'செய்தி கட்டுரைகள்' },
        vacancies: { en: 'vacancies', singular: 'vacancy', si: 'පුරප්පාඩු', ta: 'வெற்றிடங்கள்' },
        notices: { en: 'notices', singular: 'notice', si: 'නිවේදන', ta: 'அறிவிப்புகள்' },
        updates: { en: 'updates', singular: 'update', si: 'යාවත්කාලීන', ta: 'புதுப்பிப்புகள்' },
        publications: { en: 'publications', singular: 'publication', si: 'ප්‍රකාශන', ta: 'வெளியீடுகள்' }
    };

    const entity = entityNames[entityType] || entityNames.news;
    const name = entity[lang] || entity.en;

    let text = '';
    if (lang === 'si') {
        if (totalItems === 1) {
            text = `${name} 1 ක් පෙන්වයි`;
        } else if (start === 1 && end === totalItems) {
            text = `සියලුම ${name} <span class="font-semibold text-gray-800">${totalItems}</span> ම පෙන්වයි`;
        } else {
            text = `${name} <span class="font-semibold text-gray-800">${totalItems}</span> න් <span class="font-semibold text-gray-800">${start}–${end}</span> දක්වා පෙන්වයි`;
        }
    } else if (lang === 'ta') {
        if (totalItems === 1) {
            text = `1 ${name} காட்டப்படுகிறது`;
        } else if (start === 1 && end === totalItems) {
            text = `அனைத்து <span class="font-semibold text-gray-800">${totalItems}</span> ${name} காட்டப்படுகின்றன`;
        } else {
            text = `<span class="font-semibold text-gray-800">${totalItems}</span> ${name} <span class="font-semibold text-gray-800">${start}–${end}</span> காட்டப்படுகின்றன`;
        }
    } else {
        if (totalItems === 1) {
            text = `Showing 1 ${entity.singular}`;
        } else if (start === 1 && end === totalItems) {
            text = `Showing all <span class="font-semibold text-gray-800">${totalItems}</span> ${name}`;
        } else {
            text = `Showing <span class="font-semibold text-gray-800">${start}–${end}</span> of <span class="font-semibold text-gray-800">${totalItems}</span> ${name}`;
        }
    }

    summaryEl.innerHTML = text;
}

function renderPaginationButtons(totalPages) {
    const container = document.getElementById('paginationButtons');
    if (!container) return;

    const maxPages = Math.max(1, totalPages);
    let html = '';

    html += `<button onclick="goToPage(${currentPage - 1})" ${currentPage <= 1 ? 'disabled class="px-3.5 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50"' : 'class="px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all"'}>Prev</button>`;

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(maxPages, startPage + 4);
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
        if (startPage < 1) startPage = 1;
    }

    if (startPage > 1) {
        html += `<button onclick="goToPage(1)" class="px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all">1</button>`;
        if (startPage > 2) html += `<span class="px-2 text-gray-400 text-xs">...</span>`;
    }

    for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            html += `<button class="px-3.5 py-2 bg-primary text-white font-bold rounded-xl text-xs shadow-sm">${i}</button>`;
        } else {
            html += `<button onclick="goToPage(${i})" class="px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all">${i}</button>`;
        }
    }

    if (endPage < maxPages) {
        if (endPage < maxPages - 1) html += `<span class="px-2 text-gray-400 text-xs">...</span>`;
        html += `<button onclick="goToPage(${maxPages})" class="px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all">${maxPages}</button>`;
    }

    html += `<button onclick="goToPage(${currentPage + 1})" ${currentPage >= maxPages ? 'disabled class="px-3.5 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50"' : 'class="px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all"'}>Next</button>`;

    container.innerHTML = html;
}

function goToPage(page) {
    currentPage = page;
    const itemsPerPageSelect = document.getElementById("itemsPerPage");
    const itemsPerPage = itemsPerPageSelect ? itemsPerPageSelect.value : '12';
    updatePaginationUI(itemsPerPage);
    document.getElementById('articles-grid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', resetPaginationAndFilter);
    }
    filterArticles();
});
</script>

<?php include 'includes/footer.php'; ?>