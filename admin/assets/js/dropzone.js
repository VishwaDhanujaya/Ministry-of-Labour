/**
 * Admin Reusable Drag & Drop Dropzone Enhancer
 * Converts standard file input wrappers into interactive drag & drop upload zones.
 */

document.addEventListener('DOMContentLoaded', () => {
    initGlobalDropzones();
});

function initGlobalDropzones() {
    const dropzoneInputs = document.querySelectorAll('input[type="file"].js-dropzone-input');
    
    dropzoneInputs.forEach(input => {
        const wrapper = input.closest('.js-dropzone-wrapper') || input.parentElement;
        if (!wrapper || wrapper.dataset.dropzoneInit) return;
        wrapper.dataset.dropzoneInit = "true";

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            wrapper.addEventListener(eventName, () => {
                wrapper.classList.add('border-primary', 'bg-primary/5', 'scale-[1.01]');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, () => {
                wrapper.classList.remove('border-primary', 'bg-primary/5', 'scale-[1.01]');
            }, false);
        });

        wrapper.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                input.files = files;
                handleDropzonePreview(input, files[0]);
            }
        });

        input.addEventListener('change', (e) => {
            if (input.files && input.files[0]) {
                handleDropzonePreview(input, input.files[0]);
            }
        });
    });
}

function handleDropzonePreview(input, file) {
    // Size check (max 5MB)
    const maxBytes = 5 * 1024 * 1024;
    if (file.size > maxBytes) {
        if (typeof window.showToast === 'function') {
            window.showToast("Selected file exceeds maximum 5MB limit", "warning");
        }
        input.value = '';
        return;
    }

    const wrapper = input.closest('.js-dropzone-wrapper') || input.parentElement;
    const previewEl = wrapper.querySelector('.js-dropzone-preview');
    const labelEl = wrapper.querySelector('.js-dropzone-label');

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            if (previewEl) {
                previewEl.src = e.target.result;
                previewEl.classList.remove('hidden');
            }
            if (labelEl) {
                labelEl.textContent = `Selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            }
        };
        reader.readAsDataURL(file);
    } else if (file.type === 'application/pdf') {
        if (labelEl) {
            labelEl.textContent = `Selected PDF: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        }
        if (typeof window.showToast === 'function') {
            window.showToast(`Attached PDF document: ${file.name}`, "info");
        }
    }
}

window.initGlobalDropzones = initGlobalDropzones;
