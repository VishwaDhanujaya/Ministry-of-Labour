<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$current_page = "manage-statistics";
$error = '';
$success = '';

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    requireCsrfToken('POST', 'post');
    $action = $_POST['action'];
    
    if ($action === 'edit') {
        $edit_id = (int)($_POST['stat_id'] ?? 0);
        $new_value = trim($_POST['stat_value'] ?? '');
        $new_suffix = trim($_POST['stat_suffix'] ?? '');
        
        if ($edit_id <= 0) {
            $error = "Invalid statistic ID.";
        } elseif ($new_value === '') {
            $error = "Value is required.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id FROM statistics WHERE id = ?");
                $stmt->execute([$edit_id]);
                $existing = $stmt->fetch();
                
                if (!$existing) {
                    $error = "Statistic not found.";
                } else {
                    $stmt = $pdo->prepare("UPDATE statistics SET stat_value = ?, stat_suffix = ? WHERE id = ?");
                    if ($stmt->execute([$new_value, $new_suffix, $edit_id])) {
                        $success = "Statistic updated successfully.";
                    } else {
                        $error = "Failed to update statistic.";
                    }
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Fetch statistics
try {
    $stmt = $pdo->query("SELECT * FROM statistics ORDER BY display_order ASC");
    $statistics = $stmt->fetchAll();
} catch (PDOException $e) {
    $statistics = [];
    $error = "Table 'statistics' does not exist yet. Please execute the SQL commands first.";
}

// Icon mapper for brand styling
function getStatIcon($key) {
    switch ($key) {
        case 'ilo_conventions':
            return '<svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>';
        case 'labour_acts':
            return '<svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>';
        case 'affiliated_institutions':
            return '<svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>';
        case 'total_visitors':
            return '<svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>';
        default:
            return '<svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>';
    }
}

// Visitor count auto-formatter (matches home page logic)
function formatVisitorCount($val) {
    if (is_numeric($val)) {
        $num = (int)$val;
        if ($num >= 1000000) {
            return round($num / 1000000, 1) . 'M';
        } elseif ($num >= 1000) {
            return round($num / 1000, 1) . 'K';
        }
    }
    return $val;
}

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage Home Page Statistics</h2>
            <p class="text-[13px] text-slate-500 mt-1 font-inter">Monitor live counts and customize counters displaying on the public portal.</p>
        </div>

        <!-- Success & Error Alert Banners -->
        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 flex items-center gap-3 text-xs font-semibold shadow-sm animate-fadeIn">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 flex items-center gap-3 text-xs font-semibold shadow-sm animate-fadeIn">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Info Alert: How Statistics Work -->
        <div class="mb-8 p-6 bg-white border border-slate-100 rounded-2xl flex flex-col md:flex-row items-start gap-4 shadow-[0_4px_16px_rgba(0,0,0,0.015)] font-inter">
            <div class="w-10 h-10 rounded-xl bg-[#4E0000]/5 text-[#4E0000] flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.063.852l-.708.283a.75.75 0 00-.475.692v.334m-.375 2.25h.007v.008H12v-.008zM12 3c7.243 0 12 4.757 12 12s-4.757 12-12 12S0 22.243 0 15 4.757 3 12 3z"></path></svg>
            </div>
            <div class="text-[12.5px] text-slate-600 leading-relaxed">
                <p class="font-bold text-[#4E0000] text-sm mb-1">Portal Statistics Note</p>
                <ul class="list-disc pl-5 space-y-1 text-slate-500">
                    <li><strong>Total Visitors Counter (Automated):</strong> This metric tracks unique portal sessions dynamically and increments automatically. When it exceeds 999, the portal formats it into thousands (<code>K</code>) or millions (<code>M</code>) syntax (e.g. database value of <code>1250</code> displays as <code>1.3K</code>).</li>
                    <li><strong>Other Counters (Manual):</strong> (ILO Conventions, Labour Acts, Affiliated Institutions) are manually updated and display exactly as saved.</li>
                    <li><strong>Suffixes:</strong> Custom suffixes (such as <code>+</code> or <code>%</code>) can be saved to append directly after the number.</li>
                </ul>
            </div>
        </div>

        <!-- Live Preview Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <?php foreach ($statistics as $stat): 
                $displayValue = $stat['stat_value'];
                $displaySuffix = $stat['stat_suffix'];
                if ($stat['stat_key'] === 'total_visitors' && is_numeric($displayValue)) {
                    $num = (int)$displayValue;
                    if ($num >= 1000000) {
                        $displayValue = round($num / 1000000, 1);
                        $displaySuffix = 'M' . $displaySuffix;
                    } elseif ($num >= 1000) {
                        $displayValue = round($num / 1000, 1);
                        $displaySuffix = 'K' . $displaySuffix;
                    }
                }
            ?>
                <div onclick='openEditModal(<?= json_encode($stat, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' 
                     class="bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_4px_16px_rgba(0,0,0,0.015)] hover:shadow-[0_12px_24px_-10px_rgba(0,0,0,0.08)] hover:-translate-y-1 transform transition-all duration-300 flex flex-col justify-between min-h-[190px] cursor-pointer group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#13273F]/2 rounded-bl-full -mr-4 -mt-4 opacity-50 z-0"></div>
                    
                    <div class="flex justify-between items-start mb-3 relative z-10 w-full">
                        <div class="w-12 h-12 bg-slate-50 text-[#13273F] rounded-xl flex items-center justify-center border border-slate-100 shadow-sm transition-all group-hover:bg-[#13273F] group-hover:text-white">
                            <?= getStatIcon($stat['stat_key']) ?>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <?php if ($stat['stat_key'] === 'total_visitors'): ?>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-[#13273F]/5 text-[#13273F] border border-[#13273F]/10 font-mono">Automated</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/5 text-amber-700 border border-amber-500/10 font-mono">Manual</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <div class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight flex items-baseline gap-0.5">
                            <span><?= htmlspecialchars($displayValue) ?></span>
                            <span class="text-teal-600 font-bold text-xl ml-0.5"><?= htmlspecialchars($displaySuffix) ?></span>
                        </div>
                        <p class="text-[12px] font-bold text-slate-400 mt-1 uppercase tracking-wider font-inter leading-none"><?= htmlspecialchars($stat['stat_label']) ?></p>
                        <p class="text-[10px] text-slate-300 font-mono mt-1">Raw DB: <?= htmlspecialchars($stat['stat_value']) ?><?= htmlspecialchars($stat['stat_suffix']) ?></p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between text-[11px] text-slate-400 group-hover:text-[#4E0000] transition-colors font-inter relative z-10 shrink-0">
                        <span>Click to update counter</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.89h2.25m-2.25 4.5h2.25m-3.83 5.06l3.29-3.29M3 20V4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1z"></path></svg>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Edit Modal -->
        <div id="statModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
            <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeModal()"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col border border-slate-100">
                <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50 shrink-0">
                    <h3 class="text-lg font-bold font-montserrat text-slate-800 flex items-center">
                        <div class="w-8.5 h-8.5 rounded-xl bg-[#4E0000]/5 text-[#4E0000] flex items-center justify-center mr-2.5 border border-[#4E0000]/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"></path></svg>
                        </div>
                        Edit Count & Suffix
                    </h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                    <form id="statForm" action="" method="POST" class="js-validate-form space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="stat_id" id="modalStatId" value="">
                        
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Statistic Name</label>
                            <input type="text" id="modalStatLabel" readonly class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-[13px] text-slate-400 font-bold uppercase tracking-wider cursor-not-allowed font-inter">
                        </div>

                        <div class="grid grid-cols-2 gap-4 font-inter">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Count Value <span class="text-red-500">*</span></label>
                                <input type="number" name="stat_value" id="modalStatValue" required placeholder="e.g. 5, 32, 1250" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 font-mono transition-all font-semibold">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Suffix</label>
                                <input type="text" name="stat_suffix" id="modalStatSuffix" placeholder="e.g. +, %" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 font-mono transition-all font-semibold">
                            </div>
                        </div>

                        <!-- Real-time Preview in Modal -->
                        <div class="mt-6 pt-6 border-t border-slate-100 font-inter">
                            <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Live Portal Preview</h4>
                            
                            <div class="bg-white rounded-2xl p-5 border border-slate-100 flex items-center justify-between shadow-sm relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-[#13273F]/2 rounded-bl-full opacity-50"></div>
                                <div class="flex items-center gap-4 relative z-10">
                                    <div class="w-11 h-11 bg-slate-50 text-[#13273F] rounded-xl flex items-center justify-center border border-slate-100" id="modalPreviewIcon">
                                        <!-- Dynamic Icon -->
                                    </div>
                                    <div>
                                        <div class="text-2xl font-extrabold font-montserrat text-slate-800 flex items-baseline gap-0.5">
                                            <span id="modalPreviewValue">0</span>
                                            <span id="modalPreviewSuffix" class="text-teal-600 font-semibold text-lg"></span>
                                        </div>
                                        <p id="modalPreviewLabel" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5 font-inter leading-none"></p>
                                    </div>
                                </div>
                                <span class="text-[9px] uppercase font-bold tracking-widest bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded border border-emerald-100 shrink-0 relative z-10">Live Preview</span>
                            </div>
                        </div>

                        <div class="pt-5 flex justify-end gap-3 border-t border-slate-100 mt-6 font-inter shrink-0">
                            <button type="button" onclick="closeModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-[12.5px] font-bold hover:bg-slate-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        let currentStatKey = '';

        function openEditModal(stat) {
            currentStatKey = stat.stat_key;
            
            document.getElementById('modalStatId').value = stat.id;
            document.getElementById('modalStatLabel').value = stat.stat_label;
            document.getElementById('modalStatValue').value = stat.stat_value;
            document.getElementById('modalStatSuffix').value = stat.stat_suffix || '';
            
            // Set static details in preview
            document.getElementById('modalPreviewLabel').textContent = stat.stat_label;
            
            // Map static preview icons
            const iconContainer = document.getElementById('modalPreviewIcon');
            iconContainer.innerHTML = getJsStatIcon(stat.stat_key);
            
            // Update preview values initially
            updateLivePreview();
            
            const modal = document.getElementById('statModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }

        function getJsStatIcon(key) {
            switch (key) {
                case 'ilo_conventions':
                    return '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>';
                case 'labour_acts':
                    return '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>';
                case 'affiliated_institutions':
                    return '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>';
                case 'total_visitors':
                    return '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>';
                default:
                    return '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>';
            }
        }

        function updateLivePreview() {
            let val = document.getElementById('modalStatValue').value.trim();
            let suffix = document.getElementById('modalStatSuffix').value;
            
            if (val === '') {
                val = '0';
            }
            
            // Format visitor count dynamically to K/M notation in preview
            if (currentStatKey === 'total_visitors' && !isNaN(val)) {
                let num = parseInt(val, 10);
                if (num >= 1000000) {
                    val = (num / 1000000).toFixed(1).replace(/\.0$/, '');
                    suffix = 'M' + suffix;
                } else if (num >= 1000) {
                    val = (num / 1000).toFixed(1).replace(/\.0$/, '');
                    suffix = 'K' + suffix;
                }
            }
            
            document.getElementById('modalPreviewValue').textContent = val;
            document.getElementById('modalPreviewSuffix').textContent = suffix;
        }

        // Live update on input changes
        document.getElementById('modalStatValue').addEventListener('input', updateLivePreview);
        document.getElementById('modalStatSuffix').addEventListener('input', updateLivePreview);

        function closeModal() {
            const modal = document.getElementById('statModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.add('opacity-0');
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
        </script>
    </main>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.25s ease-out forwards;
}
.custom-scrollbar::-webkit-scrollbar {
    height: 5px;
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #E2E8F0;
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #CBD5E1;
}
</style>

<?php include 'includes/footer.php'; ?>
