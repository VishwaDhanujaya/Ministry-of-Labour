<?php
// downloads.php
require_once 'admin/includes/db.php';

$page_title = 'Downloads';
$pageTitle = 'Downloads - Documents, Acts & Amendments - Ministry of Labour - Sri Lanka';
$metaDescription = 'Download Documents, Acts and Amendments of the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Ministry of Labour, Sri Lanka, Downloads, Documents, Acts, Amendments';
$pageMeta = [
    'si' => [
        'title' => 'බාගැනීම් - ලේඛන සහ පනත් - කම්කරු අමාත්‍යාංශය - ශ්‍රී ලංකාව',
        'desc'  => 'කම්කරු අමාත්‍යාංශයේ නිල ලේඛන, පනත් සහ සංශෝධන බාගත කරන්න.',
        'kw'    => 'කම්කරු අමාත්‍යාංශය, බාගැනීම්, ලේඛන, පනත්'
    ],
    'ta' => [
        'title' => 'பதிவிறக்கங்கள் - ஆவணங்கள் மற்றும் சட்டங்கள் - தொழில் அமைச்சு - இலங்கை',
        'desc'  => 'தொழில் அமைச்சின் அதிகாரப்பூர்வ ஆவணங்கள், சட்டங்கள் மற்றும் திருத்தங்களை பதிவிறக்கவும்.',
        'kw'    => 'தொழில் அமைச்சு, பதிவிறக்கங்கள், ஆவணங்கள், சட்டங்கள்'
    ]
];

include 'includes/header.php';
include 'includes/sub-hero.php';

$all_documents = [];

try {
    // Helper closure to resolve multilingual fields with graceful fallback to English
    $resolveLocalizedFields = function(&$row) use ($current_lang) {
        if ($current_lang === 'si' && !empty($row['title_si'])) {
            $row['title'] = $row['title_si'];
        } elseif ($current_lang === 'ta' && !empty($row['title_ta'])) {
            $row['title'] = $row['title_ta'];
        }
        if (isset($row['description'])) {
            if ($current_lang === 'si' && !empty($row['description_si'])) {
                $row['description'] = $row['description_si'];
            } elseif ($current_lang === 'ta' && !empty($row['description_ta'])) {
                $row['description'] = $row['description_ta'];
            }
        }
    };

    // Fetch Acts and Amendments
    $stmt = $pdo->query("SELECT title, title_si, title_ta, ref, category, created_at, pdf_path, pdf_path_si, pdf_path_ta FROM acts_amendments WHERE status = 'Published' AND (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['ref'] = !empty($row['ref']) ? $row['ref'] : date('Y-m-d', strtotime($row['created_at']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch Procurements
    $categoryMapping = [
        'Plan' => 'Procurement Plan',
        'Notice' => 'Procurement Notice',
        'Award' => 'Contract Award Details'
    ];
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, category, pdf_path, pdf_path_si, pdf_path_ta FROM procurements WHERE (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $rawCat = $row['category'] ?? 'Notice';
        $row['category'] = $categoryMapping[$rawCat] ?? 'Procurement Notice';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch Vacancies
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, pdf_path, pdf_path_si, pdf_path_ta FROM vacancies WHERE (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['category'] = 'Vacancies';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch Local Publications
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, pdf_path, pdf_path_si, pdf_path_ta FROM learning_platforms_local WHERE (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['category'] = 'Local Publications';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch Foreign Publications
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, pdf_path, pdf_path_si, pdf_path_ta FROM learning_platforms_foreign WHERE (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['category'] = 'Foreign Publications';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch Special Notices
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, pdf_path, pdf_path_si, pdf_path_ta FROM special_notices WHERE status = 'Published' AND (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['category'] = 'Special Notices';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch Action Plans
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, pdf_path, pdf_path_si, pdf_path_ta FROM action_plans WHERE status = 'Published' AND (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['category'] = 'Action Plans';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch RTI Reports
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, pdf_path, pdf_path_si, pdf_path_ta FROM rti_reports WHERE status = 'Published' AND (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['category'] = 'RTI Reports';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Fetch IAU Downloads
    $stmt = $pdo->query("SELECT title, title_si, title_ta, created_at, created_at as ref, pdf_path, pdf_path_si, pdf_path_ta FROM iau_downloads WHERE status = 'Published' AND (pdf_path != '' OR pdf_path_si != '' OR pdf_path_ta != '') ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $resolveLocalizedFields($row);
        $row['category'] = 'IAU Update';
        $row['ref'] = date('Y-m-d', strtotime($row['ref']));
        $row['pdf_path'] = !empty($row['pdf_path']) ? resolvePdfUrl($row['pdf_path']) : '';
        $row['pdf_path_si'] = !empty($row['pdf_path_si']) ? resolvePdfUrl($row['pdf_path_si']) : '';
        $row['pdf_path_ta'] = !empty($row['pdf_path_ta']) ? resolvePdfUrl($row['pdf_path_ta']) : '';
        $all_documents[] = $row;
    }

    // Global sort: newest created/uploaded documents always appear at the top
    usort($all_documents, function($a, $b) {
        $tA = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
        $tB = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
        if ($tA === $tB) return 0;
        return ($tA < $tB) ? 1 : -1;
    });
} catch (PDOException $e) {
    // Silently continue
}

$categories = array_unique(array_column($all_documents, 'category'));

$categoryColors = [
    'Acts' => 'bg-blue-50 text-blue-700 border-blue-100',
    'Amendments' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
    'Procurement Plan' => 'bg-blue-50 text-blue-700 border-blue-100',
    'Procurement Notice' => 'bg-amber-50 text-amber-700 border-amber-100',
    'Contract Award Details' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
    'Vacancies' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
    'Local Publications' => 'bg-purple-50 text-purple-700 border-purple-100',
    'Foreign Publications' => 'bg-rose-50 text-rose-700 border-rose-100',
    'Special Notices' => 'bg-orange-50 text-orange-700 border-orange-100',
    'Action Plans' => 'bg-pink-50 text-pink-700 border-pink-100',
    'RTI Reports' => 'bg-teal-50 text-teal-700 border-teal-100',
    'IAU Update' => 'bg-sky-50 text-sky-700 border-sky-100'
];
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
                    <input type="text" id="searchInput" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full pl-11 pr-4 py-3 font-inter transition-all outline-none" placeholder="<?= htmlspecialchars(t('search_docs_placeholder', 'Search documents...')) ?>" onkeyup="resetPaginationAndFilter()">
                </div>
                
                <!-- Filters & Views -->
                <div class="flex flex-wrap sm:flex-nowrap gap-3 items-center">
                    
                    <!-- Category -->
                    <?php $preselected_category = isset($_GET['category']) ? $_GET['category'] : ''; ?>
                    <div class="relative w-full sm:w-48">
                        <select id="categoryFilter" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="" <?= ($preselected_category === '') ? 'selected' : '' ?>><?= t('all_categories', 'All Categories') ?></option>
                            <option value="acts-amendments" <?= ($preselected_category === 'acts-amendments') ? 'selected' : '' ?>><?= t('acts_amendments_filter', 'Acts & Amendments') ?></option>
                            <option value="procurements" <?= ($preselected_category === 'procurements') ? 'selected' : '' ?>><?= t('all_procurements', 'All Procurements') ?></option>
                            <?php foreach ($categories as $cat): ?>
                                <?php if (in_array($cat, ['Acts', 'Amendments', 'Procurement Plan', 'Procurement Notice', 'Contract Award Details'])) continue; ?>
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

                    <!-- Language Filter -->
                    <div class="relative w-full sm:w-40">
                        <select id="langFilter" class="bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-secondary focus:border-secondary block w-full px-4 py-3 font-inter transition-all outline-none appearance-none cursor-pointer" onchange="resetPaginationAndFilter()">
                            <option value="en" <?= $current_lang === 'en' ? 'selected' : '' ?>><?= t('english_pdf', 'English PDF') ?></option>
                            <option value="si" <?= $current_lang === 'si' ? 'selected' : '' ?>><?= t('sinhala_pdf', 'Sinhala PDF') ?></option>
                            <option value="ta" <?= $current_lang === 'ta' ? 'selected' : '' ?>><?= t('tamil_pdf', 'Tamil PDF') ?></option>
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
            <div class="document-card bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between cursor-pointer notranslate" translate="no" data-index="<?= $index ?>" data-title="<?= htmlspecialchars(strtolower($doc['title'])) ?>" data-ref="<?= htmlspecialchars(strtolower($doc['ref'])) ?>" data-category="<?= htmlspecialchars(strtolower($doc['category'])) ?>" data-pdf-en="<?= htmlspecialchars($doc['pdf_path'] ?? '') ?>" data-pdf-si="<?= htmlspecialchars($doc['pdf_path_si'] ?? '') ?>" data-pdf-ta="<?= htmlspecialchars($doc['pdf_path_ta'] ?? '') ?>" onclick="openDownloadModal(<?= $index ?>)">
                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="notranslate px-2.5 py-1 rounded-lg text-xs font-semibold border whitespace-nowrap <?= $badgeClass ?>"><?= htmlspecialchars(translateCategory($doc['category'])) ?></span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <!-- Title -->
                    <h3 class="font-bold text-gray-800 text-[15px] leading-snug mb-2 hover:text-secondary transition-colors group-hover:text-secondary notranslate" translate="no"><?= htmlspecialchars($doc['title']) ?></h3>
                    <!-- Reference -->
                    <p class="text-xs text-gray-500 font-medium font-inter mb-6 notranslate"><?= t('ref_prefix', 'Ref: ') ?><?= htmlspecialchars($doc['ref']) ?></p>
                </div>
                <!-- Action Button -->
                <button type="button" class="download-btn w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-xl text-[13px] font-bold transition-all gap-2 shadow-sm notranslate" onclick="openDownloadModal(<?= $index ?>)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <?= t('download_document', 'Download Document') ?>
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
                            <th class="px-6 py-4 font-semibold text-[13.5px] notranslate"><?= t('doc_title_col', 'Document Title') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-40 notranslate"><?= t('category_col', 'Category') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] w-48 notranslate"><?= t('reference_col', 'Reference') ?></th>
                            <th class="px-6 py-4 font-semibold text-[13.5px] text-right w-56 notranslate"><?= t('action_col', 'Action') ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 notranslate" translate="no">
                        <?php foreach ($all_documents as $index => $doc): 
                            $badgeClass = $categoryColors[$doc['category']] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                        ?>
                        <tr class="document-list-row hover:bg-gray-50/40 transition-all duration-150 cursor-pointer notranslate" translate="no" data-index="<?= $index ?>" data-pdf-en="<?= htmlspecialchars($doc['pdf_path'] ?? '') ?>" data-pdf-si="<?= htmlspecialchars($doc['pdf_path_si'] ?? '') ?>" data-pdf-ta="<?= htmlspecialchars($doc['pdf_path_ta'] ?? '') ?>" onclick="openDownloadModal(<?= $index ?>)">
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
                                <button type="button" class="list-download-btn inline-flex items-center px-4 py-2 bg-gray-50 hover:bg-secondary hover:text-white border border-gray-200 text-gray-700 rounded-lg text-[12px] font-bold transition-all gap-1.5 shadow-sm notranslate" onclick="openDownloadModal(<?= $index ?>)">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <?= t('download', 'Download') ?>
                                </button>
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
            <p class="text-[17px] font-bold text-gray-800 mb-1 notranslate"><?= t('no_docs_found', 'No documents matched your search') ?></p>
            <p class="text-sm text-gray-400 notranslate"><?= t('no_docs_found_sub', 'Try adjusting your filters or search keywords') ?></p>
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

<!-- Trilingual Download Language Selection Modal Popup -->
<div id="downloadModal" class="fixed inset-0 bg-slate-950/75 backdrop-blur-md flex items-center justify-center p-4 sm:p-6 opacity-0 pointer-events-none transition-all duration-300" style="z-index: 999999 !important;">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 transform scale-95 transition-all duration-300 relative max-h-[90vh] overflow-y-auto" id="modalCard" onclick="event.stopPropagation();">
        <button onclick="closeDownloadModal()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <div class="mb-6">
            <span id="modalCategory" class="px-3 py-1 rounded-lg text-xs font-semibold border whitespace-nowrap bg-primary/5 text-primary border-primary/10 inline-block mb-3 notranslate"><?= t('category', 'Category') ?></span>
            <h3 id="modalTitle" class="text-xl sm:text-2xl font-bold text-gray-900 leading-snug font-montserrat mb-1"><?= t('doc_title', 'Document Title') ?></h3>
            <p id="modalRef" class="text-xs text-gray-500 font-medium font-inter notranslate"><?= t('ref_prefix', 'Ref: ') ?>-</p>
        </div>
        
        <div class="space-y-3 mb-6">
            <p class="text-xs font-bold uppercase tracking-wider text-gray-400 font-inter mb-2 notranslate"><?= t('select_pdf_version', 'Select Language PDF Version') ?></p>
            
            <!-- English PDF Button -->
            <a id="btnModalEn" href="#" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl border border-gray-200 hover:border-primary hover:shadow-sm transition-all duration-200 group notranslate">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">EN</span>
                    <div>
                        <p class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors"><?= t('pdf_english', 'English PDF') ?></p>
                        <p class="text-[11px] text-gray-400"><?= t('pdf_english_desc', 'Official English Document') ?></p>
                    </div>
                </div>
                <span class="px-3.5 py-2 bg-primary text-white rounded-xl text-xs font-bold group-hover:bg-secondary transition-colors flex items-center gap-1.5 shadow-sm">
                    <?= t('download', 'Download') ?>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </span>
            </a>
            
            <!-- Sinhala PDF Button -->
            <a id="btnModalSi" href="#" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl border border-gray-200 hover:border-primary hover:shadow-sm transition-all duration-200 group notranslate">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs font-noto">සිං</span>
                    <div>
                        <p class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors font-noto"><?= t('pdf_sinhala', 'සිංහල PDF (Sinhala)') ?></p>
                        <p class="text-[11px] text-gray-400 font-noto"><?= t('pdf_sinhala_desc', 'සිංහල මාධ්‍ය නිල ලේඛනය') ?></p>
                    </div>
                </div>
                <span class="px-3.5 py-2 bg-primary text-white rounded-xl text-xs font-bold group-hover:bg-secondary transition-colors flex items-center gap-1.5 shadow-sm font-noto">
                    <?= t('download', 'බාගත කරන්න') ?>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </span>
            </a>
            
            <!-- Tamil PDF Button -->
            <a id="btnModalTa" href="#" target="_blank" class="flex items-center justify-between p-3.5 rounded-2xl border border-gray-200 hover:border-primary hover:shadow-sm transition-all duration-200 group notranslate">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs font-noto">த</span>
                    <div>
                        <p class="font-bold text-gray-800 text-sm group-hover:text-primary transition-colors font-noto"><?= t('pdf_tamil', 'தமிழ் PDF (Tamil)') ?></p>
                        <p class="text-[11px] text-gray-400 font-noto"><?= t('pdf_tamil_desc', 'தமிழ் மொழி அதிகாரப்பூர்வ ஆவணம்') ?></p>
                    </div>
                </div>
                <span class="px-3.5 py-2 bg-primary text-white rounded-xl text-xs font-bold group-hover:bg-secondary transition-colors flex items-center gap-1.5 shadow-sm font-noto">
                    <?= t('download', 'பதிவிறக்கம்') ?>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </span>
            </a>
        </div>
        
        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button onclick="closeDownloadModal()" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition-colors"><?= t('close_btn', 'Close') ?></button>
        </div>
    </div>
</div>

<script>
let downloadsPaginator;
let currentView = 'list';

// Capture all documents from PHP
const documents = <?php echo json_encode(array_map(function($doc, $i) {
    return [
        'index' => $i,
        'raw_title' => $doc['title'],
        'title' => strtolower($doc['title']),
        'raw_ref' => $doc['ref'],
        'ref' => strtolower($doc['ref']),
        'raw_category' => translateCategory($doc['category']),
        'category' => strtolower($doc['category']),
        'pdf_en' => $doc['pdf_path'] ?? '',
        'pdf_si' => $doc['pdf_path_si'] ?? '',
        'pdf_ta' => $doc['pdf_path_ta'] ?? '',
        'has_en' => !empty($doc['pdf_path']),
        'has_si' => !empty($doc['pdf_path_si']),
        'has_ta' => !empty($doc['pdf_path_ta'])
    ];
}, $all_documents, array_keys($all_documents))); ?>;

function openDownloadModal(index) {
    const doc = documents.find(d => d.index === index);
    if (!doc) return;
    
    document.getElementById('modalTitle').innerText = doc.raw_title;
    document.getElementById('modalRef').innerText = '<?= t("ref_prefix", "Ref: ") ?>' + doc.raw_ref;
    document.getElementById('modalCategory').innerText = doc.raw_category;
    
    // English PDF Button
    const btnEn = document.getElementById('btnModalEn');
    if (btnEn) {
        if (doc.pdf_en) {
            btnEn.href = doc.pdf_en;
            btnEn.classList.remove('opacity-40', 'pointer-events-none');
        } else {
            btnEn.removeAttribute('href');
            btnEn.classList.add('opacity-40', 'pointer-events-none');
        }
    }
    
    // Sinhala PDF Button
    const btnSi = document.getElementById('btnModalSi');
    if (btnSi) {
        if (doc.pdf_si) {
            btnSi.href = doc.pdf_si;
            btnSi.classList.remove('opacity-40', 'pointer-events-none');
        } else {
            btnSi.removeAttribute('href');
            btnSi.classList.add('opacity-40', 'pointer-events-none');
        }
    }

    // Tamil PDF Button
    const btnTa = document.getElementById('btnModalTa');
    if (btnTa) {
        if (doc.pdf_ta) {
            btnTa.href = doc.pdf_ta;
            btnTa.classList.remove('opacity-40', 'pointer-events-none');
        } else {
            btnTa.removeAttribute('href');
            btnTa.classList.add('opacity-40', 'pointer-events-none');
        }
    }

    const modal = document.getElementById('downloadModal');
    const card = document.getElementById('modalCard');
    if (modal && card) {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }
    document.body.style.overflow = 'hidden';
}

function closeDownloadModal() {
    const modal = document.getElementById('downloadModal');
    const card = document.getElementById('modalCard');
    if (modal && card) {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
    document.body.style.overflow = '';
}

// Close on backdrop click
document.getElementById('downloadModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'downloadModal') closeDownloadModal();
});

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDownloadModal();
});

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
    
    if (downloadsPaginator) {
        downloadsPaginator.setView(view);
    }
}

function resetPaginationAndFilter() {
    filterTable();
}

function filterTable() {
    const searchInput = document.getElementById("searchInput") ? document.getElementById("searchInput").value.toLowerCase().trim() : '';
    const categoryFilter = document.getElementById("categoryFilter") ? document.getElementById("categoryFilter").value.toLowerCase() : '';
    const lang = document.getElementById("langFilter") ? document.getElementById("langFilter").value : 'en';
    
    const filteredIndexes = [];
    documents.forEach(doc => {
        const gridCard = document.querySelector(`.document-card[data-index="${doc.index}"]`);
        const titleEl = gridCard ? gridCard.querySelector('h3') : null;
        const visibleTitle = titleEl ? titleEl.textContent.toLowerCase() : doc.title;
        
        const matchesSearch = searchInput === "" || 
                              visibleTitle.includes(searchInput) || 
                              doc.ref.includes(searchInput);
                              
        let matchesCategory = false;
        if (categoryFilter === "") {
            matchesCategory = true;
        } else if (categoryFilter === "acts-amendments") {
            matchesCategory = (doc.category === "acts" || doc.category === "amendments");
        } else if (categoryFilter === "procurements") {
            matchesCategory = (doc.category === "procurement plan" || doc.category === "procurement notice" || doc.category === "contract award details");
        } else {
            matchesCategory = (doc.category === categoryFilter);
        }
                                
        if (matchesSearch && matchesCategory) {
            filteredIndexes.push(doc.index);
        }
    });
    
    if (downloadsPaginator) {
        downloadsPaginator.setFilteredIndexes(filteredIndexes);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('downloadModal');
    if (modal && modal.parentNode !== document.body) {
        document.body.appendChild(modal);
    }
    
    downloadsPaginator = new ContentPaginator({
        items: documents,
        entityType: 'documents',
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

<?php include 'includes/footer.php'; ?>
