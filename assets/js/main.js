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
    // 6. KEY FOCUS AREA CAROUSEL SLIDER
    // ==========================================
    const track = document.getElementById('carousel-track');
    const nextBtn = document.getElementById('carousel-next');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtnMob = document.getElementById('carousel-next-mob');
    const prevBtnMob = document.getElementById('carousel-prev-mob');

    if (track) {
        const scrollCarousel = (direction) => {
            const cardWidth = track.firstElementChild ? track.firstElementChild.offsetWidth + 24 : 320;
            track.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
        };

        if (nextBtn) nextBtn.addEventListener('click', () => scrollCarousel(1));
        if (prevBtn) prevBtn.addEventListener('click', () => scrollCarousel(-1));
        if (nextBtnMob) nextBtnMob.addEventListener('click', () => scrollCarousel(1));
        if (prevBtnMob) prevBtnMob.addEventListener('click', () => scrollCarousel(-1));
    }

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
                lightbox.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            });
        });

        const closeLightbox = () => {
            lightbox.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
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
        btn.addEventListener('click', () => {
            // Remove active formatting
            instBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-white', 'active');
                b.classList.add('text-gray-600', 'hover:bg-gray-50');
            });
            // Add active formatting to current
            btn.classList.add('bg-primary', 'text-white', 'active');
            btn.classList.remove('text-gray-600', 'hover:bg-gray-50');

            const targetId = btn.getAttribute('data-target');
            instPanels.forEach(panel => {
                if (panel.id === `inst-panel-${targetId}`) {
                    panel.classList.remove('hidden');
                    panel.classList.add('active-panel-block');
                } else {
                    panel.classList.add('hidden');
                    panel.classList.remove('active-panel-block');
                }
            });
        });
    });

    // ==========================================
    // 10. NEWSLETTER FORM & TOAST BULLETINS
    // ==========================================
    const newsletterForm = document.getElementById('newsletter-form');
    const toast = document.getElementById('toast');

    if (newsletterForm && toast) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            toast.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
            }, 3500);
            newsletterForm.reset();
        });
    }

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
