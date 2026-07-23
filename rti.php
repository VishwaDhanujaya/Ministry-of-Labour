<?php
// rti.php
// Initialize current_lang from cookie or URL parameter for frontend display and UI states
$current_lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'si', 'ta'])) {
    $current_lang = $_GET['lang'];
    if (!headers_sent()) {
        setcookie('lang', $current_lang, time() + 86400 * 30, '/');
        setcookie('googtrans', '/en/' . $current_lang, time() + 86400 * 30, '/');
    }
} elseif (isset($_COOKIE['googtrans']) && !empty($_COOKIE['googtrans'])) {
    $gt_raw = trim(urldecode($_COOKIE['googtrans']), '"');
    if (preg_match('#/(si|ta|en)$#i', $gt_raw, $m)) {
        $current_lang = strtolower($m[1]);
    }
}
if ($current_lang === 'en' && isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['en', 'si', 'ta'])) {
    $current_lang = $_COOKIE['lang'];
}

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
    
    $officers_list[$type][] = [
        'name' => $officer['name'],
        'designation' => $officer['designation'],
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

// RTI Forms and Details
$rti_details = [
    'en' => [
        'section_subtitle' => 'Guidelines & Downloads',
        'section_title' => 'Forms & Details',
        'intro' => 'Sri Lanka’s Right to Information (RTI) Act comes into effect by bringing with it a promise of open government, citizens’ active participation in governance, and accountability to the people of the country.',
        
        'complaints_title' => 'Complaints & Labour Laws Information',
        'complaints_text_1' => 'Note: The information on the progress related to the investigations of the complaints which forwarded to the Department of Labour and the measures taken in respect of those complaints can directly be obtained by the parties to such complaints. The requests for such information do not need to be made under the Right to Information Act. Further, if a court action has already been taken regarding the matters related to an investigation, the request is forwarded to the Court and upon the permission of the Court information is provided to the respective parties.',
        'complaints_text_2' => 'However, in the event of an outside party to a complaint requests the information on the complaint or the information on the investigation made in relation to the complaint, it will be ascertained whether a court action has already been taken on the complaint or whether there is a possibility to take a court action in future. Considering the said facts, only the disclosable information will be provided to the requesting party.',
        'complaints_text_3' => 'Since all the ordinances, Acts, regulations, formats and set of instructions pertinent to all the labour laws have already been published on the web site, requests need not to be made under the Right to information Act to obtain such documents or information on such ordinances, Acts, regulations, formats and set of instructions. Those can directly be obtained though the web site. Moreover, if need further clarification on these matters it can be obtained through your nearest Labour office. Telephone numbers of all the Labour offices have been published on the web site. (This is not included disclosing the information to the media.)',
        
        'request_title' => 'Notice: Submitting Information Requests',
        'request_intro' => 'In accordance with the Right to Information Act, No. 12 of 2016, requests for Information should be made to the following Information Officer by completing and handing over a request preferably in the manner prescribed in the Form RTI 01 although this is not mandatory.',
        'request_list_1' => 'Upon making the request for information, either in verbal or written form obtain the written acknowledgment from the Information Officer.',
        'request_list_2' => 'The decision whether to grant the information or not shall be given as expeditiously as possible and in any case within 14 days.',
        'request_list_3' => 'If a decision is made to provide the information, the information officer will inform the citizen making the request that the information will be provided on the payment of a fee in accordance with the Fee Schedule prescribed by the Right to Information Commission. If the information is subject to payment of fee, the information shall be provided within 14 days of the payment. Information will be provided within 14 days of the decision if there is no requirement to pay a fee.',
        'request_list_4' => 'If, after payment of fees the information cannot be provided within 14 days, the person making the request will be informed that there will be a further extension period – up to a maximum of 21 days – to provide the information and given reasons for the extension.',
        'request_list_5' => 'When the request relates to the life and personal liberty of a citizen the information officer shall provide a response to the request within 48 hours.',
        
        'appeals_title' => 'Notice: Appeals Process',
        'appeals_intro' => 'An appeal may be made in situations where:',
        'appeals_item_1' => 'The Information Officer refuses a request made for information',
        'appeals_item_2' => 'The Information Officer refuses access to the information on the ground that such information is exempted from being granted under Section 5',
        'appeals_item_3' => 'Non-compliance with time frames specified in the Act',
        'appeals_item_4' => 'The Information Officer granted incomplete, misleading or false information',
        'appeals_item_5' => 'The Information Officer charged excessive fees',
        'appeals_item_6' => 'The Information Officer refused to provide information in the form requested',
        'appeals_item_7' => 'The citizen making the request had reasonable grounds to believe that information has been deformed, destroyed or misplaced to prevent him/her from having access to the information',
        'appeals_outro' => 'When making an appeal as mentioned in s.6 of this notice, complete and hand over Form RTI 10, to the Designated Officer. The RTI 10 Form is not compulsory. A citizen making a request can make the appeal by a letter with the basic information indicated in RTI 10 justifying the appeal.',
        
        'download_box_title' => 'Downloads & Forms',
        'download_box_desc' => 'Access and download the official Right to Information documents, forms, and regulations.',
        'doc_1_title' => 'Right to Information Act, No. 12 of 2016',
        'doc_2_title' => 'Regulations promulgated on 03.02.2017',
        'doc_3_title' => 'Application to receive information (RTI 01)',
        'doc_4_title' => 'Appeal form (RTI 10)',
        'doc_5_title' => 'Information Officers List of Dept. of Labour',
        'btn_download' => 'Download',
        'btn_view' => 'View List'
    ],
    'si' => [
        'section_subtitle' => 'මාර්ගෝපදේශ සහ බාගත කිරීම්',
        'section_title' => 'අයදුම්පත් සහ තොරතුරු',
        'intro' => 'ශ්‍රී ලංකා තොරතුරු දැනගැනීමේ අයිතිවාසිකම් (RTI) පනත ක්‍රියාත්මක වීමත් සමඟ විවෘත රාජ්‍ය පාලනයක්, පුරවැසියන්ගේ සක්‍රීය සහභාගිත්වය සහ වගවීම සහතික කෙරේ.',
        
        'complaints_title' => 'පැමිණිලි සහ කම්කරු නීති තොරතුරු',
        'complaints_text_1' => 'සටහන: කම්කරු දෙපාර්තමේන්තුව වෙත යොමු කරන ලද පැමිණිලි සම්බන්ධයෙන් සිදු කෙරෙන විමර්ශනවල ප්‍රගතිය සහ එම පැමිණිලි සම්බන්ධයෙන් ගෙන ඇති පියවර පිළිබඳ තොරතුරු අදාළ පැමිණිලිකාර පාර්ශවයන්ට සෘජුවම ලබා ගත හැක. ඒ සඳහා තොරතුරු දැනගැනීමේ පනත යටතේ ඉල්ලීම් ඉදිරිපත් කිරීමට අවශ්‍ය නොවේ. තවද, කිසියම් පැමිණිල්ලක් සම්බන්ධයෙන් දැනටමත් අධිකරණ ක්‍රියාමාර්ග ගෙන තිබේ නම්, එම ඉල්ලීම අධිකරණය වෙත යොමු කෙරෙන අතර අධිකරණයේ අවසරය මත අදාළ පාර්ශවයන්ට තොරතුරු සපයනු ලැබේ.',
        'complaints_text_2' => 'කෙසේ වෙතත්, පැමිණිල්ලකට සම්බන්ධ නොවන බාහිර පාර්ශවයක් විසින් පැමිණිල්ලක විමර්ශන ප්‍රගතිය හෝ තොරතුරු ඉල්ලා සිටින අවස්ථාවකදී, එම පැමිණිල්ල සම්බන්ධයෙන් දැනටමත් අධිකරණ ක්‍රියාමාර්ග ගෙන තිබේද නැතහොත් අනාගතයේදී අධිකරණ ක්‍රියාමාර්ග ගැනීමට හැකියාවක් පවතීද යන්න සොයා බලා, අනාවරණය කළ හැකි තොරතුරු පමණක් ලබා දෙනු ඇත.',
        'complaints_text_3' => 'සියලුම කම්කරු නීතිවලට අදාළ ආඥාපනත්, පනත්, රීති සහ උපදෙස් මාලා දැනටමත් වෙබ් අඩවියේ පළ කර ඇති බැවින්, එම ලේඛන හෝ තොරතුරු ලබා ගැනීමට තොරතුරු දැනගැනීමේ පනත යටතේ ඉල්ලීම් ඉදිරිපත් කිරීමට අවශ්‍ය නොවේ. ඒවා සෘජුවම වෙබ් අඩවියෙන් බාගත හැක. වැඩිදුර තොරතුරු අවශ්‍ය නම් ළඟම ඇති කම්කරු කාර්යාලයෙන් ලබාගත හැක. සියලුම කම්කරු කාර්යාලවල දුරකථන අංක වෙබ් අඩවියේ පළ කර ඇත. (මෙයට මාධ්‍ය වෙත තොරතුරු අනාවරණය කිරීම ඇතුළත් නොවේ.)',
        
        'request_title' => 'නිවේදනය: තොරතුරු ඉල්ලීම් ඉදිරිපත් කිරීම',
        'request_intro' => '2016 අංක 12 දරන තොරතුරු දැනගැනීමේ අයිතිවාසිකම් පනතට අනුකූලව, තොරතුරු ලබාගැනීම සඳහා වන ඉල්ලීම් RTI 01 ආකෘති පත්‍රය මඟින් හෝ ලිඛිතව තොරතුරු නිලධාරියා වෙත ඉදිරිපත් කළ යුතුය.',
        'request_list_1' => 'තොරතුරු ඉල්ලීම වාචිකව හෝ ලිඛිතව ඉදිරිපත් කළ පසු, තොරතුරු නිලධාරියාගෙන් ලිඛිත පිළිගැනීමේ පත්‍රයක් ලබා ගන්න.',
        'request_list_2' => 'තොරතුරු ලබා දෙන්නේද නැද්ද යන්න පිළිබඳ තීරණය හැකි ඉක්මනින් සහ දින 14ක් ඇතුළත ලබා දිය යුතුය.',
        'request_list_3' => 'තොරතුරු සැපයීමට තීරණය කරන්නේ නම්, තොරතුරු කොමිෂන් සභාව නියම කර ඇති ගාස්තු ගෙවීමෙන් පසු තොරතුරු ලබා දෙන බව තොරතුරු නිලධාරියා දැනුම් දෙනු ඇත. ගාස්තු ගෙවා දින 14ක් ඇතුළත තොරතුරු ලබා දිය යුතුය. ගාස්තුවක් අය නොකෙරේ නම් තීරණය ගෙන දින 14ක් ඇතුළත තොරතුරු සැපයිය යුතුය.',
        'request_list_4' => 'ගාස්තු ගෙවීමෙන් පසුවද දින 14ක් ඇතුළත තොරතුරු ලබා දීමට නොහැකි නම්, ඒ සඳහා හේතු දක්වමින් තොරතුරු සැපයීම උපරිම දින 21ක් දක්වා දීර්ඝ කරන බව අයදුම්කරුට දැනුම් දෙනු ලැබේ.',
        'request_list_5' => 'ඉල්ලීම පුරවැසියෙකුගේ ජීවිතයට හෝ පුද්ගලික නිදහසට අදාළ වන විට, පැය 48ක් ඇතුළත ඊට ප්‍රතිචාර දැක්විය යුතුය.',
        
        'appeals_title' => 'නිවේදනය: අභියාචනා ක්‍රියාවලිය',
        'appeals_intro' => 'පහත සඳහන් අවස්ථාවලදී නම් කරන ලද නිලධාරියා වෙත අභියාචනයක් ඉදිරිපත් කළ හැකිය:',
        'appeals_item_1' => 'තොරතුරු නිලධාරියා තොරතුරු සැපයීම ප්‍රතික්ෂේප කිරීම',
        'appeals_item_2' => '5 වන වගන්තිය යටතේ නිදහස් කර ඇති තොරතුරු බව පවසමින් ප්‍රවේශය ප්‍රතික්ෂේප කිරීම',
        'appeals_item_3' => 'පනතේ දක්වා ඇති කාලසීමාවන් නොපිළිපැදීම',
        'appeals_item_4' => 'අසම්පූර්ණ, නොමඟ යවන හෝ වැරදි තොරතුරු සැපයීම',
        'appeals_item_5' => 'අධික ගාස්තු අය කිරීම',
        'appeals_item_6' => 'ඉල්ලූ ආකෘතියෙන් තොරතුරු සැපයීම ප්‍රතික්ෂේප කිරීම',
        'appeals_item_7' => 'තොරතුරු විකෘති කර, විනාශ කර හෝ අස්ථානගත කර ඇති බවට අයදුම්කරුට සාධාරණ සැකයක් ඇති වීම',
        'appeals_outro' => 'නම් කරන ලද නිලධාරියා වෙත අභියාචනයක් ඉදිරිපත් කිරීමේදී RTI 10 ආකෘති පත්‍රය සම්පූර්ණ කර භාර දෙන්න. RTI 10 පත්‍රය අනිවාර්ය නොවන අතර, අයදුම්කරුට ලිපියක් මඟින්ද අභියාචනය ඉදිරිපත් කළ හැක.',
        
        'download_box_title' => 'නිල පෝරම සහ සබැඳි',
        'download_box_desc' => 'තොරතුරු දැනගැනීමේ අයිතියට අදාළ නිල ලේඛන, පෝරම සහ රීති බාගත කරගන්න.',
        'doc_1_title' => '2016 අංක 12 දරන තොරතුරු දැනගැනීමේ අයිතිවාසිකම් පනත',
        'doc_2_title' => '2017.02.03 දින ප්‍රකාශයට පත් කරන ලද රීති',
        'doc_3_title' => 'තොරතුරු ලබාගැනීම සඳහා වන අයදුම්පත (RTI 01)',
        'doc_4_title' => 'අභියාචනා පත්‍රය (RTI 10)',
        'doc_5_title' => 'කම්කරු දෙපාර්තමේන්තුවේ තොරතුරු නිලධාරීන්ගේ ලැයිස්තුව',
        'btn_download' => 'බාගත කරන්න',
        'btn_view' => 'ලැයිස්තුව බලන්න'
    ],
    'ta' => [
        'section_subtitle' => 'வழிகாட்டுதல்கள் & பதிவிறக்கங்கள்',
        'section_title' => 'விண்ணப்பங்கள் & விபரங்கள்',
        'intro' => 'இலங்கையின் தகவல் அறியும் உரிமை (RTI) சட்டம் நடைமுறைக்கு வருவதன் மூலம் திறந்த அரசாங்கமும், குடிமக்களின் தீவிர பங்கேற்பும், பொறுப்புக்கூறலும் உறுதி செய்யப்படுகிறது.',
        
        'complaints_title' => 'முறைப்பாடுகள் & தொழிலாளர் சட்டங்கள் தகவல்',
        'complaints_text_1' => 'குறிப்பு: தொழிலாளர் திணைக்களத்திற்கு அனுப்பப்பட்ட முறைப்பாடுகள் தொடர்பான விசாரணைகளின் முன்னேற்றம் மற்றும் எடுக்கப்பட்ட நடவடிக்கைகள் பற்றிய தகவல்களை முறைப்பாட்டாளர்கள் நேரடியாகப் பெற்றுக் கொள்ளலாம். இதற்காக தகவல் அறியும் உரிமைச் சட்டத்தின் கீழ் கோரிக்கை விடுக்கத் தேவையில்லை. மேலும், ஒரு விசாரணை தொடர்பான விடயங்களில் ஏற்கனவே நீதிமன்ற நடவடிக்கை எடுக்கப்பட்டிருந்தால், கோரிக்கை நீதிமன்றத்திற்கு மாற்றப்பட்டு நீதிமன்றத்தின் அனுமதியுடன் சம்பந்தப்பட்ட தரப்பினருக்கு தகவல் வழங்கப்படும்.',
        'complaints_text_2' => 'எவ்வாறாயினும், ஒரு முறைப்பாட்டுடன் தொடர்பில்லாத வெளி தரப்பினர் முறைப்பாடு அல்லது விசாரணை பற்றிய தகவல்களைக் கோரும் சந்தர்ப்பத்தில், நீதிமன்ற நடவடிக்கை எடுக்கப்பட்டுள்ளதா அல்லது எதிர்காலத்தில் நீதிமன்ற நடவடிக்கை எடுப்பதற்கான சாத்தியக்கூறுகள் உள்ளதா என்பது கண்டறியப்பட்டு, வெளிப்படுத்தக்கூடிய தகவல்கள் மட்டுமே வழங்கப்படும்.',
        'complaints_text_3' => 'அனைத்து தொழிலாளர் சட்டங்கள் தொடர்பான கட்டளைகள், சட்டங்கள், ஒழுங்குவிதிகள் மற்றும் அறிவுறுத்தல்கள் ஏற்கனவே இணையதளத்தில் வெளியிடப்பட்டுள்ளதால், அத்தகைய ஆவணங்களைப் பெறுவதற்கு தகவல் அறியும் சட்டத்தின் கீழ் விண்ணப்பிக்கத் தேவையில்லை. அவற்றை இணையதளத்தில் நேரடியாகப் பெற்றுக்கொள்ளலாம். மேலதிக விபரங்களுக்கு அருகிலுள்ள தொழிலாளர் அலுவலகத்தை தொடர்பு கொள்ளவும். (இது ஊடகங்களுக்கு தகவல் வெளியிடுவதை உள்ளடக்காது.)',
        
        'request_title' => 'அறிவித்தல்: தகவல் கோரிக்கைகளை சமர்ப்பித்தல்',
        'request_intro' => '2016 ஆம் ஆண்டின் 12 ஆம் இலக்க தகவல் அறியும் உரிமைச் சட்டத்தின்படி, தகவல்களுக்கான கோரிக்கைகளை RTI 01 படிவம் மூலமாக அல்லது எழுத்துப்பூர்வமாக தகவல் அதிகாரிக்கு சமர்ப்பிக்க வேண்டும்.',
        'request_list_1' => 'தகவல் கோரிக்கையை வாய்மொழியாக அல்லது எழுத்துப்பூர்வமாக சமர்ப்பித்ததும், தகவல் அதிகாரியிடமிருந்து எழுத்துப்பூர்வ ஒப்புதலைப் பெற்றுக்கொள்ளவும்.',
        'request_list_2' => 'தகவல் வழங்குவதா இல்லையா என்ற முடிவு கூடிய விரைவில் மற்றும் 14 நாட்களுக்குள் வழங்கப்பட வேண்டும்.',
        'request_list_3' => 'தகவல் வழங்க முடிவு செய்யப்பட்டால், தகவல் அறியும் ஆணையம் பரிந்துரைத்துள்ள கட்டணத்தைச் செலுத்தியதும் தகவல் வழங்கப்படும் என்று தகவல் அதிகாரி அறிவிப்பார். கட்டணம் செலுத்தி 14 நாட்களுக்குள் தகவல் வழங்கப்பட வேண்டும். கட்டணம் எதுவும் தேவையில்லை எனில் முடிவு எடுக்கப்பட்டு 14 நாட்களுக்குள் தகவல் வழங்கப்பட வேண்டும்.',
        'request_list_4' => 'கட்டணம் செலுத்திய பின்னரும் 14 நாட்களுக்குள் தகவலை வழங்க முடியாவிட்டால், அதற்கான காரணங்களுடன் தகவல் வழங்குவது அதிகபட்சமாக 21 நாட்கள் வரை நீட்டிக்கப்படும் என்று விண்ணப்பதாரருக்கு அறிவிக்கப்படும்.',
        'request_list_5' => 'கோரிக்கை ஒரு குடிமகனின் உயிர் அல்லது தனிப்பட்ட சுதந்திரம் தொடர்பானது எனில், 48 மணி நேரத்திற்குள் பதிலளிக்கப்பட வேண்டும்.',
        
        'appeals_title' => 'அறிவித்தல்: மேன்முறையீட்டு செயல்முறை',
        'appeals_intro' => 'பின்வரும் சூழ்நிலைகளில் நியமிக்கப்பட்ட அதிகாரிக்கு மேன்முறையீடு செய்யலாம்:',
        'appeals_item_1' => 'தகவல் அதிகாரி தகவலை வழங்க மறுப்பது',
        'appeals_item_2' => 'பிரிவு 5 இன் கீழ் விலக்கு அளிக்கப்பட்ட தகவல் எனக் கூறி அணுகலை மறுப்பது',
        'appeals_item_3' => 'சட்டவழிகளில் குறிப்பிடப்பட்டுள்ள காலக்கெடுவைக் கடைப்பிடிக்காமை',
        'appeals_item_4' => 'அரைகுறையான, தவறான தகவல்களை வழங்கியமை',
        'appeals_item_5' => 'அதிகப்படியான கட்டணம் வசூலித்தமை',
        'appeals_item_6' => 'கோரப்பட்ட வடிவத்தில் தகவலை வழங்க மறுத்தமை',
        'appeals_item_7' => 'தகவல் மறைக்கப்பட்டுள்ளது, அழிக்கப்பட்டுள்ளது அல்லது தவறவிடப்பட்டுள்ளது என்று விண்ணப்பதாரருக்கு நியாயமான சந்தேகம் ஏற்படும் போது',
        'appeals_outro' => 'மேன்முறையீடு செய்யும் போது RTI 10 படிவத்தை பூர்த்தி செய்து நியமிக்கப்பட்ட அதிகாரியிடம் ஒப்படைக்கவும். RTI 10 படிவம் கட்டாயமில்லை, கடிதம் மூலமாகவும் மேன்முறையீடு செய்யலாம்.',
        
        'download_box_title' => 'உத்தியோகபூர்வ படிவங்கள் & இணைப்புகள்',
        'download_box_desc' => 'தகவல் அறியும் உரிமை தொடர்பான உத்தியோகபூர்வ ஆவணங்கள், படிவங்கள் மற்றும் ஒழுங்குவிதிகளைப் பதிவிறக்கவும்.',
        'doc_1_title' => '2016 ஆம் ஆண்டின் 12 ஆம் இலக்க தகவல் அறியும் உரிமைச் சட்டம்',
        'doc_2_title' => '03.02.2017 அன்று வெளியிடப்பட்ட ஒழுங்குவிதிகள்',
        'doc_3_title' => 'தகவல் பெறுவதற்கான விண்ணப்பப் படிவம் (RTI 01)',
        'doc_4_title' => 'மேன்முறையீட்டுப் படிவம் (RTI 10)',
        'doc_5_title' => 'தொழிலாளர் திணைக்களத்தின் தகவல் அதிகாரிகள் பட்டியல்',
        'btn_download' => 'பதிவிறக்கம்',
        'btn_view' => 'பட்டியலைப் பார்'
    ]
];

include 'includes/sub-hero.php';
?>

<!-- Content Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-white overflow-hidden">
    <div class="container mx-auto max-w-5xl">
        
        <!-- Commitment & Overview: 2-Column Grid -->
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-center mb-16">
            <!-- Left Column: Commitment text -->
            <div class="w-full lg:w-1/2" data-aos="fade-right">
                <span class="section-subtitle"><?= $current_lang === 'si' ? 'විනිවිදභාවය සහ වගවීම' : ($current_lang === 'ta' ? 'வெளிப்படைத்தன்மை & பொறுப்புக்கூறல்' : 'Transparency & Accountability') ?></span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat mb-6"><?= $current_lang === 'si' ? 'තොරතුරු දැනගැනීමේ අයිතිය' : ($current_lang === 'ta' ? 'தகவல் அறியும் உரிமை' : 'Right to Information') ?></h2>
                <div class="bg-[#FAFAFA] border-l-4 border-secondary p-6 rounded-r-2xl shadow-sm">
                    <p class="text-gray-800 font-inter text-[15px] md:text-[16px] leading-relaxed font-semibold notranslate">
                        <?= htmlspecialchars($rti_texts[$current_lang]['intro']) ?>
                    </p>
                </div>
            </div>
            <!-- Right Column: Generated concept image -->
            <div class="w-full lg:w-1/2" data-aos="fade-left">
                <div class="relative group rounded-3xl overflow-hidden shadow-md border-[0.5px] border-[#D4D4D4] bg-white p-2">
                    <img loading="lazy" src="assets/img/rti-concept.webp" alt="Right to Information" class="w-full h-auto object-cover rounded-2xl group-hover:scale-[1.02] transition-transform duration-500">
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
                        <?= htmlspecialchars($rti_texts[$current_lang]['vision_title']) ?>
                    </h4>
                </div>
                <p class="text-gray-600 font-inter text-[14px] leading-relaxed notranslate">
                    <?= htmlspecialchars($rti_texts[$current_lang]['vision']) ?>
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
                        <?= htmlspecialchars($rti_texts[$current_lang]['mission_title']) ?>
                    </h4>
                </div>
                <p class="text-gray-600 font-inter text-[14px] leading-relaxed notranslate">
                    <?= htmlspecialchars($rti_texts[$current_lang]['mission']) ?>
                </p>
            </div>
        </div>

    </div>
</section>

<!-- RTI Officers Section -->
<section class="py-16 md:py-24 px-4 md:px-16 bg-[#F1F5F9] border-t border-b border-slate-200/80 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
    <div class="container mx-auto max-w-5xl">
        <span class="section-subtitle block text-center md:text-left"><?= $current_lang === 'si' ? 'අමාත්‍යාංශ කාර්ය මණ්ඩලය' : ($current_lang === 'ta' ? 'அமைச்சு ஊழியர்கள்' : 'Ministry Officials') ?></span>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat mb-12 text-center md:text-left notranslate" data-aos="fade-up">
            <?= htmlspecialchars($rti_texts[$current_lang]['officers_title']) ?>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="100">
            <?php foreach (['designated', 'information', 'central'] as $type): ?>
                <?php foreach ($officers_list[$type] as $officer): ?>
                    <div class="bg-white rounded-[32px] border border-gray-200/80 p-6 md:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transform transition-all duration-300 flex flex-col justify-between h-full group">
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-primary/10 to-primary/5 text-primary border border-primary/10 flex items-center justify-center font-montserrat font-bold text-lg shrink-0 group-hover:scale-105 transition-transform duration-300">
                                    <?= htmlspecialchars(get_initials($officer['name'])) ?>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-primary/5 text-primary border border-primary/10 mb-1 notranslate">
                                        <?= htmlspecialchars($rti_texts[$current_lang][$type . '_officer']) ?>
                                    </span>
                                    <h3 class="text-base font-bold font-montserrat text-gray-900 leading-snug notranslate">
                                        <?= htmlspecialchars($officer['name']) ?>
                                    </h3>
                                </div>
                            </div>
                            
                            <p class="text-xs md:text-sm font-inter text-gray-500 font-semibold mb-6 min-h-[36px] notranslate">
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
                                <p class="leading-relaxed">
                                    <?= $current_lang === 'si' ? 'කම්කරු අමාත්‍යාංශයේ තොරතුරු දැනගැනීමේ අයදුම්පත් සහ සම්බන්ධීකරණ කටයුතු භාර නිලධාරී.' : ($current_lang === 'ta' ? 'தொழில் அமைச்சின் தகவல் அறியும் விண்ணப்பங்கள் மற்றும் ஒருங்கிணைப்புக்கு பொறுப்பான அதிகாரி.' : 'Responsible for the coordination of RTI applications and processes within the Ministry of Labour.') ?>
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
<section class="py-16 md:py-24 px-4 md:px-16 bg-white border-t border-gray-200">
    <div class="container mx-auto max-w-5xl">
        <span class="section-subtitle block text-center md:text-left"><?= htmlspecialchars($rti_details[$current_lang]['section_subtitle']) ?></span>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat mb-12 text-center md:text-left notranslate" data-aos="fade-up">
            <?= htmlspecialchars($rti_details[$current_lang]['section_title']) ?>
        </h2>
        
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            <!-- Left Column: Details -->
            <div class="w-full lg:w-[65%] space-y-12" data-aos="fade-right">
                
                <!-- Introduction -->
                <div class="prose max-w-none">
                    <p class="text-gray-700 font-inter text-[15px] md:text-[16px] leading-relaxed font-semibold notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['intro']) ?>
                    </p>
                </div>
                
                <!-- Section A: Complaints and Labour Laws -->
                <div class="bg-[#FAFAFA] border border-gray-200/60 rounded-3xl p-6 md:p-8 shadow-sm">
                    <h3 class="text-lg md:text-xl font-bold font-montserrat text-primary mb-4 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['complaints_title']) ?>
                    </h3>
                    <div class="space-y-4 font-inter text-[14px] text-gray-600 leading-relaxed notranslate font-medium">
                        <p><?= htmlspecialchars($rti_details[$current_lang]['complaints_text_1']) ?></p>
                        <p><?= htmlspecialchars($rti_details[$current_lang]['complaints_text_2']) ?></p>
                        <p><?= htmlspecialchars($rti_details[$current_lang]['complaints_text_3']) ?></p>
                    </div>
                </div>
                
                <!-- Section B: Requests -->
                <div class="bg-white border border-gray-200/60 rounded-3xl p-6 md:p-8 shadow-sm">
                    <h3 class="text-lg md:text-xl font-bold font-montserrat text-primary mb-4 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['request_title']) ?>
                    </h3>
                    <p class="font-semibold font-inter text-[14px] text-gray-700 mb-4 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['request_intro']) ?>
                    </p>
                    <ul class="list-disc pl-5 space-y-3 font-inter text-[14px] text-gray-600 leading-relaxed notranslate">
                        <li><?= htmlspecialchars($rti_details[$current_lang]['request_list_1']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['request_list_2']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['request_list_3']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['request_list_4']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['request_list_5']) ?></li>
                    </ul>
                </div>
                
                <!-- Section C: Appeals -->
                <div class="bg-white border border-gray-200/60 rounded-3xl p-6 md:p-8 shadow-sm">
                    <h3 class="text-lg md:text-xl font-bold font-montserrat text-primary mb-4 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['appeals_title']) ?>
                    </h3>
                    <p class="font-semibold font-inter text-[14px] text-gray-700 mb-4 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['appeals_intro']) ?>
                    </p>
                    <ul class="list-disc pl-5 space-y-3 font-inter text-[14px] text-gray-600 leading-relaxed mb-4 notranslate">
                        <li><?= htmlspecialchars($rti_details[$current_lang]['appeals_item_1']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['appeals_item_2']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['appeals_item_3']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['appeals_item_4']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['appeals_item_5']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['appeals_item_6']) ?></li>
                        <li><?= htmlspecialchars($rti_details[$current_lang]['appeals_item_7']) ?></li>
                    </ul>
                    <p class="font-inter text-[14px] text-gray-600 leading-relaxed border-t border-gray-100 pt-4 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['appeals_outro']) ?>
                    </p>
                </div>
            </div>
            
            <!-- Right Column: Sidebar Downloads Card -->
            <div class="w-full lg:w-[35%]" data-aos="fade-left">
                <div class="bg-[#FAFAFA] rounded-[32px] border border-gray-200/80 p-6 md:p-8 shadow-sm sticky top-28">
                    <h3 class="text-lg font-bold font-montserrat text-primary mb-2 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['download_box_title']) ?>
                    </h3>
                    <p class="text-xs font-inter text-gray-500 mb-6 notranslate">
                        <?= htmlspecialchars($rti_details[$current_lang]['download_box_desc']) ?>
                    </p>
                    
                    <div class="space-y-4">
                        <!-- Link 1 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= htmlspecialchars($rti_details[$current_lang]['doc_1_title']) ?>
                            </h4>
                            <a href="https://www.parliament.lk/uploads/acts/gbills/english/6007.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= htmlspecialchars($rti_details[$current_lang]['btn_download']) ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 2 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= htmlspecialchars($rti_details[$current_lang]['doc_2_title']) ?>
                            </h4>
                            <a href="https://www.parliament.lk/files/rti/regulations-20170203-2004-66-en.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= htmlspecialchars($rti_details[$current_lang]['btn_download']) ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 3 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= htmlspecialchars($rti_details[$current_lang]['doc_3_title']) ?>
                            </h4>
                            <a href="https://www.parliament.lk/files/rti/form-RTI01-en.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= htmlspecialchars($rti_details[$current_lang]['btn_download']) ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 4 -->
                        <div class="border-b border-gray-200/60 pb-4">
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= htmlspecialchars($rti_details[$current_lang]['doc_4_title']) ?>
                            </h4>
                            <a href="https://www.parliament.lk/files/rti/form-RTI10-en.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= htmlspecialchars($rti_details[$current_lang]['btn_download']) ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Link 5 -->
                        <div>
                            <h4 class="text-xs font-semibold text-gray-800 font-inter mb-2 notranslate">
                                <?= htmlspecialchars($rti_details[$current_lang]['doc_5_title']) ?>
                            </h4>
                            <a href="https://labourdept.gov.lk/information-officers-list/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-xs font-bold text-secondary hover:text-primary transition-colors gap-1 notranslate">
                                <span><?= htmlspecialchars($rti_details[$current_lang]['btn_view']) ?></span>
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
<section class="py-16 px-4 md:px-16 bg-white border-t border-gray-200 overflow-hidden">
    <div class="container mx-auto max-w-5xl" data-aos="zoom-in">
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
                            <?= htmlspecialchars($rti_texts[$current_lang]['more_info_lbl']) ?>
                        </h4>
                        <p class="text-sm font-inter text-gray-200 mt-2 max-w-xl notranslate">
                            <?= htmlspecialchars($rti_texts[$current_lang]['more_info_desc']) ?>
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
