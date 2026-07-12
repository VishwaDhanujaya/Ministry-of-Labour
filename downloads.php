<?php
// downloads.php
require_once 'admin/includes/db.php';

$page_title = 'Downloads';
$pageTitle = 'Downloads - Documents, Acts & Amendments - Ministry of Labour - Sri Lanka';
$metaDescription = 'Download Documents, Acts and Amendments of the Ministry of Labour in Sinhala, Tamil, and English.';
$metaKeywords = 'Downloads, Acts, Amendments, Procurements, Vacancies, Publications, Ministry of Labour, Sri Lanka';

include 'includes/header.php';
include 'includes/sub-hero.php';

$all_documents = [];

try {
    // Fetch Acts and Amendments
    $stmt = $pdo->query("SELECT title, ref, category, created_at, pdf_path FROM acts_amendments WHERE status = 'Published' AND pdf_path != '' AND pdf_path IS NOT NULL");
    while ($row = $stmt->fetch()) {
        $row['ref'] = !empty($row['ref']) ? $row['ref'] : date('Y-m-d', strtotime($row['created_at']));
        $row['pdf_path'] = resolvePdfUrl($row['pdf_path']);
        $all_documents[] = $row;
    }

    // Fetch Procurements
    $stmt = $pdo->query("SELECT title, created_at as ref, pdf_path FROM procurements WHERE pdf_path != '' AND pdf_path IS NOT NULL");
    while ($row = $stmt->fetch()) {
        $row['category'] = 'Procurements';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = resolvePdfUrl($row['pdf_path']);
        $all_documents[] = $row;
    }

    // Fetch Vacancies
    $stmt = $pdo->query("SELECT title, created_at as ref, pdf_path FROM vacancies WHERE pdf_path != '' AND pdf_path IS NOT NULL");
    while ($row = $stmt->fetch()) {
        $row['category'] = 'Vacancies';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = resolvePdfUrl($row['pdf_path']);
        $all_documents[] = $row;
    }

    // Fetch Local Publications
    $stmt = $pdo->query("SELECT title, created_at as ref, pdf_path FROM learning_platforms_local WHERE pdf_path != '' AND pdf_path IS NOT NULL");
    while ($row = $stmt->fetch()) {
        $row['category'] = 'Local Publications';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = resolvePdfUrl($row['pdf_path']);
        $all_documents[] = $row;
    }

    // Fetch Foreign Publications
    $stmt = $pdo->query("SELECT title, created_at as ref, pdf_path FROM learning_platforms_foreign WHERE pdf_path != '' AND pdf_path IS NOT NULL");
    while ($row = $stmt->fetch()) {
        $row['category'] = 'Foreign Publications';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = resolvePdfUrl($row['pdf_path']);
        $all_documents[] = $row;
    }
} catch (PDOException $e) {
    // Silently continue
}

$categories = array_unique(array_column($all_documents, 'category'));

$categoryColors = [
    'Acts' => 'bg-blue-50 text-blue-700 border-blue-100',
    'Amendments' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
    'Procurements' => 'bg-amber-50 text-amber-700 border-amber-100',
    'Vacancies' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
    'Local Publications' => 'bg-purple-50 text-purple-700 border-purple-100',
    'Foreign Publications' => 'bg-rose-50 text-rose-700 border-rose-100'
];
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
                    <input type="text" id="searchInput" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full pl-11 pr-4 py-3 font-inter transition-all outline-none" placeholder="Search documents by title or reference..." onkeyup="resetPaginationAndFilter()">
                </div>
                
                <!-- Filters & Views -->
                <div class="flex flex-wrap sm:flex-nowrap gap-3 items-center">
                    
                    <!-- Category -->
                    <div class="relative w-full sm:w-48">
                        <select id="categoryFilter" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

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
        <div id="gridViewContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php foreach ($all_documents as $index => $doc): 
                $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
            ?>
            <div class="document-card bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between cursor-pointer" data-index="<?= $index ?>" data-title="<?= htmlspecialchars(strtolower($doc['title'])) ?>" data-ref="<?= htmlspecialchars(strtolower($doc['ref'])) ?>" data-category="<?= htmlspecialchars(strtolower($doc['category'])) ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                'title' => $doc['title'],
                'content' => '<p class=\'text-gray-500 font-medium\'>Reference ID / Code: <span class=\'font-semibold text-gray-800 font-inter\'>' . htmlspecialchars($doc['ref']) . '</span></p>',
                'date' => date('M d, Y', strtotime($doc['created_at'] ?? $doc['ref'])),
                'category' => $doc['category'],
                'pdf_path' => $doc['pdf_path'] ?? ''
            ])) ?>)">
                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold border whitespace-nowrap <?= $badgeClass ?>"><?= htmlspecialchars($doc['category']) ?></span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <!-- Title -->
                    <h3 class="font-bold text-gray-800 text-[15px] leading-snug mb-2 hover:text-[#4E0000] transition-colors group-hover:text-secondary"><?= htmlspecialchars($doc['title']) ?></h3>
                    <!-- Reference -->
                    <p class="text-xs text-gray-500 font-medium font-inter mb-6">Ref: <?= htmlspecialchars($doc['ref']) ?></p>
                </div>
                <!-- Action Button -->
                <a href="<?= htmlspecialchars($doc['pdf_path'] ?? '#') ?>" <?php if(($doc['pdf_path'] ?? '#') !== '#') echo 'target="_blank"'; ?> class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-xl text-[13px] font-bold transition-all gap-2 shadow-sm" onclick="event.stopPropagation();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Document
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- List View Layout Container -->
        <div id="listViewContainer" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12 hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter">
                    <thead class="bg-gray-50/70 text-gray-600 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-[13.5px]">Document Title</th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-40">Category</th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-48">Reference</th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] text-right w-56">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($all_documents as $index => $doc): 
                            $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                        ?>
                        <tr class="document-list-row hover:bg-gray-50/40 transition-all duration-150 cursor-pointer" data-index="<?= $index ?>" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                            'title' => $doc['title'],
                            'content' => '<p class=\'text-gray-500 font-medium\'>Reference ID / Code: <span class=\'font-semibold text-gray-800 font-inter\'>' . htmlspecialchars($doc['ref']) . '</span></p>',
                            'date' => date('M d, Y', strtotime($doc['created_at'] ?? $doc['ref'])),
                            'category' => $doc['category'],
                            'pdf_path' => $doc['pdf_path'] ?? ''
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
                                <a href="<?= htmlspecialchars($doc['pdf_path'] ?? '#') ?>" <?php if(($doc['pdf_path'] ?? '#') !== '#') echo 'target="_blank"'; ?> class="inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-lg text-[12px] font-bold transition-all gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Results State -->
        <div id="noResultsMsg" class="hidden py-20 bg-white rounded-2xl border border-gray-100 shadow-sm text-center text-gray-500 mb-12">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-[17px] font-bold text-gray-800 mb-1">No documents matched your search</p>
            <p class="text-sm text-gray-400">Try adjusting your filters or search keywords</p>
        </div>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="bg-white rounded-2xl px-6 py-4 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 hidden">
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
let currentView = 'grid'; // 'grid' or 'list'
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
        
        gridContainer.classList.remove('hidden');
        listContainer.classList.add('hidden');
    } else {
        btnList.classList.add('bg-white', 'text-secondary', 'shadow-sm');
        btnList.classList.remove('text-gray-500');
        btnGrid.classList.remove('bg-white', 'text-secondary', 'shadow-sm');
        btnGrid.classList.add('text-gray-500');
        
        listContainer.classList.remove('hidden');
        gridContainer.classList.add('hidden');
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
        const matchesSearch = searchInput === "" || 
                              doc.title.includes(searchInput) || 
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
        noResultsMsg.classList.remove('hidden');
        gridContainer.classList.add('hidden');
        listViewContainer.classList.add('hidden');
        paginationControls.classList.add('hidden');
        return;
    }
    
    noResultsMsg.classList.add('hidden');
    if (currentView === 'grid') {
        gridContainer.classList.remove('hidden');
    } else {
        listViewContainer.classList.remove('hidden');
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
        paginationControls.classList.remove('hidden');
    } else {
        paginationControls.classList.add('hidden');
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
            html += `<button class="px-3 py-2 border border-[#4E0000] bg-[#4E0000] text-white font-bold rounded-xl text-xs">${i}</button>`;
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
    changeView('grid');
});
</script>

<?php include 'includes/footer.php'; ?>
