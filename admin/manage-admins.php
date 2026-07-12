<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

requirePermission('manage_users');

$current_page = "manage-admins";
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    if ($del_id !== $_SESSION['admin_id']) {
        $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->execute([$del_id]);
        $success = "Admin deleted successfully.";
    } else {
        $error = "You cannot delete yourself.";
    }
}

// Handle Add Admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    requireCsrfToken('POST', 'post');
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admins (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $hash, $role])) {
                $success = "Admin created successfully.";
            } else {
                $error = "Failed to create admin.";
            }
        }
    }
}

// Handle Edit Admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    requireCsrfToken('POST', 'post');
    $edit_id = (int)$_POST['admin_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($password) && $password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email exists for other users
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ? AND id != ?");
        $stmt->execute([$email, $edit_id]);
        if ($stmt->fetch()) {
            $error = "Email already registered to another admin.";
        } else {
            if (!empty($password)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE admins SET name = ?, email = ?, password_hash = ?, role = ? WHERE id = ?");
                if ($stmt->execute([$name, $email, $hash, $role, $edit_id])) {
                    $success = "Admin updated successfully.";
                } else {
                    $error = "Failed to update admin.";
                }
            } else {
                $stmt = $pdo->prepare("UPDATE admins SET name = ?, email = ?, role = ? WHERE id = ?");
                if ($stmt->execute([$name, $email, $role, $edit_id])) {
                    $success = "Admin updated successfully.";
                } else {
                    $error = "Failed to update admin.";
                }
            }
        }
    }
}

// Fetch Admins
$stmt = $pdo->query("SELECT * FROM admins ORDER BY created_at DESC");
$admins = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage Admins</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Configure and assign administrative roles, user credentials, and permission groups.</p>
            </div>
            <button onclick="openAddModal()" class="bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm self-start sm:self-auto gap-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                New Admin
            </button>
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

        <!-- Filter Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative flex-1 w-full md:max-w-[50%]">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path></svg>
                </span>
                <input type="text" placeholder="Search by name, role, or email..." class="js-table-search bg-slate-50 border border-slate-200/70 text-slate-700 text-[13px] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] block w-full pl-10 pr-4 py-2.5 font-inter transition-all outline-none">
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-52">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    </span>
                    <select class="js-table-filter w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/70 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] font-semibold text-slate-700 appearance-none cursor-pointer hover:bg-slate-100/50 transition-all">
                        <option value="">All Roles</option>
                        <option value="Executive Officer">Executive Officer</option>
                        <option value="Content Editor">Content Editor</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                    </span>
                </div>

                <button class="js-reset-filter px-5 py-2.5 bg-rose-50/50 border border-rose-100/50 rounded-xl text-[12.5px] font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-all shadow-sm">
                    Reset
                </button>
            </div>
        </div>

        <!-- Table -->
        <?php
        $headers = [
            ['label' => 'Full Name', 'class' => ''],
            ['label' => 'Role', 'class' => ''],
            ['label' => 'Email Address', 'class' => ''],
            ['label' => 'Date Added', 'class' => ''],
            ['label' => 'Actions', 'class' => 'text-right w-36']
        ];
        
        renderAdminTable($headers, $admins, function($adm) {
            $roleColor = 'from-slate-600 to-slate-800';
            if ($adm['role'] === 'executive_officer') {
                $roleColor = 'from-[#4E0000] to-[#721c1c]';
            } elseif ($adm['role'] === 'content_editor') {
                $roleColor = 'from-[#13273F] to-[#254974]';
            }
            
            $badgeClass = "bg-slate-50 text-slate-600 border-slate-100";
            $badgeLabel = str_replace('_', ' ', $adm['role']);
            if ($adm['role'] === 'executive_officer') {
                $badgeClass = "bg-[#4E0000]/5 text-[#4E0000] border-[#4E0000]/10";
                $badgeLabel = "Executive Officer";
            } elseif ($adm['role'] === 'content_editor') {
                $badgeClass = "bg-[#13273F]/5 text-[#13273F] border-[#13273F]/10";
                $badgeLabel = "Content Editor";
            }
            ?>
            <tr class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group">
                <td class="py-4 px-6">
                    <div class="flex items-center">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr <?= $roleColor ?> text-white flex items-center justify-center font-extrabold text-xs mr-3 border-2 border-white shadow-sm ring-1 ring-slate-100 font-mono select-none">
                            <?= htmlspecialchars(getInitials($adm['name'])) ?>
                        </div>
                        <p class="text-[13.5px] font-bold text-slate-800 group-hover:text-[#4E0000] transition-colors leading-none"><?= htmlspecialchars($adm['name']) ?></p>
                    </div>
                </td>
                <td class="py-4 px-6">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold border <?= $badgeClass ?> shadow-sm">
                        <?= htmlspecialchars($badgeLabel) ?>
                    </span>
                </td>
                <td class="py-4 px-6 text-[13px] text-slate-600 font-mono"><?= htmlspecialchars($adm['email']) ?></td>
                <td class="py-4 px-6 text-[13px] text-slate-400 font-mono"><?= date('M d, Y', strtotime($adm['created_at'])) ?></td>
                <td class="py-4 px-6 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <button onclick='openEditModal(<?= json_encode($adm, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 flex items-center justify-center transition-all shadow-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                        </button>
                        <?php if ($adm['id'] !== $_SESSION['admin_id']): ?>
                        <a href="manage-admins?delete=<?= $adm['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this admin?" class="w-8.5 h-8.5 rounded-xl bg-rose-50/50 border border-rose-100/50 hover:bg-rose-50 hover:text-rose-600 text-rose-400 flex items-center justify-center transition-all shadow-sm" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php
        }, [
            'minWidth' => '800px',
            'emptyTitle' => 'No admins found',
            'emptyIcon' => 'users',
            'pagination' => [
                'total_items' => count($admins),
                'showing_count' => count($admins)
            ]
        ]);
        ?>

        <!-- Add/Edit Admin Modal -->
        <div id="adminModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
            <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeAdminModal()"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col border border-slate-100">
                <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50 shrink-0">
                    <h3 class="text-lg font-bold font-montserrat text-slate-800 flex items-center gap-2" id="modalTitle">
                        <!-- Filled by JS -->
                    </h3>
                    <button type="button" onclick="closeAdminModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                    <form id="adminForm" action="" method="POST" class="js-validate-form space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="admin_id" id="adminId" value="">
                        
                        <!-- Row 1: Full Name & Role -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Full Name <span class="text-red-500">*</span></label>
                                <div class="relative font-inter">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                    </span>
                                    <input type="text" name="name" id="adminName" required placeholder="Namal Perera" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 placeholder-slate-400 transition-all font-semibold">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Role <span class="text-red-500">*</span></label>
                                <div class="relative font-inter">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </span>
                                    <select name="role" id="adminRole" class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-600 appearance-none cursor-pointer transition-all font-semibold">
                                        <option value="executive_officer">Executive Officer</option>
                                        <option value="content_editor">Content Editor</option>
                                    </select>
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Email -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative font-inter">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                </span>
                                <input type="email" name="email" id="adminEmail" required placeholder="admin@labourmin.gov.lk" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 placeholder-slate-400 transition-all font-mono font-semibold">
                            </div>
                        </div>

                        <!-- Row 3: Password & Confirm Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2" id="pwdLabel">Password</label>
                                <div class="relative font-inter">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                    </span>
                                    <input type="password" name="password" id="adminPassword" placeholder="Minimum 06 characters" class="js-pwd w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 placeholder-slate-400 transition-all font-mono font-semibold">
                                    <button type="button" onclick="toggleModalPwdVisibility('adminPassword', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="eye-icon-adminPassword"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2" id="pwdConfirmLabel">Confirm Password</label>
                                <div class="relative font-inter">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </span>
                                    <input type="password" name="confirm_password" id="adminConfirmPassword" placeholder="Confirm password" class="js-pwd-confirm w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 placeholder-slate-400 transition-all font-mono font-semibold">
                                    <button type="button" onclick="toggleModalPwdVisibility('adminConfirmPassword', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="eye-icon-adminConfirmPassword"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Real-time Validation Matching Feed inside modal -->
                        <div id="modal-pwd-match-badge" class="hidden items-center gap-1.5 p-3.5 rounded-xl border text-[11px] font-bold uppercase tracking-wider">
                            <span id="modal-pwd-match-icon"></span>
                            <span id="modal-pwd-match-text"></span>
                        </div>

                        <p id="editPwdHint" class="text-[11px] text-slate-400 italic hidden mt-1 font-inter">Leave password fields blank to keep the current password.</p>

                        <div class="pt-5 mt-2 flex justify-end gap-3 border-t border-slate-100 font-inter shrink-0">
                            <button type="button" onclick="closeAdminModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-[12.5px] font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtnText" class="px-7 py-2.5 bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all">
                                Save Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg> Add New Admin';
            document.getElementById('formAction').value = 'add';
            document.getElementById('adminId').value = '';
            
            document.getElementById('adminName').value = '';
            document.getElementById('adminEmail').value = '';
            document.getElementById('adminRole').value = 'executive_officer';
            document.getElementById('adminPassword').value = '';
            document.getElementById('adminConfirmPassword').value = '';
            
            document.getElementById('adminPassword').required = true;
            document.getElementById('adminConfirmPassword').required = true;
            
            document.getElementById('pwdLabel').innerHTML = 'Password <span class="text-red-500">*</span>';
            document.getElementById('pwdConfirmLabel').innerHTML = 'Confirm Password <span class="text-red-500">*</span>';
            document.getElementById('editPwdHint').classList.add('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Create Admin';
            
            // Clean modal password matching indicator
            const matchBadge = document.getElementById('modal-pwd-match-badge');
            if (matchBadge) {
                matchBadge.classList.add('hidden');
                matchBadge.classList.remove('flex');
            }

            const modal = document.getElementById('adminModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }

        function openEditModal(admin) {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg> Edit Admin';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('adminId').value = admin.id;
            
            document.getElementById('adminName').value = admin.name;
            document.getElementById('adminEmail').value = admin.email;
            document.getElementById('adminRole').value = admin.role;
            document.getElementById('adminPassword').value = '';
            document.getElementById('adminConfirmPassword').value = '';
            
            document.getElementById('adminPassword').required = false;
            document.getElementById('adminConfirmPassword').required = false;
            
            document.getElementById('pwdLabel').textContent = 'New Password';
            document.getElementById('pwdConfirmLabel').textContent = 'Confirm New Password';
            document.getElementById('editPwdHint').classList.remove('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Save Changes';
            
            // Clean modal password matching indicator
            const matchBadge = document.getElementById('modal-pwd-match-badge');
            if (matchBadge) {
                matchBadge.classList.add('hidden');
                matchBadge.classList.remove('flex');
            }

            const modal = document.getElementById('adminModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }

        function closeAdminModal() {
            const modal = document.getElementById('adminModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.add('opacity-0');
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function toggleModalPwdVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const svgIcon = document.getElementById('eye-icon-' + inputId);
            
            if (input.type === 'password') {
                input.type = 'text';
                // Eye-off SVG
                svgIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                `;
            } else {
                input.type = 'password';
                // Eye SVG
                svgIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                `;
            }
        }

        // Modal Password Match Indicator
        const modalPwdInput = document.getElementById('adminPassword');
        const modalPwdConfirmInput = document.getElementById('adminConfirmPassword');
        const modalMatchBadge = document.getElementById('modal-pwd-match-badge');
        const modalMatchIcon = document.getElementById('modal-pwd-match-icon');
        const modalMatchText = document.getElementById('modal-pwd-match-text');

        function checkModalPasswordMatch() {
            const val = modalPwdInput.value;
            const confirmVal = modalPwdConfirmInput.value;
            
            if (val === '' && confirmVal === '') {
                modalMatchBadge.classList.add('hidden');
                modalMatchBadge.classList.remove('flex');
                return;
            }
            
            modalMatchBadge.classList.remove('hidden');
            modalMatchBadge.classList.add('flex');
            
            if (val === confirmVal) {
                modalMatchBadge.className = "flex items-center gap-1.5 p-3.5 rounded-xl border text-[11px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border-emerald-200";
                modalMatchIcon.innerHTML = `<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>`;
                modalMatchText.textContent = "Passwords match successfully.";
            } else {
                modalMatchBadge.className = "flex items-center gap-1.5 p-3.5 rounded-xl border text-[11px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border-rose-200";
                modalMatchIcon.innerHTML = `<svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>`;
                modalMatchText.textContent = "Passwords do not match yet.";
            }
        }

        modalPwdInput.addEventListener('input', checkModalPasswordMatch);
        modalPwdConfirmInput.addEventListener('input', checkModalPasswordMatch);
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
