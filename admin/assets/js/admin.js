/**
 * Admin Dashboard - Frontend Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    initToastContainer();
    initModalContainer();
    
    initGlobalInteractions();
    initTableFiltering();
    initFormValidation();
    initBookingActions();
    initDateScroller();
    initDragAndDrop();
});

// --- UI Utilities (Toasts & Modals) ---

let toastTimeout;
function initToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed bottom-5 right-5 z-50 flex flex-col gap-3';
    document.body.appendChild(container);
}

window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    
    // Styling based on type
    let bgClass = type === 'success' ? 'bg-[#0A6C5B]' : (type === 'error' ? 'bg-red-600' : 'bg-gray-800');
    toast.className = `px-6 py-3 rounded shadow-lg text-white text-[13px] font-bold transform transition-all duration-300 translate-y-10 opacity-0 ${bgClass}`;
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
    const overlay = document.createElement('div');
    overlay.id = 'modal-overlay';
    overlay.className = 'fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center transition-opacity opacity-0 duration-300';
    
    const modal = document.createElement('div');
    modal.id = 'mock-modal';
    modal.className = 'bg-white rounded-xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300';
    
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
    // trigger reflow
    void overlay.offsetWidth;
    overlay.classList.remove('opacity-0');
    modal.classList.remove('scale-95');
}

function hideModal() {
    const overlay = document.getElementById('modal-overlay');
    const modal = document.getElementById('mock-modal');
    
    overlay.classList.add('opacity-0');
    modal.classList.add('scale-95');
    
    setTimeout(() => {
        overlay.classList.add('hidden');
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
    
    // Edit Buttons in Tables
    const editBtns = document.querySelectorAll('.js-edit-row');
    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Future edit logic here
        });
    });
}


// --- Form Validation (Upload & Settings) ---

function initFormValidation() {
    const forms = document.querySelectorAll('.js-validate-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            let isValid = true;
            const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');
            
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
                return;
            }

            if (!isValid) {
                showToast('Please fill in all required fields', 'error');
                return;
            }
            
            // Mock submission
            showToast('Changes saved successfully!', 'success');
            
            // If it's a new item form (not settings), reset it
            if (form.classList.contains('js-reset-on-success')) {
                form.reset();
            }
        });
    });
    
    // Specific mock for "Save as Draft"
    const draftBtns = document.querySelectorAll('.js-save-draft');
    draftBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            showToast('Draft saved securely.', 'success');
        });
    });
}


// --- Bungalow Bookings ---

function initBookingActions() {
    const approveBtns = document.querySelectorAll('.js-booking-approve');
    const rejectBtns = document.querySelectorAll('.js-booking-reject');
    
    approveBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const card = e.target.closest('.js-booking-card');
            showModal('Approve Booking', 'Are you sure you want to approve this booking?', 'Approve', 'bg-[#0A6C5B] hover:bg-[#075043]', () => {
                updateBookingStatus(card, 'Confirmed', 'bg-[#0A6C5B]/30 text-[#D1F1E8]');
                showToast('Booking approved successfully', 'success');
            });
        });
    });
    
    rejectBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const card = e.target.closest('.js-booking-card');
            showModal('Reject Booking', 'Are you sure you want to reject this booking?', 'Reject', 'bg-red-600 hover:bg-red-700', () => {
                updateBookingStatus(card, 'Cancelled', 'bg-red-900/40 text-red-300');
                showToast('Booking rejected', 'success');
            });
        });
    });
}

function updateBookingStatus(card, newText, newClasses) {
    const statusPill = card.querySelector('.js-status-pill');
    if (statusPill) {
        statusPill.textContent = newText;
        statusPill.className = `js-status-pill px-2.5 py-0.5 rounded text-[10px] font-bold ${newClasses}`;
    }
    // Optionally disable buttons
    const footer = card.querySelector('.bg-\\[\\#E5E7EB\\]');
    if(footer) footer.style.opacity = '0.5';
}

function initDateScroller() {
    const dates = document.querySelectorAll('.js-date-block');
    if(dates.length === 0) return;
    
    dates.forEach(date => {
        date.addEventListener('click', () => {
            // Remove active from all
            dates.forEach(d => {
                d.className = 'js-date-block flex flex-col items-center justify-center w-16 h-20 bg-[#F9FAFB] text-gray-800 rounded-lg border border-gray-200 shrink-0 cursor-pointer hover:bg-gray-50 transition-colors';
                const dot = d.querySelector('div');
                if(dot) dot.className = 'w-1.5 h-1.5 rounded-full bg-gray-300';
            });
            
            // Set active to clicked
            date.className = 'js-date-block flex flex-col items-center justify-center w-16 h-20 bg-[#13273F] text-white rounded-lg border border-[#13273F] shrink-0 cursor-pointer shadow-md transform scale-105 transition-transform';
            const dot = date.querySelector('div');
            if(dot) dot.className = 'w-1.5 h-1.5 rounded-full bg-[#FDECB1]';
        });
    });
}


// --- Drag and Drop Mock ---

function initDragAndDrop() {
    const dropzone = document.querySelector('.js-dropzone');
    if (!dropzone) return;
    
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-[#4E0000]', 'bg-gray-50');
    });
    
    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-[#4E0000]', 'bg-gray-50');
    });
    
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-[#4E0000]', 'bg-gray-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            updateDropzoneText(dropzone, files[0].name);
        }
    });
    
    dropzone.addEventListener('click', () => {
        // Mock file input click
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = (e) => {
            if (e.target.files.length > 0) {
                updateDropzoneText(dropzone, e.target.files[0].name);
            }
        };
        input.click();
    });
}

function updateDropzoneText(dropzone, filename) {
    const mainText = dropzone.querySelector('p:first-child');
    if (mainText) {
        mainText.textContent = `Selected: ${filename}`;
        mainText.classList.add('text-[#4E0000]', 'font-bold');
        showToast('Image attached', 'success');
    }
}
