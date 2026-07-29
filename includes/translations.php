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
        'ta' => 'அண்மைக்கාල செய்திகள்'
    ],
    'news_updates_desc' => [
        'en' => 'Read the latest news and updated notices related to the Ministry.',
        'si' => 'අමාත්‍යාංශයට අදාළ නවතම පුවත්, යාවත්කාලීන නිවේදන කියවන්න.',
        'ta' => 'அமைச்சு தொடர்பான அண்மைக்கාල செய்திகள் மற்றும் புதுப்பிக்கப்பட்ட அறிவிப்புகளைப் படிக்கவும்.'
    ],
    'our_blog' => [
        'en' => 'Our Blog',
        'si' => 'අපගේ බ්ලොග් අඩවිය',
        'ta' => 'எமது வலைப்பதிவு'
    ],
    'latest_insights' => [
        'en' => 'Latest Insights',
        'si' => 'නවතම පුවත්',
        'ta' => 'அண்மைக்கාල செய்திகள்'
    ],
    'recent_posts' => [
        'en' => 'Recent Posts',
        'si' => 'මෑතකාලීන පලකිරීම්',
        'ta' => 'සமீපத்திய இடுகைகள்'
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
        'si' => 'සෑහීමට පත් පාරිභෝගිකයින්',
        'ta' => 'මகிழ்ச்சியான வாடிக்கையாளர்கள்'
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
        'si' => 'පෞද්ගලික හා අර්ධ රාජ්ය අංශ සේවා නියුක්තිකයන්ගේ වෘත්තීය අයිතිවාසිකම් ආරක්ෂා කිරීම, සමාජ ආරක්ෂණය, කාර්මික සාමය තහවුරු කිරීම, රැකියා වෙළඳපොළ සඳහා පුහුණු ශ්රමිකයන් යොමු කිරීම, රැකියාගත කිරීම සහ රැකියා සුරක්ෂිතභාවය තහවුරු කිරීම, වෘත්තීය සුරක්ෂිතතාව හා සෞඛ්ය ආරක්ෂණය තහවුරු කිරීම තුළින් දේශීය ශ්රම බලකාය ආර්ථික සංවර්ධනය සඳහා දක්වන දායකත්වය ඉහළ නැංවීමට අවශ්ය ප්රතිපත්ති සම්පාදනය හා ක්රියාත්මක කිරීම කම්කරු අමාත්යාංශයේ ප්රධාන මෙහෙවර වේ.',
        'ta' => 'தனியார் மற்றும் பகுதியளவில் அரச துறைகளில் உள்ள ஊழியர்களின் தொழில் உரிமைகளைப் பாதுகாத்தல், சமூகப் பாதுகாப்பு, தொழிற்துறை அமைதியை உறுதி செய்தல், பயிற்சி பெற்ற தொழிலாளர்களை தொழில் சந்தைக்கு வழிநடத்துதல், தொழில் வாய்ப்பை உறுதி செய்தல், தொழில் பாதுகாப்பை உறுதி செய்தல் மற்றும் நாட்டின் உற்பத்தித்திறனை மேம்படுத்துதல் ஆகியவற்றின் மூலம் பொருளாதார அபிவிருத்திக்கு உள்நாட்டு பணியாளர்களின் பங்களிப்பை மேம்படுத்துவதற்கான கொள்கைகளை வகுத்துச் செயற்படுத்துவதே தொழில் அமைச்சின் பிரதான பணியாகும்.'
    ],
    'overview_p2' => [
        'en' => 'In pursuit of this mission, the key function of this Ministry is to formulate policies, plan, implement, monitor and follow up on programmes and projects related to the scope of labour and the scopes of departments and institutions affiliated to the Ministry, based on the tasks assigned and national policies in terms of the Gazette Extraordinary Notification No. 2412/08 dated 25.11.2024, in accordance with the sustainable development goals and international conventions ratified by Sri Lanka the Government.',
        'si' => 'මෙම මෙහෙවර ඉටු කිරීමේදී තිරසාර සංවර්ධන අරමුණු සහ ශ්රී ලංකාව විසින් අනුමත කර ඇති ජාත්යන්තර සම්මුතීන් මෙන්ම 2024.11.25 දිනැති අංක 2412/08 දරන අතිවිශේෂ ගැසට් නිවේදනයෙහි සඳහන් කාර්යයන් හා කර්තව්යයන් මත පදනම්ව අමාත්යාංශ වැඩසටහන් පළගස්වා ඇත. එම ගැසට් නිවේදනය ප්රකාරව රජය විසින් ක්රියාත්මක කරනු ලබන ජාතික ප්රතිපත්තීන් මත පිහිටා කම්කරු විෂය පථයට සහ අමාත්යාංශයට අනුබද්ධ ආයතනයන්හි විෂය පථයන්ට අදාළව ප්රතිපත්ති සම්පාදනය, වැඩසටහන් සහ ව්යාපෘති සැලසුම් කිරීම, ක්රියාත්මක කිරීම, අධීක්ෂණය හා පසුවිපරම් කිරීම මෙම අමාත්යාංශයේ ප්රධාන කාර්යභාරය වේ.',
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
