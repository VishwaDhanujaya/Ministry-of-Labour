<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once '../includes/Cache.php';

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

if (isset($_GET['timeout'])) {
    $error = "You have been logged out due to inactivity.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $rateLimitKey = 'login_attempts_' . md5($ip);
    $attempts = Cache::get($rateLimitKey, 900) ?? 0;

    if ($attempts >= 5) {
        $error = "Too many failed attempts. Please try again in 15 minutes.";
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!empty($email) && !empty($password)) {
            $stmt = $pdo->prepare("SELECT id, name, password_hash, role, permissions FROM admins WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                Cache::forget($rateLimitKey); // Reset lockout on success
                session_regenerate_id(true); // Prevent Session Fixation
                loginAdmin($admin['id'], $admin['name'], $admin['role'], $admin['permissions']);
                session_write_close(); // Force session to write to disk before redirect
                header("Location: dashboard");
                exit;
            } else {
                $attempts++;
                Cache::set($rateLimitKey, $attempts);
                // Generic error message to prevent username enumeration
                $error = "Invalid email or password. Attempt $attempts of 5.";
            }
        } else {
            $error = "Please enter both email and password.";
        }
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
    <?php
    $css_path = dirname(__DIR__) . '/assets/css/style.css';
    $css_version = file_exists($css_path) ? filemtime($css_path) : time();
    ?>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css?v=<?= $css_version ?>">

    <style>
        body, input, select, textarea, button {
            font-family: 'Inter', sans-serif !important;
        }
        h1, h2, h3, h4, h5, h6, .font-montserrat {
            font-family: 'Montserrat', sans-serif !important;
        }
        .font-inter {
            font-family: 'Inter', sans-serif !important;
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
    <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center bg-secondary min-h-screen shrink-0">
        <!-- Background Image (using inline style for reliable loading without Tailwind compilation) -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= $base_url ?>admin/assets/img/login-admin.webp');">
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 z-0"
            style="background: linear-gradient(180deg, rgba(78, 0, 0, 0.81) 0%, rgba(78, 0, 0, 0.9) 100%);"></div>

        <!-- Logo -->
        <div class="relative z-10 flex flex-col items-center">
            <?php
            $logo_path = dirname(__DIR__) . '/assets/img/logo.png';
            $logo_version = file_exists($logo_path) ? filemtime($logo_path) : time();
            ?>
            <img loading="lazy" src="<?= $base_url ?>assets/img/logo.png?v=<?= $logo_version ?>" alt="Ministry of Labour Logo"
                class="w-80 lg:w-[420px] h-auto object-contain drop-shadow-md">
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center relative p-8 min-h-screen shrink-0 overflow-y-auto">

        <div class="w-full max-w-[420px]">
            <h2 class="text-[36px] font-bold text-black text-center mb-12 font-montserrat">Admin Login</h2>



            <form id="loginForm" action="" method="POST" class="js-validate-form space-y-6">
                <!-- Email Input -->
                <div class="relative">
                    <input type="email" id="email" name="email" required autocomplete="username" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        class="custom-placeholder-input w-full px-4 py-3.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors bg-white shadow-sm"
                        placeholder=" ">
                    <label for="email"
                        class="custom-placeholder-label absolute text-sm text-gray-500 left-4 top-1/2 -translate-y-1/2 pointer-events-none transition-all flex items-center gap-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                </div>

                <!-- Password Input -->
                <div class="relative group">
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="custom-placeholder-input w-full px-4 py-3.5 pr-12 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors bg-white shadow-sm"
                        placeholder=" ">
                    <label for="password"
                        class="custom-placeholder-label absolute text-sm text-gray-500 left-4 top-1/2 -translate-y-1/2 pointer-events-none transition-all flex items-center gap-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-secondary focus:outline-none transition-colors" title="Toggle password visibility">
                        <svg id="eye-icon" class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" id="loginBtn"
                        class="w-full bg-secondary hover:bg-[#320000] text-white font-semibold rounded-lg py-3.5 transition-all duration-200 text-[15px] shadow-md hover:shadow-lg font-montserrat tracking-wide flex justify-center items-center gap-2">
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

    <!-- Include admin.js for toasts and loading states -->
    <?php
    $admin_js_path = dirname(__DIR__) . '/admin/assets/js/admin.js';
    $admin_js_version = file_exists($admin_js_path) ? filemtime($admin_js_path) : time();
    ?>
    <script src="<?= $base_url ?>admin/assets/js/admin.js?v=<?= $admin_js_version ?>"></script>

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

        document.getElementById('loginForm').addEventListener('submit', () => {
            const pwd = document.getElementById('password');
            if (pwd.type === 'text') {
                pwd.type = 'password';
            }
        });

        <?php if (!empty($error)): ?>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.showToast === 'function') {
                window.showToast(<?= json_encode($error) ?>, 'error');
                
                // Clean up URL parameters without refreshing
                const url = new URL(window.location);
                if (url.searchParams.has('timeout')) {
                    url.searchParams.delete('timeout');
                    window.history.replaceState({}, '', url);
                }
            }
        });
        <?php endif; ?>
    </script>
</body>

</html>