<?php
/**
 * Global Translation Dictionary & Helper Function
 * Hybrid Architecture: Manual human translations for key structural UI components,
 * while allowing Google Translate machine translation for dynamic body content.
 */

global $lang_dict;

$lang_dict = [
    // Navigation Bar & Main Menu
    'home' => [
        'en' => 'Home',
        'si' => 'මුල් පිටුව',
        'ta' => 'முகப்பு'
    ],
    'about_us' => [
        'en' => 'About Us',
        'si' => 'අප ගැන',
        'ta' => 'எங்களைப் பற்றி'
    ],
    'iau' => [
        'en' => 'IAU',
        'si' => 'IAU',
        'ta' => 'IAU'
    ],
    'overview' => [
        'en' => 'Overview',
        'si' => 'හැදින්වීම',
        'ta' => 'கண்ணோட்டம்'
    ],
    'current_updates' => [
        'en' => 'Current Updates',
        'si' => 'නවතම තත්වය',
        'ta' => 'තற்பෝதைய புதுப்பிப்புகள்'
    ],
    'rti' => [
        'en' => 'RTI',
        'si' => 'RTI',
        'ta' => 'RTI'
    ],
    'learning_platforms' => [
        'en' => 'Learning Platforms',
        'si' => 'ඔබේ දැනුමට',
        'ta' => 'கற்றல் தளங்கள்'
    ],
    'local_publications' => [
        'en' => 'Local Publications',
        'si' => 'දේශීය ප්‍රකාශන',
        'ta' => 'உள்நாட்டு வெளியீடுகள்'
    ],
    'foreign_publications' => [
        'en' => 'Foreign Publications',
        'si' => 'විදේශීය ප්‍රකාශන',
        'ta' => 'வெளிநாட்டு வெளியீடுகள்'
    ],
    'announcements' => [
        'en' => 'Announcements',
        'si' => 'නිවේදන',
        'ta' => 'அறிவிப்புகள்'
    ],
    'procurements' => [
        'en' => 'Procurements',
        'si' => 'ප්‍රසම්පාදන',
        'ta' => 'கொள்முதல்கள்'
    ],
    'vacancies' => [
        'en' => 'Vacancies',
        'si' => 'පුරප්පාඩු',
        'ta' => 'காலிப்பணியிடங்கள்'
    ],
    'special_notices' => [
        'en' => 'Special Notices',
        'si' => 'විශේෂ නිවේදන',
        'ta' => 'சிறப்பு அறிவிப்புகள்'
    ],
    'news' => [
        'en' => 'News',
        'si' => 'පුවත්',
        'ta' => 'செய்திகள்'
    ],
    'downloads' => [
        'en' => 'Downloads',
        'si' => 'බාගත කිරීම්',
        'ta' => 'பதிවிறக்கங்கள்'
    ],
    'contact_us' => [
        'en' => 'Contact Us',
        'si' => 'අප අමතන්න',
        'ta' => 'තொடர்புகொள்ள'
    ],

    // Global Search & Header Components
    'topbar_tel' => [
        'en' => 'Tel: (+94) 11 2581991',
        'si' => 'දුරකථන: (+94) 11 2581991',
        'ta' => 'தொலைபேசி: (+94) 11 2581991'
    ],
    'topbar_fax' => [
        'en' => 'Fax: (+94) 11 2368165',
        'si' => 'ෆැක්ස්: (+94) 11 2368165',
        'ta' => 'தொலைநகல்: (+94) 11 2368165'
    ],
    // Hero Section UI
    'welcome_to' => [
        'en' => 'Welcome to',
        'si' => 'සාදරයෙන් පිළිගනිමු',
        'ta' => 'நல்வரவு'
    ],
    'ministry_of_labour' => [
        'en' => 'Ministry of Labour',
        'si' => 'කම්කරු අමාත්‍යාංශය',
        'ta' => 'தொழில் அமைச்சு'
    ],
    'hero_desc' => [
        'en' => 'Dedicated to fostering fair employment, protecting workers\' rights, and building a dynamic workforce that drives Sri Lanka\'s economic development.',
        'si' => 'සාධාරණ රැකියා ප්‍රවර්ධනය කිරීම, කම්කරු අයිතිවාසිකම් සුරැකීම සහ ශ්‍රී ලංකාවේ ආර්ථික සංවර්ධනය මෙහෙයවන සක්‍රීය ශ්‍රම බලකායක් ගොඩනැගීමට කැපවී සිටී.',
        'ta' => 'நியாயமான வேலைவாய்ப்பை ஊக்குவிப்பதற்கும், தொழிலாளர்களின் உரிமைகளைப் பாதுகாப்பதற்கும், இலங்கையின் பொருளாதார வளர்ச்சியை உந்தித்தள்ளும் துடிப்பான பணியாளர்களை உருவாக்குவதற்கும் அர்ப்பணிக்கப்பட்டுள்ளது.'
    ],
    'view_notices' => [
        'en' => 'View Notices',
        'si' => 'නිවේදන බලන්න',
        'ta' => 'அறிவிப்புகளைப் பார்க்க'
    ],
    'search_placeholder' => [
        'en' => 'Search Ministry Services...',
        'si' => 'අමාත්‍යාංශ සේවාවන් සොයන්න...',
        'ta' => 'அமைச்சின் சேவைகளைத் தேடுங்கள்...'
    ],
    'select_language' => [
        'en' => 'Select Language',
        'si' => 'භාෂාව තෝරන්න',
        'ta' => 'மொழியைத் தேர்ந்தெடுக்கவும்'
    ],

    // Footer Structural UI
    'footer_motto' => [
        'en' => 'Committed to fostering productive labour relations, safeguarding workers\' rights, and promoting decent work for all citizens of Sri Lanka.',
        'si' => 'ඵලදායී කම්කරු සබඳතා වර්ධනය කිරීම, කම්කරු අයිතිවාසිකම් සුරැකීම සහ ශ්‍රී ලංකාවේ සියලුම පුරවැසියන් සඳහා යහපත් රැකියාවක් ප්‍රවර්ධනය කිරීමට කැපවී සිටී.',
        'ta' => 'உற்பத்தித்திறன்மிக்க தொழிலாளர் உறவுகளை வளர்ப்பதற்கும், தொழிலாளர்களின் உரிமைகளைப் பாதுகாப்பதற்கும், இலங்கையின் அனைத்துக் குடிமக்களுக்கும் கண்ணியமான வேலையை ஊக்குவிப்பதற்கும் அர்ப்பணிக்கப்பட்டுள்ளது.'
    ],
    'subscribe_title' => [
        'en' => 'Subscribe to receive the latest Ministry news, gazette notifications and policy updates.',
        'si' => 'අමාත්‍යාංශයේ නවතම පුවත්, ගැසට් නිවේදන සහ ප්‍රතිපත්ති යාවත්කාලීන ලබා ගැනීමට ලියාපදිංචි වන්න.',
        'ta' => 'அமைச்சின் அண்மைக்கால செய்திகள், வர்த்தமானி அறிவித்தல்கள் மற்றும் கொள்கை புதுப்பிப்புகளைப் பெற குழுசேரவும்.'
    ],
    'email_placeholder' => [
        'en' => 'Your Email Address',
        'si' => 'ඔබගේ විද්‍යුත් තැපැල් ලිපිනය',
        'ta' => 'உங்கள் மின்னஞ்சல் முகவரி'
    ],
    'subscribe_btn' => [
        'en' => 'Subscribe',
        'si' => 'ලියාපදිංචි වන්න',
        'ta' => 'குழுசேர்'
    ],
    'quick_links' => [
        'en' => 'Quick Links',
        'si' => 'ක්ෂණික පිවිසුම්',
        'ta' => 'விரைவு இணைப்புகள்'
    ],
    'ql_ampara' => [
        'en' => 'Ampara Circuit Bungalow',
        'si' => 'අම්පාර විශ්‍රාම ශාලාව',
        'ta' => 'அம்பாறை சுற்றுலா பங்களா'
    ],
    'ql_news_updates' => [
        'en' => 'News Updates',
        'si' => 'නවතම පුවත්',
        'ta' => 'அண்மைக்கාල செய்திகள்'
    ],
    'latest_news' => [
        'en' => 'Latest News',
        'si' => 'නවතම පුවත්',
        'ta' => 'அண்மைக்கාල செய்திகள்'
    ],
    'nlac_full' => [
        'en' => 'National Labour Advisory Council (NLAC)',
        'si' => 'ජාතික කම්කරු උපදේශක සභාව (NLAC)',
        'ta' => 'தேசிய தொழிலாளர் ஆலோசனைக் குழு (NLAC)'
    ],
    'nlac_desc' => [
        'en' => 'National Labour Advisory Council — consultative labour governance and social dialogue.',
        'si' => 'ජාතික කම්කරු උපදේශක සභාව (NLAC) — උපදේශනාත්මක කම්කරු පාලනය සහ සාමාජීය සංවාදය.',
        'ta' => 'தேசிய தொழிலாளர் ஆலோசனைக் குழு (NLAC) — ஆலோசனைக் தொழிலாளர் ஆளுகை மற்றும் சமூக உரையாடல்.'
    ],
    'ql_complaints' => [
        'en' => 'Complaints',
        'si' => 'පැමිණිලි',
        'ta' => 'புகார்கள்'
    ],
    'contact_heading' => [
        'en' => 'Contact',
        'si' => 'සම්බන්ධ කර ගැනීමට',
        'ta' => 'தொடர்புகளுக்கு'
    ],
    'get_directions' => [
        'en' => 'Get Directions',
        'si' => 'මාර්ග උපදෙස් ලබා ගන්න',
        'ta' => 'திசைகளைப் பெறுங்கள்'
    ],
    'ministry_address' => [
        'en' => '6th floor, Mehewara Piyasa, Narahenpita, Colombo 05, Sri Lanka.',
        'si' => '6 වන මහල, මෙහෙවර පියස, නාරාහේන්පිට, කොළඹ 05, ශ්‍රී ලංකාව.',
        'ta' => '6 வது மாடி, மெஹெவர பியஸ, நாரஹேன்பிட்ட, கொழும்பு 05, இலங்கை.'
    ],
    'rights_reserved' => [
        'en' => 'All rights reserved.',
        'si' => 'සියලුම හිමිකම් ඇවිරිණි.',
        'ta' => 'அனைத்து உரிமைகளும் பாதுகாக்கப்பட்டவை.'
    ],
    'last_updated' => [
        'en' => 'Last Updated',
        'si' => 'අවසන් වරට යාවත්කාලීන කළේ',
        'ta' => 'கடைசியாக புதுப்பிக்கப்பட்டது'
    ],

    // Additional Sub-Hero & Section Titles
    'iau_sub_title' => [
        'en' => '(Internal Affairs Unit)',
        'si' => '(අභ්‍යන්තර විගණන අංශය)',
        'ta' => '(உள்துறை தணிக்கைப் பிரிவு)'
    ],
    'rti_sub_title' => [
        'en' => '(Right to Information)',
        'si' => '(තොරතුරු දැනගැනීමේ අයිතිය)',
        'ta' => '(தகவல் அறியும் உரிமை)'
    ],
    'iau_updates' => [
        'en' => 'IAU Updates',
        'si' => 'IAU නවතම තත්වය',
        'ta' => 'உள்துறை தணிக்கைப் பிரிவு புதுப்பிப்புகள்'
    ],
    'ampara_bungalow' => [
        'en' => 'Ampara Circuit Bungalow',
        'si' => 'අම්පාර විශ්‍රාම ශාලාව',
        'ta' => 'அம்பாறை சுற்றுலா பங்களா'
    ],
    'ampara_booking' => [
        'en' => 'Ampara Circuit Bungalow Booking',
        'si' => 'අම්පාර විශ්‍රාම ශාලාව වෙන්කිරීම',
        'ta' => 'அம்பாறை சுற்றுலா பங்களா முன்பதிவு'
    ],
    'complaints' => [
        'en' => 'Complaints',
        'si' => 'පැමිණිලි',
        'ta' => 'புகார்கள்'
    ],
    'years_of_experience' => [
        'en' => 'Years of Experience',
        'si' => 'වසර ගණනාවක අත්දැකීම්',
        'ta' => 'ஆண்டுகள் அனுபவம்'
    ],
    'happy_customers' => [
        'en' => 'Happy Customers',
        'si' => 'සෑහීමට පත් පාරිභෝගිකයින්',
        'ta' => 'மகிழ்ச்சியான வாடிக்கையாளர்கள்'
    ],
    'related_organizations' => [
        'en' => 'Related Organizations',
        'si' => 'සම්බන්දිත ආයතන',
        'ta' => 'தொடர்புடைய அமைப்புகள்'
    ]
];

/**
 * Global Translation Helper Function `t($key, $fallback = '')`
 * Looks up human translation for given key based on global `$current_lang`.
 * Fallbacks to English dictionary entry, then provided fallback parameter, then string key itself.
 */
if (!function_exists('t')) {
    function t(string $key, string $fallback = ''): string {
        global $lang_dict, $current_lang;
        $lang = $current_lang ?? 'en';
        
        if (isset($lang_dict[$key][$lang]) && $lang_dict[$key][$lang] !== '') {
            return $lang_dict[$key][$lang];
        }
        
        if (isset($lang_dict[$key]['en']) && $lang_dict[$key]['en'] !== '') {
            return $lang_dict[$key]['en'];
        }
        
        return $fallback !== '' ? $fallback : $key;
    }
}
