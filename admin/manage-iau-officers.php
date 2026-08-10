<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

// Block unauthorized users
requirePermission("manage_iau");

// Fetch officers
$stmt = $pdo->query("SELECT * FROM `iau_officers` ORDER BY sort_order ASC");
$officers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'IAU Officers';
$current_page = 'manage-iau-officers';
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
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">IAU Officers</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Manage Internal Affairs Unit contact information and drag to sort the display order.</p>
            </div>
            <button onclick="openModal()" class="bg-gradient-to-r from-secondary to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm self-start sm:self-auto gap-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Add IAU Officer
            </button>
        </div>

        <!-- IAU Officers List Table -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] overflow-hidden">
            <div class="overflow-x-auto min-w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100/80 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6 w-12 text-center">Order</th>
                            <th class="py-4 px-6 w-1/4">Title / Department</th>
                            <th class="py-4 px-6 w-1/4">Name / Designation</th>
                            <th class="py-4 px-6 w-1/4">Contact info</th>
                            <th class="py-4 px-6 w-28 text-center">Status</th>
                            <th class="py-4 px-6 w-32 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 sortable-list" id="officers-sortable-list">
                        <?php if (empty($officers)): ?>
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <h4 class="text-sm font-bold text-slate-700">No IAU officers found</h4>
                                    <p class="text-xs text-slate-400 mt-1">Click the button above to add the first officer.</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($officers as $officer): ?>
                            <tr data-id="<?= $officer['id'] ?>" class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group">
                                <td class="py-4 px-6 text-slate-300 group-hover:text-slate-400 transition-colors cursor-move drag-handle text-center">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"></path></svg>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-800 text-[13.5px] leading-tight"><?= htmlspecialchars($officer['title']) ?></div>
                                    <?php if ($officer['department']): ?>
                                    <div class="text-[11.5px] text-slate-400 font-semibold uppercase tracking-wide mt-0.5"><?= htmlspecialchars($officer['department']) ?></div>
                                    <?php else: ?>
                                    <div class="text-[11.5px] text-slate-300 italic font-medium mt-0.5">No Department</div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-800 text-[13.5px] leading-tight"><?= htmlspecialchars($officer['name']) ?></div>
                                    <div class="text-[11.5px] text-slate-400 font-semibold uppercase tracking-wide mt-0.5"><?= htmlspecialchars($officer['designation']) ?></div>
                                </td>
                                <td class="py-4 px-6 text-[12.5px] text-slate-500 space-y-1">
                                    <?php if ($officer['email']): ?>
                                        <div class="flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                            <span class="truncate max-w-[220px] hover:text-slate-800 transition-colors"><?= htmlspecialchars($officer['email']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($officer['phone']): ?>
                                        <div class="flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.117-6.942-6.942l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                                            <span><?= htmlspecialchars($officer['phone']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleActive(<?= $officer['id'] ?>)" class="inline-flex items-center justify-center">
                                        <?php $status_badge_class = $officer['is_active'] ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' : 'bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100'; ?>
                                        <span id="status-badge-<?= $officer['id'] ?>" class="px-2.5 py-1 text-[11px] font-bold rounded-md border shadow-sm transition-all duration-150 <?= $status_badge_class ?>">
                                            <?= $officer['is_active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </button>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button onclick='openModal(<?= htmlspecialchars(json_encode($officer), ENT_QUOTES, "UTF-8") ?>)' class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 flex items-center justify-center transition-all shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                        </button>
                                        <button onclick="deleteOfficer(<?= $officer['id'] ?>)" class="w-8.5 h-8.5 rounded-xl bg-rose-50/50 border border-rose-100/50 hover:bg-rose-50 hover:text-rose-600 text-rose-400 flex items-center justify-center transition-all shadow-sm" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Form -->
<div id="officer-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col overflow-hidden border border-slate-100">
        <form id="officer-form" onsubmit="saveOfficer(event)" class="flex flex-col max-h-[90vh] w-full">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-gray-50/50">
                <h3 id="modal-title" class="text-lg font-bold text-slate-800 font-montserrat">Add IAU Officer</h3>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-4 text-xs flex-1 custom-scrollbar">
                <input type="hidden" id="field-id" name="id">
                <input type="hidden" name="action" value="save_officer">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

                <!-- Language Tabs Header -->
                <div class="flex items-center justify-between mb-4 gap-2 flex-wrap sm:flex-nowrap">
                    <div class="inline-flex p-1 bg-slate-100/80 backdrop-blur-md rounded-2xl shadow-inner border border-slate-200/40 shrink-0">
                        <button type="button" onclick="switchLangTab('en')" id="lang-tab-btn-en" class="px-5 py-2 text-[12.5px] font-bold rounded-xl text-secondary bg-white shadow-sm transition-all focus:outline-none">
                            English
                        </button>
                        <button type="button" onclick="switchLangTab('si')" id="lang-tab-btn-si" class="px-5 py-2 text-[12.5px] font-semibold rounded-xl text-slate-500 hover:text-slate-800 transition-all focus:outline-none">
                            Sinhala
                        </button>
                        <button type="button" onclick="switchLangTab('ta')" id="lang-tab-btn-ta" class="px-5 py-2 text-[12.5px] font-semibold rounded-xl text-slate-500 hover:text-slate-800 transition-all focus:outline-none">
                            Tamil
                        </button>
                    </div>
                    <button type="button" onclick="autoTranslateAll()" id="translate-all-btn" class="text-[12px] bg-blue-50 text-blue-600 px-3.5 py-2 rounded-xl border border-blue-100 hover:bg-blue-100 transition-all flex items-center gap-1 font-bold shadow-sm cursor-pointer shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138A14.37 14.37 0 009 5.25M9 5.25a14.368 14.368 0 01-3.666 3.614m1.86 7.139a11.385 11.385 0 01-4.7-3.614"></path></svg>
                        Auto Translate
                    </button>
                </div>

                <!-- Tab 1: English -->
                <div id="lang-tab-pane-en" class="space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Title (Role in IAU) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-title" name="title" placeholder="e.g. Member / Head of the IAU" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Department / Division / Organization (Optional)</label>
                        <input type="text" id="field-department" name="department" placeholder="e.g. Shrama Vasana Fund / Planning Division" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="field-name" name="name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Designation (Main Post) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-designation" name="designation" placeholder="e.g. Accountant / Deputy Director" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                </div>

                <!-- Tab 2: Sinhala -->
                <div id="lang-tab-pane-si" class="hidden space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Title (Sinhala) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-title-si" name="title_si" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-sinhala">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Department / Division / Org (Sinhala)</label>
                        <input type="text" id="field-department-si" name="department_si" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-sinhala">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Full Name (Sinhala) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-name-si" name="name_si" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-sinhala">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Designation (Sinhala) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-designation-si" name="designation_si" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-sinhala">
                    </div>
                </div>

                <!-- Tab 3: Tamil -->
                <div id="lang-tab-pane-ta" class="hidden space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Title (Tamil) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-title-ta" name="title_ta" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-tamil">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Department / Division / Org (Tamil)</label>
                        <input type="text" id="field-department-ta" name="department_ta" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-tamil">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Full Name (Tamil) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-name-ta" name="name_ta" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-tamil">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Designation (Tamil) <span class="text-red-500">*</span></label>
                        <input type="text" id="field-designation-ta" name="designation_ta" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium font-tamil">
                    </div>
                </div>
                
                <div class="border-t border-slate-100 mt-4 pt-4"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Phone (Optional)</label>
                        <input type="text" id="field-phone" name="phone" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Email (Optional)</label>
                        <input type="text" id="field-email" name="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 transition-all font-medium">
                    </div>
                </div>
            </div>

            <div class="p-5 border-t border-slate-100 flex justify-end gap-3 bg-slate-50 rounded-b-2xl">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl text-[12.5px] font-bold transition-all">Cancel</button>
                <button type="submit" id="submit-btn" class="px-5 py-2.5 bg-gradient-to-r from-secondary to-[#721c1c] text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all">Save Officer</button>
            </div>
        </form>
    </div>
</div>

<style>
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
let activeLang = 'en';

// Translation Utilities
async function translateText(text, fromLang, toLang) {
    if (!text) return '';
    const res = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=${fromLang}&tl=${toLang}&dt=t&q=${encodeURIComponent(text)}`);
    const data = await res.json();
    return data[0].map(x => x[0]).join('');
}

async function autoTranslateAll() {
    const titleEn = document.getElementById('field-title').value.trim();
    const deptEn = document.getElementById('field-department').value.trim();
    const nameEn = document.getElementById('field-name').value.trim();
    const desigEn = document.getElementById('field-designation').value.trim();

    if (!titleEn && !deptEn && !nameEn && !desigEn) {
        showToast('Please enter English values to translate.', 'warning');
        return;
    }

    const translateBtn = document.getElementById('translate-all-btn');
    const originalText = translateBtn.innerHTML;
    translateBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Translating...';
    translateBtn.disabled = true;

    try {
        if (titleEn) {
            const titleSi = await translateText(titleEn, 'en', 'si');
            document.getElementById('field-title-si').value = titleSi;
            
            const titleTa = await translateText(titleEn, 'en', 'ta');
            document.getElementById('field-title-ta').value = titleTa;
        }
        if (deptEn) {
            const deptSi = await translateText(deptEn, 'en', 'si');
            document.getElementById('field-department-si').value = deptSi;
            
            const deptTa = await translateText(deptEn, 'en', 'ta');
            document.getElementById('field-department-ta').value = deptTa;
        }
        if (nameEn) {
            const nameSi = await translateText(nameEn, 'en', 'si');
            document.getElementById('field-name-si').value = nameSi;
            
            const nameTa = await translateText(nameEn, 'en', 'ta');
            document.getElementById('field-name-ta').value = nameTa;
        }
        if (desigEn) {
            const desigSi = await translateText(desigEn, 'en', 'si');
            document.getElementById('field-designation-si').value = desigSi;
            
            const desigTa = await translateText(desigEn, 'en', 'ta');
            document.getElementById('field-designation-ta').value = desigTa;
        }
        showToast('Fields translated successfully!', 'success');
    } catch (err) {
        showToast('Translation failed. Please try again or enter manually.', 'error');
        console.error(err);
    } finally {
        translateBtn.innerHTML = originalText;
        translateBtn.disabled = false;
    }
}

function switchLangTab(lang) {
    activeLang = lang;
    ['en', 'si', 'ta'].forEach(l => {
        const btn = document.getElementById('lang-tab-btn-' + l);
        const pane = document.getElementById('lang-tab-pane-' + l);
        if (l === lang) {
            btn.classList.add('bg-white', 'text-secondary', 'shadow-sm');
            btn.classList.remove('text-slate-500', 'font-semibold');
            btn.classList.add('font-bold');
            pane.classList.remove('hidden');
        } else {
            btn.classList.remove('bg-white', 'text-secondary', 'shadow-sm', 'font-bold');
            btn.classList.add('text-slate-500', 'font-semibold');
            pane.classList.add('hidden');
        }
    });
}

function openModal(data = null) {
    document.getElementById('officer-form').reset();
    switchLangTab('en');
    
    if (data) {
        document.getElementById('modal-title').textContent = 'Edit IAU Officer';
        document.getElementById('field-id').value = data.id;
        
        document.getElementById('field-title').value = data.title || '';
        document.getElementById('field-title-si').value = data.title_si || '';
        document.getElementById('field-title-ta').value = data.title_ta || '';
        
        document.getElementById('field-department').value = data.department || '';
        document.getElementById('field-department-si').value = data.department_si || '';
        document.getElementById('field-department-ta').value = data.department_ta || '';

        document.getElementById('field-name').value = data.name || '';
        document.getElementById('field-name-si').value = data.name_si || '';
        document.getElementById('field-name-ta').value = data.name_ta || '';
        
        document.getElementById('field-designation').value = data.designation || '';
        document.getElementById('field-designation-si').value = data.designation_si || '';
        document.getElementById('field-designation-ta').value = data.designation_ta || '';
        
        document.getElementById('field-phone').value = data.phone || '';
        document.getElementById('field-email').value = data.email || '';
    } else {
        document.getElementById('modal-title').textContent = 'Add IAU Officer';
        document.getElementById('field-id').value = '';
    }

    const modal = document.getElementById('officer-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    void modal.offsetWidth;
    modal.classList.remove('opacity-0');
    modalBox.classList.remove('scale-95');
    modalBox.classList.add('scale-100');
}

function closeModal() {
    const modal = document.getElementById('officer-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.add('opacity-0');
    modalBox.classList.remove('scale-100');
    modalBox.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Client-side validation helper
function validateField(val, name, lang) {
    if (!val) {
        switchLangTab(lang);
        window.showToast(`${name} in ${lang.toUpperCase() === 'EN' ? 'English' : lang.toUpperCase() === 'SI' ? 'Sinhala' : 'Tamil'} is mandatory.`, 'error');
        return false;
    }
    return true;
}

async function saveOfficer(e) {
    e.preventDefault();
    
    const fields = [
        { id: 'field-title', name: 'Title', lang: 'en' },
        { id: 'field-title-si', name: 'Title', lang: 'si' },
        { id: 'field-title-ta', name: 'Title', lang: 'ta' },
        { id: 'field-name', name: 'Full Name', lang: 'en' },
        { id: 'field-name-si', name: 'Full Name', lang: 'si' },
        { id: 'field-name-ta', name: 'Full Name', lang: 'ta' },
        { id: 'field-designation', name: 'Designation', lang: 'en' },
        { id: 'field-designation-si', name: 'Designation', lang: 'si' },
        { id: 'field-designation-ta', name: 'Designation', lang: 'ta' }
    ];

    for (let f of fields) {
        const val = document.getElementById(f.id).value.trim();
        if (!validateField(val, f.name, f.lang)) {
            document.getElementById(f.id).focus();
            return;
        }
    }

    // If department is specified in English, verify it has Sinhala and Tamil translations too
    const dept = document.getElementById('field-department').value.trim();
    if (dept) {
        const deptSi = document.getElementById('field-department-si').value.trim();
        const deptTa = document.getElementById('field-department-ta').value.trim();
        if (!deptSi) {
            switchLangTab('si');
            document.getElementById('field-department-si').focus();
            window.showToast('Department/Division translation in Sinhala is required if specified.', 'error');
            return;
        }
        if (!deptTa) {
            switchLangTab('ta');
            document.getElementById('field-department-ta').focus();
            window.showToast('Department/Division translation in Tamil is required if specified.', 'error');
            return;
        }
    }

    const form = document.getElementById('officer-form');
    const formData = new FormData(form);

    try {
        const res = await fetch('iau-officers-api.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        
        if (data.success) {
            window.showToast(data.message, 'success');
            closeModal();
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            window.showToast(data.message, 'error');
        }
    } catch (err) {
        console.error(err);
        window.showToast('Failed to connect to server.', 'error');
    }
}

async function deleteOfficer(id) {
    if (!confirm('Are you sure you want to delete this IAU officer?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_officer');
    formData.append('id', id);
    formData.append('csrf_token', '<?= generateCsrfToken() ?>');

    try {
        const res = await fetch('iau-officers-api.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        if (data.success) {
            window.showToast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            window.showToast(data.message, 'error');
        }
    } catch (err) {
        window.showToast('An error occurred.', 'error');
    }
}

async function toggleActive(id) {
    const formData = new FormData();
    formData.append('action', 'toggle_status');
    formData.append('id', id);
    formData.append('csrf_token', '<?= generateCsrfToken() ?>');

    try {
        const res = await fetch('iau-officers-api.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        if (data.success) {
            window.showToast(data.message, 'success');
            const badge = document.getElementById('status-badge-' + id);
            if (badge.textContent.trim() === 'Active') {
                badge.textContent = 'Inactive';
                badge.className = 'px-2.5 py-1 text-[11px] font-bold rounded-md border shadow-sm transition-all duration-150 bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100';
            } else {
                badge.textContent = 'Active';
                badge.className = 'px-2.5 py-1 text-[11px] font-bold rounded-md border shadow-sm transition-all duration-150 bg-green-50 text-green-700 border-green-200 hover:bg-green-100';
            }
        } else {
            window.showToast(data.message, 'error');
        }
    } catch (err) {
        window.showToast('An error occurred.', 'error');
    }
}

// Drag & Drop Sort initialization
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('officers-sortable-list');
    if (el) {
        new Sortable(el, {
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            animation: 150,
            onEnd: async function() {
                const ids = [];
                el.querySelectorAll('tr[data-id]').forEach(tr => {
                    ids.push(tr.getAttribute('data-id'));
                });

                const formData = new FormData();
                formData.append('action', 'update_sort_order');
                formData.append('order', JSON.stringify(ids));
                formData.append('csrf_token', '<?= generateCsrfToken() ?>');

                try {
                    const res = await fetch('iau-officers-api.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await res.json();
                    if (data.success) {
                        window.showToast(data.message, 'success');
                    } else {
                        window.showToast(data.message, 'error');
                    }
                } catch (err) {
                    window.showToast('Failed to save order.', 'error');
                }
            }
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
