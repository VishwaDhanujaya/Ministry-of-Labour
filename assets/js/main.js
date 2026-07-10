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
    // 3. FONT SIZING RESIZER (ACCESSIBILITY)
    // ==========================================
    const fontDecreaseBtn = document.getElementById('font-decrease');
    const fontResetBtn = document.getElementById('font-reset');
    const fontIncreaseBtn = document.getElementById('font-increase');
    const htmlEl = document.documentElement;

    const setActiveFontBtn = (activeBtn) => {
        [fontDecreaseBtn, fontResetBtn, fontIncreaseBtn].forEach(btn => {
            if (btn) btn.classList.remove('bg-white/10', 'text-yellow-400');
        });
        if (activeBtn) activeBtn.classList.add('bg-white/10', 'text-yellow-400');
    };

    if (fontDecreaseBtn) {
        fontDecreaseBtn.addEventListener('click', () => {
            htmlEl.style.fontSize = '14px';
            setActiveFontBtn(fontDecreaseBtn);
        });
    }
    if (fontResetBtn) {
        fontResetBtn.addEventListener('click', () => {
            htmlEl.style.fontSize = '16px';
            setActiveFontBtn(fontResetBtn);
        });
    }
    if (fontIncreaseBtn) {
        fontIncreaseBtn.addEventListener('click', () => {
            htmlEl.style.fontSize = '18px';
            setActiveFontBtn(fontIncreaseBtn);
        });
    }

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
    const instBtns = document.querySelectorAll('.inst-tab-btn');
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

            // Reset all buttons styling
            instBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'active');
                b.classList.add('text-gray-600', 'bg-white', 'hover:bg-gray-50', 'border', 'border-gray-200', 'hover:border-gray-300', 'hover:shadow-md');
                
                const svg = b.querySelector('svg');
                if (svg) {
                    svg.classList.remove('transform', 'group-hover:translate-x-1');
                    svg.classList.add('opacity-0', 'group-hover:opacity-100', 'transform', '-translate-x-2', 'group-hover:translate-x-0', 'text-primary');
                }
            });

            // Set active styling on current button
            this.classList.add('bg-primary', 'text-white', 'shadow-lg', 'active');
            this.classList.remove('text-gray-600', 'bg-white', 'hover:bg-gray-50', 'border', 'border-gray-200', 'hover:border-gray-300', 'hover:shadow-md');

            const activeSvg = this.querySelector('svg');
            if (activeSvg) {
                activeSvg.classList.remove('opacity-0', 'group-hover:opacity-100', 'transform', '-translate-x-2', 'group-hover:translate-x-0', 'text-primary');
                activeSvg.classList.add('transform', 'group-hover:translate-x-1');
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
            if (window.showToast) {
                window.showToast('Successfully subscribed!', 'success');
            }
            newsletterForm.reset();
        });
    }

    let toastTimeout;
    function initToastContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed bottom-6 right-6 z-50 flex flex-col gap-3';
            document.body.appendChild(container);
        }
    }

    window.showToast = function(message, type = 'success') {
        initToastContainer();
        const container = document.getElementById('toast-container');
        const toastEl = document.createElement('div');
        
        const statusColors = {
            success: {
                bg: 'bg-green-500/10 border-green-500/20 text-green-400',
                bar: 'bg-green-500',
                icon: `<svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>`
            },
            error: {
                bg: 'bg-red-500/10 border-red-500/20 text-red-400',
                bar: 'bg-red-500',
                icon: `<svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>`
            },
            info: {
                bg: 'bg-[#4E0000]/10 border-[#4E0000]/20 text-red-300',
                bar: 'bg-[#4E0000]',
                icon: `<svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
            }
        };
        
        const config = statusColors[type] || statusColors.info;
        
        toastEl.className = `relative overflow-hidden flex items-center gap-3.5 p-4 pr-10 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.3)] text-white text-[13px] font-semibold transform transition-all duration-300 translate-y-10 opacity-0 bg-[#13273F]/95 backdrop-blur-md border border-white/10 font-inter pointer-events-auto max-w-sm w-full z-50`;
        
        toastEl.innerHTML = `
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 ${config.bg} border">
                ${config.icon}
            </div>
            <div class="flex-1 text-gray-100 font-inter leading-snug">${message}</div>
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-1/2 -translate-y-1/2 right-3 text-white/40 hover:text-white transition-colors focus:outline-none p-1 rounded-md hover:bg-white/5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="absolute bottom-0 left-0 h-1 transition-all duration-[3000ms] ease-linear w-full ${config.bar}" style="width: 100%" id="toast-progress"></div>
        `;
        
        container.appendChild(toastEl);
        
        setTimeout(() => {
            toastEl.classList.remove('translate-y-10', 'opacity-0');
            const progress = toastEl.querySelector('#toast-progress');
            if (progress) progress.style.width = '0%';
        }, 10);
        
        setTimeout(() => {
            toastEl.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => toastEl.remove(), 300);
        }, 3000);
    };

    // ==========================================
    // 11. FLOAT SCROLL-TO-TOP CONTROL
    // ==========================================
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-3');
            } else {
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-3');
            }
        });
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
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

        headerSearchInput.addEventListener('input', (e) => {
            clearTimeout(searchDebounceTimeout);
            const query = e.target.value.trim();
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
                <div class="p-5 text-center text-gray-500 flex items-center justify-center gap-2.5">
                    <svg class="animate-spin h-4 w-4 text-[#13273F]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xs font-inter font-medium text-gray-500">Searching records...</span>
                </div>
            `;

            searchDebounceTimeout = setTimeout(() => {
                fetch('search-suggest.php?q=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        activeSuggestionIndex = -1;
                        if (data.length === 0) {
                            searchSuggestionsContainer.innerHTML = `
                                <div class="p-6 text-center flex flex-col items-center justify-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center mb-3 border border-gray-100">
                                        <svg class="w-4.5 h-4.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-900 font-inter">No matches found</p>
                                    <p class="text-[11px] text-gray-400 font-inter mt-1 leading-normal">Try adjusting keywords or check spelling</p>
                                </div>
                            `;
                        } else {
                            let html = '<div class="py-1.5 divide-y divide-gray-50">';
                            data.forEach(item => {
                                const escapedTitle = item.title.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                                
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
                                    <a href="${item.url}" class="suggestion-item block px-4 py-3 hover:bg-gray-50/80 transition-all duration-200 border-l-4 border-l-transparent flex items-center justify-between gap-3">
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-[12.5px] font-semibold text-gray-900 font-inter line-clamp-2 leading-snug">${escapedTitle}</span>
                                            <span class="text-[10px] text-gray-400 font-inter mt-0.5">${item.type} Page</span>
                                        </div>
                                        <span class="text-[8.5px] px-2 py-0.5 rounded font-bold uppercase tracking-wider shrink-0 font-inter border ${badgeClass}">${item.type}</span>
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
                            <div class="p-5 text-center text-xs text-red-500 font-inter flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Failed to fetch suggestions</span>
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



