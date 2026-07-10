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
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Officials & Contacts</h2>
            <button onclick="openModal('division', null)" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> Add Official
            </button>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6 overflow-x-auto whitespace-nowrap">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs" id="officials-tabs">
                <button onclick="switchTab('top')" class="tab-btn active border-[#4E0000] text-[#4E0000] whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Top Officials
                </button>
                <?php foreach ($divisions as $div): ?>
                <button onclick="switchTab('div-<?= $div['id_db'] ?? $div['id'] ?>')" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors" data-div-id="<?= $div['id_db'] ?? $div['id'] ?>">
                    <?= htmlspecialchars($div['title']) ?>
                </button>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- Tab Contents -->
        
        <!-- Top Officials Tab -->
        <div id="tab-top" class="tab-content active">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($topOfficials as $official): ?>
                <div onclick="showPreviewModal(<?= $official['id'] ?>, '<?= htmlspecialchars(addslashes($official['name'])) ?>', 'top', <?= htmlspecialchars(json_encode($official, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col cursor-pointer hover:shadow-md hover:border-gray-300 transition-all duration-200">
                    <div class="p-6 flex-1 text-center">
                        <?php if ($official['image_path'] && file_exists('../' . $official['image_path'])): ?>
                            <img src="../<?= htmlspecialchars($official['image_path']) ?>" class="w-32 h-32 rounded-full object-cover mx-auto mb-4 border border-gray-200">
                        <?php else: ?>
                            <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        <?php endif; ?>
                        <h3 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($official['name']) ?></h3>
                        <p class="text-[13px] text-gray-500 mb-2 font-medium"><?= htmlspecialchars($official['title']) ?></p>
                        
                        <div class="text-[13px] text-gray-600 mt-4 text-left space-y-1">
                            <?php if ($official['email']): ?><p><strong>Email:</strong> <?= htmlspecialchars($official['email']) ?></p><?php endif; ?>
                            <?php if ($official['phone']): ?><p><strong>Phone:</strong> <?= htmlspecialchars($official['phone']) ?></p><?php endif; ?>
                            <?php if ($official['fax']): ?><p><strong>Fax:</strong> <?= htmlspecialchars($official['fax']) ?></p><?php endif; ?>
                        </div>

                        <!-- Hidden Preview Content -->
                        <div id="preview-content-<?= $official['id'] ?>" class="hidden">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="w-full md:w-[35%] shrink-0 text-center">
                                    <?php if ($official['image_path'] && file_exists('../' . $official['image_path'])): ?>
                                        <img src="../<?= htmlspecialchars($official['image_path']) ?>" class="w-32 h-32 rounded-xl object-cover border border-gray-200 mx-auto shadow-sm">
                                    <?php else: ?>
                                        <div class="w-32 h-32 rounded-xl bg-gray-100 flex items-center justify-center border border-gray-200 mx-auto">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 flex flex-col justify-center text-left">
                                    <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#F3F4F6] text-gray-800 border border-gray-200 self-start mb-2">Top Official</span>
                                    <h4 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($official['name']) ?></h4>
                                    <p class="text-sm font-semibold text-[#4E0000] mt-1"><?= htmlspecialchars($official['title']) ?></p>
                                    
                                    <div class="text-[13px] text-gray-600 mt-4 space-y-2 border-t border-gray-100 pt-4">
                                        <?php if ($official['email']): ?><p><strong>Email:</strong> <?= htmlspecialchars($official['email']) ?></p> <?php endif; ?>
                                        <?php if ($official['phone']): ?><p><strong>Phone:</strong> <?= htmlspecialchars($official['phone']) ?></p> <?php endif; ?>
                                        <?php if ($official['fax']): ?><p><strong>Fax:</strong> <?= htmlspecialchars($official['fax']) ?></p> <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-3 flex justify-center" onclick="event.stopPropagation();">
                        <button onclick="openModal('top', <?= htmlspecialchars(json_encode($official)) ?>)" class="text-[#4E0000] hover:text-[#320000] text-[13px] font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Details
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Division Tabs -->
        <?php foreach ($divisions as $div): ?>
        <div id="tab-div-<?= $div['id_db'] ?? $div['id'] ?>" class="tab-content hidden">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 border-b border-gray-200 text-xs uppercase tracking-wider">
                            <th class="py-3 px-4 w-10"></th>
                            <th class="py-3 px-4 w-16">Image</th>
                            <th class="py-3 px-4">Name / Designation</th>
                            <th class="py-3 px-4">Contact</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 sortable-list" data-division-id="<?= $div['id_db'] ?? $div['id'] ?>">
                        <?php if (empty($div['people'])): ?>
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-500 text-sm">No officials found in this division.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($div['people'] as $person): ?>
                            <tr data-id="<?= $person['id'] ?>" onclick="showPreviewModal(<?= $person['id'] ?>, '<?= htmlspecialchars(addslashes($person['name'])) ?>', 'division', <?= htmlspecialchars(json_encode($person, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)" class="hover:bg-gray-50 bg-white transition-colors cursor-pointer group">
                                <td class="py-3 px-4 text-gray-400 cursor-move drag-handle" onclick="event.stopPropagation();">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </td>
                                <td class="py-3 px-4">
                                    <?php if ($person['image_path']): ?>
                                        <img src="../<?= htmlspecialchars($person['image_path']) ?>" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                    <?php else: ?>
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                            <span class="text-gray-400 text-xs">N/A</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-gray-900 text-sm group-hover:text-[#4E0000] transition-colors"><?= htmlspecialchars($person['name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= htmlspecialchars($person['designation'] ?? $person['title']) ?></div>
                                    
                                    <!-- Hidden Preview Content -->
                                    <div id="preview-content-<?= $person['id'] ?>" class="hidden">
                                        <div class="flex flex-col md:flex-row gap-6">
                                            <div class="w-full md:w-[35%] shrink-0 text-center">
                                                <?php if ($person['image_path']): ?>
                                                    <img src="../<?= htmlspecialchars($person['image_path']) ?>" class="w-32 h-32 rounded-xl object-cover border border-gray-200 mx-auto shadow-sm">
                                                <?php else: ?>
                                                    <div class="w-32 h-32 rounded-xl bg-gray-100 flex items-center justify-center border border-gray-200 mx-auto">
                                                        <span class="text-gray-400 text-xs">No Image</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-1 flex flex-col justify-center text-left">
                                                <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#F3F4F6] text-gray-800 border border-gray-200 self-start mb-2"><?= htmlspecialchars($div['title']) ?></span>
                                                <h4 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($person['name']) ?></h4>
                                                <p class="text-sm font-semibold text-[#4E0000] mt-1"><?= htmlspecialchars($person['designation'] ?? $person['title']) ?></p>
                                                
                                                <div class="text-[13px] text-gray-600 mt-4 space-y-2 border-t border-gray-100 pt-4">
                                                    <?php if ($person['email']): ?><p><strong>Email:</strong> <?= htmlspecialchars($person['email']) ?></p> <?php endif; ?>
                                                    <?php if ($person['phone']): ?><p><strong>Phone:</strong> <?= htmlspecialchars($person['phone']) ?></p> <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-xs text-gray-600 space-y-0.5">
                                    <?php if ($person['email']): ?><div><span class="font-medium">E:</span> <?= htmlspecialchars($person['email']) ?></div><?php endif; ?>
                                    <?php if ($person['phone']): ?><div><span class="font-medium">P:</span> <?= htmlspecialchars($person['phone']) ?></div><?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-right" onclick="event.stopPropagation();">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button onclick='openModal("division", <?= htmlspecialchars(json_encode($person), ENT_QUOTES, "UTF-8") ?>)' class="p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button onclick="deleteOfficial(<?= $person['id'] ?>)" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
        <?php endforeach; ?>
    </main>
</div>

<!-- Modal Form -->
<div id="official-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col overflow-hidden">
        <form id="official-form" onsubmit="saveOfficial(event)" class="flex flex-col max-h-[90vh] w-full">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 id="modal-title" class="text-xl font-bold text-gray-900">Add Official</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-4 text-sm flex-1">
                <input type="hidden" id="field-id" name="id">
                <input type="hidden" id="field-category" name="category" value="division">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                <input type="hidden" id="field-top-role" name="top_role">
                
                <div id="division-select-container">
                    <label class="block text-gray-700 font-medium mb-1.5">Division <span class="text-red-500">*</span></label>
                    <select id="field-division-id" name="division_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#4E0000] focus:border-[#4E0000]">
                        <?php foreach ($divisions as $div): ?>
                        <option value="<?= $div['id_db'] ?? $div['id'] ?>"><?= htmlspecialchars($div['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="field-name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#4E0000] focus:border-[#4E0000]">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input type="text" id="field-title" name="title" required placeholder="e.g. Director General" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#4E0000] focus:border-[#4E0000]">
                    </div>
                </div>

                <div id="designation-container">
                    <label class="block text-gray-700 font-medium mb-1.5">Designation (Optional)</label>
                    <input type="text" id="field-designation" name="designation" placeholder="e.g. Additional Secretary (Admin)" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#4E0000] focus:border-[#4E0000]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1.5">Phone <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
                        <input type="text" id="field-phone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#4E0000] focus:border-[#4E0000]">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1.5">Fax <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
                        <input type="text" id="field-fax" name="fax" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#4E0000] focus:border-[#4E0000]">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1.5">Email <span class="text-gray-400 font-normal text-xs">(Optional)</span></label>
                    <input type="email" id="field-email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#4E0000] focus:border-[#4E0000]">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1.5">Profile Image</label>
                    <!-- Current image preview (shown when editing) -->
                    <div id="current-image-preview" class="hidden mb-3 flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-md">
                        <img id="current-image-thumb" src="" alt="Current photo" class="w-14 h-14 rounded-full object-cover border border-gray-300">
                        <div>
                            <p class="text-xs font-semibold text-gray-700">Current photo</p>
                            <p class="text-xs text-gray-400">Choose a new file below to replace it.</p>
                        </div>
                    </div>
                    <input type="file" id="field-image" name="image" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-800 hover:file:bg-gray-200 border border-gray-200 rounded-md p-1 focus:outline-none">
                    <p class="text-xs text-gray-400 mt-1">Leave empty to keep existing image. Max file size: 5MB. Recommended: 300x300 WEBP or JPG.</p>
                </div>
            </div>

            <div class="p-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                <button type="button" onclick="closeModal()" class="px-5 py-2 text-gray-600 bg-white border border-gray-300 rounded-md text-sm font-semibold hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" id="submit-btn" class="px-5 py-2 bg-[#4E0000] text-white rounded-md text-sm font-semibold hover:bg-[#320000] transition-colors shadow-sm">Save Official</button>
            </div>
        </form>
    </div>
</div>

<style>
.tab-content { display: none; }
.tab-content.active { display: block; }
.sortable-ghost { opacity: 0.4; }
</style>

<script>
// Tab Switching
let currentActiveTab = 'top';

function switchTab(tabId) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'border-[#4E0000]', 'text-[#4E0000]');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
        content.classList.add('hidden');
    });

    const activeBtn = event.currentTarget || document.querySelector(`.tab-btn[onclick*="switchTab('${tabId}')"]`);
    if (activeBtn) {
        activeBtn.classList.add('active', 'border-[#4E0000]', 'text-[#4E0000]');
        activeBtn.classList.remove('border-transparent', 'text-gray-500');
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

// API Calls
async function saveOfficial(e) {
    e.preventDefault();
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
    // csrf_token is already included from the hidden field in the form

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
<div id="preview-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0 bg-black/50 backdrop-blur-sm">
    <div class="absolute inset-0" onclick="hidePreviewModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-0 transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50">
            <h3 id="preview-title" class="text-lg font-bold font-montserrat text-gray-900 truncate pr-4">Official Details</h3>
            <button onclick="hidePreviewModal()" class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none p-1 rounded-md hover:bg-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div id="preview-content-container" class="text-[14px] text-gray-700 overflow-y-auto p-6 md:p-8 flex-1"></div>
        <div class="flex justify-between items-center p-5 border-t border-gray-100 bg-gray-50 shrink-0">
            <span class="text-xs text-gray-500 font-medium">Quick Preview</span>
            <div class="flex gap-3">
                <button id="preview-edit-btn" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors shadow-sm">Edit</button>
                <button id="preview-delete-btn" class="px-5 py-2 bg-red-600 text-white rounded-md text-[13px] font-bold hover:bg-red-700 transition-colors shadow-sm">Delete</button>
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
