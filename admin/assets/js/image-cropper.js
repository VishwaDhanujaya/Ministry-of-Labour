/**
 * Ministry of Labour - Admin Image Cropper Engine
 * Integrates Cropper.js with interactive controls, aspect ratio presets, and canvas compression.
 */

(function () {
    let cropperInstance = null;
    let currentOptions = {};
    let activeFileOriginalName = 'official-photo.jpg';

    // Create modal HTML dynamically if not present
    function initCropperModalHTML() {
        if (document.getElementById('globalCropModal')) return;

        const modalHTML = `
        <div id="globalCropModal" class="fixed inset-0 z-[99999] hidden items-center justify-center p-3 sm:p-5 transition-opacity duration-300 opacity-0 bg-slate-950/70 backdrop-blur-md">
            <div class="absolute inset-0" onclick="window.closeImageCropper()"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl transform scale-95 transition-all duration-300 relative z-10 max-h-[92vh] flex flex-col overflow-hidden border border-slate-200">
                
                <!-- Modal Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b border-slate-100 bg-slate-50/80 shrink-0">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A2.25 2.25 0 019.455 3.5h5.09c.597 0 1.17.237 1.591.657l1.62 1.62c.42.42.657.994.657 1.591v.832m-13.5 0H2.25m3.75 0V18a2.25 2.25 0 002.25 2.25h10.5A2.25 2.25 0 0021 18V8.25m-15 0h15M12 11.25v6m0 0l-2.25-2.25M12 17.25l2.25-2.25"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800 font-montserrat">Crop Profile Photo</h3>
                            <p class="text-[11px] text-slate-400 font-medium">Frame the headshot perfectly before saving</p>
                        </div>
                    </div>
                    <button type="button" onclick="window.closeImageCropper()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition-all focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body (Cropper Container) -->
                <div class="p-4 sm:p-6 overflow-y-auto flex-1 flex flex-col items-center justify-center bg-slate-900/95 relative custom-scrollbar min-h-[300px] max-h-[55vh]">
                    <div class="w-full h-full flex items-center justify-center max-h-[50vh] overflow-hidden rounded-xl">
                        <img id="cropperTargetImage" src="" alt="Crop Source" class="max-w-full max-h-[48vh] block rounded-lg">
                    </div>
                </div>

                <!-- Cropper Toolbar (Ratios & Transforms) -->
                <div class="px-5 py-3.5 bg-slate-50 border-t border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 shrink-0">
                    <!-- Fixed 1:1 Aspect Ratio Badge -->
                    <div class="flex items-center gap-1.5 bg-slate-200/60 px-3 py-1.5 rounded-xl">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        <span class="text-xs font-bold text-slate-700">1:1 Square Ratio</span>
                    </div>

                    <!-- Transform Controls -->
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="window.cropperAction('zoom', 0.1)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-bold transition-all shadow-sm" title="Zoom In">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6"></path></svg>
                        </button>
                        <button type="button" onclick="window.cropperAction('zoom', -0.1)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-bold transition-all shadow-sm" title="Zoom Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM7.5 10.5h6"></path></svg>
                        </button>
                        <div class="w-px h-5 bg-slate-200 mx-1"></div>
                        <button type="button" onclick="window.cropperAction('rotate', -90)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-bold transition-all shadow-sm" title="Rotate Left 90°">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"></path></svg>
                        </button>
                        <button type="button" onclick="window.cropperAction('rotate', 90)" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-bold transition-all shadow-sm" title="Rotate Right 90°">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3"></path></svg>
                        </button>
                        <button type="button" onclick="window.cropperAction('flipX')" class="p-2 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-bold transition-all shadow-sm" title="Flip Horizontal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h18m-7.5-12L18 9m0 0l-4.5 4.5M18 9H3"></path></svg>
                        </button>
                        <div class="w-px h-5 bg-slate-200 mx-1"></div>
                        <button type="button" onclick="window.cropperAction('reset')" class="px-2.5 py-1.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-1" title="Reset View">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path></svg>
                            Reset
                        </button>
                    </div>
                </div>

                <!-- Modal Footer CTA -->
                <div class="p-4 px-6 border-t border-slate-100 flex justify-end gap-3 bg-white shrink-0">
                    <button type="button" onclick="window.closeImageCropper()" class="px-5 py-2.5 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-bold transition-all">Cancel</button>
                    <button type="button" id="applyCropBtn" onclick="window.applyImageCrop()" class="px-6 py-2.5 bg-gradient-to-r from-secondary to-[#721c1c] text-white rounded-xl text-xs font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                        Apply & Save Crop
                    </button>
                </div>
            </div>
        </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    /**
     * Open Cropper Modal
     * @param {File|string} fileOrSrc File object or Image URL
     * @param {Object} options Configuration options
     */
    window.openImageCropper = function (fileOrSrc, options = {}) {
        initCropperModalHTML();

        currentOptions = Object.assign({
            aspectRatio: 1, // Default 1:1 square for headshots
            maxWidth: 1000,
            maxHeight: 1000,
            onCrop: null
        }, options);

        activeFileOriginalName = (fileOrSrc instanceof File) ? fileOrSrc.name : 'official-photo.jpg';

        const imgEl = document.getElementById('cropperTargetImage');
        if (!imgEl) return;

        // Destroy existing cropper if active
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }

        const modal = document.getElementById('globalCropModal');
        const modalBox = modal.querySelector('.bg-white');

        function startCropper(src) {
            imgEl.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');

            // Initialize Cropper.js instance
            cropperInstance = new Cropper(imgEl, {
                aspectRatio: currentOptions.aspectRatio === 0 ? NaN : currentOptions.aspectRatio,
                viewMode: 1,
                autoCropArea: 0.9,
                responsive: true,
                restore: false,
                checkCrossOrigin: false,
                background: true
            });

            // Update aspect ratio pill UI
            updateRatioPillUI(currentOptions.aspectRatio);
        }

        if (fileOrSrc instanceof File) {
            const reader = new FileReader();
            reader.onload = (e) => startCropper(e.target.result);
            reader.readAsDataURL(fileOrSrc);
        } else {
            startCropper(fileOrSrc);
        }
    };

    /**
     * Close Cropper Modal
     */
    window.closeImageCropper = function () {
        const modal = document.getElementById('globalCropModal');
        if (!modal) return;
        const modalBox = modal.querySelector('.bg-white');

        modal.classList.add('opacity-0');
        if (modalBox) {
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');
        }

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
        }, 300);
    };

    /**
     * Change Aspect Ratio
     */
    window.setCropperRatio = function (ratio) {
        if (!cropperInstance) return;
        cropperInstance.setAspectRatio(ratio === 0 ? NaN : ratio);
        updateRatioPillUI(ratio);
    };

    function updateRatioPillUI(ratio) {
        document.querySelectorAll('.crop-ratio-btn').forEach(btn => {
            btn.className = 'crop-ratio-btn px-2.5 py-1 text-xs font-semibold text-slate-600 hover:text-slate-900 rounded-lg transition-all';
        });

        let targetId = 'crop-ratio-1';
        if (ratio === 4 / 3) targetId = 'crop-ratio-4-3';
        else if (ratio === 0) targetId = 'crop-ratio-free';

        const activeBtn = document.getElementById(targetId);
        if (activeBtn) {
            activeBtn.className = 'crop-ratio-btn px-2.5 py-1 text-xs font-bold rounded-lg transition-all bg-white text-slate-800 shadow-sm';
        }
    }

    /**
     * Perform Cropper Actions (Zoom, Rotate, Flip, Reset)
     */
    window.cropperAction = function (action, param) {
        if (!cropperInstance) return;

        switch (action) {
            case 'zoom':
                cropperInstance.zoom(param);
                break;
            case 'rotate':
                cropperInstance.rotate(param);
                break;
            case 'flipX':
                const dataX = cropperInstance.getData();
                cropperInstance.scaleX(dataX.scaleX === -1 ? 1 : -1);
                break;
            case 'reset':
                cropperInstance.reset();
                break;
        }
    };

    /**
     * Apply & Export Cropped Canvas to File / DataURL
     */
    window.applyImageCrop = function () {
        if (!cropperInstance) return;

        const applyBtn = document.getElementById('applyCropBtn');
        if (applyBtn) {
            applyBtn.disabled = true;
            applyBtn.innerHTML = `<svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Exporting...`;
        }

        const canvas = cropperInstance.getCroppedCanvas({
            width: 600,
            height: 600,
            maxWidth: 600,
            maxHeight: 600,
            fillColor: '#ffffff',
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });

        if (!canvas) {
            if (typeof window.showToast === 'function') window.showToast('Failed to crop image canvas.', 'error');
            if (applyBtn) {
                applyBtn.disabled = false;
                applyBtn.innerHTML = 'Apply & Save Crop';
            }
            return;
        }

        canvas.toBlob((blob) => {
            if (!blob) {
                if (typeof window.showToast === 'function') window.showToast('Failed to generate image blob.', 'error');
                return;
            }

            const cleanExt = activeFileOriginalName.endsWith('.webp') ? '.webp' : '.jpg';
            const croppedFileName = activeFileOriginalName.replace(/\.[^/.]+$/, "") + '-cropped' + cleanExt;
            const croppedFile = new File([blob], croppedFileName, { type: 'image/jpeg' });
            const croppedDataUrl = canvas.toDataURL('image/jpeg', 0.8);

            if (typeof currentOptions.onCrop === 'function') {
                currentOptions.onCrop(croppedFile, croppedDataUrl);
            }

            if (applyBtn) {
                applyBtn.disabled = false;
                applyBtn.innerHTML = 'Apply & Save Crop';
            }

            window.closeImageCropper();
            if (typeof window.showToast === 'function') window.showToast('Photo cropped & adjusted!', 'success');
        }, 'image/jpeg', 0.8);
    };
})();
