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
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Settings</h2>
        </div>

        <div class="max-w-5xl">
            <!-- Account Settings Section -->
            <div class="mb-14">
                <h3 class="text-2xl font-bold font-montserrat text-gray-900 mb-6">Account Settings</h3>
                


                <form action="" method="POST" class="js-validate-form space-y-8">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h4 class="text-[15px] font-semibold text-gray-900 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profile Information
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-800 mb-2">Full Name</label>
                                    <input type="text" name="name" required value="<?= htmlspecialchars($current_user['name']) ?>" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400">
                                </div>
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-800 mb-2">Email Address</label>
                                    <input type="email" name="email" required value="<?= htmlspecialchars($current_user['email']) ?>" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[13px] font-medium text-gray-800 mb-2">Account Role</label>
                                    <div class="flex items-center space-x-3">
                                        <input type="text" value="<?= htmlspecialchars(str_replace('_', ' ', $current_user['role'])) ?>" readonly class="w-full md:w-1/2 px-4 py-3 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none text-[13px] text-gray-600 font-semibold capitalize cursor-not-allowed">
                                        <span class="text-[12px] text-gray-500 italic hidden md:inline">Your role cannot be changed here.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Card -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h4 class="text-[15px] font-semibold text-gray-900 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Security & Password
                            </h4>
                        </div>
                        <div class="p-6">
                            <p class="text-[13px] text-gray-500 mb-5">Leave these fields blank if you do not wish to change your password.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-800 mb-2">New Password</label>
                                    <input type="password" name="new_password" placeholder="Enter new password" class="js-pwd w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400">
                                </div>
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-800 mb-2">Confirm New Password</label>
                                    <input type="password" name="confirm_password" placeholder="Confirm new password" class="js-pwd-confirm w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="index" data-confirm="Are you sure you want to cancel? Any unsaved changes will be lost." class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors bg-white text-center flex items-center justify-center">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors shadow-sm">
                            Save All Changes
                        </button>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
