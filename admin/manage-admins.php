<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

if (!isSuperAdmin()) {
    die("Access Denied.");
}

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

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Manage Admins</h2>
            <button onclick="openAddModal()" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Admin
            </button>
        </div>

        
        

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative flex-1 w-full md:max-w-[60%]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Search by name, role, or email..." class="js-table-search bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 pr-4 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400">
                </div>
            
            <div class="grid grid-cols-2 sm:flex sm:items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-40">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Roles</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <button class="js-reset-filter col-span-1 px-4 py-2.5 bg-white border border-red-200 rounded-md text-[13px] font-medium text-red-500 flex items-center justify-center hover:bg-red-50 transition-colors">
                    Reset
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto mb-12">
            <div class="overflow-x-auto">
                <table class="js-filterable-table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F9FAFB] border-b border-gray-100">
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Full Name</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Date Added</th>
                            <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($admins)): ?>
                        <tr>
                            <td colspan="5" class="py-16 px-6">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <p class="text-[14px] font-semibold text-gray-900 mb-1">No admins found</p>
                                    <p class="text-[13px] text-gray-500">There are no admins matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($admins as $adm): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <?php 
                                    $roleColor = 'bg-gray-800';
                                    if ($adm['role'] === 'super_admin') $roleColor = 'bg-[#320000]';
                                    elseif ($adm['role'] === 'admin') $roleColor = 'bg-[#13273F]';
                                    ?>
                                    <div class="w-8 h-8 rounded-full <?= $roleColor ?> text-white flex items-center justify-center font-bold text-xs mr-3"><?= htmlspecialchars(getInitials($adm['name'])) ?></div>
                                    <p class="text-[13px] font-medium text-gray-900"><?= htmlspecialchars($adm['name']) ?></p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <?php if ($adm['role'] === 'super_admin'): ?>
                                <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#13273F] text-white">Super Admin</span>
                                <?php else: ?>
                                <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-gray-200 text-gray-800">Admin</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-[13px] text-gray-600"><?= htmlspecialchars($adm['email']) ?></td>
                            <td class="py-4 px-6 text-[13px] text-gray-600"><?= date('M d, Y', strtotime($adm['created_at'])) ?></td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick='openEditModal(<?= json_encode($adm, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <?php if ($adm['id'] !== $_SESSION['admin_id']): ?>
                                    <a href="manage-admins?delete=<?= $adm['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this admin?" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-[13px] text-gray-500">Showing 1 to 2 of 2 entries</p>
                <div class="flex gap-1">
                    <button class="px-3 py-1.5 border border-gray-200 rounded text-[13px] text-gray-500 hover:bg-gray-50" disabled>Prev</button>
                    <button class="px-3 py-1.5 bg-[#4E0000] text-white rounded text-[13px]">1</button>
                    <button class="px-3 py-1.5 border border-gray-200 rounded text-[13px] text-gray-500 hover:bg-gray-50" disabled>Next</button>
                </div>
            </div>
        </div>

        <!-- Add/Edit Admin Modal -->
        <div id="adminModal" class="fixed inset-0 z-[150] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900 flex items-center" id="modalTitle">
                        <svg class="w-5 h-5 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Add New Admin
                    </h3>
                    <button type="button" onclick="closeAdminModal()" class="text-gray-400 hover:text-gray-600 transition-colors bg-white hover:bg-gray-100 rounded-full p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto">
                    <form id="adminForm" action="" method="POST" class="js-validate-form space-y-6">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="admin_id" id="adminId" value="">
                        
                        <!-- Row 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Full Name</label>
                                <input type="text" name="name" id="adminName" required placeholder="Namal Perera" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400 transition-shadow">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Role</label>
                                <div class="relative">
                                    <select name="role" id="adminRole" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-600 appearance-none cursor-pointer transition-shadow">
                                        <option value="super_admin">Super Admin</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Email</label>
                                <input type="email" name="email" id="adminEmail" required placeholder="admin@labourmin.gov.lk" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400 transition-shadow">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2" id="pwdLabel">Password</label>
                                <input type="password" name="password" id="adminPassword" placeholder="Minimum 06 characters" class="js-pwd w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400 transition-shadow">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2" id="pwdConfirmLabel">Confirm Password</label>
                                <input type="password" name="confirm_password" id="adminConfirmPassword" placeholder="Add password for confirm" class="js-pwd-confirm w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400 transition-shadow">
                            </div>
                        </div>
                        
                        <p id="editPwdHint" class="text-[12px] text-gray-500 hidden mt-2">Leave password fields blank to keep the current password.</p>

                        <div class="pt-4 mt-2 flex justify-end gap-3 border-t border-gray-100">
                            <button type="button" onclick="closeAdminModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-medium hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtnText" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors shadow-sm">
                                Save Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg> Add New Admin';
            document.getElementById('formAction').value = 'add';
            document.getElementById('adminId').value = '';
            
            document.getElementById('adminName').value = '';
            document.getElementById('adminEmail').value = '';
            document.getElementById('adminRole').value = 'super_admin';
            document.getElementById('adminPassword').value = '';
            document.getElementById('adminConfirmPassword').value = '';
            
            document.getElementById('adminPassword').required = true;
            document.getElementById('adminConfirmPassword').required = true;
            
            document.getElementById('pwdLabel').textContent = 'Password *';
            document.getElementById('pwdConfirmLabel').textContent = 'Confirm Password *';
            document.getElementById('editPwdHint').classList.add('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Create Admin';
            
            const modal = document.getElementById('adminModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(admin) {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit Admin';
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
            
            const modal = document.getElementById('adminModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAdminModal() {
            const modal = document.getElementById('adminModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        </script>
    </main>
</div>

<?php include 'includes/footer.php'; ?>



