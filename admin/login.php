<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Compute absolute base URL so assets load correctly under URL rewriting.
$script_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); // e.g. /admin
$base_dir    = str_replace('\\', '/', dirname($script_path));            // e.g. /
if ($base_dir === '\\' || $base_dir === '/') {
    $base_dir = '';
}
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $base_dir . '/';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (isLoggedIn()) {
    header("Location: dashboard");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, name, password_hash, role FROM admins WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true); // Prevent Session Fixation
            loginAdmin($admin['id'], $admin['name'], $admin['role']);
            session_write_close(); // Force session to write to disk before redirect
            header("Location: dashboard");
            exit;
        } else {
            // Generic error message to prevent username enumeration
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Please enter both email and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ministry of Labour</title>

    <!-- Google Fonts: Inter and Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="<?= $base_url ?>assets/img/emblem.png" type="image/png">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">

    <style>
        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        .font-montserrat {
            font-family: 'Montserrat', sans-serif;
        }

        /* Custom Placeholder Styles to accommodate the red asterisk */
        .custom-placeholder-input:not(:placeholder-shown)+.custom-placeholder-label {
            opacity: 0;
            visibility: hidden;
        }

        .custom-placeholder-input:focus+.custom-placeholder-label {
            opacity: 0;
            visibility: hidden;
        }
    </style>
</head>

<body class="bg-white text-gray-800 antialiased font-inter min-h-screen flex flex-col lg:flex-row">

    <!-- Left Side: Image with Gradient Overlay -->
    <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center bg-[#4E0000] min-h-screen shrink-0">
        <!-- Background Image (using inline style for reliable loading without Tailwind compilation) -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= $base_url ?>admin/assets/img/login-admin.webp');">
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 z-0"
            style="background: linear-gradient(180deg, rgba(78, 0, 0, 0.81) 0%, rgba(78, 0, 0, 0.9) 100%);"></div>

        <!-- Logo -->
        <div class="relative z-10 flex flex-col items-center">
            <img loading="lazy" src="<?= $base_url ?>assets/img/logo.png" alt="Ministry of Labour Logo"
                class="w-80 lg:w-[420px] h-auto object-contain drop-shadow-md">
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center relative p-8 min-h-screen shrink-0 overflow-y-auto">

        <div class="w-full max-w-[420px]">
            <h2 class="text-[36px] font-bold text-black text-center mb-12 font-montserrat">Admin Login</h2>

            <?php if (!empty($error)): ?>
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm font-medium">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <!-- Email Input -->
                <div class="relative">
                    <input type="email" id="email" name="email" required autocomplete="off" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        class="custom-placeholder-input w-full px-4 py-3.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#4E0000] focus:border-[#4E0000] transition-colors"
                        placeholder=" ">
                    <label for="email"
                        class="custom-placeholder-label absolute text-sm text-gray-500 left-4 top-1/2 -translate-y-1/2 pointer-events-none transition-all flex items-center gap-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                </div>

                <!-- Password Input -->
                <div class="relative">
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                        class="custom-placeholder-input w-full px-4 py-3.5 pr-12 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#4E0000] focus:border-[#4E0000] transition-colors"
                        placeholder=" ">
                    <label for="password"
                        class="custom-placeholder-label absolute text-sm text-gray-500 left-4 top-1/2 -translate-y-1/2 pointer-events-none transition-all flex items-center gap-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4E0000] focus:outline-none transition-colors">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-[#4E0000] hover:bg-[#320000] text-white font-semibold rounded-lg py-3.5 transition-colors text-[15px] shadow-sm font-montserrat tracking-wide">
                        Login
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-8 left-0 right-0 text-center text-[11px] text-gray-400 font-medium tracking-wide">
            © 2026 Copyright SLTDIGITAL
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                pwd.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</body>

</html>