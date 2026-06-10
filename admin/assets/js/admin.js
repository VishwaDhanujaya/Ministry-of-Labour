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
    
    // Styling based on type
    let bgClass = type === 'success' ? 'bg-[#0A6C5B]' : (type === 'error' ? 'bg-red-600' : 'bg-gray-800');
    toast.className = `px-6 py-3.5 rounded-xl shadow-2xl text-white text-[13px] font-bold transform transition-all duration-300 translate-y-10 opacity-0 ${bgClass}`;
    toast.textContent = message;
    
    container.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-y-10', 'opacity-0');
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
    
    const bg = document.createElement('div');
    bg.className = 'absolute inset-0 bg-black/60 backdrop-blur-sm';
    overlay.appendChild(bg);
    
    const modal = document.createElement('div');
    modal.id = 'mock-modal';
    modal.className = 'bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform scale-95 transition-all duration-300 relative z-10';
    
    modal.innerHTML = `
        <h3 id="modal-title" class="text-xl font-bold font-montserrat text-gray-900 mb-2">Confirm Action</h3>
        <p id="modal-message" class="text-[13px] text-gray-600 mb-6">Are you sure you want to proceed?</p>
        <div class="flex justify-end gap-3">
            <button id="modal-cancel" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="modal-confirm" class="px-5 py-2 bg-red-600 text-white rounded-md text-[13px] font-bold hover:bg-red-700 transition-colors">Confirm</button>
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
    
    const confirmBtn = document.getElementById('modal-confirm');
    confirmBtn.textContent = confirmBtnText;
    confirmBtn.className = `px-5 py-2 text-white rounded-md text-[13px] font-bold transition-colors ${confirmBtnClass}`;
    
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
    const forms = document.querySelectorAll('.js-validate-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            let isValid = true;
            const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');
            
            // Check if the submission was triggered by a button with formnovalidate (like Save as Draft)
            if (e.submitter && e.submitter.hasAttribute('formnovalidate')) {
                return; // Skip custom JS validation, let it submit to PHP
            }
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500', 'focus:ring-red-500');
                } else {
                    field.classList.remove('border-red-500', 'focus:ring-red-500');
                }
            });
            
            // Special password check for Settings
            const pwd = form.querySelector('.js-pwd');
            const pwdConfirm = form.querySelector('.js-pwd-confirm');
            
            if (pwd && pwdConfirm && pwd.value !== pwdConfirm.value) {
                isValid = false;
                pwdConfirm.classList.add('border-red-500');
                showToast('Passwords do not match', 'error');
            }

            if (!isValid) {
                e.preventDefault();
                showToast('Please correct errors before submitting', 'error');
                return;
            }
            
            // If valid, the form will submit normally to PHP
        });
    });
}
