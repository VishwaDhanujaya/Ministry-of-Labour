<?php
// complaints.php
require_once 'admin/includes/db.php';

// Detect active language
$current_lang = isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['en', 'si', 'ta']) ? $_COOKIE['lang'] : 'en';

// Localized Content
$localized_content = [
    'en' => [
        'page_title' => 'Complaints',
        'meta_description' => 'Submit your complaints to the Department of Labour CMS portal or escalate them directly to the Ministry of Labour via WhatsApp.',
        'meta_keywords' => 'Complaints, Department of Labour CMS, WhatsApp Complaint, Ministry of Labour, Sri Lanka',
        'section_subtitle' => 'Official Channels',
        'section_title' => 'Lodge a Complaint',
        'intro_text' => 'The Ministry of Labour, in coordination with the Department of Labour, provides official channels to submit, track, and resolve employee and public complaints. Please follow the steps below to ensure your complaint is routed and addressed effectively.',
        
        'cms_card_title' => 'Step 1: Department of Labour CMS Portal',
        'cms_card_desc' => 'To submit your complaint, please use the link below to access the official Department of Labour CMS portal. This is the primary and formal channel for registering complaints.',
        'cms_bullets' => [
            'Formal registration of dispute details and workplace issues',
            'Official tracking number provided instantly upon submission',
            'Complaints are routed directly to designated Department officers'
        ],
        'cms_btn_text' => 'Access Labour CMS Portal',
        'cms_link' => 'https://cms.labourdept.gov.lk/',
        
        'whatsapp_card_title' => 'Step 2: Ministry WhatsApp Escalation',
        'whatsapp_card_desc' => 'If you do not receive a satisfactory response to your complaint submitted through the CMS portal above, please contact the Ministry of Labour via WhatsApp:',
        'whatsapp_bullets' => [
            'Direct escalation channel to Ministry representatives',
            'Requires a valid Department of Labour CMS reference number',
            'Quick turnaround for unresolved inquiries and status updates'
        ],
        'whatsapp_number_label' => '070 722 7877 (WhatsApp Only)',
        'whatsapp_btn_text' => 'Contact via WhatsApp',
        'whatsapp_link' => 'https://wa.me/94707227877',
        
        'note_title' => 'Important Guidance',
        'note_text' => 'Please ensure you first attempt to submit your complaint via the Department of Labour CMS portal. This ensures all formal records are generated and processed through appropriate legal channels. Keep any reference numbers for subsequent WhatsApp escalation inquiries.'
    ],
    'si' => [
        'page_title' => 'පැමිණිලි',
        'meta_description' => 'කම්කරු දෙපාර්තමේන්තුවේ CMS ද්වාරය හරහා පැමිණිලි ඉදිරිපත් කරන්න හෝ කම්කරු අමාත්‍යාංශය WhatsApp මඟින් සම්බන්ධ කරගන්න.',
        'meta_keywords' => 'පැමිණිලි, කම්කරු දෙපාර්තමේන්තු CMS, WhatsApp පැමිණිලි, කම්කරු අමාත්‍යාංශය, ශ්‍රී ලංකාව',
        'section_subtitle' => 'නිල මාර්ග',
        'section_title' => 'පැමිණිල්ලක් ඉදිරිපත් කිරීම',
        'intro_text' => 'සේවකයින්ගේ සහ මහජනතාවගේ පැමිණිලි ඉදිරිපත් කිරීම, සොයා බැලීම සහ කඩිනම් කිරීම සඳහා කම්කරු අමාත්‍යාංශය සහ කම්කරු දෙපාර්තමේන්තුව ඒකාබද්ධව නිල මාර්ග සපයයි. ඔබගේ පැමිණිල්ල නිවැරදිව යොමු කිරීමට පහත පියවර අනුගමනය කරන්න.',
        
        'cms_card_title' => 'පියවර 1: කම්කරු දෙපාර්තමේන්තුවේ CMS ද්වාරය',
        'cms_card_desc' => 'ඔබගේ පැමිණිල්ල ඉදිරිපත් කිරීමට, කරුණාකර කම්කරු දෙපාර්තමේන්තුවේ නිල CMS ද්වාරය වෙත පිවිසීමට පහත සබැඳිය භාවිතා කරන්න:',
        'cms_bullets' => [
            'සේවා ස්ථාන ගැටලු සහ ආරවුල් පිළිබඳ නිල ලියාපදිංචිය',
            'පැමිණිල්ල ඉදිරිපත් කළ වහාම නිල යොමු අංකයක් ලබාදීම',
            'දෙපාර්තමේන්තුවේ නම් කළ නිලධාරීන් විසින් සෘජුවම විමර්ශන මෙහෙයවීම'
        ],
        'cms_btn_text' => 'CMS ද්වාරය වෙත පිවිසෙන්න',
        'cms_link' => 'https://cms.labourdept.gov.lk/',
        
        'whatsapp_card_title' => 'පියවර 2: අමාත්‍යාංශයේ WhatsApp සේවාව',
        'whatsapp_card_desc' => 'ඉහත සබැඳිය හරහා ඉදිරිපත් කරන ලද ඔබගේ පැමිණිල්ලට සතුටුදායක ප්‍රතිචාරයක් නොලැබුනේ නම්, කරුණාකර කම්කරු අමාත්‍යාංශය අපගේ නිල WhatsApp අංකය ඔස්සේ සම්බන්ධ කරගන්න:',
        'whatsapp_bullets' => [
            'අමාත්‍යාංශ නිලධාරීන් වෙත සෘජුවම පැමිණිල්ල යොමු කිරීමේ අවස්ථාව',
            'කම්කරු දෙපාර්තමේන්තුවේ වලංගු CMS යොමු අංකය ඉදිරිපත් කිරීම අවශ්‍ය වේ',
            'විසඳා නොමැති ගැටලු පිළිබඳ ඉක්මන් විමසීම් සහ ප්‍රගති සමාලෝචන'
        ],
        'whatsapp_number_label' => '070 722 7877 (WhatsApp පමණි)',
        'whatsapp_btn_text' => 'WhatsApp මඟින් සම්බන්ධ වන්න',
        'whatsapp_link' => 'https://wa.me/94707227877',
        
        'note_title' => 'වැදගත් උපදෙස්',
        'note_text' => 'පළමුව කම්කරු දෙපාර්තමේන්තුවේ CMS ද්වාරය හරහා පැමිණිල්ල ඉදිරිපත් කිරීමට කටයුතු කරන්න. එමඟින් අදාළ නීතිමය අංශ හරහා පැමිණිල්ල විමර්ශනය කිරීමට අවස්ථාව ලැබෙනු ඇත. පසුකාලීන විමසීම් සඳහා එහි සඳහන් යොමු අංකය සුරක්ෂිතව තබා ගන්න.'
    ],
    'ta' => [
        'page_title' => 'முறைப்பாடுகள்',
        'meta_description' => 'தொழிலாளர் திணைக்களத்தின் CMS போர்டல் மூலம் உங்கள் முறைப்பாடுகளைச் சமர்ப்பிக்கவும் அல்லது வாட்ஸ்அப் மூலம் தொழில் அமைச்சிற்கு அனுப்பவும்.',
        'meta_keywords' => 'முறைப்பாடுகள், தொழிலாளர் திணைக்களம் CMS, WhatsApp முறைப்பாடு, தொழில் அமைச்சு, இலங்கை',
        'section_subtitle' => 'உத்தியோகபூர்வ சேனல்கள்',
        'section_title' => 'முறைப்பாட்டைச் சமர்ப்பித்தல்',
        'intro_text' => 'தொழிலாளர்கள் மற்றும் பொதுமக்களின் முறைப்பாடுகளைச் சமர்ப்பிக்கவும், கண்காணிக்கவும் மற்றும் விரைவுபடுத்தவும் தொழில் அமைச்சு, தொழிலாளர் திணைக்களத்துடன் இணைந்து உத்தியோகபூர்வ வழிகளை வழங்குகிறது. முறைப்பாட்டைச் சரியாக அனுப்ப கீழே உள்ள வழிமுறைகளைப் பின்பற்றவும்.',
        
        'cms_card_title' => 'படி 1: தொழிலாளர் திணைக்களம் CMS போர்டல்',
        'cms_card_desc' => 'உங்கள் முறைப்பாட்டைச் சமர்ப்பிக்க, தொழிலாளர் திணைக்களத்தின் உத்தியோகபூர்வ CMS போர்ட்டலை அணுக கீழே உள்ள இணைப்பைப் பயன்படுத்தவும்:',
        'cms_bullets' => [
            'வேலைஸ்தல பிரச்சனைகள் மற்றும் தகராறுகளின் உத்தியோகபூர்வ பதிவு',
            'சமர்ப்பித்தவுடன் உடனடியாக வழங்கப்படும் உத்தியோகபூர்வ குறிப்பு எண்',
            'திணைக்களத்தின் நியமிக்கப்பட்ட அதிகாரிகளால் நேரடியாகக் கையாளப்படும்'
        ],
        'cms_btn_text' => 'CMS போர்ட்டலை அணுகவும்',
        'cms_link' => 'https://cms.labourdept.gov.lk/',
        
        'whatsapp_card_title' => 'படி 2: அமைச்சு வாட்ஸ்அப் (WhatsApp) சேவை',
        'whatsapp_card_desc' => 'மேலே உள்ள இணைப்பின் மூலம் சமர்ப்பிக்கப்பட்ட உங்கள் முறைப்பாட்டிற்கு திருப்திகரமான பதில் கிடைக்கவில்லை எனின், தயவுசெய்து தொழில் அமைச்சை எமது உத்தியோகபூர்வ வாட்ஸ்அப் எண் மூலம் தொடர்பு கொள்ளவும்:',
        'whatsapp_bullets' => [
            'அமைச்சின் பிரதிநிதிகளுக்கான நேரடி மேல்முறையீட்டு சேனல்',
            'செல்லுபடியாகும் தொழிலாளர் திணைக்களம் CMS குறிப்பு எண் தேவைப்படும்',
            'தீர்க்கப்படாத விசாரணைகள் மற்றும் நிலை புதுப்பிப்புகளுக்கான விரைவான பதில்'
        ],
        'whatsapp_number_label' => '070 722 7877 (வாட்ஸ்அப் மட்டும்)',
        'whatsapp_btn_text' => 'வாட்ஸ்அப் மூலம் தொடர்பு கொள்ளவும்',
        'whatsapp_link' => 'https://wa.me/94707227877',
        
        'note_title' => 'முக்கிய வழிகாட்டுதல்',
        'note_text' => 'முதலில் தொழிலாளர் திணைக்களத்தின் CMS போர்டல் மூலம் உங்கள் முறைப்பாட்டைச் சமர்ப்பிக்க முயற்சிக்கவும். இதன் மூலம் அனைத்து உத்தியோகபூர்வ ஆவணங்களும் சட்டத் திணைக்களங்கள் மூலம் செயலாக்கப்படும். வாட்ஸ்அப் மூலம் மேல்முறையீடு செய்ய அதன் குறிப்பு எண்ணைச் சேமித்துக்கொள்ளவும்.'
    ]
];

$content = $localized_content[$current_lang];

$page_title = $content['page_title'];
$pageTitle = $content['page_title'] . ' - Ministry of Labour - Sri Lanka';
$metaDescription = $content['meta_description'];
$metaKeywords = $content['meta_keywords'];

$breadcrumbs = [
    ['label' => $content['page_title']]
];

include 'includes/header.php';
include 'includes/sub-hero.php';
?>

<!-- Main Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-[#FAFAFA]">
    <div class="container mx-auto max-w-5xl">
        <!-- Section Title and Intro -->
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-secondary font-semibold text-xs md:text-sm tracking-[0.2em] uppercase mb-3 block font-inter"><?= htmlspecialchars($content['section_subtitle']) ?></span>
            <h2 class="text-3xl sm:text-4xl font-bold font-montserrat text-primary mb-5"><?= htmlspecialchars($content['section_title']) ?></h2>
            <div class="w-16 h-1 bg-gradient-to-r from-secondary to-yellow-500 mx-auto mb-6 rounded-full"></div>
            <p class="text-gray-500 text-[14.5px] md:text-[15.5px] font-inter leading-relaxed text-justify md:text-center">
                <?= htmlspecialchars($content['intro_text']) ?>
            </p>
        </div>

        <!-- Dual Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 mb-16">
            <!-- Step 1: Department of Labour CMS Portal -->
            <div class="group relative bg-white border border-gray-100 rounded-[32px] p-8 md:p-10 shadow-[0_10px_30px_-5px_rgba(19,39,63,0.03)] hover:shadow-[0_20px_40px_-5px_rgba(19,39,63,0.08)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden" data-aos="fade-right">
                <!-- Top Right Counter Badge -->
                <div class="absolute top-6 right-6 text-gray-200 font-montserrat font-bold text-5xl opacity-40 select-none group-hover:text-primary/10 transition-colors">01</div>
                
                <!-- Soft background gradient on hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                
                <div class="relative z-10">
                    <!-- Icon -->
                    <div class="w-16 h-16 rounded-[22px] bg-blue-50/70 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <!-- Card Title -->
                    <h3 class="text-xl md:text-2xl font-bold font-montserrat text-primary mb-4"><?= htmlspecialchars($content['cms_card_title']) ?></h3>
                    <!-- Card Description -->
                    <p class="text-gray-500 text-[14.5px] leading-relaxed mb-6 font-inter text-justify">
                        <?= htmlspecialchars($content['cms_card_desc']) ?>
                    </p>
                    
                    <!-- Bullet Points -->
                    <ul class="space-y-3 mb-8">
                        <?php foreach ($content['cms_bullets'] as $bullet): ?>
                            <li class="flex items-start gap-3 text-[13.5px] text-gray-600 font-inter">
                                <svg class="w-4 h-4 text-secondary mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span><?= htmlspecialchars($bullet) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Action Button -->
                <div class="relative z-10">
                    <a href="<?= htmlspecialchars($content['cms_link']) ?>" target="_blank" rel="noopener noreferrer" class="w-full text-center inline-flex items-center justify-center bg-gradient-to-r from-primary to-[#1c395c] hover:from-[#1c395c] hover:to-primary text-white text-xs font-bold px-6 py-4 rounded-xl transition-all duration-300 font-montserrat tracking-wider uppercase shadow-md hover:shadow-lg active:scale-[0.98]">
                        <?= htmlspecialchars($content['cms_btn_text']) ?>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Step 2: Ministry WhatsApp Escalation -->
            <div class="group relative bg-[#EFF8F6] border border-teal-100 rounded-[32px] p-8 md:p-10 shadow-[0_10px_30px_-5px_rgba(13,148,136,0.03)] hover:shadow-[0_20px_40px_-5px_rgba(13,148,136,0.08)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden" data-aos="fade-left">
                <!-- Top Right Counter Badge -->
                <div class="absolute top-6 right-6 text-teal-200 font-montserrat font-bold text-5xl opacity-40 select-none group-hover:text-teal-900/10 transition-colors">02</div>
                
                <!-- Soft background gradient on hover -->
                <div class="absolute inset-0 bg-gradient-to-br from-teal-600/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                
                <div class="relative z-10">
                    <!-- Icon -->
                    <div class="w-16 h-16 rounded-[22px] bg-teal-100/55 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <!-- Card Title -->
                    <h3 class="text-xl md:text-2xl font-bold font-montserrat text-teal-900 mb-4"><?= htmlspecialchars($content['whatsapp_card_title']) ?></h3>
                    <!-- Card Description -->
                    <p class="text-teal-800 text-[14.5px] leading-relaxed mb-6 font-inter text-justify">
                        <?= htmlspecialchars($content['whatsapp_card_desc']) ?>
                    </p>
                    
                    <!-- Bullet Points -->
                    <ul class="space-y-3 mb-8">
                        <?php foreach ($content['whatsapp_bullets'] as $bullet): ?>
                            <li class="flex items-start gap-3 text-[13.5px] text-teal-800 font-inter">
                                <svg class="w-4 h-4 text-teal-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span><?= htmlspecialchars($bullet) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Action Button with Official WhatsApp Icon -->
                <div class="relative z-10">
                    <a href="<?= htmlspecialchars($content['whatsapp_link']) ?>" target="_blank" rel="noopener noreferrer" class="w-full text-center inline-flex items-center justify-center bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-6 py-4 rounded-xl transition-all duration-300 font-montserrat tracking-wider uppercase shadow-md hover:shadow-lg active:scale-[0.98]">
                        <!-- Official Brand Vector WhatsApp Logo -->
                        <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                            <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                        </svg>
                        <span><?= htmlspecialchars($content['whatsapp_btn_text']) ?>: 070 722 7877</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Guidance Alert Box -->
        <div class="bg-white border-t-4 border-primary rounded-3xl p-6 md:p-8 shadow-[0_10px_25px_-5px_rgba(19,39,63,0.02)]" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-primary shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-bold text-primary font-montserrat mb-2"><?= htmlspecialchars($content['note_title']) ?></h4>
                    <p class="text-gray-500 font-inter text-[14px] leading-relaxed text-justify">
                        <?= htmlspecialchars($content['note_text']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
