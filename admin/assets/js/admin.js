/**
 * Admin Dashboard - Frontend Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    initToastContainer();
    initModalContainer();
    
    initGlobalInteractions();
    initTableFiltering();
    initFormValidation();
    initIdleTimer();
});

// --- UI Utilities (Toasts & Modals) ---

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

    const toast = document.createElement('div');
    
    // Status colors mapping
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
    
    toast.className = `relative overflow-hidden flex items-center gap-3.5 p-4 pr-10 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] text-white text-[13px] font-semibold bg-[#13273F]/95 backdrop-blur-md border border-white/10 font-inter pointer-events-auto max-w-sm w-full animate-toast-in notranslate`;
    
    toast.innerHTML = `
        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 ${config.bg} border border-current/10">
            ${config.icon}
        </div>
        <div class="flex-1 text-gray-100 font-inter leading-snug toast-msg">${message}</div>
        <button type="button" class="toast-close absolute top-1/2 -translate-y-1/2 right-3 text-white/40 hover:text-white transition-colors focus:outline-none p-1 rounded-md hover:bg-white/5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="absolute bottom-0 left-0 h-1 w-full ${config.bar}" id="toast-progress"></div>
    `;
    
    container.appendChild(toast);
    
    const progress = toast.querySelector('#toast-progress');
    const autoDismissTime = 4000;
    let timeRemaining = autoDismissTime;
    let startTime = Date.now();
    let dismissTimeout;
    
    // Bind progress bar animation
    if (progress) {
        progress.style.animation = `toast-progress ${autoDismissTime}ms linear forwards`;
    }

    function dismissToast() {
        toast.classList.remove('animate-toast-in');
        toast.classList.add('animate-toast-out');
        setTimeout(() => toast.remove(), 300);
    }
    
    dismissTimeout = setTimeout(dismissToast, autoDismissTime);
    
    // Hover interactions (Pause and Resume)
    toast.addEventListener('mouseenter', () => {
        clearTimeout(dismissTimeout);
        timeRemaining -= (Date.now() - startTime);
        if (progress) {
            progress.style.animationPlayState = 'paused';
        }
    });
    
    toast.addEventListener('mouseleave', () => {
        startTime = Date.now();
        dismissTimeout = setTimeout(dismissToast, timeRemaining);
        if (progress) {
            progress.style.animationPlayState = 'running';
        }
    });
    
    const closeBtn = toast.querySelector('.toast-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            clearTimeout(dismissTimeout);
            dismissToast();
        });
    }
}

function initModalContainer() {
    let overlay = document.getElementById('modal-overlay');
    if (overlay) return;
    
    overlay = document.createElement('div');
    overlay.id = 'modal-overlay';
    overlay.className = 'fixed inset-0 z-[100] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0';
    overlay.style.zIndex = '9999';
    
    const bg = document.createElement('div');
    bg.className = 'absolute inset-0 bg-black/60 backdrop-blur-sm pointer-events-none';
    overlay.appendChild(bg);
    
    const modal = document.createElement('div');
    modal.id = 'mock-modal';
    modal.className = 'bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-95 transition-all duration-300 relative z-10 overflow-hidden border border-gray-100';
    
    modal.innerHTML = `
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-50 text-red-600 mb-4" id="modal-icon-container">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 id="modal-title" class="text-[17px] font-bold text-gray-900 font-montserrat mb-2">Confirm Action</h3>
            <p id="modal-message" class="text-[13px] text-gray-500 font-inter leading-relaxed px-2">Are you sure you want to proceed?</p>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
            <button id="modal-confirm" type="button" class="px-5 py-2.5 bg-red-600 text-white rounded-md text-[13px] font-bold hover:bg-red-700 transition-colors shadow-sm focus:outline-none">Confirm</button>
            <button id="modal-cancel" type="button" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors focus:outline-none">Cancel</button>
        </div>
    `;
    
    overlay.appendChild(modal);
    document.body.appendChild(overlay);
    
    document.getElementById('modal-cancel').addEventListener('click', hideModal);
    overlay.addEventListener('click', (e) => {
        if(e.target === overlay) hideModal();
    });
}

let currentConfirmCallback = null;

window.showModal = function(title, message, confirmBtnText = 'Confirm', confirmBtnClass = 'bg-red-600 hover:bg-red-700', onConfirm) {
    const overlay = document.getElementById('modal-overlay');
    const modal = document.getElementById('mock-modal');
    
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-message').textContent = message;
    
    const iconContainer = document.getElementById('modal-icon-container');
    const isDestructive = confirmBtnText.toLowerCase().includes('delete') || confirmBtnText.toLowerCase().includes('reject') || message.toLowerCase().includes('delete') || message.toLowerCase().includes('reject') || message.toLowerCase().includes('cancel');
    
    if (isDestructive) {
        iconContainer.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-50 text-red-600 mb-4';
        iconContainer.innerHTML = `
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        `;
    } else {
        iconContainer.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-50 text-blue-600 mb-4';
        iconContainer.innerHTML = `
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        `;
    }
    
    const confirmBtn = document.getElementById('modal-confirm');
    confirmBtn.textContent = confirmBtnText;
    confirmBtn.className = `px-5 py-2.5 text-white rounded-md text-[13px] font-bold transition-colors shadow-sm focus:outline-none ${confirmBtnClass}`;
    
    currentConfirmCallback = onConfirm;
    
    // remove old listener
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    newConfirmBtn.addEventListener('click', () => {
        if(currentConfirmCallback) currentConfirmCallback();
        hideModal();
    });
    
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
    // trigger reflow
    void overlay.offsetWidth;
    overlay.classList.remove('opacity-0');
    modal.classList.remove('scale-95');
    modal.classList.add('scale-100');
}

function hideModal() {
    const overlay = document.getElementById('modal-overlay');
    const modal = document.getElementById('mock-modal');
    
    overlay.classList.add('opacity-0');
    modal.classList.remove('scale-100');
    modal.classList.add('scale-95');
    
    setTimeout(() => {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }, 300);
}


// --- Global Interactions ---

function initGlobalInteractions() {
    // Topbar Search Dummy
    const topSearch = document.querySelector('header input[type="text"]');
    if (topSearch) {
        topSearch.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                // Future search logic here
                e.target.value = '';
            }
        });
    }

    // Intercept clicks on links/buttons with data-confirm
    document.addEventListener('click', function(e) {
        const confirmEl = e.target.closest('[data-confirm]');
        if (confirmEl) {
            if (!confirmEl.dataset.confirmed) {
                e.preventDefault();
                e.stopPropagation();
                
                const message = confirmEl.getAttribute('data-confirm');
                const isDelete = message.toLowerCase().includes('delete') || message.toLowerCase().includes('reject');
                const btnClass = isDelete ? 'bg-red-600 hover:bg-red-700' : 'bg-[#4E0000] hover:bg-[#320000]';
                const btnText = isDelete ? 'Delete' : 'Confirm';
                const title = isDelete ? 'Delete Action' : 'Confirm Action';
                
                // Show modal overlay
                initModalContainer();
                
                window.showModal(
                    title, 
                    message, 
                    btnText, 
                    btnClass, 
                    function() {
                        confirmEl.dataset.confirmed = 'true';
                        confirmEl.click();
                        delete confirmEl.dataset.confirmed;
                    }
                );
            }
        }
    }, true); // useCapture = true is key to intercept before other click handlers
}


// --- Table Filtering & Pagination Logic ---

function initTableFiltering() {
    const searchInputs = document.querySelectorAll('.js-table-search');
    const filterSelects = document.querySelectorAll('.js-table-filter');
    const resetBtns = document.querySelectorAll('.js-reset-filter');
    
    if (searchInputs.length === 0 && filterSelects.length === 0) return;

    // Pagination state
    let currentPage = 1;
    let currentPerPage = 'all';

    // Read per-page from the pagination container if it exists
    const paginationContainer = document.querySelector('.js-table-pagination');
    if (paginationContainer) {
        const pp = parseInt(paginationContainer.dataset.perPage);
        currentPerPage = (pp && pp > 0) ? pp : 'all';
    }

    function getFilteredItems() {
        const table = document.querySelector('.js-filterable-table tbody');
        const cardsContainer = document.querySelectorAll('.js-booking-card');
        
        let allItems = [];
        if (table) {
            allItems = Array.from(table.querySelectorAll('tr:not(.js-empty-state)'));
        } else if (cardsContainer.length > 0) {
            allItems = Array.from(cardsContainer);
        }
        
        if (allItems.length === 0) return { all: [], filtered: [] };
        
        const searchTerm = searchInputs.length > 0 ? searchInputs[0].value.toLowerCase() : '';
        
        // Get all select values
        const activeFilters = [];
        filterSelects.forEach(select => {
            if (select.value) {
                activeFilters.push(select.value.toLowerCase());
            }
        });
        
        const filtered = [];
        allItems.forEach(item => {
            let matchesSearch = true;
            if (searchTerm) {
                matchesSearch = item.textContent.toLowerCase().includes(searchTerm);
            }
            
            let matchesSelects = true;
            if (activeFilters.length > 0) {
                const itemText = item.textContent.toLowerCase();
                activeFilters.forEach(filterVal => {
                    if (!itemText.includes(filterVal)) {
                        matchesSelects = false;
                    }
                });
            }
            
            if (matchesSearch && matchesSelects) {
                filtered.push(item);
            }
        });

        return { all: allItems, filtered };
    }

    function applyFiltersAndPaginate() {
        const { all, filtered } = getFilteredItems();
        if (all.length === 0) return;

        // Hide all items first
        all.forEach(item => item.style.display = 'none');

        const totalFiltered = filtered.length;
        const perPage = currentPerPage === 'all' ? totalFiltered : parseInt(currentPerPage);
        const totalPages = perPage > 0 ? Math.ceil(totalFiltered / perPage) : 1;

        // Clamp current page
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        // Calculate visible range
        const startIdx = (currentPage - 1) * perPage;
        const endIdx = Math.min(startIdx + perPage, totalFiltered);

        // Show only items in range
        for (let i = startIdx; i < endIdx; i++) {
            filtered[i].style.display = '';
        }

        // Handle empty state
        const table = document.querySelector('.js-filterable-table tbody');
        if (table) {
            let emptyRow = table.querySelector('.js-empty-state');
            if (totalFiltered === 0) {
                if (!emptyRow) {
                    emptyRow = document.createElement('tr');
                    emptyRow.className = 'js-empty-state';
                    emptyRow.innerHTML = `<td colspan="99" class="py-16 px-6 text-center text-slate-400">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-inner">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path></svg>
                        </div>
                        <span class="font-bold text-slate-700 block mb-1">No matching results</span>
                        <span class="text-xs text-slate-400">Try adjusting your filters or search keywords</span>
                    </td>`;
                    table.appendChild(emptyRow);
                }
                emptyRow.style.display = '';
            } else if (emptyRow) {
                emptyRow.style.display = 'none';
            }
        }

        // Update pagination UI
        updatePaginationUI(totalFiltered, perPage, totalPages);
    }

    function updatePaginationUI(totalFiltered, perPage, totalPages) {
        if (!paginationContainer) return;

        const infoEl = paginationContainer.querySelector('.js-pagination-info');
        const buttonsEl = paginationContainer.querySelector('.js-pagination-buttons');

        if (totalFiltered === 0) {
            if (infoEl) infoEl.innerHTML = '<span class="text-slate-400">No entries to display</span>';
            if (buttonsEl) buttonsEl.innerHTML = '';
            return;
        }

        const startItem = ((currentPage - 1) * perPage) + 1;
        const endItem = Math.min(currentPage * perPage, totalFiltered);

        // Update info text
        if (infoEl) {
            infoEl.innerHTML = `Showing <span class="font-semibold text-slate-800">${startItem}</span> to <span class="font-semibold text-slate-800">${endItem}</span> of <span class="font-semibold text-slate-800">${totalFiltered}</span> entries`;
        }

        // Render pagination buttons
        if (buttonsEl) {
            if (currentPerPage === 'all' || totalPages <= 1) {
                buttonsEl.innerHTML = '';
                return;
            }

            let html = '';

            // Prev Button
            if (currentPage === 1) {
                html += `<button disabled class="px-3.5 py-1.5 border border-slate-200 text-slate-400 rounded-xl text-[12px] font-bold cursor-not-allowed bg-slate-50/50">Prev</button>`;
            } else {
                html += `<button data-page="${currentPage - 1}" class="js-page-btn px-3.5 py-1.5 border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 rounded-xl text-[12px] font-bold transition-all">Prev</button>`;
            }

            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            if (startPage > 1) {
                html += `<button data-page="1" class="js-page-btn px-3 py-1.5 border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 rounded-xl text-[12px] font-bold transition-all">1</button>`;
                if (startPage > 2) html += `<span class="px-1.5 text-slate-400 text-xs self-end pb-1">…</span>`;
            }

            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    html += `<button class="px-3 py-1.5 border border-[#4E0000] bg-[#4E0000] text-white font-bold rounded-xl text-[12px] shadow-sm">${i}</button>`;
                } else {
                    html += `<button data-page="${i}" class="js-page-btn px-3 py-1.5 border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 rounded-xl text-[12px] font-bold transition-all">${i}</button>`;
                }
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) html += `<span class="px-1.5 text-slate-400 text-xs self-end pb-1">…</span>`;
                html += `<button data-page="${totalPages}" class="js-page-btn px-3 py-1.5 border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 rounded-xl text-[12px] font-bold transition-all">${totalPages}</button>`;
            }

            // Next Button
            if (currentPage === totalPages) {
                html += `<button disabled class="px-3.5 py-1.5 border border-slate-200 text-slate-400 rounded-xl text-[12px] font-bold cursor-not-allowed bg-slate-50/50">Next</button>`;
            } else {
                html += `<button data-page="${currentPage + 1}" class="js-page-btn px-3.5 py-1.5 border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 rounded-xl text-[12px] font-bold transition-all">Next</button>`;
            }

            buttonsEl.innerHTML = html;

            // Bind page button clicks
            buttonsEl.querySelectorAll('.js-page-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentPage = parseInt(btn.dataset.page);
                    applyFiltersAndPaginate();
                });
            });
        }
    }

    // When filters change, reset to page 1
    function onFilterChange() {
        currentPage = 1;
        applyFiltersAndPaginate();
    }

    searchInputs.forEach(input => {
        input.addEventListener('input', onFilterChange);
    });
    
    filterSelects.forEach(select => {
        select.addEventListener('change', onFilterChange);
    });
    
    resetBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            searchInputs.forEach(input => input.value = '');
            filterSelects.forEach(select => select.value = '');
            currentPage = 1;
            onFilterChange();
        });
    });

    // Items-per-page selector
    const perPageSelect = document.querySelector('.js-per-page-select');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', () => {
            currentPerPage = perPageSelect.value === 'all' ? 'all' : parseInt(perPageSelect.value);
            currentPage = 1;
            applyFiltersAndPaginate();
        });
    }

    // Initial pagination render
    if (paginationContainer) {
        applyFiltersAndPaginate();
    }

    // Delete Buttons in Tables
    const deleteBtns = document.querySelectorAll('.js-delete-row');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            showModal('Delete Item', 'Are you sure you want to delete this item? This action cannot be undone.', 'Delete', 'bg-red-600 hover:bg-red-700', () => {
                row.remove();
                showToast('Item deleted successfully', 'success');
            });
        });
    });
}



// --- Form Validation (Upload & Settings) ---

function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Skip dirtiness check for forms that shouldn't have it (like search filters or login)
        const skipDirtyCheck = form.classList.contains('js-no-dirty-check') || form.action.includes('login.php') || window.location.href.includes('login');
        
        // Function to serialize form, including handling Quill if present
        const getFormState = (submitter = null) => {
            // Trigger any pre-submit syncs if they exist (like Quill)
            if (typeof window.syncQuillToHidden === 'function') {
                window.syncQuillToHidden();
            }
            
            const formData = new FormData(form);
            if (submitter && submitter.name) {
                formData.append(submitter.name, submitter.value);
            }
            return new URLSearchParams(formData).toString();
        };

        let initialState = '';
        if (!skipDirtyCheck) {
            // Capture initial state after a short delay to allow rich text editors to initialize
            setTimeout(() => {
                initialState = getFormState();
            }, 500);
        }

        form.addEventListener('submit', (e) => {
            // Check form double submission
            if (form.dataset.submitting === 'true') {
                const submitBtn = e.submitter || form.querySelector('button[type="submit"]');
                if (submitBtn && submitBtn.disabled) {
                    e.preventDefault();
                    return;
                } else {
                    // The button was re-enabled by an AJAX script, so reset submitting state
                    form.dataset.submitting = 'false';
                }
            }

            // Check form dirtiness first
            if (!skipDirtyCheck && initialState !== '') {
                const submitBtn = e.submitter || form.querySelector('button[type="submit"]');
                const currentState = getFormState(submitBtn);
                if (currentState === initialState) {
                    e.preventDefault();
                    if (typeof window.showToast === 'function') {
                        window.showToast("No changes have been made.", "info");
                    }
                    
                    // Reset any loading spinners on the submit button that might have been triggered by other scripts
                    const btn = e.submitter || form.querySelector('button[type="submit"]');
                    if (btn && btn.dataset.originalContent) {
                        btn.innerHTML = btn.dataset.originalContent;
                        btn.disabled = false;
                    }
                    return;
                }
            }
            
            // Call the globally exportable validation helper
            const skipValidation = e.submitter && e.submitter.hasAttribute('formnovalidate');
            if (!window.validateForm(form, skipValidation)) {
                e.preventDefault();
                // Reset loading spinners if validation failed
                const btn = e.submitter || form.querySelector('button[type="submit"]');
                if (btn && btn.dataset.originalContent) {
                    btn.innerHTML = btn.dataset.originalContent;
                    btn.disabled = false;
                }
                return;
            }
            
            // Validation passed, mark form as submitting to prevent double-clicks
            form.dataset.submitting = 'true';
            
            // If valid (or validation bypassed), apply loading state to the submit button
            const submitBtn = e.submitter || form.querySelector('button[type="submit"]');
            if (submitBtn) {
                // Determine processing text based on original text
                const originalText = submitBtn.textContent.trim();
                let processingText = "Processing...";
                if (originalText.toLowerCase() === 'login') processingText = 'Authenticating...';
                else if (originalText.toLowerCase().includes('save')) processingText = 'Saving...';
                else if (originalText.toLowerCase().includes('submit')) processingText = 'Submitting...';
                else if (originalText.toLowerCase().includes('publish')) processingText = 'Publishing...';

                // Save original content in case we need to revert (though usually page reloads)
                if (!submitBtn.dataset.originalContent) {
                    submitBtn.dataset.originalContent = submitBtn.innerHTML;
                }

                // Add spinner and processing text
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${processingText}
                `;
                
                // Disable the button to prevent double submission (except for login form to allow browser credential saving)
                if (form.id !== 'loginForm') {
                    setTimeout(() => {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                    }, 10);
                }
            }
        });
    });
}

// Global Validation Helper (allows AJAX forms like officials.php to reuse custom validation styles)
window.validateForm = function(form, skipValidation = false) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');
    
    // Clear any existing custom error messages
    form.querySelectorAll('.custom-error-msg').forEach(el => el.remove());
    form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'focus:ring-red-500'));

    if (skipValidation) return true;

    let firstInvalidField = null;

    // Validate required fields
    requiredFields.forEach(field => {
        let fieldError = '';
        
        // 1. Required Check
        if (!field.value.trim()) {
            let label = form.querySelector(`label[for="${field.id}"]`) || field.closest('div')?.querySelector('label');
            const fieldName = label ? label.textContent.replace('*', '').trim() : 'This field';
            fieldError = `${fieldName} is required.`;
        } 
        // 2. Email format check
        else if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value.trim())) {
            fieldError = 'Please enter a valid email address.';
        }
        // 3. Password length check
        else if (field.type === 'password' && (field.classList.contains('js-pwd') || field.id.includes('Password')) && field.value.length < 6) {
            fieldError = 'Password must be at least 6 characters.';
        }

        if (fieldError) {
            isValid = false;
            
            // Handle file inputs that are styled/hidden (e.g. cover image)
            if (field.type === 'file' && field.classList.contains('sr-only')) {
                const dropzone = field.closest('.border-dashed');
                if (dropzone) {
                    dropzone.classList.add('border-red-500', 'bg-red-50/10');
                    if (!firstInvalidField) firstInvalidField = dropzone;
                    
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'custom-error-msg text-xs text-red-600 mt-1 font-semibold';
                    errorMsg.textContent = fieldError;
                    dropzone.insertAdjacentElement('afterend', errorMsg);
                }
            } else {
                field.classList.add('border-red-500', 'focus:ring-red-500');
                if (!firstInvalidField) firstInvalidField = field;

                // Add custom error message below field
                const errorMsg = document.createElement('p');
                errorMsg.className = 'custom-error-msg text-xs text-red-600 mt-1 font-semibold transition-all duration-200';
                errorMsg.textContent = fieldError;
                
                // Insert after the field, or after its relative container if it has a custom icon/wrapper
                const parent = field.parentElement;
                if (parent && parent.classList.contains('relative')) {
                    parent.insertAdjacentElement('afterend', errorMsg);
                } else {
                    field.insertAdjacentElement('afterend', errorMsg);
                }
            }
        }
    });

    // Quill Editor Checks (typically hidden inputs representing rich text)
    const quillInputs = form.querySelectorAll('#content_en_input, #content_si_input, #content_ta_input');
    quillInputs.forEach(input => {
        // Sync Quill editors first
        if (typeof window.syncQuillToHidden === 'function') {
            window.syncQuillToHidden();
        }
        // Only validate if it's the primary content (English/default)
        if (input.id === 'content_en_input' && !input.value.trim()) {
            isValid = false;
            const quillEditor = form.querySelector('#content_en');
            if (quillEditor) {
                const quillContainer = quillEditor.closest('.border');
                if (quillContainer) {
                    quillContainer.classList.add('border-red-500');
                    if (!firstInvalidField) firstInvalidField = quillEditor;
                    
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'custom-error-msg text-xs text-red-600 mt-1 font-semibold';
                    errorMsg.textContent = 'News Body (English) is required.';
                    quillContainer.insertAdjacentElement('afterend', errorMsg);
                }
            }
        }
    });

    // Optional but filled password check (e.g. for edits where password is not required but filled)
    const optionalPwds = form.querySelectorAll('input[type="password"]:not([required])');
    optionalPwds.forEach(field => {
        if (field.value.trim() && field.value.length < 6) {
            isValid = false;
            field.classList.add('border-red-500', 'focus:ring-red-500');
            if (!firstInvalidField) firstInvalidField = field;

            const errorMsg = document.createElement('p');
            errorMsg.className = 'custom-error-msg text-xs text-red-600 mt-1 font-semibold';
            errorMsg.textContent = 'Password must be at least 6 characters.';
            
            const parent = field.parentElement;
            if (parent && parent.classList.contains('relative')) {
                parent.insertAdjacentElement('afterend', errorMsg);
            } else {
                field.insertAdjacentElement('afterend', errorMsg);
            }
        }
    });

    // Special password confirmation check for Settings / Manage Admins
    const pwd = form.querySelector('.js-pwd');
    const pwdConfirm = form.querySelector('.js-pwd-confirm');
    
    if (pwd && pwdConfirm && (pwd.value.trim() || pwdConfirm.value.trim()) && pwd.value !== pwdConfirm.value) {
        isValid = false;
        pwdConfirm.classList.add('border-red-500');
        if (!firstInvalidField) firstInvalidField = pwdConfirm;

        const errorMsg = document.createElement('p');
        errorMsg.className = 'custom-error-msg text-xs text-red-600 mt-1 font-semibold';
        errorMsg.textContent = 'Passwords do not match.';
        
        const parent = pwdConfirm.parentElement;
        if (parent && parent.classList.contains('relative')) {
            parent.insertAdjacentElement('afterend', errorMsg);
        } else {
            pwdConfirm.insertAdjacentElement('afterend', errorMsg);
        }
    }

    // Inline dynamic clearing as user types
    const handleInputClear = (e) => {
        const field = e.target;
        field.classList.remove('border-red-500', 'focus:ring-red-500');
        const container = field.parentElement;
        const errorSibling = container.classList.contains('relative') ? container.nextElementSibling : field.nextElementSibling;
        if (errorSibling && errorSibling.classList.contains('custom-error-msg')) {
            errorSibling.remove();
        }
        
        // Clear custom file dropzone error
        if (field.type === 'file') {
            const dropzone = field.closest('.border-dashed');
            if (dropzone) {
                dropzone.classList.remove('border-red-500', 'bg-red-50/10');
                const dropzoneSibling = dropzone.nextElementSibling;
                if (dropzoneSibling && dropzoneSibling.classList.contains('custom-error-msg')) {
                    dropzoneSibling.remove();
                }
            }
        }
    };
    
    // Clear custom Quill error when user types in Quill editor
    form.querySelectorAll('.ql-editor').forEach(editor => {
        editor.addEventListener('keyup', () => {
            const quillContainer = editor.closest('.border');
            if (quillContainer) {
                quillContainer.classList.remove('border-red-500');
                const errorSibling = quillContainer.nextElementSibling;
                if (errorSibling && errorSibling.classList.contains('custom-error-msg')) {
                    errorSibling.remove();
                }
            }
        });
    });
    
    const allFieldsToBind = form.querySelectorAll('input, textarea, select');
    allFieldsToBind.forEach(field => {
        field.addEventListener('input', handleInputClear);
        field.addEventListener('change', handleInputClear);
    });

    if (!isValid) {
        showToast('Please correct errors before submitting', 'error');
        
        // Scroll to first invalid field smoothly
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => firstInvalidField.focus(), 300);
        }
    } else {
        // Aesthetic Polish: Button loading state on valid submit
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.dataset.submitting) {
            submitBtn.dataset.submitting = "true";
            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80', 'cursor-wait');
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin shrink-0 text-current" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Processing...</span>
            `;
        }
    }

    return isValid;
};

// ==========================================
// COMMAND PALETTE (CTRL + K) UX SYSTEM
// ==========================================
const commandPaletteItems = [
    { name: 'Dashboard Overview', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', url: 'dashboard', category: 'Navigation' },
    { name: 'Add News Update', icon: 'M12 4v16m8-8H4', url: 'news-add', category: 'Quick Action' },
    { name: 'News & Press Releases', icon: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15', url: 'news', category: 'Content' },
    { name: 'Special Notices', icon: 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', url: 'manage-special-notices', category: 'Content' },
    { name: 'Directory Officials', icon: 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', url: 'officials', category: 'Directory' },
    { name: 'Circuit Bungalow Bookings', icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', url: 'bungalow-bookings', category: 'Services' },
    { name: 'Homepage Slider Collections', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', url: 'manage-sliders', category: 'Media' },
    { name: 'Local Learning & Publications', icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', url: 'manage-learning-platforms-local', category: 'Publications' },
    { name: 'Foreign Learning & Publications', icon: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V7a2 2 0 00-2-2h-1.5a.5.5 0 01-.5-.5V3.935M21 12a9 9 0 11-18 0 9 9 0 0118 0z', url: 'manage-learning-platforms-foreign', category: 'Publications' },
    { name: 'Tenders & Procurements', icon: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', url: 'manage-procurements', category: 'Careers' },
    { name: 'Vacancies & Careers', icon: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', url: 'manage-vacancies', category: 'Careers' },
    { name: 'Administrator Accounts', icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', url: 'manage-admins', category: 'Settings' },
    { name: 'Account Settings', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', url: 'settings', category: 'Settings' }
];

window.openCommandPalette = function() {
    let modal = document.getElementById('command-palette-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'command-palette-modal';
        modal.className = 'fixed inset-0 z-[99999] flex items-start justify-center pt-16 md:pt-24 px-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-200 opacity-0 pointer-events-none';
        
        modal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden border border-slate-100 flex flex-col max-h-[80vh] transform scale-95 transition-all duration-200" id="command-palette-card">
                <div class="p-4 border-b border-slate-100 flex items-center gap-3 relative bg-slate-50/50">
                    <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                    <input type="text" id="cmd-input" placeholder="Type a command or search page links..." class="w-full bg-transparent text-sm text-slate-800 focus:outline-none font-medium placeholder-slate-400">
                    <kbd class="px-2 py-1 text-[10px] font-mono font-bold bg-slate-200/70 text-slate-500 rounded border border-slate-300/60 shrink-0">ESC</kbd>
                </div>
                <div class="overflow-y-auto p-2 space-y-1 flex-1" id="cmd-results"></div>
                <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-400 font-medium flex items-center justify-between font-mono">
                    <span>Use ↑ ↓ to navigate, Enter to select</span>
                    <span>Ministry CMS</span>
                </div>
            </div>
        `;
        document.body.appendChild(modal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeCommandPalette();
        });
    }

    const card = modal.querySelector('#command-palette-card');
    const input = modal.querySelector('#cmd-input');
    const results = modal.querySelector('#cmd-results');

    modal.classList.remove('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-95');
    card.classList.add('scale-100');

    input.value = '';
    renderCommandResults('', results);
    setTimeout(() => input.focus(), 50);

    let activeIndex = 0;

    const handleKey = (e) => {
        if (e.key === 'Escape') {
            closeCommandPalette();
            document.removeEventListener('keydown', handleKey);
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            const items = results.querySelectorAll('.cmd-item');
            if (items.length > 0) {
                activeIndex = (activeIndex + 1) % items.length;
                updateActiveCmdItem(items, activeIndex);
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            const items = results.querySelectorAll('.cmd-item');
            if (items.length > 0) {
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                updateActiveCmdItem(items, activeIndex);
            }
        } else if (e.key === 'Enter') {
            e.preventDefault();
            const items = results.querySelectorAll('.cmd-item');
            if (items[activeIndex]) {
                items[activeIndex].click();
            }
        }
    };

    document.addEventListener('keydown', handleKey);

    input.oninput = (e) => {
        activeIndex = 0;
        renderCommandResults(e.target.value, results);
    };
};

function closeCommandPalette() {
    const modal = document.getElementById('command-palette-modal');
    if (!modal) return;
    const card = modal.querySelector('#command-palette-card');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    modal.classList.add('opacity-0', 'pointer-events-none');
}

function renderCommandResults(query, container) {
    const q = query.toLowerCase().trim();
    const filtered = commandPaletteItems.filter(item => 
        item.name.toLowerCase().includes(q) || item.category.toLowerCase().includes(q)
    );

    if (filtered.length === 0) {
        container.innerHTML = `
            <div class="py-8 text-center text-xs text-slate-400">
                No matching admin pages or actions found.
            </div>
        `;
        return;
    }

    container.innerHTML = filtered.map((item, idx) => `
        <a href="${item.url}" class="cmd-item flex items-center justify-between p-3 rounded-xl transition-all duration-150 group ${idx === 0 ? 'bg-slate-100/80 text-primary font-bold' : 'hover:bg-slate-50 text-slate-700 font-medium'}">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200/80 flex items-center justify-center text-slate-500 group-hover:text-primary transition-colors shrink-0 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="${item.icon}"></path></svg>
                </div>
                <span class="text-[13px]">${item.name}</span>
            </div>
            <span class="text-[10px] font-mono uppercase tracking-wider font-bold px-2 py-0.5 rounded bg-slate-200/50 text-slate-500">${item.category}</span>
        </a>
    `).join('');
}

function updateActiveCmdItem(items, activeIndex) {
    items.forEach((el, idx) => {
        if (idx === activeIndex) {
            el.classList.add('bg-slate-100/80', 'text-primary', 'font-bold');
            el.classList.remove('hover:bg-slate-50');
            el.scrollIntoView({ block: 'nearest' });
        } else {
            el.classList.remove('bg-slate-100/80', 'text-primary', 'font-bold');
        }
    });
}

// Bind Ctrl+K global shortcut
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        window.openCommandPalette();
    }
});

// ==========================================
// ASYNC INLINE SWITCH TOGGLES (AJAX)
// ==========================================
document.addEventListener('change', (e) => {
    if (e.target.classList.contains('js-status-toggle')) {
        const toggle = e.target;
        const targetUrl = toggle.dataset.url;
        const action = toggle.dataset.action;
        const id = toggle.dataset.id;
        const isChecked = toggle.checked ? 1 : 0;

        if (!targetUrl || !action || !id) return;

        const formData = new FormData();
        formData.append('action', action);
        formData.append('id', id);
        formData.append('status', isChecked);

        fetch(targetUrl, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || "Status updated successfully", "success");
            } else {
                toggle.checked = !toggle.checked; // Revert on failure
                showToast(data.error || "Failed to update status", "error");
            }
        })
        .catch(err => {
            toggle.checked = !toggle.checked; // Revert on failure
            showToast("Network connection error", "error");
        });
    }
});

// --- Idle Session Lock Screen ---
function initIdleTimer() {
    const path = window.location.pathname;
    if (path.includes('login') || path.includes('logout') || path.includes('unlock')) {
        return;
    }

    let idleTime = 0;
    // Lock screen triggers after 15 minutes of inactivity (900 seconds)
    const idleLimit = 900; 

    setInterval(() => {
        if (localStorage.getItem('workspace_locked') === 'true') {
            idleTime = 0;
            return;
        }
        idleTime++;
        if (idleTime >= idleLimit) {
            triggerWorkspaceLock();
        }
    }, 1000);

    const resetIdleTime = () => {
        idleTime = 0;
    };

    const events = ['mousemove', 'mousedown', 'keypress', 'touchstart', 'scroll'];
    events.forEach(event => {
        document.addEventListener(event, resetIdleTime, { passive: true });
    });
}

function triggerWorkspaceLock() {
    const currentUrl = window.location.pathname + window.location.search;
    const formData = new FormData();
    formData.append('current_url', currentUrl);

    fetch('lock-session.php', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (typeof window.showLockscreen === 'function') {
                window.showLockscreen();
            } else {
                window.location.reload();
            }
        }
    })
    .catch(err => {
        window.location.reload();
    });
}

window.resolvePdfUrlJs = function(path) {
    if (!path || path === '#') return '#';
    if (path.startsWith('http://') || path.startsWith('https://')) {
        return path;
    }
    let cleanPath = path;
    if (cleanPath.startsWith('/')) {
        cleanPath = cleanPath.substring(1);
    }
    if (cleanPath.startsWith('admin/')) {
        cleanPath = cleanPath.substring(6);
    }
    return cleanPath;
};

// --- Trilingual PDF Upload Widget Preview & Clear Controls ---
document.addEventListener('DOMContentLoaded', () => {
    // Wrap openEditModal and openAddModal to clear cached attributes
    ['openEditModal', 'openAddModal'].forEach(funcName => {
        const originalFunc = window[funcName];
        if (typeof originalFunc === 'function') {
            window[funcName] = function(...args) {
                ['En', 'Si', 'Ta'].forEach(suffix => {
                    const container = document.getElementById('pdfViewContainer' + suffix);
                    if (container) {
                        container.removeAttribute('data-original-href');
                        container.removeAttribute('data-original-text');
                    }
                });
                return originalFunc.apply(this, args);
            };
        }
    });
});

// Listener for file input selection to show local preview
document.addEventListener('change', (e) => {
    const input = e.target;
    if (input.tagName === 'INPUT' && input.type === 'file' && input.accept === 'application/pdf') {
        const file = input.files[0];
        let suffix = '';
        if (input.id.endsWith('En')) suffix = 'En';
        else if (input.id.endsWith('Si')) suffix = 'Si';
        else if (input.id.endsWith('Ta')) suffix = 'Ta';
        
        if (!suffix) return;
        
        const container = document.getElementById('pdfViewContainer' + suffix);
        const link = document.getElementById('pdfLink' + suffix);
        
        if (container && link) {
            if (file) {
                if (!container.hasAttribute('data-original-href')) {
                    container.setAttribute('data-original-href', link.getAttribute('href') || '#');
                    container.setAttribute('data-original-text', link.textContent || 'View PDF');
                }
                
                const objectUrl = URL.createObjectURL(file);
                link.href = objectUrl;
                link.textContent = file.name;
                
                container.classList.remove('hidden');
                container.classList.add('flex');
            }
        }
    }
});

// Capturing listener to intercept and handle clicks on the delete button for local files
document.addEventListener('click', (e) => {
    const button = e.target.closest('button[onclick^="deletePdfAjax"]');
    if (button) {
        const match = button.getAttribute('onclick').match(/deletePdfAjax\('([a-z]+)'\)/);
        if (match) {
            const lang = match[1];
            const suffix = lang.charAt(0).toUpperCase() + lang.slice(1);
            
            // Find corresponding input
            const input = document.querySelector(`input[type="file"][id$="${suffix}"]`);
            if (input && input.files.length > 0) {
                // Intercept event to prevent calling backend AJAX deletion
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                input.value = '';
                
                const container = document.getElementById('pdfViewContainer' + suffix);
                const link = document.getElementById('pdfLink' + suffix);
                if (container && link) {
                    const originalHref = container.getAttribute('data-original-href') || '#';
                    const originalText = container.getAttribute('data-original-text') || 'View PDF';
                    
                    if (originalHref !== '#' && originalHref !== '') {
                        link.href = originalHref;
                        link.textContent = originalText;
                    } else {
                        container.classList.add('hidden');
                        container.classList.remove('flex');
                    }
                }
                return false;
            }
        }
    }
}, true); // capturing phase is required to execute before inline onclick


// --- Centralized Trilingual Translation & Tab Switching ---

async function translateText(text, fromLang, toLang) {
    if (!text) return '';
    const res = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=${fromLang}&tl=${toLang}&dt=t&q=${encodeURIComponent(text)}`);
    const data = await res.json();
    return data[0].map(x => x[0]).join('');
}

async function autoTranslateTrilingualField(tabGroupId, fieldName, idPrefix, fromLang, type) {
    const langs = ['en', 'si', 'ta'];
    const sourceId = idPrefix + fromLang.charAt(0).toUpperCase() + fromLang.slice(1);
    let sourceVal = '';

    if (type === 'quill') {
        const quillSource = window['quill' + idPrefix + fromLang.charAt(0).toUpperCase() + fromLang.slice(1)];
        if (quillSource) {
            sourceVal = quillSource.getText().trim();
        }
    } else {
        sourceVal = document.getElementById(sourceId).value.trim();
    }

    if (!sourceVal) {
        window.showToast('Please enter text to translate.', 'warning');
        return;
    }

    const translateBtn = document.getElementById(`translate-btn-${idPrefix}-${fromLang}`);
    const originalText = translateBtn.innerHTML;
    translateBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Translating...';
    translateBtn.disabled = true;

    try {
        for (const lang of langs) {
            if (lang === fromLang) continue;
            const targetId = idPrefix + lang.charAt(0).toUpperCase() + lang.slice(1);
            
            if (type === 'quill') {
                const quillTarget = window['quill' + idPrefix + lang.charAt(0).toUpperCase() + lang.slice(1)];
                if (quillTarget) {
                    const translatedText = await translateText(sourceVal, fromLang, lang);
                    quillTarget.setText(translatedText);
                }
            } else {
                const translatedText = await translateText(sourceVal, fromLang, lang);
                document.getElementById(targetId).value = translatedText;
            }
        }
        window.showToast('Translation completed successfully.', 'success');
    } catch (err) {
        console.error(err);
        window.showToast('An error occurred during translation.', 'error');
    } finally {
        translateBtn.innerHTML = originalText;
        translateBtn.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.lang-tab-btn');
        if (!btn) return;
        
        const container = btn.parentElement;
        const targetId = btn.dataset.target;
        if (!targetId) return;

        // Toggle active states on buttons within the same container
        container.querySelectorAll('.lang-tab-btn').forEach(b => {
            b.classList.remove('active', 'text-secondary', 'bg-white', 'shadow-sm', 'font-bold');
            b.classList.add('text-slate-500', 'font-semibold', 'hover:bg-slate-50/50');
        });
        btn.classList.add('active', 'bg-white', 'shadow-sm', 'text-secondary', 'font-bold');
        btn.classList.remove('text-slate-500', 'font-semibold', 'hover:bg-slate-50/50');

        // Toggle visibility of target panels
        const parentModalOrPage = container.parentElement;
        parentModalOrPage.querySelectorAll('.lang-tab-content').forEach(panel => {
            if (panel.id === targetId) {
                panel.classList.remove('hidden');
                panel.classList.add('block');
            } else {
                panel.classList.add('hidden');
                panel.classList.remove('block');
            }
        });
    });
});

window.initTrilingualQuill = function(idPrefix) {
    const langs = ['En', 'Si', 'Ta'];
    const options = {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    };
    
    langs.forEach(lang => {
        const selector = '#' + idPrefix + lang;
        const inputId = idPrefix + lang + '_input';
        const el = document.querySelector(selector);
        if (el) {
            const quill = new Quill(selector, options);
            window['quill' + idPrefix + lang] = quill;
            
            const input = document.getElementById(inputId);
            if (input && input.value) {
                quill.root.innerHTML = input.value;
            }
        }
    });
};

window.syncQuillToHidden = function() {
    const inputs = document.querySelectorAll('input[type="hidden"][id$="_input"]');
    inputs.forEach(input => {
        const baseId = input.id.replace('_input', '');
        const quill = window['quill' + baseId];
        if (quill) {
            const html = quill.root.innerHTML;
            input.value = (html === '<p><br></p>') ? '' : html;
        }
    });
};


