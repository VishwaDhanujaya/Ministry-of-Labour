<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$success = '';
$error = '';

$admin_id = $_SESSION['admin_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrfToken('POST', 'post');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email)) {
        $error = "Name and Email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            // Check if email already exists for another user
            $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ? AND id != ?");
            $stmt->execute([$email, $admin_id]);
            if ($stmt->fetch()) {
                $error = "Email is already in use.";
            } else {
                if (!empty($new_password)) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE admins SET name = ?, email = ?, password_hash = ? WHERE id = ?");
                    $stmt->execute([$name, $email, $hashed_password, $admin_id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE admins SET name = ?, email = ? WHERE id = ?");
                    $stmt->execute([$name, $email, $admin_id]);
                }
                
                // Update session
                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_email'] = $email;
                $success = "Profile updated successfully.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

// Fetch current user data
$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$admin_id]);
$current_user = $stmt->fetch();

include 'includes/header.php';
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Admin Settings</h2>
            <p class="text-[13px] text-slate-500 mt-1 font-inter">Manage your administrator profile details and update account security credentials.</p>
        </div>

        <!-- Success & Error Banners -->
        <?php if (!empty($success)): ?>
            <div class="max-w-6xl mx-auto mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 flex items-center gap-3 text-xs font-semibold shadow-sm animate-fadeIn">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="max-w-6xl mx-auto mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 flex items-center gap-3 text-xs font-semibold shadow-sm animate-fadeIn">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-8 items-start mb-10">
            
            <!-- Left Side: Profile Summary Card -->
            <?php
                $words = explode(" ", $current_user['name']);
                $initials = "";
                foreach ($words as $w) {
                    if (preg_match('/^[A-Za-z]/', $w)) $initials .= strtoupper($w[0]);
                }
                $initials = substr($initials, 0, 2);
                if (empty($initials)) {
                    $initials = "AD";
                }

                $role = $current_user['role'];
                $roleClass = "bg-slate-50 text-slate-600 border-slate-100";
                $roleLabel = str_replace('_', ' ', $role);
                if ($role === 'executive_officer') {
                    $roleClass = "bg-[#4E0000]/5 text-[#4E0000] border-[#4E0000]/10";
                    $roleLabel = "Executive Officer";
                } elseif ($role === 'content_editor') {
                    $roleClass = "bg-[#13273F]/5 text-[#13273F] border-[#13273F]/10";
                    $roleLabel = "Content Editor";
                } elseif ($role === 'super_admin') {
                    $roleClass = "bg-amber-500/5 text-amber-700 border-amber-500/10";
                    $roleLabel = "Super Administrator";
                }
            ?>
            <div class="w-full lg:w-1/3 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] overflow-hidden flex flex-col shrink-0">
                <!-- Color Banner -->
                <div class="h-28 bg-gradient-to-r from-[#13273F] to-[#254974] relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full"></div>
                </div>
                <!-- Profile Block -->
                <div class="px-6 pb-6 text-center flex-1">
                    <!-- Initials Avatar -->
                    <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-[#13273F] to-[#254974] text-white font-extrabold text-2xl flex items-center justify-center border-4 border-white shadow-md mx-auto -mt-10 relative z-10 ring-2 ring-slate-100/50">
                        <?= htmlspecialchars($initials) ?>
                    </div>
                    
                    <h3 class="text-base font-bold text-slate-800 font-montserrat mt-4 leading-snug"><?= htmlspecialchars($current_user['name']) ?></h3>
                    <p class="text-xs text-slate-400 font-mono tracking-tight mt-1"><?= htmlspecialchars($current_user['email']) ?></p>
                    
                    <div class="mt-4 flex justify-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold border <?= $roleClass ?> uppercase tracking-wider font-mono">
                            <?= htmlspecialchars($roleLabel) ?>
                        </span>
                    </div>

                    <!-- Additional details -->
                    <div class="mt-6 pt-6 border-t border-slate-50 space-y-3.5 text-left text-xs text-slate-500">
                        <div class="flex justify-between items-center font-mono">
                            <span class="text-slate-400 font-medium">Account ID:</span>
                            <span class="text-slate-700 font-bold">#<?= htmlspecialchars($current_user['id']) ?></span>
                        </div>
                        <div class="flex justify-between items-center font-mono">
                            <span class="text-slate-400 font-medium">Last Login Session:</span>
                            <span class="text-slate-700 font-bold text-[11px]"><?= date('Y-m-d H:i') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Forms and Tabs -->
            <div class="flex-1 w-full bg-white rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] overflow-hidden">
                <form action="" method="POST" class="js-validate-form">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

                    <!-- Tabs Navigation Bar -->
                    <div class="flex border-b border-slate-100 bg-slate-50/30 p-2 gap-2">
                        <button type="button" onclick="switchTab('profile')" id="tabBtn-profile" class="flex-1 py-3 px-6 font-montserrat font-bold text-[12.5px] rounded-xl bg-white text-slate-800 shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-slate-200/20 transition-all text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            Profile Details
                        </button>
                        <button type="button" onclick="switchTab('security')" id="tabBtn-security" class="flex-1 py-3 px-6 font-montserrat font-bold text-[12.5px] rounded-xl text-slate-400 hover:text-slate-600 transition-all text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                            Security Credentials
                        </button>
                    </div>

                    <!-- Panel Container -->
                    <div class="p-6 md:p-8">
                        
                        <!-- TAB 1: Profile Information Panel -->
                        <div id="tabPanel-profile" class="space-y-6">
                            <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 font-inter">Edit Profile Information</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Full Name <span class="text-red-500">*</span></label>
                                    <div class="relative font-inter">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                        </span>
                                        <input type="text" name="name" required value="<?= htmlspecialchars($current_user['name']) ?>" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address <span class="text-red-500">*</span></label>
                                    <div class="relative font-inter">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                                        </span>
                                        <input type="email" name="email" required value="<?= htmlspecialchars($current_user['email']) ?>" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-medium">
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Account Role</label>
                                    <div class="relative font-inter">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </span>
                                        <input type="text" value="<?= htmlspecialchars($roleLabel) ?>" readonly class="w-full md:w-1/2 pl-10 pr-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl focus:outline-none text-[13px] text-slate-400 font-bold uppercase tracking-wider cursor-not-allowed font-inter">
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-2 font-inter italic">Administrators cannot modify their own roles. Please contact a root system administrator for credential scope adjustments.</p>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: Security & Password Panel -->
                        <div id="tabPanel-security" class="hidden space-y-6">
                            <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 font-inter">Change Password</h4>
                            <p class="text-[12px] text-slate-400 mb-6 font-inter">Leave the fields blank if you wish to keep your current login password.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
                                    <div class="relative font-inter">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                        </span>
                                        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" class="js-pwd w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-mono">
                                        <button type="button" onclick="togglePwdVisibility('new_password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="eye-icon-new_password"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Confirm New Password</label>
                                    <div class="relative font-inter">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </span>
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" class="js-pwd-confirm w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 transition-all font-mono">
                                        <button type="button" onclick="togglePwdVisibility('confirm_password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="eye-icon-confirm_password"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Real-time Validation Matching Feed -->
                            <div id="pwd-match-badge" class="hidden items-center gap-1.5 p-3.5 rounded-xl border text-[11px] font-bold uppercase tracking-wider">
                                <span id="pwd-match-icon"></span>
                                <span id="pwd-match-text"></span>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3 font-inter shrink-0">
                            <a href="dashboard" class="px-6 py-2.5 border border-slate-200 text-slate-700 rounded-xl text-[12.5px] font-bold hover:bg-slate-50 transition-all bg-white text-center flex items-center justify-center shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" class="px-7 py-2.5 bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all">
                                Save All Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
</style>

<script>
function switchTab(tabId) {
    const profileBtn = document.getElementById('tabBtn-profile');
    const securityBtn = document.getElementById('tabBtn-security');
    
    const profilePanel = document.getElementById('tabPanel-profile');
    const securityPanel = document.getElementById('tabPanel-security');
    
    if (tabId === 'profile') {
        profileBtn.className = "flex-1 py-3 px-6 font-montserrat font-bold text-[12.5px] rounded-xl bg-white text-slate-800 shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-slate-200/20 transition-all text-center flex items-center justify-center gap-2";
        securityBtn.className = "flex-1 py-3 px-6 font-montserrat font-bold text-[12.5px] rounded-xl text-slate-400 hover:text-slate-600 transition-all text-center flex items-center justify-center gap-2";
        
        profilePanel.classList.remove('hidden');
        securityPanel.classList.add('hidden');
    } else {
        securityBtn.className = "flex-1 py-3 px-6 font-montserrat font-bold text-[12.5px] rounded-xl bg-white text-slate-800 shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-slate-200/20 transition-all text-center flex items-center justify-center gap-2";
        profileBtn.className = "flex-1 py-3 px-6 font-montserrat font-bold text-[12.5px] rounded-xl text-slate-400 hover:text-slate-600 transition-all text-center flex items-center justify-center gap-2";
        
        securityPanel.classList.remove('hidden');
        profilePanel.classList.add('hidden');
    }
}

function togglePwdVisibility(inputId, btn) {
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

// Password Match Dynamic Indicator
const pwdInput = document.getElementById('new_password');
const pwdConfirmInput = document.getElementById('confirm_password');
const matchBadge = document.getElementById('pwd-match-badge');
const matchIcon = document.getElementById('pwd-match-icon');
const matchText = document.getElementById('pwd-match-text');

function checkPasswordMatch() {
    const val = pwdInput.value;
    const confirmVal = pwdConfirmInput.value;
    
    if (val === '' && confirmVal === '') {
        matchBadge.classList.add('hidden');
        matchBadge.classList.remove('flex');
        return;
    }
    
    matchBadge.classList.remove('hidden');
    matchBadge.classList.add('flex');
    
    if (val === confirmVal) {
        matchBadge.className = "flex items-center gap-1.5 p-3.5 rounded-xl border text-[11px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border-emerald-200";
        matchIcon.innerHTML = `<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>`;
        matchText.textContent = "Passwords match successfully.";
    } else {
        matchBadge.className = "flex items-center gap-1.5 p-3.5 rounded-xl border text-[11px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border-rose-200";
        matchIcon.innerHTML = `<svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>`;
        matchText.textContent = "Passwords do not match yet.";
    }
}

pwdInput.addEventListener('input', checkPasswordMatch);
pwdConfirmInput.addEventListener('input', checkPasswordMatch);
</script>

<?php include 'includes/footer.php'; ?>
