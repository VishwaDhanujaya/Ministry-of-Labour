<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

// Block editor access
if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'editor') {
    die('Unauthorized access');
}

require_once '../includes/officials-service.php';

$topOfficials = getTopOfficials($pdo);
$divisions = getDivisions($pdo);

$current_page = 'officials';
include 'includes/header.php'; 
?>
<!-- Include SortableJS for drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Officials & Contacts</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Manage ministry leadership, division heads, and contact list sort order.</p>
            </div>
            <button onclick="openModal('division', null)" class="bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm self-start sm:self-auto">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                Add Official
            </button>
        </div>

        <!-- Tab Navigation (iOS Pill Control) -->
        <div class="bg-slate-100/80 p-1.5 rounded-2xl border border-slate-200/40 mb-8 flex gap-1 overflow-x-auto whitespace-nowrap custom-scrollbar">
            <button type="button" onclick="switchTab('top')" class="tab-btn active px-6 py-2.5 text-[12.5px] font-bold rounded-xl transition-all duration-200 bg-white text-slate-800 shadow-[0_2px_8px_rgba(0,0,0,0.06)] border border-slate-200/30">
                Top Officials
            </button>
            <?php foreach ($divisions as $div): ?>
            <button type="button" onclick="switchTab('div-<?= $div['id_db'] ?? $div['id'] ?>')" class="tab-btn px-6 py-2.5 text-[12.5px] font-bold rounded-xl transition-all duration-200 text-slate-500 hover:text-slate-800" data-div-id="<?= $div['id_db'] ?? $div['id'] ?>">
                <?= htmlspecialchars($div['title']) ?>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Tab Contents -->
        
        <!-- Top Officials Tab -->
        <div id="tab-top" class="tab-content active">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($topOfficials as $official): 
                    // Calculate Initials
                    $words = explode(' ', $official['name']);
                    $initials = '';
                    foreach ($words as $w) {
                        if (preg_match('/^[A-Za-z]/', $w)) $initials .= strtoupper($w[0]);
                    }
                    $initials = substr($initials, 0, 2);
                ?>
                <div onclick="showPreviewModal(<?= $official['id'] ?>, '<?= htmlspecialchars(addslashes($official['name'])) ?>', 'top', <?= htmlspecialchars(json_encode($official, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_4px_12px_rgba(0,0,0,0.015)] hover:shadow-[0_12px_24px_-10px_rgba(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#13273F]/2 rounded-bl-full -mr-4 -mt-4 opacity-50 z-0"></div>
                    <span class="absolute top-4 right-4 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#13273F]/5 text-[#13273F] border border-[#13273F]/10 z-10">Top Official</span>
                    
                    <div class="text-center relative z-10 flex-1 flex flex-col items-center">
                        <!-- Avatar -->
                        <div class="relative w-28 h-28 mx-auto mb-5 shrink-0">
                            <?php if ($official['image_path'] && file_exists('../' . $official['image_path'])): ?>
                                <img src="../<?= htmlspecialchars($official['image_path']) ?>" class="w-full h-full rounded-full object-cover border-2 border-white shadow-md ring-2 ring-slate-100">
                            <?php else: ?>
                                <div class="w-full h-full rounded-full bg-gradient-to-tr from-[#13273F] to-[#254974] flex items-center justify-center border-2 border-white shadow-md ring-2 ring-slate-100">
                                    <span class="text-white font-extrabold text-xl font-montserrat">
                                        <?= htmlspecialchars($initials) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="text-base font-bold text-slate-800 tracking-tight leading-tight"><?= htmlspecialchars($official['name']) ?></h3>
                        <p class="text-[12px] text-slate-400 font-semibold mt-1 uppercase tracking-wider"><?= htmlspecialchars($official['title']) ?></p>
                        
                        <!-- Contact Detail Fields -->
                        <div class="w-full text-[12.5px] text-slate-600 mt-6 space-y-2.5 border-t border-slate-50 pt-5 text-left">
                            <?php if ($official['email']): ?>
                                <div class="flex items-center text-slate-500 hover:text-slate-800 transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                    <span class="truncate"><?= htmlspecialchars($official['email']) ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($official['phone']): ?>
                                <div class="flex items-center text-slate-500">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                                    <span><?= htmlspecialchars($official['phone']) ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($official['fax']): ?>
                                <div class="flex items-center text-slate-500">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path></svg>
                                    <span>Fax: <?= htmlspecialchars($official['fax']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Hidden Preview Content -->
                        <div id="preview-content-<?= $official['id'] ?>" class="hidden">
                            <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
                                <div class="w-32 h-32 shrink-0 relative">
                                    <?php if ($official['image_path'] && file_exists('../' . $official['image_path'])): ?>
                                        <img src="../<?= htmlspecialchars($official['image_path']) ?>" class="w-full h-full rounded-2xl object-cover border-2 border-white shadow-md ring-4 ring-slate-50">
                                    <?php else: ?>
                                        <div class="w-full h-full rounded-2xl bg-gradient-to-tr from-[#13273F] to-[#254974] flex items-center justify-center border-2 border-white shadow-md ring-4 ring-slate-50">
                                            <span class="text-white font-extrabold text-3xl font-montserrat">
                                                <?= htmlspecialchars($initials) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 text-center md:text-left mt-4 md:mt-0">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#13273F]/5 text-[#13273F] border border-[#13273F]/10 mb-3">Top Official</span>
                                    <h4 class="text-xl font-extrabold text-slate-800 leading-tight"><?= htmlspecialchars($official['name']) ?></h4>
                                    <p class="text-xs font-bold text-[#4E0000] uppercase tracking-wider mt-1.5"><?= htmlspecialchars($official['title']) ?></p>
                                    
                                    <div class="text-[13px] text-slate-600 mt-5 space-y-3 border-t border-slate-50 pt-5 text-left">
                                        <?php if ($official['email']): ?>
                                            <div class="flex items-center text-slate-500 hover:text-slate-800 transition-colors">
                                                <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                                <span><?= htmlspecialchars($official['email']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($official['phone']): ?>
                                            <div class="flex items-center text-slate-500">
                                                <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                                                <span><?= htmlspecialchars($official['phone']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($official['fax']): ?>
                                            <div class="flex items-center text-slate-500">
                                                <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path></svg>
                                                <span>Fax: <?= htmlspecialchars($official['fax']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between shrink-0 relative z-10" onclick="event.stopPropagation();">
                        <span class="text-[11px] text-slate-400 font-medium">Quick Actions</span>
                        <button onclick="openModal('top', <?= htmlspecialchars(json_encode($official)) ?>)" class="text-[#4E0000] hover:text-[#721c1c] text-[13px] font-bold flex items-center gap-1.5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                            Edit
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Division Tabs -->
        <?php foreach ($divisions as $div): ?>
        <div id="tab-div-<?= $div['id_db'] ?? $div['id'] ?>" class="tab-content hidden">
            <?php
            $headers = [
                ['label' => 'Order', 'class' => 'w-12 text-center'],
                ['label' => 'Avatar', 'class' => 'w-20'],
                ['label' => 'Name / Designation', 'class' => ''],
                ['label' => 'Contact Channels', 'class' => ''],
                ['label' => 'Actions', 'class' => 'text-right w-32']
            ];
            
            renderAdminTable($headers, $div['people'], function($person) use ($div) {
                // Calculate Initials
                $pWords = explode(' ', $person['name']);
                $personInitials = '';
                foreach ($pWords as $w) {
                    if (preg_match('/^[A-Za-z]/', $w)) $personInitials .= strtoupper($w[0]);
                }
                $personInitials = substr($personInitials, 0, 2);
                ?>
                <tr data-id="<?= $person['id'] ?>" onclick="showPreviewModal(<?= $person['id'] ?>, '<?= htmlspecialchars(addslashes($person['name'])) ?>', 'division', <?= htmlspecialchars(json_encode($person, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)" class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 cursor-pointer group">
                    <td class="py-4 px-6 text-slate-300 group-hover:text-slate-400 transition-colors cursor-move drag-handle text-center" onclick="event.stopPropagation();">
                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"></path></svg>
                    </td>
                    <td class="py-4 px-6">
                        <div class="w-10 h-10 rounded-full relative">
                            <?php if ($person['image_path']): ?>
                                <img src="../<?= htmlspecialchars($person['image_path']) ?>" class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-slate-100">
                            <?php else: ?>
                                <div class="w-full h-full rounded-full bg-gradient-to-tr from-[#13273F] to-[#254974] flex items-center justify-center border-2 border-white shadow-sm ring-1 ring-slate-100">
                                    <span class="text-white font-bold text-xs font-montserrat">
                                        <?= htmlspecialchars($personInitials) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-slate-800 text-[13.5px] group-hover:text-[#4E0000] transition-colors leading-tight"><?= htmlspecialchars($person['name']) ?></div>
                        <div class="text-[11.5px] text-slate-400 font-semibold uppercase tracking-wide mt-0.5"><?= htmlspecialchars($person['designation'] ?? $person['title']) ?></div>
                        
                        <!-- Hidden Preview Content -->
                        <div id="preview-content-<?= $person['id'] ?>" class="hidden">
                            <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
                                <div class="w-32 h-32 shrink-0 relative">
                                    <?php if ($person['image_path']): ?>
                                        <img src="../<?= htmlspecialchars($person['image_path']) ?>" class="w-full h-full rounded-2xl object-cover border-2 border-white shadow-md ring-4 ring-slate-55">
                                    <?php else: ?>
                                        <div class="w-full h-full rounded-2xl bg-gradient-to-tr from-[#13273F] to-[#254974] flex items-center justify-center border-2 border-white shadow-md ring-4 ring-slate-55">
                                            <span class="text-white font-extrabold text-3xl font-montserrat">
                                                <?= htmlspecialchars($personInitials) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 text-center md:text-left mt-4 md:mt-0">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#13273F]/5 text-[#13273F] border border-[#13273F]/10 mb-3"><?= htmlspecialchars($div['title']) ?></span>
                                    <h4 class="text-xl font-extrabold text-slate-800 leading-tight"><?= htmlspecialchars($person['name']) ?></h4>
                                    <p class="text-xs font-bold text-[#4E0000] uppercase tracking-wider mt-1.5"><?= htmlspecialchars($person['designation'] ?? $person['title']) ?></p>
                                    
                                    <div class="text-[13px] text-slate-600 mt-5 space-y-3 border-t border-slate-50 pt-5 text-left">
                                        <?php if ($person['email']): ?>
                                            <div class="flex items-center text-slate-500 hover:text-slate-800 transition-colors">
                                                <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                                <span><?= htmlspecialchars($person['email']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($person['phone']): ?>
                                            <div class="flex items-center text-slate-500">
                                                <svg class="w-4 h-4 mr-2.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                                                <span><?= htmlspecialchars($person['phone']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-[12.5px] text-slate-500 space-y-1">
                        <?php if ($person['email']): ?>
                            <div class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                <span class="truncate max-w-[220px] hover:text-slate-800 transition-colors"><?= htmlspecialchars($person['email']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($person['phone']): ?>
                            <div class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                                <span><?= htmlspecialchars($person['phone']) ?></span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-6 text-right" onclick="event.stopPropagation();">
                        <div class="flex items-center justify-end space-x-2">
                            <button onclick='openModal("division", <?= htmlspecialchars(json_encode($person), ENT_QUOTES, "UTF-8") ?>)' class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 flex items-center justify-center transition-all shadow-sm" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                            </button>
                            <button onclick="deleteOfficial(<?= $person['id'] ?>)" class="w-8.5 h-8.5 rounded-xl bg-rose-50/50 border border-rose-100/50 hover:bg-rose-50 hover:text-rose-600 text-rose-400 flex items-center justify-center transition-all shadow-sm" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
            }, [
                'minWidth' => '700px',
                'emptyTitle' => 'No officials registered',
                'emptySubtitle' => 'Add leadership personnel to display them on this division.',
                'emptyIcon' => 'users',
                'tableClass' => 'w-full text-left border-collapse min-w-[700px]',
                'containerClass' => 'bg-white rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] overflow-hidden',
                'tbodyClass' => 'divide-y divide-slate-50 sortable-list',
                'tbodyAttrs' => 'data-division-id="' . ($div['id_db'] ?? $div['id']) . '"'
            ]);
            ?>
        </div>
        <?php endforeach; ?>
    </main>
</div>

<!-- Modal Form -->
<div id="official-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col overflow-hidden border border-slate-100">
        <form id="official-form" onsubmit="saveOfficial(event)" class="flex flex-col max-h-[90vh] w-full">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 id="modal-title" class="text-lg font-bold text-slate-800 font-montserrat">Add Official</h3>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-4 text-xs flex-1 custom-scrollbar">
                <input type="hidden" id="field-id" name="id">
                <input type="hidden" id="field-category" name="category" value="division">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                <input type="hidden" id="field-top-role" name="top_role">
                
                <div id="division-select-container">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Division <span class="text-red-500">*</span></label>
                    <?php
                    $divOptions = [];
                    foreach ($divisions as $div) {
                        $divOptions[$div['id_db'] ?? $div['id']] = $div['title'];
                    }
                    echo renderDropdown([
                        'id' => 'field-division-id',
                        'name' => 'division_id',
                        'options' => $divOptions,
                        'placeholder' => false,
                        'context' => 'form',
                        'width' => 'w-full'
                    ]);
                    ?>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="field-name" name="name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input type="text" id="field-title" name="title" required placeholder="e.g. Director General" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                </div>

                <div id="designation-container">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Designation (Optional)</label>
                    <input type="text" id="field-designation" name="designation" placeholder="e.g. Additional Secretary (Admin)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Phone (Optional)</label>
                        <input type="text" id="field-phone" name="phone" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Fax (Optional)</label>
                        <input type="text" id="field-fax" name="fax" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Email (Optional)</label>
                    <input type="email" id="field-email" name="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Profile Image</label>
                    <!-- Current image preview (shown when editing) -->
                    <div id="current-image-preview" class="hidden mb-3 flex items-center gap-3 p-3 bg-slate-50 border border-slate-200/60 rounded-xl">
                        <img id="current-image-thumb" src="" alt="Current photo" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shadow-sm">
                        <div>
                            <p class="text-xs font-bold text-slate-700 leading-tight">Current photo</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Uploading a new photo will replace this.</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100/50 transition-all relative overflow-hidden group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                <svg class="w-8 h-8 mb-2 text-slate-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"></path></svg>
                                <p id="file-label-text" class="text-[12px] text-slate-500 font-bold">Click to upload photo</p>
                                <p class="text-[10px] text-slate-400 mt-1">WEBP, PNG or JPG (Max. 5MB)</p>
                            </div>
                            <input type="file" id="field-image" name="image" accept=".jpg,.jpeg,.png,.webp" class="hidden">
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-5 border-t border-slate-100 flex justify-end gap-3 bg-slate-50 rounded-b-2xl">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl text-[12.5px] font-bold transition-all">Cancel</button>
                <button type="submit" id="submit-btn" class="px-5 py-2.5 bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all">Save Official</button>
            </div>
        </form>
    </div>
</div>

<style>
.tab-content { display: none; }
.tab-content.active { display: block; }
.sortable-ghost { opacity: 0.3; background-color: #F8FAFC !important; border: 2px dashed #CBD5E1; }
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

<script>
// Tab Switching
let currentActiveTab = 'top';

function switchTab(tabId) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-white', 'text-slate-800', 'shadow-[0_2px_8px_rgba(0,0,0,0.06)]', 'border', 'border-slate-200/30');
        btn.classList.add('text-slate-500');
    });
    
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
        content.classList.add('hidden');
    });

    const activeBtn = event.currentTarget || document.querySelector(`.tab-btn[onclick*="switchTab('${tabId}')"]`);
    if (activeBtn) {
        activeBtn.classList.add('active', 'bg-white', 'text-slate-800', 'shadow-[0_2px_8px_rgba(0,0,0,0.06)]', 'border', 'border-slate-200/30');
        activeBtn.classList.remove('text-slate-500');
    }

    const activeContent = document.getElementById('tab-' + tabId);
    if (activeContent) {
        activeContent.classList.remove('hidden');
        activeContent.classList.add('active');
    }
    
    currentActiveTab = tabId;
}

// Modal Logic
function openModal(category, data = null) {
    document.getElementById('official-form').reset();
    document.getElementById('field-category').value = category;
    document.getElementById('file-label-text').textContent = 'Click to upload photo';
    
    if (data) {
        document.getElementById('modal-title').textContent = 'Edit Official';
        document.getElementById('field-id').value = data.id;
        document.getElementById('field-top-role').value = data.top_role || '';
        document.getElementById('field-name').value = data.name || '';
        document.getElementById('field-title').value = data.title || '';
        document.getElementById('field-designation').value = data.designation || '';
        document.getElementById('field-phone').value = data.phone || '';
        document.getElementById('field-fax').value = data.fax || '';
        document.getElementById('field-email').value = data.email || '';

        // Show current image preview if the official has an image
        const previewBox = document.getElementById('current-image-preview');
        const previewThumb = document.getElementById('current-image-thumb');
        if (data.image_path) {
            previewThumb.src = '../' + data.image_path;
            previewBox.classList.remove('hidden');
        } else {
            previewBox.classList.add('hidden');
            previewThumb.src = '';
        }

        if (data.division_id) {
            document.getElementById('field-division-id').value = data.division_id;
        }
    } else {
        document.getElementById('modal-title').textContent = 'Add Official';
        document.getElementById('field-id').value = '';
        document.getElementById('field-top-role').value = '';

        // Hide image preview for new officials
        document.getElementById('current-image-preview').classList.add('hidden');
        document.getElementById('current-image-thumb').src = '';

        // Auto-select division based on active tab
        if (currentActiveTab.startsWith('div-')) {
            document.getElementById('field-division-id').value = currentActiveTab.replace('div-', '');
        }
    }

    if (category === 'top') {
        document.getElementById('division-select-container').style.display = 'none';
        document.getElementById('designation-container').style.display = 'none';
    } else {
        document.getElementById('division-select-container').style.display = 'block';
        document.getElementById('designation-container').style.display = 'block';
    }

    const modal = document.getElementById('official-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    void modal.offsetWidth; // force reflow
    modal.classList.remove('opacity-0');
    modalBox.classList.remove('scale-95');
    modalBox.classList.add('scale-100');
}

function closeModal() {
    const modal = document.getElementById('official-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.add('opacity-0');
    modalBox.classList.remove('scale-100');
    modalBox.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Display uploaded filename in dropzone
document.getElementById('field-image').addEventListener('change', function() {
    const label = document.getElementById('file-label-text');
    if (this.files && this.files[0]) {
        label.textContent = 'Selected: ' + this.files[0].name;
    } else {
        label.textContent = 'Click to upload photo';
    }
});

// API Calls
async function saveOfficial(e) {
    e.preventDefault();
    
    if (typeof window.validateForm === 'function' && !window.validateForm(e.target)) {
        return;
    }
    
    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    const fileInput = document.getElementById('field-image');
    if (fileInput && fileInput.files && fileInput.files[0]) {
        const file = fileInput.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            if (typeof window.showToast === 'function') {
                window.showToast('Profile image size exceeds the maximum limit of 5MB.', 'error');
            } else {
                alert('Profile image size exceeds the maximum limit of 5MB.');
            }
            btn.disabled = false;
            btn.textContent = 'Save Official';
            return;
        }
    }

    const formData = new FormData(e.target);
    formData.append('action', 'save_official');

    try {
        const res = await fetch('officials-api', { method: 'POST', body: formData });
        const json = await res.json();
        
        if (json.success) {
            window.location.reload();
        } else {
            if (typeof window.showToast === 'function') {
                window.showToast(json.message || 'An error occurred.', 'error');
            } else {
                alert(json.message || 'An error occurred.');
            }
            btn.disabled = false;
            btn.textContent = 'Save Official';
        }
    } catch (err) {
        if (typeof window.showToast === 'function') {
            window.showToast('Network error.', 'error');
        } else {
            alert('Network error.');
        }
        btn.disabled = false;
        btn.textContent = 'Save Official';
    }
}

async function deleteOfficial(id) {
    window.showModal(
        'Delete Action',
        'Are you sure you want to delete this official?',
        'Delete',
        'bg-red-600 hover:bg-red-700',
        async function() {
            const formData = new FormData();
            formData.append('action', 'delete_official');
            formData.append('id', id);
            formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);

            try {
                const res = await fetch('officials-api', { method: 'POST', body: formData });
                const json = await res.json();

                if (json.success) {
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) row.remove();
                    
                    // Also check top cards grid
                    const topCards = document.querySelectorAll('.grid > div');
                    topCards.forEach(card => {
                        if (card.getAttribute('onclick') && card.getAttribute('onclick').includes(id)) {
                            card.remove();
                        }
                    });

                    if (typeof window.showToast === 'function') {
                        window.showToast('Official deleted successfully', 'success');
                    }
                } else {
                    if (typeof window.showToast === 'function') {
                        window.showToast(json.message || 'An error occurred.', 'error');
                    } else {
                        alert(json.message || 'An error occurred.');
                    }
                }
            } catch (err) {
                if (typeof window.showToast === 'function') {
                    window.showToast('Network error.', 'error');
                } else {
                    alert('Network error.');
                }
            }
        }
    );
}

// Initialize SortableJS for each division table
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.sortable-list').forEach(el => {
        new Sortable(el, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: async function (evt) {
                const itemEl = evt.item;
                const tbody = itemEl.closest('tbody');
                
                const orderedIds = Array.from(tbody.querySelectorAll('tr')).map(tr => tr.dataset.id);
                
                if (orderedIds.length > 0) {
                    const formData = new FormData();
                    formData.append('action', 'update_sort_order');
                    formData.append('order', JSON.stringify(orderedIds));
                    formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
                    
                    try {
                        const res = await fetch('officials-api', { method: 'POST', body: formData });
                        const json = await res.json();
                        if (!json.success) {
                             if (typeof window.showToast === 'function') {
                                 window.showToast(json.message || 'Failed to update order', 'error');
                             } else {
                                 alert(json.message || 'Failed to update order');
                             }
                         }
                    } catch (err) {
                        console.error('Network error during sort update');
                    }
                }
            }
        });
    });
});
</script>

<!-- Preview Modal -->
<div id="preview-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0 bg-black/40 backdrop-blur-sm">
    <div class="absolute inset-0" onclick="hidePreviewModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-0 transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col overflow-hidden border border-slate-100">
        <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50 shrink-0">
            <h3 id="preview-title" class="text-base font-bold font-montserrat text-slate-800 truncate pr-4">Official Profile</h3>
            <button onclick="hidePreviewModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100/60 p-1.5 rounded-lg transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div id="preview-content-container" class="text-xs text-slate-700 overflow-y-auto p-6 md:p-8 flex-1 custom-scrollbar"></div>
        <div class="flex justify-between items-center p-5 border-t border-slate-100 bg-slate-50/50 shrink-0">
            <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Quick Details</span>
            <div class="flex gap-2.5">
                <button id="preview-edit-btn" class="px-5 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-[12.5px] font-bold hover:bg-slate-50 transition-colors shadow-sm">Edit</button>
                <button id="preview-delete-btn" class="px-5 py-2 bg-rose-600 text-white rounded-xl text-[12.5px] font-bold hover:bg-rose-700 transition-colors shadow-sm">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
let activePreviewCategory = null;
let activePreviewData = null;

function showPreviewModal(id, title, category, itemData) {
    document.getElementById('preview-content-container').innerHTML = document.getElementById('preview-content-' + id).innerHTML;
    activePreviewCategory = category;
    activePreviewData = itemData;
    
    const modal = document.getElementById('preview-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    void modal.offsetWidth; // trigger reflow
    modal.classList.remove('opacity-0');
    modalBox.classList.remove('scale-95');
    modalBox.classList.add('scale-100');
}

function hidePreviewModal() {
    const modal = document.getElementById('preview-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.add('opacity-0');
    modalBox.classList.remove('scale-100');
    modalBox.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

document.getElementById('preview-edit-btn').addEventListener('click', function() {
    if (activePreviewData) {
        hidePreviewModal();
        openModal(activePreviewCategory, activePreviewData);
    }
});

document.getElementById('preview-delete-btn').addEventListener('click', function() {
    if (activePreviewData) {
        hidePreviewModal();
        deleteOfficial(activePreviewData.id);
    }
});
</script>

<?php include 'includes/footer.php'; ?>
