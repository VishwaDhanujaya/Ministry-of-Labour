/**
 * Ministry of Labour - Official JS Assets
 * Robust client-side features for modern, premium interaction.
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // ==========================================
    // 1. STICKY NAVIGATION BLUR
    // ==========================================
    const header = document.getElementById('main-header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 30) {
                header.classList.add('shadow-md', 'bg-white/95', 'backdrop-blur-md');
                header.classList.remove('shadow-sm');
            } else {
                header.classList.add('shadow-sm');
                header.classList.remove('shadow-md', 'bg-white/95', 'backdrop-blur-md');
            }
        });
    }

    // ==========================================
    // 2. MOBILE MENU DRAWER TOGGLES
    // ==========================================
    const menuTrigger = document.getElementById('mobile-menu-trigger');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileDrawer = document.getElementById('mobile-menu-drawer');
    const menuClose = document.getElementById('mobile-menu-close');

    const openMobileMenu = () => {
        if (mobileMenu && mobileDrawer) {
            mobileMenu.classList.remove('opacity-0', 'pointer-events-none', 'invisible');
            mobileDrawer.classList.remove('translate-x-full');
            document.body.classList.add('overflow-hidden');
        }
    };

    const closeMobileMenu = () => {
        if (mobileMenu && mobileDrawer) {
            mobileMenu.classList.add('opacity-0', 'pointer-events-none', 'invisible');
            mobileDrawer.classList.add('translate-x-full');
            document.body.classList.remove('overflow-hidden');
        }
    };

    if (menuTrigger) menuTrigger.addEventListener('click', openMobileMenu);
    if (menuClose) menuClose.addEventListener('click', closeMobileMenu);
    if (mobileMenu) {
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) closeMobileMenu();
        });
    }

    // Mobile Navigation Accordion Expanders
    const collapseBtns = document.querySelectorAll('.mobile-collapse-btn');
    collapseBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('svg');
            if (content) {
                content.classList.toggle('hidden');
                if (icon) icon.classList.toggle('rotate-180');
            }
        });
    });

    // ==========================================
    // 3. ACCESSIBILITY SYSTEM & MENU
    // ==========================================
    const a11yBtn = document.getElementById('accessibility-menu-btn');
    const a11yDropdown = document.getElementById('accessibility-dropdown');
    const a11yChevron = document.getElementById('a11y-chevron');
    const a11yContainer = document.getElementById('accessibility-menu-container');
    const a11yResetBtn = document.getElementById('a11y-reset-btn');
    const a11yToggleLinksBtn = document.getElementById('a11y-toggle-links');
    const a11yLinksIndicator = document.getElementById('a11y-links-indicator');
    
    // TTS Control Elements
    const a11yCloseBtn = document.getElementById('a11y-close-btn');
    const a11yTtsMasterBtn = document.getElementById('a11y-tts-master-btn');
    const a11yTtsMasterSwitch = document.getElementById('a11y-tts-master-switch');
    const a11yTtsOptions = document.getElementById('a11y-tts-options');
    const a11yTtsReadPageBtn = document.getElementById('a11y-tts-read-page-btn');
    const a11yTtsStopBtn = document.getElementById('a11y-tts-stop-btn');
    const a11yTtsHoverBtn = document.getElementById('a11y-tts-hover-btn');
    const a11yTtsHoverSwitch = document.getElementById('a11y-tts-hover-switch');
    const a11yTtsSelectionBtn = document.getElementById('a11y-tts-selection-btn');
    const a11yTtsSelectionSwitch = document.getElementById('a11y-tts-selection-switch');
    const a11yTtsLiveWave = document.getElementById('a11y-tts-live-wave');
    const htmlEl = document.documentElement;

    // Toggle Dropdown Panel
    const toggleA11yDropdown = (show) => {
        if (!a11yDropdown) return;
        const isCurrentlyOpen = !a11yDropdown.classList.contains('opacity-0');
        const open = (typeof show === 'boolean') ? show : !isCurrentlyOpen;

        if (open) {
            a11yDropdown.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
            a11yDropdown.classList.add('opacity-100', 'translate-y-0');
            if (a11yChevron) a11yChevron.classList.add('rotate-180');
            if (a11yBtn) {
                a11yBtn.setAttribute('aria-expanded', 'true');
                a11yBtn.classList.add('ring-2', 'ring-yellow-400', 'ring-offset-2');
            }
        } else {
            a11yDropdown.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
            a11yDropdown.classList.remove('opacity-100', 'translate-y-0');
            if (a11yChevron) a11yChevron.classList.remove('rotate-180');
            if (a11yBtn) {
                a11yBtn.setAttribute('aria-expanded', 'false');
                a11yBtn.classList.remove('ring-2', 'ring-yellow-400', 'ring-offset-2');
            }
        }
    };

    if (a11yBtn) {
        a11yBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleA11yDropdown();
        });
    }

    if (a11yCloseBtn) {
        a11yCloseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleA11yDropdown(false);
        });
    }

    // Close on click outside
    document.addEventListener('click', (e) => {
        if (a11yContainer && !a11yContainer.contains(e.target)) {
            toggleA11yDropdown(false);
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            toggleA11yDropdown(false);
        }
    });

    // Font Sizing Controller
    const sizeBtns = document.querySelectorAll('[data-a11y-size]');
    const setFontSize = (size, persist = true) => {
        if (!['sm', 'md', 'lg', 'xl'].includes(size)) size = 'md';
        if (size === 'md') {
            htmlEl.removeAttribute('data-a11y-size');
        } else {
            htmlEl.setAttribute('data-a11y-size', size);
        }

        sizeBtns.forEach(btn => {
            const btnSize = btn.getAttribute('data-a11y-size');
            if (btnSize === size) {
                btn.classList.add('bg-primary', 'text-white', 'shadow-sm');
                btn.classList.remove('text-gray-600', 'hover:bg-white');
            } else {
                btn.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                btn.classList.add('text-gray-600', 'hover:bg-white');
            }
        });

        if (persist) {
            try { localStorage.setItem('a11y_font_size', size); } catch(e) {}
        }
    };

    sizeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const size = btn.getAttribute('data-a11y-size');
            setFontSize(size);
        });
    });

    // Color Blindness & Display Modes Controller (Normal, Grayscale, Protanopia, Deuteranopia, Tritanopia)
    const colorBtns = document.querySelectorAll('[data-a11y-color]');
    const setColorMode = (mode, persist = true) => {
        if (!['normal', 'grayscale', 'protanopia', 'deuteranopia', 'tritanopia'].includes(mode)) mode = 'normal';
        htmlEl.classList.remove('a11y-color-grayscale', 'a11y-color-protanopia', 'a11y-color-deuteranopia', 'a11y-color-tritanopia', 'a11y-high-contrast', 'a11y-grayscale');
        if (mode !== 'normal') {
            htmlEl.classList.add('a11y-color-' + mode);
        }

        colorBtns.forEach(btn => {
            const btnMode = btn.getAttribute('data-a11y-color');
            const checkIcon = btn.querySelector('.a11y-color-check span');
            if (btnMode === mode) {
                btn.classList.add('border-primary', 'ring-2', 'ring-primary/15', 'bg-primary/5', 'text-primary');
                btn.classList.remove('border-gray-200', 'text-gray-700');
                if (checkIcon) checkIcon.classList.remove('opacity-0');
            } else {
                btn.classList.remove('border-primary', 'ring-2', 'ring-primary/15', 'bg-primary/5', 'text-primary');
                btn.classList.add('border-gray-200', 'text-gray-700');
                if (checkIcon) checkIcon.classList.add('opacity-0');
            }
        });

        if (persist) {
            try { 
                localStorage.setItem('a11y_color_mode', mode);
                localStorage.removeItem('a11y_contrast');
            } catch(e) {}
        }
    };

    colorBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const mode = btn.getAttribute('data-a11y-color');
            setColorMode(mode);
        });
    });

    // Highlight Links Toggle
    const setHighlightLinks = (active, persist = true) => {
        if (active) {
            htmlEl.classList.add('a11y-highlight-links');
            if (a11yLinksIndicator) {
                a11yLinksIndicator.classList.add('border-primary', 'bg-primary');
                const dot = a11yLinksIndicator.querySelector('span');
                if (dot) {
                    dot.classList.remove('opacity-0', 'bg-primary');
                    dot.classList.add('bg-white');
                }
            }
        } else {
            htmlEl.classList.remove('a11y-highlight-links');
            if (a11yLinksIndicator) {
                a11yLinksIndicator.classList.remove('border-primary', 'bg-primary');
                const dot = a11yLinksIndicator.querySelector('span');
                if (dot) {
                    dot.classList.add('opacity-0');
                    dot.classList.remove('bg-white');
                }
            }
        }
        if (persist) {
            try { localStorage.setItem('a11y_highlight_links', active ? '1' : '0'); } catch(e) {}
        }
    };

    if (a11yToggleLinksBtn) {
        a11yToggleLinksBtn.addEventListener('click', () => {
            const isActive = htmlEl.classList.contains('a11y-highlight-links');
            setHighlightLinks(!isActive);
        });
    }

    // ==========================================
    // TEXT-TO-SPEECH (TTS) ADVANCED ENGINE
    // ==========================================
    let isSpeaking = false;
    let currentSpeechElement = null;
    let ttsEnabled = false;
    let ttsHoverEnabled = false;
    let ttsSelectionEnabled = false;
    let hoverDebounceTimer = null;

    const stopSpeech = () => {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
        }
        isSpeaking = false;
        if (currentSpeechElement) {
            currentSpeechElement.classList.remove('a11y-tts-reading');
            currentSpeechElement = null;
        }

        if (a11yTtsLiveWave) {
            a11yTtsLiveWave.classList.add('hidden');
            a11yTtsLiveWave.classList.remove('flex');
        }
    };

    const getPreferredVoice = (lang) => {
        if (!('speechSynthesis' in window)) return null;
        const voices = window.speechSynthesis.getVoices();
        if (!voices || voices.length === 0) return null;

        let langPrefix = 'en';
        if (lang === 'si') langPrefix = 'si';
        else if (lang === 'ta') langPrefix = 'ta';

        return voices.find(v => v.lang && v.lang.toLowerCase().startsWith(langPrefix)) || 
               voices.find(v => v.lang && v.lang.toLowerCase().startsWith('en')) || 
               voices[0];
    };

    const speakText = (text, targetElement = null) => {
        if (!('speechSynthesis' in window) || !text || !text.trim()) {
            return;
        }

        stopSpeech();

        const currentLang = document.querySelector('meta[name="mol-lang"]')?.content || 'en';
        const utterance = new SpeechSynthesisUtterance(text.trim());
        
        if (currentLang === 'si') utterance.lang = 'si-LK';
        else if (currentLang === 'ta') utterance.lang = 'ta-LK';
        else utterance.lang = 'en-US';

        utterance.rate = 0.95;
        utterance.pitch = 1.0;

        const voice = getPreferredVoice(currentLang);
        if (voice) utterance.voice = voice;

        if (targetElement) {
            currentSpeechElement = targetElement;
            targetElement.classList.add('a11y-tts-reading');
        }

        utterance.onstart = () => {
            isSpeaking = true;
            if (a11yTtsLiveWave) {
                a11yTtsLiveWave.classList.remove('hidden');
                a11yTtsLiveWave.classList.add('flex');
            }
        };

        utterance.onend = () => {
            stopSpeech();
        };

        utterance.onerror = () => {
            stopSpeech();
        };

        window.speechSynthesis.speak(utterance);
    };

    // Update Switch Visuals
    const updateTtsSwitchesUI = () => {
        if (a11yTtsMasterSwitch) {
            const dot = a11yTtsMasterSwitch.querySelector('span');
            if (ttsEnabled) {
                a11yTtsMasterSwitch.classList.remove('bg-gray-300');
                a11yTtsMasterSwitch.classList.add('bg-primary');
                if (dot) dot.classList.add('translate-x-3.5');
            } else {
                a11yTtsMasterSwitch.classList.add('bg-gray-300');
                a11yTtsMasterSwitch.classList.remove('bg-primary');
                if (dot) dot.classList.remove('translate-x-3.5');
            }
        }

        if (a11yTtsOptions) {
            if (ttsEnabled) {
                a11yTtsOptions.classList.remove('hidden');
            } else {
                a11yTtsOptions.classList.add('hidden');
            }
        }

        if (a11yTtsHoverSwitch) {
            const dot = a11yTtsHoverSwitch.querySelector('span');
            if (ttsHoverEnabled) {
                a11yTtsHoverSwitch.classList.remove('bg-gray-300');
                a11yTtsHoverSwitch.classList.add('bg-primary');
                if (dot) dot.classList.add('translate-x-3');
            } else {
                a11yTtsHoverSwitch.classList.add('bg-gray-300');
                a11yTtsHoverSwitch.classList.remove('bg-primary');
                if (dot) dot.classList.remove('translate-x-3');
            }
        }

        if (a11yTtsSelectionSwitch) {
            const dot = a11yTtsSelectionSwitch.querySelector('span');
            if (ttsSelectionEnabled) {
                a11yTtsSelectionSwitch.classList.remove('bg-gray-300');
                a11yTtsSelectionSwitch.classList.add('bg-primary');
                if (dot) dot.classList.add('translate-x-3');
            } else {
                a11yTtsSelectionSwitch.classList.add('bg-gray-300');
                a11yTtsSelectionSwitch.classList.remove('bg-primary');
                if (dot) dot.classList.remove('translate-x-3');
            }
        }
    };

    // Set Master TTS
    const setTtsMaster = (enabled, persist = true) => {
        ttsEnabled = !!enabled;
        if (!ttsEnabled) {
            stopSpeech();
        }
        updateTtsSwitchesUI();
        if (persist) {
            try { localStorage.setItem('a11y_tts_enabled', ttsEnabled ? '1' : '0'); } catch(e) {}
        }
    };

    // Set Read on Hover
    const setTtsHover = (enabled, persist = true) => {
        ttsHoverEnabled = !!enabled;
        if (ttsHoverEnabled && !ttsEnabled) {
            setTtsMaster(true, persist);
        }
        updateTtsSwitchesUI();
        if (persist) {
            try { localStorage.setItem('a11y_tts_hover', ttsHoverEnabled ? '1' : '0'); } catch(e) {}
        }
    };

    // Set Read on Selection
    const setTtsSelection = (enabled, persist = true) => {
        ttsSelectionEnabled = !!enabled;
        if (ttsSelectionEnabled && !ttsEnabled) {
            setTtsMaster(true, persist);
        }
        updateTtsSwitchesUI();
        if (persist) {
            try { localStorage.setItem('a11y_tts_selection', ttsSelectionEnabled ? '1' : '0'); } catch(e) {}
        }
    };

    // Read Page Action
    const readCurrentPage = () => {
        if (!ttsEnabled) setTtsMaster(true);

        const readableTargets = document.querySelectorAll('main p, main h1, main h2, main h3, article p, section p, .page-header h1, #content p');
        let combinedText = '';
        let firstEl = null;

        for (const el of readableTargets) {
            if (el.closest('#accessibility-dropdown') || el.closest('header') || el.closest('footer') || el.closest('#mobile-menu-drawer')) continue;
            const text = el.textContent?.trim();
            if (text && text.length > 10) {
                if (!firstEl) firstEl = el;
                combinedText += text + '. ';
                if (combinedText.length > 600) break;
            }
        }

        if (!combinedText.trim()) {
            const heading = document.querySelector('h1')?.textContent || document.title;
            combinedText = heading;
        }

        speakText(combinedText, firstEl);
    };

    // Event Listeners for TTS Controls
    if (a11yTtsMasterBtn) {
        a11yTtsMasterBtn.addEventListener('click', () => {
            setTtsMaster(!ttsEnabled);
        });
    }

    if (a11yTtsReadPageBtn) {
        a11yTtsReadPageBtn.addEventListener('click', readCurrentPage);
    }

    if (a11yTtsStopBtn) {
        a11yTtsStopBtn.addEventListener('click', stopSpeech);
    }

    if (a11yTtsHoverBtn) {
        a11yTtsHoverBtn.addEventListener('click', () => {
            setTtsHover(!ttsHoverEnabled);
        });
    }

    if (a11yTtsSelectionBtn) {
        a11yTtsSelectionBtn.addEventListener('click', () => {
            setTtsSelection(!ttsSelectionEnabled);
        });
    }

    // Read on Hover Listener
    document.addEventListener('mouseover', (e) => {
        if (!ttsEnabled || !ttsHoverEnabled) return;
        const target = e.target.closest('p, h1, h2, h3, h4, h5, h6, a, li, button');
        if (!target) return;
        if (target.closest('#accessibility-dropdown') || target.closest('#mobile-menu-drawer')) return;

        clearTimeout(hoverDebounceTimer);
        hoverDebounceTimer = setTimeout(() => {
            const text = target.textContent?.trim();
            if (text && text.length > 2 && text.length < 500) {
                speakText(text, target);
            }
        }, 350);
    });

    document.addEventListener('mouseout', (e) => {
        clearTimeout(hoverDebounceTimer);
    });

    // Read on Selection Listener
    document.addEventListener('mouseup', () => {
        if (!ttsEnabled || !ttsSelectionEnabled) return;
        setTimeout(() => {
            const selectedText = window.getSelection()?.toString();
            if (selectedText && selectedText.trim().length > 2) {
                speakText(selectedText);
            }
        }, 100);
    });

    window.addEventListener('beforeunload', stopSpeech);

    // Reset All Settings
    const resetA11ySettings = () => {
        stopSpeech();
        try {
            localStorage.removeItem('a11y_font_size');
            localStorage.removeItem('a11y_color_mode');
            localStorage.removeItem('a11y_contrast');
            localStorage.removeItem('a11y_highlight_links');
            localStorage.removeItem('a11y_tts_enabled');
            localStorage.removeItem('a11y_tts_hover');
            localStorage.removeItem('a11y_tts_selection');
        } catch(e) {}

        setFontSize('md', false);
        setColorMode('normal', false);
        setHighlightLinks(false, false);
        setTtsMaster(false, false);
        setTtsHover(false, false);
        setTtsSelection(false, false);
    };

    if (a11yResetBtn) {
        a11yResetBtn.addEventListener('click', resetA11ySettings);
    }

    // Initialize UI active states from localStorage
    try {
        const savedFontSize = localStorage.getItem('a11y_font_size') || 'md';
        const savedColorMode = localStorage.getItem('a11y_color_mode') || localStorage.getItem('a11y_contrast') || 'normal';
        const savedHighlightLinks = localStorage.getItem('a11y_highlight_links') === '1';
        const savedTtsEnabled = localStorage.getItem('a11y_tts_enabled') === '1';
        const savedTtsHover = localStorage.getItem('a11y_tts_hover') === '1';
        const savedTtsSelection = localStorage.getItem('a11y_tts_selection') === '1';

        setFontSize(savedFontSize, false);
        setColorMode(savedColorMode, false);
        setHighlightLinks(savedHighlightLinks, false);
        setTtsMaster(savedTtsEnabled, false);
        setTtsHover(savedTtsHover, false);
        setTtsSelection(savedTtsSelection, false);
    } catch(e) {}



    // ==========================================
    // 5. STATS ANIMATED COUNT-UP ON SCROLL
    // ==========================================
    const statBoxes = document.querySelectorAll('.stat-box');
    let countTriggered = false;

    const animateStats = () => {
        if (countTriggered) return;
        statBoxes.forEach(box => {
            const numEl = box.querySelector('.stat-number');
            if (!numEl) return;
            const targetVal = parseFloat(box.getAttribute('data-target'));
            const isMillion = box.getAttribute('data-target').includes('.');
            const duration = 1800; // ms
            let startTime = null;

            const step = (timestamp) => {
                if (!startTime) startTime = timestamp;
                const progress = Math.min((timestamp - startTime) / duration, 1);
                const currentVal = progress * targetVal;
                
                if (isMillion) {
                    numEl.innerText = currentVal.toFixed(1);
                } else {
                    numEl.innerText = Math.floor(currentVal).toLocaleString();
                }

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    numEl.innerText = targetVal;
                }
            };
            window.requestAnimationFrame(step);
        });
        countTriggered = true;
    };

    // Intersection observer trigger
    const statsSection = document.querySelector('.stat-box')?.parentElement?.parentElement;
    if (statsSection && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                animateStats();
                observer.disconnect();
            }
        }, { threshold: 0.15 });
        observer.observe(statsSection);
    } else {
        // Fallback for older browsers
        window.addEventListener('scroll', () => {
            if (statsSection) {
                const triggerPoint = statsSection.offsetTop - window.innerHeight + 100;
                if (window.scrollY > triggerPoint) {
                    animateStats();
                }
            }
        });
    }

    // ==========================================
    // 6. REUSABLE CAROUSEL SLIDER WITH DOTS
    // ==========================================
    const initDotSlider = (trackId, dotsContainerId, dotClassName) => {
        const track = document.getElementById(trackId);
        const dotsContainer = document.getElementById(dotsContainerId);

        if (!track || !dotsContainer) return;

        // Clear existing static dots if any
        dotsContainer.innerHTML = '';

        const slidesCount = track.children.length;
        if (slidesCount <= 1) return;

        // Generate dots dynamically
        const dots = [];
        const isDarkBg = dotsContainerId.includes('carousel'); // Check if it needs dark background dots style

        for (let i = 0; i < slidesCount; i++) {
            const btn = document.createElement('button');
            btn.className = `rounded-full transition-all duration-300 ${dotClassName} shadow-sm`;
            btn.setAttribute('aria-label', `Go to slide ${i + 1}`);
            
            if (isDarkBg) {
                btn.classList.add('dark-bg-dot');
            }
            
            dotsContainer.appendChild(btn);
            dots.push(btn);
        }

        const updateDots = () => {
            if (!track.firstElementChild || dots.length === 0) return;
            
            // Check if slider actually needs to scroll
            if (track.scrollWidth <= track.clientWidth) {
                dotsContainer.classList.add('hidden');
                dotsContainer.classList.remove('flex');
                return;
            } else {
                dotsContainer.classList.remove('hidden');
                dotsContainer.classList.add('flex');
            }

            const scrollLeft = track.scrollLeft;
            let cardWidth = track.firstElementChild.offsetWidth;
            if (track.children.length > 1) {
                cardWidth = track.children[1].offsetLeft - track.children[0].offsetLeft;
            } else {
                cardWidth += 24; // fallback
            }
            
            // Calculate which card is closest to the left edge (center of view)
            const activeIndex = Math.round(scrollLeft / cardWidth);
            
            dots.forEach((dot, index) => {
                if (index === activeIndex) {
                    dot.classList.add('bg-secondary', 'w-8');
                    dot.classList.remove('bg-gray-300', 'bg-white/30', 'hover:bg-white/50', 'w-2.5');
                } else {
                    dot.classList.remove('bg-secondary', 'w-8');
                    if (dot.classList.contains('dark-bg-dot')) {
                        dot.classList.add('bg-white/30', 'hover:bg-white/50', 'w-2.5');
                    } else {
                        dot.classList.add('bg-gray-300', 'hover:bg-gray-400', 'w-2.5');
                    }
                }
            });
        };

        track.addEventListener('scroll', () => {
            window.requestAnimationFrame(updateDots);
        });
        
        window.addEventListener('resize', () => {
            window.requestAnimationFrame(updateDots);
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                let cardWidth = track.firstElementChild.offsetWidth;
                if (track.children.length > 1) {
                    cardWidth = track.children[1].offsetLeft - track.children[0].offsetLeft;
                } else {
                    cardWidth += 24;
                }
                track.scrollTo({ left: index * cardWidth, behavior: 'smooth' });
            });
        });
        
        // Initialize dots state
        setTimeout(updateDots, 100);
    };

    // Initialize Key Focus Areas Slider
    initDotSlider('carousel-track', 'carousel-dots-container', 'carousel-dot');
    // Initialize Partners Slider
    initDotSlider('partners-track', 'partners-dots-container', 'partner-dot');

    // ==========================================
    // 7. CITIZEN SERVICES LIVE SEARCH FILTER
    // ==========================================
    const searchInput = document.getElementById('services-search');
    const serviceCards = document.querySelectorAll('.service-card');
    const noResults = document.getElementById('search-no-results');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            serviceCards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                const keywords = card.getAttribute('data-keywords').toLowerCase();

                if (title.includes(query) || keywords.includes(query)) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (visibleCount === 0 && query !== '') {
                if (noResults) noResults.classList.remove('hidden');
            } else {
                if (noResults) noResults.classList.add('hidden');
            }
        });
    }

    // ==========================================
    // 8. MEDIA LIGHTBOX MODAL OVERLAY
    // ==========================================
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.getElementById('lightbox-modal');
    const lightboxClose = document.getElementById('lightbox-close');
    const lightboxCaption = document.getElementById('lightbox-caption');

    if (galleryItems && lightbox) {
        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const caption = item.getAttribute('data-caption');
                if (lightboxCaption) lightboxCaption.innerText = caption;
                
                const img = item.querySelector('img');
                const lightboxImageEl = document.getElementById('lightbox-img');
                const lightboxPlaceholder = document.getElementById('lightbox-placeholder');
                
                if (img && lightboxImageEl) {
                    lightboxImageEl.src = img.src;
                    lightboxImageEl.alt = img.alt || caption;
                    lightboxImageEl.classList.remove('hidden');
                    if (lightboxPlaceholder) lightboxPlaceholder.classList.add('hidden');
                } else {
                    if (lightboxImageEl) lightboxImageEl.classList.add('hidden');
                    if (lightboxPlaceholder) lightboxPlaceholder.classList.remove('hidden');
                }
                
                lightbox.classList.remove('hidden', 'pointer-events-none');
                lightbox.classList.add('flex');
                setTimeout(() => {
                    lightbox.classList.remove('opacity-0');
                    const card = lightbox.querySelector('.transform');
                    if(card) { card.classList.remove('scale-95'); card.classList.add('scale-100'); }
                }, 10);
                document.body.classList.add('overflow-hidden');
            });
        });

        const closeLightbox = () => {
            lightbox.classList.add('opacity-0');
            const card = lightbox.querySelector('.transform');
            if(card) { card.classList.remove('scale-100'); card.classList.add('scale-95'); }
            setTimeout(() => {
                lightbox.classList.add('hidden', 'pointer-events-none');
                lightbox.classList.remove('flex');
            }, 300);
            document.body.classList.remove('overflow-hidden');
            
            const lightboxImageEl = document.getElementById('lightbox-img');
            const lightboxPlaceholder = document.getElementById('lightbox-placeholder');
            if (lightboxImageEl) {
                lightboxImageEl.src = '';
                lightboxImageEl.classList.add('hidden');
            }
            if (lightboxPlaceholder) lightboxPlaceholder.classList.remove('hidden');
        };

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLightbox();
        });
    }

     // ==========================================
     // 9. AFFILIATED INSTITUTIONS TABS
     // ==========================================
     const instBtns = document.querySelectorAll('.inst-split-tab');
     const instPanels = document.querySelectorAll('.inst-panel');
 
     instBtns.forEach(btn => {
         btn.addEventListener('click', function() {
             // Hide all panels
             instPanels.forEach(panel => {
                 panel.classList.remove('block', 'animate-[fadeIn_0.4s_ease-out]');
                 panel.classList.add('hidden');
             });
 
             // Show target panel
             const targetId = this.getAttribute('data-target');
             const targetPanel = document.getElementById('inst-panel-' + targetId);
             if (targetPanel) {
                 targetPanel.classList.remove('hidden');
                 setTimeout(() => {
                     targetPanel.classList.add('block', 'animate-[fadeIn_0.4s_ease-out]');
                 }, 10);
             }
 
             // Reset active states and set it on the clicked button
             instBtns.forEach(b => b.classList.remove('active'));
             this.classList.add('active');

             // Smoothly scroll clicked tab into center view on mobile
             if (window.innerWidth < 768) {
                 this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
             }
         });
     });

    // ==========================================
    // 10. NEWSLETTER FORM & TOAST BULLETINS
    // ==========================================
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const msg = newsletterForm.getAttribute('data-subscribed-msg') || 'Successfully subscribed!';
            if (window.showToast) {
                window.showToast(msg, 'success');
            }
            newsletterForm.reset();
        });
    }

    function initToastContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-6 right-6 z-[99999] flex flex-col gap-3 max-w-sm w-full pointer-events-none';
            document.body.appendChild(container);
        }
    }

    window.showToast = function(message, type = 'success') {
        initToastContainer();
        const container = document.getElementById('toast-container');
        
        // Prevent duplicate spam of identical active messages
        const existingToasts = Array.from(container.children);
        const isDuplicate = existingToasts.some(t => {
            const textEl = t.querySelector('.toast-msg');
            return textEl && textEl.textContent === message;
        });
        if (isDuplicate) return;

        const toastEl = document.createElement('div');
        
        const statusColors = {
            success: {
                bg: 'bg-green-500/10 border-green-500/20 text-green-400',
                bar: 'bg-green-500',
                icon: `<svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>`
            },
            error: {
                bg: 'bg-red-500/10 border-red-500/20 text-red-400',
                bar: 'bg-red-500',
                icon: `<svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>`
            },
            warning: {
                bg: 'bg-amber-500/10 border-amber-500/20 text-amber-400',
                bar: 'bg-amber-500',
                icon: `<svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`
            },
            info: {
                bg: 'bg-blue-500/10 border-blue-500/20 text-blue-400',
                bar: 'bg-blue-500',
                icon: `<svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
            }
        };
        
        const config = statusColors[type] || statusColors.info;
        
        toastEl.className = `relative overflow-hidden flex items-center gap-3.5 p-4 pr-10 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.3)] text-white text-[13px] font-semibold bg-[#13273F]/95 backdrop-blur-md border border-white/10 font-inter pointer-events-auto max-w-sm w-full animate-toast-in notranslate`;
        
        toastEl.innerHTML = `
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 ${config.bg} border border-current/10">
                ${config.icon}
            </div>
            <div class="flex-1 text-gray-100 font-inter leading-snug toast-msg">${message}</div>
            <button type="button" class="toast-close absolute top-1/2 -translate-y-1/2 right-3 text-white/40 hover:text-white transition-colors focus:outline-none p-1 rounded-md hover:bg-white/5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="absolute bottom-0 left-0 h-1 w-full ${config.bar}" id="toast-progress"></div>
        `;
        
        container.appendChild(toastEl);
        
        const progress = toastEl.querySelector('#toast-progress');
        const autoDismissTime = 4000;
        let timeRemaining = autoDismissTime;
        let startTime = Date.now();
        let dismissTimeout;
        
        // Bind progress bar animation
        if (progress) {
            progress.style.animation = `toast-progress ${autoDismissTime}ms linear forwards`;
        }

        function dismissToast() {
            toastEl.classList.remove('animate-toast-in');
            toastEl.classList.add('animate-toast-out');
            setTimeout(() => toastEl.remove(), 300);
        }
        
        dismissTimeout = setTimeout(dismissToast, autoDismissTime);
        
        // Hover interactions (Pause and Resume)
        toastEl.addEventListener('mouseenter', () => {
            clearTimeout(dismissTimeout);
            timeRemaining -= (Date.now() - startTime);
            if (progress) {
                progress.style.animationPlayState = 'paused';
            }
        });
        
        toastEl.addEventListener('mouseleave', () => {
            startTime = Date.now();
            dismissTimeout = setTimeout(dismissToast, timeRemaining);
            if (progress) {
                progress.style.animationPlayState = 'running';
            }
        });
        
        const closeBtn = toastEl.querySelector('.toast-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                clearTimeout(dismissTimeout);
                dismissToast();
            });
        }
    };

    // ==========================================
    // 11. FLOAT SCROLL-TO-TOP CONTROL WITH PROGRESS
    // ==========================================
    const backToTopBtn = document.getElementById('back-to-top');
    const progressCircle = document.getElementById('scroll-progress-circle');

    window.scrollToTop = function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };


    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) : 0;

            if (scrollTop > 300) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                backToTopBtn.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto');
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
            }

            if (progressCircle) {
                const dashoffset = 100 - (scrollPercent * 100);
                progressCircle.style.strokeDashoffset = dashoffset;
            }
        });
    }

    // ==========================================
    // 12. HEADER SEARCH BAR TOGGLE & AUTOCOMPLETE
    // ==========================================
    const searchBtn = document.getElementById('search-btn');
    const mobileSearchBtn = document.getElementById('mobile-search-btn');
    const searchBarContainer = document.getElementById('search-bar-container');
    const searchCloseBtn = document.getElementById('search-close-btn');
    const headerSearchInput = document.getElementById('header-search-input');
    const searchSuggestionsContainer = document.getElementById('search-suggestions-container');
    let searchDebounceTimeout = null;

    const showSuggestions = () => {
        if (!searchSuggestionsContainer) return;
        searchSuggestionsContainer.classList.remove('hidden');
        setTimeout(() => {
            searchSuggestionsContainer.classList.remove('scale-95', 'opacity-0');
            searchSuggestionsContainer.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    const hideSuggestions = () => {
        if (!searchSuggestionsContainer) return;
        searchSuggestionsContainer.classList.remove('scale-100', 'opacity-100');
        searchSuggestionsContainer.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            searchSuggestionsContainer.classList.add('hidden');
        }, 200);
    };

    const openHeaderSearch = () => {
        if (!searchBarContainer) return;
        searchBarContainer.classList.remove('opacity-0', 'pointer-events-none', 'w-0');
        searchBarContainer.classList.add('opacity-100', 'pointer-events-auto', 'w-[calc(100vw-2rem)]', 'sm:w-80', 'md:w-96');
        if (headerSearchInput) {
            headerSearchInput.value = '';
            headerSearchInput.focus();
        }
    };

    const closeHeaderSearch = () => {
        if (!searchBarContainer) return;
        searchBarContainer.classList.remove('opacity-100', 'pointer-events-auto', 'w-[calc(100vw-2rem)]', 'sm:w-80', 'md:w-96');
        searchBarContainer.classList.add('opacity-0', 'pointer-events-none', 'w-0');
        if (headerSearchInput) headerSearchInput.value = '';
        hideSuggestions();
        setTimeout(() => {
            if (searchSuggestionsContainer) searchSuggestionsContainer.innerHTML = '';
        }, 200);
    };

    const handleSearchToggle = (e) => {
        e.stopPropagation();
        if (searchBarContainer && searchBarContainer.classList.contains('pointer-events-none')) {
            openHeaderSearch();
        } else {
            closeHeaderSearch();
        }
    };

    if (searchBtn) {
        searchBtn.addEventListener('click', handleSearchToggle);
    }

    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', handleSearchToggle);
    }

    if (searchCloseBtn) {
        searchCloseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            closeHeaderSearch();
        });
    }

    document.addEventListener('click', (e) => {
        const isSearchBtn = (searchBtn && (searchBtn === e.target || searchBtn.contains(e.target))) ||
                            (mobileSearchBtn && (mobileSearchBtn === e.target || mobileSearchBtn.contains(e.target)));
        if (searchBarContainer && !searchBarContainer.contains(e.target) && !isSearchBtn) {
            closeHeaderSearch();
        } else if (searchSuggestionsContainer && !searchSuggestionsContainer.contains(e.target) && e.target !== headerSearchInput) {
            hideSuggestions();
        }
    });

    if (headerSearchInput && searchSuggestionsContainer) {
        let activeSuggestionIndex = -1;

        const highlightSuggestion = (items) => {
            items.forEach((item, idx) => {
                if (idx === activeSuggestionIndex) {
                    item.classList.add('bg-gray-50/90', 'border-l-secondary');
                    item.classList.remove('border-l-transparent');
                    item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                } else {
                    item.classList.remove('bg-gray-50/90', 'border-l-secondary');
                    item.classList.add('border-l-transparent');
                }
            });
        };

        headerSearchInput.addEventListener('keydown', (e) => {
            const items = searchSuggestionsContainer.querySelectorAll('.suggestion-item');
            if (items.length === 0 || searchSuggestionsContainer.classList.contains('hidden')) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeSuggestionIndex++;
                if (activeSuggestionIndex >= items.length) activeSuggestionIndex = 0;
                highlightSuggestion(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeSuggestionIndex--;
                if (activeSuggestionIndex < 0) activeSuggestionIndex = items.length - 1;
                highlightSuggestion(items);
            } else if (e.key === 'Enter') {
                if (activeSuggestionIndex > -1) {
                    e.preventDefault();
                    items[activeSuggestionIndex].click();
                }
            } else if (e.key === 'Escape') {
                e.preventDefault();
                hideSuggestions();
            }
        });

        const searchI18n = {
            en: {
                searching: 'Searching records...',
                noMatches: 'No matches found',
                tryAdjusting: 'Try adjusting keywords or check spelling',
                failed: 'Failed to fetch suggestions',
                pageSuffix: 'Page'
            },
            si: {
                searching: 'වාර්තා සොයමින් පවතී...',
                noMatches: 'ගැලපෙන ප්‍රතිඵල හමු නොවීය',
                tryAdjusting: 'මූලපද වෙනස් කර හෝ අක්ෂර වින්‍යාසය පරීක්ෂා කරන්න',
                failed: 'යෝජනා ලබා ගැනීම අසාර්ථක විය',
                pageSuffix: 'පිටුව'
            },
            ta: {
                searching: 'பதிவுகள் தேடப்படுகின்றன...',
                noMatches: 'பொருத்தமான முடிவுகள் எதுவும் கிடைக்கவில்லை',
                tryAdjusting: 'முக்கிய வார்த்தைகளை மாற்றி அல்லது எழுத்துப் பிழையைச் சரிபார்க்கவும்',
                failed: 'பரிந்துரைகளைப் பெறுவதில் தோல்வி',
                pageSuffix: 'பக்கம்'
            }
        };

        headerSearchInput.addEventListener('input', (e) => {
            clearTimeout(searchDebounceTimeout);
            const query = e.target.value.trim();
            const currentLang = document.documentElement.lang || 'en';
            const tSearch = searchI18n[currentLang] || searchI18n.en;
            activeSuggestionIndex = -1;

            if (query.length < 2) {
                hideSuggestions();
                setTimeout(() => {
                    searchSuggestionsContainer.innerHTML = '';
                }, 200);
                return;
            }

            // Show suggestions container and displaying a loading indicator
            showSuggestions();
            searchSuggestionsContainer.innerHTML = `
                <div class="p-5 text-center text-gray-500 flex items-center justify-center gap-2.5 notranslate" translate="no">
                    <svg class="animate-spin h-4 w-4 text-[#13273F]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs font-inter font-medium text-gray-500">${tSearch.searching}</span>
                </div>
            `;

            searchDebounceTimeout = setTimeout(() => {
                fetch('search-suggest.php?q=' + encodeURIComponent(query) + '&lang=' + encodeURIComponent(currentLang))
                    .then(res => res.json())
                    .then(data => {
                        activeSuggestionIndex = -1;
                        if (data.length === 0) {
                            searchSuggestionsContainer.innerHTML = `
                                <div class="p-6 text-center flex flex-col items-center justify-center notranslate" translate="no">
                                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mb-3 border border-gray-100">
                                        <svg class="w-4.5 h-4.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-900 font-inter">${tSearch.noMatches}</p>
                                    <p class="text-[11px] text-gray-400 font-inter mt-1 leading-normal">${tSearch.tryAdjusting}</p>
                                </div>
                            `;
                        } else {
                            let html = '<div class="py-1.5 divide-y divide-gray-50">';
                            const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                            data.forEach(item => {
                                const escapedTitle = item.title.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                                const highlightedTitle = escapedTitle.replace(regex, '<mark class="bg-yellow-200 text-gray-900 font-bold px-0.5 rounded">$1</mark>');
                                const badgeLabel = item.type_label || item.type;
                                
                                // Category-specific premium badges styling
                                let badgeClass = '';
                                if (item.type === 'News') {
                                    badgeClass = 'bg-red-50 text-[#4E0000] border-red-100';
                                } else if (item.type === 'Vacancy') {
                                    badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                } else if (item.type === 'Page') {
                                    badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-100';
                                } else {
                                    badgeClass = 'bg-blue-50 text-blue-700 border-blue-100';
                                }

                                html += `
                                    <a href="${item.url}" class="suggestion-item px-4 py-3 hover:bg-gray-50/80 transition-all duration-200 border-l-4 border-l-transparent flex items-center justify-between gap-3 notranslate" translate="no">
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-[12.5px] font-semibold text-gray-900 font-inter line-clamp-2 leading-snug">${highlightedTitle}</span>
                                            <span class="text-[10px] text-gray-400 font-inter mt-0.5">${badgeLabel} ${item.type === 'Page' ? '' : tSearch.pageSuffix}</span>
                                        </div>
                                        <span class="text-[8.5px] px-2 py-0.5 rounded font-bold uppercase tracking-wider shrink-0 font-inter border ${badgeClass}">${badgeLabel}</span>
                                    </a>
                                `;
                            });
                            html += '</div>';
                            searchSuggestionsContainer.innerHTML = html;
                        }
                    })
                    .catch(err => {
                        console.error('Search autocomplete fetch failed:', err);
                        searchSuggestionsContainer.innerHTML = `
                            <div class="p-5 text-center text-xs text-red-500 font-inter flex items-center justify-center gap-1.5 notranslate" translate="no">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>${tSearch.failed}</span>
                            </div>
                        `;
                    });
            }, 300);
        });

        // Prevent suggestions container click from closing the search bar
        searchSuggestionsContainer.addEventListener('click', (e) => {
            e.stopPropagation();
        });
        
        // Also show suggestions again if input is clicked/focused and has text
        headerSearchInput.addEventListener('focus', () => {
            if (headerSearchInput.value.trim().length >= 2) {
                showSuggestions();
            }
        });
    }
});

/**
 * =========================================================================
 * Centralized Trilingual Content Paginator & Filter Suite
 * Handles item slicing, show/hide state, trilingual summary, and page buttons.
 * =========================================================================
 */
class ContentPaginator {
    constructor(options = {}) {
        this.items = options.items || [];
        this.filteredIndexes = options.filteredIndexes || (this.items.length > 0 ? this.items.map((it, idx) => it.index !== undefined ? it.index : idx) : []);
        this.currentPage = options.initialPage || 1;
        this.defaultItemsPerPage = options.defaultItemsPerPage || 6;
        this.entityType = options.entityType || 'documents';
        this.itemSelectors = options.itemSelectors || ['.article-card', '.document-card', '.document-list-row'];
        this.gridContainerId = options.gridContainerId || (document.getElementById('gridViewContainer') ? 'gridViewContainer' : 'articles-grid');
        this.listContainerId = options.listContainerId || 'listViewContainer';
        this.noResultsId = options.noResultsId || 'noResultsMsg';
        this.paginationControlsId = options.paginationControlsId || 'paginationControls';
        this.paginationSummaryId = options.paginationSummaryId || 'paginationSummary';
        this.paginationButtonsId = options.paginationButtonsId || 'paginationButtons';
        this.itemsPerPageSelectId = options.itemsPerPageSelectId || 'itemsPerPage';
        this.scrollToTargetId = options.scrollToTargetId || this.gridContainerId;
        this.currentView = options.currentView || 'grid';
        this.onPageChange = options.onPageChange || null;

        // Register active paginator for global window.goToPage access
        window.activePaginator = this;

        this.initEvents();
    }

    initEvents() {
        const perPageEl = document.getElementById(this.itemsPerPageSelectId);
        if (perPageEl) {
            perPageEl.addEventListener('change', () => {
                this.currentPage = 1;
                this.updateUI();
            });
        }
    }

    setFilteredIndexes(indexes) {
        this.filteredIndexes = Array.isArray(indexes) ? indexes : [];
        this.currentPage = 1;
        this.updateUI();
    }

    getItemsPerPage() {
        const perPageEl = document.getElementById(this.itemsPerPageSelectId);
        if (!perPageEl) return this.defaultItemsPerPage;
        const val = perPageEl.value;
        if (val === 'all') return 'all';
        const num = parseInt(val, 10);
        return isNaN(num) || num <= 0 ? this.defaultItemsPerPage : num;
    }

    goToPage(page) {
        const itemsPerPage = this.getItemsPerPage();
        const totalItems = this.filteredIndexes.length;
        const perPageNum = itemsPerPage === 'all' ? totalItems : parseInt(itemsPerPage, 10);
        const totalPages = Math.max(1, Math.ceil(totalItems / perPageNum));

        let targetPage = parseInt(page, 10);
        if (isNaN(targetPage) || targetPage < 1) targetPage = 1;
        if (targetPage > totalPages) targetPage = totalPages;

        this.currentPage = targetPage;
        this.updateUI();

        // Smooth scroll to top of listing container
        const target = document.getElementById(this.scrollToTargetId) || document.getElementById('articles-grid') || document.getElementById('gridViewContainer');
        if (target) {
            const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - 120;
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }

        if (typeof this.onPageChange === 'function') {
            this.onPageChange(this.currentPage);
        }
    }

    setView(viewMode) {
        this.currentView = viewMode;
        this.updateUI();
    }

    updateUI() {
        const noResultsMsg = document.getElementById(this.noResultsId);
        const gridContainer = document.getElementById(this.gridContainerId);
        const listContainer = document.getElementById(this.listContainerId);
        const paginationControls = document.getElementById(this.paginationControlsId);

        const totalItems = this.filteredIndexes.length;
        const itemsPerPage = this.getItemsPerPage();

        // 1. Hide ALL cards/rows across all selectors to prevent any ghosting or overlap
        const combinedSelector = Array.isArray(this.itemSelectors) ? this.itemSelectors.join(', ') : this.itemSelectors;
        document.querySelectorAll(combinedSelector).forEach(el => el.classList.add('hidden'));

        // 2. Handle empty state
        if (totalItems === 0) {
            if (noResultsMsg) noResultsMsg.style.display = 'flex';
            if (gridContainer) gridContainer.style.display = 'none';
            if (listContainer) listContainer.style.display = 'none';
            if (paginationControls) paginationControls.style.display = 'none';
            return;
        }

        // 3. Restore visibility of active grid or list container
        if (noResultsMsg) noResultsMsg.style.display = 'none';
        if (this.currentView === 'list' && listContainer) {
            listContainer.style.display = 'block';
            if (gridContainer) gridContainer.style.display = 'none';
        } else if (gridContainer) {
            gridContainer.style.display = 'grid';
            if (listContainer) listContainer.style.display = 'none';
        }

        // 4. Calculate pagination slice
        let startIdx = 0;
        let endIdx = totalItems;
        let totalPages = 1;

        if (itemsPerPage !== 'all') {
            const perPageNum = parseInt(itemsPerPage, 10);
            totalPages = Math.ceil(totalItems / perPageNum) || 1;
            if (this.currentPage > totalPages) this.currentPage = totalPages;
            if (this.currentPage < 1) this.currentPage = 1;

            startIdx = (this.currentPage - 1) * perPageNum;
            endIdx = Math.min(startIdx + perPageNum, totalItems);
        }

        // 5. Reveal items belonging to the current page slice
        const activeSelector = this.currentView === 'list' && listContainer ? '.document-list-row' : combinedSelector;
        const allDomItems = document.querySelectorAll(activeSelector);

        for (let i = startIdx; i < endIdx; i++) {
            const itemIdx = this.filteredIndexes[i];
            const el = Array.from(allDomItems).find(card => {
                const attr = card.getAttribute('data-index');
                return attr !== null && parseInt(attr, 10) === itemIdx;
            });
            if (el) {
                el.classList.remove('hidden');
            }
        }

        // 6. Render localized summary and pagination buttons
        this.renderSummary(startIdx, endIdx, totalItems);
        this.renderButtons(totalPages);

        if (paginationControls) {
            paginationControls.style.display = 'flex';
        }
    }

    renderSummary(startIdx, endIdx, totalItems) {
        const summaryEl = document.getElementById(this.paginationSummaryId) || document.querySelector(`#${this.paginationControlsId} .text-sm`);
        if (!summaryEl) return;

        const start = startIdx + 1;
        const end = endIdx;
        const lang = document.documentElement.lang || 'en';

        const entityNames = {
            documents: { en: 'documents', singular: 'document', si: 'ලේඛන', ta: 'ஆவணங்கள்' },
            news: { en: 'articles', singular: 'article', si: 'ලිපි', ta: 'கட்டுரைகள்' },
            events: { en: 'events', singular: 'event', si: 'සිදුවීම්', ta: 'நிகழ்வுகள்' },
            vacancies: { en: 'vacancies', singular: 'vacancy', si: 'පුරප්පාඩු', ta: 'வெற்றிடங்கள்' },
            notices: { en: 'notices', singular: 'notice', si: 'නිවේදන', ta: 'அறிவிப்புகள்' },
            procurements: { en: 'procurements', singular: 'procurement', si: 'ප්‍රසම්පාදන', ta: 'கொள்முதல்கள்' },
            updates: { en: 'updates', singular: 'update', si: 'යාවත්කාලීන', ta: 'புதுப்பிப்புகள்' },
            publications: { en: 'publications', singular: 'publication', si: 'ප්‍රකාශන', ta: 'வெளியීடுகள்' },
            platforms: { en: 'platforms', singular: 'platform', si: 'වේදිකා', ta: 'தளங்கள்' }
        };

        const entity = entityNames[this.entityType] || entityNames.documents;
        const name = entity[lang] || entity.en;
        const itemsPerPage = this.getItemsPerPage();
        const isAll = itemsPerPage === 'all' || (start === 1 && end === totalItems);

        let text = '';
        if (lang === 'si') {
            if (totalItems === 1) {
                text = `${name} 1 ක් පෙන්වයි`;
            } else if (isAll) {
                text = `සියලුම ${name} <span class="font-semibold text-gray-800">${totalItems}</span> ම පෙන්වයි`;
            } else {
                text = `${name} <span class="font-semibold text-gray-800">${totalItems}</span> න් <span class="font-semibold text-gray-800">${start}–${end}</span> දක්වා පෙන්වයි`;
            }
        } else if (lang === 'ta') {
            if (totalItems === 1) {
                text = `1 ${name} காட்டப்படுகிறது`;
            } else if (isAll) {
                text = `அனைத்து <span class="font-semibold text-gray-800">${totalItems}</span> ${name} காட்டப்படுகின்றன`;
            } else {
                text = `<span class="font-semibold text-gray-800">${totalItems}</span> ${name} <span class="font-semibold text-gray-800">${start}–${end}</span> காட்டப்படுகின்றன`;
            }
        } else {
            if (totalItems === 1) {
                text = `Showing 1 ${entity.singular || 'item'}`;
            } else if (isAll) {
                text = `Showing all <span class="font-semibold text-gray-800">${totalItems}</span> ${name}`;
            } else {
                text = `Showing <span class="font-semibold text-gray-800">${start}–${end}</span> of <span class="font-semibold text-gray-800">${totalItems}</span> ${name}`;
            }
        }

        summaryEl.innerHTML = text;
        summaryEl.classList.add('notranslate');
        summaryEl.setAttribute('translate', 'no');
    }

    renderButtons(totalPages) {
        const container = document.getElementById(this.paginationButtonsId);
        if (!container) return;

        const maxPages = Math.max(1, totalPages);
        const lang = document.documentElement.lang || 'en';

        const labels = {
            prev: lang === 'si' ? 'පෙර' : (lang === 'ta' ? 'முந்தைய' : 'Prev'),
            next: lang === 'si' ? 'මීළඟ' : (lang === 'ta' ? 'அடுத்தது' : 'Next')
        };

        if (maxPages <= 1) {
            container.innerHTML = '';
            return;
        }

        let html = '';

        // Previous Button
        const prevDisabled = this.currentPage <= 1;
        html += `<button type="button" data-page="${this.currentPage - 1}" ${prevDisabled ? 'disabled class="px-3.5 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50 notranslate" translate="no"' : 'class="pagination-btn px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all cursor-pointer shadow-sm notranslate" translate="no"'}>${labels.prev}</button>`;

        // Page Number Buttons with Smart Ellipsis
        let startPage = Math.max(1, this.currentPage - 2);
        let endPage = Math.min(maxPages, startPage + 4);
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
            if (startPage < 1) startPage = 1;
        }

        if (startPage > 1) {
            html += `<button type="button" data-page="1" class="pagination-btn px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all cursor-pointer shadow-sm font-inter">1</button>`;
            if (startPage > 2) html += `<span class="px-1.5 text-gray-400 text-xs select-none">...</span>`;
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === this.currentPage) {
                html += `<button type="button" class="px-3.5 py-2 border border-primary bg-primary text-white font-bold rounded-xl text-xs shadow-sm cursor-default font-inter">${i}</button>`;
            } else {
                html += `<button type="button" data-page="${i}" class="pagination-btn px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all cursor-pointer shadow-sm font-inter">${i}</button>`;
            }
        }

        if (endPage < maxPages) {
            if (endPage < maxPages - 1) html += `<span class="px-1.5 text-gray-400 text-xs select-none">...</span>`;
            html += `<button type="button" data-page="${maxPages}" class="pagination-btn px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all cursor-pointer shadow-sm font-inter">${maxPages}</button>`;
        }

        // Next Button
        const nextDisabled = this.currentPage >= maxPages;
        html += `<button type="button" data-page="${this.currentPage + 1}" ${nextDisabled ? 'disabled class="px-3.5 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs cursor-not-allowed bg-gray-50/50 notranslate" translate="no"' : 'class="pagination-btn px-3.5 py-2 border border-gray-200 text-gray-600 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold transition-all cursor-pointer shadow-sm notranslate" translate="no"'}>${labels.next}</button>`;

        container.innerHTML = html;

        // Bind click events to page buttons
        container.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const targetPage = parseInt(btn.getAttribute('data-page'), 10);
                if (!isNaN(targetPage)) {
                    this.goToPage(targetPage);
                }
            });
        });
    }
}

// Global hook for backward compatibility with inline onclick="goToPage(X)"
window.goToPage = function(page) {
    if (window.activePaginator) {
        window.activePaginator.goToPage(page);
    }
};
