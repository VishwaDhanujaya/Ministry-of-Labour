<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ministry of Labour</title>
    
    <!-- Google Fonts: Inter and Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/emblem.png" type="image/png">
    
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        .font-inter { font-family: 'Inter', sans-serif; }
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        
        /* Custom Placeholder Styles to accommodate the red asterisk */
        .custom-placeholder-input:not(:placeholder-shown) + .custom-placeholder-label {
            opacity: 0;
            visibility: hidden;
        }
        .custom-placeholder-input:focus + .custom-placeholder-label {
            opacity: 0;
            visibility: hidden;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased font-inter h-screen flex overflow-hidden">

    <!-- Left Side: Image with Gradient Overlay -->
    <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center bg-[#4E0000]">
        <!-- Background Image (using inline style for reliable loading without Tailwind compilation) -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('assets/img/login-admin.webp');"></div>
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 z-0" style="background: linear-gradient(180deg, rgba(78, 0, 0, 0.81) 0%, rgba(78, 0, 0, 0.9) 100%);"></div>
        
        <!-- Logo -->
        <div class="relative z-10 flex flex-col items-center">
            <img src="../assets/img/logo.png" alt="Ministry of Labour Logo" class="w-80 lg:w-[420px] h-auto object-contain drop-shadow-md">
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center relative p-8">
        
        <div class="w-full max-w-[420px]">
            <h2 class="text-[36px] font-bold text-black text-center mb-12 font-montserrat">Admin Login</h2>
            
            <form action="index.php" method="POST" class="space-y-6">
                <!-- Email Input -->
                <div class="relative">
                    <input type="email" id="email" name="email" required
                        class="custom-placeholder-input w-full px-4 py-3.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#4E0000] focus:border-[#4E0000] transition-colors"
                        placeholder=" ">
                    <label for="email" class="custom-placeholder-label absolute text-sm text-gray-500 left-4 top-1/2 -translate-y-1/2 pointer-events-none transition-all flex items-center gap-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                </div>
                
                <!-- Password Input -->
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="custom-placeholder-input w-full px-4 py-3.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-[#4E0000] focus:border-[#4E0000] transition-colors"
                        placeholder=" ">
                    <label for="password" class="custom-placeholder-label absolute text-sm text-gray-500 left-4 top-1/2 -translate-y-1/2 pointer-events-none transition-all flex items-center gap-1">
                        Password <span class="text-red-500">*</span>
                    </label>
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
            © 2025 Copyright SLTDIGITAL
        </div>
    </div>

</body>
</html>
