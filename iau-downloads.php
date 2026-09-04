<?php
$page_title = 'IAU Downloads';
$pageTitle = 'IAU Downloads - Ministry of Labour - Sri Lanka';
$metaDescription = 'Download all current documents and notices from the Internal Affairs Unit (IAU) of the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'IAU, Internal Affairs Unit, Downloads, Notices, Ministry of Labour, Sri Lanka';
include 'includes/header.php';
$breadcrumbs = [
    ['label' => t('iau', 'IAU'), 'url' => 'iau'],
    ['label' => t('downloads', 'Downloads')]
];
include 'includes/sub-hero.php';

require_once 'admin/includes/db.php';

// Fetch published IAU downloads
$stmt = $pdo->query("SELECT * FROM iau_downloads WHERE status = 'Published' ORDER BY created_at DESC");
$raw_updates = $stmt->fetchAll();

$all_documents = [];
$categoryColors = [
    'IAU Update' => 'bg-teal-50 text-teal-700 border-teal-100'
];

foreach ($raw_updates as $update) {
    // Language-aware title fallback
    $update_title = $update['title'];
    if ($current_lang === 'si' && !empty($update['title_si'])) $update_title = $update['title_si'];
    elseif ($current_lang === 'ta' && !empty($update['title_ta'])) $update_title = $update['title_ta'];

    // Language-aware content/description fallback
    $update_desc = $update['content'];
    if ($current_lang === 'si' && !empty($update['content_si'])) $update_desc = $update['content_si'];
    elseif ($current_lang === 'ta' && !empty($update['content_ta'])) $update_desc = $update['content_ta'];

    $all_documents[] = [
        'title' => $update_title,
        'description' => $update_desc ?? '',
        'ref' => date('Y-m-d', strtotime($update['created_at'])),
        'category' => 'IAU Update',
        'pdf_path' => !empty($update['pdf_path']) ? resolvePdfUrl($update['pdf_path']) : '',
        'pdf_path_si' => !empty($update['pdf_path_si']) ? resolvePdfUrl($update['pdf_path_si']) : '',
        'pdf_path_ta' => !empty($update['pdf_path_ta']) ? resolvePdfUrl($update['pdf_path_ta']) : '',
        'created_at' => $update['created_at']
    ];
}
?>

<section class="py-12 md:py-16 px-4 md:px-16 bg-[#F9FAFB] min-h-[75vh]">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Controls Bar -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 notranslate">
            <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
                
                <!-- Search -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="searchInput" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full pl-11 pr-4 py-3 font-inter transition-all outline-none" placeholder="<?= t('search_downloads_placeholder', 'Search IAU downloads by title or date...') ?>" onkeyup="resetPaginationAndFilter()">
                </div>
                
                <!-- Filters & Views -->
                <div class="flex flex-wrap sm:flex-nowrap gap-3 items-center">
                    
                    <!-- Items per page -->
                    <div class="relative w-full sm:w-36">
                        <select id="itemsPerPage" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="12">12 <?= t('per_page_label', 'per page') ?></option>
                            <option value="24">24 <?= t('per_page_label', 'per page') ?></option>
                            <option value="48">48 <?= t('per_page_label', 'per page') ?></option>
                            <option value="all"><?= t('show_all', 'Show All') ?></option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <!-- Language Filter -->
                    <div class="relative w-full sm:w-40">
                        <select id="langFilter" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="en" <?= $current_lang === 'en' ? 'selected' : '' ?>><?= t('pdf_english', 'English PDF') ?></option>
                            <option value="si" <?= $current_lang === 'si' ? 'selected' : '' ?>><?= t('pdf_sinhala', 'Sinhala PDF') ?></option>
                            <option value="ta" <?= $current_lang === 'ta' ? 'selected' : '' ?>><?= t('pdf_tamil', 'Tamil PDF') ?></option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <!-- View Toggle -->
                    <div class="bg-gray-100 p-1 rounded-xl flex items-center shrink-0">
                        <button onclick="changeView('grid')" id="btnGridView" class="p-2 rounded-lg text-gray-500 hover:text-gray-900 transition-all focus:outline-none" title="Grid View">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </button>
                        <button onclick="changeView('list')" id="btnListView" class="p-2 rounded-lg text-gray-500 hover:text-gray-900 transition-all focus:outline-none" title="List View">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Grid View Layout Container -->
        <div id="gridViewContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 notranslate" translate="no" style="display: none;">
            <?php foreach ($all_documents as $index => $doc): 
                $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
            ?>
            <div class="document-card bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between cursor-pointer notranslate" translate="no" data-index="<?= $index ?>" data-title="<?= htmlspecialchars(strtolower($doc['title'])) ?>" data-ref="<?= htmlspecialchars(strtolower($doc['ref'])) ?>" data-category="<?= htmlspecialchars(strtolower($doc['category'])) ?>" data-pdf-en="<?= htmlspecialchars($doc['pdf_path'] ?? '') ?>" data-pdf-si="<?= htmlspecialchars($doc['pdf_path_si'] ?? '') ?>" data-pdf-ta="<?= htmlspecialchars($doc['pdf_path_ta'] ?? '') ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                'title' => $doc['title'],
                'content' => $doc['description'],
                'date' => date('M d, Y', strtotime($doc['created_at'])),
                'category' => translateCategory($doc['category']),
                'pdf_path' => $doc['pdf_path'] ?? '',
                'pdf_path_si' => $doc['pdf_path_si'] ?? '',
                'pdf_path_ta' => $doc['pdf_path_ta'] ?? ''
            ])) ?>)">
                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="notranslate px-2.5 py-1 rounded-lg text-xs font-semibold border whitespace-nowrap <?= $badgeClass ?>"><?= htmlspecialchars(translateCategory($doc['category'])) ?></span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <!-- Title -->
                    <h3 class="font-bold text-gray-800 text-[15px] leading-snug mb-2 hover:text-secondary transition-colors group-hover:text-secondary notranslate" translate="no"><?= htmlspecialchars($doc['title']) ?></h3>
                    <!-- Reference Date -->
                    <p class="text-xs text-gray-500 font-medium font-inter mb-6 notranslate"><?= t('published_label', 'Published:') ?> <?= htmlspecialchars($doc['ref']) ?></p>
                </div>
                <!-- Action Button -->
                <a href="#" target="_blank" class="download-btn w-full items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-xl text-[13px] font-bold transition-all gap-2 shadow-sm hidden notranslate" onclick="event.stopPropagation();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <?= t('download_document', 'Download Document') ?>
                </a>
                <button type="button" class="view-details-btn w-full items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-xl text-[13px] font-bold transition-all cursor-pointer hidden notranslate">
                    <?= t('view_details', 'View Details') ?>
                </button>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- List View Layout Container -->
        <div id="listViewContainer" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12 notranslate" translate="no">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter notranslate" translate="no">
                    <thead class="bg-gray-50/70 text-gray-600 border-b border-gray-100 notranslate" translate="no">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-[13.5px] notranslate"><?= t('th_document_title', 'Document Title') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-48 notranslate"><?= t('th_category', 'Category') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-40 notranslate"><?= t('th_published_date', 'Published Date') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] text-right w-56 notranslate"><?= t('th_action', 'Action') ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 notranslate" translate="no">
                        <?php foreach ($all_documents as $index => $doc): 
                            $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                        ?>
                        <tr class="document-list-row hover:bg-gray-50/40 transition-all duration-150 cursor-pointer notranslate" translate="no" data-index="<?= $index ?>" data-pdf-en="<?= htmlspecialchars($doc['pdf_path'] ?? '') ?>" data-pdf-si="<?= htmlspecialchars($doc['pdf_path_si'] ?? '') ?>" data-pdf-ta="<?= htmlspecialchars($doc['pdf_path_ta'] ?? '') ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                            'title' => $doc['title'],
                            'content' => $doc['description'],
                            'date' => date('M d, Y', strtotime($doc['created_at'])),
                            'category' => translateCategory($doc['category']),
                            'pdf_path' => $doc['pdf_path'] ?? '',
                            'pdf_path_si' => $doc['pdf_path_si'] ?? '',
                            'pdf_path_ta' => $doc['pdf_path_ta'] ?? ''
                        ])) ?>)">
                            <td class="px-6 py-4 notranslate">
                                <h3 class="font-bold text-gray-800 text-[14px] group-hover:text-secondary transition-colors notranslate" translate="no"><?= htmlspecialchars($doc['title']) ?></h3>
                            </td>
                            <td class="px-6 py-4 notranslate">
                                <span class="notranslate px-2.5 py-0.5 rounded-lg text-xs font-semibold border whitespace-nowrap <?= $badgeClass ?>"><?= htmlspecialchars(translateCategory($doc['category'])) ?></span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 font-medium font-inter notranslate">
                                <?= htmlspecialchars($doc['ref']) ?>
                            </td>
                            <td class="px-6 py-4 text-right notranslate">
                                <a href="#" target="_blank" class="list-download-btn items-center px-4 py-2 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-lg text-[12px] font-bold transition-all gap-1.5 shadow-sm hidden notranslate" onclick="event.stopPropagation();">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <?= t('download', 'Download') ?>
                                </a>
                                <span class="list-no-doc text-xs text-gray-400 italic hidden notranslate"><?= t('view_details', 'View Details') ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Results State -->
        <div id="noResultsMsg" class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm text-center text-gray-500 mb-12 notranslate" style="display: none;">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-[17px] font-bold text-gray-800 mb-1"><?= t('no_downloads_found', 'No downloads matched your search') ?></p>
            <p class="text-sm text-gray-400"><?= t('try_adjusting_filters', 'Try adjusting your filters or search keywords') ?></p>
        </div>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 notranslate" style="display: none;">
            <div class="text-sm text-gray-500 font-inter" id="paginationSummary">
                <!-- Dynamic user-friendly pagination summary -->
            </div>
            <div class="flex items-center gap-1.5" id="paginationButtons">
                <!-- Pagination buttons will be injected here -->
            </div>
        </div>

    </div>
</section>

<script>
let iauDownloadsPaginator;
let currentView = 'list';

// Capture all documents from PHP
const documents = <?php echo json_encode(array_map(function($doc, $i) {
    return [
        'index' => $i,
        'title' => strtolower($doc['title']),
        'ref' => strtolower($doc['ref']),
        'category' => strtolower($doc['category'])
    ];
}, $all_documents, array_keys($all_documents))); ?>;

function changeView(view) {
    currentView = view;
    
    const btnGrid = document.getElementById('btnGridView');
    const btnList = document.getElementById('btnListView');
    
    if (view === 'grid') {
        btnGrid?.classList.add('bg-white', 'text-secondary', 'shadow-sm');
        btnGrid?.classList.remove('text-gray-500');
        btnList?.classList.remove('bg-white', 'text-secondary', 'shadow-sm');
        btnList?.classList.add('text-gray-500');
    } else {
        btnList?.classList.add('bg-white', 'text-secondary', 'shadow-sm');
        btnList?.classList.remove('text-gray-500');
        btnGrid?.classList.remove('bg-white', 'text-secondary', 'shadow-sm');
        btnGrid?.classList.add('text-gray-500');
    }
    
    if (iauDownloadsPaginator) {
        iauDownloadsPaginator.setView(view);
    }
}

function resetPaginationAndFilter() {
    filterTable();
}

function filterTable() {
    const searchInput = document.getElementById("searchInput") ? document.getElementById("searchInput").value.toLowerCase().trim() : '';
    const lang = document.getElementById("langFilter") ? document.getElementById("langFilter").value : 'en';
    
    const filteredIndexes = [];
    documents.forEach(doc => {
        const gridCard = document.querySelector(`.document-card[data-index="${doc.index}"]`);
        const titleEl = gridCard ? gridCard.querySelector('h3') : null;
        const visibleTitle = titleEl ? titleEl.textContent.toLowerCase() : doc.title;
        
        const matchesSearch = searchInput === "" || 
                              visibleTitle.includes(searchInput) || 
                              doc.ref.includes(searchInput);
                                
        if (matchesSearch) {
            filteredIndexes.push(doc.index);
        }
    });
    
    updateDownloadLinks(lang);
    if (iauDownloadsPaginator) {
        iauDownloadsPaginator.setFilteredIndexes(filteredIndexes);
    }
}

function updateDownloadLinks(lang) {
    document.querySelectorAll('.document-card').forEach(card => {
        const btn = card.querySelector('.download-btn');
        const fallback = card.querySelector('.view-details-btn');
        const pdfUrl = card.getAttribute(`data-pdf-${lang}`);
        
        if (pdfUrl) {
            btn?.classList.remove('hidden');
            btn?.classList.add('inline-flex');
            if (btn) btn.href = pdfUrl;
            fallback?.classList.add('hidden');
            fallback?.classList.remove('inline-flex');
        } else {
            btn?.classList.add('hidden');
            btn?.classList.remove('inline-flex');
            fallback?.classList.remove('hidden');
            fallback?.classList.add('inline-flex');
        }
    });

    document.querySelectorAll('.document-list-row').forEach(row => {
        const btn = row.querySelector('.list-download-btn');
        const fallback = row.querySelector('.list-no-doc');
        const pdfUrl = row.getAttribute(`data-pdf-${lang}`);
        
        if (pdfUrl) {
            btn?.classList.remove('hidden');
            btn?.classList.add('inline-flex');
            if (btn) btn.href = pdfUrl;
            fallback?.classList.add('hidden');
        } else {
            btn?.classList.add('hidden');
            btn?.classList.remove('inline-flex');
            fallback?.classList.remove('hidden');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    iauDownloadsPaginator = new ContentPaginator({
        items: documents,
        entityType: 'downloads',
        itemSelectors: ['.document-card', '.document-list-row'],
        gridContainerId: 'gridViewContainer',
        listContainerId: 'listViewContainer',
        currentView: 'list',
        defaultItemsPerPage: 12
    });

    changeView('list');
    filterTable();
});
</script>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
