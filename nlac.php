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
        <div id="table-employer" class="tu-table overflow-x-auto mb-12 rounded-xl border border-gray-200">
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
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">01</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Vajira Ellepola</td>
                        <td class="py-3 px-4">Director General</td>
                        <td class="py-3 px-4">Employers' Federation of Ceylon</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">02</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Adhil Khasim</td>
                        <td class="py-3 px-4">Deputy Director General</td>
                        <td class="py-3 px-4">Employers' Federation of Ceylon</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">03</td>
                        <td class="py-3 px-4">Ms</td>
                        <td class="py-3 px-4">Kirthana Krishnakumar (AAL)</td>
                        <td class="py-3 px-4">Senior Legal Counsel, Group Legal Department & Vice President</td>
                        <td class="py-3 px-4">John Keells Group</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">04</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Jayendra de Silva</td>
                        <td class="py-3 px-4">General Manager- Group Human Resource Management</td>
                        <td class="py-3 px-4">Hayleys PLC</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">05</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Suresh Noel Muttiah</td>
                        <td class="py-3 px-4">Group Chief Human Resources Officer</td>
                        <td class="py-3 px-4">Aitken Spence Corporate Finance (pvt) Ltd</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">06</td>
                        <td class="py-3 px-4">Ms</td>
                        <td class="py-3 px-4">Geetha Yasanayake</td>
                        <td class="py-3 px-4">Group Chief HR Officer</td>
                        <td class="py-3 px-4">Cargills (Ceylon) Plc</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">07</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Dhammika Fernando</td>
                        <td class="py-3 px-4">Chairman</td>
                        <td class="py-3 px-4">Free Trade Zone Manufacturers' Association</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">08</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Charaka Gunawardana</td>
                        <td class="py-3 px-4">Director- Human Resources and Sustainable Business</td>
                        <td class="py-3 px-4">MAS Active</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">09</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Shiran Fernando</td>
                        <td class="py-3 px-4">Chief Economic Policy Advisor</td>
                        <td class="py-3 px-4">The Ceylon Chamber of Commerce</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">10</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Hemantha Balasuriya</td>
                        <td class="py-3 px-4">Hony. Secretary</td>
                        <td class="py-3 px-4">Sri Lanka Food Processors Association (SLFPA)</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">11</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Lalith Obeyesekere</td>
                        <td class="py-3 px-4">Secretary General</td>
                        <td class="py-3 px-4">The Planters' Association of Ceylon</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">12</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Yohan Lawrence</td>
                        <td class="py-3 px-4">Secretary General</td>
                        <td class="py-3 px-4">Joint Apparel Association Forum</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">13</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Sampath Jayasundara</td>
                        <td class="py-3 px-4">SLASSCOM Director/ CEO/Director-hSenid Business Solutions</td>
                        <td class="py-3 px-4">Sri Lanka Association of Software and Services Companies (SLASSCOM)</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">14</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">M.D.S Hemantha Kumara Perera</td>
                        <td class="py-3 px-4">Secretary General</td>
                        <td class="py-3 px-4">Sri Lanka Chamber of Garment Association</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">15</td>
                        <td class="py-3 px-4">Capt.</td>
                        <td class="py-3 px-4">Lal Tennekoon</td>
                        <td class="py-3 px-4">Senior Assistant Secretary General</td>
                        <td class="py-3 px-4">Chamber of Construction Industry of Sri Lanka</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">16</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">H.T Chaminda</td>
                        <td class="py-3 px-4">Vice President - Human Resources</td>
                        <td class="py-3 px-4">Associated CEAT (pvt) Ltd</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">17</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Kavinda Rajapaksha</td>
                        <td class="py-3 px-4">Senior Deputy President</td>
                        <td class="py-3 px-4">National Chamber of Commerce Sri Lanka</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Employee Trade Unions -->
        <div id="table-employee" class="tu-table hidden overflow-x-auto mb-12 rounded-xl border border-gray-200">
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
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">01</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">S.Rajamany</td>
                        <td class="py-3 px-4">Vice President</td>
                        <td class="py-3 px-4">Ceylon Workers’ Congress</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">02</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Vadivel Suresh</td>
                        <td class="py-3 px-4">General Secretary</td>
                        <td class="py-3 px-4">Lanka Jathika Estate Workers Union</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">03</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Leslie Devendra</td>
                        <td class="py-3 px-4">General Secretary</td>
                        <td class="py-3 px-4">Sri Lanka Nidahas Sewaka Sangamaya</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">04</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">S.Ramanathan</td>
                        <td class="py-3 px-4">Secretary General</td>
                        <td class="py-3 px-4">Joint Plantation Trade Union Centre</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">05</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Channa Sirinath Dissanayake</td>
                        <td class="py-3 px-4">President</td>
                        <td class="py-3 px-4">Ceylon Bank Employees Union</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">06</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">G.D. Indika Pushpakumara</td>
                        <td class="py-3 px-4">General Secretary</td>
                        <td class="py-3 px-4">Jathika Sewaka Sangamaya</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">07</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Amarapala Gamage</td>
                        <td class="py-3 px-4">National Organizer/Senior Vice President</td>
                        <td class="py-3 px-4">Podujana Pragathasheeli Sewaka Sangamaya</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">08</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Palitha Athukorale</td>
                        <td class="py-3 px-4">Chairman</td>
                        <td class="py-3 px-4">National Union of Seafarer Sri Lanka</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">09</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Nishantha Wanniarachchi</td>
                        <td class="py-3 px-4">President</td>
                        <td class="py-3 px-4">Ceylon Estate Staffs’ Union</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">10</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Warahena Liyanage Don Marcus</td>
                        <td class="py-3 px-4">Member</td>
                        <td class="py-3 px-4">Free Trade Zones and General Services Employees Union</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">11</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">J.M.A Premarathna</td>
                        <td class="py-3 px-4">Secretary</td>
                        <td class="py-3 px-4">All Ceylon Estate Workers Union</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">12</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Prasanga Medawatte</td>
                        <td class="py-3 px-4">President</td>
                        <td class="py-3 px-4">All Ceylon Port Public Employees’ Union</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">13</td>
                        <td class="py-3 px-4">Ms</td>
                        <td class="py-3 px-4">Lalitha Ranjani Dedduwakumara</td>
                        <td class="py-3 px-4">Chief Organizer</td>
                        <td class="py-3 px-4">Textile, Garment and Clothing Workers Union (TGCWU) <span class="text-xs text-gray-400 block font-normal font-sans">නිමි භාණ්ඩ ඇඟළුම් හා රෙදිපිළි සේවක සංගමය</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">14</td>
                        <td class="py-3 px-4">Ms</td>
                        <td class="py-3 px-4">P.K Chamila Thushari</td>
                        <td class="py-3 px-4">Secretary</td>
                        <td class="py-3 px-4">Dabindu Collective</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">15</td>
                        <td class="py-3 px-4">Ms</td>
                        <td class="py-3 px-4">Eranga Amali Kalupahana</td>
                        <td class="py-3 px-4">President</td>
                        <td class="py-3 px-4">Centre for Working Women</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">16</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Amal Wedage</td>
                        <td class="py-3 px-4">Deputy General Secretary</td>
                        <td class="py-3 px-4">Ceylon Federation of Trade Unions</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">17</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">Janaka Adhikari (AAL)</td>
                        <td class="py-3 px-4">General Secretary</td>
                        <td class="py-3 px-4">Inter Company Employees Union</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4">18</td>
                        <td class="py-3 px-4">Mr</td>
                        <td class="py-3 px-4">K.S Munasinghe</td>
                        <td class="py-3 px-4">Co-Secretary</td>
                        <td class="py-3 px-4">All Ceylon Transport Employees Union</td>
                    </tr>
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

        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 max-w-lg">
            <h3 class="text-xl font-bold text-primary font-montserrat mb-4 flex items-center gap-3 notranslate">
                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span><?= t('contact_info_title', 'Contact Information') ?></span>
            </h3>
            <p class="text-gray-800 font-bold font-inter text-[15px] mb-1">Mr. B Vasanthan</p>
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
