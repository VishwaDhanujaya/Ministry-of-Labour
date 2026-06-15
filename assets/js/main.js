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
            mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
            mobileDrawer.classList.remove('translate-x-full');
            document.body.classList.add('overflow-hidden');
        }
    };

    const closeMobileMenu = () => {
        if (mobileMenu && mobileDrawer) {
            mobileMenu.classList.add('opacity-0', 'pointer-events-none');
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
    const initDotSlider = (trackId, dotsContainerId, dotClass) => {
        const track = document.getElementById(trackId);
        const dotsContainer = document.getElementById(dotsContainerId);
        const dots = document.querySelectorAll(dotClass);

        if (!track) return;

        const updateDots = () => {
            if (!track.firstElementChild || dots.length === 0) return;
            
            // Check if slider actually needs to scroll
            if (track.scrollWidth <= track.clientWidth) {
                if (dotsContainer) dotsContainer.classList.add('hidden');
                if (dotsContainer) dotsContainer.classList.remove('flex');
                return;
            } else {
                if (dotsContainer) dotsContainer.classList.remove('hidden');
                if (dotsContainer) dotsContainer.classList.add('flex');
            }

            const scrollLeft = track.scrollLeft;
            // Determine gap by computing styles or assuming it's gap-6 (24px) or gap-8 (32px) etc.
            // Since we use gap-6 (24px) usually, let's just use a more dynamic approach or standard 24px.
            // Actually, offsetWidth + gap might vary if gap is responsive.
            // A more robust way to get card total width is to look at distance between first and second children.
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
                    // We need a fallback color if not on dark background. 
                    // Let's use data attribute or base class to know if it's light or dark mode.
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
    initDotSlider('carousel-track', 'carousel-dots-container', '.carousel-dot');
    // Initialize Partners Slider
    initDotSlider('partners-track', 'partners-dots-container', '.partner-dot');

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
        
        let bgClass = type === 'success' ? 'from-primary to-[#1a3656]' : (type === 'error' ? 'from-red-600 to-red-800' : 'from-gray-700 to-gray-900');
        toastEl.className = `bg-gradient-to-r text-white py-3.5 px-6 rounded-xl shadow-2xl border border-white/10 opacity-0 translate-y-4 transition-all duration-500 z-50 flex items-center gap-3 ${bgClass}`;
        
        let iconHtml = type === 'success' ? 
            `<svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>` : 
            `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

        toastEl.innerHTML = `
            <div class="w-7 h-7 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                ${iconHtml}
            </div>
            <span class="font-inter text-sm font-semibold">${message}</span>
        `;
        
        container.appendChild(toastEl);
        
        setTimeout(() => {
            toastEl.classList.remove('translate-y-4', 'opacity-0');
        }, 10);
        
        setTimeout(() => {
            toastEl.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toastEl.remove(), 500);
        }, 3500);
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
    // 12. HEADER SEARCH BAR TOGGLE
    // ==========================================
    const searchBtn = document.getElementById('search-btn');
    const searchBarContainer = document.getElementById('search-bar-container');
    const searchCloseBtn = document.getElementById('search-close-btn');
    const headerSearchInput = document.getElementById('header-search-input');

    if (searchBtn && searchBarContainer) {
        searchBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            searchBarContainer.classList.remove('opacity-0', 'pointer-events-none', 'w-0');
            searchBarContainer.classList.add('opacity-100', 'pointer-events-auto', 'w-48');
            if (headerSearchInput) headerSearchInput.focus();
        });
    }

    const closeHeaderSearch = () => {
        if (searchBarContainer) {
            searchBarContainer.classList.add('opacity-0', 'pointer-events-none', 'w-0');
            searchBarContainer.classList.remove('opacity-100', 'pointer-events-auto', 'w-48');
        }
        if (headerSearchInput) headerSearchInput.value = '';
    };

    if (searchCloseBtn) {
        searchCloseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            closeHeaderSearch();
        });
    }

    document.addEventListener('click', (e) => {
        if (searchBarContainer && !searchBarContainer.contains(e.target) && e.target !== searchBtn) {
            closeHeaderSearch();
        }
    });
});

