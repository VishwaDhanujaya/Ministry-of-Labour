<?php
// nlac.php
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

include 'includes/header.php';

$page_title = t('nlac_full', 'National Labour Advisory Council (NLAC)');
$pageTitle = t('nlac_full', 'National Labour Advisory Council') . ' - Ministry of Labour - Sri Lanka';
$metaDescription = 'National Labour Advisory Council (NLAC) is the national tripartite consultative mechanism established in 1994.';
$metaKeywords = 'Ministry of Labour, Sri Lanka, NLAC, National Labour Advisory Council, Tripartite Consultative Mechanism';

$employer_members = [
    [
        'no' => '01',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Vajira Ellepola', 'si' => 'වජිර ඇල්ලේපොල', 'ta' => 'வஜிர எல்லேபொல'],
        'designation' => ['en' => 'Director General', 'si' => 'අධ්‍යක්ෂ ජනරාල්', 'ta' => 'பணிப்பாளர் நாயகம்'],
        'tu' => ['en' => 'Employers\' Federation of Ceylon', 'si' => 'ලංකා සේවා යෝජකයන්ගේ සම්මේලනය', 'ta' => 'இலங்கை முதலாளிமார் சம்மேளனம்']
    ],
    [
        'no' => '02',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Adhil Khasim', 'si' => 'අදිල් කාසිම්', 'ta' => 'அத்ஹில் காசிம்'],
        'designation' => ['en' => 'Deputy Director General', 'si' => 'නියෝජ්‍ය අධ්‍යක්ෂ ජනරාල්', 'ta' => 'பிரதிப் பணிப்பாளர் நாயகம்'],
        'tu' => ['en' => 'Employers\' Federation of Ceylon', 'si' => 'ලංකා සේවා යෝජකයන්ගේ සම්මේලනය', 'ta' => 'இலங்கை முதலாளிமார் சம்மேளனம்']
    ],
    [
        'no' => '03',
        'title' => ['en' => 'Ms', 'si' => 'මිය', 'ta' => 'திருமதி.'],
        'name' => ['en' => 'Kirthana Krishnakumar (AAL)', 'si' => 'කීර්තනා ක්‍රිෂ්ණකුමාර් (නීතිඥ)', 'ta' => 'கீர்த்தனா கிருஷ்ணகுமார் (சட்டத்தரணி)'],
        'designation' => ['en' => 'Senior Legal Counsel, Group Legal Department & Vice President', 'si' => 'ජ්‍යෙෂ්ඨ නීති උපදේශක, සමූහ නීති අංශය සහ උප සභාපති', 'ta' => 'மூத்த சட்ட ஆலோசகர், குழு சட்டத் துறை மற்றும் துணைத் தலைவர்'],
        'tu' => ['en' => 'John Keells Group', 'si' => 'ජෝන් කීල්ස් සමූහය', 'ta' => 'ஜோன் கீல்ஸ் குழுமம்']
    ],
    [
        'no' => '04',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Jayendra de Silva', 'si' => 'ජයේන්ද්‍ර ද සිල්වා', 'ta' => 'ஜயேந்திர டி சில்வா'],
        'designation' => ['en' => 'General Manager- Group Human Resource Management', 'si' => 'සාමාන්්‍යාධිකාරී - සමූහ මානව සම්පත් කළමනාකරණය', 'ta' => 'பொது மேலாளர் - குழு மனித வள மேலாண்மை'],
        'tu' => ['en' => 'Hayleys PLC', 'si' => 'හේලීස් පීඑල්සී', 'ta' => 'ஹேலீஸ் பிஎல்சி']
    ],
    [
        'no' => '05',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Suresh Noel Muttiah', 'si' => 'සුරේෂ් නොයෙල් මුත්තයියා', 'ta' => 'சுரேஷ் நோயல் முத்தையா'],
        'designation' => ['en' => 'Group Chief Human Resources Officer', 'si' => 'සමූහ ප්‍රධාන මානව සම්පත් නිලධාරී', 'ta' => 'குழு தலைமை மனித வள அதிகாரி'],
        'tu' => ['en' => 'Aitken Spence Corporate Finance (pvt) Ltd', 'si' => 'ඇයිට්කන් ස්පෙන්ස් කෝපරේට් ෆයිනෑන්ස් (පුද්) සමාගම', 'ta' => 'எய்ட்கன் ஸ்பென்ஸ் கார்ப்பரேட் பைனான்ஸ் (தனியார்) லிமிடெட்']
    ],
    [
        'no' => '06',
        'title' => ['en' => 'Ms', 'si' => 'මිය', 'ta' => 'திருமதி.'],
        'name' => ['en' => 'Geetha Yasanayake', 'si' => 'ගීතා යසනායක', 'ta' => 'கீதா யசநாயக்க'],
        'designation' => ['en' => 'Group Chief HR Officer', 'si' => 'සමූහ ප්‍රධාන මානව සම්පත් නිලධාරී', 'ta' => 'குழு தலைமை மனித வள அதிகாரி'],
        'tu' => ['en' => 'Cargills (Ceylon) Plc', 'si' => 'කාගිල්ස් (සිලෝන්) පීඑල්සී', 'ta' => 'கார்கில்ஸ் (சிலோன்) பிஎல்சி']
    ],
    [
        'no' => '07',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Dhammika Fernando', 'si' => 'ධම්මික ප්‍රනාන්දු', 'ta' => 'தம்மிக்க பெர்னாண்டோ'],
        'designation' => ['en' => 'Chairman', 'si' => 'සභාපති', 'ta' => 'தலைவர்'],
        'tu' => ['en' => 'Free Trade Zone Manufacturers\' Association', 'si' => 'නිදහස් වෙළඳ කලාප නිෂ්පාදකයින්ගේ සංගමය', 'ta' => 'சுதந்திர வர்த்தக வலய உற்பத்தியாளர்கள் சங்கம்']
    ],
    [
        'no' => '08',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Charaka Gunawardana', 'si' => 'චරක ගුණවර්ධන', 'ta' => 'சாரக குணவர்தன'],
        'designation' => ['en' => 'Director- Human Resources and Sustainable Business', 'si' => 'අධ්‍යක්ෂ - මානව සම්පත් සහ තිරසාර ව්‍යාපාර', 'ta' => 'பணிப்பாளர் - மனித வளங்கள் மற்றும் நிலையான வணிகம்'],
        'tu' => ['en' => 'MAS Active', 'si' => 'එම්ඒඑස් ඇක්ටිව්', 'ta' => 'எம்ஏஎஸ் ஆக்டிவ்']
    ],
    [
        'no' => '09',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Shiran Fernando', 'si' => 'ශිරාන් ප්‍රනාන්දු', 'ta' => 'ஷிரான் பெர்னாண்டோ'],
        'designation' => ['en' => 'Chief Economic Policy Advisor', 'si' => 'ප්‍රධාන ආර්ථික ප්‍රතිපත්ති උපදේශක', 'ta' => 'தலைமை பொருளாதார கொள்கை ஆலோசகர்'],
        'tu' => ['en' => 'The Ceylon Chamber of Commerce', 'si' => 'ලංකා වාණිජ මණ්ඩලය', 'ta' => 'இலங்கை வர்த்தக சபை']
    ],
    [
        'no' => '10',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Hemantha Balasuriya', 'si' => 'හේමන්ත බාලසූරිය', 'ta' => 'ஹேமந்த பாலசூரிய'],
        'designation' => ['en' => 'Hony. Secretary', 'si' => 'ගරු ලේකම්', 'ta' => 'கௌரவ செயலாளர்'],
        'tu' => ['en' => 'Sri Lanka Food Processors Association (SLFPA)', 'si' => 'ශ්‍රී ලංකා ආහාර සකසන්නන්ගේ සංගමය', 'ta' => 'இலங்கை உணவு பதப்படுத்துவோர் சங்கம் (SLFPA)']
    ],
    [
        'no' => '11',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Lalith Obeyesekere', 'si' => 'ලලිත් ඔබේසේකර', 'ta' => 'லலித் ஒபயசேகர'],
        'designation' => ['en' => 'Secretary General', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'செயலாளர் நாயகம்'],
        'tu' => ['en' => 'The Planters\' Association of Ceylon', 'si' => 'ලංකා වැවිලිකරුවන්ගේ සංගමය', 'ta' => 'இலங்கை பெருந்தோட்ட உரிமையாளர்கள் சங்கம்']
    ],
    [
        'no' => '12',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Yohan Lawrence', 'si' => 'යොහාන් ලෝරන්ස්', 'ta' => 'யோஹான் லாரன்ஸ்'],
        'designation' => ['en' => 'Secretary General', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'செயலாளர் நாயகம்'],
        'tu' => ['en' => 'Joint Apparel Association Forum', 'si' => 'ඒකාබද්ධ ඇඟලුම් සංගම් සංසදය', 'ta' => 'கூட்டு ஆடை சங்கங்களின் மன்றம்']
    ],
    [
        'no' => '13',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Sampath Jayasundara', 'si' => 'සම්පත් ජයසුන්දර', 'ta' => 'சம்பத் ஜயசுந்தர'],
        'designation' => ['en' => 'SLASSCOM Director/ CEO/Director-hSenid Business Solutions', 'si' => 'SLASSCOM අධ්‍යක්ෂ/ ප්‍රධාන විධායක නිලධාරී/ අධ්‍යක්ෂ - hSenid Business Solutions', 'ta' => 'SLASSCOM பணிப்பாளர்/ தலைமை நிர்வாக அதிகாரி/ பணிப்பாளர் - hSenid Business Solutions'],
        'tu' => ['en' => 'Sri Lanka Association of Software and Services Companies (SLASSCOM)', 'si' => 'ශ්‍රී ලංකා මෘදුකාංග සහ සේවා සමාගම් සංගමය', 'ta' => 'இலங்கை மென்பொருள் மற்றும் சேவைகள் நிறுவனங்களின் சங்கம் (SLASSCOM)']
    ],
    [
        'no' => '14',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'M.D.S Hemantha Kumara Perera', 'si' => 'එම්.ඩී.එස් හේමන්ත කුමාර පෙරේරා', 'ta' => 'எம்.டி.எஸ் ஹேமந்த குமார பெரேரா'],
        'designation' => ['en' => 'Secretary General', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'செயலாளர் நாயகம்'],
        'tu' => ['en' => 'Sri Lanka Chamber of Garment Association', 'si' => 'ශ්‍රී ලංකා ඇඟලුම් සංගම් මණ්ඩලය', 'ta' => 'இலங்கை ஆடை சங்க சம்மேளனம்']
    ],
    [
        'no' => '15',
        'title' => ['en' => 'Capt.', 'si' => 'කැප්ටන්', 'ta' => 'கேப்டன்'],
        'name' => ['en' => 'Lal Tennekoon', 'si' => 'ලාල් තැන්නකෝන්', 'ta' => 'லால் தென்னகோன்'],
        'designation' => ['en' => 'Senior Assistant Secretary General', 'si' => 'ජ්‍යෙෂ්ඨ සහකාර ලේකම් ජනරාල්', 'ta' => 'மூத்த உதவிச் செயலாளர் நாயகம்'],
        'tu' => ['en' => 'Chamber of Construction Industry of Sri Lanka', 'si' => 'ශ්‍රී ලංකා ඉදිකිරීම් කර්මාන්ත මණ්ඩලය', 'ta' => 'இலங்கை கட்டுமான தொழில்துறை சம்மேளனம்']
    ],
    [
        'no' => '16',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'H.T Chaminda', 'si' => 'එච්.ටී චමින්ද', 'ta' => 'எச்.டி சமிந்த'],
        'designation' => ['en' => 'Vice President - Human Resources', 'si' => 'උප සභාපති - මානව සම්පත්', 'ta' => 'துணைத் தலைவர் - மனித வளங்கள்'],
        'tu' => ['en' => 'Associated CEAT (pvt) Ltd', 'si' => 'ඇසෝසියේටඩ් සීට් (පුද්) සමාගම', 'ta' => 'அசோசியேட்டட் சியட் (தனியார்) லிமிடெட்']
    ],
    [
        'no' => '17',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Kavinda Rajapaksha', 'si' => 'කවීන්ද රාජපක්ෂ', 'ta' => 'கவிந்த ராஜபக்ச'],
        'designation' => ['en' => 'Senior Deputy President', 'si' => 'ජ්‍යෙෂ්ඨ නියෝජ්‍ය සභාපති', 'ta' => 'மூத்த பிரதித் தலைவர்'],
        'tu' => ['en' => 'National Chamber of Commerce Sri Lanka', 'si' => 'ශ්‍රී ලංකා ජාතික වාණිජ මණ්ඩලය', 'ta' => 'இலங்கை தேசிய வர்த்தக சபை']
    ]
];

$employee_members = [
    [
        'no' => '01',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'S.Rajamany', 'si' => 'එස්. රාජමනී', 'ta' => 'எஸ். இராஜமணி'],
        'designation' => ['en' => 'Vice President', 'si' => 'උප සභාපති', 'ta' => 'துணைத் தலைவர்'],
        'tu' => ['en' => 'Ceylon Workers’ Congress', 'si' => 'ලංකා කම්කරු කොංග්‍රසය', 'ta' => 'இலங்கை தொழிலாளர் காங்கிரஸ்']
    ],
    [
        'no' => '02',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Vadivel Suresh', 'si' => 'වඩිවෙල් සුරේෂ්', 'ta' => 'வடிவேல் சுரேஷ்'],
        'designation' => ['en' => 'General Secretary', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'பொதுச் செயலாளர்'],
        'tu' => ['en' => 'Lanka Jathika Estate Workers Union', 'si' => 'ලංකා ජාතික වතු කම්කරු සංගමය', 'ta' => 'லங்கா ஜாதிக தோட்டத் தொழிலாளர் சங்கம்']
    ],
    [
        'no' => '03',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Leslie Devendra', 'si' => 'ලෙස්ලි දේවේන්ද්‍ර', 'ta' => 'லெஸ்லி தேவேந்திரா'],
        'designation' => ['en' => 'General Secretary', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'பொதுச் செயலாளர்'],
        'tu' => ['en' => 'Sri Lanka Nidahas Sewaka Sangamaya', 'si' => 'ශ්‍රී ලංකා නිදහස් සේවක සංගමය', 'ta' => 'இலங்கை சுதந்திர ஊழியர் சங்கம்']
    ],
    [
        'no' => '04',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'S.Ramanathan', 'si' => 'එස්. රාමානාදන්', 'ta' => 'எஸ். இராமநாதன்'],
        'designation' => ['en' => 'Secretary General', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'செயலாளர் நாயகம்'],
        'tu' => ['en' => 'Joint Plantation Trade Union Centre', 'si' => 'ඒකාබද්ධ වතු වෘත්තීය සමිති මධ්‍යස්ථානය', 'ta' => 'கூட்டு தோட்ட தொழிற்சங்க மையம்']
    ],
    [
        'no' => '05',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Channa Sirinath Dissanayake', 'si' => 'චන්න සිරිනාත් දිසානායක', 'ta' => 'சன்ன சிரினாத் திசாநாயக்க'],
        'designation' => ['en' => 'President', 'si' => 'සභාපති', 'ta' => 'தலைவர்'],
        'tu' => ['en' => 'Ceylon Bank Employees Union', 'si' => 'ලංකා බැංකු සේවක සංගමය', 'ta' => 'இலங்கை வங்கி ஊழியர் சங்கம்']
    ],
    [
        'no' => '06',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'G.D. Indika Pushpakumara', 'si' => 'ජී.ඩී. ඉන්දික පුෂ්පකුමාර', 'ta' => 'ஜி.டி. இந்திக புஷ்பகுமார'],
        'designation' => ['en' => 'General Secretary', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'பொதுச் செயலாளர்'],
        'tu' => ['en' => 'Jathika Sewaka Sangamaya', 'si' => 'ජාතික සේවක සංගමය', 'ta' => 'ஜாதிக சேவக சங்கம்']
    ],
    [
        'no' => '07',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Amarapala Gamage', 'si' => 'අමරපාල ගමගේ', 'ta' => 'அமரபால கமகே'],
        'designation' => ['en' => 'National Organizer/Senior Vice President', 'si' => 'ජාතික සංවිධායක/ජ්‍යෙෂ්ඨ උප සභාපති', 'ta' => 'தேசிய அமைப்பாளர்/மூத்த துணைத் தலைவர்'],
        'tu' => ['en' => 'Podujana Pragathasheeli Sewaka Sangamaya', 'si' => 'පොදුජන ප්‍රගතිශීලී සේවක සංගමය', 'ta' => 'பொதுஜன பிரகதிஷீலி சேவக சங்கம்']
    ],
    [
        'no' => '08',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Palitha Athukorale', 'si' => 'පාලිත ඇතුකෝරල', 'ta' => 'பாலித அத்துகோரல'],
        'designation' => ['en' => 'Chairman', 'si' => 'සභාපති', 'ta' => 'தலைவர்'],
        'tu' => ['en' => 'National Union of Seafarer Sri Lanka', 'si' => 'ශ්‍රී ලංකා නාවිකයින්ගේ ජාතික සංගමය', 'ta' => 'இலங்கை கடல்சார் தேசிய சங்கம்']
    ],
    [
        'no' => '09',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Nishantha Wanniarachchi', 'si' => 'නිශාන්ත වන්නිආරච්චි', 'ta' => 'நிஷாந்த வன்னியாரச்சி'],
        'designation' => ['en' => 'President', 'si' => 'සභාපති', 'ta' => 'தலைவர்'],
        'tu' => ['en' => 'Ceylon Estate Staffs’ Union', 'si' => 'ලංකා වතු සේවක සංගමය', 'ta' => 'இலங்கை தோட்ட ஊழியர் சங்கம்']
    ],
    [
        'no' => '10',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Warahena Liyanage Don Marcus', 'si' => 'වරහේන ලියනගේ දොන් මාකස්', 'ta' => 'வரஹேன லியனகே டொன் மார்கஸ்'],
        'designation' => ['en' => 'Member', 'si' => 'සාමාජික', 'ta' => 'உறுப்பினர்'],
        'tu' => ['en' => 'Free Trade Zones and General Services Employees Union', 'si' => 'නිදහස් වෙළඳ කලාප සහ පොදු සේවා සේවක සංගමය', 'ta' => 'சுதந்திர வர்த்தக வலயங்கள் மற்றும் பொது சேவைகள் ஊழியர் சங்கம்']
    ],
    [
        'no' => '11',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'J.M.A Premarathna', 'si' => 'ජේ.එම්.ඒ ප්‍රේමරත්න', 'ta' => 'ஜே.எம்.ஏ பிரேமரத்ன'],
        'designation' => ['en' => 'Secretary', 'si' => 'ලේකම්', 'ta' => 'செயலாளர்'],
        'tu' => ['en' => 'All Ceylon Estate Workers Union', 'si' => 'සමස්ත ලංකා වතු කම්කරු සංගමය', 'ta' => 'அகில இலங்கை தோட்டத் தொழிலாளர் சங்கம்']
    ],
    [
        'no' => '12',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Prasanga Medawatte', 'si' => 'ප්‍රසංග මැදවත්ත', 'ta' => 'பிரசங்க மேடவத்தே'],
        'designation' => ['en' => 'President', 'si' => 'සභාපති', 'ta' => 'தலைவர்'],
        'tu' => ['en' => 'All Ceylon Port Public Employees’ Union', 'si' => 'සමස්ත ලංකා වරාය පොදු සේවක සංගමය', 'ta' => 'அகில இலங்கை துறைமுக பொது ஊழியர் சங்கம்']
    ],
    [
        'no' => '13',
        'title' => ['en' => 'Ms', 'si' => 'මිය', 'ta' => 'திருமதி.'],
        'name' => ['en' => 'Lalitha Ranjani Dedduwakumara', 'si' => 'ලලිතා රංජනී දෙද්දුවකුමාර', 'ta' => 'லலிதா ரஞ்சனி தெத்துவகுமார'],
        'designation' => ['en' => 'Chief Organizer', 'si' => 'ප්‍රධාන සංවිධායක', 'ta' => 'தலைமை அமைப்பாளர்'],
        'tu' => ['en' => 'Textile, Garment and Clothing Workers Union (TGCWU)', 'si' => 'නිමි භාණ්ඩ ඇඟළුම් හා රෙදිපිළි සේවක සංගමය', 'ta' => 'ஆடை, ஆடை மற்றும் ஆடைத் தொழிலாளர் சங்கம் (TGCWU)']
    ],
    [
        'no' => '14',
        'title' => ['en' => 'Ms', 'si' => 'මිය', 'ta' => 'திருமதி.'],
        'name' => ['en' => 'P.K Chamila Thushari', 'si' => 'පී.කේ චමිලා තුෂාරි', 'ta' => 'பி.கே சமிலா துஷாரி'],
        'designation' => ['en' => 'Secretary', 'si' => 'ලේකම්', 'ta' => 'செயலாளர்'],
        'tu' => ['en' => 'Dabindu Collective', 'si' => 'දබිඳු සාමූහිකය', 'ta' => 'தபிந்து கூட்டுறவு']
    ],
    [
        'no' => '15',
        'title' => ['en' => 'Ms', 'si' => 'මිය', 'ta' => 'திருமதி.'],
        'name' => ['en' => 'Eranga Amali Kalupahana', 'si' => 'එරංගා අමාලි කළුපහන', 'ta' => 'இரங்கா அமாலி களுபஹன'],
        'designation' => ['en' => 'President', 'si' => 'සභාපති', 'ta' => 'தலைவர்'],
        'tu' => ['en' => 'Centre for Working Women', 'si' => 'වැඩකරන කාන්තා මධ්‍යස්ථානය', 'ta' => 'உழைக்கும் பெண்கள் மையம்']
    ],
    [
        'no' => '16',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Amal Wedage', 'si' => 'අමල් වෙදගේ', 'ta' => 'அமல் வெடகே'],
        'designation' => ['en' => 'Deputy General Secretary', 'si' => 'නියෝජ්‍ය ප්‍රධාන ලේකම්', 'ta' => 'துணைப் பொதுச் செயலாளர்'],
        'tu' => ['en' => 'Ceylon Federation of Trade Unions', 'si' => 'ලංකා වෘත්තීය සමිති සම්මේලනය', 'ta' => 'இலங்கை தொழிற்சங்க சம்மேளனம்']
    ],
    [
        'no' => '17',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'Janaka Adhikari (AAL)', 'si' => 'ජනක අධිකාරි (නීතිඥ)', 'ta' => 'ஜனக அதிகாரி (சட்டத்தரணி)'],
        'designation' => ['en' => 'General Secretary', 'si' => 'ලේකම් ජනරාල්', 'ta' => 'பொதுச் செயலாளர்'],
        'tu' => ['en' => 'Inter Company Employees Union', 'si' => 'අන්තර් සමාගම් සේවක සංගමය', 'ta' => 'நிறுவனங்களுக்கு இடையிலான ஊழியர் சங்கம்']
    ],
    [
        'no' => '18',
        'title' => ['en' => 'Mr', 'si' => 'මහතා', 'ta' => 'திரு.'],
        'name' => ['en' => 'K.S Munasinghe', 'si' => 'කේ.එස් මුණසිංහ', 'ta' => 'கே.எஸ் முனசிங்க'],
        'designation' => ['en' => 'Co-Secretary', 'si' => 'සහ-ලේකම්', 'ta' => 'இணைச் செயலாளர்'],
        'tu' => ['en' => 'All Ceylon Transport Employees Union', 'si' => 'සමස්ත ලංකා ප්‍රවාහන සේවක සංගමය', 'ta' => 'அகில இலங்கை போக்குவரத்து ஊழியர் சங்கம்']
    ]
];

include 'includes/sub-hero.php';
?>

<section class="py-16 md:py-24 px-4 md:px-16 bg-white">
    <div class="container mx-auto max-w-5xl" data-aos="fade-up">
        
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary font-montserrat tracking-tight uppercase mb-6 md:mb-8 notranslate"><?= t('nlac_full', 'National Labour Advisory Council (NLAC)') ?></h2>
        
        <div class="prose max-w-none text-gray-600 font-inter text-[15px] leading-relaxed mb-12">
            <p class="mb-4 notranslate">
                <?= t('nlac_intro_p1') ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
            <!-- Objectives -->
            <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-primary font-montserrat mb-4 notranslate"><?= t('nlac_objectives_title', 'The objectives of the NLAC shall be;') ?></h3>
                <ul class="space-y-3 text-gray-600 font-inter text-sm list-disc pl-5 notranslate">
                    <li><?= t('nlac_obj_1') ?></li>
                    <li><?= t('nlac_obj_2') ?></li>
                    <li><?= t('nlac_obj_3') ?></li>
                </ul>
            </div>

            <!-- Functions -->
            <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-primary font-montserrat mb-4 notranslate"><?= t('nlac_functions_title', 'Functions of the NLAC shall be;') ?></h3>
                <p class="text-gray-600 font-inter text-sm mb-3 notranslate"><?= t('nlac_func_intro') ?></p>
                <ul class="space-y-3 text-gray-600 font-inter text-sm list-disc pl-5 notranslate">
                    <li><?= t('nlac_func_1') ?></li>
                    <li><?= t('nlac_func_2') ?></li>
                    <li><?= t('nlac_func_3') ?></li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
            <!-- Composition -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                <h3 class="text-xl font-bold text-primary font-montserrat mb-4 flex items-center gap-3 notranslate">
                    <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span><?= t('nlac_composition_title', 'Composition') ?></span>
                </h3>
                <ul class="space-y-3 text-gray-600 font-inter text-sm list-disc pl-5 notranslate">
                    <li><?= t('nlac_comp_1') ?></li>
                    <li><?= t('nlac_comp_2') ?></li>
                    <li><?= t('nlac_comp_3') ?></li>
                </ul>
            </div>

            <!-- How it works -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                <h3 class="text-xl font-bold text-primary font-montserrat mb-4 flex items-center gap-3 notranslate">
                    <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span><?= t('nlac_how_it_works_title', 'How the NLAC works') ?></span>
                </h3>
                <ul class="space-y-3 text-gray-600 font-inter text-sm list-disc pl-5 notranslate">
                    <li><?= t('nlac_works_1') ?></li>
                    <li><?= t('nlac_works_2') ?></li>
                    <li><?= t('nlac_works_3') ?></li>
                </ul>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-primary font-montserrat mb-8 notranslate"><?= t('nlac_members_title', 'Members of the National Labour Advisory Council') ?></h3>
        
        <div class="flex flex-wrap items-center gap-2 mb-8 bg-gray-100 p-1.5 rounded-xl max-w-xl">
            <button id="btn-employer" onclick="showTab('employer')" class="flex-1 text-center py-2.5 px-4 rounded-lg font-bold text-sm transition-all bg-primary text-white shadow notranslate">
                <?= t('tab_employer_tu', 'Employer Trade Unions') ?>
            </button>
            <button id="btn-employee" onclick="showTab('employee')" class="flex-1 text-center py-2.5 px-4 rounded-lg font-bold text-sm transition-all text-gray-500 hover:text-gray-800 hover:bg-white/50 notranslate">
                <?= t('tab_employee_tu', 'Employee Trade Unions') ?>
            </button>
        </div>
        
        <!-- Employer Trade Unions -->
        <div id="table-employer" class="tu-table overflow-x-auto mb-12 rounded-xl border border-gray-200 notranslate">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_no', 'No') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_title', 'Title') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_name', 'Name') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_designation', 'Designation') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_name_of_tu', 'Name of TU') ?></th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 font-inter divide-y divide-gray-100">
                    <?php foreach ($employer_members as $m): 
                        $title = $m['title'][$current_lang] ?? $m['title']['en'];
                        $name = $m['name'][$current_lang] ?? $m['name']['en'];
                        $designation = $m['designation'][$current_lang] ?? $m['designation']['en'];
                        $tu = $m['tu'][$current_lang] ?? $m['tu']['en'];
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4"><?= htmlspecialchars($m['no']) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($title) ?></td>
                        <td class="py-3 px-4 font-semibold"><?= htmlspecialchars($name) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($designation) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($tu) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Employee Trade Unions -->
        <div id="table-employee" class="tu-table hidden overflow-x-auto mb-12 rounded-xl border border-gray-200 notranslate">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_no', 'No') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_title', 'Title') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_name', 'Name') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_designation', 'Designation') ?></th>
                        <th class="py-4 px-4 font-semibold text-gray-700 text-sm border-b notranslate"><?= t('th_name_of_tu', 'Name of TU') ?></th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 font-inter divide-y divide-gray-100">
                    <?php foreach ($employee_members as $m): 
                        $title = $m['title'][$current_lang] ?? $m['title']['en'];
                        $name = $m['name'][$current_lang] ?? $m['name']['en'];
                        $designation = $m['designation'][$current_lang] ?? $m['designation']['en'];
                        $tu = $m['tu'][$current_lang] ?? $m['tu']['en'];
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4"><?= htmlspecialchars($m['no']) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($title) ?></td>
                        <td class="py-3 px-4 font-semibold"><?= htmlspecialchars($name) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($designation) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($tu) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script>
        function showTab(type) {
            const tableEmployer = document.getElementById('table-employer');
            const tableEmployee = document.getElementById('table-employee');
            const btnEmployer = document.getElementById('btn-employer');
            const btnEmployee = document.getElementById('btn-employee');
            
            if (type === 'employer') {
                tableEmployer.classList.remove('hidden');
                tableEmployee.classList.add('hidden');
                btnEmployer.className = "flex-1 text-center py-2.5 px-4 rounded-lg font-bold text-sm transition-all bg-primary text-white shadow";
                btnEmployee.className = "flex-1 text-center py-2.5 px-4 rounded-lg font-bold text-sm transition-all text-gray-500 hover:text-gray-800 hover:bg-white/50";
            } else {
                tableEmployer.classList.add('hidden');
                tableEmployee.classList.remove('hidden');
                btnEmployer.className = "flex-1 text-center py-2.5 px-4 rounded-lg font-bold text-sm transition-all text-gray-500 hover:text-gray-800 hover:bg-white/50";
                btnEmployee.className = "flex-1 text-center py-2.5 px-4 rounded-lg font-bold text-sm transition-all bg-primary text-white shadow";
            }
        }
        </script>

        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 max-w-lg notranslate">
            <h3 class="text-xl font-bold text-primary font-montserrat mb-4 flex items-center gap-3 notranslate">
                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span><?= t('contact_info_title', 'Contact Information') ?></span>
            </h3>
            <p class="text-gray-800 font-bold font-inter text-[15px] mb-1"><?= t('nlac_contact_name', 'Mr. B Vasanthan') ?></p>
            <p class="text-gray-500 font-inter text-sm mb-4 notranslate"><?= t('nlac_contact_person', 'Senior Assistant Secretary (Foreign Relations)') ?></p>
            <ul class="space-y-2 text-gray-600 font-inter text-sm">
                <li class="flex items-center gap-2">
                    <span class="font-semibold text-gray-700 w-12 notranslate"><?= t('tel_lbl', 'Tel:') ?></span> 
                    <a href="tel:+94112368609" class="hover:text-primary transition-colors notranslate">+94-11-2368609</a>
                </li>
                <li class="flex items-center gap-2">
                    <span class="font-semibold text-gray-700 w-12 notranslate"><?= t('fax_lbl', 'Fax:') ?></span> 
                    <span class="notranslate">+94-11-2368609</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="font-semibold text-gray-700 w-12 notranslate"><?= t('email_lbl', 'Email:') ?></span> 
                    <a href="mailto:sasfr@sltnet.lk" class="hover:text-primary transition-colors notranslate">sasfr@sltnet.lk</a>
                </li>
            </ul>
        </div>
        
    </div>
</section>

<?php
include 'includes/footer.php';
?>
