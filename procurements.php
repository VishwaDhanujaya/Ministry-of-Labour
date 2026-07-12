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
$all_procurements = $stmt->fetchAll();

$categorized_procurements = [
    'Plan' => [],
    'Notice' => [],
    'Award' => []
];

foreach ($all_procurements as $proc) {
    $cat = $proc['category'] ?? 'Notice';
    if (!isset($categorized_procurements[$cat])) {
        $categorized_procurements[$cat] = [];
    }
    $categorized_procurements[$cat][] = $proc;
}
?>

<!-- Content Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-white min-h-[50vh]">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Filters and Search -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <h2 class="text-xl md:text-[24px] font-bold font-montserrat text-primary">Procurements</h2>
            <div class="relative w-full md:max-w-[40%]">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none shadow-sm" placeholder="Search procurements by title..." onkeyup="filterTable()">
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex space-x-2 border-b border-gray-200 mb-8 overflow-x-auto" id="procurementTabs">
            <button class="tab-btn active px-6 py-3.5 text-[14px] font-semibold border-b-2 border-primary text-primary transition-colors whitespace-nowrap focus:outline-none flex items-center gap-2" data-target="tab-plans">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Procurement Plans
            </button>
            <button class="tab-btn px-6 py-3.5 text-[14px] font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition-colors whitespace-nowrap focus:outline-none flex items-center gap-2" data-target="tab-notices">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                Procurement Notices
            </button>
            <button class="tab-btn px-6 py-3.5 text-[14px] font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 transition-colors whitespace-nowrap focus:outline-none flex items-center gap-2" data-target="tab-awards">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                Contract Award Details
            </button>
        </div>

        <!-- Tab Contents -->
        <?php 
        $tabs = [
            'tab-plans' => ['title' => 'Procurement Plans', 'data' => $categorized_procurements['Plan']],
            'tab-notices' => ['title' => 'Procurement Notices', 'data' => $categorized_procurements['Notice']],
            'tab-awards' => ['title' => 'Contract Award Details', 'data' => $categorized_procurements['Award']]
        ];
        
        $isFirst = true;
        foreach($tabs as $id => $tab): 
        ?>
        <div id="<?= $id ?>" class="tab-content <?= $isFirst ? 'block' : 'hidden' ?>">
            <div class="bg-white rounded-[16px] shadow-[0_2px_12px_rgba(0,0,0,0.04)] border-[0.5px] border-[#E5E7EB] overflow-hidden mb-12">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 font-inter dataTable">
                        <thead class="bg-primary text-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-normal text-[14px] w-full md:w-auto">Title & Description</th>
                                <th class="px-6 py-4 font-normal text-[14px] w-32 shrink-0">Published Date</th>
                                <th class="px-6 py-4 font-normal text-[14px] text-right w-48 shrink-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E5E7EB]">
                            <?php if (empty($tab['data'])): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p>No <?= strtolower($tab['title']) ?> available at the moment.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($tab['data'] as $proc): ?>
                            <tr class="hover:bg-gray-50/80 transition-colors group search-row cursor-pointer" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                                 'title' => $proc['title'],
                                 'content' => $proc['description'] ?? '',
                                 'date' => date('M d, Y', strtotime($proc['created_at'])),
                                 'category' => 'Procurement ' . ($proc['category'] ?? 'Notice'),
                                 'pdf_path' => !empty($proc['pdf_path']) ? resolvePdfUrl($proc['pdf_path']) : ''
                             ])) ?>)">
                                <td class="px-6 py-4 search-target">
                                    <h3 class="font-medium text-gray-900 text-[14px] group-hover:text-secondary transition-colors"><?= htmlspecialchars($proc['title']) ?></h3>
                                    <?php if (!empty($proc['description'])): ?>
                                    <div class="text-[13px] text-gray-500 mt-1 prose prose-sm max-w-none notranslate"><?= $proc['description'] ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-[13px] whitespace-nowrap">
                                    <?= date('M d, Y', strtotime($proc['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap" onclick="event.stopPropagation();">
                                    <div class="flex items-center justify-end gap-3">
                                        <button type="button" data-pdf-url="<?= htmlspecialchars(resolvePdfUrl($proc['pdf_path'])) ?>" data-pdf-title="<?= htmlspecialchars($proc['title']) ?>" class="open-pdf-modal inline-flex items-center text-[#4E0000] hover:text-[#320000] text-[13px] font-semibold transition-colors focus:outline-none bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            View
                                        </button>
                                        <a href="<?= htmlspecialchars(resolvePdfUrl($proc['pdf_path'])) ?>" download class="inline-flex items-center text-[#4E0000] hover:text-[#320000] text-[13px] font-semibold transition-colors bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
        $isFirst = false;
        endforeach; 
        ?>

    </div>
</section>

<script>
// Tab Switching Logic
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active classes from all tabs
            tabs.forEach(t => {
                t.classList.remove('active', 'border-primary', 'text-primary');
                t.classList.add('border-transparent', 'text-gray-500');
            });

            // Add active class to clicked tab
            tab.classList.remove('border-transparent', 'text-gray-500');
            tab.classList.add('active', 'border-primary', 'text-primary');

            // Hide all content
            contents.forEach(c => {
                c.classList.remove('block');
                c.classList.add('hidden');
            });

            // Show target content
            const target = tab.getAttribute('data-target');
            document.getElementById(target).classList.remove('hidden');
            document.getElementById(target).classList.add('block');
        });
    });
});

// Improved Filter Logic across all tables
function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    
    // Select all rows with class search-row across all tabs
    let rows = document.querySelectorAll(".search-row");
    
    rows.forEach(row => {
        let td = row.querySelector(".search-target");
        if (td) {
            let txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    });
}
</script>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
