<?php
// Compute base URL for assets if not defined
if (!isset($base_url)) {
    $script_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); // e.g. /admin
    $base_dir    = str_replace('\\', '/', dirname($script_path));            // e.g. /
    if ($base_dir === '\\' || $base_dir === '/') {
        $base_dir = '';
    }
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $base_dir . '/';
}

if (!function_exists('getInitials')) {
    require_once dirname(__DIR__) . '/includes/functions.php';
}

$user = getLoggedInAdmin();
$name = $user['name'] ?? 'Administrator';
$role = $user['role'] ?? 'staff';
$initials = getInitials($name);

$standalone = isset($is_standalone) && $is_standalone;
?>

<?php if ($standalone): ?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace Locked - Ministry of Labour</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="<?= $base_url ?>assets/img/emblem.png" type="image/png">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
<?php endif; ?>

<!-- Custom Lock Screen Overlay styles -->
<style>
    #lockscreen-overlay {
        font-family: 'Inter', sans-serif !important;
    }
    #lockscreen-overlay h2, #lockscreen-overlay h3, #lockscreen-overlay .font-montserrat {
        font-family: 'Montserrat', sans-serif !important;
    }
    @keyframes lockFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-lock-fade-in {
        animation: lockFadeIn 0.35s ease-out forwards;
    }
    @keyframes lockSlideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-lock-slide-up {
        animation: lockSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes lockShake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-6px); }
        20%, 40%, 60%, 80% { transform: translateX(6px); }
    }
    .lock-shake {
        animation: lockShake 0.6s ease-in-out;
    }
    
    /* Standalone background override */
    <?php if ($standalone): ?>
    body {
        background: #0f172a !important;
    }
    <?php endif; ?>
</style>

<?php if ($standalone): ?>
</head>
<body class="min-h-full flex items-center justify-center p-4 relative overflow-hidden select-none">
<?php endif; ?>

<?php
$is_locked = isset($_SESSION['is_locked']) && $_SESSION['is_locked'] === true;
?>
<!-- Full screen blurred lock overlay: dark glass sheet blurring the background -->
<div id="lockscreen-overlay" class="fixed inset-0 z-[99999] <?= $is_locked ? 'flex' : 'hidden' ?> items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xl animate-lock-fade-in select-none">
    <!-- Main Solid Lock Card in front -->
    <div class="w-full max-w-md bg-white border border-slate-100/80 shadow-[0_24px_50px_rgba(0,0,0,0.12)] rounded-3xl p-8 text-center relative z-10 animate-lock-slide-up <?= isset($_GET['unlock_error']) ? 'lock-shake' : '' ?>">
        <!-- Emblem/Logo -->
        <div class="flex justify-center mb-5">
            <img loading="lazy" src="<?= $base_url ?>assets/img/emblem.png" alt="Sri Lanka Emblem" class="h-14 w-auto object-contain">
        </div>
        
        <h2 class="text-lg font-extrabold font-montserrat text-slate-800 tracking-wider mb-1 uppercase">Workspace Locked</h2>
        <p class="text-xs text-slate-500 mb-7 font-medium">Your session has been locked due to inactivity.</p>

        <!-- User Profile -->
        <div class="flex flex-col items-center mb-7">
            <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-700 flex items-center justify-center font-bold text-xl mb-3.5 border border-slate-100/80 shadow-sm">
                <?= htmlspecialchars($initials) ?>
            </div>
            <h3 class="text-base font-bold text-slate-800 leading-tight"><?= htmlspecialchars($name) ?></h3>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-mono mt-1"><?= htmlspecialchars(str_replace('_', ' ', $role)) ?></p>
        </div>

        <?php
        $failed_attempts = $_SESSION['failed_unlock_attempts'] ?? 0;
        $remaining = 3 - $failed_attempts;
        ?>

        <!-- Dynamic AJAX Error Box -->
        <div id="unlock-error-container" class="hidden mb-5 p-3 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 text-[11px] font-semibold leading-relaxed"></div>

        <?php if (isset($_GET['unlock_error'])): ?>
            <div id="php-error-container" class="mb-5 p-3 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 text-[11px] font-semibold leading-relaxed">
                Incorrect password. <?= $remaining ?> <?= $remaining === 1 ? 'attempt' : 'attempts' ?> remaining.
            </div>
        <?php endif; ?>

        <!-- Unlock Form -->
        <form id="unlock-form" action="<?= $base_url ?>admin/unlock.php" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
            <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
            
            <div class="relative group">
                <input type="password" name="password" id="password" required autofocus placeholder="Enter password to unlock" class="w-full pl-12 pr-12 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-secondary/40 focus:border-secondary/40 text-xs text-slate-800 placeholder-slate-400 text-center font-medium transition-all">
                <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" aria-label="Toggle password visibility">
                    <!-- Eye Icon (Visible by default) -->
                    <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.799 8.05 8.361 5 12 5c3.639 0 8.201 3.05 9.964 6.678a1.012 1.012 0 010 .644C20.199 15.95 15.639 19 12 19c-3.639 0-8.201-3.05-9.964-6.678z"></path>
                        <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"></circle>
                    </svg>
                    <!-- Eye Off Icon (Hidden by default) -->
                    <svg id="eye-off-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.893 7.893L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                    </svg>
                </button>
            </div>

            <button type="submit" class="w-full py-3 bg-secondary hover:bg-[#721c1c] text-white rounded-xl text-xs font-bold shadow-sm hover:shadow active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h16.5a1.5 1.5 0 001.5-1.5V10.5a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 10.5v9.75a1.5 1.5 0 001.5 1.5z"></path></svg>
                Unlock Workspace
            </button>
        </form>

        <div class="mt-7 pt-5 border-t border-slate-100">
            <a href="<?= $base_url ?>admin/logout.php" class="text-[11px] font-bold text-slate-400 hover:text-rose-500 transition-colors flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-current" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path></svg>
                Sign out and exit
            </a>
        </div>
    </div>
</div>

<script>
(function() {
    const form = document.getElementById('unlock-form');
    if (!form) return;

    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('toggle-password');
    const overlay = document.getElementById('lockscreen-overlay');
    const errorContainer = document.getElementById('unlock-error-container');
    const phpError = document.getElementById('php-error-container');
    const card = form.closest('.animate-lock-slide-up');

    // Align localStorage with the backend state on page load
    const initialLockedState = '<?= $is_locked ? "true" : "false" ?>';
    localStorage.setItem('workspace_locked', initialLockedState);

    // Dynamic visibility controls (fade animations + pointer-events toggle)
    window.setLockscreenVisible = function(visible) {
        if (!overlay) return;
        
        if (visible) {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            overlay.style.transition = 'none';
            overlay.style.opacity = '1';
            overlay.style.pointerEvents = 'auto';
            if (passwordInput) {
                passwordInput.value = '';
                // Focus with short timeout to guarantee input is interactive in browser
                setTimeout(() => passwordInput.focus(), 50);
            }
            if (phpError) phpError.classList.add('hidden');
            if (errorContainer) errorContainer.classList.add('hidden');
            if (card) card.classList.remove('lock-shake');
        } else {
            overlay.style.transition = 'opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
            overlay.style.opacity = '0';
            overlay.style.pointerEvents = 'none';
            setTimeout(() => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
                if (passwordInput) {
                    passwordInput.value = '';
                }
            }, 300);
        }
    };

    // Expose helpers globally for other scripts (e.g. admin.js)
    window.showLockscreen = () => {
        localStorage.setItem('workspace_locked', 'true');
        window.setLockscreenVisible(true);
    };
    window.hideLockscreen = () => {
        localStorage.setItem('workspace_locked', 'false');
        window.setLockscreenVisible(false);
    };

    // Cross-tab synchronization via storage events
    window.addEventListener('storage', function(e) {
        if (e.key === 'workspace_locked') {
            window.setLockscreenVisible(e.newValue === 'true');
        }
    });

    if (toggleBtn && passwordInput) {
        const eyeIcon = document.getElementById('eye-icon');
        const eyeOffIcon = document.getElementById('eye-off-icon');

        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            
            if (type === 'password') {
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            } else {
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            }
        });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const password = passwordInput.value;
        const csrfToken = form.querySelector('input[name="csrf_token"]').value;
        const redirectTo = form.querySelector('input[name="redirect_to"]').value;

        // Reset error states
        if (phpError) phpError.classList.add('hidden');
        errorContainer.classList.add('hidden');
        card.classList.remove('lock-shake');

        // Build parameters
        const formData = new FormData();
        formData.append('password', password);
        formData.append('csrf_token', csrfToken);
        formData.append('redirect_to', redirectTo);
        formData.append('ajax', '1');

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Workspace unlocked successfully: disappear and notify other tabs
                window.hideLockscreen();
                // Trigger a mousemove event to reset the inactivity timer in admin.js
                document.dispatchEvent(new MouseEvent('mousemove'));
            } else {
                passwordInput.value = '';
                passwordInput.focus();
                
                if (data.error === 'too_many_attempts') {
                    window.location.href = data.redirect || 'login.php?timeout=2';
                } else {
                    errorContainer.textContent = data.message || 'Incorrect password.';
                    errorContainer.classList.remove('hidden');
                    
                    // Force shake reflow
                    void card.offsetWidth;
                    card.classList.add('lock-shake');
                }
            }
        })
        .catch(err => {
            errorContainer.textContent = 'Connection error. Please try again.';
            errorContainer.classList.remove('hidden');
            card.classList.add('lock-shake');
        });
    });
})();
</script>

<?php if ($standalone): ?>
</body>
</html>
<?php endif; ?>
