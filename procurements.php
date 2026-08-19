<?php
$page_title = 'Procurements';
$pageTitle = 'Procurements - Ministry of Labour - Sri Lanka';
$metaDescription = 'Download important procurement plans, notices, tender documents, and contract award details from the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Procurements, Tenders, Bids, Notices, Contract Awards, Ministry of Labour, Sri Lanka';
include 'includes/header.php';
include 'includes/sub-hero.php';

require_once 'admin/includes/db.php';

// Fetch published procurements
$stmt = $pdo->query("SELECT * FROM procurements WHERE status = 'Published' ORDER BY created_at DESC");
$raw_procurements = $stmt->fetchAll();

$all_documents = [];
$categoryMapping = [
    'Plan' => 'Procurement Plan',
    'Notice' => 'Procurement Notice',
    'Award' => 'Contract Award Details'
];

$categoryColors = [
    'Procurement Plan' => 'bg-blue-50 text-blue-700 border-blue-100',
    'Procurement Notice' => 'bg-amber-50 text-amber-700 border-amber-100',
    'Contract Award Details' => 'bg-emerald-50 text-emerald-700 border-emerald-100'
];

foreach ($raw_procurements as $proc) {
    $rawCat = $proc['category'] ?? 'Notice';
    $userCat = $categoryMapping[$rawCat] ?? 'Procurement Notice';
    // Language-aware title fallback
    $proc_title = $proc['title'];
    if ($current_lang === 'si' && !empty($proc['title_si'])) $proc_title = $proc['title_si'];
    elseif ($current_lang === 'ta' && !empty($proc['title_ta'])) $proc_title = $proc['title_ta'];

    $pdf_en = !empty($proc['pdf_path']) ? resolvePdfUrl($proc['pdf_path']) : '';
    $pdf_si = !empty($proc['pdf_path_si']) ? resolvePdfUrl($proc['pdf_path_si']) : '';
    $pdf_ta = !empty($proc['pdf_path_ta']) ? resolvePdfUrl($proc['pdf_path_ta']) : '';

    // Pick best available PDF URL based on active language or available fallbacks
    $best_pdf = '';
    if ($current_lang === 'si' && !empty($pdf_si)) {
        $best_pdf = $pdf_si;
    } elseif ($current_lang === 'ta' && !empty($pdf_ta)) {
        $best_pdf = $pdf_ta;
    } elseif (!empty($pdf_en)) {
        $best_pdf = $pdf_en;
    } else {
        $best_pdf = $pdf_si ?: ($pdf_ta ?: '');
    }

    $all_documents[] = [
        'title' => $proc_title,
        'description' => $proc['description'] ?? '',
        'ref' => date('Y-m-d', strtotime($proc['created_at'])),
        'category' => $userCat,
        'pdf_path' => $pdf_en,
        'pdf_path_si' => $pdf_si,
        'pdf_path_ta' => $pdf_ta,
        'best_pdf' => $best_pdf,
        'created_at' => $proc['created_at']
    ];
}

$categories = [
    'Procurement Plan',
    'Procurement Notice',
    'Contract Award Details'
];
$preselected_category = isset($_GET['category']) ? $_GET['category'] : '';
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
                    <input type="text" id="searchInput" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full pl-11 pr-4 py-3 font-inter transition-all outline-none" placeholder="<?= t('search_procurements_placeholder', 'Search procurements by title or date...') ?>" onkeyup="resetPaginationAndFilter()">
                </div>
                
                <!-- Filters & Views -->
                <div class="flex flex-wrap sm:flex-nowrap gap-3 items-center">
                    
                    <!-- Category Filter -->
                    <div class="relative w-full sm:w-48">
                        <select id="categoryFilter" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="" <?= ($preselected_category === '') ? 'selected' : '' ?>><?= t('all_categories', 'All Categories') ?></option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>" <?= ($preselected_category === $cat) ? 'selected' : '' ?>><?= htmlspecialchars(translateCategory($cat)) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

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
        <div id="gridViewContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12" style="display: none;">
            <?php foreach ($all_documents as $index => $doc): 
                $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
            ?>
            <div class="document-card bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between cursor-pointer" data-index="<?= $index ?>" data-title="<?= htmlspecialchars(strtolower($doc['title'])) ?>" data-ref="<?= htmlspecialchars(strtolower($doc['ref'])) ?>" data-category="<?= htmlspecialchars(strtolower($doc['category'])) ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
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
                    <h3 class="font-bold text-gray-800 text-[15px] leading-snug mb-2 hover:text-secondary transition-colors group-hover:text-secondary"><?= htmlspecialchars($doc['title']) ?></h3>
                    <!-- Reference Date -->
                    <p class="text-xs text-gray-500 font-medium font-inter mb-6"><?= t('published', 'Published') ?>: <?= htmlspecialchars($doc['ref']) ?></p>
                </div>
                <!-- Action Button -->
                <?php if (!empty($doc['best_pdf'])): ?>
                <a href="<?= htmlspecialchars($doc['best_pdf']) ?>" target="_blank" class="download-btn w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-xl text-[13px] font-bold transition-all gap-2 shadow-sm" onclick="event.stopPropagation();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <?= t('download_document', 'Download Document') ?>
                </a>
                <?php else: ?>
                <button class="view-details-btn w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-50 text-gray-400 border border-gray-200 rounded-xl text-[13px] font-bold cursor-default" onclick="event.stopPropagation();" disabled>
                    <?= t('no_document_available', 'No Document Available') ?>
                </button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- List View Layout Container -->
        <div id="listViewContainer" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter">
                    <thead class="bg-gray-50/70 text-gray-600 border-b border-gray-100 notranslate">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-[13.5px]"><?= t('th_document_title', 'Document Title') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-48"><?= t('th_category', 'Category') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-40"><?= t('th_published_date', 'Published Date') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] text-right w-56"><?= t('th_action', 'Action') ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($all_documents as $index => $doc): 
                            $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                        ?>
                        <tr class="document-list-row hover:bg-gray-50/40 transition-all duration-150 cursor-pointer" data-index="<?= $index ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                            'title' => $doc['title'],
                            'content' => $doc['description'],
                            'date' => date('M d, Y', strtotime($doc['created_at'])),
                            'category' => translateCategory($doc['category']),
                            'pdf_path' => $doc['pdf_path'] ?? '',
                            'pdf_path_si' => $doc['pdf_path_si'] ?? '',
                            'pdf_path_ta' => $doc['pdf_path_ta'] ?? ''
                        ])) ?>)">
                            <td class="px-6 py-4">
                                <h3 class="font-bold text-gray-800 text-[14px] group-hover:text-secondary transition-colors"><?= htmlspecialchars($doc['title']) ?></h3>
                            </td>
                            <td class="px-6 py-4">
                                <span class="notranslate px-2.5 py-0.5 rounded-lg text-xs font-semibold border whitespace-nowrap <?= $badgeClass ?>"><?= htmlspecialchars(translateCategory($doc['category'])) ?></span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 font-medium font-inter">
                                <?= htmlspecialchars($doc['ref']) ?>
                            </td>
                            <td class="px-6 py-4 text-right" onclick="event.stopPropagation();">
                                <?php if (!empty($doc['best_pdf'])): ?>
                                <a href="<?= htmlspecialchars($doc['best_pdf']) ?>" target="_blank" class="list-download-btn inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-lg text-[12px] font-bold transition-all gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <?= t('download', 'Download') ?>
                                </a>
                                <?php else: ?>
                                <span class="list-no-doc text-xs text-gray-400 italic"><?= t('no_document', 'No Document') ?></span>
                                <?php endif; ?>
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
            <p class="text-[17px] font-bold text-gray-800 mb-1"><?= t('no_documents_found', 'No documents matched your search') ?></p>
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
let currentPage = 1;
let currentView = 'list'; // 'grid' or 'list'
let filteredIndexes = [];

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
    
    // Toggle active state on buttons
    const btnGrid = document.getElementById('btnGridView');
    const btnList = document.getElementById('btnListView');
    const gridContainer = document.getElementById('gridViewContainer');
    const listContainer = document.getElementById('listViewContainer');
    
    if (view === 'grid') {
        btnGrid.classList.add('bg-white', 'text-secondary', 'shadow-sm');
        btnGrid.classList.remove('text-gray-500');
        btnList.classList.remove('bg-white', 'text-secondary', 'shadow-sm');
        btnList.classList.add('text-gray-500');
        
        gridContainer.style.display = 'grid';
        listContainer.style.display = 'none';
    } else {
        btnList.classList.add('bg-white', 'text-secondary', 'shadow-sm');
        btnList.classList.remove('text-gray-500');
        btnGrid.classList.remove('bg-white', 'text-secondary', 'shadow-sm');
        btnGrid.classList.add('text-gray-500');
        
        listContainer.style.display = 'block';
        gridContainer.style.display = 'none';
    }
    
    filterTable();
}

function resetPaginationAndFilter() {
    currentPage = 1;
    filterTable();
}

function filterTable() {
    const searchInput = document.getElementById("searchInput").value.toLowerCase().trim();
    const categoryFilter = document.getElementById("categoryFilter").value.toLowerCase();
    const itemsPerPage = document.getElementById("itemsPerPage").value;
    
    // Filter matching item indexes
    filteredIndexes = [];
    documents.forEach(doc => {
        const gridCard = document.querySelector(`.document-card[data-index="${doc.index}"]`);
        const titleEl = gridCard ? gridCard.querySelector('h3') : null;
        const visibleTitle = titleEl ? titleEl.textContent.toLowerCase() : doc.title;
        
        const matchesSearch = searchInput === "" || 
                              visibleTitle.includes(searchInput) || 
                              doc.ref.includes(searchInput);
                              
        const matchesCategory = categoryFilter === "" || 
                                doc.category === categoryFilter;
                                
        if (matchesSearch && matchesCategory) {
            filteredIndexes.push(doc.index);
        }
    });
    
    // Hide all items (both grid cards and list rows)
    document.querySelectorAll('.document-card').forEach(card => card.classList.add('hidden'));
    document.querySelectorAll('.document-list-row').forEach(row => row.classList.add('hidden'));
    
    updatePaginationUI(itemsPerPage);
}

function updatePaginationUI(itemsPerPage) {
    const noResultsMsg = document.getElementById('noResultsMsg');
    const gridContainer = document.getElementById('gridViewContainer');
    const listViewContainer = document.getElementById('listViewContainer');
    const paginationControls = document.getElementById('paginationControls');
    
    const totalItems = filteredIndexes.length;
    
    if (totalItems === 0) {
        noResultsMsg.style.display = 'flex';
        gridContainer.style.display = 'none';
        listViewContainer.style.display = 'none';
        paginationControls.style.display = 'none';
        return;
    }
    
    noResultsMsg.style.display = 'none';
    if (currentView === 'grid') {
        gridContainer.style.display = 'grid';
    } else {
        listViewContainer.style.display = 'block';
    }
    
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
    paginationControls.style.display = 'flex';
    
    // Show only active items for this page depending on the current view
    const selector = currentView === 'grid' ? '.document-card' : '.document-list-row';
    const items = document.querySelectorAll(selector);
    
    for (let i = startIdx; i < endIdx; i++) {
        const itemIdx = filteredIndexes[i];
        // Find element matching this index
        const el = Array.from(items).find(item => parseInt(item.getAttribute('data-index')) === itemIdx);
        if (el) {
            el.classList.remove('hidden');
        }
    }
    
    // Update summary text
    updatePaginationSummary(startIdx, endIdx, totalItems, 'documents');
}

function updatePaginationSummary(startIdx, endIdx, totalItems, entityType = 'documents') {
    const summaryEl = document.getElementById('paginationSummary') || document.querySelector('#paginationControls .text-sm');
    if (!summaryEl) return;

    const start = startIdx + 1;
    const end = endIdx;
    const lang = document.documentElement.lang || 'en';

    const entityNames = {
        documents: { en: 'documents', si: 'ලේඛන', ta: 'ஆவணங்கள்' },
        vacancies: { en: 'vacancies', si: 'පුරප්පාඩු', ta: 'வெற்றிடங்கள்' },
        notices: { en: 'notices', si: 'නිවේදන', ta: 'அறிவிப்புகள்' },
        updates: { en: 'updates', si: 'යාවත්කාලීන', ta: 'புதுப்பிப்புகள்' },
        publications: { en: 'publications', si: 'ප්‍රකාශන', ta: 'வெளியீடுகள்' }
    };

    const entity = entityNames[entityType] || entityNames.documents;
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
        const singularName = entityType === 'vacancies' ? 'vacancy' : (entityType === 'notices' ? 'notice' : (entityType === 'updates' ? 'update' : (entityType === 'publications' ? 'publication' : 'document')));
        if (totalItems === 1) {
            text = `Showing 1 ${singularName}`;
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
    let html = '';
    
    // Prev Button
    html += `<button onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled class="px-3.5 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50"' : 'class="px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all"'}>` + '<?= t("pagination_prev", "Prev") ?>' + `</button>`;
    
    // Numbers
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }
    
    if (startPage > 1) {
        html += `<button onclick="goToPage(1)" class="px-3 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all">1</button>`;
        if (startPage > 2) html += `<span class="px-1.5 text-gray-400 text-xs">...</span>`;
    }
    
    for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            html += `<button class="px-3 py-2 border border-secondary bg-secondary text-white font-bold rounded-xl text-xs">${i}</button>`;
        } else {
            html += `<button onclick="goToPage(${i})" class="px-3 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all">${i}</button>`;
        }
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) html += `<span class="px-1.5 text-gray-400 text-xs">...</span>`;
        html += `<button onclick="goToPage(${totalPages})" class="px-3 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all">${totalPages}</button>`;
    }
    
    // Next Button
    html += `<button onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled class="px-3 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50"' : 'class="px-3 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all"'}>` + '<?= t("pagination_next", "Next") ?>' + `</button>`;
    
    container.innerHTML = html;
}

function goToPage(page) {
    currentPage = page;
    
    // Hide all currently visible
    document.querySelectorAll('.document-card').forEach(card => card.classList.add('hidden'));
    document.querySelectorAll('.document-list-row').forEach(row => row.classList.add('hidden'));
    
    const itemsPerPage = document.getElementById("itemsPerPage").value;
    updatePaginationUI(itemsPerPage);
}

// Init page
document.addEventListener('DOMContentLoaded', () => {
    changeView('list');
});
</script>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
