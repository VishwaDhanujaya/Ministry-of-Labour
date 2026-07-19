<?php
$page_title = 'Foreign Publications';
$pageTitle = 'Foreign Publications - Ministry of Labour - Sri Lanka';
$metaDescription = 'Download important foreign learning resources, reports, and documents from the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Foreign Learning Platforms, Reports, Documents, Ministry of Labour, Sri Lanka';
$breadcrumbs = [
    ['label' => 'Learning Platforms', 'url' => 'learning-platforms'],
    ['label' => 'Foreign Publications']
];
include 'includes/header.php';
include 'includes/sub-hero.php';

require_once 'admin/includes/db.php';

// Fetch published learning_platforms_foreign
$stmt = $pdo->query("SELECT * FROM learning_platforms_foreign WHERE status = 'Published' ORDER BY created_at DESC");
$raw_pubs = $stmt->fetchAll();

$all_documents = [];
$categoryColors = [
    'Foreign Publication' => 'bg-rose-50 text-rose-700 border-rose-100'
];

foreach ($raw_pubs as $pub) {
    $all_documents[] = [
        'title' => $pub['title'],
        'description' => $pub['description'] ?? '',
        'ref' => date('Y-m-d', strtotime($pub['created_at'])),
        'category' => 'Foreign Publication',
        'pdf_path' => !empty($pub['pdf_path']) ? resolvePdfUrl($pub['pdf_path']) : '',
        'pdf_path_si' => !empty($pub['pdf_path_si']) ? resolvePdfUrl($pub['pdf_path_si']) : '',
        'pdf_path_ta' => !empty($pub['pdf_path_ta']) ? resolvePdfUrl($pub['pdf_path_ta']) : '',
        'created_at' => $pub['created_at']
    ];
}
?>

<section class="py-12 md:py-16 px-4 md:px-16 bg-[#F9FAFB] min-h-[75vh]">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Controls Bar -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
                
                <!-- Search -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="searchInput" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full pl-11 pr-4 py-3 font-inter transition-all outline-none" placeholder="Search foreign publications by title or date..." onkeyup="resetPaginationAndFilter()">
                </div>
                
                <!-- Filters & Views -->
                <div class="flex flex-wrap sm:flex-nowrap gap-3 items-center">
                    
                    <!-- Items per page -->
                    <div class="relative w-full sm:w-36">
                        <select id="itemsPerPage" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="12">12 per page</option>
                            <option value="24">24 per page</option>
                            <option value="48">48 per page</option>
                            <option value="all">Show All</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <!-- Language Filter -->
                    <div class="relative w-full sm:w-40">
                        <select id="langFilter" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="en">English PDF</option>
                            <option value="si">Sinhala PDF</option>
                            <option value="ta">Tamil PDF</option>
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
        <div id="gridViewContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8" style="display: none;">
            <?php foreach ($all_documents as $index => $doc): 
                $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
            ?>
            <div class="document-card bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between cursor-pointer" data-index="<?= $index ?>" data-title="<?= htmlspecialchars(strtolower($doc['title'])) ?>" data-ref="<?= htmlspecialchars(strtolower($doc['ref'])) ?>" data-category="<?= htmlspecialchars(strtolower($doc['category'])) ?>" data-pdf-en="<?= htmlspecialchars($doc['pdf_path'] ?? '') ?>" data-pdf-si="<?= htmlspecialchars($doc['pdf_path_si'] ?? '') ?>" data-pdf-ta="<?= htmlspecialchars($doc['pdf_path_ta'] ?? '') ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                'title' => $doc['title'],
                'content' => $doc['description'],
                'date' => date('M d, Y', strtotime($doc['created_at'])),
                'category' => $doc['category'],
                'pdf_path' => $doc['pdf_path'] ?? '',
                'pdf_path_si' => $doc['pdf_path_si'] ?? '',
                'pdf_path_ta' => $doc['pdf_path_ta'] ?? ''
            ])) ?>)">
                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold border whitespace-nowrap <?= $badgeClass ?>"><?= htmlspecialchars($doc['category']) ?></span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <!-- Title -->
                    <h3 class="font-bold text-gray-800 text-[15px] leading-snug mb-2 hover:text-secondary transition-colors group-hover:text-secondary"><?= htmlspecialchars($doc['title']) ?></h3>
                    <!-- Reference Date -->
                    <p class="text-xs text-gray-500 font-medium font-inter mb-6">Published: <?= htmlspecialchars($doc['ref']) ?></p>
                </div>
                <!-- Action Button -->
                <a href="#" target="_blank" class="download-btn w-full items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-xl text-[13px] font-bold transition-all gap-2 shadow-sm hidden" onclick="event.stopPropagation();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Document
                </a>
                <button class="view-details-btn w-full items-center justify-center px-4 py-2.5 bg-gray-50 text-gray-450 border border-gray-200 text-gray-500 rounded-xl text-[13px] font-bold cursor-default hidden" onclick="event.stopPropagation();">
                    View Details
                </button>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- List View Layout Container -->
        <div id="listViewContainer" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter">
                    <thead class="bg-gray-50/70 text-gray-600 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-[13.5px]">Document Title</th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-48">Category</th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-40">Published Date</th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] text-right w-56">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($all_documents as $index => $doc): 
                            $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                        ?>
                        <tr class="document-list-row hover:bg-gray-50/40 transition-all duration-150 cursor-pointer" data-index="<?= $index ?>" data-pdf-en="<?= htmlspecialchars($doc['pdf_path'] ?? '') ?>" data-pdf-si="<?= htmlspecialchars($doc['pdf_path_si'] ?? '') ?>" data-pdf-ta="<?= htmlspecialchars($doc['pdf_path_ta'] ?? '') ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                            'title' => $doc['title'],
                            'content' => $doc['description'],
                            'date' => date('M d, Y', strtotime($doc['created_at'])),
                            'category' => $doc['category'],
                            'pdf_path' => $doc['pdf_path'] ?? '',
                            'pdf_path_si' => $doc['pdf_path_si'] ?? '',
                            'pdf_path_ta' => $doc['pdf_path_ta'] ?? ''
                        ])) ?>)">
                            <td class="px-6 py-4">
                                <h3 class="font-bold text-gray-800 text-[14px] group-hover:text-secondary transition-colors"><?= htmlspecialchars($doc['title']) ?></h3>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-lg text-xs font-semibold border whitespace-nowrap <?= $badgeClass ?>"><?= htmlspecialchars($doc['category']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 font-medium font-inter">
                                <?= htmlspecialchars($doc['ref']) ?>
                            </td>
                            <td class="px-6 py-4 text-right" onclick="event.stopPropagation();">
                                <a href="#" target="_blank" class="list-download-btn items-center px-4 py-2 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-lg text-[12px] font-bold transition-all gap-1.5 shadow-sm hidden">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download
                                </a>
                                <span class="list-no-doc text-xs text-gray-400 italic hidden">No Document</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Results State -->
        <div id="noResultsMsg" class="flex flex-col items-center justify-center py-16 px-4 bg-white rounded-3xl border border-gray-100 shadow-sm" style="display: none;">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-[17px] font-bold text-gray-800 mb-1">No publications matched your search</p>
            <p class="text-sm text-gray-400">Try adjusting your filters or search keywords</p>
        </div>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4" style="display: none;">
            <div class="text-sm text-gray-500 font-inter">
                Showing <span id="pageStart" class="font-semibold text-gray-800">0</span> to <span id="pageEnd" class="font-semibold text-gray-800">0</span> of <span id="totalItems" class="font-semibold text-gray-800">0</span> documents
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
        'category' => strtolower($doc['category']),
        'has_en' => !empty($doc['pdf_path']),
        'has_si' => !empty($doc['pdf_path_si']),
        'has_ta' => !empty($doc['pdf_path_ta'])
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
    const itemsPerPage = document.getElementById("itemsPerPage").value;
    const lang = document.getElementById("langFilter").value;
    
    // Filter matching item indexes
    filteredIndexes = [];
    documents.forEach(doc => {
        const matchesSearch = searchInput === "" || 
                              doc.title.includes(searchInput) || 
                              doc.ref.includes(searchInput);
                                
        if (matchesSearch) {
            filteredIndexes.push(doc.index);
        }
    });
    
    // Hide all items (both grid cards and list rows)
    document.querySelectorAll('.document-card').forEach(card => card.classList.add('hidden'));
    document.querySelectorAll('.document-list-row').forEach(row => row.classList.add('hidden'));
    
    // Update links based on selected language
    updateDownloadLinks(lang);
    
    updatePaginationUI(itemsPerPage);
}

function updateDownloadLinks(lang) {
    document.querySelectorAll('.document-card').forEach(card => {
        const btn = card.querySelector('.download-btn');
        const fallback = card.querySelector('.view-details-btn');
        const pdfUrl = card.getAttribute(`data-pdf-${lang}`);
        
        if (pdfUrl) {
            btn.href = pdfUrl;
            btn.classList.remove('hidden');
            btn.classList.add('inline-flex');
            fallback.classList.add('hidden');
            fallback.classList.remove('inline-flex');
        } else {
            btn.classList.add('hidden');
            btn.classList.remove('inline-flex');
            fallback.classList.remove('hidden');
            fallback.classList.add('inline-flex');
        }
    });

    document.querySelectorAll('.document-list-row').forEach(row => {
        const btn = row.querySelector('.list-download-btn');
        const fallback = row.querySelector('.list-no-doc');
        const pdfUrl = row.getAttribute(`data-pdf-${lang}`);
        
        if (pdfUrl) {
            btn.href = pdfUrl;
            btn.classList.remove('hidden');
            btn.classList.add('inline-flex');
            fallback.classList.add('hidden');
        } else {
            btn.classList.add('hidden');
            btn.classList.remove('inline-flex');
            fallback.classList.remove('hidden');
        }
    });
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
        paginationControls.style.display = 'flex';
    } else {
        paginationControls.style.display = 'none';
    }
    
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
    
    // Update labels
    if (itemsPerPage !== 'all') {
        document.getElementById('pageStart').innerText = startIdx + 1;
        document.getElementById('pageEnd').innerText = endIdx;
        document.getElementById('totalItems').innerText = totalItems;
    }
}

function renderPaginationButtons(totalPages) {
    const container = document.getElementById('paginationButtons');
    let html = '';
    
    // Prev Button
    html += `<button onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled class="px-3.5 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50"' : 'class="px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all"'}>Prev</button>`;
    
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
    html += `<button onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled class="px-3 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50"' : 'class="px-3 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all"'}>Next</button>`;
    
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
