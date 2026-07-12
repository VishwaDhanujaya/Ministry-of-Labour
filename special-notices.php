<?php
$page_title = 'Special Notices';
$pageTitle = 'Special Notices - Ministry of Labour - Sri Lanka';
$metaDescription = 'View all special notices published by the Ministry of Labour, Sri Lanka.';
$metaKeywords = 'Special Notices, Announcements, Ministry of Labour, Sri Lanka';
include 'includes/header.php';
include 'includes/sub-hero.php';

require_once 'admin/includes/db.php';

// Fetch published special notices
$stmt = $pdo->query("SELECT * FROM special_notices WHERE status = 'Published' ORDER BY created_at DESC");
$notices = $stmt->fetchAll();
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
                <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none" placeholder="Search special notices by title..." onkeyup="filterTable()">
            </div>
        </div>

        <!-- Section Title -->
        <h2 class="text-lg md:text-[20px] font-medium font-montserrat text-primary mb-4">Special Notices</h2>

        <!-- Table -->
        <div class="bg-white rounded-[16px] shadow-[0_2px_12px_rgba(0,0,0,0.04)] border-[0.5px] border-[#E5E7EB] overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter" id="dataTable">
                    <thead class="bg-primary text-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-normal text-[14px] w-full md:w-auto">Title & Description</th>
                            <th class="px-6 py-4 font-normal text-[14px] w-32 shrink-0">Published Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        <?php if (empty($notices)): ?>
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-gray-500">No special notices available at the moment.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($notices as $notice): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors group cursor-pointer" onclick="openDetailModal(<?= htmlspecialchars(json_encode([
                            'title' => $notice['title'],
                            'content' => $notice['content'] ?? '',
                            'date' => date('M d, Y', strtotime($notice['created_at'])),
                            'category' => 'Special Notice',
                            'pdf_path' => !empty($notice['pdf_path']) ? resolvePdfUrl($notice['pdf_path']) : ''
                        ])) ?>)">
                            <td class="px-6 py-4">
                                <h3 class="font-medium text-gray-900 text-[14px] group-hover:text-secondary transition-colors"><?= htmlspecialchars($notice['title']) ?></h3>
                                <?php if (!empty($notice['content'])): ?>
                                <div class="text-[13px] text-gray-500 mt-1 prose prose-sm max-w-none notranslate"><?= $notice['content'] ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-[13px] whitespace-nowrap">
                                <?= date('M d, Y', strtotime($notice['created_at'])) ?>
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

<?php include 'includes/footer.php'; ?>
