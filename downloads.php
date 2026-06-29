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

<section class="py-16 md:py-24 px-4 md:px-16 bg-gray-50">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-4">Acts & Amendments</h2>
            <p class="text-gray-600 font-inter max-w-2xl mx-auto">Download the official legislative documents relevant to the Ministry of Labour in all three national languages.</p>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center mb-10">
            <div class="bg-white rounded-full p-1.5 shadow-sm border border-gray-200 inline-flex">
                <button onclick="showTab('acts')" id="tab-acts" class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 bg-primary text-white shadow-md">Acts</button>
                <button onclick="showTab('amendments')" id="tab-amendments" class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 text-gray-500 hover:text-gray-900">Amendments</button>
            </div>
        </div>

        <!-- Acts Section -->
        <div id="content-acts" class="animate-fade-in">
            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($acts as $doc): ?>
                <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h3 class="text-[17px] font-bold text-gray-900 font-montserrat mb-1"><?= htmlspecialchars($doc['title']) ?></h3>
                        <p class="text-sm text-gray-500 font-inter flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <?= htmlspecialchars($doc['ref']) ?>
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2.5 w-full md:w-auto">
                        <a href="<?= $doc['si'] ?>" class="flex-1 md:flex-none text-center px-4 py-2 bg-[#F5F7FA] hover:bg-yellow-400 text-[#13273F] border border-gray-200 hover:border-yellow-400 font-bold rounded-xl text-[13px] transition-all duration-300" style="font-family: 'Noto Sans Sinhala', sans-serif;">
                            සිංහල PDF
                        </a>
                        <a href="<?= $doc['ta'] ?>" class="flex-1 md:flex-none text-center px-4 py-2 bg-[#F5F7FA] hover:bg-yellow-400 text-[#13273F] border border-gray-200 hover:border-yellow-400 font-bold rounded-xl text-[13px] transition-all duration-300" style="font-family: 'Noto Sans Tamil', sans-serif;">
                            தமிழ் PDF
                        </a>
                        <a href="<?= $doc['en'] ?>" class="flex-1 md:flex-none text-center px-4 py-2 bg-[#F5F7FA] hover:bg-yellow-400 text-[#13273F] border border-gray-200 hover:border-yellow-400 font-bold font-inter rounded-xl text-[13px] transition-all duration-300">
                            English PDF
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Amendments Section -->
        <div id="content-amendments" class="hidden animate-fade-in">
            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($amendments as $doc): ?>
                <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h3 class="text-[17px] font-bold text-gray-900 font-montserrat mb-1"><?= htmlspecialchars($doc['title']) ?></h3>
                        <p class="text-sm text-gray-500 font-inter flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <?= htmlspecialchars($doc['ref']) ?>
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2.5 w-full md:w-auto">
                        <a href="<?= $doc['si'] ?>" class="flex-1 md:flex-none text-center px-4 py-2 bg-[#F5F7FA] hover:bg-yellow-400 text-[#13273F] border border-gray-200 hover:border-yellow-400 font-bold rounded-xl text-[13px] transition-all duration-300" style="font-family: 'Noto Sans Sinhala', sans-serif;">
                            සිංහල PDF
                        </a>
                        <a href="<?= $doc['ta'] ?>" class="flex-1 md:flex-none text-center px-4 py-2 bg-[#F5F7FA] hover:bg-yellow-400 text-[#13273F] border border-gray-200 hover:border-yellow-400 font-bold rounded-xl text-[13px] transition-all duration-300" style="font-family: 'Noto Sans Tamil', sans-serif;">
                            தமிழ் PDF
                        </a>
                        <a href="<?= $doc['en'] ?>" class="flex-1 md:flex-none text-center px-4 py-2 bg-[#F5F7FA] hover:bg-yellow-400 text-[#13273F] border border-gray-200 hover:border-yellow-400 font-bold font-inter rounded-xl text-[13px] transition-all duration-300">
                            English PDF
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<script>
function showTab(tabId) {
    // Hide all contents
    document.getElementById('content-acts').classList.add('hidden');
    document.getElementById('content-amendments').classList.add('hidden');
    
    // Reset buttons
    const btnActs = document.getElementById('tab-acts');
    const btnAmendments = document.getElementById('tab-amendments');
    
    btnActs.className = 'px-6 py-2.5 rounded-full text-sm transition-all duration-300 text-gray-500 hover:text-gray-900 font-semibold';
    btnAmendments.className = 'px-6 py-2.5 rounded-full text-sm transition-all duration-300 text-gray-500 hover:text-gray-900 font-semibold';
    
    // Show selected content and style button
    document.getElementById('content-' + tabId).classList.remove('hidden');
    
    const activeBtn = document.getElementById('tab-' + tabId);
    activeBtn.className = 'px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 bg-primary text-white shadow-md';
}
</script>

<?php include 'includes/footer.php'; ?>
