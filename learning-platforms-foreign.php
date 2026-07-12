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
$learning_platforms_foreign = $stmt->fetchAll();
?>

<!-- Content Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-white min-h-[50vh]">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Filters and Search -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="relative flex-1 w-full md:max-w-[60%]">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none" placeholder="Search foreign publications by title..." onkeyup="filterTable()">
            </div>
        </div>

        <!-- Section Title -->
        <h2 class="text-lg md:text-[20px] font-medium font-montserrat text-primary mb-4">Latest Foreign Publications</h2>

        <!-- Table -->
        <div class="bg-white rounded-[16px] shadow-[0_2px_12px_rgba(0,0,0,0.04)] border-[0.5px] border-[#E5E7EB] overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter" id="dataTable">
                    <thead class="bg-primary text-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-normal text-[14px] w-full md:w-auto">Title & Description</th>
                            <th class="px-6 py-4 font-normal text-[14px] w-32 shrink-0">Published Date</th>
                            <th class="px-6 py-4 font-normal text-[14px] text-right w-48 shrink-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        <?php if (empty($learning_platforms_foreign)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">No foreign publications available at the moment.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($learning_platforms_foreign as $pub): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors group cursor-pointer" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                            'title' => $pub['title'],
                            'content' => $pub['description'] ?? '',
                            'date' => date('M d, Y', strtotime($pub['created_at'])),
                            'category' => 'Foreign Publication',
                            'pdf_path' => !empty($pub['pdf_path']) ? resolvePdfUrl($pub['pdf_path']) : ''
                        ])) ?>)">
                            <td class="px-6 py-4">
                                <h3 class="font-medium text-gray-900 text-[14px] group-hover:text-secondary transition-colors"><?= htmlspecialchars($pub['title']) ?></h3>
                                <?php if (!empty($pub['description'])): ?>
                                <div class="text-[13px] text-gray-500 mt-1 prose prose-sm max-w-none notranslate"><?= $pub['description'] ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-[13px] whitespace-nowrap">
                                <?= date('M d, Y', strtotime($pub['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap" onclick="event.stopPropagation();">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="<?= htmlspecialchars(resolvePdfUrl($pub['pdf_path'])) ?>" target="_blank" class="inline-flex items-center text-[#4E0000] hover:text-[#320000] text-[13px] font-semibold transition-colors focus:outline-none bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View
                                    </a>
                                    <a href="<?= htmlspecialchars(resolvePdfUrl($pub['pdf_path'])) ?>" download class="inline-flex items-center text-[#4E0000] hover:text-[#320000] text-[13px] font-semibold transition-colors bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md">
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
</section>

<script>
function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let table = document.getElementById("dataTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) { // skip header
        let td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            let txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}
</script>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
