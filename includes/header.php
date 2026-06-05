<?php
$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Best Practices -->
    <title>Ministry of Labour - Government of Sri Lanka</title>
    <meta name="description"
        content="Official portal of the Ministry of Labour, Sri Lanka. Committed to protecting workforce rights, maintaining industrial peace, social security (EPF), and workplace occupational safety.">
    <meta name="keywords"
        content="Ministry of Labour, Sri Lanka Labour, EPF, ETF, Labour Laws Sri Lanka, Employees Provident Fund, Mehewara Piyasa, Industrial Relations, Occupational Safety">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.labour.gov.lk/">
    <meta property="og:title" content="Ministry of Labour - Government of Sri Lanka">
    <meta property="og:description"
        content="Protecting workforce rights, maintaining industrial peace, and enhancing employee welfare for national economic development in Sri Lanka.">
    <meta property="og:image" content="assets/img/og-preview.jpg">

    <!-- Google Fonts: Inter and Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Favicon / Tab Emblem -->
    <link rel="icon" href="assets/img/emblem.png" type="image/png">

    <!-- Compiled Tailwind and Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-white text-gray-800 antialiased scroll-smooth">

    <!-- Top Bar -->
    <div
        class="hidden md:flex bg-[#2D2D43] text-white text-[11px] md:text-xs py-2 px-4 md:px-8 flex-col md:flex-row justify-between items-center font-inter border-b border-white/10 relative z-40">
        <div class="flex flex-wrap gap-x-6 gap-y-2 items-center mb-2 md:mb-0 justify-center md:justify-start">
            <a href="mailto:info@labour.gov.lk"
                class="flex items-center space-x-2 hover:text-yellow-400 transition-colors duration-200">
                <svg class="w-3.5 h-3.5 text-yellow-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                <span>info@labour.gov.lk</span>
            </a>
            <a href="tel:+94112581141"
                class="flex items-center space-x-2 hover:text-yellow-400 transition-colors duration-200">
                <svg class="w-3.5 h-3.5 text-yellow-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                    </path>
                </svg>
                <span>+94 11 2581141</span>
            </a>
            <span class="flex items-center space-x-2 text-white/90">
                <svg class="w-3.5 h-3.5 text-yellow-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                <span>Fax: (+94) 11 2368165</span>
            </span>
        </div>
        <div class="flex space-x-5 items-center">
            <div class="flex space-x-3 text-white/80">
                <a href="#" aria-label="Facebook Link" class="hover:text-yellow-400 transition-colors duration-200"><svg
                        class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                    </svg></a>
                <a href="#" aria-label="Twitter Link" class="hover:text-yellow-400 transition-colors duration-200"><svg
                        class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                    </svg></a>
                <a href="#" aria-label="YouTube Link" class="hover:text-yellow-400 transition-colors duration-200"><svg
                        class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg></a>
            </div>
            <span class="text-white/20">|</span>
            <!-- Language Selector -->
            <div class="flex space-x-2 text-white/85 font-semibold font-inter">
                <button
                    class="hover:text-yellow-400 transition-colors duration-200 px-1 rounded text-yellow-400 font-bold">EN</button>
                <span class="text-white/25">/</span>
                <button class="hover:text-yellow-400 transition-colors duration-200 px-1 rounded">SI</button>
                <span class="text-white/25">/</span>
                <button class="hover:text-yellow-400 transition-colors duration-200 px-1 rounded">TA</button>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header
        class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm transition-all duration-300"
        id="main-header">
        <div class="container mx-auto px-4 md:px-8 py-3.5 flex justify-between items-center">
            <!-- Logo Area -->
            <div class="flex items-center">
                <img src="assets/img/logo-black.png" alt="Ministry of Labour - Government of Sri Lanka"
                    class="h-12 md:h-14 w-auto object-contain">
            </div>

            <!-- Desktop Navigation with Interactive Dropdowns -->
            <nav class="hidden xl:flex items-center space-x-3 xl:space-x-4 2xl:space-x-6 font-inter text-[13px] font-bold text-gray-700">
                <a href="index.php" class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'index' || $current_page == '') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">Home</a>

                <a href="about-us"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'about-us') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">About
                    Us</a>

                <a href="iau"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'iau') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">IAU</a>

                <a href="rti"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'rti') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">RTI</a>

                <a href="citizen-charter"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'citizen-charter') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">Citizen
                    Charter</a>

                <!-- Dropdown Circuit Bungalow -->
                <div
                    class="relative group cursor-pointer flex items-center hover:text-[#13273F] transition-colors pb-1.5 border-b-2 border-transparent hover:border-gray-300">
                    <span>Circuit Bungalow</span>
                    <svg class="w-3.5 h-3.5 ml-1 text-gray-400 group-hover:text-[#13273F] transition-transform duration-200 group-hover:rotate-180"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <!-- Dropdown -->
                    <div
                        class="dropdown-bridge absolute left-1/2 transform -translate-x-1/2 top-[100%] mt-2.5 w-56 bg-white border-[0.5px] border-[#D4D4D4] rounded-xl shadow-xl py-3 px-1.5 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-50">
                        <a href="ampara-circuit-bungalow"
                            class="block px-4 py-2.5 text-gray-600 hover:text-[#13273F] hover:bg-gray-50 rounded-lg transition-colors font-semibold">Ampara
                            Circuit Bungalow</a>
                    </div>
                </div>

                <a href="downloads"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'downloads') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">Downloads</a>

                <a href="articles"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'articles') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">Articles</a>

                <a href="gallery"
                    class="pb-1.5 border-b-2 transition-all <?= ($current_page == 'gallery') ? 'text-[#13273F] border-[#13273F]' : 'hover:text-[#13273F] border-transparent hover:border-gray-300' ?>">Gallery</a>

                <a href="contact-us"
                    class="bg-[#4E0000] text-white px-4 py-2.5 rounded-lg hover:bg-[#320000] transition-all duration-300 hover:shadow-md font-medium text-xs tracking-wider uppercase active:scale-95">Contact
                    Us</a>

                <div class="h-5 w-px bg-gray-200 mx-2 shrink-0"></div>

                <!-- Expanding Search Bar Container -->
                <div class="relative flex items-center">
                    <div id="search-bar-container"
                        class="flex items-center bg-white border border-gray-200 rounded-lg px-2 py-1 shadow-sm opacity-0 pointer-events-none transition-all duration-300 w-0 overflow-hidden absolute right-0 top-1/2 -translate-y-1/2 z-50">
                        <input type="text" id="header-search-input" placeholder="Search..."
                            class="w-full bg-transparent text-xs font-inter focus:outline-none pr-6 pl-1 py-0.5">
                        <button id="search-close-btn"
                            class="absolute right-2 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <button id="search-btn" aria-label="Search"
                        class="text-gray-400 hover:text-[#13273F] p-1.5 hover:bg-gray-50 rounded-lg transition-all duration-200 flex items-center justify-center shrink-0 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </nav>

            <!-- Mobile Menu Trigger Button -->
            <button id="mobile-menu-trigger" aria-label="Open Mobile Menu"
                class="xl:hidden text-[#13273F] hover:bg-gray-50 p-1.5 rounded-lg focus:outline-none transition-colors duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Mobile Slide-out Menu Drawer -->
    <div id="mobile-menu"
        class="fixed inset-0 bg-[#13273F]/40 backdrop-blur-sm z-[100] opacity-0 pointer-events-none transition-all duration-300">
        <div id="mobile-menu-drawer"
            class="absolute right-0 top-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-2xl p-6 flex flex-col transform translate-x-full transition-transform duration-300 ease-out overflow-y-auto">
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                <div class="flex items-center">
                    <img src="assets/img/logo-black.png" alt="Ministry of Labour - Government of Sri Lanka" class="h-10 w-auto object-contain">
                </div>
                <button id="mobile-menu-close" aria-label="Close Mobile Menu"
                    class="p-1 rounded-lg text-gray-400 hover:text-primary hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <nav class="flex-grow flex flex-col space-y-4 font-inter text-[13px] font-bold text-gray-700">
                <a href="index.php"
                    class="pl-3 py-1 <?= ($current_page == 'index' || $current_page == '') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">Home</a>
                <a href="about-us" class="pl-3 py-1 <?= ($current_page == 'about-us') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">About Us</a>
                <a href="iau" class="pl-3 py-1 <?= ($current_page == 'iau') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">IAU</a>
                <a href="rti" class="pl-3 py-1 <?= ($current_page == 'rti') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">RTI</a>
                <a href="citizen-charter" class="pl-3 py-1 <?= ($current_page == 'citizen-charter') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">Citizen Charter</a>

                <!-- Collapse Item: Circuit Bungalow -->
                <div>
                    <button
                        class="w-full flex justify-between items-center hover:text-[#13273F] hover:bg-gray-50 pl-3 pr-2 py-1.5 rounded mobile-collapse-btn transition-colors duration-200">
                        <span>Circuit Bungalow</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div
                        class="hidden pl-6 pr-2 py-2 flex-col space-y-2.5 mt-1 bg-gray-50 rounded-lg text-xs font-semibold">
                        <a href="ampara-circuit-bungalow" class="text-gray-600 hover:text-primary transition-colors">Ampara Circuit
                            Bungalow</a>
                    </div>
                </div>

                <a href="downloads" class="pl-3 py-1 <?= ($current_page == 'downloads') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">Downloads</a>
                <a href="articles" class="pl-3 py-1 <?= ($current_page == 'articles') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">Articles</a>
                <a href="gallery" class="pl-3 py-1 <?= ($current_page == 'gallery') ? 'text-[#13273F] bg-gray-50 border-l-4 border-[#13273F] rounded-r-md' : 'hover:text-primary rounded transition-colors' ?>">Gallery</a>
            </nav>

            <div class="border-t border-gray-100 pt-6 mt-6 flex flex-col space-y-4">
                <a href="contact-us"
                    class="bg-secondary text-white text-center py-2.5 rounded-lg hover:bg-[#320000] transition-colors shadow-sm font-semibold text-xs tracking-wider uppercase">Contact
                    Us</a>
                <div class="flex justify-center space-x-5 text-gray-400 py-2">
                    <a href="#" class="hover:text-primary transition-colors duration-200"><svg class="w-5 h-5"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg></a>
                    <a href="#" class="hover:text-primary transition-colors duration-200"><svg class="w-5 h-5"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg></a>
                </div>
            </div>
        </div>
    </div>