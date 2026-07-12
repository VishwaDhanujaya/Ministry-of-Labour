<?php
// index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'admin/includes/db.php';

// Increment unique visitor count
if (!isset($_SESSION['has_visited_site'])) {
    try {
        $pdo->query("UPDATE statistics SET stat_value = CAST(stat_value AS UNSIGNED) + 1 WHERE stat_key = 'total_visitors'");
        $_SESSION['has_visited_site'] = true;
    } catch (PDOException $e) {
        // Fail silently
    }
}


// Fetch recent news (limit 3)
$recentNewsRaw = $pdo->query("SELECT * FROM news WHERE status = 'Published' ORDER BY created_at DESC LIMIT 3")->fetchAll();
$recentNews = [];
foreach ($recentNewsRaw as $news) {
    if ($current_lang === 'si') {
        if (!empty($news['title_si'])) $news['title'] = $news['title_si'];
        if (!empty($news['content_si'])) $news['content'] = $news['content_si'];
    } elseif ($current_lang === 'ta') {
        if (!empty($news['title_ta'])) $news['title'] = $news['title_ta'];
        if (!empty($news['content_ta'])) $news['content'] = $news['content_ta'];
    }
    $recentNews[] = $news;
}

// Fetch Vacancies and Procurements for Announcements (limit 4 combined)
$vacanciesRaw = $pdo->query("SELECT id, title, 'Vacancy' as type, pdf_path, created_at, description FROM vacancies WHERE status = 'Published' ORDER BY created_at DESC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
$procurementsRaw = $pdo->query("SELECT id, title, 'Procurement' as type, pdf_path, created_at, description FROM procurements WHERE status = 'Published' ORDER BY created_at DESC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

$announcementsRaw = array_merge($vacanciesRaw, $procurementsRaw);
// Sort by created_at descending
usort($announcementsRaw, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
$announcementsRaw = array_slice($announcementsRaw, 0, 4);

$announcements = [];
foreach ($announcementsRaw as $notice) {
    $notice['content'] = $notice['description'];
    $announcements[] = $notice;
}

// Fetch statistics with fallback defaults
$statisticsList = [];
try {
    $statisticsList = $pdo->query("SELECT * FROM statistics ORDER BY display_order ASC")->fetchAll();
} catch (PDOException $e) {
    // Fail silently, defaults will be used
}

$stats = [
    'ilo_conventions' => [
        'stat_label' => 'ILO Ratified Conventions',
        'stat_label_si' => 'අනුමත කරන ලද ILO සම්මුතීන්',
        'stat_label_ta' => 'ஒப்புதல் அளிக்கப்பட்ட ஐ.எல்.ஓ உடன்படிக்கைகள்',
        'stat_value' => '44',
        'stat_suffix' => ''
    ],
    'labour_acts' => [
        'stat_label' => 'Labour Acts Enforced',
        'stat_label_si' => 'බලාත්මක කළ කම්කරු පනත්',
        'stat_label_ta' => 'அமுல்படுத்தப்பட்ட தொழிலாளர் சட்டங்கள்',
        'stat_value' => '32',
        'stat_suffix' => '+'
    ],
    'affiliated_institutions' => [
        'stat_label' => 'Affiliated Institutions',
        'stat_label_si' => 'අනුබද්ධ ආයතන',
        'stat_label_ta' => 'இணைந்த நிறுவனங்கள்',
        'stat_value' => '5',
        'stat_suffix' => ''
    ],
    'total_visitors' => [
        'stat_label' => 'Total Visitors',
        'stat_label_si' => 'මුළු අමුත්තන් සංඛ්‍යාව',
        'stat_label_ta' => 'மொத்த பார்வையாளர்கள்',
        'stat_value' => '1250',
        'stat_suffix' => ''
    ]
];

if (!empty($statisticsList)) {
    foreach ($statisticsList as $row) {
        $key = $row['stat_key'];
        if (isset($stats[$key])) {
            $val = $row['stat_value'];
            $suffix = $row['stat_suffix'] ?? '';
            
            // Format visitor count dynamically to K/M notation
            if ($key === 'total_visitors' && is_numeric($val)) {
                $num = (int)$val;
                if ($num >= 1000000) {
                    $val = round($num / 1000000, 1);
                    $suffix = 'M' . $suffix;
                } elseif ($num >= 1000) {
                    $val = round($num / 1000, 1);
                    $suffix = 'K' . $suffix;
                }
            }
            
            $stats[$key]['stat_value'] = $val;
            if (isset($row['stat_label']) && !empty($row['stat_label'])) $stats[$key]['stat_label'] = $row['stat_label'];
            if (isset($row['stat_label_si']) && !empty($row['stat_label_si'])) $stats[$key]['stat_label_si'] = $row['stat_label_si'];
            if (isset($row['stat_label_ta']) && !empty($row['stat_label_ta'])) $stats[$key]['stat_label_ta'] = $row['stat_label_ta'];
            $stats[$key]['stat_suffix'] = $suffix;
        }
    }
}




$pageTitle = 'Home - Ministry of Labour - Sri Lanka';
$metaDescription = 'Official portal of the Ministry of Labour, Sri Lanka. Committed to protecting workforce rights, maintaining industrial peace, social security (EPF), and workplace occupational safety.';
$metaKeywords = 'Ministry of Labour, Sri Lanka Labour, EPF, ETF, Labour Laws Sri Lanka, Employees Provident Fund, Mehewara Piyasa, Industrial Relations, Occupational Safety';
include 'includes/header.php';
?>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<?php
$hero_desktop_path = __DIR__ . '/assets/img/hero.webp';
$hero_desktop_version = file_exists($hero_desktop_path) ? filemtime($hero_desktop_path) : time();

$hero_mobile_path = __DIR__ . '/assets/img/mobile-hero.webp';
$hero_mobile_version = file_exists($hero_mobile_path) ? filemtime($hero_mobile_path) : time();
?>
<!-- Hero Section -->
<section class="relative min-h-[calc(100vh-76px)] md:min-h-[calc(100vh-120px)] flex items-center bg-primary overflow-hidden py-12 md:py-16 xl:py-20">
    <!-- Desktop Hero Image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none hidden md:block"
        style="background-image: url('assets/img/hero.webp?v=<?= $hero_desktop_version ?>');"></div>
    <!-- Mobile Hero Image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none block md:hidden"
        style="background-image: url('assets/img/mobile-hero.webp?v=<?= $hero_mobile_version ?>');"></div>
    <div class="absolute inset-0 opacity-25 bg-home-hero-gradient"></div>
    <!-- Bottom gradient overlay to blend hero image and improve legibility at the bottom -->
    <div class="absolute inset-x-0 bottom-0 h-96 opacity-70 bg-home-hero-bottom-gradient pointer-events-none"></div>

    <div class="relative z-10 container mx-auto px-4 md:px-16 text-white w-full" data-aos="fade-up" data-aos-duration="1000">
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-12 relative w-full">
            
            <!-- Left Side: Welcome Text (Old design restored) -->
            <div class="max-w-2xl w-full">
                <h2 class="text-2xl md:text-3xl font-inter font-normal mb-2 text-shadow-premium">Welcome to</h2>
                <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7.5xl font-semibold font-montserrat mb-4 md:mb-6 leading-none tracking-tighter uppercase text-shadow-premium">
                    Ministry of Labour</h1>
                <p class="text-[13px] md:text-base font-inter mb-6 md:mb-10 leading-relaxed text-white text-shadow-premium max-w-xl">
                    The Ministry of Labour is dedicated to fostering fair employment, protecting workers' rights, and
                    building a dynamic workforce that drives Sri Lanka's economic development.
                </p>
                <div class="flex flex-wrap gap-3 sm:gap-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="#quick-links"
                        class="bg-secondary/70 backdrop-blur-md text-white font-semibold py-2 px-4 sm:py-3.5 sm:px-8 rounded-lg border border-white/10 hover:border-white/30 transition-all duration-300 text-[11.5px] sm:text-[13px] tracking-wider font-inter hover:shadow-xl hover:-translate-y-1 transform text-center flex items-center justify-center">Quick Links</a>
                    <a href="#news-section"
                        class="bg-white/10 backdrop-blur-md text-white font-semibold py-2 px-4 sm:py-3.5 sm:px-8 rounded-lg border border-white/20 hover:border-white transition-all duration-300 text-[11.5px] sm:text-[13px] tracking-wider font-inter flex items-center justify-center hover:bg-white hover:text-primary hover:shadow-xl hover:-translate-y-1 transform text-center">View Notices</a>
                </div>
            </div>



        </div>
    </div>
    <!-- Scrolling News Bar -->
    <div class="absolute bottom-0 left-0 w-full z-40 bg-black/40 backdrop-blur-md border-t border-white/10 overflow-hidden flex items-stretch h-14 shadow-lg">
        <div class="bg-primary text-white font-bold text-[10px] md:text-xs px-4 md:px-6 uppercase tracking-widest shrink-0 z-10 shadow-[10px_0_20px_rgba(0,0,0,0.5)] flex items-center justify-center hidden md:flex">
            Latest News
        </div>
        
        <div class="flex-1 overflow-hidden relative flex items-center h-full group">
            <div class="flex whitespace-nowrap animate-marquee group-hover:[animation-play-state:paused] items-center">
                <?php if(!empty($recentNews)): ?>
                    <?php 
                    // Duplicate for seamless infinite scrolling
                    $tickerNews = array_merge($recentNews, $recentNews, $recentNews, $recentNews); 
                    foreach($tickerNews as $news): 
                    ?>
                        <a href="news/<?= $news['id'] ?>" class="inline-flex items-center text-gray-100 hover:text-yellow-400 transition-colors mx-6 md:mx-10 font-inter text-[13px] md:text-sm group/link">
                            <?= htmlspecialchars($news['title']) ?>
                            <svg class="w-4 h-4 ml-1.5 transform group-hover/link:translate-x-1 transition-transform opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        <span class="w-1 h-1 rounded-full bg-white/30 mx-2"></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-gray-300 mx-8 font-inter text-sm">No recent news available.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-25%); } 
    }
    .animate-marquee {
        animation: marquee 40s linear infinite;
        will-change: transform;
    }
</style>

<!-- Stats Bar -->
<div class="bg-secondary text-white py-10 relative z-20">
    <div class="container mx-auto px-4 md:px-16 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center md:divide-x divide-white/20">
            <?php 
            $orderedKeys = ['ilo_conventions', 'labour_acts', 'affiliated_institutions', 'total_visitors'];
            foreach ($orderedKeys as $key): 
                $stat = $stats[$key];
                $label = $stat['stat_label'];
                if ($current_lang === 'si' && !empty($stat['stat_label_si'])) {
                    $label = $stat['stat_label_si'];
                } elseif ($current_lang === 'ta' && !empty($stat['stat_label_ta'])) {
                    $label = $stat['stat_label_ta'];
                }
                
                $isLink = ($key === 'affiliated_institutions');
                $elTag = $isLink ? 'a' : 'div';
                $linkHref = $isLink ? ' href="#affiliated-institutions"' : '';
                $hoverClasses = $isLink ? ' hover:scale-105 cursor-pointer transition-all duration-300 hover:opacity-90 block' : '';
            ?>
            <<?= $elTag . $linkHref ?> class="px-4 stat-box notranslate<?= $hoverClasses ?>" data-target="<?= htmlspecialchars($stat['stat_value']) ?>" data-suffix="<?= htmlspecialchars($stat['stat_suffix']) ?>">
                <div class="text-4xl md:text-5xl font-semibold font-montserrat mb-2 text-white"><span
                        class="stat-number">0</span><?= htmlspecialchars($stat['stat_suffix']) ?></div>
                <div class="text-[11px] md:text-xs font-inter text-gray-200 uppercase tracking-widest font-normal">
                    <?= htmlspecialchars($label) ?></div>
            </<?= $elTag ?>>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="py-20 md:py-28 px-4 md:px-16" id="about-us">
    <div class="container mx-auto flex flex-col lg:flex-row items-center gap-16">
        <div class="w-full lg:w-[55%]" data-aos="fade-right">
            <p class="section-subtitle">About
                Us</p>
            <h2 class="section-title">
                About the Ministry of Labour</h2>
            <div class="space-y-5 text-gray-600 font-inter text-[14px] md:text-[15px] leading-relaxed">
                <p>Improving the standards of living and service conditions of workers in Sri Lanka's semi-government
                    and private sectors, and the formulation and implementation of pertinent policies to establish
                    industrial peace and employer-employee relationships required for enhancing production and labour
                    productivity, are the prime objectives of the Ministry of Labour.</p>
                <p>The Ministry of Labour plays a vital role in safeguarding the rights and welfare of employees while
                    fostering harmonious industrial relations across the country. The ministry oversees labour laws,
                    social security programs, employment policies, and occupational safety standards to ensure a fair
                    and productive labour environment.</p>
                <p>Through its institutions and departments, the ministry serves millions of employees in the private
                    and semi-government sectors while contributing to national economic development.</p>
            </div>
            
            <!-- Read More Button -->
            <div class="mt-8">
                <a href="about-us" class="bg-secondary text-white font-semibold py-3.5 px-8 rounded-lg transition-all duration-300 text-[13px] tracking-wider font-inter inline-block hover:shadow-lg hover:-translate-y-1 transform">
                    Read More
                </a>
            </div>
        </div>

        <!-- Styled administrative image container -->
        <div class="w-full lg:w-[45%]" data-aos="fade-left">
            <div
                class="rounded-3xl overflow-hidden shadow-lg border-[0.5px] border-[#D4D4D4] h-[450px] lg:h-[530px] w-full bg-gray-50 hover:shadow-2xl transition-shadow duration-500">
                <img loading="lazy" src="assets/img/home-about.webp" alt="Ministry of Labour Head Office"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
            </div>
        </div>
    </div>
</section>

<!-- Quick Links -->
<section class="relative py-20 md:py-28 px-4 md:px-16 text-white overflow-hidden bg-primary" id="quick-links">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat pointer-events-none"
        style="background-image: url('assets/img/keyfocus.webp');"></div>
    <div class="absolute inset-0 bg-primary/90"></div>
    <div class="container mx-auto relative z-10" data-aos="fade-up">
        <div class="mb-12">
            <div>
                <p class="text-gray-300 text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">Quick Access</p>
                <h2 class="section-title text-white mb-0">Quick Links</h2>
                <p class="text-gray-300 font-inter font-normal text-sm md:text-base mt-3">Direct access to our most crucial portals and services.</p>
            </div>
        </div>

        <div class="relative">
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-6 py-4">
                <!-- Card 1: NLAC -->
                <a href="about-us#divisions-functions" class="focus-card min-w-0 group hover:-translate-y-1 hover:shadow-lg transition-all duration-300 hover:no-underline">
                    <div>
                        <div class="focus-card-icon group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <h3 class="focus-card-title">NLAC</h3>
                        <p class="focus-card-desc">National Labour Advisory Council — consultative labour governance and social dialogue.</p>
                    </div>
                </a>
                
                <!-- Card 2: Ampara Circuit Bungalow -->
                <a href="ampara-circuit-bungalow" class="focus-card min-w-0 group hover:-translate-y-1 hover:shadow-lg transition-all duration-300 hover:no-underline">
                    <div>
                        <div class="focus-card-icon group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="focus-card-title">Circuit Bungalow</h3>
                        <p class="focus-card-desc">Book and reserve the Ministry's comfortable circuit bungalow in Ampara online.</p>
                    </div>
                </a>
 
                <!-- Card 3: Learning Platforms -->
                <a href="learning-platforms" class="focus-card min-w-0 group hover:-translate-y-1 hover:shadow-lg transition-all duration-300 hover:no-underline">
                    <div>
                        <div class="focus-card-icon group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="focus-card-title">Learning Platforms</h3>
                        <p class="focus-card-desc">Access official learning platforms and resources.</p>
                    </div>
                </a>
 
                <!-- Card 4: News -->
                <a href="news" class="focus-card min-w-0 group hover:-translate-y-1 hover:shadow-lg transition-all duration-300 hover:no-underline">
                    <div>
                        <div class="focus-card-icon group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>
                        </div>
                        <h3 class="focus-card-title">News Updates</h3>
                        <p class="focus-card-desc">Read the latest news, updates, announcements, and notices from the Ministry.</p>
                    </div>
                </a>
 
                <!-- Card 5: RTI -->
                <a href="rti" class="focus-card min-w-0 group hover:-translate-y-1 hover:shadow-lg transition-all duration-300 hover:no-underline">
                    <div>
                        <div class="focus-card-icon group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="focus-card-title">RTI Portal</h3>
                        <p class="focus-card-desc">Submit information requests under the Right to Information Act in Sri Lanka.</p>
                    </div>
                </a>
 
                <!-- Card 6: Complaints -->
                <a href="https://wa.me/94707227877" target="_blank" rel="noopener noreferrer" class="focus-card min-w-0 group hover:-translate-y-1 hover:shadow-lg transition-all duration-300 hover:no-underline">
                    <div>
                        <div class="focus-card-icon group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="focus-card-title">Complaints (WhatsApp)</h3>
                        <p class="focus-card-desc">Submit complaints directly via WhatsApp to our official number: 070 722 7877.</p>
                    </div>
                </a>
            </div>
        </div>
</section>



<!-- Latest Articles -->
<section class="py-20 md:py-32 px-4 md:px-16 relative overflow-hidden bg-[#F9FAFB]" id="news-section">
    <div class="container mx-auto">
        <div class="flex justify-between items-end mb-12" data-aos="fade-up">
            <div>
                <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">
                    Updates & Announcements</p>
                <h2 class="section-title">
                    Latest News</h2>
            </div>
            <a href="news" class="hidden md:flex items-center space-x-2 border border-secondary text-secondary font-bold py-2.5 px-6 rounded-lg hover:bg-secondary hover:text-white transition-all text-xs uppercase tracking-wider">
                <span>View All</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if(empty($recentNews)): ?>
                <div class="col-span-3 text-center text-gray-500 py-10">No recent news available.</div>
            <?php else: ?>
                <?php foreach($recentNews as $news): ?>
                <div class="news-card">
                    <div>
                        <div class="h-56 overflow-hidden bg-gray-100 flex items-center justify-center">
                            <?php if(!empty($news['cover_image']) && file_exists('admin/' . $news['cover_image'])): ?>
                                <img loading="lazy" src="admin/<?= htmlspecialchars($news['cover_image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <?php endif; ?>
                        </div>
                        <div class="p-8 pb-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs text-gray-500 font-inter font-bold"><?= date('M d, Y', strtotime($news['created_at'])) ?></span>
                            </div>
                            <h3 class="text-lg font-semibold text-primary font-montserrat mb-4 leading-snug hover:text-secondary transition-colors line-clamp-2 notranslate">
                                <?= htmlspecialchars($news['title']) ?>
                            </h3>
                            <p class="text-gray-500 text-[14px] font-inter leading-relaxed line-clamp-3 notranslate">
                                <?= htmlspecialchars(mb_substr(strip_tags($news['content']), 0, 150)) ?>...
                            </p>
                        </div>
                    </div>
                    <div class="p-8 pt-2">
                        <a href="news/<?= $news['id'] ?>" class="text-secondary font-bold text-xs flex items-center hover:text-primary transition-colors uppercase tracking-wider gap-1.5">
                            Read More <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="mt-10 text-center md:hidden">
            <a href="news"
                class="inline-flex items-center space-x-2 border border-secondary text-secondary font-bold py-3 px-8 rounded-lg hover:bg-secondary hover:text-white transition-all text-xs tracking-wider uppercase">
                <span>View All News</span>
            </a>
        </div>
    </div>
</section>


<!-- Downloads & Special Notices Section -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-white" id="downloads-notices">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            
            <!-- Downloads Column -->
            <div class="bg-[#FAFAFA] rounded-[32px] p-8 md:p-12 flex flex-col self-start">
                <p class="text-secondary font-medium text-xs md:text-[13px] tracking-[0.15em] mb-3 font-inter uppercase">
                    Important Documents and Resources
                </p>
                <h3 class="font-semibold text-3xl md:text-4xl font-montserrat mb-8 text-primary">Downloads</h3>
                
                <div class="flex flex-col space-y-3.5">
                    <?php
                    $downloads = [
                        ['title' => 'Acts & Amendments', 'url' => 'downloads'],
                        ['title' => 'Learning Platforms (Local)', 'url' => 'learning-platforms-local'],
                        ['title' => 'Learning Platforms (Foreign)', 'url' => 'learning-platforms-foreign'],
                        ['title' => 'Procurements', 'url' => 'procurements']
                    ];
                    foreach($downloads as $download):
                    ?>
                    <a href="<?= $download['url'] ?>" class="group flex items-center justify-between bg-white border border-gray-200 rounded-[16px] px-6 py-4 hover:border-gray-300 hover:shadow-sm transition-all duration-300">
                        <span class="text-gray-800 font-medium font-inter text-[14.5px] group-hover:text-secondary transition-colors"><?= $download['title'] ?></span>
                        <div class="bg-secondary text-white w-9 h-9 rounded-[10px] flex items-center justify-center shrink-0 group-hover:bg-primary transition-colors">
                            <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Announcements Column -->
            <div class="bg-white rounded-[32px] border-[0.5px] border-[#D4D4D4] shadow-sm overflow-hidden flex flex-col h-full">
                <div class="bg-primary text-white py-4 px-6 relative overflow-hidden shrink-0">
                    <h3 class="font-medium text-[18px] md:text-[20px] font-montserrat flex items-center relative z-10 tracking-wide">Announcements</h3>
                </div>
                <div class="divide-y divide-gray-100 bg-white flex-grow flex flex-col">
                    <?php if(empty($announcements)): ?>
                        <div class="p-6 text-center text-gray-500 font-inter flex-grow flex items-center justify-center">No announcements available at the moment.</div>
                    <?php else: ?>
                        <?php foreach($announcements as $notice): 
                            $isVacancy = ($notice['type'] === 'Vacancy');
                            $hasPdf = !empty($notice['pdf_path']) && !$isVacancy;
                            $btnUrl = $hasPdf ? htmlspecialchars(resolvePdfUrl($notice['pdf_path'])) : ($isVacancy ? 'vacancies' : 'procurements');
                            $btnTarget = $hasPdf ? '_blank' : '_self';
                            $btnText = $hasPdf ? 'View PDF' : 'Read More';
                        ?>
                        <div class="p-4 md:p-5 flex justify-between items-center gap-4 hover:bg-gray-50/50 transition-colors duration-200">
                            <div class="flex-grow">
                                <div class="mb-1">
                                    <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-bold uppercase tracking-wider rounded"><?= $notice['type'] ?></span>
                                </div>
                                <h4 class="text-gray-800 font-medium font-inter mb-1 text-[13.5px] md:text-[14.5px] leading-snug notranslate"><?= htmlspecialchars($notice['title']) ?></h4>
                                <p class="text-[12px] text-gray-400 font-inter"><?= date('M d, Y', strtotime($notice['created_at'])) ?></p>
                            </div>
                            <a href="<?= $btnUrl ?>" target="<?= $btnTarget ?>"
                                class="border border-secondary text-secondary hover:bg-secondary hover:text-white text-[12px] font-semibold px-4 py-1.5 rounded-lg transition-all duration-200 text-center whitespace-nowrap font-inter shrink-0"><?= $btnText ?></a>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Institutions -->
<section class="py-20 md:py-28 px-4 md:px-16 bg-[#FAFAFA] border-t border-gray-100" id="affiliated-institutions">
    <div class="container mx-auto">
        <div class="mb-14">
            <p class="text-secondary font-normal text-xs md:text-sm uppercase tracking-[0.2em] mb-3 font-inter">
                Affiliated Bodies</p>
            <h2 class="section-title">
                Institutions</h2>
        </div>

        <div class="flex flex-col md:flex-row gap-8 lg:gap-12">
            <!-- Vertical Tabs -->
            <div class="w-full md:w-[32%] flex flex-col space-y-2.5 relative z-10">
                <button
                    class="group relative text-left px-6 py-4 bg-primary text-white font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 shadow-lg cursor-pointer focus:outline-none inst-tab-btn active overflow-hidden"
                    data-target="inst-dol">
                    <span class="relative z-10 flex items-center justify-between">Department of Labour <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-dme">
                    <span class="relative z-10 flex items-center justify-between">Department of Manpower and Employment <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-nils">
                    <span class="relative z-10 flex items-center justify-between">National Institute of Labour Studies <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-niosh">
                    <span class="relative z-10 flex items-center justify-between">National Institute of Occupational Safety and health <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
                <button
                    class="group relative text-left px-6 py-4 text-gray-600 bg-white hover:bg-gray-50 font-semibold text-[14.5px] rounded-2xl font-montserrat transition-all duration-300 border border-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer focus:outline-none inst-tab-btn"
                    data-target="inst-wc">
                    <span class="relative z-10 flex items-center justify-between">Office of the Commissioner for Workmen's Compensation <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg></span>
                </button>
            </div>

            <!-- Content Area -->
            <div class="w-full md:w-[68%]">
                <div class="bg-white rounded-[2rem] p-8 md:p-12 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] min-h-[450px] flex flex-col justify-start relative overflow-hidden transition-all duration-500">
                    <!-- Top accent line -->
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-secondary to-primary"></div>

                    <!-- Panel: Department of Labour (Active by default) -->
                    <div id="inst-panel-inst-dol" class="inst-panel transition-all duration-500 block animate-[fadeIn_0.4s_ease-out]">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Affiliated Body</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Department of Labour</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed mb-10">
                            <p>The Department of Labour was initially established to look into the welfare of Indian Immigrant Labour and was called the Department of Indian Immigrant Labour. Enactment of Indian Immigrant Labour Ordinance No. 1 of 1923 provided for the establishment of the Department of Indian Immigrant Labour.</p>
                            <p>However, with the gradual expansion of the indigenous segment of the labour force, labour perse became a force to be reckoned with. In these circumstances the colonial rulers were compelled to look beyond their limited scope of looking into the welfare of Indian Immigrant Labour and had to take measures for the welfare and well-being of all the workers alike. Accordingly, in 1931 the Department of Indian Immigrant Labour was transformed into the General Department of Labour - the state agency responsible for ensuring the welfare of both Indian Migrant Labour as well as indigenous labour. Initially the Head of the Department was designated as Controller of Labour, but in 1944 the Head was re-designated as Commissioner of Labour and year 2000 as Commissioner General of Labour.</p>
                        </div>
                        <a href="#" class="mt-4 inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-bold text-[13px] tracking-wider px-8 py-3.5 rounded-xl uppercase transition-all shadow-sm hover:shadow-md active:scale-95 w-fit">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: DME -->
                    <div id="inst-panel-inst-dme" class="inst-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Affiliated Body</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Department of Manpower and Employment</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed mb-10">
                            <p>The Department of Manpower and Employment is responsible for formulating and implementing national policies related to manpower planning, employment creation, and career guidance in Sri Lanka. It aims to develop a skilled workforce and facilitate employment opportunities for the youth.</p>
                            <p>Through its network of island-wide offices, the department offers career development initiatives, job matching platforms, and vocational guidance to empower job seekers and sustain local industry demand.</p>
                        </div>
                        <a href="#" class="mt-4 inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-bold text-[13px] tracking-wider px-8 py-3.5 rounded-xl uppercase transition-all shadow-sm hover:shadow-md active:scale-95 w-fit">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: NILS -->
                    <div id="inst-panel-inst-nils" class="inst-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Affiliated Body</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">National Institute of Labour Studies</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed mb-10">
                            <p>The National Institute of Labour Studies (NILS) is the premier state institution in Sri Lanka dedicated to providing education, training, and research in labour relations, human resource management, and employment law. It supports trade unions, public officers, and private sector employees in enhancing their skills and workplace harmony.</p>
                            <p>NILS conducts certificate and diploma courses tailored to labor dynamics, resolving industrial disputes, and establishing modern, productive employer-employee relationships across industries.</p>
                        </div>
                        <a href="#" class="mt-4 inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-bold text-[13px] tracking-wider px-8 py-3.5 rounded-xl uppercase transition-all shadow-sm hover:shadow-md active:scale-95 w-fit">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: NIOSH -->
                    <div id="inst-panel-inst-niosh" class="inst-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Affiliated Body</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">National Institute of Occupational Safety and health</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed mb-10">
                            <p>NIOSH Sri Lanka is tasked with executing research, generating safety reports, and formulating policies concerning occupational health and physical safety in commercial and manufacturing workspace environments.</p>
                            <p>By organizing vocational safety drills and safety compliance auditing programs, the institute helps domestic industries minimize hazard risks and comply with national factories ordinance mandates.</p>
                        </div>
                        <a href="#" class="mt-4 inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-bold text-[13px] tracking-wider px-8 py-3.5 rounded-xl uppercase transition-all shadow-sm hover:shadow-md active:scale-95 w-fit">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Panel: Workmen's Compensation Office -->
                    <div id="inst-panel-inst-wc" class="inst-panel hidden">
                        <div class="inline-block px-3 py-1 bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider rounded-lg mb-4">Affiliated Body</div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 font-montserrat tracking-tight">Office of the Commissioner for Workmen's Compensation</h3>
                        <div class="space-y-6 text-gray-600 text-[15px] font-inter leading-relaxed mb-10">
                            <p>This regulatory judicial body is tasked with arbitrating, registering, and distributing formal compensation claims arising from workplace physical injuries or accidental death in Sri Lanka.</p>
                            <p>The commissioner enforces compliance under the Workmen's Compensation Ordinance, ensuring employers distribute prompt and legal payouts to affected families.</p>
                        </div>
                        <a href="#" class="mt-4 inline-flex items-center space-x-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white font-bold text-[13px] tracking-wider px-8 py-3.5 rounded-xl uppercase transition-all shadow-sm hover:shadow-md active:scale-95 w-fit">
                            <span>Read More</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
