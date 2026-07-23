<?php
// iau.php
$iau_staff = [
    [
        'id' => 'staff-1',
        'title' => 'Head of the IAU',
        'department' => '',
        'name' => 'Ms. T.P. Muditha Pathmajay',
        'designation' => 'Additional Secretary (Development)',
        'phone' => '0718123025',
        'email' => 'mpathmajay@gmail.com'
    ],
    [
        'id' => 'staff-2',
        'title' => 'Integrity Officer',
        'department' => 'Ministry of Labour',
        'name' => 'Mr. P.D. Chandana Pathirage',
        'designation' => 'Director (Development)',
        'phone' => '0713373538',
        'email' => 'pstchandana@gmail.com'
    ],
    [
        'id' => 'staff-3',
        'title' => 'Member',
        'department' => 'Department of Manpower and Employment',
        'name' => 'Mrs. W. C. K. Wijemanna',
        'designation' => 'Additional Director General',
        'phone' => '0776182082',
        'email' => 'kumudinichampa@yahoo.com'
    ],
    [
        'id' => 'staff-4',
        'title' => 'Member',
        'department' => 'National Institute of Labour Studies',
        'name' => 'Mrs. W.D.D. Weerathunga',
        'designation' => 'Administrative Officer',
        'phone' => '0776911027',
        'email' => 'deepikaweerathunga2@gmail.com'
    ],
    [
        'id' => 'staff-5',
        'title' => 'Member',
        'department' => 'National Institute of Occupational Safety and Health',
        'name' => 'Mr. P.M.K. Perera',
        'designation' => 'Assistant Director (Finance)',
        'phone' => '0773956382',
        'email' => 'mohan@niosh.gov.lk'
    ],
    [
        'id' => 'staff-6',
        'title' => 'Member',
        'department' => 'Office of the Commissioner for Workmen’s Compensation',
        'name' => 'Mrs. Y. Ganga',
        'designation' => 'Accountant',
        'phone' => '076-4500454',
        'email' => 'm.kganga4@gmail.com'
    ],
    [
        'id' => 'staff-7',
        'title' => 'Member',
        'department' => 'Shrama Vasana Fund',
        'name' => 'Mr. H.W. Thilakarathne',
        'designation' => 'Manager',
        'phone' => '0712809917',
        'email' => 'thilak22@hotmail.com'
    ],
    [
        'id' => 'staff-8',
        'title' => 'Member',
        'department' => 'Policy Formulation & Foreign Relations Division',
        'name' => 'Mr. B. Vasanthan',
        'designation' => 'Senior Assistant Secretary (Foreign Relations)',
        'phone' => '0718249902',
        'email' => 'bvasanthan@yahoo.com'
    ],
    [
        'id' => 'staff-9',
        'title' => 'Member',
        'department' => 'Accounts Division',
        'name' => 'Mrs. S.S. Shiroma Nandani',
        'designation' => 'Chief Accountant',
        'phone' => '0752261785',
        'email' => 'shiromanandani@yahoo.com'
    ],
    [
        'id' => 'staff-10',
        'title' => 'Member',
        'department' => 'Planning Division',
        'name' => 'Mrs. M.P.D.C. W. Kumari',
        'designation' => 'Deputy Director (Planning)',
        'phone' => '0716897218',
        'email' => 'kuma_lg@yahoo.com'
    ],
    [
        'id' => 'staff-11',
        'title' => 'Member',
        'department' => 'Administration Division',
        'name' => 'Mrs. S. Luxiga',
        'designation' => 'Assistant Secretary (Administration)',
        'phone' => '0779265869',
        'email' => 'skluxi@gmail.com'
    ],
    [
        'id' => 'staff-12',
        'title' => 'Member',
        'department' => 'Legal Division',
        'name' => 'Mrs. W.P.A.G. Wijesooriya',
        'designation' => 'Legal Officer',
        'phone' => '0763526589',
        'email' => 'gayaniew1@gmail.com'
    ]
];

$page_title = 'IAU <span class="text-2xl md:text-3xl font-medium tracking-normal pb-1">(Internal Affairs Unit)</span>';
$pageTitle = 'Internal Affairs Unit (IAU) - Ministry of Labour - Sri Lanka';
$metaDescription = 'Learn about the Internal Affairs Unit (IAU) of the Ministry of Labour, its objectives, responsibilities, and find contact information for the unit\'s staff.';
$metaKeywords = 'Internal Affairs Unit, IAU, Integrity, Accountability, Ministry of Labour, Sri Lanka';
$title_classes = 'flex items-end gap-2';
$breadcrumbs = [
    ['label' => 'IAU']
];
include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- About the Unit Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white border-b border-slate-200/80">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 font-montserrat mb-6">About the Unit</h2>
        <p class="text-gray-600 font-inter text-[15px] leading-relaxed mb-12 max-w-5xl">
            The Internal Affairs Unit (IAU) of the Ministry of Labour is committed to promoting integrity, transparency, and accountability while actively working to prevent bribery and corruption. The unit is responsible for implementing institutional integrity action plans and collaborating with national anti-corruption bodies like CIABOC.
        </p>

        <!-- Key Objectives Card -->
        <div class="bg-white rounded-[32px] border-[0.5px] border-[#D4D4D4] p-6 md:p-10 shadow-sm flex flex-col lg:flex-row gap-10 items-center">
            <div class="w-full lg:w-2/5">
                <img loading="lazy" src="assets/img/IAU/about-iau.webp" alt="IAU Meeting" class="w-full h-auto object-cover rounded-2xl shadow-sm">
            </div>
            <div class="w-full lg:w-3/5">
                <h3 class="text-2xl font-bold text-gray-900 font-montserrat mb-4">Key Objectives of the Internal Affairs Unit (IAU)</h3>
                <p class="text-gray-700 font-inter text-[15px] mb-4">The IAU in each institution is expected to achieve the following objectives:</p>
                <ol class="list-[lower-alpha] pl-5 space-y-3 text-gray-600 font-inter text-[15px] leading-relaxed">
                    <li>Prevent corruption in the institution and cultivate a culture of integrity.</li>
                    <li>Ensure transparency and accountability in all activities of the institution and ensure public access to information regarding institutional practices and decisions.</li>
                    <li>Promote ethical governance within the institution.</li>
                    <li>Develop a secure and accessible system to encourage reporting misconduct, protect whistleblowers and maintain confidentiality.</li>
                    <li>Support legal enforcement Allegations of Bribery or Corruption (CIABOC).</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Responsibilities and Functions Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-[#F1F5F9] border-t border-b border-slate-200/80 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
    <div class="container mx-auto flex flex-col lg:flex-row gap-16">
        <!-- Left Side: List -->
        <div class="w-full lg:w-[65%]">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 font-montserrat mb-8">Responsibilities and Functions of the Internal Affairs Unit (IAU)</h2>
            <ol class="list-decimal pl-5 space-y-4 text-gray-700 font-inter text-[15px] leading-relaxed">
                <li>Examine current procedures and circulars to identify systemic bottlenecks within the institution and identify them to enhance operational efficiency.</li>
                <li>Conduct Corruption Risk Assessments (CRA) to identify areas in the institution vulnerable to corruption and unethical conduct and take targeted preventive measures.</li>
                <li>Develop and implement an Institutional Integrity Action Plan outlining specific anti-corruption objectives and strategies tailored to the institution's needs.</li>
                <li>Ensure full compliance with national anti-corruption Action Plan.</li>
                <li>Conduct regular compliance reviews to assess the institution's compliance with national and international anti-corruption laws, including the Anti-Corruption Act No. 9 of 2023.</li>
                <li>Ensure compliance with Asset Declaration requirements for all public officials and employees, and manage conflicts of interest.</li>
                <li>Establish a secure system to receive and manage complaints related to corruptions and unethical conduct in the institution; ensure that all such complaints are promptly addressed.</li>
                <li>Develop and publish a Citizens Charter outlining services provided by the institution.</li>
                <li>Establish and enforce policies that promote ethical governance, including a standardized code of conduct.</li>
                <li>Implement measures, including training and awareness creation, to motivate employees to commit to anti-corruption principles.</li>
                <li>Act as the institutional focal point for the National Anti-corruption Integrity Assessment.</li>
                <li>Maintain liaison with the CIABOC to receive ongoing guidance and support in EXECUTING THE UNIT'S DUTIES.</li>
                <li>Produce periodic and annual reports summarizing the IAU's activities.</li>
                <li>Collaborate with private sector stakeholders to plan and implement integrity development programs.</li>
            </ol>
        </div>

        <!-- Right Side: Contact Card -->
        <div class="w-full lg:w-[35%] pt-2 md:pt-16">
            <div class="bg-primary rounded-[32px] p-8 md:p-10 text-white shadow-lg sticky top-32">
                <h3 class="text-xl md:text-2xl font-semibold font-montserrat mb-8 text-[#FAFAFA]">Submission of Suggestions/ ideas/<br>Complaints</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <p class="text-[#FAFAFA] font-inter text-sm leading-relaxed pt-1">
                            Internal Affairs Unit,<br>
                            Ministry of Labour<br>
                            6th Floor, Mehewara Piyasa, Narahenpita, Colombo 05
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <a href="mailto:iaunit.mol@gmail.com" class="shrink-0" title="Email">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </a>
                        <a href="mailto:iaunit.mol@gmail.com" class="text-[#FAFAFA] font-inter text-sm hover:text-white transition-colors">iaunit.mol@gmail.com</a>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <a href="tel:+94112368938" class="shrink-0" title="Call">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                        </a>
                        <a href="tel:+94112368938" class="text-[#FAFAFA] font-inter text-sm hover:text-white transition-colors notranslate">+94 11 236 8938</a>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <a href="https://wa.me/94707227877" target="_blank" rel="noopener noreferrer" class="shrink-0" title="WhatsApp">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.031 0C5.405 0 0 5.405 0 12.031c0 2.115.548 4.17 1.588 5.986L.048 23.953l6.082-1.597c1.745.952 3.702 1.455 5.753 1.455h.005c6.622 0 12.025-5.404 12.025-12.03 0-3.21-1.25-6.227-3.518-8.497A11.968 11.968 0 0012.031 0zm0 21.802h-.005c-1.79 0-3.543-.481-5.076-1.39l-.364-.216-3.771.989.999-3.676-.237-.377a10.024 10.024 0 01-1.536-5.328c0-5.522 4.495-10.016 10.019-10.016 2.678 0 5.195 1.042 7.086 2.936a9.98 9.98 0 012.934 7.084c-.001 5.524-4.496 10.019-10.02 10.019zm5.498-7.514c-.301-.151-1.782-.879-2.059-.98-.276-.1-.478-.151-.678.151-.201.302-.78 1.018-.954 1.22-.175.201-.352.226-.653.075-.302-.15-1.272-.469-2.424-1.494-.897-.798-1.503-1.785-1.678-2.087-.175-.302-.019-.465.132-.616.136-.136.302-.352.453-.528.151-.176.201-.302.302-.503.1-.201.05-.377-.025-.528-.075-.15-.678-1.634-.93-2.237-.245-.589-.494-.509-.678-.519-.175-.008-.377-.008-.578-.008-.201 0-.528.075-.804.377-.276.302-1.055 1.03-1.055 2.513 0 1.483 1.08 2.915 1.231 3.116.151.201 2.126 3.245 5.147 4.549.719.311 1.28.496 1.718.636.722.23 1.38.197 1.897.12.58-.087 1.782-.729 2.033-1.433.251-.703.251-1.307.176-1.433-.075-.126-.276-.201-.578-.352z"/>
                                </svg>
                            </div>
                        </a>
                        <a href="https://wa.me/94707227877" target="_blank" rel="noopener noreferrer" class="text-[#FAFAFA] font-inter text-sm hover:text-white transition-colors notranslate">+94 70 722 7877</a>
                    </div>

                    <!-- QR Code Section -->
                    <div class="border-t border-white/10 pt-6 mt-6 flex flex-col items-center">
                        <p class="text-xs text-white/70 mb-3 font-medium tracking-wide">Scan to Submit Complaints / Suggestions</p>
                        <div class="w-40 h-40 bg-white p-2 rounded-2xl flex items-center justify-center shadow-sm">
                            <img loading="lazy" src="assets/img/IAU/IAU_QR.png" alt="IAU QR Code" class="w-full h-full object-contain rounded-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Grid Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-[#F1F5F9] border-t border-b border-slate-200/90 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 font-montserrat mb-12 text-center md:text-left">Internal Affairs Unit Contact Information</h2>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-gray-100 border-[0.5px] border-[#D4D4D4] rounded-[32px] overflow-hidden">
            <?php foreach($iau_staff as $staff): ?>
            <div onclick="openModal('<?php echo $staff['id']; ?>')" class="bg-white cursor-pointer hover:bg-gray-50 transition-colors p-4 sm:p-6 md:p-8 flex flex-col items-center justify-center text-center h-full">
                <h4 class="text-base md:text-lg font-semibold font-montserrat text-gray-900 mb-1.5 md:mb-2"><?php echo $staff['title']; ?></h4>
                <?php if($staff['department']): ?>
                <p class="text-xs md:text-sm font-inter text-gray-500"><?php echo $staff['department']; ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PDF Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white border-t border-slate-200/80">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row gap-8 justify-start items-center">
            <div class="w-full max-w-[400px]">
                <?php 
                    $pdfId = 'iau-pdf-1';
                    $pdfUrl = 'assets/img/IAU/pdf-1.pdf';
                    $pdfTitle = 'IAU Document 1';
                    include 'includes/pdf-viewer.php'; 
                ?>
            </div>
            <div class="w-full max-w-[400px]">
                <?php 
                    $pdfId = 'iau-pdf-2';
                    $pdfUrl = 'assets/img/IAU/pdf-2.pdf';
                    $pdfTitle = 'IAU Document 2';
                    include 'includes/pdf-viewer.php'; 
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Staff Modals -->
<?php foreach($iau_staff as $staff): ?>
<div id="<?php echo $staff['id']; ?>" class="fixed inset-0 z-[150] hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('<?php echo $staff['id']; ?>')"></div>
    
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-[600px] bg-secondary rounded-2xl shadow-2xl p-6 sm:p-8 md:p-12 text-center text-white">
        <button onclick="closeModal('<?php echo $staff['id']; ?>')" class="absolute top-4 right-4 md:top-6 md:right-6 text-white/80 hover:text-white transition-all z-10 bg-black/20 hover:bg-black/40 rounded-full p-1.5 active:scale-95 flex items-center justify-center focus:outline-none">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <h3 class="text-xl md:text-[26px] font-semibold font-montserrat mb-4 md:mb-6"><?php echo $staff['title']; ?><?php if($staff['department']) echo ' - ' . $staff['department']; ?></h3>
        
        <hr class="border-white/50 w-[85%] mx-auto mb-6 md:mb-8">
        
        <div class="space-y-2 md:space-y-3 font-inter">
            <p class="text-[20px] sm:text-2xl md:text-[28px] font-semibold font-montserrat mb-1 md:mb-2 leading-tight"><?php echo $staff['name']; ?></p>
            <?php if($staff['designation']): ?>
            <p class="text-base md:text-lg pb-1 md:pb-2"><?php echo $staff['designation']; ?></p>
            <?php endif; ?>
            <p class="text-xs md:text-[15px]">Tel: <?php echo $staff['phone']; ?></p>
            <p class="text-xs md:text-[15px]">Email: <?php echo $staff['email']; ?></p>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            if (modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 10);
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
            document.body.classList.remove('overflow-hidden');
        }
    }
</script>

<?php include 'includes/pdf-modal.php'; ?>
<?php include 'includes/footer.php'; ?>
