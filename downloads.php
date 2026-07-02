<?php
// downloads.php
$page_title = 'Downloads';
$pageTitle = 'Downloads - Acts & Amendments - Ministry of Labour - Sri Lanka';
$metaDescription = 'Download Acts and Amendments of the Ministry of Labour in Sinhala, Tamil, and English.';
$metaKeywords = 'Downloads, Acts, Amendments, Ministry of Labour, Sri Lanka, Sinhala, Tamil, English';

include 'includes/header.php';
include 'includes/sub-hero.php';

// Placeholder data for Acts
$acts = [
    [
        'title' => 'Shop and Office Employees Act',
        'ref' => 'Act No. 19 of 1954',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Wages Boards Ordinance',
        'ref' => 'Ordinance No. 27 of 1941',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Employees\' Provident Fund Act',
        'ref' => 'Act No. 15 of 1958',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Maternity Benefits Ordinance',
        'ref' => 'Ordinance No. 32 of 1939',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Workmen\'s Compensation Ordinance',
        'ref' => 'Ordinance No. 19 of 1934',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Factories Ordinance',
        'ref' => 'Ordinance No. 45 of 1942',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ]
];

// Placeholder data for Amendments
$amendments = [
    [
        'title' => 'Employees\' Provident Fund (Amendment) Act',
        'ref' => 'Act No. 2 of 2012',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Shop and Office Employees (Regulation of Employment and Remuneration) (Amendment) Act',
        'ref' => 'Act No. 14 of 2021',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Maternity Benefits (Amendment) Act',
        'ref' => 'Act No. 15 of 2021',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ],
    [
        'title' => 'Minimum Wages (Indian Labour) (Amendment) Act',
        'ref' => 'Act No. 16 of 2021',
        'en' => '#',
        'si' => '#',
        'ta' => '#'
    ]
];
?>

<section class="py-12 md:py-16 px-4 md:px-16 bg-white min-h-[50vh]">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Filters and Search -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="relative flex-1 w-full md:max-w-[60%]">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchInput" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none" placeholder="Search acts or amendments by title..." onkeyup="filterTable()">
            </div>
        </div>

        <!-- Section Title and Tabs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <h2 class="text-[20px] font-medium font-montserrat text-primary">Acts & Amendments</h2>
            <div class="bg-white rounded-full p-1 border border-gray-200 inline-flex self-start">
                <button onclick="showTab('acts')" id="tab-acts" class="px-5 py-2 rounded-full text-xs font-bold transition-all duration-300 bg-primary text-white shadow-sm">Acts</button>
                <button onclick="showTab('amendments')" id="tab-amendments" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-300 text-gray-500 hover:text-gray-900">Amendments</button>
            </div>
        </div>

        <!-- Acts Table -->
        <div id="content-acts" class="animate-fade-in bg-white rounded-[16px] shadow-[0_2px_12px_rgba(0,0,0,0.04)] border-[0.5px] border-[#E5E7EB] overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter" id="actsTable">
                    <thead class="bg-primary text-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-normal text-[14px] w-full md:w-auto">Document Title</th>
                            <th class="px-6 py-4 font-normal text-[14px] w-48 shrink-0">Reference</th>
                            <th class="px-6 py-4 font-normal text-[14px] text-right w-80 shrink-0">Available Downloads</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        <?php foreach ($acts as $doc): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <h3 class="font-medium text-gray-900 text-[14px]"><?= htmlspecialchars($doc['title']) ?></h3>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-gray-500 whitespace-nowrap">
                                <?= htmlspecialchars($doc['ref']) ?>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= $doc['si'] ?>" class="px-3 py-1.5 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold transition-all" style="font-family: 'Noto Sans Sinhala', sans-serif;">සිංහල</a>
                                    <a href="<?= $doc['ta'] ?>" class="px-3 py-1.5 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold transition-all" style="font-family: 'Noto Sans Tamil', sans-serif;">தமிழ்</a>
                                    <a href="<?= $doc['en'] ?>" class="px-3 py-1.5 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold transition-all">English</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Amendments Table -->
        <div id="content-amendments" class="hidden animate-fade-in bg-white rounded-[16px] shadow-[0_2px_12px_rgba(0,0,0,0.04)] border-[0.5px] border-[#E5E7EB] overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter" id="amendmentsTable">
                    <thead class="bg-primary text-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-normal text-[14px] w-full md:w-auto">Document Title</th>
                            <th class="px-6 py-4 font-normal text-[14px] w-48 shrink-0">Reference</th>
                            <th class="px-6 py-4 font-normal text-[14px] text-right w-80 shrink-0">Available Downloads</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        <?php foreach ($amendments as $doc): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <h3 class="font-medium text-gray-900 text-[14px]"><?= htmlspecialchars($doc['title']) ?></h3>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-gray-500 whitespace-nowrap">
                                <?= htmlspecialchars($doc['ref']) ?>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= $doc['si'] ?>" class="px-3 py-1.5 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold transition-all" style="font-family: 'Noto Sans Sinhala', sans-serif;">සිංහල</a>
                                    <a href="<?= $doc['ta'] ?>" class="px-3 py-1.5 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold transition-all" style="font-family: 'Noto Sans Tamil', sans-serif;">தமிழ்</a>
                                    <a href="<?= $doc['en'] ?>" class="px-3 py-1.5 bg-gray-50 hover:bg-[#4E0000] hover:text-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold transition-all">English</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<script>
function showTab(tabId) {
    document.getElementById('content-acts').classList.add('hidden');
    document.getElementById('content-amendments').classList.add('hidden');
    
    const btnActs = document.getElementById('tab-acts');
    const btnAmendments = document.getElementById('tab-amendments');
    
    btnActs.className = 'px-5 py-2 rounded-full text-xs transition-all duration-300 text-gray-500 hover:text-gray-900 font-semibold';
    btnAmendments.className = 'px-5 py-2 rounded-full text-xs transition-all duration-300 text-gray-500 hover:text-gray-900 font-semibold';
    
    document.getElementById('content-' + tabId).classList.remove('hidden');
    
    const activeBtn = document.getElementById('tab-' + tabId);
    activeBtn.className = 'px-5 py-2 rounded-full text-xs font-bold transition-all duration-300 bg-primary text-white shadow-sm';

    // Clear search when switching tabs
    document.getElementById("searchInput").value = "";
    filterTable();
}

function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    
    // Filter acts
    let actsTable = document.getElementById("actsTable");
    let actsTr = actsTable.getElementsByTagName("tr");
    for (let i = 1; i < actsTr.length; i++) {
        let tdTitle = actsTr[i].getElementsByTagName("td")[0];
        let tdRef = actsTr[i].getElementsByTagName("td")[1];
        if (tdTitle || tdRef) {
            let titleVal = tdTitle ? (tdTitle.textContent || tdTitle.innerText) : '';
            let refVal = tdRef ? (tdRef.textContent || tdRef.innerText) : '';
            if (titleVal.toLowerCase().indexOf(filter) > -1 || refVal.toLowerCase().indexOf(filter) > -1) {
                actsTr[i].style.display = "";
            } else {
                actsTr[i].style.display = "none";
            }
        }
    }
    
    // Filter amendments
    let amTable = document.getElementById("amendmentsTable");
    let amTr = amTable.getElementsByTagName("tr");
    for (let i = 1; i < amTr.length; i++) {
        let tdTitle = amTr[i].getElementsByTagName("td")[0];
        let tdRef = amTr[i].getElementsByTagName("td")[1];
        if (tdTitle || tdRef) {
            let titleVal = tdTitle ? (tdTitle.textContent || tdTitle.innerText) : '';
            let refVal = tdRef ? (tdRef.textContent || tdRef.innerText) : '';
            if (titleVal.toLowerCase().indexOf(filter) > -1 || refVal.toLowerCase().indexOf(filter) > -1) {
                amTr[i].style.display = "";
            } else {
                amTr[i].style.display = "none";
            }
        }
    }
}
</script>

<?php include 'includes/footer.php'; ?>
