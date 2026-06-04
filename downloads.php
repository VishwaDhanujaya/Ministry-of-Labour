<?php
// downloads.php
$page_title = 'Downloads';
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-6xl">
        
        <!-- Filters and Search -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="relative flex-1 max-w-[60%]">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 py-2.5 font-inter transition-colors outline-none" placeholder="Search by document name...">
            </div>
            <div class="flex gap-4">
                <button class="bg-[#FAFAFA] border border-[#E5E7EB] text-gray-700 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary px-4 py-2.5 flex items-center gap-2 font-inter hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    All Status
                    <svg class="w-4 h-4 text-gray-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <button class="bg-white border border-[#FECDD3] text-[#E24A4A] text-[13px] rounded-lg hover:bg-red-50 focus:ring-secondary focus:border-secondary px-4 py-2.5 flex items-center gap-2 font-inter transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Section Title -->
        <h2 class="text-[20px] font-medium font-montserrat text-primary mb-4">Industrial Safety Division</h2>

        <!-- Table -->
        <div class="bg-white rounded-[16px] shadow-[0_2px_12px_rgba(0,0,0,0.04)] border-[0.5px] border-[#E5E7EB] overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 font-inter">
                    <thead class="bg-primary text-gray-200">
                        <tr>
                            <th class="px-6 py-4 font-normal text-[14px] flex items-center gap-2 w-full md:w-auto">
                                Document Name
                                <svg class="w-4 h-4 text-gray-400 cursor-pointer hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                            </th>
                            <th class="px-6 py-4 font-normal text-[14px] text-center w-28 shrink-0">Sinhala</th>
                            <th class="px-6 py-4 font-normal text-[14px] text-center w-28 shrink-0">Tamil</th>
                            <th class="px-6 py-4 font-normal text-[14px] text-center w-32 shrink-0">English</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        <?php
                        $documents = [
                            "General register",
                            "Accident notification follow-up report ( CFIE-1 Form )",
                            "Factory Registration Application Form",
                            "Factory Building Plan Approval Application Form",
                            "Accident Notification Form (Form 10)",
                            "Dangerous Occurrences Notification Form (Form 12)",
                            "Industrial Diseases Notification Form (Form 13)",
                            "Steam Boiler Registration Application Form"
                        ];

                        foreach ($documents as $doc) {
                            echo '<tr class="hover:bg-gray-50/80 transition-colors group">';
                            echo '<td class="px-6 py-3.5 font-medium text-gray-700 text-[13px]">' . $doc . '</td>';
                            
                            $pdfIcon = '<a href="#" title="Download PDF" class="inline-flex items-center justify-center p-1.5 hover:bg-red-50 rounded-lg transition-colors group-hover:bg-red-50/50">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="hover:scale-110 transition-transform">
                                                <path d="M6 2C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2H6Z" fill="#E24A4A"/>
                                                <path d="M14 2V8H20" fill="#B32D2D"/>
                                                <path d="M10 13C10 13 9 11 7.5 11C6.2 11 6 12 6 12.5C6 13 6.5 13.5 7.5 13.5C8.5 13.5 9.5 13.2 10 13ZM10 13L11.5 10C11.5 10 12 8 11.5 7.5C11 7 10 7.5 10 8.5C10 9.5 10 13 10 13ZM10 13C10 13 12 14.5 13.5 15C15 15.5 15.5 15 15.5 14.5C15.5 14 15 13 13.5 13C12 13 10 13 10 13ZM10 13C10 13 9 16 8.5 18C8 20 9 20 9.5 18C10 16 10 13 10 13Z" fill="white"/>
                                            </svg>
                                        </a>';

                            echo '<td class="px-6 py-2.5 text-center align-middle">' . $pdfIcon . '</td>';
                            echo '<td class="px-6 py-2.5 text-center align-middle">' . $pdfIcon . '</td>';
                            echo '<td class="px-6 py-2.5 text-center align-middle">' . $pdfIcon . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
