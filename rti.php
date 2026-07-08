<?php
// rti.php
// Initialize current_lang from cookie for frontend display and UI states
$current_lang = isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['en', 'si', 'ta']) ? $_COOKIE['lang'] : 'en';

$rti_texts = [
    'en' => [
        'intro' => 'At the Ministry of Labour, we are committed to transparency and accountability. In line with this commitment, we fully support the Right to Information (RTI) Act No. 12 of 2016, ensuring that you have easy access to the information you require.',
        'vision_title' => 'Vision',
        'vision' => 'To ensure the right of citizens of Sri Lanka to access information related to the labour sector.',
        'mission_title' => 'Mission',
        'mission' => 'To promote and safeguard the right of access to information held by the Ministry of Labour and its affiliated institutions, while providing Sri Lankan citizens with a more effective and efficient service through transparency.',
        'officers_title' => 'RTI Officers',
        'designated_officer' => 'Designated Officer',
        'information_officer' => 'Information Officer',
        'central_officer' => 'Central Officer',
        'name_lbl' => 'Name',
        'designation_lbl' => 'Designation',
        'address_lbl' => 'Address',
        'tel_lbl' => 'Telephone',
        'fax_lbl' => 'Fax',
        'email_lbl' => 'Email',
        'more_info_lbl' => 'For more information',
        'more_info_desc' => 'Visit the official government Right to Information portal for forms, rules, and further circulars.',
        'website_lbl' => 'Website',
    ],
    'si' => [
        'intro' => 'කම්කරු අමාත්‍යාංශයේදී, අපි විනිවිදභාවය සහ වගවීම සඳහා කැපවී සිටිමු. මෙම කැපවීමට අනුකූලව, ඔබට අවශ්‍ය තොරතුරු වෙත පහසුවෙන් ප්‍රවේශ විය හැකි බව සහතික කරමින්, 2016 අංක 12 දරන තොරතුරු දැනගැනීමේ අයිතිවාසිකම් (RTI) පනතට අපි පූර්ණ සහාය දෙමු.',
        'vision_title' => 'දැක්ම',
        'vision' => 'ශ්‍රී ලංකාවේ පුරවැසියන් සඳහා කම්කරු ක්ෂේත්‍රයට අයත් තොරතුරු වෙත ප්‍රවේශ වීමේ අයිතිය තහවුරු කිරීම.',
        'mission_title' => 'මෙහෙවර',
        'mission' => 'කම්කරු අමාත්‍යාංශය සහ ඊට අනුබද්ධ ආයතන සතුව ඇති තොරතුරු වෙත ප්‍රවේශ වීමේ අයිතිය සංවර්ධනය කිරීම සහ ආරක්ෂා කිරීම සහ ශ්‍රී ලංකාවේ පුරවැසියන්ට විනිවිදභාවයෙන් යුතුව වඩාත් ඵලදායී හා කාර්යක්ෂම සේවාවක් සැපයීම.',
        'officers_title' => 'තොරතුරු දැනගැනීමේ නිලධාරීන්',
        'designated_officer' => 'නම්කළ නිලධාරී',
        'information_officer' => 'තොරතුරු නිලධාරී',
        'central_officer' => 'කේන්ද්‍රීය නිලධාරී',
        'name_lbl' => 'නම',
        'designation_lbl' => 'තනතුර',
        'address_lbl' => 'ලිපිනය',
        'tel_lbl' => 'දුරකථන අංකය',
        'fax_lbl' => 'ෆැක්ස් අංකය',
        'email_lbl' => 'ඊමේල් ලිපිනය',
        'more_info_lbl' => 'වැඩිදුර තොරතුරු සඳහා',
        'more_info_desc' => 'පෝරම, නීති සහ වැඩිදුර චක්‍රලේඛ සඳහා රජයේ නිල තොරතුරු දැනගැනීමේ ද්වාරය වෙත පිවිසෙන්න.',
        'website_lbl' => 'වෙබ් අඩවිය',
    ],
    'ta' => [
        'intro' => 'தோழில் அமைச்சில், வெளிப்படைத்தன்மை மற்றும் பொறுப்புக்கூறலுக்கு நாம் கடமைப்பட்டுள்ளோம். இந்த உறுதிப்பாட்டிற்கு இணங்க, 2016 ஆம் ஆண்டின் 12 ஆம் இலக்க தகவல் அறியும் உரிமை (RTI) சட்டத்திற்கு நாங்கள் முழு ஆதரவை வழங்குவதுடன், உங்களுக்குத் தேவையான தகவல்களை எளிதாக அணுகுவதை உறுதிசெய்கிறோம்.',
        'vision_title' => 'தொலைநோக்கு',
        'vision' => 'இலங்கை குடிமக்களுக்கு தொழிலாளர் துறை சார்ந்த தகவல்களை அணுகும் உரிமையை உறுதி செய்தல்.',
        'mission_title' => 'பணிப்பணிப்பு',
        'mission' => 'தோழில் அமைச்சு மற்றும் அதன் இணைந்த நிறுவனங்கள் வைத்துள்ள தகவல்களை அணுகும் உரிமையை மேம்படுத்துவதும் பாதுகாப்பதும், அதே வேளையில் இலங்கை குடிமக்களுக்கு வெளிப்படைத்தன்மையின் மூலம் மிகவும் பயனுள்ள மற்றும் திறமையான சேவையை வழங்குதல்.',
        'officers_title' => 'தகவல் அறியும் உரிமை அதிகாரிகள்',
        'designated_officer' => 'நியமிக்கப்பட்ட அதிகாரி',
        'information_officer' => 'தகவல் அதிகாரி',
        'central_officer' => 'மத்திய அதிகாரி',
        'name_lbl' => 'பெயர்',
        'designation_lbl' => 'பதவி',
        'address_lbl' => 'முகவரி',
        'tel_lbl' => 'தொலைபேசி',
        'fax_lbl' => 'தொலைநகல்',
        'email_lbl' => 'மின்னஞ்சல்',
        'more_info_lbl' => 'மேலும் தகவலுக்கு',
        'more_info_desc' => 'படிவங்கள், விதிகள் மற்றும் மேலதிக சுற்றறிக்கைகளுக்கு அரசாங்கத்தின் உத்தியோகபூர்வ தகவல் அறியும் போர்ட்டலுக்கு விஜயம் செய்யுங்கள்.',
        'website_lbl' => 'இணையதள முகவரி',
    ]
];

$officers_list = [
    'designated' => [
        'en' => [
            'name' => 'Mr. Lal Samarasekara',
            'designation' => 'Additional Secretary (Development)',
            'address' => 'Ministry of Labour, 6th Floor, "Mehewara Piyesa", Narahenpita, Colombo 05',
            'tel' => '+94 11 258 6337',
        ],
        'si' => [
            'name' => 'ලාල් සමරසේකර මහතා',
            'designation' => 'අතිරේක ලේකම් (සංවර්ධන)',
            'address' => 'කම්කරු අමාත්‍යංශය, හයවන මහල, “මෙහෙවර පියෙස”, නාරාහේන්පිට, කොළඹ 05',
            'tel' => '011-2586337',
        ],
        'ta' => [
            'name' => 'திரு. லால் சமரசேகர',
            'designation' => 'மேலதிக செயலாளர் (அபிவிருத்தி)',
            'address' => 'தோழில் அமைச்சு, 6வது மாடி, "மெஹெவர பியச", நாரஹேன்பிட்ட, கொழும்பு 05',
            'tel' => '+94 11 258 6337',
        ]
    ],
    'information' => [
        'en' => [
            'name' => 'Mr. P.D. Chandana Pathirage',
            'designation' => 'Director (Development)',
            'address' => 'Ministry of Labour, 6th Floor, "Mehewara Piyesa", Narahenpita, Colombo 05',
            'tel' => '+94 11 250 2807',
            'fax' => '+94 11 236 8165',
            'email' => 'dir.dev@labourmin.gov.lk',
        ],
        'si' => [
            'name' => 'පී.ඩී. චන්දන පතිරගේ මහතා',
            'designation' => 'අධ්‍යක්ෂ (සංවර්ධන)',
            'address' => 'කම්කරු අමාත්‍යංශය, හයවන මහල, “මෙහෙවර පියෙස”, නාරාහේන්පිට, කොළඹ 05',
            'tel' => '011-2502807',
            'fax' => '011-2368165',
            'email' => 'dir.dev@labourmin.gov.lk',
        ],
        'ta' => [
            'name' => 'திரு. பி.டி. சந்தன பத்திரகே',
            'designation' => 'பணிப்பாளர் (அபிவிருத்தி)',
            'address' => 'தோழில் அமைச்சு, 6வது மாடி, "மெஹெவர பியச", நாரஹேன்பிட்ட, கொழும்பு 05',
            'tel' => '+94 11 250 2807',
            'fax' => '+94 11 236 8165',
            'email' => 'dir.dev@labourmin.gov.lk',
        ]
    ],
    'central' => [
        'en' => [
            'name' => 'Mr. W.L.I.N. Senarathna',
            'designation' => 'Development Officer',
        ],
        'si' => [
            'name' => 'ඩබ්.එල්.අයි.එන්. සේනාරත්න මහතා',
            'designation' => 'සංවර්ධන නිලධාරී',
        ],
        'ta' => [
            'name' => 'திரு. டபிள்யூ. எல். ஐ. என். சேனாரத்ன',
            'designation' => 'அபிவிருத்தி அதிகாரி',
        ]
    ]
];

if ($current_lang === 'si') {
    $page_title = 'තොරතුරු දැනගැනීමේ අයිතිය <span class="text-2xl md:text-3xl font-medium tracking-normal pb-1">(RTI)</span>';
    $pageTitle = 'තොරතුරු දැනගැනීමේ අයිතිය (RTI) - කම්කරු අමාත්‍යාංශය - ශ්‍රී ලංකාව';
    $breadcrumbs = [
        ['label' => 'තොරතුරු දැනගැනීමේ අයිතිය']
    ];
} elseif ($current_lang === 'ta') {
    $page_title = 'தகவல் அறியும் உரிமை <span class="text-2xl md:text-3xl font-medium tracking-normal pb-1">(RTI)</span>';
    $pageTitle = 'தகவல் அறியும் உரிமை (RTI) - தோழில் அமைச்சு - இலங்கை';
    $breadcrumbs = [
        ['label' => 'தகவல் அறியும் உரிமை']
    ];
} else {
    $page_title = 'RTI <span class="text-2xl md:text-3xl font-medium tracking-normal pb-1">(Right to Information)</span>';
    $pageTitle = 'Right to Information (RTI) - Ministry of Labour - Sri Lanka';
    $breadcrumbs = [
        ['label' => 'RTI']
    ];
}

$metaDescription = 'Learn about the Right to Information (RTI) Act in Sri Lanka, how to request information from the Ministry of Labour, and download necessary RTI forms and documents.';
$metaKeywords = 'Right to Information, RTI, Ministry of Labour, Sri Lanka, Information Request';
$title_classes = 'flex items-end gap-2';

include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-5xl">
        
        <!-- Commitment, Vision & Mission Intro Section -->
        <div class="space-y-8">
            <!-- Commitment Statement -->
            <div class="bg-[#FAFAFA] border-[0.5px] border-[#D4D4D4] p-6 md:p-8 rounded-[24px] shadow-sm">
                <p class="text-gray-800 font-inter text-[16px] leading-relaxed font-semibold notranslate">
                    <?= htmlspecialchars($rti_texts[$current_lang]['intro']) ?>
                </p>
            </div>
            
            <!-- Vision & Mission Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-8">
                <!-- Vision Card -->
                <div class="bg-white border-[0.5px] border-[#D4D4D4] rounded-[24px] p-6 md:p-8 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h4 class="text-base font-bold font-montserrat text-primary notranslate">
                            <?= htmlspecialchars($rti_texts[$current_lang]['vision_title']) ?>
                        </h4>
                    </div>
                    <p class="text-gray-600 font-inter text-[14px] leading-relaxed notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['vision']) ?>
                    </p>
                </div>
                
                <!-- Mission Card -->
                <div class="bg-white border-[0.5px] border-[#D4D4D4] rounded-[24px] p-6 md:p-8 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-secondary/5 text-secondary flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="text-base font-bold font-montserrat text-secondary notranslate">
                            <?= htmlspecialchars($rti_texts[$current_lang]['mission_title']) ?>
                        </h4>
                    </div>
                    <p class="text-gray-600 font-inter text-[14px] leading-relaxed notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['mission']) ?>
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- RTI Officers Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-[#FAFAFA] border-t border-gray-200">
    <div class="container mx-auto max-w-5xl">
        <h2 class="text-3xl md:text-4xl font-bold text-primary font-montserrat mb-12 text-center md:text-left notranslate">
            <?= htmlspecialchars($rti_texts[$current_lang]['officers_title']) ?>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Designated Officer Card -->
            <div class="bg-white rounded-[32px] border-[0.5px] border-[#D4D4D4] p-6 md:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transform transition-all duration-300 flex flex-col justify-between h-full">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary/5 text-primary border border-primary/10 mb-6 notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['designated_officer']) ?>
                    </span>
                    
                    <h3 class="text-[17px] md:text-lg font-bold font-montserrat text-gray-900 mb-2 notranslate">
                        <?= htmlspecialchars($officers_list['designated'][$current_lang]['name']) ?>
                    </h3>
                    
                    <p class="text-xs md:text-sm font-inter text-gray-500 font-semibold mb-6 notranslate">
                        <?= htmlspecialchars($officers_list['designated'][$current_lang]['designation']) ?>
                    </p>
                    
                    <div class="space-y-4 border-t border-gray-100 pt-6 font-inter text-sm text-gray-600">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="notranslate"><?= htmlspecialchars($officers_list['designated'][$current_lang]['address']) ?></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:<?= htmlspecialchars(str_replace(' ', '', $officers_list['designated'][$current_lang]['tel'])) ?>" class="hover:text-secondary transition-colors notranslate">
                                <?= htmlspecialchars($officers_list['designated'][$current_lang]['tel']) ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Information Officer Card -->
            <div class="bg-white rounded-[32px] border-[0.5px] border-[#D4D4D4] p-6 md:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transform transition-all duration-300 flex flex-col justify-between h-full">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary/5 text-primary border border-primary/10 mb-6 notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['information_officer']) ?>
                    </span>
                    
                    <h3 class="text-[17px] md:text-lg font-bold font-montserrat text-gray-900 mb-2 notranslate">
                        <?= htmlspecialchars($officers_list['information'][$current_lang]['name']) ?>
                    </h3>
                    
                    <p class="text-xs md:text-sm font-inter text-gray-500 font-semibold mb-6 notranslate">
                        <?= htmlspecialchars($officers_list['information'][$current_lang]['designation']) ?>
                    </p>
                    
                    <div class="space-y-4 border-t border-gray-100 pt-6 font-inter text-sm text-gray-600">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="notranslate"><?= htmlspecialchars($officers_list['information'][$current_lang]['address']) ?></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:<?= htmlspecialchars(str_replace(' ', '', $officers_list['information'][$current_lang]['tel'])) ?>" class="hover:text-secondary transition-colors notranslate">
                                <?= htmlspecialchars($officers_list['information'][$current_lang]['tel']) ?>
                            </a>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            <span class="notranslate"><?= htmlspecialchars($officers_list['information'][$current_lang]['fax']) ?></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:<?= htmlspecialchars($officers_list['information'][$current_lang]['email']) ?>" class="hover:text-secondary transition-colors notranslate text-xs md:text-sm">
                                <?= htmlspecialchars($officers_list['information'][$current_lang]['email']) ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Central Officer Card -->
            <div class="bg-white rounded-[32px] border-[0.5px] border-[#D4D4D4] p-6 md:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transform transition-all duration-300 flex flex-col justify-between h-full">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary/5 text-primary border border-primary/10 mb-6 notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['central_officer']) ?>
                    </span>
                    
                    <h3 class="text-[17px] md:text-lg font-bold font-montserrat text-gray-900 mb-2 notranslate">
                        <?= htmlspecialchars($officers_list['central'][$current_lang]['name']) ?>
                    </h3>
                    
                    <p class="text-xs md:text-sm font-inter text-gray-500 font-semibold mb-6 notranslate">
                        <?= htmlspecialchars($officers_list['central'][$current_lang]['designation']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Standalone More Info Callout Section -->
<section class="py-16 px-4 md:px-16 bg-white border-t border-gray-200">
    <div class="container mx-auto max-w-5xl">
        <div class="bg-white border-[0.5px] border-[#D4D4D4] rounded-[24px] p-6 md:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center gap-4 text-center sm:text-left">
                <div class="w-12 h-12 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 01-18 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-bold font-montserrat text-primary notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['more_info_lbl']) ?>
                    </h4>
                    <p class="text-xs md:text-sm font-inter text-gray-500 mt-1 notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['more_info_desc']) ?>
                    </p>
                </div>
            </div>
            <a href="https://www.rti.gov.lk" target="_blank" rel="noopener noreferrer" class="bg-primary text-white hover:bg-secondary px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-sm active:scale-95 flex items-center gap-2 notranslate">
                <span>rti.gov.lk</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
