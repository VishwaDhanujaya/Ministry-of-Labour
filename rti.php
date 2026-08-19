<?php
// rti.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'si', 'ta'])) {
    $current_lang = $_GET['lang'];
} elseif (isset($_SESSION['lang']) && in_array($_SESSION['lang'], ['en', 'si', 'ta'])) {
    $current_lang = $_SESSION['lang'];
}

require_once 'admin/includes/db.php';

$rti_division = $pdo->query("SELECT id FROM divisions WHERE slug = 'rti-officers'")->fetchColumn();
$rti_officers_raw = [];
if ($rti_division) {
    $stmt = $pdo->prepare("SELECT * FROM officials WHERE division_id = ? AND is_active = 1 ORDER BY sort_order ASC, id ASC");
    $stmt->execute([$rti_division]);
    $rti_officers_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$officers_list = [
    'designated' => [],
    'information' => [],
    'central' => []
];

// Predefined translated addresses
$ministry_address = [
    'en' => 'Ministry of Labour, 6th Floor, "Mehewara Piyesa", Narahenpita, Colombo 05',
    'si' => 'කම්කරු අමාත්‍යංශය, හයවන මහල, “මෙහෙවර පියෙස”, නාරාහේන්පිට, කොළඹ 05',
    'ta' => 'தோழில் அமைச்சு, 6வது மாடி, "மெஹெவர பியச", நாரஹேன்பிட்ட, கொழும்பு 05'
];

foreach ($rti_officers_raw as $officer) {
    $title_lower = strtolower($officer['title']);
    $type = 'information';
    if (strpos($title_lower, 'designated') !== false) {
        $type = 'designated';
    } elseif (strpos($title_lower, 'central') !== false) {
        $type = 'central';
    }
    
    $address = $ministry_address[$current_lang];
    
    $name = !empty($officer['name_' . $current_lang]) ? $officer['name_' . $current_lang] : $officer['name'];
    $designation = !empty($officer['title_' . $current_lang]) ? $officer['title_' . $current_lang] : $officer['title'];
    
    $officers_list[$type][] = [
        'name' => $name,
        'name_en' => $officer['name'],
        'designation' => $designation,
        'address' => $address,
        'tel' => $officer['phone'],
        'fax' => $officer['fax'],
        'email' => $officer['email'],
    ];
}

if (!function_exists('get_initials')) {
    function get_initials(string $name): string {
        $clean_name = preg_replace('/^(Mr\.|Mrs\.|Ms\.|Dr\.|Prof\.|Rev\.)\s+/i', '', $name);
        $words = explode(' ', trim($clean_name));
        $initials = '';
        foreach ($words as $w) {
            if (mb_strlen($w) > 0) {
                $initials .= mb_substr($w, 0, 1);
                if (mb_strlen($initials) >= 2) break;
            }
        }
        return mb_strtoupper($initials);
    }
}
include 'includes/header.php';

$page_title = 'RTI <span class="text-2xl md:text-3xl font-medium tracking-normal pb-1">' . t('rti_sub_title', '(Right to Information)') . '</span>';
$pageTitle = 'RTI ' . t('rti_sub_title', '(Right to Information)') . ' - Ministry of Labour - Sri Lanka';
$breadcrumbs = [
    ['label' => 'RTI']
];

$metaDescription = 'Learn about the Right to Information (RTI) Act in Sri Lanka, how to request information from the Ministry of Labour, and download necessary RTI forms and documents.';
$metaKeywords = 'Right to Information, RTI, Ministry of Labour, Sri Lanka, Information Request';
$title_classes = 'flex items-end gap-2';

include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-white overflow-hidden">
    <div class="container mx-auto">
        
        <!-- Commitment & Overview: 2-Column Grid -->
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-center mb-16">
            <!-- Left Column: Commitment text -->
            <div class="w-full lg:w-1/2" data-aos="fade-right">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-6 notranslate"><?= t('rti', 'Right to Information') ?></h2>
                <div class="bg-[#FAFAFA] border-l-4 border-secondary p-6 rounded-r-2xl shadow-sm">
                    <p class="text-gray-800 font-inter text-[15px] md:text-[16px] leading-relaxed font-semibold notranslate">
                        <?= t('rti_intro') ?>
                    </p>
                </div>
            </div>
            <!-- Right Column: Generated concept image -->
            <div class="w-full lg:w-1/2" data-aos="fade-left">
                <div class="relative group rounded-3xl overflow-hidden shadow-md border-[0.5px] border-[#D4D4D4] bg-white p-2">
                    <img loading="lazy" src="assets/img/rti-concept.jpg" alt="Right to Information" class="w-full h-auto object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-500">
                </div>
            </div>
        </div>

        <!-- Vision & Mission Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-12" data-aos="fade-up" data-aos-delay="100">
            <!-- Vision Card -->
            <div class="bg-white border-l-4 border-primary rounded-r-[24px] border-t border-b border-r border-gray-200/80 p-6 md:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transform transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold font-montserrat text-primary notranslate">
                        <?= t('rti_vision_title', 'Vision') ?>
                    </h4>
                </div>
                <p class="text-gray-600 font-inter text-[14px] leading-relaxed notranslate">
                    <?= t('rti_vision') ?>
                </p>
            </div>
            
            <!-- Mission Card -->
            <div class="bg-white border-l-4 border-secondary rounded-r-[24px] border-t border-b border-r border-gray-200/80 p-6 md:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transform transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-secondary/5 text-secondary flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold font-montserrat text-secondary notranslate">
                        <?= t('rti_mission_title', 'Mission') ?>
                    </h4>
                </div>
                <p class="text-gray-600 font-inter text-[14px] leading-relaxed notranslate">
                    <?= t('rti_mission') ?>
                </p>
            </div>
        </div>

    </div>
</section>

<!-- RTI Officers Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-[#F1F5F9] border-t border-b border-slate-200/80 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-8 text-center md:text-left notranslate" data-aos="fade-up">
            <?= t('rti_officers_title', 'RTI Officers') ?>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="100">
            <?php foreach (['designated', 'information', 'central'] as $type): ?>
                <?php foreach ($officers_list[$type] as $officer): ?>
                    <div class="bg-white rounded-[32px] border border-gray-200/80 p-6 md:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transform transition-all duration-300 flex flex-col justify-between h-full group">
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-primary/10 to-primary/5 text-primary border border-primary/10 flex items-center justify-center font-montserrat font-bold text-lg shrink-0 group-hover:scale-105 transition-transform duration-300 notranslate" translate="no">
                                    <?= htmlspecialchars(get_initials($officer['name_en'])) ?>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-primary/5 text-primary border border-primary/10 mb-1 notranslate">
                                        <?= t('rti_' . $type . '_officer') ?>
                                    </span>
                                    <h3 class="text-base font-bold font-montserrat text-gray-900 leading-snug">
                                        <?= htmlspecialchars($officer['name']) ?>
                                    </h3>
                                </div>
                            </div>
                            
                            <p class="text-xs md:text-sm font-inter text-gray-500 font-semibold mb-6 min-h-[36px]">
                                <?= htmlspecialchars($officer['designation']) ?>
                            </p>
                            
                            <?php if (!empty($officer['address']) || !empty($officer['tel']) || !empty($officer['fax']) || !empty($officer['email'])): ?>
                            <div class="space-y-4 border-t border-gray-100 pt-6 font-inter text-[13px] text-gray-600">
                                <?php if (!empty($officer['address'])): ?>
                                <div class="flex items-start gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center shrink-0 text-gray-400 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="notranslate leading-relaxed"><?= nl2br(htmlspecialchars($officer['address'])) ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($officer['tel'])): ?>
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center shrink-0 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <a href="tel:<?= htmlspecialchars(str_replace(' ', '', $officer['tel'])) ?>" class="hover:text-secondary transition-colors notranslate font-semibold">
                                        <?= htmlspecialchars($officer['tel']) ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($officer['fax'])): ?>
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center shrink-0 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                    </div>
                                    <span class="notranslate font-semibold"><?= htmlspecialchars($officer['fax']) ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($officer['email'])): ?>
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center shrink-0 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <a href="mailto:<?= htmlspecialchars($officer['email']) ?>" class="hover:text-secondary transition-colors notranslate text-xs break-all">
                                        <?= htmlspecialchars($officer['email']) ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php elseif ($type === 'central'): ?>
                            <div class="border-t border-gray-100 pt-6 font-inter text-[13px] text-gray-500">
                                <p class="leading-relaxed notranslate">
                                    <?= t('rti_central_officer_desc') ?>
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- RTI Forms and Details Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-white border-t border-gray-200">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-8 text-center md:text-left notranslate" data-aos="fade-up">
            <?= t('rti_section_title', 'Forms & Details') ?>
        </h2>
        
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            <!-- Left Column: Details -->
            <div class="w-full lg:w-[65%] space-y-12" data-aos="fade-right">
                
                <!-- Introduction -->
                <div class="prose max-w-none">
                    <p class="text-gray-700 font-inter text-[15px] md:text-[16px] leading-relaxed font-semibold notranslate">
                        <?= t('rti_act_intro') ?>
                    </p>
                </div>
                
                <!-- Section A: Complaints and Labour Laws -->
                <div class="bg-[#FAFAFA] border border-gray-200/60 rounded-3xl p-6 md:p-8 shadow-sm">
                    <h3 class="text-lg md:text-xl font-bold font-montserrat text-primary mb-4 notranslate">
                        <?= t('rti_complaints_title', 'Complaints & Labour Laws Information') ?>
                    </h3>
                    <div class="space-y-4 font-inter text-[14px] text-gray-600 leading-relaxed notranslate font-medium">
                        <p><?= t('rti_complaints_text_1') ?></p>
                        <p><?= t('rti_complaints_text_2') ?></p>
                        <p><?= t('rti_complaints_text_3') ?></p>
                    </div>
                </div>
                
                <!-- Section B: Requests -->
                <div class="bg-white border border-gray-200/60 rounded-3xl p-6 md:p-8 shadow-sm">
                    <h3 class="text-lg md:text-xl font-bold font-montserrat text-primary mb-4 notranslate">
                        <?= t('rti_request_title', 'Notice: Submitting Information Requests') ?>
                    </h3>
                    <p class="font-semibold font-inter text-[14px] text-gray-700 mb-4 notranslate">
                        <?= t('rti_request_intro') ?>
                    </p>
                    <ul class="list-disc pl-5 space-y-3 font-inter text-[14px] text-gray-600 leading-relaxed notranslate">
                        <li><?= t('rti_request_list_1') ?></li>
                        <li><?= t('rti_request_list_2') ?></li>
                        <li><?= t('rti_request_list_3') ?></li>
                        <li><?= t('rti_request_list_4') ?></li>
                        <li><?= t('rti_request_list_5') ?></li>
                    </ul>
                </div>
                
                <!-- Section C: Appeals -->
                <div class="bg-white border border-gray-200/60 rounded-3xl p-6 md:p-8 shadow-sm">
                    <h3 class="text-lg md:text-xl font-bold font-montserrat text-primary mb-4 notranslate">
                        <?= t('rti_appeals_title', 'Notice: Appeals Process') ?>
                    </h3>
                    <p class="font-semibold font-inter text-[14px] text-gray-700 mb-4 notranslate">
                        <?= t('rti_appeals_intro') ?>
                    </p>
                    <ul class="list-disc pl-5 space-y-3 font-inter text-[14px] text-gray-600 leading-relaxed mb-4 notranslate">
                        <li><?= t('rti_appeals_item_1') ?></li>
                        <li><?= t('rti_appeals_item_2') ?></li>
                        <li><?= t('rti_appeals_item_3') ?></li>
                        <li><?= t('rti_appeals_item_4') ?></li>
                        <li><?= t('rti_appeals_item_5') ?></li>
                        <li><?= t('rti_appeals_item_6') ?></li>
                        <li><?= t('rti_appeals_item_7') ?></li>
                    </ul>
                    <p class="font-inter text-[14px] text-gray-600 leading-relaxed border-t border-gray-100 pt-4 notranslate">
                        <?= t('rti_appeals_outro') ?>
                    </p>
                </div>
            </div>
            
            <!-- Right Column: Sidebar Downloads Card -->
            <div class="w-full lg:w-[35%]" data-aos="fade-left">
                <div class="bg-[#FAFAFA] rounded-[32px] border border-gray-200/80 p-6 md:p-8 shadow-sm sticky top-28">
                    <h3 class="text-lg font-bold font-montserrat text-primary mb-2 notranslate">
                        <?= t('rti_download_box_title', 'Downloads & Forms') ?>
                    </h3>
                    <p class="text-xs font-inter text-gray-500 mb-6 notranslate">
                        <?= t('rti_download_box_desc') ?>
                    </p>
                    
                    <div class="space-y-4">
                        <!-- Link 1 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= t('rti_doc_1') ?>
                            </h4>
                            <a href="https://www.parliament.lk/uploads/acts/gbills/english/6007.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= t('download', 'Download') ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 2 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= t('rti_doc_2') ?>
                            </h4>
                            <a href="https://www.parliament.lk/files/rti/regulations-20170203-2004-66-en.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= t('download', 'Download') ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 3 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= t('rti_doc_3') ?>
                            </h4>
                            <a href="https://www.parliament.lk/files/rti/form-RTI01-en.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= t('download', 'Download') ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 4 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= t('rti_doc_4') ?>
                            </h4>
                            <a href="https://www.parliament.lk/files/rti/form-RTI10-en.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= t('download', 'Download') ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 5 -->
                        <div>
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= t('rti_doc_5') ?>
                            </h4>
                            <a href="https://labourdept.gov.lk/information-officers-list/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= t('view_pdf', 'View List') ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Standalone More Info Callout Section -->
<section class="py-12 md:py-16 px-4 md:px-16 bg-white border-t border-gray-200 overflow-hidden">
    <div class="container mx-auto" data-aos="zoom-in">
        <div class="relative bg-gradient-to-r from-primary to-primary/95 text-white rounded-[32px] p-8 md:p-12 shadow-lg overflow-hidden border border-white/10">
            <!-- Background Decorative Mesh -->
            <div class="absolute inset-0 bg-mesh-pattern opacity-10 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 text-white flex items-center justify-center shrink-0 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 01-18 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold font-montserrat notranslate">
                            <?= t('rti_more_info_title', 'For more information') ?>
                        </h4>
                        <p class="text-sm font-inter text-gray-200 mt-2 max-w-xl notranslate">
                            <?= t('rti_more_info_desc') ?>
                        </p>
                    </div>
                </div>
                <a href="https://www.rti.gov.lk" target="_blank" rel="noopener noreferrer" class="bg-secondary text-white hover:bg-secondary/90 hover:scale-105 active:scale-95 px-8 py-4 rounded-2xl text-sm font-bold transition-all shadow-md flex items-center gap-2 notranslate shrink-0">
                    <span>rti.gov.lk</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
