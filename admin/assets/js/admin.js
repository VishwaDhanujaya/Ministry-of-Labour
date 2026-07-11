/**
 * Admin Dashboard - Frontend Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    initToastContainer();
    initModalContainer();
    
    initGlobalInteractions();
    initTableFiltering();
    initFormValidation();
});

// --- UI Utilities (Toasts & Modals) ---

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
    const toast = document.createElement('div');
    
    // Status colors mapping
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
    
    // Modern glassmorphism layout matching header/sidebar (#13273F)
    toast.className = `relative overflow-hidden flex items-center gap-3.5 p-4 pr-10 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] text-white text-[13px] font-semibold transform transition-all duration-300 translate-y-10 opacity-0 bg-[#13273F]/95 backdrop-blur-md border border-white/10 font-inter pointer-events-auto max-w-sm w-full`;
    
    toast.innerHTML = `
        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 ${config.bg} border">
            ${config.icon}
        </div>
        <div class="flex-1 text-gray-100 font-inter leading-snug">${message}</div>
        <button type="button" onclick="this.parentElement.remove()" class="absolute top-1/2 -translate-y-1/2 right-3 text-white/40 hover:text-white transition-colors focus:outline-none p-1 rounded-md hover:bg-white/5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="absolute bottom-0 left-0 h-1 transition-all duration-[3000ms] ease-linear w-full ${config.bar}" style="width: 100%" id="toast-progress"></div>
    `;
    
    container.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-y-10', 'opacity-0');
        const progress = toast.querySelector('#toast-progress');
        if (progress) progress.style.width = '0%';
    }, 10);
    
    // Animate out
    setTimeout(() => {
        toast.classList.add('translate-y-10', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
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


// --- Table Filtering Logic ---

function initTableFiltering() {
    const searchInputs = document.querySelectorAll('.js-table-search');
    const filterSelects = document.querySelectorAll('.js-table-filter');
    const resetBtns = document.querySelectorAll('.js-reset-filter');
    
    if (searchInputs.length === 0 && filterSelects.length === 0) return;

    function applyFilters() {
        const table = document.querySelector('.js-filterable-table tbody');
        const cardsContainer = document.querySelectorAll('.js-booking-card');
        
        let itemsToFilter = [];
        if (table) {
            itemsToFilter = Array.from(table.querySelectorAll('tr'));
        } else if (cardsContainer.length > 0) {
            itemsToFilter = Array.from(cardsContainer);
        }
        
        if (itemsToFilter.length === 0) return;
        
        const searchTerm = searchInputs.length > 0 ? searchInputs[0].value.toLowerCase() : '';
        
        // Get all select values
        const activeFilters = [];
        filterSelects.forEach(select => {
            if (select.value) {
                activeFilters.push(select.value.toLowerCase());
            }
        });
        
        itemsToFilter.forEach(item => {
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
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInputs.forEach(input => {
        input.addEventListener('input', applyFilters);
    });
    
    filterSelects.forEach(select => {
        select.addEventListener('change', () => {
            applyFilters();
        });
    });
    
    resetBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            searchInputs.forEach(input => input.value = '');
            filterSelects.forEach(select => select.value = '');
            applyFilters();
        });
    });

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
        const getFormState = () => {
            // Trigger any pre-submit syncs if they exist (like Quill)
            if (typeof window.syncQuillToHidden === 'function') {
                window.syncQuillToHidden();
            }
            
            const formData = new FormData(form);
            // Ignore csrf_token since it might not be the real changed data we care about, though it shouldn't change
            // Actually it's fine to keep it.
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
            // Check form dirtiness first
            if (!skipDirtyCheck && initialState !== '') {
                const currentState = getFormState();
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
                
                // Disable the button to prevent double submission
                // We add a tiny delay so the form data from this button (if it has name/value) is still submitted
                setTimeout(() => {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                }, 10);
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
    }

    return isValid;
};

