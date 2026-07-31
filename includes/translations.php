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
        'ta' => 'தற்போதைய புதுப்பிப்புகள்'
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
    'learning_platforms_desc' => [
        'en' => 'Access local and foreign publications related to your knowledge.',
        'si' => 'ඔබේ දැනුමට අදාළ දේශීය හා විදේශීය ප්‍රකාශන වෙත ප්‍රවේශ වන්න.',
        'ta' => 'உங்கள் அறிவுக்கு தொடர்பான உள்நாட்டு மற்றும் வெளிநாட்டு வெளியீடுகளை அணுகவும்.'
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
    'acts_amendments' => [
        'en' => 'Acts & Amendments',
        'si' => 'පනත් සහ සංශෝධන',
        'ta' => 'சட்டங்கள் மற்றும் திருத்தங்கள்'
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
        'ta' => 'பதிவிறக்கங்கள்'
    ],
    'contact_us' => [
        'en' => 'Contact Us',
        'si' => 'අප අමතන්න',
        'ta' => 'தொடர்புகொள்ள'
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
    'view_news' => [
        'en' => 'View News',
        'si' => 'පුවත් බලන්න',
        'ta' => 'செய்திகளைப் பார்க்க'
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
        'si' => 'අම්පාර සංචාරක බංගලාව',
        'ta' => 'அம்பாறை சுற்றுலா பங்களா'
    ],
    'ql_news_updates' => [
        'en' => 'News Updates',
        'si' => 'නවතම පුවත්',
        'ta' => 'அண்மைக்கால செய்திகள்'
    ],
    'news_updates_desc' => [
        'en' => 'Read the latest news and updated notices related to the Ministry.',
        'si' => 'අමාත්‍යාංශයට අදාළ නවතම පුවත්, යාවත්කාලීන නිවේදන කියවන්න.',
        'ta' => 'அமைச்சு தொடர்பான அண்மைக்கால செய்திகள் மற்றும் புதுப்பிக்கப்பட்ட அறிவிப்புகளைப் படிக்கவும்.'
    ],
    'our_blog' => [
        'en' => 'Our Blog',
        'si' => 'අපගේ බ්ලොග් අඩවිය',
        'ta' => 'எமது வலைப்பதிவு'
    ],
    'latest_insights' => [
        'en' => 'Latest Insights',
        'si' => 'නවතම පුවත්',
        'ta' => 'அண்மைக்கால செய்திகள்'
    ],
    'recent_posts' => [
        'en' => 'Recent Posts',
        'si' => 'මෑතකාලීන පලකිරීම්',
        'ta' => 'சமீபத்திய இடுகைகள்'
    ],
    'latest_news' => [
        'en' => 'Latest News',
        'si' => 'නවතම පුවත්',
        'ta' => 'அண்மைக்கால செய்திகள்'
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
    'complaints_desc' => [
        'en' => 'Submit complaints to the Ministry via WhatsApp and submit complaints to the Department of Labour via CMS.',
        'si' => 'WhatsApp හරහා අමාත්‍යාංශය වෙත පැමිණිලි ඉදිරිපත් කිරීමට සහ CMS හරහා කම්කරු දෙපාර්තමේන්තුවට පැමිණිලි ඉදිරිපත් කරන්න.',
        'ta' => 'வாட்ஸ்அப் மூலம் அமைச்சிற்கு புகார்களை சமர்ப்பிக்கவும் மற்றும் CMS மூலம் தொழிலாளர் திணைக்களத்திற்கு புகார்களை சமர்ப்பிக்கவும்.'
    ],
    'rti_desc' => [
        'en' => 'Submit information requests under the Right to Information Act in Sri Lanka.',
        'si' => 'ශ්‍රී ලංකාවේ තොරතුරු දැනගැනීමේ අයිතිවාසිකම් පනත යටතේ තොරතුරු ඉල්ලීම් ඉදිරිපත් කරන්න.',
        'ta' => 'இலங்கையில் தகவல் அறியும் உரிமைச் சட்டத்தின் கீழ் தகவல் கோரிக்கைகளை சமர்ப்பிக்கவும்.'
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
        'si' => 'අම්පාර සංචාරක බංගලාව',
        'ta' => 'அம்பாறை சுற்றுலா பங்களா'
    ],
    'ampara_booking' => [
        'en' => 'Ampara Circuit Bungalow Booking',
        'si' => 'අම්පාර සංචාරක බංගලාව වෙන්කිරීම',
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
        'si' => 'සතුටුදායක ගනුදෙනුකරුවන්',
        'ta' => 'மகிழ்ச்சியான வாடிக்கையாளர்கள்'
    ],
    'related_organizations' => [
        'en' => 'Related Organizations',
        'si' => 'සම්බන්දිත ආයතන',
        'ta' => 'தொடர்புடைய அமைப்புகள்'
    ],

    // About Us Page: Vision, Mission & Overview
    'about_vision_title' => [
        'en' => 'Our Vision',
        'si' => 'අපගේ දැක්ම',
        'ta' => 'எமது நோக்கு'
    ],
    'about_vision_text' => [
        'en' => 'A satisfied, productive labour force',
        'si' => 'තෘප්තිමත් ඵලදායී ශ්‍රී ලාංකික ශ්‍රම බලකායක්',
        'ta' => 'திருப்திகரமான, உற்பத்தித்திறன்மிக்க இலங்கைத் தொழிலாளர் படை'
    ],
    'about_mission_title' => [
        'en' => 'Our Mission',
        'si' => 'අපගේ මෙහෙවර',
        'ta' => 'எமது பணிப்பொறுப்பு'
    ],
    'about_mission_text' => [
        'en' => 'Contribute to socio-economic development through industrial peace and cooperation, social protection, safeguarding labour rights and promotion of productivity.',
        'si' => 'කාර්මික සාමය හා සහයෝගීතාව, සමාජ සුරක්ෂිතතාවය, කම්කරු අයිතිවාසිකම් ආරක්ෂා කිරීම හා ඵලදායීතාව ප්‍රවර්ධනය තුළින් සමාජ-ආර්ථික සංවර්ධනයට දායක වීම',
        'ta' => 'தொழிற்துறை அமைதி மற்றும் ஒத்துழைப்பு, சமூகப் பாதுகாப்பு, தொழிலாளர் உரிமைகளைப் பாதுகாத்தல் மற்றும் உற்பத்தித்திறனை மேம்படுத்துதல் ஊடாக சமூக-பொருளாதார அபிவிருத்திக்குப் பங்களிப்பு செய்தல்.'
    ],
    'overview_p1' => [
        'en' => 'The prime mission of the Ministry of Labour is to formulate and implement policies to enhance the contribution of the local labour force to economic development by protecting the occupational rights of private and semi-government employees, ensuring social security, ensuring industrial peace, directing skilled labour to the job market, providing employment, ensuring job security and promoting productivity in the country.',
        'si' => 'පෞද්ගලික හා අර්ධ රාජ්‍ය අංශ සේවා නියුක්තිකයන්ගේ වෘත්තීය අයිතිවාසිකම් ආරක්ෂා කිරීම, සමාජ ආරක්ෂණය, කාර්මික සාමය තහවුරු කිරීම, රැකියා වෙළඳපොළ සඳහා පුහුණු ශ්‍රමිකයන් යොමු කිරීම, රැකියාගත කිරීම සහ රැකියා සුරක්ෂිතභාවය තහවුරු කිරීම, වෘත්තීය සුරක්ෂිතතාව හා සෞඛ්‍ය ආරක්ෂණය තහවුරු කිරීම තුළින් දේශීය ශ්‍රම බලකාය ආර්ථික සංවර්ධනය සඳහා දක්වන දායකත්වය ඉහළ නැංවීමට අවශ්‍ය ප්‍රතිපත්ති සම්පාදනය හා ක්‍රියාත්මක කිරීම කම්කරු අමාත්‍යාංශයේ ප්‍රධාන මෙහෙවර වේ.',
        'ta' => 'தனியார் மற்றும் பகுதியளவில் அரச துறைகளில் உள்ள ஊழியர்களின் தொழில் உரிமைகளைப் பாதுகாத்தல், சமூகப் பாதுகாப்பு, தொழிற்துறை அமைதியை உறுதி செய்தல், பயிற்சி பெற்ற தொழிலாளர்களை தொழில் சந்தைக்கு வழிநடத்துதல், தொழில் வாய்ப்பை உறுதி செய்தல், தொழில் பாதுகாப்பை உறுதி செய்தல் மற்றும் நாட்டின் உற்பத்தித்திறனை மேம்படுத்துதல் ஆகியவற்றின் மூலம் பொருளாதார அபிவிருத்திக்கு உள்நாட்டு பணியாளர்களின் பங்களிப்பை மேம்படுத்துவதற்கான கொள்கைகளை வகுத்துச் செயற்படுத்துவதே தொழில் அமைச்சின் பிரதான பணியாகும்.'
    ],
    'overview_p2' => [
        'en' => 'In pursuit of this mission, the key function of this Ministry is to formulate policies, plan, implement, monitor and follow up on programmes and projects related to the scope of labour and the scopes of departments and institutions affiliated to the Ministry, based on the tasks assigned and national policies in terms of the Gazette Extraordinary Notification No. 2412/08 dated 25.11.2024, in accordance with the sustainable development goals and international conventions ratified by Sri Lanka the Government.',
        'si' => 'මෙම මෙහෙවර ඉටු කිරීමේදී තිරසාර සංවර්ධන අරමුණු සහ ශ්‍රී ලංකාව විසින් අනුමත කර ඇති ජාත්‍යන්තර සම්මුතීන් මෙන්ම 2024.11.25 දිනැති අංක 2412/08 දරන අතිවිශේෂ ගැසට් නිවේදනයෙහි සඳහන් කාර්යයන් හා කර්තව්‍යයන් මත පදනම්ව අමාත්‍යාංශ වැඩසටහන් සළස්වා ඇත. එම ගැසට් නිවේදනය ප්‍රකාරව රජය විසින් ක්‍රියාත්මක කරනු ලබන ජාතික ප්‍රතිපත්තීන් මත පිහිටා කම්කරු විෂය පථයට සහ අමාත්‍යාංශයට අනුබද්ධ ආයතනයන්හි විෂය පථයන්ට අදාළව ප්‍රතිපත්ති සම්පාදනය, වැඩසටහන් සහ ව්‍යාපෘති සැලසුම් කිරීම, ක්‍රියාත්මක කිරීම, අධීක්ෂණය හා පසුවිපරම් කිරීම මෙම අමාත්‍යාංශයේ ප්‍රධාන කාර්යභාරය වේ.',
        'ta' => 'இந்தப் பணியை நிறைவேற்றுவதில், நிலைபேறான அபிவிருத்தி இலக்குகள் மற்றும் இலங்கையால் ஏற்று அங்கீகரிக்கப்பட்ட சர்வதேச சமவாயங்கள் அடிப்படையில், தாபிக்கப்பட்ட 2022.07.22 திகதியிட்ட 2289/43 ஆம் இலக்கம் மற்றும் 2024.11.25 திகதியிட்ட 2412/08 ஆம் இலக்கம் கொண்ட அதிவிசேட வர்த்தமானி அறிவிப்புகளின் அடிப்படையில் ஒப்படைக்கப்பட்ட பொறுப்புகள் மற்றும் தேசிய கொள்கை அடிப்படையில் தாபிக்கப்பட்ட தொழில் விடயப்பரப்பு மற்றும் அமைச்சுடன் இணைக்கப்பட்ட நிறுவனங்களின் விடயப்பரப்பு தொடர்பான கொள்கைகளை உருவாக்குதல், நிகழ்ச்சித் திட்டங்கள் மற்றும் கருத்திட்டங்களை திட்டமிடுதல், செயற்படுத்துதல், மேற்பார்வை செய்தல் மற்றும் பின்தொடர் நடவடிக்கையில் ஈடுபடல் இந்த அமைச்சின் பிரதான செயற்பாடாகும்.'
    ],
    'about_ministry_title' => [
        'en' => 'About the Ministry of Labour',
        'si' => 'කම්කරු අමාත්‍යාංශය පිළිබඳව',
        'ta' => 'தொழில் அமைச்சு பற்றி'
    ],
    'read_more' => [
        'en' => 'Read More',
        'si' => 'තවදුරටත් කියවන්න',
        'ta' => 'மேலும் படிக்க'
    ],

    // Affiliated Bodies / Institutions Section
    'affiliated_institutions' => [
        'en' => 'Affiliated Institutions',
        'si' => 'අමාත්‍යාංශයට අනුබද්ධිත ආයතන',
        'ta' => 'அமைச்சின் கீழுள்ள நிறுவனங்கள்'
    ],
    'visit_website' => [
        'en' => 'Website',
        'si' => 'වෙබ් අඩවිය',
        'ta' => 'இணையதளம்'
    ],
    'inst_dol_title' => [
        'en' => 'Department of Labour',
        'si' => 'කම්කරු දෙපාර්තමේන්තුව',
        'ta' => 'தொழில் திணைக்களம்'
    ],
    'inst_dol_p1' => [
        'en' => "The key function of the Department of Labour is to create a decent working environment by safeguarding the rights secured under labor laws to the employees of the private and semi-government sectors, who represent the majority of Sri Lanka's total workforce. This is achieved through promotion of employer-employee relations and the protecting industrial peace and harmony at the institutional level.",
        'si' => 'ශ්‍රී ලංකාවේ සමස්ත ශ්‍රම බලකායේ බහුතරය නියෝජනය කරනු ලබන පෞද්ගලික අංශයේ සහ අර්ධ රාජ්‍ය අංශයේ සේවක ප්‍රජාව වෙත කම්කරු නීති මඟින් හිමිකර දී ඇති අයිතිවාසිකම් තහවුරු කිරීම, සේව්ය - සේවක සබඳතාවය ප්‍රවර්ධනය කිරීම තුළින් සහ ආයතන මට්ටමින් කාර්මික සාමය සුරක්ෂිත කිරීම තුළින් සුනිසි වැඩ පරිසරයක් ඇති කිරීම කම්කරු දෙපාර්තමේන්තුවේ ප්‍රධාන කාර්යභාරය වේ.',
        'ta' => 'இலங்கையில் மொத்த பணியாளர்களில் பெரும்பான்மையினரை பிரதிநிதித்துவப்படுத்தும் தனியார் மற்றும் பகுதி அளவிலான அரசுத்துறை ஊழியர்களுக்கு வழங்கப்படும் உரிமைகளை உறுதி செய்வதன் மூலமும், தொழில் தருநர் -பணியாளர் உறவுகளை மேம்படுத்துவதன் மூலமும், நிறுவன மட்டத்தில் தொழில்துறை அமைதியைப் பாதுகாப்பதன் மூலமும் ஒரு ஒழுக்கமான பணிச்சூழலை உருவாக்குவதே தொழில் திணைக்களத்தின் முக்கிய வகிபங்கு ஆகும்.'
    ],
    'inst_dol_p2' => [
        'en' => 'With a history over a century, the Department of Labour has currently initiated necessary steps to provide a more efficient service through digitalization. In particular, introduction of electronic services (e-services) will provide clients with the opportunity to fulfill their requirements more easily and efficiently.',
        'si' => 'වසර සියයකට අධික ඉතිහාසයක් හිමි කම්කරු දෙපාර්තමේන්තුව, වර්තමානය වන විට ඩිජිටල්කරණය ඔස්සේ වඩාත් කාර්යක්ෂම සේවාවක් ලබා දීම සඳහා අවශ්‍ය කටයුතු ආරම්භ කර ඇත. විශේෂයෙන්ම විද්‍යුත් සේවාවන් (e-services) හඳුන්වා දීම මඟින් සේවාලාභීන්ට තම අවශ්‍යතා වඩාත් පහසුවෙන් සහ කාර්යක්ෂමව ඉටු කර ගැනීමට අවස්ථාව උදාවනු ඇත.',
        'ta' => 'நூறு ஆண்டுகளுக்கும் மேலான வரலாற்றைக் கொண்ட தொழில் திணைக்களம், டிஜிட்டல் மயமாக்கல் மூலம் மிகவும் திறமையான சேவைகளை வழங்குவதற்குத் தேவையான நடவடிக்கைகளில் தற்போது இறங்கியுள்ளது. குறிப்பாக, மின்னணு சேவைகள் (e-services) அறிமுகப்படுத்தப்படுவது வாடிக்கையாளர்கள் தங்கள் தேவைகளை மிகவும் எளிதாகவும் வினைத்திறனாகவும் நிறைவேற்றிக் கொள்ளும் வாய்ப்பை வழங்கும்.'
    ],
    'inst_dol_p3' => [
        'en' => 'Accordingly, the Department functions proactively to promote industrial harmony by nurturing constructive employer–employee relationships and strengthening the protection of workers’ rights.',
        'si' => 'එසේම සේවා යෝජක-සේවක සබඳතාවයන් පෝෂණය කරමින් සහ සේවක අයිතීන් ශක්තිමත් කරමින් කාර්මික සාමය ප්‍රවර්ධනය උදෙසා දෙපාර්තමේන්තුව ක්‍රියාකාරීව කටයුතු කරනු ලැබේ.',
        'ta' => 'அதன்படி, தொழில் தருநர்-பணியாளர் உறவுகளை வளர்ப்பதன் மூலமும், ஊழியர் உரிமைகளை வலுப்படுத்துவதன் மூலமும் தொழில்துறை அமைதியை மேம்படுத்துவதற்கு திணைக்களம் தீவிரமாக செயல்பட்டு வருகிறது.'
    ],
    'inst_dme_title' => [
        'en' => 'Department of Manpower and Employment',
        'si' => 'මිනිස්බල හා රැකියා නියුක්ති දෙපාර්තමේන්තුව',
        'ta' => 'மனிதவலு மற்றும் வேலைவாய்ப்புத் திணைக்களம்'
    ],
    'inst_dme_p1' => [
        'en' => 'The Department of Manpower and Employment was established in 2010 under the Ministry of Labour Relations and Manpower, in accordance with the provisions of the Extraordinary Gazette Notification No. 1640/31 dated February 12, 2010. It currently functions under the Ministry of Labour. Established as a "Grade A" department, its designated subjects include the promotion of employment, employment planning, employment and labor market information, and vocational guidance programs. Additionally, the department is assigned with the responsibility of maintaining public employment services and implementing the provisions of the National Human Resources and Employment Policy.',
        'si' => '2010.02.12 දිනැති අංක 1640/31 දරණ අතිවිශේෂ ගැසට් පත්‍රයේ විධිවිධාන අනුව මිනිස්බල හා රැකියා නියුක්ති දෙපාර්තමේන්තුව 2010 වර්ෂයේදී කම්කරු සබඳතා හා මිනිස්බල අමාත්‍යාංශය යටතේ ස්ථාපනය කරන ලද අතර වර්තමානයේ කම්කරු අමාත්‍යාංශය යටතේ ක්‍රියාත්මක වේ. A ශ්‍රේණියේ දෙපාර්තමේන්තුවක් ලෙස ස්ථාපනය කරන ලද මෙම දෙපාර්තමේන්තුව සඳහා රැකියා නියුක්තිය ප්‍රවර්ධනය කිරීම, රැකියා සැලසුම්කරණය, රැකියා නියුක්තිය හා ශ්‍රම වෙළඳපොළ තොරතුරු, වෘත්තීය මාර්ගෝපදේශන වැඩසටහන් යන විෂයන් නියම කරනු ලැබිණි. ඊට අමතරව දෙපාර්තමේන්තුව වෙත මහජන රැකියා සේවාවන් පවත්වාගෙන යාම හා ජාතික මානව සම්පත් හා රැකියා නියුක්ති ප්‍රතිපත්තියේ විධිවිධාන ක්‍රියාත්මක කිරීමේ වගකීම ද පැවරී ඇත.',
        'ta' => '12.02.2010 திகதியிட்ட 1640/31 ஆம் இலக்கம் கொண்ட அதிவிசேட வர்த்தமானியின் விதிகளின்படி, மனிதவலு மற்றும் வேலைவாய்ப்புத் திணைக்களம் 2010 இல் தொழில் உறவுகள் மற்றும் மனிதவள அமைச்சின் கீழ் நிறுவப்பட்டது மற்றும் தற்போது தொழில் அமைச்சின் கீழ் செயல்பட்டு வருகிறது. A-தரத் திணைக்களமாக நிறுவப்பட்ட இந்த திணைக்களம் வேலைவாய்ப்பு அபிவிருத்தி, வேலைவாய்ப்பு திட்டமிடல், வேலைவாய்ப்பு மற்றும் தொழில் சந்தை தகவல் மற்றும் தொழில் வழிகாட்டுதல் திட்டங்கள் ஆகிய விடயங்கள் தீர்மானிக்கப்பட்டன. இதற்கு மேலதிகமாக இந்தத் திணைக்களத்துக்கு மக்கள் வேலைவாய்ப்பு சேவைகளைப் பராமரிப்பதற்கும் தேசிய மனிதவளம் மற்றும் வேலைவாய்ப்புக் கொள்கையின் விதிகளை செயல்படுத்துவதற்குமான பொறுப்பு ஒப்படைக்கப்பட்டுள்ளது.'
    ],
    'inst_dme_p2' => [
        'en' => 'Utilizing survey data compiled by its Labor Market Information Unit, the department implements district and divisional-level programs related to vocational guidance and job creation promotion. Through these initiatives, unemployed youth are directed towards employment opportunities in the private sector.',
        'si' => 'මෙම දෙපාර්තමේන්තුව විසින් මෙතෙක් ශ්‍රම වෙළඳපොළ තොරතුරු ඒකකය මඟින් සිදුකරන ලද සම්පූර්ණ තොරතුරු උපයෝගී කර ගනිමින් වෘත්තීය මාර්ගෝපදේශනයට හා රැකියා නියුක්ති ප්‍රවර්ධනයට අදාළව දිස්ත්‍රික් හා ප්‍රාදේශීය වශයෙන් වැඩසටහන් ක්‍රියාත්මක කෙරේ. මෙයින් රැකියා විරහිත තරුණ තරුණයන් පෞද්ගලික අංශයේ රැකියා සඳහා යොමු කිරීම සිදුකරනු ලැබේ.',
        'ta' => 'இந்த திணைக்களத்தால் இதுவரை தொழில் சந்தை தகவல் பிரிவால் நடத்தப்பட்ட கணக்கெடுப்புத் தகவல்களைப் பயன்படுத்தி, தொழில் வழிகாட்டுதல் மற்றும் வேலை உருவாக்கம் அபிவிருத்தி தொடர்பான மாவட்ட மற்றும் பிரதேச ரீதியான நிகழ்ச்சித் திட்டங்கள் செயல்படுத்தப்பட்டு வருகின்றன. இதன் மூலம், வேலையற்ற இளைஞர்கள் மற்றும் யுவதிகள் தனியார் துறையில் வேலைகளுக்கு அனுப்பப்படுகிறார்கள்.'
    ],
    'inst_nils_title' => [
        'en' => 'National Institute of Labour Studies',
        'si' => 'ජාතික ශ්‍රම අධ්‍යයන ආයතනය',
        'ta' => 'தேசிய தொழில் கற்கைகள் நிறுவனம்'
    ],
    'inst_nils_p1' => [
        'en' => 'The National Institute of Labour Studies (NILS), which currently operates under the Ministry of Labour, was established on 11 September 2007 and is governed by the provisions of the National Institute of Labour Studies Act No. 12 of 2010. The Institute is administered by a governing board comprising representatives of the tripartite partners in the labour sector employers, employees, and the government.',
        'si' => 'ජාතික ශ්‍රම අධ්‍යයන ආයතනය 2007 සැප්තැම්බර් 11 වන දින ස්ථාපිත කරන ලද අතර, 2010 අංක 12 දරන ජාතික ශ්‍රම අධ්‍යයන ආයතන පනත මඟින් බලගන්වා ඇත. කම්කරු ක්ෂේත්‍රයේ ප්‍රධානතම පාර්ශවකරුවන් වන සේව්ය, සේවක හා රාජ්‍ය නිලධාරීන්ගෙන් සැදුම්ලත් පාලක මණ්ඩලයක් විසින් මෙම ආයතනය පාලනය වේ.',
        'ta' => 'தேசிய தொழில் கற்கைகள் நிறுவனம், 2007 செப்டம்பர் 11, அன்று நிறுவப்பட்டதோடு, 2010 இலக்கம் 12 தாங்கிய தேசிய தொழில் கற்கைகள் நிறுவனச் சட்டத்தால் இந்த நிறுவனம் செயல்படுத்தப்பட்டது. தொழில் துறையில் முத்தரப்பு பங்காளர்களான தொழில் தருநர், ஊழியர்கள் மற்றும் அரசு ஊழியர்களைக் கொண்ட ஒரு நிர்வாகக் குழுவால் நிறுவனம் நிர்வகிக்கப்படுகிறது.'
    ],
    'inst_nils_p2' => [
        'en' => 'The primary function of the Institute is to plan and implement the necessary training and research activities required to develop an informed and productive labour force that is knowledgeable about labour laws, regulations, and procedures. With the objective of providing a more effective service to trade union activists and worker representatives, the National Institute of Labour Studies is presently located on the second floor of the Department of Labour Secretariat Building.',
        'si' => 'කම්කරු අයිතීන්, නීති රීති හා රෙගුලාසි පිළිබඳව දැනුවත් සහ ඵලදායී ශ්‍රම බලකායක් නිර්මාණය කිරීම සඳහා අවශ්‍ය පුහුණු හා පර්යේෂණ කටයුතු සැලසුම් කිරීම සහ ක්‍රියාත්මක කිරීම මෙම ආයතනයේ මූලික කාර්යභාරය වේ. ජාතික ශ්‍රම අධ්‍යයන ආයතනය කම්කරු මහලේකම් කාර්යාල පරිශ්‍රයේ දෙවන මහලේ ස්ථාපිත කර ඇත.',
        'ta' => 'தொழில் சட்டங்கள், விதிகள் மற்றும் ஒழுங்குமுறைகள் குறித்து அறிவு மற்றும் உற்பத்தித் திறன் கொண்ட பணியாளர்களை உருவாக்குவதற்குத் தேவையான பயிற்சி மற்றும் ஆராய்ச்சி நடவடிக்கைகளைத் திட்டமிட்டு செயல்படுத்துவதே இந்த நிறுவனத்தின் முதன்மைப் பணியாகும். தேசிய தொழில் கற்கைகள் நிறுவனம் தற்போது தொழில் செயலக கட்டிடத்தின் இரண்டாவது மாடியில் நிறுவப்பட்டுள்ளது.'
    ],
    'inst_niosh_title' => [
        'en' => 'National Institute of Occupational Safety and Health',
        'si' => 'ජාතික වෘත්තීය සුරක්ෂිතතා සහ සෞඛ්‍ය ආයතනය',
        'ta' => 'தேசிய தொழில்சார் பாதுகாப்பு மற்றும் சுகாதார நிறுவனம்'
    ],
    'inst_niosh_p1' => [
        'en' => 'With the objective of creating a safe and healthy workforce in Sri Lanka through the adoption of sound occupational safety measures and good health practices, the National Institute of Occupational Safety and Health (NIOSH) was established as an affiliated institution under the then Ministry of Labour and Labour Relations, by the National Institute of Occupational Safety and Health Act No. 38 of 2009.',
        'si' => 'ශ්‍රී ලංකාව තුළ යහපත් වෘත්තීය ආරක්ෂණ ක්‍රියාමාර්ග හා යහපත් සෞඛ්‍ය පුරුදු අනුගමනය කරමින් සුරක්ෂිත හා සෞඛ්‍ය සම්පන්න ශ්‍රම බලකායක් බිහි කරලීමේ අරමුණින් 2009 අංක 38 දරණ ජාතික වෘත්තීය සුරක්ෂිතතා හා සෞඛ්‍යය පිළිබඳ ආයතන පනත මඟින් ජාතික වෘත්තීය සුරක්ෂිතතා හා සෞඛ්‍යය ආයතනය ස්ථාපිත කර ඇත.',
        'ta' => 'இலங்கையில் நல்ல தொழில் பாதுகாப்பு நடவடிக்கைகள் மற்றும் நல்ல சுகாதார நடைமுறைகளைப் பின்பற்றுவதன் மூலம் பாதுகாப்பான மற்றும் ஆரோக்கியமான பணியாளர்களை உருவாக்கும் நோக்கத்துடன் 2009 ஆம் ஆண்டு 38 ஆம் இலக்க தேசிய தொழில்சார் பாதுகாப்பு மற்றும் சுகாதார நிறுவனச் சட்டத்தின் மூலம் தேசிய தொழில்சார் பாதுகாப்பு மற்றும் சுகாதார நிறுவனம் நிறுவப்பட்டது.'
    ],
    'inst_niosh_p2' => [
        'en' => 'This institute works on to creating a prolific workforce in Sri Lanka through daily environmental measurement surveys, risk assessment and medical examinations as well as trainings conducted as special programmes, projects and activities carried out on the basis of international cooperation with other countries.',
        'si' => 'දෛනිකව සිදු කරනු ලබන පාරිසරික මිණුම් සමීක්ෂණ, අවදානම් ඇගයීම හා වෛද්‍ය පරීක්ෂණ මඟින් මෙන්ම විශේෂ වැඩසටහන් ලෙස ක්‍රියාත්මක කරනු ලබන පුහුණු කිරීම්, ව්‍යාපෘති මඟින් හා වෙනත් රටවල් සමඟ අන්තර් ජාතික සහයෝගීතාවය මත සිදු කරනු ලබන ක්‍රියාකාරකම් තුළින් ශ්‍රී ලංකාව තුළ වැඩදායී ශ්‍රම බලකායක් බිහි කරවාලීමට මෙම ආයතනය විසින් කටයුතු කරනු ලැබෙයි.',
        'ta' => 'தினசரி சுற்றுச்சூழல் அளவீட்டு ஆய்வுகள், இடர்நேர்வு மதிப்பீடுகள் மற்றும் மருத்துவ பரிசோதனைகள் மூலம், அத்துடன் விசேட நிகழ்ச்சித் திட்டங்களாக நடைமுறைப்படுத்தப்படும் பயிற்றுவித்தல், செயற்றிட்டங்கள் மூலம் மற்றும் பிற நாடுகளுடனான சர்வதேச ஒத்துழைப்பு அடிப்படையில் மேற்கொள்ளப்படும் செயற்பாடுகள் மூலம் இலங்கையில் உற்பத்தித் திறன் கொண்ட பணியாளர்களை உருவாக்குவதற்கு இந்த நிறுவனம் செயல்படுகிறது.'
    ],
    'inst_wc_title' => [
        'en' => "Office of the Commissioner for Workmen's Compensation",
        'si' => 'කම්කරු වන්දි කොමසාරිස් කාර්යාලය',
        'ta' => 'வேலையாளர் நட்டஈட்டு ஆணையாளர் அலுவலகம்'
    ],
    'inst_wc_p1' => [
        'en' => "The Workmen’s Compensation Ordinance No. 19 of 1934 was enacted to provide compensation in respect of accidents occurring in the course of employment. Several amendments have been made to this Ordinance on different occasions, and the latest amendment was effected by Act No. 10 of 2022. The Workmen’s Compensation Court, which exercises the powers of a District Judge and a Magistrate, consists of 14 circuit courts covering the entire island. The judicial officers appointed by the Judicial Service Commission include the Commissioner of Workmen’s Compensation, the Additional Commissioner of Workmen’s Compensation, and the Deputy Commissioner of Workmen’s Compensation, among others, making up a total of 43 positions, which also include a Class I post of the Sri Lanka Accountants’ Service and a post of the Sri Lanka Administrative Service. The main objectives of the Office of the Workmen’s Compensation Commissioner are to pay compensation to employees injured in accidents arising out of and in the course of their employment, to pay compensation to employees suffering from diseases contracted due to the nature of their employment, and to pay compensation to the dependents of employees who die as a result of such accidents occurring in the course of employment.",
        'si' => 'සේවයේ යෙදී සිටින අවස්ථාවේදී සිදුවන අනතුරු සම්බන්ධයෙන් වන්දි ලබාදීම සඳහා 1934 අංක 19 දරණ කම්කරු වන්දි ආඥා පනත පනවා ඇත. මෙම පනතට යම් යම් අවස්ථාවන්හිදී සංශෝධන කිහිපයක් ඇතුළත් වූ අතර, අවසාන සංශෝධනය 2022 අංක 10 පනතින් සිදුකර ඇත. කම්කරු වන්දි උසාවිය දිසා විනිසුරු හා මහේස්ත්‍රාත් බලතල සහිතව මුළු දිවයිනම ආවරණය වන පරිදි සංචාරක උසාවි 14 කින් සමන්විත වේ. අධිකරණ සේවා කොමිෂන් සභාව මඟින් පත්කරනු ලබන අධිකරණ නිලධාරීන් වන කම්කරු වන්දි කොමසාරිස්, අතිරේක කම්කරු වන්දි කොමසාරිස් හා නියෝජ්‍ය කම්කරු වන්දි කොමසාරිස් යන තනතුරු 3කින් ද ශ්‍රී ලංකා ගණකාධිකාරී සේවයේ I වන පන්තියේ තනතුරක්ද ශ්‍රී ලංකා පරිපාලන සේවයේ තනතුරක් ද ඇතුළු තනතුරු 43 කින් සමන්විත වේ. රැකියාවේ යෙදී සිටියදී සිදුවන අනතුරු වලින් තුවාල ලබන සේවකයින්ට වන්දි අයකර දීම, රැකියාවේ ස්වභාවය නිසා වැළඳුණු රෝගවලින් පීඩා විඳින සේවකයින්ට වන්දි අයකර දීම හා සේවයේ යෙදී සිටින විට සිදුවන අනතුරු වලින් මියයන සේවකයින්ගේ යැපෙන්නන්ට වන්දි අයකර දීම කම්කරු වන්දි කොමසාරිස් කාර්යාලයේ ප්‍රධාන අරමුණු වේ.',
        'ta' => 'சேவையில் ஈடுபட்டுள்ள போது இடம்பெறுகின்ற விபத்துகள் தொடர்பில் நட்ட ஈடுகளைப் பெற்றுக்கொள்வதற்காக 1934 ஆம் ஆண்டின் 19 ஆம் இலக்க வேலையாளர் நட்ட ஈட்டு கட்டளைச்சட்டம் இயற்றப்பட்டுள்ளது. சிற்சில சந்தர்ப்பங்களில் இச்சட்டத்தில் சில திருத்தங்கள் மேற்கொள்ளப்பட்டுள்ளதோடு இறுதித் திருத்தம் 2022 ஆம் ஆண்டின் 10 ஆம் இலக்க சட்டத்தின் மூலம் மேற்கொள்ளப்பட்டுள்ளது. வேலையாளர் நட்ட ஈட்டு நீதிமன்றம் மாவட்ட நீதிபதி மற்றும் நீதிவானின் அதிகாரங்களோடு ஒட்டுமொத்த நாடும் உள்வாங்கப்படும் வகையில் 14 சுற்றுலா நீதிமன்றங்களைக் கொண்டமைந்துள்ளது. நீதிச் சேவைகள் ஆணைக்குழுவினால் நியமிக்கப்படுகின்ற நீதித்துறை உத்தியோகத்தர்களான வேலையாளர் நட்டஈட்டு ஆணையாளர், மேலதிக வேலையாளர் நட்ட ஈட்டு ஆணையாளர் மற்றும் பிரதி வேலையாளர் நட்ட ஈட்டு ஆணையாளர் ஆகிய 03 பதவிகளையும், இலங்கை கணக்காளர் சேவையின் I ஆம் வகுப்பு பதவி ஒன்றையும் இலங்கை நிர்வாக சேவையின் பதவி ஒன்றையும் உள்ளிட்டதாக 43 பதவிகளைக் கொண்டமைந்துள்ளது. சேவையில் ஈடுபட்டுள்ளபோது இடம்பெறுகின்ற விபத்துகளினால் காயங்களுக்கு உள்ளாகின்ற தொழிலாளர்களுக்கும் தொழிலின் தன்மை காரணமாக ஏற்பட்ட நோய்களினால் பாதிக்கப்பட்டுள்ள தொழிலாளர்களுக்கும் சேவையில் ஈடுபட்டுள்ள போது ஏற்படுகின்ற விபத்துகளினால் மரணமடைகின்ற தொழிலாளர்களில் தங்கி வாழ்வோருக்கும் நட்ட ஈடுகளை அறவிட்டுக் கொடுப்பது பிரதான நோக்கமாகும்.'
    ],
    'inst_wc_p2' => [
        'en' => 'For judicial proceedings relating to workmen’s compensation, the Criminal Procedure Code, the Civil Procedure Code, and the Evidence Ordinance are applicable, and the appeal procedure is similar to that of a District Court.',
        'si' => 'කම්කරු වන්දි අධිකරණ ක්‍රියාවලිය සඳහා අපරාධ නඩු විධාන සංග්‍රහය, සිවිල් නඩු විධාන සංග්‍රහය සහ සාක්ෂි ආඥා පනත අදාළ කර ගන්නා අතර, අභියාචන පටිපාටිය දිසා අධිකරණයකට සමාන වේ.',
        'ta' => 'வேலையாளர் நட்ட ஈட்டு நீதிமன்ற செயன்முறைக்காக குற்றவியல் நடவடிக்கை முறைக் கோவை, சிவில் நடவடிக்கை முறைக் கோவை மற்றும் சாட்சிகள் கட்டளைச்சட்டம் ஏற்புடையதாக்கிக் கொள்ளப்படுவதோடு மேல்முறையீட்டு நடவடிக்கையானது மாவட்ட நீதிமன்றத்திற்கு ஒத்ததாகும்.'
    ],
    // Divisions & Functions Translations
    'div_section_title' => array (
  'en' => 'Divisions under the Ministry',
  'si' => 'අමාත්‍යාංශය යටතේ පවතින අංශ',
  'ta' => 'அமைச்சின் கீழுள்ள பிரிவுகள்',
),
    'div_admin_title' => array (
  'en' => 'Administration and Establishments Division',
  'si' => 'පාලන හා ආයතන අංශය',
  'ta' => 'நிர்வாகம் மற்றும் தாபனப் பிரிவு',
),
    'div_admin_content' => array (
  'en' => '<p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">The Administration Division is functioned in three sub-divisions: Administration, Establishment and Legal. The Administration and Establishment sub division handle the ministry\'s administration, human resource management, general maintenance, staff training, coordination of departments institutions affiliated to the ministry.</p><p class="mt-4">Meanwhile, the Legal section is responsible for taking necessary steps to update existing labor laws to align with new trends, introducing and implementing new rules and regulations to facilitate the execution of ratified international conventions with follow-up activities. Further, functions performed by the Administration Division are as follows.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">Preparation of cabinet memoranda and taking action in respect of cabinet decisions.</li><li class="pl-1">Providing answers to referrals made by the Consultative Committee and Public Petitions Committee as well as parliamentary questions.</li><li class="pl-1">Submission of annual reports and performance reports of the Ministry and all departments and statutory institutions under the Ministry to Parliament.</li><li class="pl-1">Collection and submission of declarations of assets and liabilities of relevant officers in accordance with the regulations of the Commission to Investigate Allegations of Bribery or Corruption.</li><li class="pl-1">Handling reservations, maintenance, and administrative activities of the Ministry’s circuit bungalow in Ampara.</li><li class="pl-1">Managing matters related to lands and buildings owned by the Ministry and by departments and statutory institutions under it.</li><li class="pl-1">Handling matters related to the appointment of boards of directors of statutory institutions functioning under the Ministry.</li><li class="pl-1">Handling activities related to July strike compensation payments.</li></ul>',
  'si' => '<p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">පාලන අංශය පාලන, ආයතන හා නීති ලෙස උප අංශ තුනක් යටතේ ක්‍රියාත්මක වේ. අමාත්‍යාංශයේ පරිපාලනය, මානව සම්පත් කළමනාකරණය, සාමාන්‍ය නඩත්තුව, කාර්ය මණ්ඩල පුහුණු කිරීම සහ අමාත්‍යාංශය යටතේ ක්‍රියාත්මක වන ආයතන සම්බන්ධීකරණය කිරීම සහ ඒ අනුව රාජ්‍යපරිපාලන හා ආයතන අංශ යටතේ සිදු කෙරේ.</p><p class="mt-4">එසේම පවත්නා කම්කරු නීති නව ප්‍රවණතා අනුව ගැලපෙන ලෙස යාවත්කාලීන කිරීම සඳහා අවශ්‍ය ක්‍රියාමාර්ග ගැනීම, අප්‍රමාදිත කරන ලද ජාත්‍යන්තර සම්මුතීන් ක්‍රියාවේ යෙදීමට හැකිවන නව නීති රීති හඳුන්වා දීම හා ක්‍රියාත්මක කිරීම සහ පසු විපරම් යනාදී කාර්යයන් නීති අංශය හරහා සිදු කෙරේ. මීට අමතරව පාලන අංශය විසින් සිදු කෙරෙන කාර්යයන් පහත පරිදි වේ.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">අමාත්‍ය මණ්ඩල සංදේශ සෑදීම හා අමාත්‍ය මණ්ඩල තීරණ පිළිබඳ ක්‍රියාකිරීම.</li><li class="pl-1">උපදේශක කාරක සභා, මහජන පෙත්සම් කාරක සභා වෙතින් සිදු කරන යොමු කිරීම් සඳහා පිළිතුරු සැපයීම මෙන්ම පාර්ලිමේන්තු ප්‍රශ්න සඳහා පිළිතුරු සැපයීම.</li><li class="pl-1">අමාත්‍යාංශය සහ අමාත්‍යාංශය යටතේ පවතින දෙපාර්තමේන්තු හා ව්‍යවස්ථාපිත ආයතනවල වාර්ෂික වාර්තා සහ කාර්යසාධන වාර්තා පාර්ලිමේන්තුව වෙත ඉදිරිපත් කිරීම.</li><li class="pl-1">අල්ලස් හා දූෂණ විමර්ශන කොමිෂන් සභාවේ නියමය පරිදි අදාළ නිලධාරීන්ගේ වත්කම් හා බැරකම් ප්‍රකාශ එකතු කිරීම හා ඉදිරිපත් කිරීම.</li><li class="pl-1">අමාත්‍යාංශය සතු අමතර සංචාරක බංගලාව වෙන් කිරීම, නඩත්තු හා පරිපාලන කටයුතු සිදු කිරීම.</li><li class="pl-1">අමාත්‍යාංශය සහ අමාත්‍යාංශය යටතේ පවතින දෙපාර්තමේන්තු හා ව්‍යවස්ථාපිත ආයතන සතු ඉඩම් හා ගොඩනැගිලි සම්බන්ධ කටයුතු.</li><li class="pl-1">අමාත්‍යාංශය යටතේ පවතින ව්‍යවස්ථාපිත ආයතනවල අධ්‍යක්ෂ මණ්ඩල පත්කිරීම සම්බන්ධ කටයුතු.</li><li class="pl-1">ජූලි වර්ජිත ගෙවීම් සම්බන්ධ කටයුතු.</li></ul>',
  'ta' => '<p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">நிர்வாகப் பிரிவு நிர்வாகம், நிறுவனங்கள் மற்றும் சட்டம் என மூன்று துணைப் பிரிவுகளின் கீழ் செயல்படுகிறது. அமைச்சின் நிர்வாகம், மனிதவள மேலாண்மை, பொது பராமரிப்பு, பணியாளர் பயிற்சி மற்றும் அமைச்சின் கீழ் இயங்கும் நிறுவனங்களின் ஒருங்கிணைப்பு மற்றும் தொடர்புடைய பணிகள் நிர்வாக மற்றும் நிறுவனப் பிரிவுகளின் கீழ் மேற்கொள்ளப்படுகின்றன.</p><p class="mt-4">மேலும், புதிய போக்குகளுக்கு ஏற்ப தற்போதுள்ள தொழில் சட்டங்களைப் புதுப்பிக்க தேவையான நடவடிக்கைகளை எடுத்தல், அங்கீகரிக்கப்பட்ட சர்வதேச சமவாயங்களை செயல்படுத்துவதற்கும், பின்தொடர்வதற்கும் உதவும் புதிய சட்டங்கள் மற்றும் ஒழுங்குமுறைகளை அறிமுகப்படுத்துதல் மற்றும் செயல்படுத்துதல் போன்றவை சட்டப் பிரிவின் மூலம் மேற்கொள்ளப்படுகின்றன. கூடுதலாக, நிர்வாகப் பிரிவால் செய்யப்படும் செயல்பாடுகள் பின்வருமாறு.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">அமைச்சரவை விசேடாம்பங்களை தயாரித்தல் மற்றும் அமைச்சரவை முடிவுகள் மீதான நடவடிக்கை.</li><li class="pl-1">ஆலோசனைக் குழுக்கள், பொது மனு குழுக்கள் மூலம் செய்யப்படும் கணக்குமுடிப்புகளுக்கு பதில்களை வழங்குதல் மற்றும் பாராளுமன்ற கேள்விகளுக்கு பதில்களை வழங்குதல்.</li><li class="pl-1">அமைச்சு மற்றும் அமைச்சின் கீழுள்ள திணைக்களங்கள் மற்றும் நியதி சட்டப்பூர்வ அமைப்புகளின் ஆண்டு அறிக்கைகள் மற்றும் செயலாற்றுகை அறிக்கைகளை பாராளுமன்றத்தில் சமர்ப்பித்தல்.</li><li class="pl-1">இலஞ்சம் அல்லது ஊழல் பற்றிய சாத்தத்தங்களை புலனாய்வு செய்வதற்கான ஆணைக்குழுவின் உத்தரவின்படி தொடர்புடைய அதிகாரிகளின் சொத்துக்கள் மற்றும் பொறுப்புக்கள் பற்றிய அறிக்கைகளை சேகரித்து சமர்ப்பித்தல்.</li><li class="pl-1">அமைச்சுக்குச் சொந்தமான அம்பாறை சுற்றுலா பங்களாவின் முன்பதிவு, பராமரிப்பு மற்றும் நிர்வாக நடவடிக்கைகள்.</li><li class="pl-1">அமைச்சு மற்றும் அமைச்சின் கீழுள்ள திணைக்களங்கள் மற்றும் நியதி சட்டப்பூர்வ அமைப்புகளின் சொந்தமான நிலம் மற்றும் கட்டிடங்கள் தொடர்பான செயல்பாடுகள்.</li><li class="pl-1">அமைச்சின் கீழுள்ள நியதி சட்டப்பூர்வ அமைப்புகளின் பணிப்பாளர்களின் குழுவை நியமிப்பது தொடர்பான செயல்பாடுகள்.</li><li class="pl-1">ஜூலை வேலைநிறுத்தக் கொடுப்பனவுகள் தொடர்பான செயல்பாடுகள்.</li></ul>',
),
    'div_dev_title' => array (
  'en' => 'Policy Formulation & Foreign Relations Division',
  'si' => 'ප්‍රතිපත්ති සම්පාදන සහ විදේශ සබඳතා අංශය',
  'ta' => 'கொள்கை உருவாக்கம் மற்றும் வெளிநாட்டு உறவுகள் பிரிவு',
),
    'div_dev_content' => array (
  'en' => '<p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">This division comprises three principal sections: Development, Foreign Relations, and Legal. It is entrusted with the administration and coordination of all matters pertaining to these sections. As a member state of the International Labour Organization (ILO), Sri Lanka maintains active engagement with the organization. Guided by internationally recognized conventions and recommendations, the division is responsible for the formulation of policy decisions aimed at safeguarding labour rights within the country and addressing issues arising in the labour sector. The principal functions undertaken by this division are outlined below:</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">Submitting to the International Labour Organization, as required, reports on the progress made in implementing within Sri Lanka the conventions of the ILO that have been ratified by Sri Lanka.</li><li class="pl-1">Informing the international community, as necessary, of the progress achieved by Sri Lanka in relation to the labour sector.</li><li class="pl-1">Taking necessary measures to resolve issues prevailing in the labour sector by obtaining financial and technical assistance from the International Labour Organization.</li><li class="pl-1">Taking appropriate action to update existing labour laws, amend them in line with emerging trends, introduce new laws, implement them, and conduct follow-up reviews.</li><li class="pl-1">Entering into new memoranda of understanding/agreements with foreign counterparts relating to the labour sector, as well as updating and reviewing the effectiveness of existing agreements or understandings.</li><li class="pl-1">Engaging in regional and global dialogues and related activities with foreign stakeholders concerning labour matters, including participation in joint committee meetings.</li><li class="pl-1">Organizing special programmes conducted by the Ministry (such as mobile service programmes).</li><li class="pl-1">Acting as the principal stakeholder for care cooperative programmes implemented with the financial and technical assistance of the International Labour Organization.</li><li class="pl-1">Managing and following up on public complaints referred from the Presidential Secretariat, the Prime Minister’s Office, and the Hon. Minister, as well as those received directly by the Ministry.</li></ul>',
  'si' => '<p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">සංවර්ධන හා විදේශ සබඳතා ලෙස මෙම අංශය උප අංශ දෙකකින් සමන්විත වන අතර එම කොටස් වලට අදාළ සියලු කටයුතු මෙහෙයවීම හා සංවිධානය මෙම අංශය මඟින් සිදුකරනු ලබයි. ජාත්‍යන්තර කම්කරු සංවිධානය සමඟ එම සංවිධානයේ සාමාජික රටක් ලෙස ශ්‍රී ලංකාව විසින් ඇති කරගත් බැඳීම, අන්තර්ජාතික වශයෙන් පිළිගත් සම්මුතීන් හා නිර්දේශයන් යටතේ මෙරට කම්කරු අයිතීන් සුරක්ෂිත කිරීම සහ කම්කරු ක්ෂේත්‍රයේ ගැටළු විසඳීම සඳහා උපයෝගී කරගත හැකිවන සේ ප්‍රතිපත්තිමය තීරණ ගැනීම යනාදී සුවිශේෂී කාර්යයන් මෙම අංශය මඟින් ඉටු කරනු ලබයි. ඒ යටතේ සිදු කරනු ලබන ප්‍රධාන කාර්යයන් පහත පරිදි වේ.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">ශ්‍රී ලංකාව විසින් අපරානුමත කර ඇති ජාත්‍යන්තර කම්කරු සංවිධානයේ සම්මුතීන්, මෙරට තුළ ක්‍රියාත්මක කිරීම සම්බන්ධ ප්‍රගතිය, නියමිත පරිදි ජාත්‍යන්තර කම්කරු සංවිධානය වෙත ඉදිරිපත් කිරීම.</li><li class="pl-1">කම්කරු ක්ෂේත්‍රය සම්බන්ධයෙන් ශ්‍රී ලංකාව ලබා ඇති ප්‍රගතිය පිළිබඳව, උනන්දුකාරක ජාත්‍යන්තර ප්‍රජාව අවශ්‍ය පරිදි දැනුවත් කිරීම.</li><li class="pl-1">ජාත්‍යන්තර කම්කරු සංවිධානයේ මූල්‍ය හා තාක්ෂණික සහයෝගය ලබා ගනිමින් කම්කරු ක්ෂේත්‍රය සම්බන්ධව පවතින ගැටළු විසඳීම සඳහා අවශ්‍ය කටයුතු කිරීම.</li><li class="pl-1">කම්කරු ක්ෂේත්‍රයට අදාළව විදේශීය පාර්ශවකරුවන් සමඟ නව අවබෝධතා ගිවිසුම්/එකඟතාවලට එළඹීම සහ දැනටමත් පවතින අවබෝධතා ගිවිසුම්/එකඟතාවන් යාවත්කාලීන කිරීම හා ඒවායේ ක්‍රියාකාරීත්වය පිළිබඳව පසු විපරම් කිරීම.</li><li class="pl-1">කම්කරු ක්ෂේත්‍රයට අදාළව විදේශීය පාර්ශවකරුවන් සමඟ කලාපීය/ ගෝලීය සංවාද හා සම්බන්ධ කටයුතු සහ ඒකාබද්ධ කමිටු රැස්වීම්වලට අදාළ කටයුතු සිදු කිරීම.</li><li class="pl-1">අමාත්‍යාංශය මඟින් පවත්වනු ලබන විශේෂ වැඩසටහන් (ජංගම සේවා වැනි) සංවිධානය කිරීම.</li><li class="pl-1">ජාත්‍යන්තර කම්කරු සංවිධානයේ මූල්‍ය හා තාක්ෂණික සහයෝගය ලබා ගනිමින් සත්කාර සහයෝගිතා වැඩසටහන් (care cooperative) සඳහා ප්‍රධානතම පාර්ශවකරුවෙකු ලෙස කටයුතු කිරීම.</li><li class="pl-1">ජනාධිපති කාර්යාලය, අගමැති කාර්යාලය සහ අමාත්‍යතුමා වෙත යොමු කරන සහ අමාත්‍යාංශයට සෘජුව ලැබෙන මහජන පැමිණිලි මෙහෙයවීම හා පසුවිපරම් කිරීම.</li></ul>',
  'ta' => '<p class="text-gray-700 bg-blue-50/50 p-4 rounded-xl border border-blue-100">இந்தப் பிரிவு, அபிவிருத்தி மற்றும் வெளி உறவுகள் என இரண்டு துணைப் பிரிவுகளைக் கொண்டுள்ளது. இந்தப் பிரிவுகளுடன் தொடர்புடைய அனைத்து நடவடிக்கைகளையும் இந்தப் பிரிவு வழிநடத்தி ஒழுங்கமைக்கிறது. சர்வதேச தொழிலாளர் அமைப்பு அந்த அமைப்பின் உறுப்பு நாடாக இலங்கையுடன் ஏற்படுத்திய உறவு, சர்வதேச அளவில் அங்கீகரிக்கப்பட்ட சமவாயங்கள் மற்றும் பரிந்துரைகளின் கீழ் நாட்டில் தொழிலாளர் உரிமங்களைப் பாதுகாத்தல் மற்றும் தொழில் துறையில் உள்ள பிரச்சினைகளைத் தீர்க்கப் பயன்படுத்தக்கூடிய கொள்கை முடிவுகளை எடுத்தல் போன்ற சிறப்புப் பணிகளை இந்தப் பிரிவு செய்கிறது. இதன் கீழ் செய்யப்படும் முக்கிய செயற்பாடுகள் பின்வருமாறு.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">நாட்டில் இலங்கையால் அங்கீகரிக்கப்பட்ட சர்வதேச தொழிலாளர் அமைப்பின் சமவாயங்களை செயல்படுத்துவது தொடர்பான முன்னேற்றத்தை திட்டமிட்டபடி சர்வதேச தொழிலாளர் அமைப்புக்கு சமர்ப்பித்தல்.</li><li class="pl-1">தொழில் துறையில் இலங்கை அடைந்த முன்னேற்றம் குறித்து, தேவைப்பட்டால், ஆர்வமுள்ள சர்வதேச சமூகத்திற்குத் தெரிவித்தல்.</li><li class="pl-1">சர்வதேச தொழிலாளர் அமைப்பிலிருந்து நிதி மற்றும் தொழில்நுட்ப உதவியைப் பெறுவதன் மூலம் தொழில் துறையுடன் தொடர்புடைய தற்போதைய பிரச்சினைகளைத் தீர்க்க தேவையான நடவடிக்கைகளை எடுத்தல்.</li><li class="pl-1">தொழில் துறை தொடர்பான வெளிநாட்டு பங்குதாரர்களுடன் புதிய புரிந்துணர்வு ஒப்பந்தங்கள்/ உடன்படிக்கைகளைச் செய்து, ஏற்கனவே உள்ள புரிந்துணர்வு ஒப்பந்தங்கள்/உடன்படிக்கைகளை புதுப்பித்து, அவற்றை செயல்படுத்துவதைப் பின்னாய்வு.</li><li class="pl-1">தொழில் துறை தொடர்பான வெளிநாட்டு பங்குதாரர்களுடன் பிராந்திய/உலகளாவிய உரையாடல்கள் மற்றும் கூட்டுக் குழு கூட்டங்கள் தொடர்பான நடவடிக்கைகளை மேற்கொள்ளல்.</li><li class="pl-1">அமைச்சால் நடத்தப்படும் விசேட நிகழ்ச்சித் திட்டங்களை (நடமாடும் சேவைகள் போன்றவை) ஏற்பாடு செய்தல்.</li><li class="pl-1">சர்வதேச தொழிலாளர் அமைப்பிலிருந்து நிதி மற்றும் தொழில்நுட்ப ஆதரவைப் பெறுவதன் மூலம் பராமரிப்பு கூட்டுறவுத் திட்டங்களுக்கு (care cooperative) முக்கிய பங்குதாரராகச் செயல்படுதல்.</li><li class="pl-1">ஜனாதிபதி செயலகம், பிரதமர் அலுவலகம் மற்றும் அமைச்சருக்கு அனுப்பப்பட்டு, அமைச்சால் நேரடியாகப் பெறப்படும் பொது முறைப்பாடுகளை கையாளுதல் மற்றும் பின்னாய்வு.</li></ul>',
),
    'div_planning_title' => array (
  'en' => 'Planning and Monitoring Division',
  'si' => 'සැලසුම් හා මෙහෙයුම් අංශය',
  'ta' => 'திட்டமிடல் மற்றும் செயல்பாட்டுப் பிரிவு',
),
    'div_planning_content' => array (
  'en' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">Devising plans of the Ministry and all institutions under its purview required for navigating the development plans towards the set targets, and the implementation of them, progress review and follow up thereof are the key functions of this division. In addition, the division executes the following duties as well.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">Preparing, implementing, and reporting on strategic plans and annual action plans in alignment with the national policy framework.</li><li class="pl-1">Preparing the annual action plan, outlining the development goals of the Ministry and its affiliated institutions, and submitting it to the relevant stakeholders and making them implement the plan, at the same time, monitoring and encouraging the achievement of the targets through progress review and follow up thereof.</li><li class="pl-1">Coordinating with the Presidential Secretariat, Ministry of Finance, Department of Project Management and Monitoring and Department of National Planning in terms of National Budget Circular and submission of progress reports monthly and quarterly.</li><li class="pl-1">Identifying and submit project proposals for preparation of annual budget estimates.</li><li class="pl-1">Preparing the annual performance report detailing the progress achieved by the Ministry and submission of progress report for the committee stage debate of the budget.</li><li class="pl-1">Appraising development project proposals related to the curriculum and referring to the Department of National Planning as appropriate.</li><li class="pl-1">Contributing as relevant to action plans implemented by various Ministries.</li></ul>',
  'si' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">අමාත්‍යාංශය හා ඒ යටතේ වන සියලුම අනුබද්ධිත ආයතනවල සංවර්ධන වැඩසටහන් නිවැරදි ඉලක්ක ඔස්සේ ක්‍රියාත්මක කිරීමට අවශ්‍ය සැලසුම් සකස් කිරීම, ඒවා ක්‍රියාත්මක කර වීම, ප්‍රගති සමාලෝචනය හා පසුවිපරම මෙම අංශයේ ප්‍රධාන කාර්යයන් වන අතර පහත සඳහන් කාර්යයන් ද ඉටු කරනු ලබයි.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">ජාතික ප්‍රතිපත්ති රාමුව හා ගැලපෙන පරිදි උපක්‍රමශීලී සැලැස්ම සහ වාර්ෂික ක්‍රියාකාරී සැලසුම් සකස් කිරීම, ක්‍රියාත්මක කර වීම සහ ප්‍රගතිය වාර්තා කිරීම.</li><li class="pl-1">අමාත්‍යාංශය හා ඒ යටතේ ඇති ආයතන විසින් සිදු කරනු ලබන සංවර්ධන ඉලක්කයන් ඇතුළත් වාර්ෂික ක්‍රියාකාරී සැලැස්ම සකස් කර අදාළ පාර්ශව වෙත යොමු කිරීම, ක්‍රියාත්මක කරවීම සහ සෑම මසකම ප්‍රගතිය ඇගයීම මඟින් ඉලක්ක වෙත ළඟා වීම අධීක්ෂණය හා දිරි ගැන්වීම.</li><li class="pl-1">ජාතික අයවැය වක්‍රලේඛ අනුව ජනාධිපති ලේකම් කාර්යාලය, මුදල් අමාත්‍යාංශය, ව්‍යාපෘති කළමනාකරණ හා අධීක්ෂණ දෙපාර්තමේන්තුව හා ජාතික ක්‍රමසම්පාදන දෙපාර්තමේන්තුව සමඟ සම්බන්ධීකරණය පැවැත්වීම හා ප්‍රගති වාර්තා මාසිකව හා ත්‍රෛමාසිකව ඉදිරිපත් කිරීම.</li><li class="pl-1">වාර්ෂික අයවැය ඇස්තමේන්තු සකස් කිරීම සඳහා ව්‍යාපෘති යෝජනා හඳුනා ගැනීම හා ඉදිරිපත් කිරීම.</li><li class="pl-1">අමාත්‍යාංශය විසින් අත්කරගත් ප්‍රගතිය ඇතුළත් වාර්ෂික කාර්යසාධන වාර්තාව සහ අයවැය කාරක සභා විවාදය සඳහා ප්‍රගති වාර්තාව සකස් කොට පාර්ලිමේන්තුව වෙත ඉදිරිපත් කිරීම.</li><li class="pl-1">කම්කරු විෂයපථයට අදාළව සංවර්ධන ව්‍යාපෘති යෝජනා ඇගයීම සහ අදාළ පරිදි ජාතික ක්‍රමසම්පාදන දෙපාර්තමේන්තුව වෙත යොමු කිරීම.</li><li class="pl-1">විවිධ අමාත්‍යාංශ විසින් ක්‍රියාත්මක කරනු ලබන ක්‍රියාකාරී සැලසුම් සඳහා අදාළ පරිදි දායකත්වය සැපයීම.</li></ul>',
  'ta' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">அமைச்சு மற்றும் அதன் கீழுள்ள அனைத்து இணைக்கப்பட்ட நிறுவனங்களின் அபிவிருத்தி நிகழ்ச்சித் திட்டங்களை சரியான இலக்குகளின்படி செயல்படுத்த தேவையான திட்டங்களைத் தயாரித்தல், அவற்றை செயற்படுத்துதல், முன்னேற்றத்தை மீளாய்வு செய்தல் மற்றும் பின்னாய்வு செய்தல் ஆகியவை இந்தப் பிரிவின் முக்கிய செயற்பாடுகளாகும், மேலும் பின்வரும் செயற்பாடுகளும் செய்யப்படுகின்றன.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">தேசிய கொள்கை சட்டக் கட்டமைப்புிற்கு ஏற்ப மூலோபாயத் திட்டம் மற்றும் வருடாந்த செயல் திட்டங்களைத் தயாரித்தல், அவற்றை செயல்படுத்துதல் மற்றும் முன்னேற்றம் குறித்து அறிக்கையிடுதல்.</li><li class="pl-1">அமைச்சு மற்றும் அதன் கீழுள்ள நிறுவனங்களால் மேற்கொள்ளப்பட வேண்டிய அபிவிருத்தி இலக்குகளை உள்ளடக்கிய வருடாந்த செயல் திட்டத்தைத் தயாரித்து, அதை சம்பந்தப்பட்ட தரப்பினருக்கு அனுப்புதல், அதை செயல்படுத்துதல் மற்றும் ஒவ்வொரு மாதமும் முன்னேற்றத்தை மதிப்பிடுவதன் மூலம் இலக்குகளை அடைவதை கண்காணித்தல் மற்றும் ஊக்குவித்தல்.</li><li class="pl-1">தேசிய வரவுசெலவு சுற்றறிக்கைகளின்படி ஜனாதிபதி செயலகம், நிதி அமைச்சு, கருத்திட்ட முகாமைத்துவ மற்றும் கண்காணிப்புத் திணைக்களம் மற்றும் தேசிய திட்டமிடல் திணைக்களத்துடன் ஒருங்கிணைத்தல் மற்றும் மாதாந்த மற்றும் காலாண்டு முன்னேற்ற அறிக்கைகளை சமர்ப்பித்தல்.</li><li class="pl-1">வருடாந்த வரவுசெலவு மதிப்பீடுகளைத் தயாரிப்பதற்கான திட்ட முன்மொழிவுகளை அடையாளம் கண்டு சமர்ப்பித்தல்.</li><li class="pl-1">வரவுசெலவு குழு விவாதத்திற்கான அமைச்சால் அடையப்பட்ட முன்னேற்றம் மற்றும் முன்னேற்ற அறிக்கை உள்ளிட்ட வருடாந்த செயலாற்ற அறிக்கையைத் தயாரித்து பாராளுமன்றத்தில் சமர்ப்பித்தல்.</li><li class="pl-1">தொழில் விடயப்பரப்புக்கு தொடர்புடைய அபிவிருத்தித் திட்ட முன்மொழிவுகளை மதிப்பீடு செய்து, பொருத்தமான முறையில் தேசிய திட்டமிடல் திணைக்களத்துக்கு அனுப்புதல்.</li><li class="pl-1">பல்வேறு அமைச்சுகளால் செயல்படுத்தப்படும் செயல் திட்டங்களுக்கு பொருத்தமான பங்களிப்புகளை வழங்குதல்.</li></ul>',
),
    'div_finance_title' => array (
  'en' => 'Finance Division',
  'si' => 'මූල්‍ය අංශය',
  'ta' => 'நிதிப் பிரிவு',
),
    'div_finance_content' => array (
  'en' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">The core responsibility of the Accounts Division is to take necessary measures for efficient, effective and economical administration of financial resources allocated from the annual budget to the Ministry in compliance with state policies.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">Conducting Annual Board of Survey as per Public Finance Circular 01/2020.</li><li class="pl-1">Preparation of reports related to the agency of the financial authority and carrying out the work of delegation of financial powers.</li><li class="pl-1">Preparation of Annual Budget Estimate.</li><li class="pl-1">Preparation of Annual Financial Statement.</li><li class="pl-1">Preparation of Committee Report on Public Accounts.</li><li class="pl-1">Submission of monthly and quarterly financial reports to the General Treasury and other relevant institutions.</li><li class="pl-1">Updating and maintaining the audit query documents and forwarding the answers to the relevant audit queries to the Auditor General.</li></ul>',
  'si' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">වාර්ෂික අයවැය මඟින් අමාත්‍යාංශයට වෙන් කරන ලද මූල්‍ය ප්‍රතිපාදන රජයේ ප්‍රතිපත්තිවලට අනුකූලව අදාළ අරමුණු ඉටුකර ගැනීම සඳහා කාර්යක්ෂමව හා ඵලදායී ලෙස භාවිත කිරීමට අවශ්‍ය කටයුතු කිරීම ගිණුම් අංශයේ ප්‍රධාන වගකීම වේ.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">අදාළ වක්‍රලේඛ ප්‍රකාරව වාර්ෂික භාණ්ඩ සමීක්ෂණය පැවැත්වීම.</li><li class="pl-1">මූල්‍ය අධිකාරියේ නියෝජිතායතනය සම්බන්ධ වාර්තා සකස් කිරීම සහ මූල්‍ය බලතල පැවරීමේ කටයුතු සිදු කිරීම.</li><li class="pl-1">වාර්ෂික අයවැය ඇස්තමේන්තු සකස් කිරීම.</li><li class="pl-1">වර්ෂය සඳහා මූල්‍ය ප්‍රකාශනය සකස් කිරීම.</li><li class="pl-1">රජයේ ගිණුම් පිළිබඳ කාරක සභා වාර්තාව සකස් කිරීම.</li><li class="pl-1">මහා භාණ්ඩාගාරයට හා අදාළ අනෙකුත් ආයතනවලට මාසිකව හා කාර්තුමය වශයෙන් මූල්‍ය වාර්තා ඉදිරිපත් කිරීම.</li><li class="pl-1">විගණන විමසුම් ලේඛන යාවත්කාලීන කර පවත්වා ගෙන යාම හා අදාළ විගණන විමසුම් සඳහා පිළිතුරු විගණකාධිපති වෙත යොමු කිරීම.</li></ul>',
  'ta' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">வருடாந்த வரவு செலவுத்திட்டத்தின் மூலம் அமைச்சுக்கு ஒதுக்கப்பட்ட நிதி ஒதுக்கீடுகள் அரசாங்கக் கொள்கைகளுக்கு ஏற்ப வினைத்திறனாகவும் விளைதிறனாகவும் பயன்படுத்தப்படுவதை உறுதி செய்வதே நிதிப் பிரிவின் முக்கிய பொறுப்பாகும்.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">தொடர்புடைய சுற்றறிக்கைகளின்படி வருடாந்த பொருட் கணக்கெடுப்பை நடத்துதல்.</li><li class="pl-1">நிதி அதிகாரசபையின் நிறுவனம் தொடர்பான அறிக்கைகளைத் தயாரித்தல் மற்றும் நிதி அதிகாரங்களை வழங்குவதற்கான நடவடிக்கைகளை மேற்கொள்வது.</li><li class="pl-1">வருடாந்த வரவு செலவுத்திட்டத்தின் மதிப்பீடுகளைத் தயாரித்தல்.</li><li class="pl-1">ஆண்டிற்கான நிதி அறிக்கையைத் தயாரித்தல்.</li><li class="pl-1">அரசாங்கக் கணக்குகள் குறித்த குழு அறிக்கையைத் தயாரித்தல்.</li><li class="pl-1">திறைசேரி மற்றும் பிற தொடர்புடைய நிறுவனங்களுக்கு மாதாந்த மற்றும் காலாண்டு நிதி அறிக்கைகளைச் சமர்ப்பித்தல்.</li><li class="pl-1">கணக்காய்வு விசாரணைக் கோப்புகளை இற்றைப்படுத்துதல் மற்றும் பராமரித்தல் மற்றும் தொடர்புடைய கணக்காய்வு வினவல் விசாரணைகளுக்கான பதில்களை கணக்காய்வாளர் தலைமை அதிபதிக்கு அனுப்புதல்.</li></ul>',
),
    'div_audit_title' => array (
  'en' => 'Internal Audit Division',
  'si' => 'අභ්‍යන්තර විගණන අංශය',
  'ta' => 'உள்ளக கணக்காய்வு பிரிவு',
),
    'div_audit_content' => array (
  'en' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">The internal audit activities of the Ministry are carried out in terms of as per the appointments made in terms of Section 40 of the National Audit Act to ensure that the responsibility of the Chief Accounting Officer is carried out as set out in Section 38(b) and (f) of the said Act and requirements of Circular No. 01/2019 dated 12/01/2019 of the Department of Management Audit and the powers vested in the Internal Audit Division in terms of FR 133 and FR 134.</p><p class="mt-4">The responsibility conducting the relevant internal audit activities of the Ministry of Labour and Departments and Institutions under it and carrying out special investigations as per the requirement also fall under the scope of internal audit.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">Assessing the effectiveness of the internal audit and control system within the organization.</li><li class="pl-1">Examining whether the institutions comply with the Establishment Code of the Government, the Finance Regulations of the Government, and the Finance Regulations and circulars, as well as other supplementary instructions periodically issued by the Ministry of Public Administration and the General Treasury.</li><li class="pl-1">Efficient management of internal audit activities in alignment with the mission and objectives of the Ministry of Labour, its departments, and other affiliated institutions, adhering to audit principles and systems.</li><li class="pl-1">Assessing the control systems established to ensure adherence to policies, plans, procedures, laws, and regulations that may significantly impact the activities of the Ministry.</li><li class="pl-1">Evaluating and verifying the measures taken to protect assets and verify the existence of assets.</li><li class="pl-1">Evaluation of activities or programs and verification of information to ascertain whether physical and financial progress has been achieved in accordance with the established objectives of the Ministry.</li><li class="pl-1">Provide guidance to establish appropriate internal control processes and risk management processes for each division of the organization.</li><li class="pl-1">Communicating findings post-audit and submitting necessary corrections thereafter.</li><li class="pl-1">Preparation and implementation of annual audit plan.</li><li class="pl-1">Making necessary arrangements for the submission of reports to the Department of Management Audit by the due date.</li><li class="pl-1">Convening the Audit and Management Committee meeting and conducting the necessary activities.</li><li class="pl-1">Performing and reporting on specific duties as assigned by management from time to time.</li></ul>',
  'si' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">රාජ්‍ය මුදල් නියෝග අංක 38 (අ) හා (ඊ) හි දක්වා ඇති පරිදි ප්‍රධාන ගණන්දීමේ නිලධාරීගේ වගකීම ඉටු වන බවට සහතික කිරීම සඳහා එම නියෝග 40 වන වගන්තිය ප්‍රකාරව බලගන්වා ඇති සහ මු.රෙ. 133 හා 134 ප්‍රකාරව අභ්‍යන්තර විගණන අංශයට ලබා දී ඇති බලතල හා කළමනාකරණ විගණන දෙපාර්තමේන්තුවේ අංක 01/2019 හා 2019/01/12 දිනැති චක්‍රලේඛයේ නියමයන් පරිදි අමාත්‍යාංශයේ අභ්‍යන්තර විගණන කටයුතු සිදු වේ.</p><p class="mt-4">කම්කරු අමාත්‍යාංශය හා ඒ යටතේ පවතින දෙපාර්තමේන්තු හා ආයතනවල අභ්‍යන්තර විගණන කටයුතු සිදු කිරීමේ වගකීම හා අධිකාරිය අනුව විශේෂ පරීක්ෂණ ද අභ්‍යන්තර විගණන අංශයේ විෂය පථයට ඇතුළත් වේ.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">ආයතනයන් තුළ ක්‍රියාත්මක වන අභ්‍යන්තර යොදවුම් හා පාලන පද්ධතියේ ක්‍රියාකාරීත්වයේ සාර්ථකත්වය සොයා බැලීම.</li><li class="pl-1">ආයතනයන් විසින් රජයේ ආයතන සංග්‍රහය, රජයේ මුදල් රෙගුලාසි සහ රජයේ පරිපාලන විෂයභාර අමාත්‍යාංශය සහ මහා භාණ්ඩාගාරය විසින් වරින්වර නිකුත් කරන ලද සහ නිකුත් කරනු ලබන චක්‍රලේඛ හා වෙනත් පරිපූර්ණ උපදෙස් පිළිපදිනු ලබන්නේ ද යන්න සොයා බැලීම.</li><li class="pl-1">කම්කරු අමාත්‍යාංශය සහ අමාත්‍යාංශය යටතට අයත් වන දෙපාර්තමේන්තු හා අනෙකුත් ආයතනවල ගිණුම්කරණ හා මූල්‍යමය, විගණන ප්‍රමිතීන් පද්ධතියට අනුකූලව අභ්‍යන්තර විගණන කටයුතු ඵලදායී ලෙස කළමනාකරණය කිරීම.</li><li class="pl-1">අමාත්‍යාංශයේ ක්‍රියාකාරීත්වය සැලකිය යුතු ලෙස බලපෑම් ඇති කළ හැකි ප්‍රධානතම, සැලසුම්, ක්‍රියාපටිපාටි, නීති හා රෙගුලාසිවලට අනුකූල වීම සම්බන්ධව සහතික කිරීම සඳහා ස්ථාපිත කර ඇති පාලන පද්ධති ඇගයීමට ලක් කිරීම.</li><li class="pl-1">වත්කම් ආරක්ෂා කිරීම හා වත්කම්වල පැවැත්ම තහවුරු කිරීම සඳහා ගෙන ඇති ක්‍රියාමාර්ග ඇගයීම හා පරීක්ෂණය කිරීම.</li><li class="pl-1">භෞතික හා මූල්‍ය ප්‍රගතිය අමාත්‍යාංශයේ වාර්ෂික අරමුණුවලට අනුකූලව ලබාගෙන ඇත්දැයි සොයා බැලීම සඳහා වන ක්‍රියාකාරීකම් හෝ වැඩසටහන් ඇගයීමට ලක් කිරීම සහ තොරතුරු පරිශීලනය.</li><li class="pl-1">ආයතනයේ එක් එක් අංශ සඳහා සුදුසු අභ්‍යන්තර පාලන ක්‍රමවේදයන් සහ අනුමත කළමනාකරණ ක්‍රමවේදයන් ඇති කිරීමට අවශ්‍ය වන යෝජනා ලබා දීම.</li><li class="pl-1">විගණන ක්‍රියාවලියෙන් අනතුරුව සන්නිවේදනය කිරීම හා අවශ්‍ය නිවැරදි කිරීමේ ක්‍රියාවලියෙන් අනතුරුව ඉදිරිපත් කිරීම.</li><li class="pl-1">වාර්ෂික විගණන සැලැස්ම සකස් කිරීම හා ක්‍රියාත්මක කිරීම.</li><li class="pl-1">කළමනාකරණ විගණන දෙපාර්තමේන්තුවට යැවිය යුතු වාර්තා නියමිත දිනට ඉදිරිපත් කිරීම සඳහා අවශ්‍ය කටයුතු කිරීම.</li><li class="pl-1">විගණන හා කළමනාකරණ කමිටු රැස්වීම කැඳවීම සහ පැවැත්වීමට අවශ්‍ය කටයුතු සිදු කිරීම.</li><li class="pl-1">පාලනාධිකාරිය විසින් අවස්ථානුකූලව පවරනු ලබන විශේෂිත රාජකාරි ඉටුකිරීම සහ වාර්තා කිරීම.</li></ul>',
  'ta' => '<p class="text-gray-700 bg-gray-50/80 p-4 rounded-xl border border-gray-100">தேசிய கணக்காய்வுச் சட்டத்தின் 38(அ) மற்றும் (எ) பிரிவில் தரப்பட்டுள்ளாறு பிரதம கணக்கீட்டு அலுவலரின் பொறுப்பு ஆற்றப்படுகின்றது என்பதை உறுதிப்படுத்துவதற்கு அச்சட்டத்தின் 40 ஆம் பிரிவின்படி மேற்கொள்ளப்பட்டுள்ள நியமனங்கள் மற்றும் நிதி ஒழுங்குவிதி 133 மற்றும் 144 இன் படி உள்ளக கணக்காய்வுப் பிரிவுக்கு உரித்தளிக்கப்பட்டுள்ள தத்துவங்கள் மற்றும் கணக்காய்வு முகாமைத்துவ திணைக்களத்தின் 2019.01.12 ஆம் திகதியிடப்பட்ட 01/2019 ஆம் இலக்க சுற்றறிக்கையின் தேவைப்பாடுகளின் படி அமைச்சின் உள்ளக கணக்காய்வுச் செயற்பாடுகள் ஆற்றப்படுகின்றன.</p><p class="mt-4">தொழில் அமைச்சு மற்றும் அதன் கீழுள்ள திணைக்களங்கள் மற்றும் நிறுவனங்களின் உள்ளக கணக்காய்வு நடவடிக்கைகளை மேற்கொள்வதற்கான பொறுப்பு மற்றும் அவசியத்தின் படி, விசேட விசாரணைகள் உள்ளக கணக்காய்வு பிரிவின் எல்லைக்குள் உள்ளன.</p><ul class="space-y-3 marker:text-secondary list-outside list-disc pl-5 mt-4"><li class="pl-1">நிறுவனங்களுக்குள் செயல்படுத்தப்படும் உள்ளக கணக்காய்வு மற்றும் கட்டுப்பாட்டு அமைப்பின் செயல்திறனை ஆய்வு செய்தல்.</li><li class="pl-1">நிறுவனங்கள் அரச நிறுவன தாபன கோவை, அரச நிதி பிரமாண விதிமுறைகள் மற்றும் பொது நிர்வாகம் மற்றும் திறைசேரிக்கு பொறுப்பான அமைச்சினால் அவ்வப்போது தயாரிக்கப்பட்டு வெளியிடப்படும் சுற்றறிக்கைகள் மற்றும் பிற துணை அறிவுறுத்தல்களுக்கு இணங்க வேண்டும் என்பதோடு தொழில் அமைச்சு மற்றும் அமைச்சின் கீழுள்ள திணைக்களங்கள் மற்றும் பிற நிறுவனங்கள் பின்பற்றப்படுகின்றனவா என்பதை தேடிப்பார்த்தல்.</li><li class="pl-1">தொழில் அமைச்சு மற்றும் அமைச்சின் கீழுள்ள திணைக்களங்கள் மற்றும் பிற நிறுவனங்களின் கணக்கியல் மற்றும் நிதி, கணக்காய்வு தரநிலைகள் அமைப்புக்கு இணங்க உள்ளக கணக்காய்வு நடவடிக்கைகளை திறம்பட நிர்வகித்தல்.</li><li class="pl-1">அமைச்சின் செயல்பாடுகளில் குறிப்பிடத்தக்க தாக்கத்தை ஏற்படுத்தக்கூடிய முக்கிய திட்டங்கள், நடைமுறைகள், சட்டங்கள் மற்றும் விதிமுறைகளுக்கு இணங்குவதை உறுதிசெய்ய நிறுவப்பட்ட கட்டுப்பாட்டு அமைப்புகளை மதிப்பீடு செய்தல்.</li><li class="pl-1">சொத்துக்களைப் பாதுகாப்பதற்கும் சொத்துக்கள் இருப்பதை உறுதி செய்வதற்கும் எடுக்கப்பட்ட நடவடிக்கைகளை மதிப்பீடு செய்து சரிபார்த்தல்.</li><li class="pl-1">அமைச்சின் நிர்ணயிக்கப்பட்ட குறிக்கோள்களுக்கு ஏற்ப பௌதிக மற்றும் நிதி முன்னேற்றம் அடைந்துள்ளதா என்பதை கண்டறிய செயல்பாடுகள் அல்லது திட்டங்களை மதிப்பீடு செய்தல் மற்றும் தகவல்களைச் சரிபார்த்தல்.</li><li class="pl-1">நிறுவனத்தின் ஒவ்வொரு பிரிவிற்கும் பொருத்தமான உள்ளக கட்டுப்பாட்டு செயல்முறைகள் மற்றும் இடர் முகாமைத்துவ செயல்முறைகளை நிறுவ வழிகாட்டுதலை வழங்குதல்.</li><li class="pl-1">கணக்காய்வுக்குப் பிந்தைய கண்டுபிடிப்புகளைத் தெரிவித்தல் மற்றும் தேவையான திருத்தங்களைச் சமர்ப்பித்தல்.</li><li class="pl-1">வருடாந்த கணக்காய்வுத் திட்டத்தைத் தயாரித்தல் மற்றும் செயல்படுத்துதல்.</li><li class="pl-1">நிர்ணயிக்கப்பட்ட தேதிக்குள் கணக்காய்வு முகாமைத்துவ திணைக்களத்திற்கு அறிக்கைகளை சமர்ப்பிப்பதற்கு தேவையான ஏற்பாடுகளை செய்தல்.</li><li class="pl-1">கணக்காய்வு மற்றும் முகாமைத்துவக் குழுக் கூட்டத்தைக் கூட்டி தேவையான நடவடிக்கைகளை மேற்கொள்வது.</li><li class="pl-1">நிர்வாகத்தால் அவ்வப்போது ஒதுக்கப்படும் குறிப்பிட்ட கடமைகளை ஆற்றுதல் மற்றும் அறிக்கையிடுதல்.</li></ul>',
    ),
    'msg_sent_success' => array(
        'en' => 'Message sent successfully!',
        'si' => 'පණිවුඩය සාර්ථකව යවන ලදී!',
        'ta' => 'செய்தி வெற்றிகரமாக அனுப்பப்பட்டது!'
    ),
    'msg_send_failed' => array(
        'en' => 'Failed to send message.',
        'si' => 'පණිවුඩය යැවීමට නොහැකි විය.',
        'ta' => 'செய்தியை அனுப்ப முடியவில்லை.'
    ),
    'msg_error_occurred' => array(
        'en' => 'An error occurred. Please try again later.',
        'si' => 'දෝෂයක් සිදු විය. පසුව නැවත උත්සාහ කරන්න.',
        'ta' => 'ஒரு பிழை ஏற்பட்டது. பின்னர் மீண்டும் முயற்சிக்கவும்.'
    ),
    'view_all' => array(
        'en' => 'View All',
        'si' => 'සියල්ල නරඹන්න',
        'ta' => 'அனைத்தையும் பார்க்க'
    ),
    'no_news_found' => array(
        'en' => 'No news found.',
        'si' => 'කිසිදු පුවතක් හමු නොවීය.',
        'ta' => 'செய்திகள் எதுவும் கிடைக்கவில்லை.'
    ),
    'search_news' => array(
        'en' => 'Search news...',
        'si' => 'පුවත් සොයන්න...',
        'ta' => 'செய்திகளைத் தேடுங்கள்...'
    ),
    'per_page_label' => array(
        'en' => 'per page',
        'si' => 'පිටුවකට',
        'ta' => 'பக்கத்திற்கு'
    ),
    'show_all' => array(
        'en' => 'Show All',
        'si' => 'සියල්ල පෙන්වන්න',
        'ta' => 'அனைத்தையும் காட்டு'
    ),
    'items_per_page' => array(
        'en' => 'Items per page',
        'si' => 'පිටුවකට අයිතම',
        'ta' => 'பக்கத்திற்கு உருப்படிகள்'
    ),
    'reservation_details' => array(
        'en' => 'Reservation Details',
        'si' => 'වෙන්කිරීමේ තොරතුරු',
        'ta' => 'முன்பதிவு விபரங்கள்'
    ),
    'booking_request_subtitle' => array(
        'en' => 'Request booking for Ampara Bungalow',
        'si' => 'අම්පාර සංචාරක බංගලාව සඳහා වෙන්කිරීමක් ඉල්ලුම් කරන්න',
        'ta' => 'அம்பாறை பங்களாவிற்கான முன்பதிவு கோரிக்கை'
    ),
    'check_in' => array(
        'en' => 'Check-In',
        'si' => 'පැමිණෙන දිනය',
        'ta' => 'வருகை திகதி'
    ),
    'check_out' => array(
        'en' => 'Check-Out',
        'si' => 'පිටවන දිනය',
        'ta' => 'வெளியேறும் திகதி'
    ),
    'room_required' => array(
        'en' => 'Room Required',
        'si' => 'අවශ්‍ය කාමරය',
        'ta' => 'தேவையான அறை'
    ),
    'applicant_name' => array(
        'en' => 'Applicant Name',
        'si' => 'ඉල්ලුම්කරුගේ නම',
        'ta' => 'விண்ணப்பதாரரின் பெயர்'
    ),
    'cancel' => array(
        'en' => 'Cancel',
        'si' => 'අවලංගු කරන්න',
        'ta' => 'ரத்துசெய்'
    ),
    'submit_booking_request' => array(
        'en' => 'Submit Booking Request',
        'si' => 'වෙන්කිරීමේ ඉල්ලීම යොමු කරන්න',
        'ta' => 'முன்பதிவு கோரிக்கையை சமர்ப்பிக்கவும்'
    ),
    'phone' => array(
        'en' => 'Telephone',
        'si' => 'දුරකථන අංකය',
        'ta' => 'தொலைபேசி'
    ),
    'email' => array(
        'en' => 'Email',
        'si' => 'විද්‍යුත් තැපෑල',
        'ta' => 'மின்னஞ்சல்'
    ),
    'get_in_touch' => array(
        'en' => 'Get In Touch',
        'si' => 'අපව සම්බන්ධ කරගන්න',
        'ta' => 'எங்களை தொடர்பு கொள்ளுங்கள்'
    ),
    'contact_subtitle' => array(
        'en' => 'Stay updated with Ministry of Labour',
        'si' => 'කම්කරු අමාත්‍යාංශය සමඟ සම්බන්ද වන්න',
        'ta' => 'தொழிலாளர் அமைச்சுடன் புதுப்பிக்கப்பட்டிருங்கள்'
    ),
    'address' => array(
        'en' => 'Address',
        'si' => 'ලිපිනය',
        'ta' => 'முகவரி'
    ),
    'phone_number' => array(
        'en' => 'Phone number',
        'si' => 'දුරකථන අංකය',
        'ta' => 'தொலைபேசி எண்'
    ),
    'fax' => array(
        'en' => 'Fax',
        'si' => 'ෆැක්ස්',
        'ta' => 'தொலைநகல்'
    ),
    'email_address' => array(
        'en' => 'Email Address',
        'si' => 'විද්‍යුත් තැපැල් ලිපිනය',
        'ta' => 'மின்னஞ்சல் முகவரி'
    ),
    'full_name' => array(
        'en' => 'Full Name',
        'si' => 'සම්පූර්ණ නම',
        'ta' => 'முழு பெயர்'
    ),
    'message' => array(
        'en' => 'Message',
        'si' => 'පණිවිඩය',
        'ta' => 'செய்தி'
    ),
    'send_message' => array(
        'en' => 'Send Message',
        'si' => 'පණිවිඩය යවන්න',
        'ta' => 'செய்தி அனுப்புக'
    ),
    'leave_a_message' => array(
        'en' => 'Leave Us A Message',
        'si' => 'අපට පණිවිඩයක් තොරන්න',
        'ta' => 'எங்களுக்கு ஒரு செய்தி விடுங்கள்'
    ),
    'contact_numbers' => array(
        'en' => 'Contact Numbers',
        'si' => 'සම්බන්ධ කිරීමේ අංක',
        'ta' => 'தொடர்பு இலக்கங்கள்'
    ),
    'submit_complaint' => array(
        'en' => 'Submit Complaint',
        'si' => 'පැමිණිල්ල ඉදිරිපත් කරන්න',
        'ta' => 'புகார் சமர்ப்பிக்கவும்'
    ),
    'lodge_complaint' => array(
        'en' => 'Lodge a Formal Complaint',
        'si' => 'නිල පැමිණිල්ලක් ඉදිරිපත් කරන්න',
        'ta' => 'முறையான புகாரை பதிவு செய்யுங்கள்'
    ),
    'how_can_we_help' => array(
        'en' => 'How can we help you?',
        'si' => 'අපට ඔබව කෙසේ උදව් කළ හැකිද?',
        'ta' => 'நாங்கள் உங்களுக்கு எவ்வாறு உதவலாம்?'
    ),
    'ph_full_name' => array(
        'en' => 'John Doe',
        'si' => 'කමල් පෙරේරා',
        'ta' => 'கமல் பெரேரா'
    ),
    'ph_email' => array(
        'en' => 'your@email.com',
        'si' => 'ඔබේ@ඊමේල්.com',
        'ta' => 'உங்கள்@மின்னஞ்சல்.com'
    ),
    'ph_phone' => array(
        'en' => '+94 77 123 4567',
        'si' => '+94 77 123 4567',
        'ta' => '+94 77 123 4567'
    ),

    // ── Downloads Page ────────────────────────────────────────────────────────
    'search_docs_placeholder' => array(
        'en' => 'Search documents by title or reference...',
        'si' => 'මාතෘකාව හෝ යොමු අංකය අනුව ලේඛන සොයන්න...',
        'ta' => 'தலைப்பு அல்லது குறிப்பு எண் மூலம் ஆவணங்களைத் தேடுங்கள்...'
    ),
    'all_categories' => array(
        'en' => 'All Categories',
        'si' => 'සියලු ප්‍රවර්ග',
        'ta' => 'அனைத்து வகைகள்'
    ),
    'acts_amendments_filter' => array(
        'en' => 'Acts & Amendments',
        'si' => 'පනත් සහ සංශෝධන',
        'ta' => 'சட்டங்கள் மற்றும் திருத்தங்கள்'
    ),
    'all_procurements' => array(
        'en' => 'All Procurements',
        'si' => 'සියලු ප්‍රසම්පාදන',
        'ta' => 'அனைத்து கொள்முதல்கள்'
    ),
    'english_pdf' => array(
        'en' => 'English PDF',
        'si' => 'ඉංග්‍රීසි PDF',
        'ta' => 'ஆங்கில PDF'
    ),
    'sinhala_pdf' => array(
        'en' => 'Sinhala PDF',
        'si' => 'සිංහල PDF',
        'ta' => 'சிங்கள PDF'
    ),
    'tamil_pdf' => array(
        'en' => 'Tamil PDF',
        'si' => 'දමිළ PDF',
        'ta' => 'தமிழ் PDF'
    ),
    'doc_title_col' => array(
        'en' => 'Document Title',
        'si' => 'ලේඛනයේ මාතෘකාව',
        'ta' => 'ஆவண தலைப்பு'
    ),
    'category_col' => array(
        'en' => 'Category',
        'si' => 'ප්‍රවර්ගය',
        'ta' => 'வகை'
    ),
    'reference_col' => array(
        'en' => 'Reference',
        'si' => 'යොමු',
        'ta' => 'குறிப்பு'
    ),
    'action_col' => array(
        'en' => 'Action',
        'si' => 'ක්‍රියාව',
        'ta' => 'செயல்'
    ),
    'download_document' => array(
        'en' => 'Download Document',
        'si' => 'ලේඛනය බාගන්න',
        'ta' => 'ஆவணத்தை பதிவிறக்குக'
    ),
    'no_document' => array(
        'en' => 'No Document',
        'si' => 'ලේඛනයක් නැත',
        'ta' => 'ஆவணம் இல்லை'
    ),
    'download' => array(
        'en' => 'Download',
        'si' => 'බාගන්න',
        'ta' => 'பதிவிறக்குக'
    ),
    'no_docs_found' => array(
        'en' => 'No documents matched your search',
        'si' => 'ඔබගේ සෙවීමට ගැලපෙන ලේඛන හමු නොවිණ',
        'ta' => 'உங்கள் தேடலுக்கு பொருந்தும் ஆவணங்கள் இல்லை'
    ),
    'no_docs_found_sub' => array(
        'en' => 'Try adjusting your filters or search keywords',
        'si' => 'ඔබගේ පෙරහන් හෝ සෙවීමේ යතුරු වචන සකස් කිරීමට උත්සාහ කරන්න',
        'ta' => 'உங்கள் வடிப்பான்கள் அல்லது தேடல் சொற்களை சரிசெய்யுங்கள்'
    ),
    'showing_label' => array(
        'en' => 'Showing',
        'si' => 'පෙන්වනු ලබන්නේ',
        'ta' => 'காட்டப்படுகிறது'
    ),
    'of_label' => array(
        'en' => 'of',
        'si' => 'සිට',
        'ta' => 'இல்'
    ),
    'documents_label' => array(
        'en' => 'documents',
        'si' => 'ලේඛන',
        'ta' => 'ஆவணங்கள்'
    ),

    // ── Ampara Circuit Bungalow Page ─────────────────────────────────────────
    'click_fullscreen' => array(
        'en' => 'Click to view fullscreen',
        'si' => 'සම්පූර්ණ තිරයෙන් බලන්න',
        'ta' => 'முழுத்திரையில் பார்க்க கிளிக் செய்யுங்கள்'
    ),
    'more_photos' => array(
        'en' => 'More',
        'si' => 'තවත්',
        'ta' => 'மேலும்'
    ),
    'starting_from' => array(
        'en' => 'Starting From',
        'si' => 'ආරම්භ මිල',
        'ta' => 'தொடங்கும் விலை'
    ),
    'per_night' => array(
        'en' => '/ night',
        'si' => '/ රාත්‍රිය',
        'ta' => '/ இரவு'
    ),
    'check_avail_book' => array(
        'en' => 'Check Availability & Book',
        'si' => 'ඉඩ ලබා ගත හැකිද බලා වෙන් කරන්න',
        'ta' => 'கிடைக்கும் தன்மையை சரிபார்த்து முன்பதிவு செய்யுங்கள்'
    ),
    'booking_dates_note' => array(
        'en' => 'Select your dates and check room availability to submit a reservation request. Offline payments apply post-approval.',
        'si' => 'ඔබගේ දිනයන් තෝරා කාමර ලබා ගත හැකිද බලා, වෙන් කිරීමේ ඉල්ලීමක් ඉදිරිපත් කරන්න. ගෙවීම් අනුමත කිරීමෙන් පසු ලබා ගනු ලැබේ.',
        'ta' => 'உங்கள் தேதிகளைத் தேர்ந்தெடுத்து அறை கிடைக்கும் தன்மையை சரிபார்த்து முன்பதிவு கோரிக்கையை சமர்ப்பிக்கவும். அனுமதிக்கப்பட்ட பிறகு கட்டணம் வழங்கப்படும்.'
    ),
    'booking_success_msg' => array(
        'en' => 'Your booking request has been submitted successfully and is pending approval.',
        'si' => 'ඔබගේ වෙන් කිරීමේ ඉල්ලීම සාර්ථකව ඉදිරිපත් කර ඇති අතර අනුමැතිය ලැබීම බලාපොරොත්තු වෙනු ලැබේ.',
        'ta' => 'உங்கள் முன்பதிவு கோரிக்கை வெற்றிகரமாக சமர்ப்பிக்கப்பட்டது மற்றும் அனுமதிக்காக காத்திருக்கிறது.'
    ),
    'view_on_google_maps' => array(
        'en' => 'View Location on Google Maps',
        'si' => 'Google Maps හි ස්ථානය බලන්න',
        'ta' => 'Google Maps இல் இடத்தை பார்க்கவும்'
    ),
    'amenities_facilities' => array(
        'en' => 'Amenities & Facilities',
        'si' => 'පහසුකම් සහ ආරාධනා',
        'ta' => 'வசதிகள் மற்றும் உபகரணங்கள்'
    ),
    'air_conditioning' => array(
        'en' => 'Air Conditioning',
        'si' => 'වායු සමනය',
        'ta' => 'குளிரூட்டல்'
    ),
    'vehicle_parking' => array(
        'en' => 'Vehicle Parking',
        'si' => 'වාහන නිර්ත්‍රාශනය',
        'ta' => 'வாகன நிறுத்துமிடம்'
    ),
    'hot_water' => array(
        'en' => 'Hot Water',
        'si' => 'උණු වතුර',
        'ta' => 'சூடான நீர்'
    ),
    'kitchen_dining' => array(
        'en' => 'Kitchen & Dining',
        'si' => 'මෙවලම් සහ ආහාර ගැනීම',
        'ta' => 'சமையலறை மற்றும் உணவு'
    ),
    'accommodation_rates' => array(
        'en' => 'Accommodation & Room Rates',
        'si' => 'නවාතැන් සහ කාමර ගාස්තු',
        'ta' => 'தங்குமிட மற்றும் அறை கட்டணங்கள்'
    ),
    'ministry_staff' => array(
        'en' => 'Ministry Staff',
        'si' => 'අමාත්‍යාංශ නිලධාරීන්',
        'ta' => 'அமைச்சு ஊழியர்கள்'
    ),
    'other_govt_private' => array(
        'en' => 'Other Govt / Private',
        'si' => 'අනෙකුත් රාජ්‍ය / පෞද්ගලික',
        'ta' => 'பிற அரசு / தனியார்'
    ),
    'foreign_visitors' => array(
        'en' => 'Foreign Visitors',
        'si' => 'විදේශ අමුත්තන්',
        'ta' => 'வெளிநாட்டு பார்வையாளர்கள்'
    ),
    'ampara_desc_p1' => array(
        'en' => 'Ampara, a town located in the Eastern Province of Sri Lanka, is known for its beautiful landscapes, wildlife sanctuaries, and historical heritage. If you are planning a visit to this scenic region, finding the right accommodation is crucial for a comfortable and memorable stay.',
        'si' => 'ශ්‍රී ලංකාවේ නැගෙනහිර පළාතේ පිහිටි අම්පාර නගරය, එහි ලස්සන භූ දර්ශනය, වනජීවී අභය භූමිය සහ ඓතිහාසික උරුමය සඳහා ප්‍රසිද්ධය. ඔබ මෙම ලස්සන ප්‍රදේශයට සංචාරය සැලසුම් කරන්නේ නම්, සුවපහසු සහ අමතක නොවන නවාතැනක් සොයා ගැනීම ඉතා වැදගත් වේ.',
        'ta' => 'இலங்கையின் கிழக்கு மாகாணத்தில் அமைந்துள்ள அம்பாறை நகரம், அதன் அழகிய இயற்கை காட்சிகள், வனவிலங்கு சரணாலயங்கள் மற்றும் வரலாற்று மரபுகளுக்கு பிரபலமானது. இந்த இயற்கை அழகு நிறைந்த பகுதிக்கு செல்ல திட்டமிடுகிறீர்களென்றால், சரியான தங்குமிடம் கண்டுபிடிப்பது வசதியான தங்குவதற்கு முக்கியமாகும்.'
    ),
    'ampara_desc_p2' => array(
        'en' => 'The Ministry of Labour has established this Circuit Bungalow in Ampara to provide premium accommodation facilities for its officers. While primarily reserved for the Department of Labour staff, other public sector officers and general citizens are welcome to apply if availability permits.',
        'si' => 'කම්කරු අමාත්‍යාංශය විසින් මෙම සංචාරක බංගලාව අම්පාරයේ ස්ථාපනය කර ඇත්තේ, ඔවුන්ගේ නිලධාරීන් සඳහා ප්‍රිමියම් නවාතැන් පහසුකම් ලබා දීමේ අරමුණෙනි. ප්‍රධාන වශයෙන් කම්කරු දෙපාර්තමේන්තු කාර්යමණ්ඩලය සඳහා වෙන් කර ඇති නමුත්, ඉඩ ලබා ගත හැකි ශේෂය ඇති විට අනෙකුත් රාජ්‍ය නිලධාරීන් සහ සාමාන්‍ය ජනතාව ද ඉල්ලුම් කිරීමට ඉදිරිපත් විය හැකිය.',
        'ta' => 'தொழில் அமைச்சு, தனது அதிகாரிகளுக்கு உயர்தர தங்குமிட வசதிகளை வழங்கும் நோக்கத்துடன் அம்பாறையில் இந்த சுற்றுலா பங்களாவை நிறுவியுள்ளது. முதன்மையாக தொழிலாளர் திணைக்கள ஊழியர்களுக்கு ஒதுக்கப்பட்டிருந்தாலும், இடம் கிடைக்கும் பட்சத்தில் பிற அரச அதிகாரிகள் மற்றும் பொதுமக்களும் விண்ணப்பிக்க வரவேற்கிறோம்.'
    ),
    'ampara_desc_p3' => array(
        'en' => 'The bungalow features air-conditioned double and single rooms, chalets, common dining halls, and full culinary facilities. Meal preparation can be requested on-site, or guests may arrange to utilize the kitchen resources directly.',
        'si' => 'බංගලාවේ වායු සමනය කළ ද්විත්ව සහ තනි කාමර, චලේ, පොදු ආහාර හෝල් සහ සම්පූර්ණ ඉවුම් පිහුම් පහසුකම් ඇත. ආහාර සකස් කිරීම ස්ථානයේදීම ඉල්ලා සිටිය හැකිය, නැතහොත් අමුත්තන්ට කෝලය සම්පත් සෘජුවම භාවිතා කළ හැකිය.',
        'ta' => 'பங்களாவில் குளிரூட்டப்பட்ட இரட்டை மற்றும் ஒற்றை அறைகள், சேலட்கள், பொதுவான சாப்பாட்டு அரங்குகள் மற்றும் முழுமையான சமையல் வசதிகள் உள்ளன. உணவு தயாரிப்பை ஆன்-சைட்டில் கோரலாம், அல்லது விருந்தினர்கள் சமையலறை வளங்களை நேரடியாக பயன்படுத்திக்கொள்ளலாம்.'
    ),

    // ── Single Article Page ───────────────────────────────────────────────────
    'gallery' => array(
        'en' => 'Gallery',
        'si' => 'ඡායාරූප ගැලරිය',
        'ta' => 'புகைப்பட கேலரி'
    ),
    'previous_article' => array(
        'en' => 'Previous',
        'si' => 'පූර්ව ලිපිය',
        'ta' => 'முந்தைய செய்தி'
    ),
    'next_article' => array(
        'en' => 'Next',
        'si' => 'ඊළඟ ලිපිය',
        'ta' => 'அடுத்த செய்தி'
    ),
    'no_older_updates' => array(
        'en' => 'No older updates',
        'si' => 'පැරණි යාවත්කාලීන නොමැත',
        'ta' => 'பழைய புதுப்பிப்புகள் இல்லை'
    ),
    'no_newer_updates' => array(
        'en' => 'No newer updates',
        'si' => 'නව යාවත්කාලීන නොමැත',
        'ta' => 'புதிய புதுப்பிப்புகள் இல்லை'
    ),
    'val_fullname_required' => array(
        'en' => 'Please enter a valid full name (at least 2 characters).',
        'si' => 'කරුණාකර නිවැරදි සම්පූර්ණ නම ඇතුළත් කරන්න (අඩුම තරමින් අක්ෂර 2ක්).',
        'ta' => 'தயவுசெய்து செல்லுபடியாகும் முழுப் பெயரை உள்ளிடவும் (குறைந்தது 2 எழுத்துக்கள்).'
    ),
    'val_email_invalid' => array(
        'en' => 'Please enter a valid email address.',
        'si' => 'කරුණාකර නිවැරදි විද්‍යුත් තැපැල් ලිපිනයක් ඇතුළත් කරන්න.',
        'ta' => 'தயவுசெய்து செல்லுபடியாகும் மின்னஞ்சல் முகவரியை உள்ளிடவும்.'
    ),
    'val_phone_invalid' => array(
        'en' => 'Please enter a valid Sri Lankan phone number (e.g., 077 123 4567 or +94 11 258 1991).',
        'si' => 'කරුණාකර නිවැරදි ශ්‍රී ලාංකික දුරකථන අංකයක් ඇතුළත් කරන්න (උදා: 077 123 4567 හෝ +94 11 258 1991).',
        'ta' => 'தயவுசெய்து செல்லுபடியாகும் இலங்கை தொலைபேசி எண்ணை உள்ளிடவும் (எ.கா. 077 123 4567 அல்லது +94 11 258 1991).'
    ),
    'val_message_short' => array(
        'en' => 'Message must be at least 10 characters long.',
        'si' => 'පණිවිඩය අවම වශයෙන් අක්ෂර 10 ක් විය යුතුය.',
        'ta' => 'செய்தி குறைந்தது 10 எழுத்துக்களாக இருக்க வேண்டும்.'
    )
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

/**
 * Localized Trilingual Date Formatting Helper
 * Formats dates appropriately for English, Sinhala, and Tamil.
 */
if (!function_exists('format_date_trilingual')) {
    function format_date_trilingual(string|int|null $dateStr, string $format = 'M d, Y'): string {
        global $current_lang;
        if (empty($dateStr)) return '';
        $timestamp = is_numeric($dateStr) ? (int)$dateStr : strtotime($dateStr);
        if (!$timestamp) return (string)$dateStr;

        $lang = $current_lang ?? 'en';
        if ($lang === 'en') {
            return date($format, $timestamp);
        }

        $monthNum = (int)date('n', $timestamp);
        $day = date('j', $timestamp);
        $year = date('Y', $timestamp);

        $siMonths = [
            1 => 'ජනවාරි', 2 => 'පෙබරවාරි', 3 => 'මාර්තු', 4 => 'අප්‍රේල්',
            5 => 'මැයි', 6 => 'ජූනි', 7 => 'ජූලි', 8 => 'අගෝස්තු',
            9 => 'සැප්තැම්බර්', 10 => 'ඔක්තෝබර්', 11 => 'නොවැම්බර්', 12 => 'දෙසැම්බර්'
        ];

        $taMonths = [
            1 => 'ஜனவரி', 2 => 'பிப்ரவரி', 3 => 'மார்ச்', 4 => 'ஏப்ரல்',
            5 => 'மே', 6 => 'ஜூன்', 7 => 'ஜூலை', 8 => 'ஆகஸ்ட்',
            9 => 'செப்டம்பர்', 10 => 'அக்டோபர்', 11 => 'நவம்பர்', 12 => 'டிசம்பர்'
        ];

        if ($lang === 'si') {
            return $year . ' ' . $siMonths[$monthNum] . ' ' . $day;
        }
        if ($lang === 'ta') {
            return $year . ' ' . $taMonths[$monthNum] . ' ' . $day;
        }

        return date($format, $timestamp);
    }
}
