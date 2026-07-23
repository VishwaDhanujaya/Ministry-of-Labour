<?php
/**
 * Search Suggest API
 * 
 * Returns autocomplete search suggestion matches for news, vacancies, and procurements
 * in JSON format based on a GET query.
 * 
 * @package MinistryOfLabour
 * @subpackage Search
 */
require_once 'admin/includes/db.php';

header('Content-Type: application/json');

$query = trim($_GET['q'] ?? '');

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

try {
    $results = [];
    $searchTerm = "%$query%";

    // Get current language from cookie or URL parameter
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

    // Static Pages definitions with translation mappings
    $static_pages = [
        [
            'url' => 'home',
            'titles' => [
                'en' => 'Home - Ministry of Labour',
                'si' => 'මුල් පිටුව - කම්කරු අමාත්‍යාංශය',
                'ta' => 'முகப்பு பக்கம் - தோழில் அமைச்சு'
            ],
            'keywords' => ['home', 'index', 'welcome', 'main', 'මුල් පිටුව', 'කම්කරු', 'முகப்பு']
        ],
        [
            'url' => 'about-us',
            'titles' => [
                'en' => 'About Us - Ministry Overview',
                'si' => 'අප ගැන - අමාත්‍යාංශය පිළිබඳ තොරතුරු',
                'ta' => 'எங்களைப் பற்றி - அமைச்சின் கண்ணோட்டம்'
            ],
            'keywords' => ['about us', 'about', 'ministry', 'overview', 'history', 'mission', 'vision', 'අප ගැන', 'අමාත්‍යාංශය', 'எங்களைப் பற்றி']
        ],
        [
            'url' => 'contact-us',
            'titles' => [
                'en' => 'Contact Us - Office Locations & Directory',
                'si' => 'අපව සම්බන්ධ කරගන්න - කාර්යාල හා දුරකථන නාමාවලිය',
                'ta' => 'தொடர்புகொள்ள - அலுவலக இடங்கள் மற்றும் விபரக்கொத்து'
            ],
            'keywords' => ['contact us', 'contact', 'telephone', 'directory', 'email', 'address', 'complaints', 'whatsapp', 'අපව සම්බන්ධ කරගන්න', 'දුරකථන', 'தொடர்புகொள்ள']
        ],
        [
            'url' => 'downloads',
            'titles' => [
                'en' => 'Downloads - Applications & Forms',
                'si' => 'බාගත කිරීම් - අයදුම්පත් හා ආකෘති පත්‍ර',
                'ta' => 'பதிවிறக்கங்கள் - விண்ணப்பங்கள் மற்றும் படிவங்கள்'
            ],
            'keywords' => ['downloads', 'applications', 'forms', 'documents', 'pdf', 'acts', 'බාගත කිරීම්', 'අයදුම්පත්', 'பதிවிறக்கங்கள்']
        ],
        [
            'url' => 'iau',
            'titles' => [
                'en' => 'Internal Affairs Unit (IAU)',
                'si' => 'අභ්‍යන්තර කටයුතු අංශය (IAU)',
                'ta' => 'உள்விவகாரப் பிரிவு (IAU)'
            ],
            'keywords' => ['iau', 'internal affairs', 'integrity', 'bribery', 'corruption', 'complaints', 'ciaboc', 'අභ්‍යන්තර කටයුතු', 'දූෂණ', 'உள்விவகார']
        ],
        [
            'url' => 'rti',
            'titles' => [
                'en' => 'Right to Information (RTI)',
                'si' => 'තොරතුරු දැනගැනීමේ අයිතිවාසිකම',
                'ta' => 'தகவல் அறியும் உரிமை'
            ],
            'keywords' => ['rti', 'right to information', 'information act', 'officers', 'තොරතුරු දැනගැනීමේ', 'தகவல் அறியும்']
        ],
        [
            'url' => 'ampara-circuit-bungalow',
            'titles' => [
                'en' => 'Ampara Circuit Bungalow - Online Booking',
                'si' => 'අම්පාර පරිපථ බංගලාව - මාර්ගගත වෙන්කිරීම්',
                'ta' => 'அம்பாறை சுற்றுவட்ட பங்களா - ஆன்லைன் முன்பதிவு'
            ],
            'keywords' => ['ampara', 'circuit bungalow', 'booking', 'bungalow', 'accommodation', 'holiday', 'අම්පාර', 'බංගලාව', 'அம்பாறை']
        ],
        [
            'url' => 'citizen-charter',
            'titles' => [
                'en' => 'Citizen Charter',
                'si' => 'පුරවැසි ප්‍රඥප්තිය',
                'ta' => 'குடிமக்கள் சாசனம்'
            ],
            'keywords' => ['citizen charter', 'charter', 'rules', 'citizen', 'පුරවැසි ප්‍රඥප්තිය', 'குடிமக்கள்']
        ],
        [
            'url' => 'news',
            'titles' => [
                'en' => 'News & Events',
                'si' => 'පුවත් සහ සිදුවීම්',
                'ta' => 'செய்திகள் மற்றும் நிகழ்வுகள்'
            ],
            'keywords' => ['news', 'events', 'announcements', 'media', 'පුවත්', 'செய்திகள்']
        ],
        [
            'url' => 'vacancies',
            'titles' => [
                'en' => 'Careers & Vacancies',
                'si' => 'රැකියා අවස්ථා සහ පුරප්පාඩු',
                'ta' => 'வேலைவாய்ப்புகள் மற்றும் காலியிடங்கள்'
            ],
            'keywords' => ['vacancies', 'jobs', 'careers', 'recruitment', 'රැකියා', 'පුරප්පාඩු', 'வேலைவாய்ப்பு']
        ],
        [
            'url' => 'procurements',
            'titles' => [
                'en' => 'Procurements & Tenders',
                'si' => 'ප්‍රසම්පාදන සහ ටෙන්ඩර්',
                'ta' => 'கொள்முதல் மற்றும் ஏலங்கள்'
            ],
            'keywords' => ['procurements', 'tenders', 'bids', 'purchasing', 'ප්‍රසම්පාදන', 'ටෙන්ඩර්', 'கொள்முதல்']
        ],
        [
            'url' => 'learning-platforms',
            'titles' => [
                'en' => 'Learning Platforms & Publications',
                'si' => 'ඉගෙනුම් වේදිකා සහ ප්‍රකාශන',
                'ta' => 'கற்றல் தளங்கள் மற்றும் வெளியீடுகள்'
            ],
            'keywords' => ['learning', 'platforms', 'publications', 'training', 'courses', 'education', 'ඉගෙනුම්', 'ප්‍රකාශන', 'කற்றல்']
        ],
        [
            'url' => 'learning-platforms-local',
            'titles' => [
                'en' => 'Local Training & Learning Platforms',
                'si' => 'දේශීය පුහුණු හා ඉගෙනුම් වේදිකා',
                'ta' => 'உள்ளூர் பயிற்சி மற்றும் கற்றல் தளங்கள்'
            ],
            'keywords' => ['local training', 'learning', 'courses', 'skills', 'දේශීය පුහුණු', 'පුහුණු', 'දේශීය']
        ],
        [
            'url' => 'learning-platforms-foreign',
            'titles' => [
                'en' => 'Foreign Training & Learning Platforms',
                'si' => 'විදේශීය පුහුණු හා ඉගෙනුම් වේදිකා',
                'ta' => 'வெளிநாட்டு பயிற்சி மற்றும் கற்றல் தளங்கள்'
            ],
            'keywords' => ['foreign training', 'scholarships', 'study', 'training', 'විදේශීය පුහුණු', 'විදේශීය']
        ],
        [
            'url' => 'complaints',
            'titles' => [
                'en' => 'Complaints - Official Portal',
                'si' => 'පැමිණිලි - නිල ද්වාරය',
                'ta' => 'முறைப்பாடுகள் - உத்தியோகபூர்வ போர்டல்'
            ],
            'keywords' => ['complaints', 'whatsapp', 'labour dept', 'cms', 'පැමිණිලි', 'முறைப்பாடுகள்', 'தொடர்புகொள்ள']
        ]
    ];

    // Search Static Pages
    $q_lower = mb_strtolower($query, 'UTF-8');
    $page_count = 0;
    foreach ($static_pages as $page) {
        if ($page_count >= 5) break;
        $matched = false;
        
        $title = $page['titles'][$current_lang] ?? $page['titles']['en'];
        if (mb_strpos(mb_strtolower($title, 'UTF-8'), $q_lower) !== false) {
            $matched = true;
        }
        
        if (!$matched) {
            foreach ($page['keywords'] as $kw) {
                if (mb_strpos(mb_strtolower($kw, 'UTF-8'), $q_lower) !== false) {
                    $matched = true;
                    break;
                }
            }
        }
        
        if ($matched) {
            $lang_param = ($current_lang !== 'en') ? '?lang=' . $current_lang : '';
            $results[] = [
                'title' => $title,
                'type' => 'Page',
                'url' => $page['url'] . $lang_param
            ];
            $page_count++;
        }
    }

    $lang_param = ($current_lang !== 'en') ? '?lang=' . $current_lang : '';

    // 1. Search News
    $stmt = $pdo->prepare("SELECT id, title, title_si, title_ta FROM news WHERE status = 'Published' AND (title LIKE ? OR title_si LIKE ? OR title_ta LIKE ?) ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($news as $n) {
        $title = $n['title'];
        if ($current_lang === 'si' && !empty($n['title_si'])) {
            $title = $n['title_si'];
        } elseif ($current_lang === 'ta' && !empty($n['title_ta'])) {
            $title = $n['title_ta'];
        }
        
        $results[] = [
            'title' => $title,
            'type' => 'News',
            'url' => 'news/' . $n['id'] . $lang_param
        ];
    }

    // 2. Search Vacancies
    $stmt = $pdo->prepare("SELECT id, title FROM vacancies WHERE status = 'Published' AND title LIKE ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$searchTerm]);
    $vacancies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($vacancies as $v) {
        $results[] = [
            'title' => $v['title'],
            'type' => 'Vacancy',
            'url' => 'vacancies' . $lang_param
        ];
    }

    // 3. Search Procurements
    $stmt = $pdo->prepare("SELECT id, title FROM procurements WHERE status = 'Published' AND title LIKE ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$searchTerm]);
    $procurements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($procurements as $p) {
        $results[] = [
            'title' => $p['title'],
            'type' => 'Procurement',
            'url' => 'procurements' . $lang_param
        ];
    }

    echo json_encode($results);
} catch (Exception $e) {
    error_log("Search suggest database error: " . $e->getMessage());
    echo json_encode([]);
}
